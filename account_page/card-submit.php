<?php
session_start();
require "../common_database.php";

$cc_name = $_POST['cc_name'];
$cc_num = $_POST['cc_num'];
$cc_exp_MM = (int)$_POST['cc_exp_MM'];
$cc_exp_YY = (int)$_POST['cc_exp_YY'];
$cc_addr = $_POST['cc_addr'];
$cc_billing_addr = $_POST['cc_billing_addr'];
$cc_phone = $_POST['cc_phone'];

$year = (int)date("y");
$month = (int)date("m");
$valid = true;
$valid = $valid && $cc_name !== null && preg_match("/^[a-z .\-,']+$/i", $cc_name);
$valid = $valid && $cc_num !== null && preg_match("/^[0-9]{16}$/", $cc_num);
$valid = $valid && (int)$cc_exp_MM > 1 && (int)$cc_exp_MM < 12;
$valid = $valid && ($cc_exp_YY > $year || ($cc_exp_YY === $year && $cc_exp_MM >= $month));
$valid = $valid && $cc_addr && $cc_billing_addr;
$valid = $valid && $cc_phone !== null && preg_match("/^[0-9]{10,}$/", $cc_phone);
$data = [
  "email"=>$_SESSION['email'],
  "cc_name" => $cc_name,
  "cc_num" => $cc_num,
  "cc_exp_MM" => $cc_exp_MM,
  "cc_exp_YY" => $cc_exp_YY,
  "cc_addr" => $cc_addr,
  "cc_billing_addr" => $cc_billing_addr,
  "cc_phone" => $cc_phone
];
$query = "INSERT INTO Credit 
(

email, cc_name, cc_num, cc_exp_MM,
cc_exp_YY, cc_addr, cc_billing_addr, cc_phone
) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
 writeToTable("Credit", ["aes-256-cbc",["cc_num"]], json_encode($data), $query, "sssiisss");
?>
