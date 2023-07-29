<?php
require __DIR__ . '/common_database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$secure_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

$submit = [
    "first_name" => $_POST['firstname'],
    "last_name" => $_POST['lastname'],
    "email" => $_POST['email'],
    "password" => $secure_pass
];

$stmt = "INSERT INTO user_info (first_name, last_name, email, password)
VALUES (?, ?, ?, ?)";

$param = "ssss";
writeToTable("user_info",[],json_encode($submit),$stmt,$param);

?>