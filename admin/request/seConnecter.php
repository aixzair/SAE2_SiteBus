<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../src/css/connexion.css">
        <title>Se connecter</title>
    </head>

    <body>
    <form action="post_seconnecter.php" method="POST" class="form">
            <h1 class="title">Connexion</h1>
            <hr>
            <!-- mail -->
            <div class="input-container ic1">
              <input type="email" name="courriel" autocomplete="name" class="input" placeholder=" "/>
              <div class="cut cut-short"></div>
              <label for="email" class="placeholder">Email</>
            </div>
            <!-- mot de passe -->
            <div class="input-container ic2">
                <input type="password" name="mdp" autocomplete="name" class="input" placeholder=" "/>
                <div class="cut"></div>
                <label for="motdepasse" class="placeholder">Mot de passe</label>
              </div>
            <button type="submit" class="submit">Valider</button>
            <a href="inscription.php">Pas encore de compte ?</a>
        </form>
       
    </body>
</html>
