<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion & Inscription</title>
    <link rel="stylesheet" href="../css/styleprofile.css">
</head>
<body>
    <div class="container">
        <div id="logo">
            <a href="home.html"><img src="../img/logo.png" alt="logo" style="width: 100px;"></a>
        </div>

        <div class="tabs">
            <button id="show-login" class="active">Se connecter</button> 
            <button id="show-signup">S'inscrire</button> 
        </div>
      
        <form id="form_Connexion" action="traitementLogin.php" class="auth-form" method="post">
            <h2>Connexion</h2>
            <label for="login-pseudo">Pseudo</label>
            <input type="text" id="login-pseudo" class="input" name="pseudo" required>

            <label for="login-password">Mot de passe</label>
            <input type="password" id="login-password" class="input" name="password" required>

            <div class="actions">
                <input type="submit" value="Se connecter" class="btn-submit">
                <input type="reset" value="Annuler" class="btn-reset">
            </div>
        </form>
            
        <form id="form_Inscri" action="traitementInscri.php" class="auth-form hidden" method="post">
            <h2>Inscription</h2>
            <label for="email">Email</label>
            <input type="email" id="email" class="input" name="email" required>

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" class="input" name="pseudo" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" class="input" name="password" required>

            <label for="confPassword">Confirmer mot de passe</label>
            <input type="password" id="confPassword" class="input" name="confirm_password" required>

            <div class="actions">
                <input type="submit" value="S'inscrire" class="btn-submit">
                <input type="reset" value="Annuler" class="btn-reset">
            </div>
        </form>
    </div>

    <script src="../js/scriptform.js"></script>
</body>
</html>