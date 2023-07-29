<?php 
require "./common_database.php";

$query = "SELECT * FROM Listings WHERE id BETWEEN 1 AND 5;";



$response = readFromTable($query,[]);
echo $response;

// Separate variables to store each object

// Return the data in JSON format
?>