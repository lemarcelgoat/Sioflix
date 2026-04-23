<?php
require_once 'php/sessionGuard.php';
require_once 'php/bdd.php';

$fk_type  = isset($_GET['type'])  && is_numeric($_GET['type'])  ? (int)$_GET['type']  : null;
$fk_genre = isset($_GET['genre']) && is_numeric($_GET['genre']) ? (int)$_GET['genre'] : null;

$types  = $bdd->query("SELECT * FROM type  ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$genres = $bdd->query("SELECT * FROM genre ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);

// Hero : 5 derniers films, image horizontale
$hero_films = $bdd->query("SELECT * FROM video ORDER BY id_video DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Carousels par type, image verticale
$films  = $bdd->query("SELECT * FROM video WHERE fk_type = 1 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
$series = $bdd->query("SELECT * FROM video WHERE fk_type = 3 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
$animes = $bdd->query("SELECT * FROM video WHERE fk_type = 2 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

// Favoris
$favoris = [];
try {
    $favRow = $bdd->prepare("SELECT fk_video FROM favoris WHERE fk_user = ?");
    $favRow->execute([$_SESSION['user_id']]);
    $favoris = array_column($favRow->fetchAll(PDO::FETCH_ASSOC), 'fk_video');
} catch (Exception $e) {}

// Pagination + grille filtrée
$par_page = 20;
$page     = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset   = ($page - 1) * $par_page;
$videos   = []; $totalPages = 1; $total = 0;

if ($fk_type || $fk_genre) {
    $sql = "SELECT DISTINCT v.* FROM video v";
    $params = [];
    if ($fk_genre) { $sql .= " JOIN appartient a ON v.id_video = a.fk_video"; }
    $sql .= " WHERE 1=1";
    if ($fk_type)  { $sql .= " AND v.fk_type = :type";   $params[':type']  = $fk_type; }
    if ($fk_genre) { $sql .= " AND a.fk_genre = :genre"; $params[':genre'] = $fk_genre; }
    $countSql = str_replace("SELECT DISTINCT v.*", "SELECT COUNT(DISTINCT v.id_video)", $sql);
    $sc = $bdd->prepare($countSql); $sc->execute($params);
    $total = $sc->fetchColumn(); $totalPages = ceil($total / $par_page);
    $sql .= " ORDER BY v.titre LIMIT :limit OFFSET :offset";
    $stmt = $bdd->prepare($sql);
    foreach ($params as $k => $v) $stmt->bindValue($k, $v);
    $stmt->bindValue(':limit', $par_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
    $stmt->execute();
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Helper : chemin image avec fallback
function imgV($film) {
    return !empty($film['img_verticale'])   ? $film['img_verticale']   : 'img/affiches/' . $film['nom_image'] . '.jpg';
}
function imgH($film) {
    return !empty($film['img_horizontale']) ? $film['img_horizontale'] : 'img/hero/'     . $film['nom_image'] . '.jpg';
}
function buildUrl($p) {
    $p = array_filter($p, fn($v) => $v !== null && $v !== '');
    return 'index.php' . ($p ? '?' . http_build_query($p) : '');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div id="logo">
        <a href="index.php"><img src="img/logo.png" alt="logo"></a>
    </div>
    <div id="menu">
        <div id="catalogue_cont" class="catalogue">
            <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <ul id="liste_catalogue">
                <a href="index.php?type=1"><li>Films</li></a>
                <a href="index.php?type=3"><li>Séries</li></a>
                <a href="index.php?type=2"><li>Animés</li></a>
            </ul>
        </div>
        <div id="search">
            <a href="php/search.php">
                <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 21L16.65 16.65" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <div id="profile">
            <a href="php/profile.php">
                <svg width="35px" height="35px" viewBox="0 0 20.00 20.00" fill="#ffffff"><path d="M10 10c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </a>
        </div>
        <span style="color:white;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="php/logout.php" style="color:#e50914;font-weight:bold;text-decoration:none;font-size:14px;">Déconnexion</a>
    </div>
</header>

<?php if (!$fk_type && !$fk_genre): ?>


<div id="page_home" class="home">

    <?php foreach ($hero_films as $i => $hf): ?>
        <img class="imgFilm <?= $i===0?'active':'' ?>"
             src="<?= htmlspecialchars(imgH($hf)) ?>"
             alt="<?= htmlspecialchars($hf['titre']) ?>"
             onerror="this.onerror=null;this.src='placeholder.php?t=<?= urlencode($hf['titre']) ?>&h=1'">
    <?php endforeach; ?>

    <?php foreach ($hero_films as $i => $hf): ?>
        <div class="infofilm <?= $i===0?'active':'' ?>">
            <p style="font-size:32px;font-weight:bold;text-shadow:0 2px 10px rgba(0,0,0,.9);margin-bottom:10px">
                <?= htmlspecialchars($hf['titre']) ?>
            </p>
            <p style="color:#ccc;margin-bottom:16px"><?= substr($hf['date_sortie'],0,4) ?></p>
            <button id="watch_button" onclick="window.location='php/film.php?id=<?= $hf['id_video'] ?>'"
                    style="display:flex;align-items:center;gap:10px;margin-top:20px;padding:12px 24px;background:white;border:none;border-radius:6px;font-size:16px;cursor:pointer;font-family:inherit;font-weight:600">
                <span style="display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:#141414;color:#fff;font-style:italic;font-weight:bold;font-size:16px;flex-shrink:0">i</span>
                <span>Plus d'infos</span>
            </button>
        </div>
    <?php endforeach; ?>

    <button id="previous_button" class="btn">❮</button>
    <button id="next_button"     class="btn next">❯</button>

    <a href="#wrapper"><button id="button_more">▼</button></a>

    <div class="carousel-indicators">
        <?php foreach ($hero_films as $i => $hf): ?>
            <span class="indicator <?= $i===0?'active':'' ?>" data-slide="<?= $i ?>"></span>
        <?php endforeach; ?>
    </div>
</div>

<?php endif; ?>


<div class="filtres-bar">
    <div class="filtre-row">
        <span class="filtre-label">Type :</span>
        <a href="index.php" class="filtre-btn <?= !$fk_type&&!$fk_genre?'actif':'' ?>">Tout</a>
        <?php foreach ($types as $t): ?>
            <a href="<?= buildUrl(['type'=>$t['id_type'],'genre'=>$fk_genre]) ?>"
               class="filtre-btn <?= $fk_type==$t['id_type']?'actif':'' ?>">
               <?= htmlspecialchars($t['nom']) ?></a>
        <?php endforeach; ?>
    </div>
    <div class="filtre-row" style="padding-bottom:10px">
        <span class="filtre-label">Genre :</span>
        <a href="<?= buildUrl(['type'=>$fk_type]) ?>" class="filtre-btn <?= !$fk_genre?'actif':'' ?>">Tous</a>
        <?php foreach ($genres as $g): ?>
            <a href="<?= buildUrl(['type'=>$fk_type,'genre'=>$g['id_genre']]) ?>"
               class="filtre-btn <?= $fk_genre==$g['id_genre']?'actif':'' ?>">
               <?= htmlspecialchars($g['libelle']) ?></a>
        <?php endforeach; ?>
    </div>
</div>

<?php if ($fk_type || $fk_genre): ?>

<section class="catalogue-section">
    <h2>
        <?= $fk_type ? htmlspecialchars(array_column($types,'nom','id_type')[$fk_type]??'') : '' ?>
        <?= $fk_genre ? ' — '.htmlspecialchars(array_column($genres,'libelle','id_genre')[$fk_genre]??'') : '' ?>
        <span style="font-size:14px;color:#888;margin-left:10px"><?= $total ?> titre<?= $total>1?'s':'' ?></span>
    </h2>
    <div class="grid">
        <?php foreach ($videos as $v): ?>
        <div class="card-item" onclick="window.location='php/film.php?id=<?= $v['id_video'] ?>'">
            <button class="fav-star <?= in_array($v['id_video'],$favoris)?'on':'' ?>"
                    onclick="event.stopPropagation();toggleFav(this,<?= $v['id_video'] ?>)"
                    title="Favoris">♥</button>
            <div class="card-img-wrap">
                <img src="<?= htmlspecialchars(imgV($v)) ?>"
                     alt="<?= htmlspecialchars($v['titre']) ?>"
                     onerror="this.onerror=null;this.src='placeholder.php?t=<?= urlencode($v['titre']) ?>'">
                <div class="card-hover-overlay">
                    <span class="btn-play">▶ Voir</span>
                </div>
            </div>
            <div class="card-meta">
                <span class="card-titre"><?= htmlspecialchars($v['titre']) ?></span>
                <span class="card-year"><?= substr($v['date_sortie'],0,4) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if ($totalPages>1): ?>
    <div class="pagination">
        <?php if ($page>1): ?><a href="<?= buildUrl(['type'=>$fk_type,'genre'=>$fk_genre,'page'=>$page-1]) ?>" class="page-btn">❮</a><?php endif; ?>
        <?php for($p=max(1,$page-2);$p<=min($totalPages,$page+2);$p++): ?>
            <a href="<?= buildUrl(['type'=>$fk_type,'genre'=>$fk_genre,'page'=>$p]) ?>" class="page-btn <?= $p==$page?'actif':'' ?>"><?= $p ?></a>
        <?php endfor; ?>
        <?php if ($page<$totalPages): ?><a href="<?= buildUrl(['type'=>$fk_type,'genre'=>$fk_genre,'page'=>$page+1]) ?>" class="page-btn">❯</a><?php endif; ?>
    </div>
    <?php endif; ?>
</section>

<?php else: ?>


<div id="wrapper" class="home">
    <?php foreach ([['🎬 Films',$films],['📺 Séries',$series],['⛩ Animés',$animes]] as [$label,$items]): ?>
    <?php if (!empty($items)): ?>
    <div class="section-container">
        <h2 class="section-title"><?= $label ?></h2>
        <div class="carousel-wrapper">
            <button class="nav-btn prev">❮</button>
            <div class="carousel-window">
                <div class="carousel-track">
                    <?php foreach ($items as $item): ?>
                        <img src="<?= htmlspecialchars(imgV($item)) ?>"
                             alt="<?= htmlspecialchars($item['titre']) ?>"
                             title="<?= htmlspecialchars($item['titre']) ?>"
                             onerror="this.onerror=null;this.src='placeholder.php?t=<?= urlencode($item['titre']) ?>'"
                             onclick="window.location='php/film.php?id=<?= $item['id_video'] ?>'">
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="nav-btn next">❯</button>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<footer>
    <p>© 2025 SIOflix. Tous droits réservés.</p>
</footer>

<script src="js/accueil.js"></script>
</body>
</html>
