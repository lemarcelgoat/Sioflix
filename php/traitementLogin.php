<?php
session_start();

require_once 'bdd.php';

$email    = $_POST['email'];
$password = $_POST['password'];

$stmt = $bdd->prepare("SELECT * FROM user WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['pseudo']  = $user['pseudo'];
    header("Location: ../index.php");   
    exit();
} else {
    header("Location: profile.php?error=not_connect");
    exit();
}
?>
