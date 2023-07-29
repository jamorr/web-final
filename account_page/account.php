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
$credits_response = readFromTable($credits_q, ["aes-256-cbc", ["cc_num"]]);
$credits_response = json_decode($credits_response, true);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="../styles/home_style.css" />
    <link rel="stylesheet" type="" href="../styles/slides.css" />
    <link rel="stylesheet" type="" href="./styles/account_style.css">
    <title>Account Page</title>
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
      <!-- Print user details  -->
      <div class="user-details">
        <h2 id="user-details">User Details</h2>
        <p id="first-name"><strong>First Name:</strong><?php echo $response['first_name']?></p>
        <p id="last-name"><strong>Last Name:</strong> <?php echo $response['last_name']?></p>
        <p id="email"><strong>Email:</strong><?php echo $email?></p>
      </div>
      <div class="user-details">

        <h1>Payment Info</h1>
        <?php 
        // print cc info
        $better_text = [
          "cc_name" => "Name",
          "cc_num" => "Card Number",
          "cc_exp_MM" => "Expiration Month",
          "cc_exp_YY" => "Expiration Year",
          "cc_addr" => "Address",
          "cc_billing_addr" => "Billing Address",
          "cc_phone" => "Phone Number"
        ];
        foreach ($credits_response as $nul => $card) {
            foreach($card as $key => $value) {
                $edited_val = $value;
                if ($key === "cc_num") {
                    $last_4 = substr($value, -4, 4);
                    $edited_val = "************".$last_4;
                } elseif ($key === "email") {
                    continue;
                }
                ?>
        <p><strong><?php echo $better_text[$key]?></strong>:  <?php echo $edited_val?></p>
                <?php
            }
            echo "<br><br>";
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

              <!-- submit button -->
              <input type="submit" name="submission" value="Submit" />
              </fieldset>

            </form>
            <script src="./scripts/credit.js"></script>
          </div>
        </div>
      </div>
    </main>
    <footer>&copy; nestXchange 2023</footer>
  </body>
</html>
