<?php  
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] = false) {
    header("Location: ../index.html");
}
require "../common_database.php";

$email = $_SESSION['email'];
$query = "SELECT * FROM Login WHERE email = $email;";
$response = readFromTable($query, []);
$credits_q = "SELECT * FROM Credit WHERE email = $email";
$credits_response = readFromTable($query, ["aes-256-cbc", ["cc_num"]]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../styles/home_style.css" />
    <link rel="styleshee" type="" href="../styles/slides.css" />
    <title>Account Page</title>
    <style>
      body {
        -webkit-text-size-adjust: 100%;
        margin: 0;
        padding: 0px;
        display: block;
        font-family: Verdana, sans-serif;
        font-size: 15px;
        line-height: 1.5;
      }
      main {
        display: flex;
        flex-flow: column wrap;
      }
      h1 {
        text-align: center;
        width: 100%;
      }
      .user-details {
        flex: 1;
        max-width: 500px;
        margin: 0 auto;
        border: 1px solid #ccc;
        padding: 20px;
      }
      .user-details p {
        margin: 10px 0;
      }
      .sidebar {
        padding: 20px;
        width: 25%;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16),
          0 2px 10px 0 rgba(0, 0, 0, 0.12);
        height: 100%;
        background-color: #fff;
        position: fixed !important;
        z-index: 1;
        display: block;
        overflow: auto;
      }
      .sidebar-item {
        width: 100%;
        display: block;
        padding: 8px 16px;
        text-align: left;
        border: none;
        white-space: normal;
        float: none;
        outline: 0;
      }
      .sidebar-button {
        -webkit-touch-callout: none;
        user-select: none;
        cursor: pointer;
        vertical-align: middle;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        background-color: inherit;
      }
      .sidebar-button:hover {
        color: #000 !important;
        background-color: #fff !important;
      }
    </style>
  </head>
  <body>
    <header class="main-header">
      <h1>nestXchange</h1>
    </header>

    <main>
      <h1>User Account Details</h1>
      <div class="sidebar">
        <h2>Account Info</h2>
        <button type="button" class="sidebar-button sidebar-item">
          User Details
        </button>
        <br />
        <button type="button" class="sidebar-button sidebar-item">
          Payment Information
        </button>
        <br />
      </div>
      <div class="user-details">
        <h2 id="user-details">User Details</h2>
        <p id="first-name"><strong>First Name:</strong><?php echo $response['first-name']?></p>
        <p id="last-name"><strong>Last Name:</strong> <?php echo $response['last-name']?></p>
        <p id="email"><strong>Email:</strong><?php echo $email?></p>
        <p><strong>Member Since:</strong> July 1, 2023</p>
      </div>
    </main>
    <footer></footer>
  </body>
</html>
