<?php
function getEnvVars()
{
    $f = file("./.env");
    if ($f === null) {
        return null;
    }
    return $f;
}
// Encryption function using OpenSSL
function encryptData($data, $encryption_key)
{
    $cipher_method = 'aes-256-cbc';
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = openssl_random_pseudo_bytes($iv_length);

    $encrypted = openssl_encrypt($data, $cipher_method, $encryption_key, OPENSSL_RAW_DATA, $iv);
    $result = base64_encode($iv . $encrypted);

    return $result;
}
function writeToTable(string $table, array $encrypt, $data)
{
    $table_vars = getEnvVars();
    if (getEnvVars() === null) {
        $table_vars = ["localhost", "agrizzle3", "batman"];
    }
    $conn = new mysqli($table_vars[0], $table_vars[1], $table_vars[1], $table_vars[1]);
    if ($conn->connect_error) {
        echo "Could not connect to server\n";
        die("Connection failed: " . $conn->connect_error);
    }
    $decoded = json_decode($data);
    $key_str = "";
    $val_str = "";
    foreach ($decoded as $key => $value) {
            $key_str .= $key.",";
        if (key_exists($key, $encrypt[1])) {
            $val_str .= "'".encryptData($value, $table_vars[2])."',";
        }else {

            $val_str .= "'".$value."',";
        }
    }
    $conn->query("INSERT INTO $table ( $key_str ) VALUES ( $val_str )");
  
}


?>
