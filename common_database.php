<?php
function getEnvVars()
{
    $f = file("./.env");
    if ($f === null) {
        return null;
    }
    return $f;
}

// $host = "localhost";
// $user = "agrizzle3";
// $pass = "agrizzle3";
// $dbname = "agrizzle3";
function writeToTable(string $table, bool $encrypt, $data)
{
    $table_vars = getEnvVars();
    if (getEnvVars() === null) {
        $table_vars = ["localhost", "agrizzle3"];
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
        $val_str .= "'".$value."',";
    }
    $conn->query("INSERT INTO $table ( $key_str ) VALUES ( $val_str )");
  
}


?>
