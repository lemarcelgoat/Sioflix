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
        const q = input.value.trim();
        if (q !== '' || currentType !== '') {
            doSearch(q);
        }
    });
});

input.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    const q = input.value.trim();
    clearBtn.style.display = q ? 'flex' : 'none';

    if (q === '' && currentType === '') {
        resetResults();
        return;
    }
    debounceTimer = setTimeout(() => doSearch(q), 300);
});

clearBtn.addEventListener('click', () => {
    input.value = '';
    clearBtn.style.display = 'none';
    if (currentType === '') {
        resetResults();
    } else {
        doSearch('');
    }
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
        .then(data => {
            loader.classList.add('hidden');
            renderResults(data, q);
        })
        .catch(() => {
            loader.classList.add('hidden');
            grid.innerHTML = '<p style="color:#aaa;text-align:center;padding:40px;grid-column:1/-1">Erreur lors de la recherche.</p>';
        });
}

function renderResults(films, q) {
    if (films.length === 0) {
        countEl.textContent = '';
        noResults.classList.remove('hidden');
        return;
    }

    countEl.textContent = films.length + ' résultat' + (films.length > 1 ? 's' : '');
    noResults.classList.add('hidden');

    films.forEach(film => {
        const card   = document.createElement('div');
        card.className = 'result-card';
        const annee  = film.date_sortie ? film.date_sortie.substring(0, 4) : '';
        const titreHL = q ? highlight(film.titre, q) : escHtml(film.titre);
        const badge  = film.fk_type == 1 ? 'Film' : film.fk_type == 2 ? 'Animé' : film.fk_type == 3 ? 'Série' : '';

        card.innerHTML = `
            <div class="card-img-wrap">
                <img src="../img/${escHtml(film.nom_image)}.jpg"
                     alt="${escHtml(film.titre)}"
                     onerror="this.onerror=null;this.src='../placeholder.php?t=${encodeURIComponent(film.titre)}&y=${annee}'">
                <div class="card-overlay">
                    <a href="${escHtml(film.bande_annonce)}" target="_blank" class="play-btn">▶</a>
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
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function resetResults() {
    grid.innerHTML = '';
    countEl.textContent = '';
    noResults.classList.add('hidden');
    defaultMsg.style.display = 'block';
    clearBtn.style.display = 'none';
}