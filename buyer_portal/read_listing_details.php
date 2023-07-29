<?php
// Connect to the database
$host = "localhost";
$user = "jmorris116";
$pass = "jmorris116";
$dbname = "jmorris116";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

// Store the ID.
$id = $_GET['id'];
$sql = "SELECT * FROM Listings WHERE id = {$id}";
$listing = $conn->query($sql)->fetch_assoc();
$conn->close();
?>