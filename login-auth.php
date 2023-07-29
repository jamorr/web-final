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
    $_SESSION['name'] = $response[0]['first_name'];
    if (!isset($_COOKIE[$email])) {
        setcookie($email, json_encode(array()), time()+1000000, "/");
    }
    if (intval($response[0]['new']) === 1) {
        $_SESSION['new'] = true;
        $conn = initConnection(['localhost','agrizzle3', 309]);
        $params = "UPDATE user_info SET new = 0 WHERE email = '$email'";
        $conn->query($params);
        $conn->close();
    }
    else {
        $_SESSION['new'] = false;
    }
    echo "Success";  
} else {
    echo "Incorrect password";
}
?>
