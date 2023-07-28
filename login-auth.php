<?php 
session_start();
require "./common_database.php";
$email = $_POST['email'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);


$query = "SELECT * FROM user_info WHERE email = $email;";
$response = readFromTable($query, []);
// if (!$response) {
//     echo "User not found";
// } elseif ($response['password'] === $pass) {
//     //successful login
//     $_SESSION['auth'] = true;
//     $_SESSION['email'] = $email;
//     if (!isset($_COOKIE['wishlist'])) {
//         setcookie("wishlist", json_encode([]), time()+1000000);
//     }
//     if ($response['new'] === true) {
//         $_SESSION['new'] = true;
//     }
//     else {
//         $_SESSION['new'] = false;
 
//     }
//     header("Location: ./buyer_dash.php");   
// } else {
//     echo "Incorrect password";
// }
?>
