<?php
include 'DbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $email = $data['email'];
    $phoneNumber = $data['phoneNumber'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $nic = $data['nic'];
    $licence = $data['licence'];
    $accountStatus = $data['accountStatus'];
    $availability = $data['availability'];

    $conn = connectDB();
    $stmt = $conn->prepare('INSERT INTO Drivers (Username, Password, Email, PhoneNumber, FirstName, LastName, NIC, Licence, AccountStatus, Availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    // Hash the password before storing it in the database (ensure proper password hashing)
    $hashedPassword = md5('default_password');
    $stmt->bind_param('ssssssssss', $username, $hashedPassword, $email, $phoneNumber, $firstName, $lastName, $nic, $licence, $accountStatus, $availability);
    $stmt->execute();
    $stmt->close();
    closeDB($conn);

    echo json_encode(['success' => true]);
} else {
    echo 'Invalid request method';
}
?>
