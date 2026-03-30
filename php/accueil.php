<?php
require_once 'sessionGuard.php';
require_once 'bdd.php';

// Récupération des types (Film / Série / Anime)
$types = $bdd->query("SELECT * FROM type ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Filtres GET
$fk_type = isset($_GET['type']) && is_numeric($_GET['type']) ? (int)$_GET['type'] : null;
$search  = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';

// Requête dynamique
$sql    = "SELECT DISTINCT v.* FROM video v WHERE 1=1";
$params = [];

if ($fk_type) {
    $sql .= " AND v.fk_type = :type";
    $params[':type'] = $fk_type;
}
if ($search !== '') {
    $sql .= " AND v.titre LIKE :search";
    $params[':search'] = '%' . $search . '%';
}
$sql .= " ORDER BY v.titre";

$stmt = $bdd->prepare($sql);
$stmt->execute($params);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix</title>
    <link rel="stylesheet" href="../css/styleprofile.css">
</head>
<body>

<?php if (isset($_GET['error'])): ?>
    <div class="error-msg"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-logo">SIOflix</div>

    <form class="nav-search" method="GET" action="accueil.php">
        <?php if ($fk_type) echo '<input type="hidden" name="type" value="' . $fk_type . '">'; ?>
        <input type="text" name="search" placeholder="Rechercher..." value="<?= $search ?>" autocomplete="off">
        <button type="submit">🔍</button>
    </form>

    <div class="nav-user">
        <span>👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="logout.php" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<!-- FILTRES PAR TYPE -->
<section class="filtres">
    <a href="accueil.php<?= $search ? '?search=' . urlencode($search) : '' ?>"
       class="filtre-btn <?= !$fk_type ? 'actif' : '' ?>">Tout</a>
    <?php foreach ($types as $t): ?>
        <a href="accueil.php?type=<?= $t['id_type'] ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
           class="filtre-btn <?= $fk_type == $t['id_type'] ? 'actif' : '' ?>">
            <?= htmlspecialchars($t['nom']) ?>
        </a>
    <?php endforeach; ?>
</section>

<!-- GRILLE FILMS -->
<main class="catalogue">
    <?php if (empty($videos)): ?>
        <p class="no-result">Aucun résultat pour "<?= $search ?>".</p>
    <?php else: ?>
        <?php foreach ($videos as $v): ?>
            <div class="card">
                <div class="card-img-wrap">
                    <img src="../img/<?= htmlspecialchars($v['nom_image']) ?>.jpg"
                         alt="<?= htmlspecialchars($v['titre']) ?>"
                         onerror="this.src='../img/default.jpg'">
                    <div class="card-overlay">
                        <a href="<?= htmlspecialchars($v['bande_annonce']) ?>"
                           target="_blank" class="btn-trailer">▶ Bande-annonce</a>
                    </div>
                </div>
                <div class="card-info">
                    <h3><?= htmlspecialchars($v['titre']) ?></h3>
                    <span class="card-date"><?= substr($v['date_sortie'], 0, 4) ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

</body>
</html>
