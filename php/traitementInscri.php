<?php
session_start();

require_once 'bdd.php';

$pseudo   = htmlspecialchars(trim($_POST['pseudo']));
$email    = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];

// Vérification que les mots de passe correspondent
if ($password !== $confirm) {
    header("Location: profile.php?error=Les+mots+de+passe+ne+correspondent+pas");
    exit();
}

// Vérification que l'email n'existe pas déjà
$check = $bdd->prepare("SELECT id FROM user WHERE email = ?");
$check->execute([$email]);
if ($check->fetch()) {
    header("Location: profile.php?error=EU");
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $bdd->prepare("INSERT INTO user (email, pseudo, password) VALUES (?, ?, ?)");
$stmt->execute([$email, $pseudo, $hash]);

// Connexion automatique après inscription
$id = $bdd->lastInsertId();
$_SESSION['user_id'] = $id;
$_SESSION['pseudo']  = $pseudo;

header("Location: accueil.php");
exit();
?>
