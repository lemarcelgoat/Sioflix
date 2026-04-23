<?php
// Si connecté → page profil avec favoris
// Si non connecté → formulaire login/inscription
session_start();

$isConnected = isset($_SESSION['pseudo']) && isset($_SESSION['user_id']);

if ($isConnected) {
    // Charger les données
    require_once 'bdd.php';

    // Favoris
    $favoris = [];
    try {
        $stmt = $bdd->prepare("
            SELECT v.*, f.date_ajout
            FROM favoris f
            JOIN video v ON f.fk_video = v.id_video
            WHERE f.fk_user = ?
            ORDER BY f.date_ajout DESC
        ");
        $stmt->execute([$_SESSION['user_id']]);
        $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}

    // Historique
    $historique = [];
    try {
        $stmt2 = $bdd->prepare("
            SELECT v.*, h.date_vue
            FROM historique h
            JOIN video v ON h.fk_video = v.id_video
            WHERE h.fk_user = ?
            ORDER BY h.date_vue DESC
            LIMIT 10
        ");
        $stmt2->execute([$_SESSION['user_id']]);
        $historique = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIOflix — <?= $isConnected ? 'Mon profil' : 'Connexion' ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/styleprofile.css">
    <?php if ($isConnected): ?>
        <link rel="stylesheet" href="../css/styleprofile2.css">
    <?php endif; ?>
</head>
<body>

<?php if ($isConnected): ?>


<header>
    <div id="logo"><a href="../index.php"><img src="../img/logo.png" alt="logo"></a></div>
    <div id="menu">
        <a href="../php/search.php" style="color:#fff;text-decoration:none">
            <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none">
                <path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21L16.65 16.65" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <span style="color:white;font-size:14px;">👤 <?= htmlspecialchars($_SESSION['pseudo']) ?></span>
        <a href="logout.php" style="color:#e50914;font-weight:bold;text-decoration:none;font-size:14px;">Déconnexion</a>
    </div>
</header>

<!-- Hero profil -->
<div class="profil-hero">
    <div class="avatar">👤</div>
    <div class="profil-info">
        <h1><?= htmlspecialchars($_SESSION['pseudo']) ?></h1>
        <p><?= count($favoris) ?> favori<?= count($favoris)>1?'s':'' ?> · <?= count($historique) ?> film<?= count($historique)>1?'s':'' ?> vus récemment</p>
    </div>
    <a href="logout.php" class="btn-logout-profil">Déconnexion</a>
</div>

<!-- Favoris -->
<div class="section">
    <h2>❤ Mes favoris</h2>
    <?php if (empty($favoris)): ?>
        <p class="empty-msg">Tu n'as pas encore ajouté de favoris. Clique sur ♥ sur un film !</p>
    <?php else: ?>
    <div class="grid-small">
        <?php foreach ($favoris as $f): ?>
        <?php
            $imgSrc = !empty($f['img_verticale']) ? '../'.$f['img_verticale'] : '../img/affiches/'.$f['nom_image'].'.jpg';
        ?>
        <div class="card-fav" onclick="window.location='film.php?id=<?= $f['id_video'] ?>'">
            <img src="<?= htmlspecialchars($imgSrc) ?>"
                 alt="<?= htmlspecialchars($f['titre']) ?>"
                 onerror="this.onerror=null;this.src='../placeholder.php?t=<?= urlencode($f['titre']) ?>'">
            <button class="remove-fav" title="Retirer des favoris"
                    onclick="event.stopPropagation();retirerFavori(this,<?= $f['id_video'] ?>)">✕</button>
            <div class="card-title"><?= htmlspecialchars($f['titre']) ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Historique -->
<div class="section">
    <h2>🕐 Récemment regardés</h2>
    <?php if (empty($historique)): ?>
        <p class="empty-msg">Aucun film regardé pour l'instant.</p>
    <?php else: ?>
    <div class="histo-list">
        <?php foreach ($historique as $h): ?>
        <?php
            $imgSrc = !empty($h['img_verticale']) ? '../'.$h['img_verticale'] : '../img/affiches/'.$h['nom_image'].'.jpg';
            $date   = date('d/m/Y à H:i', strtotime($h['date_vue']));
        ?>
        <div class="histo-item" onclick="window.location='film.php?id=<?= $h['id_video'] ?>'">
            <img src="<?= htmlspecialchars($imgSrc) ?>"
                 alt="<?= htmlspecialchars($h['titre']) ?>"
                 onerror="this.onerror=null;this.src='../placeholder.php?t=<?= urlencode($h['titre']) ?>'">
            <div class="histo-info">
                <div class="histo-titre"><?= htmlspecialchars($h['titre']) ?></div>
                <div class="histo-date">Vu le <?= $date ?></div>
            </div>
            <span class="histo-play">▶</span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<footer><p>© 2025 SIOflix. Tous droits réservés.</p></footer>

<script>
function retirerFavori(btn, id) {
    fetch('favori_toggle.php?id=' + id)
        .then(r => r.json())
        .then(() => {
            const card = btn.closest('.card-fav');
            card.style.transition = 'opacity .3s';
            card.style.opacity = '0';
            setTimeout(() => card.remove(), 300);
        });
}
</script>

<?php else: ?>

<!-- ── PAGE LOGIN (non connecté) ───────────────────────── -->
<div class="container">
    <div id="logo">
        <a href="../index.php"><img src="../img/logo.png" alt="logo" style="width:100px"></a>
    </div>

    <?php if (!empty($_GET['error'])): ?>
    <div class="error-box">
        <span class="error-icon">✕</span>
        <span><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
    <?php endif; ?>

    <div class="tabs">
        <button id="show-login" class="active">Se connecter</button>
        <button id="show-signup">S'inscrire</button>
    </div>

    <form id="form_Connexion" action="traitementLogin.php" class="auth-form" method="post">
        <h2>Connexion</h2>
        <label for="login-email">Email</label>
        <input type="text" id="login-email" class="input" name="email" placeholder="exemple@email.com" required>
        <label for="login-password">Mot de passe</label>
        <input type="password" id="login-password" class="input" name="password" placeholder="Votre mot de passe" required>
        <div class="actions">
            <input type="submit" value="Se connecter" class="btn-submit">
            <input type="reset" value="Annuler" class="btn-reset">
        </div>
    </form>

    <form id="form_Inscri" action="traitementInscri.php" class="auth-form hidden" method="post">
        <h2>Inscription</h2>
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" class="input" name="pseudo" placeholder="Choisissez un pseudo" required>
        <label for="email">Email</label>
        <input type="email" id="email" class="input" name="email" placeholder="exemple@email.com" required>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" class="input" name="password" placeholder="Choisissez un mot de passe" required>
        <label for="confPassword">Confirmer mot de passe</label>
        <input type="password" id="confPassword" class="input" name="confirm_password" placeholder="Confirmez votre mot de passe" required>
        <div class="actions">
            <input type="submit" value="S'inscrire" class="btn-submit">
            <input type="reset" value="Annuler" class="btn-reset">
        </div>
    </form>
</div>
<script src="../js/scriptform.js"></script>

<?php endif; ?>
</body>
</html>
