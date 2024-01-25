<?php

function connectDB() {
    // Replace with your actual database details
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'citytaxi';

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
    
}

function closeDB($conn) {
    $conn->close();
}
 
connectDB();
?>