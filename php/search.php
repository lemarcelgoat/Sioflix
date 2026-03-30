<?php
require_once 'sessionGuard.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix — Recherche</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>

<header>
    <div id="logo">
        <a href="../index.php"><img src="../img/logo.png" alt="logo"></a>
    </div>
    <div id="menu">
        <div id="search_icon">
            <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div id="profile">
            <a href="profile.php">
                <svg width="35px" height="35px" viewBox="0 0 20 20" fill="#ffffff"><path d="M10 10c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </a>
        </div>
        <span style="color:white;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="logout.php" style="color:#e50914;font-weight:bold;text-decoration:none;font-size:14px;">Déconnexion</a>
    </div>
</header>

<div id="search-hero">
    <h1>Rechercher un titre</h1>
    <div id="search-bar-wrap">
        <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
            <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M21 21L16.65 16.65" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <input type="text" id="search-input" placeholder="Ex: Spider-Man, Breaking Bad..." autocomplete="off">
        <button id="clear-btn" title="Effacer">✕</button>
    </div>
    <div id="filter-bar">
        <button class="filter-btn active" data-type="">Tout</button>
        <button class="filter-btn" data-type="1">Films</button>
        <button class="filter-btn" data-type="3">Séries</button>
        <button class="filter-btn" data-type="2">Animés</button>
    </div>
</div>

<div id="results-section">
    <div id="results-header">
        <span id="results-count"></span>
        <div id="loader" class="hidden"><div class="spinner"></div></div>
    </div>
    <div id="results-grid"></div>
    <p id="no-results"  class="hidden">Aucun résultat pour cette recherche.</p>
    <p id="default-msg">Commencez à taper pour rechercher...</p>
</div>

<footer><p>© 2025 SIOflix. Tous droits réservés.</p></footer>

<script src="../js/search.js"></script>
</body>
</html>