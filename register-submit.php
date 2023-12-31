<?php
require __DIR__ . '/common_database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// $secure_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

$submit = [
    "first_name" => $_POST['firstname'],
    "last_name" => $_POST['lastname'],
    "email" => $_POST['email'],
    "password" => $_POST['pass'],
    "new" => true
];

$stmt = "INSERT INTO user_info (first_name, last_name, email, password, new)
VALUES (?, ?, ?, ?, ?)";

$param = "ssssi";
writeToTable("user_info", ["aes-256-cbc",["password"]], json_encode($submit), $stmt, $param);

?>
