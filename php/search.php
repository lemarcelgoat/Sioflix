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
    <div id="logo"><a href="../index.php"><img src="../img/logo.png" alt="logo"></a></div>
    <div id="menu">
        <div id="search_icon">
            <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
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

<script>
const input      = document.getElementById('search-input');
const grid       = document.getElementById('results-grid');
const countEl    = document.getElementById('results-count');
const loader     = document.getElementById('loader');
const noResults  = document.getElementById('no-results');
const defaultMsg = document.getElementById('default-msg');
const clearBtn   = document.getElementById('clear-btn');
const filterBtns = document.querySelectorAll('.filter-btn');

let currentType = '';
let debounceTimer;

filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentType = btn.dataset.type;
        if (input.value.trim() !== '' || currentType !== '') doSearch(input.value.trim());
    });
});

input.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const q = input.value.trim();
    clearBtn.style.display = q ? 'flex' : 'none';
    if (q === '' && currentType === '') { resetResults(); return; }
    debounceTimer = setTimeout(() => doSearch(q), 300);
});

clearBtn.addEventListener('click', () => {
    input.value = '';
    clearBtn.style.display = 'none';
    currentType === '' ? resetResults() : doSearch('');
    input.focus();
});

function doSearch(q) {
    loader.classList.remove('hidden');
    noResults.classList.add('hidden');
    defaultMsg.style.display = 'none';
    grid.innerHTML = '';
    countEl.textContent = '';

    fetch(`search_ajax.php?q=${encodeURIComponent(q)}&type=${encodeURIComponent(currentType)}`)
        .then(r => r.json())
        .then(data => { loader.classList.add('hidden'); renderResults(data, q); })
        .catch(() => { loader.classList.add('hidden'); grid.innerHTML = '<p style="color:#aaa;text-align:center;padding:40px;grid-column:1/-1">Erreur lors de la recherche.</p>'; });
}

function renderResults(films, q) {
    if (films.length === 0) { countEl.textContent = ''; noResults.classList.remove('hidden'); return; }

    countEl.textContent = films.length + ' résultat' + (films.length > 1 ? 's' : '');
    noResults.classList.add('hidden');

    films.forEach(film => {
        const card  = document.createElement('div');
        card.className = 'result-card';
        card.onclick = () => window.location = 'film.php?id=' + film.id_video;

        const annee  = film.date_sortie ? film.date_sortie.substring(0, 4) : '';
        const titreHL = q ? highlight(film.titre, q) : escHtml(film.titre);
        const badge  = film.fk_type == 1 ? 'Film' : film.fk_type == 2 ? 'Animé' : film.fk_type == 3 ? 'Série' : '';

        // Utiliser img_verticale si disponible, sinon fallback
        const imgSrc = film.img_verticale
            ? '../' + escHtml(film.img_verticale)
            : '../img/affiches/' + escHtml(film.nom_image) + '.jpg';

        card.innerHTML = `
            <div class="card-img-wrap">
                <img src="${imgSrc}"
                     alt="${escHtml(film.titre)}"
                     onerror="this.onerror=null;this.src='../placeholder.php?t=${encodeURIComponent(film.titre)}&y=${annee}'">
                <div class="card-overlay">
                    <a href="film.php?id=${film.id_video}" class="play-btn" onclick="event.stopPropagation()">▶</a>
                </div>
                <span class="type-badge">${badge}</span>
            </div>
            <div class="card-meta">
                <span class="card-titre">${titreHL}</span>
                <span class="card-annee">${annee}</span>
            </div>`;
        grid.appendChild(card);
    });
}

function highlight(text, q) {
    const safe  = escHtml(text);
    const safeQ = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    return safe.replace(new RegExp(`(${safeQ})`, 'gi'), '<mark>$1</mark>');
}
function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function resetResults() {
    grid.innerHTML = ''; countEl.textContent = '';
    noResults.classList.add('hidden'); defaultMsg.style.display = 'block';
    clearBtn.style.display = 'none';
}
</script>
</body>
</html>
