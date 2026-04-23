<?php
require_once 'sessionGuard.php';
require_once 'bdd.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
if (!$id) { header('Location: ../index.php'); exit(); }


$stmt = $bdd->prepare("SELECT v.*, t.nom as type_nom FROM video v LEFT JOIN type t ON v.fk_type = t.id_type WHERE v.id_video = ?");
$stmt->execute([$id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$film) { header('Location: ../index.php'); exit(); }

$stmt2 = $bdd->prepare("SELECT a.prenom, a.nom, j.role FROM joue j JOIN acteur a ON j.fk_acteur = a.id_acteur WHERE j.fk_video = ?");
$stmt2->execute([$id]);
$acteurs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$stmt3 = $bdd->prepare("SELECT g.libelle FROM appartient ap JOIN genre g ON ap.fk_genre = g.id_genre WHERE ap.fk_video = ?");
$stmt3->execute([$id]);
$genres = $stmt3->fetchAll(PDO::FETCH_ASSOC);

$stmt4 = $bdd->prepare("SELECT id FROM historique WHERE fk_user = ? AND fk_video = ?");
$stmt4->execute([$_SESSION['user_id'], $id]);
if (!$stmt4->fetch()) {
    $bdd->prepare("INSERT INTO historique (fk_user, fk_video, date_vue) VALUES (?, ?, NOW())")->execute([$_SESSION['user_id'], $id]);
} else {
    $bdd->prepare("UPDATE historique SET date_vue = NOW() WHERE fk_user = ? AND fk_video = ?")->execute([$_SESSION['user_id'], $id]);
}

$stmtFav = $bdd->prepare("SELECT id FROM favoris WHERE fk_user = ? AND fk_video = ?");
$stmtFav->execute([$_SESSION['user_id'], $id]);
$isFavori = (bool)$stmtFav->fetch();

$stmt5 = $bdd->prepare("SELECT * FROM video WHERE fk_type = ? AND id_video != ? ORDER BY RAND() LIMIT 6");
$stmt5->execute([$film['fk_type'], $id]);
$similaires = $stmt5->fetchAll(PDO::FETCH_ASSOC);

$annee  = substr($film['date_sortie'], 0, 4);
$titre   = htmlspecialchars($film['titre']);
$imgV    = !empty($film['img_verticale'])   ? $film['img_verticale']   : 'img/affiches/' . $film['nom_image'] . '.jpg';
$imgH    = !empty($film['img_horizontale']) ? $film['img_horizontale'] : 'img/hero/'     . $film['nom_image'] . '.jpg';
$ba      = htmlspecialchars($film['bande_annonce']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix — <?= $titre ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/stylefilm.css">
</head>
<body>

<!-- HEADER -->
<header>
    <div id="logo"><a href="../index.php"><img src="../img/logo.png" alt="logo"></a></div>
    <div id="menu">
        <a href="search.php" style="color:#fff;text-decoration:none">
            <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <span style="color:white;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="logout.php" style="color:#e50914;font-weight:bold;text-decoration:none;font-size:14px;">Déconnexion</a>
    </div>
</header>

<!-- HERO -->
<div class="film-hero">
    <div class="hero-bg" style="background-image:url('../<?= htmlspecialchars($imgH) ?>')"></div>
    <div class="hero-content">
        <h1><?= $titre ?></h1>
        <div class="hero-meta">
            <span class="badge type"><?= htmlspecialchars($film['type_nom']) ?></span>
            <span class="badge"><?= $annee ?></span>
        </div>
        <?php if (!empty($genres)): ?>
        <div class="genre-list">
            <?php foreach ($genres as $g): ?>
                <span class="genre-tag"><?= htmlspecialchars($g['libelle']) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="hero-actions">
            <a href="<?= $ba ?>" target="_blank" class="btn-watch">▶ Bande-annonce</a>
            <button class="btn-fav <?= $isFavori ? 'active' : '' ?>"
                    id="fav-btn"
                    onclick="toggleFavori(<?= $id ?>)">
                <?= $isFavori ? '♥ Retirer des favoris' : '♡ Ajouter aux favoris' ?>
            </button>
        </div>
    </div>
</div>

<!-- DETAILS + CASTING -->
<div class="film-details">
    <div class="film-poster">
        <img src="../<?= htmlspecialchars($imgV) ?>"
             alt="<?= $titre ?>"
             onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'film-poster-placeholder\'>🎬</div>'">
    </div>
    <div class="film-info">
        <h2>Casting</h2>
        <?php if (!empty($acteurs)): ?>
        <div class="cast-grid">
            <?php foreach ($acteurs as $a): ?>
                <div class="cast-item">
                    <span class="cast-name"><?= htmlspecialchars($a['prenom'] . ' ' . $a['nom']) ?></span>
                    <span class="cast-role"><?= htmlspecialchars($a['role']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p style="color:#555">Aucune information de casting disponible.</p>
        <?php endif; ?>
    </div>
</div>

<!-- LECTEUR VIDEO (YouTube embed si lien YouTube) -->
<div class="video-section">
    <h2>🎬 Bande-annonce</h2>
    <?php
    $videoId = '';
    if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $film['bande_annonce'], $m)) {
        $videoId = $m[1];
    }
    ?>
    <?php if ($videoId): ?>
        <div class="video-wrap">
            <iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($videoId) ?>?rel=0"
                    allowfullscreen loading="lazy"></iframe>
        </div>
    <?php else: ?>
        <div class="no-video">Aucune bande-annonce disponible.</div>
    <?php endif; ?>
</div>

<!-- FILMS SIMILAIRES -->
<?php if (!empty($similaires)): ?>
<div class="similaires-section">
    <h2>Vous aimerez aussi</h2>
    <div class="similaires-grid">
        <?php foreach ($similaires as $s): ?>
            <div class="sim-card" onclick="window.location='film.php?id=<?= $s['id_video'] ?>'">
                <img src="../<?= !empty($s['img_verticale']) ? $s['img_verticale'] : 'img/affiches/'.$s['nom_image'].'.jpg' ?>"
                     alt="<?= htmlspecialchars($s['titre']) ?>"
                     onerror="this.onerror=null;this.src='../placeholder.php?t=<?= urlencode($s['titre']) ?>'">
                <div class="sim-title"><?= htmlspecialchars($s['titre']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<footer><p>© 2025 SIOflix. Tous droits réservés.</p></footer>

<script>
function toggleFavori(id) {
    const btn = document.getElementById('fav-btn');
    fetch('favori_toggle.php?id=' + id)
        .then(r => r.json())
        .then(data => {
            if (data.favori) {
                btn.textContent = '♥ Retirer des favoris';
                btn.classList.add('active');
            } else {
                btn.textContent = '♡ Ajouter aux favoris';
                btn.classList.remove('active');
            }
        });
}
</script>
</body>
</html>
