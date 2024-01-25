<?php
include 'DbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $email = $data['email'];
    $phoneNumber = $data['phoneNumber'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    // Add other fields as needed

    // Generate a random password
    $autoGeneratedPassword = generateRandomPassword(); // Implement this function

    $conn = connectDB();
    $stmt = $conn->prepare('INSERT INTO Passengers (Username, Password, Email, PhoneNumber, FirstName, LastName) VALUES (?, ?, ?, ?, ?, ?)');

    // Hash the password before storing it in the database (ensure proper password hashing)
    $hashedPassword = md5($autoGeneratedPassword);

    $stmt->bind_param('ssssss', $username, $hashedPassword, $email, $phoneNumber, $firstName, $lastName);
    $stmt->execute();
    $stmt->close();
    closeDB($conn);

    // Send registration confirmation email
    $subject = 'City Taxi Registration Successful';
    $message = "Dear $lastName,\n\n"
        . "Congratulations! Your registration as a passenger on City Taxi was successful.\n"
        . "Your username: $username\n"
        . "Your password: $autoGeneratedPassword\n\n"
        . "Thank you for choosing our service.";

    // Replace 'your_email@example.com' with your actual email address
    $headers = 'From: City Taxi <admin@citytaxi.com>' . "\r\n" .
    			'Reply-To: admin@citytaxi.com' . "\r\n" ;

    // Send email
    mail($email, $subject, $message, $headers);

    echo json_encode(['success' => true]);
} else {
    echo 'Invalid request method';
}

function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
