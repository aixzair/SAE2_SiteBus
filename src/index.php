<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
        <link rel="stylesheet" href="css/menus.css">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
    
        <!-- Barre de navigation -->
        <?php require_once("header.php");?>
        <h1> Viking Bus </h1>
        <br>

      

        <section>
            <h2>Découvrez notre réseau de bus en Normandie</h2><br>
            <?php 
            require_once("../admin/config/bdd.php");


            if (isset($_SESSION["prenom"]) && isset($_SESSION["nom"])) {
                echo "<p> Bonjour " . $_SESSION["prenom"] . " " . $_SESSION["nom"] . " ! <p><br> ";
            } else {
                echo "<p>Bonjour visiteur !<p><br>";
            }     
        ?>
            <p>Explorez la magnifique région de la Normandie avec notre réseau de bus Viking Bus. Que vous soyez un habitant ou un touriste, nous vous offrons un moyen de transport pratique et confortable pour vous déplacer dans toute la région.</p>
            <br><p>Notre vaste réseau de lignes couvre les principales villes, les sites touristiques et les destinations incontournables de la Normandie. Que vous souhaitiez visiter les célèbres plages du Débarquement, découvrir les charmants villages normands ou explorer les sites historiques, nos bus vous y conduiront en toute simplicité.</p>
            <br><p>Nos chauffeurs expérimentés et courtois vous garantissent un voyage agréable et sécurisé. Nos bus modernes et confortables sont équipés des dernières technologies pour assurer votre confort tout au long du trajet.</p>
            <br><p>Nous proposons des solutions adaptées à tous vos besoins, que vous voyagiez seul, en famille ou en groupe. Nos tarifs abordables et nos options de billetterie flexibles vous permettent de voyager en toute liberté.</p>
            <br><p>Planifiez dès maintenant votre prochaine aventure avec Viking Bus. Consultez nos horaires, nos lignes et réservez votre billet en ligne. Nous sommes impatients de vous accueillir à bord de nos bus pour une expérience de voyage inoubliable en Normandie.</p>
        </section>

        <!-- Pied de page -->
        <footer class="footer">
            <?php require_once("footer.php");?>
        </footer>
    </body>
</html>