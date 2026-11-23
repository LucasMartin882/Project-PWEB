<?php
$host = "localhost";
$dbUser = "root";
$dbPassword = "46135";
$dbName = "project_pweb_2026_k2";
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

$option = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try{
  $pdo = new PDO($dsn, $dbUser, $dbPassword, $option);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}