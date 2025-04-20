<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "kampus";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Koneksi ke database gagal");
}

?>