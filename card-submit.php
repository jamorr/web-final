<?php
require "./common_database.php";

$cc_name = $_POST['cc-name'];
$cc_num = $_POST['cc-num'];
$cc_exp_MM = (int)$_POST['cc-exp-MM'];
$cc_exp_YY = (int)$_POST['cc-exp-YY'];
$cc_addr = $_POST['cc-addr'];
if ($_POST['same-addr']) {
    $_POST['cc-billing-addr'] = $_POST['cc-addr'];
}
$cc_billing_addr = $_POST['cc-billing-addr'];
$cc_phone = $_POST['cc-phone'];

$year = (int)date("y");
$month = (int)date("m");
$valid = true;
$valid = $valid && $cc_name !== null && preg_match("/^[a-z .\-,']+$/i", $cc_name);
$valid = $valid && $cc_num !== null && preg_match("/^[0-9]{16}$/", $cc_num);
$valid = $valid && (int)$cc_exp_MM > 1 && (int)$cc_exp_MM < 12;
$valid = $valid && ( $cc_exp_YY > $year || ($cc_exp_YY === $year && $cc_exp_MM > $month));
$valid = $valid && $cc_addr && $cc_billing_addr;
$valid = $valid && $cc_phone !== null && preg_match("/^[0-9]{10,}$/", $cc_phone);
$valid && writeToTable("credit", ["aes-256-abc", ["cc-num"]], json_encode($_POST));

?>
