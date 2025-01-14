<?php
// db.php

$host = 'localhost';
$db = 'MereniSpotreby';
$user = 'root';
$pass = '';

// Vytvoření připojení
$conn = new mysqli($host, $user, $pass, $db);

// Kontrola připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>