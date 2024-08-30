<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "billiard";
//database connection

$db = mysqli_connect($hostname, $username, $password, $database_name);
//create connection

if ($db->connect_error) {
    echo "koneksi database error";
    die("koneksi database error");
}
