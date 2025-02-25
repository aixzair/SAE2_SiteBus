
<?php
    // Démarrage de la session
    session_start();

    // Récupération des informations de connexion
    require_once("../admin/config/bdd.php");
    

    try {
        // Configuration des options de PDO
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération des informations du compte client
        $cliNum = $_SESSION["num"];

        // Requête SQL pour récupérer les informations du compte client
        $sql = "SELECT * FROM vik_client LEFT JOIN vik_correspondance USING (cli_num) LEFT JOIN vik_reservation using(res_num, cli_num) WHERE cli_num = $cliNum";

        // Exécution de la requête SQL
        $resultat = $connexion->query($sql);

        // Récupération des données du compte client
        $ligne = $resultat->fetch();

        // Fermeture du curseur
        $resultat->closeCursor();

        // Récupération des informations du compte client
        $nom = $ligne["CLI_NOM"];
        $prenom = $ligne["CLI_PRENOM"];
        $ville = $ligne["CLI_VILLE"];
        $tel = $ligne["CLI_TELEPHONE"];
        $mail = $ligne["CLI_COURRIEL"];
        $nbPointsTot = $ligne["CLI_NB_POINTS_TOT"];
        $nbPointsEc = $ligne["CLI_NB_POINTS_EC"];
        $resNum = $ligne["RES_NUM"];

        if($resNum == null) {
            $resNum = "Vous n'avez pas de réservation en cours";
        }

        if($nbPointsEc == 0) {
            $nbPointsEc = "Vous n'avez pas de points effectifs";
        }

        if($nbPointsTot == 0) {
            $nbPointsTot = "Vous n'avez accumulés aucun points";
        }

        if($tel == null) {
            $tel = "Vous n'avez pas renseigné votre numéro de téléphone";
        }

        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Informations du compte</title>
            <link rel="stylesheet" href="../src/css/admin.css">

            

        </head>
        <body>


            <div class="container">
                <h1>Informations du compte</h1>
                <p><strong>Nom :</strong> <?php echo $nom; ?></p>
                <p><strong>Prénom :</strong> <?php echo $prenom; ?></p>
                <p><strong>Ville :</strong> <?php echo $ville; ?></p>
                <p><strong>Téléphone :</strong> <?php echo $tel; ?></p>
                <p><strong>Mail :</strong> <?php echo $mail; ?></p>
                <p><strong>Nombre de points total :</strong> <?php echo $nbPointsTot; ?></p>
                <p><strong>Nombre de points échangeables :</strong> <?php echo $nbPointsEc; ?></p>
                <button type="button"><a href="../admin/account/modifierCompte.php?num=<?php echo $cliNum ?>">Modifier les informations du compte</a></button>
            </div>
            
        </body>
        </html>

        <?php 
    } catch (PDOException $e) {
        echo "Erreur de requête SQL : " . $e->getMessage();
    }
?>
