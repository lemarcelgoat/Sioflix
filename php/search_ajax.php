<?php
require_once 'bdd.php';

$q    = isset($_GET['q'])    ? trim($_GET['q'])    : '';
$type = isset($_GET['type']) && is_numeric($_GET['type']) ? (int)$_GET['type'] : null;

$sql    = "SELECT v.*, t.nom as type_nom FROM video v LEFT JOIN type t ON v.fk_type = t.id_type WHERE 1=1";
$params = [];

if ($q !== '') {
    $sql .= " AND v.titre LIKE :q";
    $params[':q'] = '%' . $q . '%';
}
if ($type) {
    $sql .= " AND v.fk_type = :type";
    $params[':type'] = $type;
}
$sql .= " ORDER BY v.titre LIMIT 50";

$stmt = $bdd->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
?>
