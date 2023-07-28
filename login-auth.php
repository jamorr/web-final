<?php 
session_start();
require __DIR__."/common_database.php";
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);


$query = "SELECT * FROM Login WHERE email = $email;";
$response = readFromTable($query, []);
if (!$response) {
    echo "User not found";
} elseif ($response['pass'] === $pass) {
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
    header("Location: ./buyer_dash.php");   
} else {
    echo "Incorrect password";
}
?>
