<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['pseudo'])) {
    header('Location: php/profile.php?error=Vous+devez+être+connecté+pour+accéder+à+cette+page.');
    exit();
}
?>
