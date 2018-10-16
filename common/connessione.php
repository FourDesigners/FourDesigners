<?php

// Create connection
$conn = new mysqli("localhost", "civic", "sense", "admin_civic");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
