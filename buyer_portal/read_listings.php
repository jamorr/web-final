<?php
// Connect to the database
$host = "localhost";
$user = "agrizzle3";
$pass = "agrizzle3";
$dbname = "agrizzle3";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

// Get the offset and the number of rows to query.
$offset = $_GET['offset'];
$limit = $_GET['limit'];

// Store the search query and additional search conditions if any.
$query = $_GET['query'];
$min_price = $_GET['min_price'];
$max_price = $_GET['max_price'];
$min_bed = $_GET['min_bed'];
$max_bed = $_GET['max_bed'];
$min_bath = $_GET['min_bath'];
$max_bath = $_GET['max_bath'];
$min_floor_area = $_GET['min_floor_area'];
$max_floor_area = $_GET['max_floor_area'];
$min_lot_area = $_GET['min_lot_area'];
$max_lot_area = $_GET['max_lot_area'];

// Create a database query.
$sql = "SELECT * FROM Listings " .

// Include the search query if any.
"WHERE (street_address LIKE '%{$query}%'
OR city LIKE '%{$query}%'
OR state_abbrev LIKE '%{$query}%' 
OR zip LIKE '%{$query}%') " .

// Include additional search conditions if any.
(empty($min_price) ? "" : 
"AND price >= '{$min_price}' ") .
(empty($max_price) ? "" : 
"AND price <= '{$max_price}' ") .
(empty($min_bed) ? "" : 
"AND bedrooms >= '{$min_bed}' ") .
(empty($max_bed) ? "" : 
"AND bedrooms <= '{$max_bed}' ") .
(empty($min_floor_area) ? "" : 
"AND floor_area >= '{$min_floor_area}' ") .
(empty($max_floor_area) ? "" : 
"AND floor_area <= '{$max_floor_area}' ") .
(empty($min_lot_area) ? "" : 
"AND lot_area >= '{$min_lot_area}' ") .
(empty($max_lot_area) ? "" : 
"AND lot_area <= '{$max_lot_area}' ") .

// Include the offset and number of rows.
"LIMIT {$offset}, {$limit}";
$result = $conn->query($sql);
$conn->close();

// Format the data as an array and echo it.
$listings = array();
while ($row = $result->fetch_assoc())
	array_push($listings, $row);
echo json_encode($listings);
?>
