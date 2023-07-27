<?php 
require __DIR__."/common_database.php";
$email = $_POST['email'];
$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); 


$query = "SELECT * FROM Login WHERE email = $email;";
$response = readFromTable($query, []);
if ($response === "") {
    echo "User not found";
} elseif ($response['pass'] === $pass) {
    $_SESSION['auth'] = true;
    $_SESSION['email'] = $email;
    if (!isset($_COOKIE['wishlist'])) {
        setcookie("wishlist", [], 100000);
    }
    if ($response['new'] === true) {
        $_SESSION['new'] = true;
    }
    else {
        $_SESSION['new'] = false;
    }
} else {
    echo "Incorrect password";
}


header("Location: ./buyer_dash.php");

?>
