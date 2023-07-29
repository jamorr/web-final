<?php
// Connect to the database.
$host = "localhost";
$user = "jmorris116";
$pass = "jmorris116";
$dbname = "jmorris116";
$conn = new mysqli($host, $user, $pass, $dbname);

// Check the connection.
if ($conn->connect_error) {
	echo "Could not connect to server\n";
	die("Connection failed: " . $conn->connect_error);
}

// Create the Listings table.
$sql = "CREATE TABLE Listings (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	street_address VARCHAR(50) NOT NULL,
	city VARCHAR(20) NOT NULL,
	state_abbrev VARCHAR(2) NOT NULL,
	zip INT NOT NULL,
	price INT NOT NULL,
	bedrooms INT NOT NULL,
	bathrooms FLOAT NOT NULL,
	floor_area INT NOT NULL,
	lot_area INT NOT NULL,
	year_built INT NOT NULL,
	date_listed DATE NOT NULL)";
if ($conn->query($sql) === TRUE) {
	echo "Table Listings created successfully<br>";
} else {
	echo "Error creating table: " . $conn->error . "<br>";
}

// Add listings to the table.
$listings = array();
array_push($listings, array("1281 Zucchini Cir SE Unit 196", "Atlanta", "GA", 30315, 469583, 3, 3, 0, 0, 2023, "2023-04-06"));
array_push($listings, array("842 Cascade Xing SW", "Atlanta", "GA", 30331, 399999, 5, 3, 2992, 9540, 1997, "2023-06-08"));
array_push($listings, array("3115 Thicket Ln", "Atlanta", "GA", 30349, 552920, 5, 4.5, 3678, 0, 2023, "2023-06-01"));
array_push($listings, array("45 Tuxedo Ter NW", "Atlanta", "GA", 30342, 1595000, 2, 2.5, 2716, 0, 1978, "2023-05-05"));
array_push($listings, array("5120 Powers Ferry Rd", "Atlanta", "GA", 30327, 3145000, 5, 5.5, 0, 41818, 2016, "2023-06-07"));
array_push($listings, array("855 Peachtree St NE Unit 2313", "Atlanta", "GA", 30308, 525000, 2, 2, 1158, 1176, 2007, "2023-07-07"));
array_push($listings, array("4463 Dandelion Ln NE", "Atlanta", "GA", 30342, 507468, 2, 2, 1162, 0, 2023, "2023-07-15"));
array_push($listings, array("1304 Lanier Blvd NE", "Atlanta", "GA", 30306, 980000, 3, 2, 1978, 7052, 1930, "2023-07-25"));
array_push($listings, array("1668 Grace St SE", "Atlanta", "GA", 30316, 535000, 3, 2, 1600, 8712, 1946, "2023-07-25"));
array_push($listings, array("774 Tift Ave SW", "Atlanta", "GA", 30310, 495000, 3, 2, 1716, 5040, 1920, "2023-07-25"));
array_push($listings, array("355 Addington St SW", "Atlanta", "GA", 30310, 325000, 3, 2, 1172, 9540, 1954, "2023-07-25"));
array_push($listings, array("3502 Paces Pl NW", "Atlanta", "GA", 30327, 650000, 3, 3.5, 2113, 0, 1962, "2023-07-25"));
array_push($listings, array("538 Whitlox Rd NW", "Atlanta", "GA", 30318, 799374, 2, 3.5, 2627, 0, 2022, "2022-12-14"));
array_push($listings, array("389 Blackland Rd NW", "Atlanta", "GA", 30342, 10900000, 6, 7.5, 0, 90605, 2022, "2022-09-09"));
array_push($listings, array("421 Blackland Rd NW", "Atlanta", "GA", 30342, 15000000, 7, 8.5, 17300, 63162, 2009, "2023-03-14"));
array_push($listings, array("3450 Ridgewood Rd NW", "Atlanta", "GA", 30327, 7999995, 6, 6.5, 0, 161172, 1998, "2023-03-31"));
array_push($listings, array("5075 Greenpine Dr", "Atlanta", "GA", 30342, 15000000, 5, 6.5, 0, 161172, 2011, "2023-03-17"));
array_push($listings, array("228 Chert Way", "Atlanta", "GA", 30349, 299999, 3, 2, 1525, 11671, 2017, "2023-06-24"));
array_push($listings, array("5569 Grammercy Dr SW", "Atlanta", "GA", 30349, 430900, 5, 3.5, 3718, 16117, 2003, "2023-06-30"));
array_push($listings, array("2465 Hughes Ct SW", "Atlanta", "GA", 30331, 775000, 7, 3.5, 5817, 28314, 2005, "2023-05-01"));
array_push($listings, array("1312 Camelot Dr", "Atlanta", "GA", 30349, 47000, 4, 3, 0, 2180, 1970, "2023-04-06"));
array_push($listings, array("3240 Timber Rdg", "Atlanta", "GA", 30349, 315000, 4, 2.5, 2713, 10019, 2005, "2023-06-08"));
array_push($listings, array("5060 Lake Forrest Dr", "Atlanta", "GA", 30342, 41999999, 6, 7.5, 7994, 38768, 2023, "2023-02-10"));
array_push($listings, array("1174 Kendron Ln", "Atlanta", "GA", 30329, 572925, 4, 3.5, 2280, 0, 2023, "2023-04-05"));
array_push($listings, array("1202 Kendron Ln", "Atlanta", "GA", 30329, 653440, 4, 3.5, 2476, 0, 2023, "2023-05-03"));
array_push($listings, array("4819 Elm Leaf Dr SW", "Atlanta", "GA", 30331, 534449, 5, 3, 3162, 0, 2023, "2023-07-04"));
array_push($listings, array("1690 W Paces Ferry Rd NW", "Atlanta", "GA", 30327, 14900000, 8, 7.5, 22557, 219542, 2006, "2023-03-13"));
array_push($listings, array("854 NW Proctor St", "Atlanta", "GA", 30318, 292000, 2, 1.5, 854, 2178, 2022, "2023-05-05"));
array_push($listings, array("4665 Riverview Rd", "Atlanta", "GA", 30327, 46800000, 7, 8.5, 0, 808038, 1995, "2023-02-05"));
array_push($listings, array("1290 Longreen Ter NW Unit 1", "Atlanta", "GA", 30318, 669786, 3, 2.5, 1853, 0, 2023, "2023-05-24"));

foreach ($listings as $list) {
	$sql = "INSERT INTO Listings (street_address, city, state_abbrev, zip, price, bedrooms, bathrooms, floor_area, lot_area, year_built, date_listed)
		VALUES ('{$list[0]}', '{$list[1]}', '{$list[2]}', '{$list[3]}', '{$list[4]}', '{$list[5]}', '{$list[6]}', '{$list[7]}', '{$list[8]}', '{$list[9]}', '{$list[10]}');";
	if ($conn->query($sql) === TRUE) {
		echo "Data insterted into 'Listings' table successfully.<br>";
	} else {
		echo "Error inserting data into 'Listings': " . $conn->error . "<br>";
	}
}
$conn->close();
?>
