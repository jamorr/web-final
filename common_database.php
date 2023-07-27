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
function encryptData($data, $encryption_key, $cipher_method)
{
    // $cipher_method = 'aes-256-cbc';
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = openssl_random_pseudo_bytes($iv_length);

    $encrypted = openssl_encrypt($data, $cipher_method, $encryption_key, OPENSSL_RAW_DATA, $iv);
    $result = base64_encode($iv . $encrypted);

    return $result;
}

// $encrypt is array who's first value is the encrytion type
// and second is an assoc array whos keys are table columns to encrypt
function writeToTable(string $table, array $encrypt, $data)
{
    try {
        // $table_vars = getEnvVars();
        $table_vars = null;
        if ($table_vars === null) {
            $table_vars = ["localhost", "jmorris116", "batman"];
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
            $key_str .= $key . ",";
            if ($encrypt && !empty($encrypt[1]) && key_exists($key, $encrypt[1])) {
                $val_str .= "'" . encryptData($value, $table_vars[2], $encrypt[0]) . "',";
            } else {
                // Use real_escape_string to avoid SQL injection
                $val_str .= "'" . $conn->real_escape_string($value) . "',"; 
            }
        }
        $key_str = rtrim($key_str, ",");
        $val_str = rtrim($val_str, ",");
        $conn->query("INSERT INTO $table ($key_str) VALUES ($val_str)");  
        $conn->close();
    } catch (Exception $e) {
        // Log the error (optional)
        error_log($e->getMessage());

        // Return an error response to the front-end
        http_response_code(500); // Set the appropriate HTTP status code for the error
        echo json_encode(array('error' => $e->getMessage()));
    }
}


?>
