<?php
// Connect to the database
$host = "localhost";
$user = "agrizzle3";
$pass = "agrizzle3";
$dbname = "agrizzle3";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

// Store the ID.
$id = $_GET['id'];
$sql = "SELECT * FROM Listings WHERE id = {$id}";
$listing = $conn->query($sql)->fetch_assoc();
$conn->close();
?>