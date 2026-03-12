<?php
$host = 'localhost';
$dbname = 'netflix';
$user = 'userdb';
$password = 'linux';

try {
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (Exception $e) {
    die("Erreur de connexion à base de données : " . $e->getMessage());
}
?>
