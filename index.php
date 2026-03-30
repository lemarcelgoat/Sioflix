<?php
require_once 'php/sessionGuard.php';
require_once 'php/bdd.php';

// Films hero (5 derniers)
$hero_films = $bdd->query("SELECT * FROM video ORDER BY id_video DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Films par type
$films  = $bdd->query("SELECT * FROM video WHERE fk_type = 1 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
$series = $bdd->query("SELECT * FROM video WHERE fk_type = 3 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
$animes = $bdd->query("SELECT * FROM video WHERE fk_type = 2 ORDER BY RAND() LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
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

<!-- HEADER -->
<header>
    <div id="logo">
        <a href="index.php"><img src="img/logo.png" alt="logo"></a>
    </div>
    <div id="menu">
        <div id="search">
            <a href="php/search.php">
                <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M21 21L16.65 16.65" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <span style="color:white;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="php/logout.php" style="color:#e50914;font-weight:bold;text-decoration:none;font-size:14px;">Déconnexion</a>
    </div>
</header>

<!-- HERO SLIDER -->
<div id="page_home">

    <?php foreach ($hero_films as $i => $hf): ?>
        <img class="imgFilm <?= $i === 0 ? 'active' : '' ?>"
             src="img/<?= htmlspecialchars($hf['nom_image']) ?>.jpg"
             alt="<?= htmlspecialchars($hf['titre']) ?>"
             onerror="this.onerror=null; this.style.background='#1e1e1e'; this.src=''">
    <?php endforeach; ?>

    <?php foreach ($hero_films as $i => $hf): ?>
        <div class="infofilm <?= $i === 0 ? 'active' : '' ?>">
            <p style="font-size:28px;font-weight:bold;"><?= htmlspecialchars($hf['titre']) ?></p>
            <p><?= substr($hf['date_sortie'], 0, 4) ?></p>
            <a href="<?= htmlspecialchars($hf['bande_annonce']) ?>" target="_blank">
                <button id="watch_button">
                    <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/>
                    </svg>
                    <span>Bande-annonce</span>
                </button>
            </a>
        </div>
    <?php endforeach; ?>

    <button id="previous_button" class="btn">❮</button>
    <button id="next_button" class="btn next">❯</button>

    <a href="#wrapper"><button id="button_more">▼</button></a>

    <div class="carousel-indicators">
        <?php foreach ($hero_films as $i => $hf): ?>
            <span class="indicator <?= $i === 0 ? 'active' : '' ?>" data-slide="<?= $i ?>"></span>
        <?php endforeach; ?>
    </div>

</div>

<!-- CAROUSELS -->
<div id="wrapper">

    <!-- Films -->
    <?php if (!empty($films)): ?>
    <div class="section-container">
        <h2 class="section-title">🎬 Films</h2>
        <div class="carousel-wrapper">
            <button class="nav-btn prev">❮</button>
            <div class="carousel-window">
                <div class="carousel-track">
                    <?php foreach ($films as $f): ?>
                        <img src="img/<?= htmlspecialchars($f['nom_image']) ?>.jpg"
                             alt="<?= htmlspecialchars($f['titre']) ?>"
                             title="<?= htmlspecialchars($f['titre']) ?>"
                             onerror="this.onerror=null; this.style.background='#1e1e1e'; this.src=''"
                             onclick="window.open('<?= htmlspecialchars($f['bande_annonce']) ?>','_blank')"
                             style="cursor:pointer;">
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="nav-btn next">❯</button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Séries -->
    <?php if (!empty($series)): ?>
    <div class="section-container">
        <h2 class="section-title">📺 Séries</h2>
        <div class="carousel-wrapper">
            <button class="nav-btn prev">❮</button>
            <div class="carousel-window">
                <div class="carousel-track">
                    <?php foreach ($series as $s): ?>
                        <img src="img/<?= htmlspecialchars($s['nom_image']) ?>.jpg"
                             alt="<?= htmlspecialchars($s['titre']) ?>"
                             title="<?= htmlspecialchars($s['titre']) ?>"
                             onerror="this.onerror=null; this.style.background='#1e1e1e'; this.src=''"
                             onclick="window.open('<?= htmlspecialchars($s['bande_annonce']) ?>','_blank')"
                             style="cursor:pointer;">
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="nav-btn next">❯</button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Animés -->
    <?php if (!empty($animes)): ?>
    <div class="section-container">
        <h2 class="section-title">⛩ Animés</h2>
        <div class="carousel-wrapper">
            <button class="nav-btn prev">❮</button>
            <div class="carousel-window">
                <div class="carousel-track">
                    <?php foreach ($animes as $a): ?>
                        <img src="img/<?= htmlspecialchars($a['nom_image']) ?>.jpg"
                             alt="<?= htmlspecialchars($a['titre']) ?>"
                             title="<?= htmlspecialchars($a['titre']) ?>"
                             onerror="this.onerror=null; this.style.background='#1e1e1e'; this.src=''"
                             onclick="window.open('<?= htmlspecialchars($a['bande_annonce']) ?>','_blank')"
                             style="cursor:pointer;">
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="nav-btn next">❯</button>
        </div>
    </div>
    <?php endif; ?>

</div>

<footer>
    <p>© 2025 SIOflix. Tous droits réservés.</p>
</footer>

<script src="js/accueil.js"></script>

</body>
</html>
