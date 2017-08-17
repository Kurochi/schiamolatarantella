<?php
$database = "tarantella";
$user = "root";
$password = "root";
$host = "localhost";
$port = "3307";

$conn = new mysqli($host, $user, $password, $database, $port);
$conn->set_charset("utf8");

if ($err = $conn->connect_error)
{
    die("Connect Error: $err");
}