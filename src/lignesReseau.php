<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Lignes du réseau</title>
        <link rel="stylesheet" href="css/menus.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/admin.css">

        

    </head>
    <body>
        <!-- Barre de navigation -->
        <?php require_once("header.php");?>
        <?php require_once("../admin/config/bdd.php");?>

        <?php require("../admin/request/visualligne.php");?>
        <!-- Pied de page -->
        <footer class="footer">
        <?php require_once("footer.php");?>
</footer>
    </body>
</html>