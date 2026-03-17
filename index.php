<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div id="logo"><a href="index.php"><img src="img/logo.png" alt="logo"></a></div>
        <div id="menu">
            <div id="catalogue_cont" class="catalogue">
                <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 19V6.2C4 5.0799 4 4.51984 4.21799 4.09202C4.40973 3.71569 4.71569 3.40973 5.09202 3.21799C5.51984 3 6.0799 3 7.2 3H16.8C17.9201 3 18.4802 3 18.908 3.21799C19.2843 3.40973 19.5903 3.71569 19.782 4.09202C20 4.51984 20 5.0799 20 6.2V17H6C4.89543 17 4 17.8954 4 19ZM4 19C4 20.1046 4.89543 21 6 21H20M9 7H15M9 11H15M19 17V21" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <ul id="liste_catalogue">
                    <a href="series.html"><li>Séries</li></a>
                    <a href="film.html"><li>Films</li></a>
                    <a href="EmissionTV.html"><li>Emission TV</li></a>
                    <a href="Animes.html"><li>Animés</li></a>
                </ul>
            </div>
            <div id="search">
                <a href="search.php">
                    <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 21L16.65 16.65" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <div id="profile">
                <a href="profile.php">
                    <svg width="35px" height="35px" viewBox="0 0 20.00 20.00" fill="#ffffff"><path d="M10 10c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </a>
            </div>
        </div>
    </header>

    <div id="page_home" class="home">
        <img class="imgFilm active" src="img/FilmsTOP10/film1/afficheh.jpg" alt="VerybadTrip">
        <img class="imgFilm" src="img/FilmsTOP10/film2/afficheh.jpg" alt="Dune">
        <img class="imgFilm" src="img/FilmsTOP10/film3/afficheh.avif" alt="MissionImpossible7">
        <img class="imgFilm" src="img/FilmsTOP10/film4/afficheh.jpeg" alt="Zootopia2">
        <img class="imgFilm" src="img/FilmsTOP10/film5/afficheh.avif" alt="LaTourMontparnasse">
        
        <button id="previous_button" class="btn">❮</button>
        <button id="next_button" class="btn next">❯</button>
        
        <div class="infofilm active">
            <img id="logoFilm" src="img/FilmsTOP10/film1/logo_film1.png" alt="logo_VeryBadTrip">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis, erat non ultricies dictum massa turpis pulvinar magna.</p>
            <button id="watch_button">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/></svg>
                <span>Regarder</span>    
            </button>
        </div>
        <div class="infofilm">
            <img id="logoFilm" src="img/FilmsTOP10/film2/logo.png" alt="logo_Dune">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis, erat non ultricies dictum massa turpis pulvinar magna.</p>
            <button id="watch_button">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/></svg>
                <span>Regarder</span>    
            </button> 
        </div>
        <div class="infofilm">
            <img id="logoFilm" src="img/FilmsTOP10/film3/logo.png" alt="logo_MissonImpossible7">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis, erat non ultricies dictum massa turpis pulvinar magna.</p>
            <button id="watch_button">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/></svg>
                <span>Regarder</span>    
            </button> 
        </div>
        <div class="infofilm">
            <img id="logoFilm" src="img/FilmsTOP10/film4/logo.png" alt="logo_Zootopia2">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis, erat non ultricies dictum massa turpis pulvinar magna.</p>
            <button id="watch_button">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/></svg>
                <span>Regarder</span>    
            </button>
        </div>
        <div class="infofilm">
            <img id="logoFilm" src="img/FilmsTOP10/film5/logo.png" alt="logo_LaTourMontparnasse">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis, erat non ultricies dictum massa turpis pulvinar magna.</p>
            <button id="watch_button">
                <svg fill="#000000" width="40px" height="40px" viewBox="0 0 56 56" xmlns="http://www.w3.org/2000/svg"><path d="M 27.9999 51.9063 C 41.0546 51.9063 51.9063 41.0781 51.9063 28 C 51.9063 14.9453 41.0312 4.0937 27.9765 4.0937 C 14.8983 4.0937 4.0937 14.9453 4.0937 28 C 4.0937 41.0781 14.9218 51.9063 27.9999 51.9063 Z M 27.9999 47.9219 C 16.9374 47.9219 8.1014 39.0625 8.1014 28 C 8.1014 16.9609 16.9140 8.0781 27.9765 8.0781 C 39.0155 8.0781 47.8983 16.9609 47.9219 28 C 47.9454 39.0625 39.0390 47.9219 27.9999 47.9219 Z M 23.8749 36.6250 L 36.4140 29.2188 C 37.3280 28.6563 37.3046 27.3672 36.4140 26.8516 L 23.8749 19.3984 C 22.9140 18.8359 21.6483 19.2812 21.6483 20.3359 L 21.6483 35.6875 C 21.6483 36.7656 22.8436 37.2344 23.8749 36.6250 Z"/></svg>
                <span>Regarder</span>    
            </button>
        </div>
        <a href="#wrapper">
            <button id="button_more">▼</button>
        </a>
        <div class="carousel-indicators">
            <span class="indicator active" data-slide="0"></span>
            <span class="indicator" data-slide="1"></span>
            <span class="indicator" data-slide="2"></span>
            <span class="indicator" data-slide="3"></span>
            <span class="indicator" data-slide="4"></span>
        </div>
    </div>

    <div id="wrapper" class="home">
        <div class="section-container">
            <h2 class="section-title">TOP 10</h2>
            <div class="carousel-wrapper">
                <button class="nav-btn prev">❮</button>
                <div class="carousel-window">
                    <div id="carroussel_top10" class="carousel-track">
                        <img src="img/FilmsTOP10/film1/affichev.jpg" alt="VerybadTrip" class="Top10_img">
                        <img src="img/FilmsTOP10/film2/affichev.jpg" alt="Dune" class="Top10_img">
                        <img src="img/FilmsTOP10/film3/affichev.jpg" alt="Mission Impossible 7" class="Top10_img">
                        <img src="img/FilmsTOP10/film4/affichev.jpg" alt="Zootopia 2" class="Top10_img">
                        <img src="img/FilmsTOP10/film5/affichev.jpg" alt="La tour Montparnasse" class="Top10_img">
                        <img src="img/FilmsTOP10/film6/affichev.jpg" alt="Le Diner de Cons" class="Top10_img">
                        <img src="img/FilmsTOP10/film7/affichev.jpg" alt="La Haine" class="Top10_img">
                        <img src="img/FilmsTOP10/film8/affichev.webp" alt="Amelie Poulain" class="Top10_img">
                        <img src="img/FilmsTOP10/film9/affichev.jpg" alt="Intouchables" class="Top10_img">
                        <img src="img/FilmsTOP10/film10/affichev.jpg" alt="Casino" class="Top10_img">
                    </div>
                </div>
                <button class="nav-btn next">❯</button>
            </div>
        </div>

        <div class="section-container">
            <h2 class="section-title">Films spécial Noël</h2>
            <div class="carousel-wrapper">
                <button class="nav-btn prev">❮</button>
                <div class="carousel-window">
                    <div id="carrousselNoel" class="carousel-track">
                        <img src="img/FilmsNoel/film1/affichen.jpg" alt="Le Grinch" class="Noel_img">
                        <img src="img/FilmsNoel/film2/affichen.jpg" alt="Maman j'ai raté l'avion" class="Noel_img">
                        <img src="img/FilmsNoel/film3/affichen.jpg" alt="Love Actually" class="Noel_img">
                        <img src="img/FilmsNoel/film4/affichen.jpg" alt="Le Pôle Express" class="Noel_img">
                        <img src="img/FilmsNoel/film5/affichen.jpg" alt="L'étrange Noël de Mr Jack" class="Noel_img">
                        <img src="img/FilmsNoel/film6/affichen.webp" alt="Le Journal de Bridget Jones" class="Noel_img">
                        <img src="img/FilmsNoel/film7/affichen.jpg" alt="Les Chroniques de Noël" class="Noel_img">
                        <img src="img/FilmsNoel/film8/affichen.jpg" alt="Klaus" class="Noel_img">
                        <img src="img/FilmsNoel/film9/affichen.jpg" alt="Elf" class="Noel_img">
                        <img src="img/FilmsNoel/film10/affichen.jpg" alt="Arthur Christmas" class="Noel_img">
                    </div>
                </div>
                <button class="nav-btn next">❯</button>
            </div>
        </div>

        <div class="section-container">
            <h2 class="section-title">Séries à la Une</h2>
            <div class="carousel-wrapper">
                <button class="nav-btn prev">❮</button>
                <div class="carousel-window">
                    <div id="carrousselAlaUne" class="carousel-track">
                        <img src="img/Series/serie1/affichea.jpg" alt="Stranger Things" class="AlaUne_img">
                        <img src="img/Series/serie2/affichea.jpg" alt="The Crown" class="AlaUne_img">
                        <img src="img/Series/serie3/affichea.jpg" alt="The Witcher" class="AlaUne_img">
                        <img src="img/Series/serie4/affichea.jpg" alt="Bridgerton" class="AlaUne_img">
                        <img src="img/Series/serie5/affichea.jpg" alt="Lupin" class="AlaUne_img">
                        <img src="img/Series/serie6/affichea.jpg" alt="Squid Game" class="AlaUne_img">
                        <img src="img/Series/serie7/affichea.jpg" alt="House of the Dragon" class="AlaUne_img">
                        <img src="img/Series/serie8/affichea.jpg" alt="Ozark" class="AlaUne_img">
                        <img src="img/Series/serie9/affichea.jpg" alt="Breaking Bad" class="AlaUne_img">
                        <img src="img/Series/serie10/affichea.jpg" alt="Money Heist" class="AlaUne_img">
                    </div>
                </div>
                <button class="nav-btn next">❯</button>
            </div>
        </div>
    </div>

    <footer>
        <p>© 2024 SIOflix.</p>
    </footer>
    <script src="js/accueil.js"></script>
</body>
</html>