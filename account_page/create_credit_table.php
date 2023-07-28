<?php 
require "../common_database.php";
$conn = initConnection(["localhost", "jmorris116", "batman"]);

// Create the Listings table.
$sql = "CREATE TABLE Credit (
	email VARCHAR(60) PRIMARY KEY,
  cc_name VARCHAR(50) NOT NULL,
  cc_num VARCHAR(16) NOT NULL,
  cc_exp_MM INT NOT NULL,
  cc_exp_YY INT NOT NULL,
  cc_addr VARCHAR(50) NOT NULL,
  cc_billing_addr VARCHAR(50) NOT NULL,
  cc_phone VARCHAR(18) NOT NULL );";

if ($conn->query($sql) === true) {
    echo "Table Listings created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();

?>
