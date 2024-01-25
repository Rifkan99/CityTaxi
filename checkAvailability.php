<?php
include 'DbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $value = $_POST['value'];

    if ($action === 'username') {
        $result = checkUsernameAvailability($value);
    } elseif ($action === 'email') {
        $result = checkEmailAvailability($value);
    } elseif ($action === 'phone') {
        $result = checkPhoneAvailability($value);
    } else {
        $result = false;
    }

    echo json_encode(['available' => $result]);
} else {
    echo 'Invalid request method';
}
/*
function checkUsernameAvailability($username) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT COUNT(*) FROM Drivers WHERE Username = ? UNION ALL SELECT COUNT(*) FROM Passengers WHERE Username = ?');
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    closeDB($conn);

    return $count == 0;
}
*/

function checkUsernameAvailability($username) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT SUM(cnt) as total_count FROM (SELECT COUNT(*) as cnt FROM Drivers WHERE Username = ? UNION ALL SELECT COUNT(*) as cnt FROM Passengers WHERE Username = ?) counts');
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    
    $stmt->bind_result($total_count);
    $stmt->fetch();
 $stmt->close();
    closeDB($conn);
    return $total_count ==0;
}


function checkEmailAvailability($email) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT COUNT(*) FROM Drivers WHERE Email = ? UNION ALL SELECT COUNT(*) FROM Passengers WHERE Email = ?');
    $stmt->bind_param('ss', $email, $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    closeDB($conn);

    return $count == 0;
}

function checkPhoneAvailability($phone) {
    $conn = connectDB();
    $stmt = $conn->prepare('SELECT COUNT(*) FROM Drivers WHERE PhoneNumber = ? UNION ALL SELECT COUNT(*) FROM Passengers WHERE PhoneNumber = ?');
    $stmt->bind_param('ss', $phone, $phone);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    closeDB($conn);

    return $count == 0;
}
?>
