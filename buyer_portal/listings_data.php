<?php
	// Connect to the database
	$host = "localhost";
	$user = "agrizzle3";
	$pass = "agrizzle3";
	$dbname = "agrizzle3";
	$conn = new mysqli($host, $user, $pass, $dbname);
	if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
	
	// Get the range of rows to query.
	$limit = $_GET['limit'];
	$offset = $_GET['offset'];
	
	// Get listing data from the database.
	$sql = "SELECT * FROM Listings limit {$offset}, {$limit}";
	$result = $conn->query($sql);
	$conn->close();
	
	// Format the data as an array and echo it.
	$listings = array();
	while ($row = $result->fetch_assoc()) {
		array_push($listings, $row);
	}	
	echo json_encode($listings);
?>
