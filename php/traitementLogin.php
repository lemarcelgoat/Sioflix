<?php
require_once 'bdd.php';

$email   = $_POST['email'];
$password = $_POST['password'];

$stmt = $bdd->prepare("SELECT * FROM user WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['pseudo'] = $user['pseudo'];
    header("Location: ../index.php");
    die();
} else {
    echo "Email ou mot de passe incorrect.";
    die();
}
exit();
?>