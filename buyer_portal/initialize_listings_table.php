<?php
	// Connect to the database.
	$host = "localhost";
	$user = "agrizzle3";
	$pass = "agrizzle3";
	$dbname = "agrizzle3";
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
		lot_area INT NOT NULL)";
	if ($conn->query($sql) === TRUE) {
		echo "Table Listings created successfully<br>";
	} else {
		echo "Error creating table: " . $conn->error . "<br>";
	}
	
	// Add listings to the table.
	$listings = array();
	// Listing 1
	// https://www.realtor.com/realestateandhomes-detail/1281-Zucchini-Cir-SE-196_Atlanta_GA_30315_M91183-65961?from=srp-list-card
	array_push($listings, array("1281 Zucchini Cir SE Unit 196", "Atlanta", "GA", 30315, 469583, 3, 3, 0, 0));
	// Listing 2
	// https://www.realtor.com/realestateandhomes-detail/842-Cascade-Xing-SW_Atlanta_GA_30331_M59445-04065?from=srp-list-card
	array_push($listings, array("842 Cascade Xing SW", "Atlanta", "GA", 30331, 399999, 5, 3, 2992, 9540));
	// Listing 3
	// https://www.realtor.com/realestateandhomes-detail/3115-Thicket-Ln_Atlanta_GA_30349_M97384-39956
	array_push($listings, array("3115 Thicket Ln", "Atlanta", "GA", 30349, 552920, 5, 4.5, 3678, 0));
	foreach ($listings as $list) {
		$sql = "INSERT INTO Listings (street_address, city, state_abbrev, zip, price, bedrooms, bathrooms, floor_area, lot_area)
			VALUES ('{$list[0]}', '{$list[1]}', '{$list[2]}', '{$list[3]}', '{$list[4]}', '{$list[5]}', '{$list[6]}', '{$list[7]}', '{$list[8]}');";
		if ($conn->query($sql) === TRUE) {
			echo "Data insterted into 'Listings' table successfully.<br>";
		} else {
			echo "Error inserting data into 'Listings': " . $conn->error . "<br>";
		}
	}
	
	$conn->close();
?>
