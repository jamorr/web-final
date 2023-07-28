<?php
require __DIR__ . '/common_database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "jfassett1";
$pass = "jfassett1";
$dbname = "jfassett1";

$conn = new mysqli($host,$user,$pass,$dbname);
if ($conn->connect_error) {
    echo "Could not connect to server\n";
    die("Connection failed: " . $conn->connect_error);
}

//Function to check passwords are same.

//Function to validate data




//Password hashing
$secure_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
//Preparing SQL statement before executing insert (this prevents SQL injection)
$stmt = $conn->prepare("INSERT INTO user_info (first_name, last_name, email, password)
        VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $_POST['firstname'], $_POST['lastname'], $_POST['email'], $secure_pass);
$stmt->execute();

if ($stmt->error) {
    // If there was an error with the SQL execution, send an error response
    $response = ["success" => false, "error" => $stmt->error];
} else {
    // SQL executed successfully, send a success response
    $response = ["success" => true, "message" => "Registration successful!"];
}

$stmt->close();

echo json_encode($response);
?>