<?php ob_start();

$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "root";
$db['db_name'] = "Articles_Web_App";

foreach($db as $key => $value) { // $key for making characters upper case converting variables to constants
    define(strtoupper($key), $value); // Turns elements into constants with the define() function
}

// Connecting to database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME); // Parameters converted to constants for security reasons

//if($connection) {
//    echo "Connected";
//}

?>