<?php
require_once 'bdd.php';

$q    = isset($_GET['q'])    ? trim($_GET['q'])    : '';
$type = isset($_GET['type']) && is_numeric($_GET['type']) ? (int)$_GET['type'] : null;

$sql    = "SELECT * FROM video WHERE 1=1";
$params = [];

if ($q !== '') {
    $sql .= " AND titre LIKE :q";
    $params[':q'] = '%' . $q . '%';
}
if ($type) {
    $sql .= " AND fk_type = :type";
    $params[':type'] = $type;
}
$sql .= " ORDER BY titre LIMIT 50";

$stmt = $bdd->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);
?>
