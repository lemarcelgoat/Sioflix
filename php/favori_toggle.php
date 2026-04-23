<?php
require_once 'sessionGuard.php';
require_once 'bdd.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id) { echo json_encode(['error' => true]); exit(); }

$stmt = $bdd->prepare("SELECT id FROM favoris WHERE fk_user = ? AND fk_video = ?");
$stmt->execute([$_SESSION['user_id'], $id]);
$exists = $stmt->fetch();

if ($exists) {
    $bdd->prepare("DELETE FROM favoris WHERE fk_user = ? AND fk_video = ?")->execute([$_SESSION['user_id'], $id]);
    echo json_encode(['favori' => false]);
} else {
    $bdd->prepare("INSERT INTO favoris (fk_user, fk_video, date_ajout) VALUES (?, ?, NOW())")->execute([$_SESSION['user_id'], $id]);
    echo json_encode(['favori' => true]);
}
header('Content-Type: application/json');
?>
