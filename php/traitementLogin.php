<?php
session_start();
require_once 'bdd.php';

$pseudo   = $_POST['pseudo'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
$stmt->execute([$pseudo]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['pseudo'] = $user['pseudo'];
    header("Location: accueil.php");
} else {
    echo "Pseudo ou mot de passe incorrect.";
}
exit();
?>