<?php
session_start();
if (!isset($_SESSION['auth']) || $_SESSION['auth'] = false) {
    header("Location: ../index.html");
}
require "../common_database.php";

$email = $_SESSION['email'];
$query = "SELECT * FROM user_info WHERE email = '$email'";
$response = readFromTable($query, []);
$response = json_decode($response, true)[0];

$credits_q = "SELECT * FROM Credit WHERE email = '$email'";
$credits_response = readFromTable($query, ["aes-256-cbc", ["cc_num"]]);
$credits_response = json_decode($response, true);

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
 fieldset {
        display: inline;
      }
      .label-div {
        min-width: 10rem;
        float: left;
        text-align: right;
        padding-right: 2rem;
      }

      #card-logo {
        height: 30px;
        width: 60px;
        background-size: 100% 100%;
        float: right;
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
        <p id="first-name"><strong>First Name:</strong><?php echo $response['first_name']?></p>
        <p id="last-name"><strong>Last Name:</strong> <?php echo $response['last_name']?></p>
        <p id="email"><strong>Email:</strong><?php echo $email?></p>
        <p><strong>Member Since:</strong> </p>
      </div>
      <div class="user-details">
        <?php 
        $better_text = [
          "cc_name" => "Name",
          "cc_num" => "Card Number",
          "cc_exp_MM" => "Expiration Month",
          "cc_exp_YY" => "Expiration Year",
          "cc_addr" => "Address",
          "cc_billing_addr" => "Billing Address",
          "cc_phone" => "Phone Number"
        ];
        foreach ($credits_response as $key => $value) {
            if ($key === "cc_num") {
                $value = "************".substr($value, 12);
            }
            ?>
        <p><strong><?php echo $better_text[$key]?></strong><?echo $value?></p>
            <?php
        }
        ?>
        <button type="button" onclick="showCreditModal();">Add payment info</button>
      </div>
      <div class="modal-wrapper" style="display: none" id="popup">
        <div class="modal" style="height: 600px;">
          <header class="modal-header">

            <h2>Add Credit</h2>
            <span class="exit-x" onclick="hideCreditModal();">&times;</span>
          </header>
          <div class="modal-content" id="credit-add">
              <form action="./card-submit.php" method="post" id="cc-info-form">
                <fieldset id="card-info">
                  <!-- CC Name -->
                  <div class="label-div">Name on card</div>
                  <input
                    type="text"
                    name="cc_name"
                    value=""
                    pattern="^[a-zA-Z .\-,']+$"
                    title="Allowed characters: a-z , ' -"
                  />
                  <!-- CC number -->
                  <br /><br />
                  <div class="label-div">Card number</div>
                  <input
                    type="text"
                    name="cc_num"
                    maxlength="16"
                    value=""
                    id="cc-num-in"
                    pattern="[0-9]{16}"
                    title="Card number must be 16 digits and may not contain non numeric characters"
                  />
                  <!-- CC Expiration -->
                  <br /><br />
                  <div class="label-div">Expiration</div>
                  <input
                    type="text"
                    name="cc_exp_MM"
                    size="2"
                    value=""
                    placeholder="MM"
                    pattern="(0?[1-9]|1[12])"
                    title="Enter a valid month"
                  />
                  /
                  <input
                    type="text"
                    name="cc_exp_YY"
                    size="2"
                    value=""
                    placeholder="YY"
                    pattern="[0-9]{2}"
                  />
                  <div id="card-logo"></div>
              </fieldset>
              <br />
              <fieldset id="personal-info">
                <!-- address -->
                <div class="label-div">Address</div>
                <input type="text" name="cc_addr" value="" id="address" />
                <br /><br />

                <div style="float: right">
                  <input type="checkbox" id="same" />
                  Same as address
                </div>
                <br />
                <div class="label-div">Billing Address</div>

                <input type="text" name="cc_billing_addr" value="" id="cc-billing" />
                <br /><br />
                <!-- phone number  -->
                <div class="label-div">Phone Number</div>
                <input
                  type="tel"
                  name="cc_phone"
                  value=""
                  pattern="[0-9]{10,}"
                  title="Phone number must be at least 10 digits long."
                />
              </fieldset>

              <!-- submit button -->
              <input type="submit" name="submission" value="Submit" />
            </form>
            <script src="./scripts/credit.js"></script>

          </div>
        </div>
          
      </div>
    </main>
    <footer>&copy; nestXchange 2023</footer>
  </body>
</html>
