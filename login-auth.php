<?php 
session_start();
require "./common_database.php";
$email = $_POST['l_email'];
$pass = $_POST['l_pass'];


$query = "SELECT * FROM user_info WHERE email = '$email'";
// $query = "SELECT * FROM user_info";

$response = readFromTable($query, ["aes-256-cbc",["password"]]);

$response = json_decode($response,true);
$outpt = "";
// foreach($response as $key =>$value){
//     $outpt .= "$key = $value";
// }

// echo "\n";
// echo "\n";
// echo $_POST['l_pass'];
// echo "\n\n";
// echo password_verify($_POST["l_pass"],$response['password'])?"success":"failure";

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
    // header("Location: ./buyer_dash.php"); 
    echo "Success";  
} else {
    echo $outpt;
    echo json_encode($response);
    echo "Incorrect password";
    echo $response['password'];
    echo "\n\n";
    echo $pass;
}
?>
