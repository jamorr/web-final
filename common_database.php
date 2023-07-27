<?php
function getEnvVars()
{
    $f = file("./.env");
    if ($f === null) {
        return null;
    }
    return $f;
}


function writeToTable(string $table, bool $encrypt, $data)
{
    $host = "localhost";
    $user = "jfassett1";
    $pass = "jfassett1";
    $dbname = "jfassett1";

    //$table_vars = getEnvVars();
    // $conn = new mysqli($table_vars[0], $table_vars[1], $table_vars[1], $table_vars[1]); 
    $conn = new mysqli($host,$user,$pass,$dbname);
    if ($conn->connect_error) {
        echo "Could not connect to server\n";
        die("Connection failed: " . $conn->connect_error);
    }
    $decoded = json_decode($data);
    $key_str = "(";
    $val_str = "(";
    foreach ($decoded as $key => $value) {
        $key_str .= $key.",";
        $val_str .= "'".$value."',";
    }
    $key_str.=")";
    $val_str.=")";
    $conn->query("INSERT INTO $table $key_str VALUES $val_str");
  
}


?>
