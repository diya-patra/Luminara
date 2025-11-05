<?php
// Luminara CMS Database configuration

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // your MySQL username
define('DB_PASSWORD', '');     // your MySQL password
define('DB_NAME', 'luminara'); // correct database name

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_error) {
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>