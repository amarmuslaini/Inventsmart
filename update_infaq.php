<?php
session_start();
$dbName = $_SESSION["db_name"];
$dbUser = $_SESSION["db_username"];
$dbPass = $_SESSION["db_password"];

$pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST["id"];
$field = $_POST["field"];
$value = $_POST["value"];

$stmt = $pdo->prepare("UPDATE infaq SET $field = ? WHERE no = ?");
$stmt->execute([$value, $id]);
