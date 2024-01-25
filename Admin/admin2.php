<?php
include 'DbConnect.php';

// Check if the user is logged in as an admin (you may need to implement proper authentication)
// For demonstration purposes, I'm assuming a session variable named 'isAdmin'

/*
session_start();
if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
    header('Location: login.php'); // Redirect to login page if not logged in as admin
    exit();
}
*/
$conn = connectDB();

// Retrieve all drivers
$query = 'SELECT * FROM Drivers';
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .activate-btn, .reject-btn {
            padding: 5px 10px;
            cursor: pointer;
        }

        .activate-btn {
            background-color: #4CAF50;
            color: white;
        }

        .reject-btn {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<h2>Admin Page</h2>

<table>
    <tr>
        <th>DriverID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Account Status</th>
        <th>Actions</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['DriverID'] . '</td>';
        echo '<td>' . $row['Username'] . '</td>';
        echo '<td>' . $row['FirstName'] . '</td>';
        echo '<td>' . $row['LastName'] . '</td>';
        echo '<td>' . $row['Email'] . '</td>';
        echo '<td>' . $row['PhoneNumber'] . '</td>';
        echo '<td>' . $row['AccountStatus'] . '</td>';
        echo '<td>';
        echo '<button class="activate-btn" onclick="activateDriver(' . $row['DriverID'] . ')">Activate</button>';
        echo '<button class="reject-btn" onclick="rejectDriver(' . $row['DriverID'] . ')">Reject</button>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
</table>

<script>
     function activateDriver(driverID) {
        // Implement the logic to update the driver's account status to 'ACTIVE'

        // Use AJAX or fetch API to send a request to the server to update the status and send an email
        fetch('activateDriver.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ driverID: driverID }),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the server response if needed
            console.log(data);
            // Reload the page or update the UI as needed
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }


    function rejectDriver(driverID) {
        // Implement the logic to reject the driver's account
        // Use AJAX or fetch API to send a request to the server to update the status and send a rejection email
        fetch('rejectDriver.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ driverID: driverID }),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the server response if needed
            console.log(data);
            // Reload the page or update the UI as needed
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
