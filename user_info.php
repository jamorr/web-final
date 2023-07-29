<?php 
require "./common_database.php";
$conn = initConnection(["localhost", "jmorris116", 78324761]);

// Create the Listings table.
$sql = "CREATE TABLE user_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(200) NOT NULL,
    new INT NOT NULL
);";
if ($conn->query($sql) === true) {
    echo "Table Listings created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}
$conn->close();
$query = "SELECT * FROM user_data";
echo readFromTable($query, []);
?>
