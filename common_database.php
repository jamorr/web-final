<?php
function getEnvVars()
{
    $f = file(".env");
    if ($f === null) {
        return null;
    }
    return $f;
}
// Encryption function using OpenSSL
function encryptData($data, $encryption_key, $cipher_method)
{
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = openssl_random_pseudo_bytes($iv_length);

    $encrypted = openssl_encrypt($data, $cipher_method, $encryption_key, OPENSSL_RAW_DATA, $iv);
    $result = base64_encode($iv . $encrypted);

    return $result;
}
function decryptData($encrypted_data, $encryption_key, $cipher_method)
{

    $data = base64_decode($encrypted_data);
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);

    $decrypted = openssl_decrypt($encrypted, $cipher_method, $encryption_key, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

function initConnection($table_vars)
{
    //file_put_contents("./db.log", print_r(getEnvVars(), true));
    $conn = new mysqli($table_vars[0], $table_vars[1], $table_vars[1], $table_vars[1]);
    if ($conn->connect_error) {
        echo "Could not connect to server\n";
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

    // $encrypt is array who's first value is the encrytion type
    // and second is an assoc array whos keys are table columns to encrypt
function writeToTable(string $table, array $encrypt, $data, $bind, $param_types)
{
    try {
        $table_vars = null;
        if ($table_vars === null) {
            $table_vars = ["localhost", "jfassett1", 78324761];
        }

        $conn = initConnection($table_vars);
        $decoded = json_decode($data);

        $value_array = [];
        $key_str = "";
        $val_str = "";
        foreach ($decoded as $key => $value) {
            $key_str .= $key . ",";
            if ($encrypt && in_array($key, $encrypt[1])) {
                array_push($value_array, encryptData($value, $table_vars[2], $encrypt[0]));
            } else {
                // Use real_escape_string to avoid SQL injection
                array_push($value_array, $value); 
            }
        }
        
        $key_str = rtrim($key_str, ",");
        $val_str = rtrim($val_str, ",");

        $stmt = $conn->prepare($bind);  
        $stmt->bind_param($param_types, ...$value_array);
        $stmt->execute();
        if ($stmt->error) {
            // If there was an error with the SQL execution, send an error response
            $response = ["success" => false, "error" => $stmt->error];
        } else {
            // SQL executed successfully, send a success response
            $response = ["success" => true, "message" => "Registration successful!"];
        }
        $conn->close();
        echo json_encode($response);



    } catch (Exception $e) {
        // Log the error (optional)
        error_log($e->getMessage());

        // Return an error response to the front-end
        http_response_code(500); // Set the appropriate HTTP status code for the error
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function readFromTable(string $query, array $encrypted)
{
    try {
        // file_put_contents("./db.log", print_r(getEnvVars(), true));
    
        // $table_vars = getEnvVars();
        $table_vars = null;
        if ($table_vars === null) {
            $table_vars = ["localhost", "agrizzle3", 78324761];
        }
        $conn = initConnection($table_vars);
        $data = $conn->query($query);
        $output = [];
        while ($row = $data->fetch_assoc()) {
            foreach ($encrypted[1] as $key => $value) {
                $row[$value] = decryptData($row[$value], $table_vars[2], $encrypted[0]);
            }
            array_push($output, $row);
        }
        $conn->close();
        // return $output['password'];
        return json_encode($output);
    } catch (Exception $e) {
        // Log the error (optional)
        error_log($e->getMessage());

        // Return an error response to the front-end
        http_response_code(510); // Set the appropriate HTTP status code for the error
        echo json_encode(array('error' => $e->getMessage()));
    }

}
?>
