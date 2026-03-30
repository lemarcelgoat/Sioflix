const catalogue  = document.querySelector("#catalogue_cont");
const btnmore    = document.querySelector("#button_more");
const buttons    = document.querySelectorAll(".btn");
const slides     = document.querySelectorAll(".imgFilm");
const infos      = document.querySelectorAll(".infofilm");
const indicators = document.querySelectorAll(".indicator");

// ── Catalogue dropdown (optionnel) ───────────────────────────
if (catalogue) {
    catalogue.addEventListener("click", affichercatalogue);
}

function affichercatalogue() {
    const liste = document.querySelector("#liste_catalogue");
    if (!liste) return;
    liste.style.display = liste.style.display === "block" ? "none" : "block";
}

// ── Bouton "voir plus" → affiche #wrapper ────────────────────
if (btnmore) {
    btnmore.addEventListener("click", afficherWrapper);
}

function afficherWrapper() {
    const wrapper = document.querySelector("#wrapper");
    if (wrapper) wrapper.style.display = "flex";
}

// ── Indicateurs hero ─────────────────────────────────────────
function updateIndicators(index) {
    indicators.forEach((ind, i) => {
        ind.classList.toggle("active", i === index);
    });
}

function goToSlide(index) {
    const currentSlide = document.querySelector(".imgFilm.active");
    const currentInfo  = document.querySelector(".infofilm.active");
    if (currentSlide) currentSlide.classList.remove("active");
    if (currentInfo)  currentInfo.classList.remove("active");
    if (slides[index]) slides[index].classList.add("active");
    if (infos[index])  infos[index].classList.add("active");
    updateIndicators(index);
}

indicators.forEach((indicator, index) => {
    indicator.addEventListener("click", () => goToSlide(index));
});

// ── Boutons prev/next hero slider ────────────────────────────
buttons.forEach((button) => {
    button.addEventListener("click", GrandCar);
});

function GrandCar(e) {
    const calcNextSlide = e.target.classList.contains("next") ? 1 : -1;
    const slideActive   = document.querySelector(".imgFilm.active");
    const infoActive    = document.querySelector(".infofilm.active");

    if (!slideActive || !infoActive) return;

    let newIndex = calcNextSlide + [...slides].indexOf(slideActive);
    if (newIndex < 0) newIndex = slides.length - 1;
    if (newIndex >= slides.length) newIndex = 0;

    slides[newIndex].classList.add("active");
    slideActive.classList.remove("active");

    let newIndexInfo = calcNextSlide + [...infos].indexOf(infoActive);
    if (newIndexInfo < 0) newIndexInfo = infos.length - 1;
    if (newIndexInfo >= infos.length) newIndexInfo = 0;

    infos[newIndexInfo].classList.add("active");
    infoActive.classList.remove("active");

    updateIndicators(newIndex);
}

// ── Carousels sections ────────────────────────────────────────
document.querySelectorAll(".carousel-wrapper").forEach((wrapper) => {
    const track   = wrapper.querySelector(".carousel-track");
    const nextBtn = wrapper.querySelector(".next");
    const prevBtn = wrapper.querySelector(".prev");

    if (!track || !nextBtn || !prevBtn) return;

    let currentPosition = 0;

    nextBtn.addEventListener("click", fctSuivant);
    function fctSuivant() {
        const firstImg = track.querySelector("img");
        if (!firstImg) return;
        const itemWidth   = firstImg.offsetWidth + 15;
        const visibleItems = window.innerWidth < 768 ? 2 : 5;
        const maxScroll   = track.children.length - visibleItems;

        if (currentPosition < maxScroll) {
            currentPosition += visibleItems;
            if (currentPosition > maxScroll) currentPosition = maxScroll;
        } else {
            currentPosition = 0;
        }
        track.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
    }

    prevBtn.addEventListener("click", fctPrecedent);
    function fctPrecedent() {
        const firstImg = track.querySelector("img");
        if (!firstImg) return;
        const itemWidth    = firstImg.offsetWidth + 15;
        const visibleItems = window.innerWidth < 768 ? 2 : 5;

        if (currentPosition > 0) {
            currentPosition -= visibleItems;
            if (currentPosition < 0) currentPosition = 0;
        } else {
            const maxScroll = track.children.length - visibleItems;
            currentPosition = maxScroll;
        }
        track.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
    }
});