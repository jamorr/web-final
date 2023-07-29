<?php 
session_start();
require "./common_database.php";
$email = $_POST['l_email'];
$pass = $_POST['l_pass'];


$query = "SELECT * FROM user_info WHERE email = '$email'";
$response = readFromTable($query, ["aes-256-cbc",["password"]]);

$response = json_decode($response, true);

if (!$response) {
    echo "User not found";
} elseif ($response[0]['password'] === $pass) {
    //successful login
    $_SESSION['auth'] = true;
    $_SESSION['email'] = $email;
    if (!isset($_COOKIE['wishlist'])) {
        setcookie("wishlist", json_encode([]), time()+1000000);
    }
    if ($response['new'] === true) {
        $_SESSION['new'] = true;
    }
    else {
        $_SESSION['new'] = false;
    }
    echo "Success";  
} else {
    echo "Incorrect password";
}
?>
