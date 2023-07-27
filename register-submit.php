<?php
require __DIR__ . '/common_database.php';

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




//Password encryption
$secure_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);
$hash = "nutsack";

//Preparing SQL statement before executing insert (this prevents SQL injection)
$stmt = $conn->prepare("INSERT INTO user_info (first_name, last_name, email, password,)
        VALUES (?, ?, ?, ?, ? )");
print_r($_POST);
$stmt-> bind_param("sssss", $_POST['firstname'],$_POST['lastname'], $_POST['email'], $secure_pass);
$stmt ->execute();
var_dump($stmt->error);
$stmt ->close();
echo "Input succesfull!"


?>