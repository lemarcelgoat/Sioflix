<?php
require_once 'bdd.php';


$email    = $_POST['email'];
$pseudo   = $_POST['pseudo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO utilisateurs (email, pseudo, password) VALUES (?, ?, ?)");
$stmt->execute([$email, $pseudo, $password]);



header("Location: home.php");
exit();
?>