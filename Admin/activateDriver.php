<?php
include '../DbConnect.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract data from the request
    $driverID = $data['driverID'];

    // Update the driver's account status to 'ACTIVE' in the database
    $conn = connectDB();
    $password = generateRandomPassword();
    $hashedPassword = md5($password);
    $updateQuery = "UPDATE Drivers SET AccountStatus = 'ACTIVE', Password = '$hashedPassword' WHERE DriverID = $driverID";
    $conn->query($updateQuery);

    // Retrieve the driver's username, Last Name and email
    $selectQuery = "SELECT Username, Email, LastName FROM Drivers WHERE DriverID = $driverID";
    $result = $conn->query($selectQuery);
    $row = $result->fetch_assoc();
    $username = $row['Username'];
    $email = $row['Email'];
	$lastName = $row['LastName'];
    closeDB($conn);

    
    // Send an email to the driver with the username and randomly generated password
    $to = $email;
    $subject = 'Your CityTaxi Account has been Activated';
    $message = "Dear $lastName,\nYour City Taxi driver account has been activated.\n\nUsername: $username\nPassword: $password\n\nPlease keep your login credentials secure.";

    // Additional headers
    $headers = 'From: City Taxi <admin@citytaxi.com>' . "\r\n" .
               'Reply-To: admin@citytaxi.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Use the mail() function to send the email
    mail($to, $subject, $message, $headers);


    // Prepare the response
    $response = array('success' => true, 'message' => 'Driver account activated successfully. Email sent.');
    echo json_encode($response);
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}

// Function to generate a random password
function generateRandomPassword() {
    $length = 8;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

?>
