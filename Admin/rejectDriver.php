<?php
include '../DbConnect.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract data from the request
    $driverID = $data['driverID'];

    // Update the driver's account status to 'REJECTED' in the database
    $conn = connectDB();

    $updateQuery = "UPDATE Drivers SET AccountStatus = 'REJECTED' WHERE DriverID = $driverID";
    $conn->query($updateQuery);

    // Retrieve the driver's username and email
    $selectQuery = "SELECT Username, Email, LastName FROM Drivers WHERE DriverID = $driverID";
    $result = $conn->query($selectQuery);
    $row = $result->fetch_assoc();
    $username = $row['Username'];
    $email = $row['Email'];
	$lastName = $row['LastName'];

    closeDB($conn);

    // Send a rejection email to the driver
    $to = $email;
    $subject = 'City Taxi Driver Account Rejected';
    $message = "Dear $lastName,\n\nWe regret to inform you that your City Taxi driver account has been rejected.\n\nIf you have any further inquiries, please contact our support team.";

    // Additional headers
    $headers = 'From: City Taxi <admin@citytaxi.com>' . "\r\n" .
               'Reply-To: admin@citytaxi.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Use the mail() function to send the email
    mail($to, $subject, $message, $headers);

    // Prepare the response
    $response = array('success' => true, 'message' => 'Driver account rejected successfully. Rejection email sent.');
    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}
?>
