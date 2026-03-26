<?php
require_once 'bdd.php';


$email    = $_POST['email'];
$pseudo   = htmlspecialchars($_POST['pseudo']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $bdd->prepare("INSERT INTO user (email, pseudo, password) VALUES (?, ?, ?)");
$stmt->execute([$email, $pseudo, $password]);



header("Location: ./index.php");
exit();
?>