<?php
    // On démarre la session
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= stylesheet href= ../../src/css/reserver.css>
    <title>Document</title>
</head>
<body>
    
</body>
</html>
    <?php
    // Connexion à la base de données
    require_once("../config/bdd.php");
    require_once("calculs/calculerDistance.php");
    require_once("calculs/calculerTarif.php");
    
    if (!isset($_SESSION["num"])) {
        $_SESSION["num"] = 0;
    }

    function calculDistanceTotale($connexion){
        $distanceTotale=0;
        for($i = 1 ; $i < $_POST["nbCorrespondances"];$i++){
            $noeudDepart = $_POST["noeudDepart$i"];
            $noeudArrivee =$_POST["noeudArrivee$i"];
            $lig_num = $_POST["numLigne$i"];
            $distanceTotale += calculerDistance($connexion, $noeudDepart, $noeudArrivee, $lig_num);
        }
        return $distanceTotale;
    }
    
    // Insertion reservation
    
    // Temporaire !!!
    $tar_num_tranche = 2;
    
    // Récupération des données du formulaire
    $distance = calculDistanceTotale($connexion);
    $tarif = calculerTarif($connexion, $distance);
    $cli_num = intval($_SESSION["num"]);
    $requete = "
        SELECT MAX(RES_NUM) + 1 AS RES_NUM
        FROM VIK_RESERVATION
    ";
    $resultat = $connexion->query($requete);
    $ligne = $resultat->fetch();
    $res_num = $ligne["RES_NUM"];
    
    // Calcul du nombre de points effectifs et totaux en fonction de la distance on divise par 10 et on arrondit à l'entier inférieur
    $res_nb_points_bonus = floor($distance / 10);

    // Requête insertion
    $sql = "
        INSERT INTO VIK_RESERVATION (CLI_NUM, RES_NUM, TAR_NUM_TRANCHE, RES_DATE, RES_NB_POINTS, RES_PRIX_TOT)
        VALUES ($cli_num, $res_num, $tar_num_tranche, SYSDATE, $res_nb_points_bonus, $res_nb_points_bonus)
    ";

    // Exécution de l'insertion
    $query = $connexion->exec($sql);

    for ($i = 1; $i < intval($_POST["nbCorrespondances"]); $i++) {
        $lig_num = str_pad($_POST["numLigne$i"], 3);
        $noeudDepart = $_POST["noeudDepart$i"];
        $noeudArrivee = $_POST["noeudArrivee$i"];
        $horaire = $_POST["horaire$i"];

        $sql = "
            INSERT INTO VIK_CORRESPONDANCE (LIG_NUM, CLI_NUM, RES_NUM, COM_CODE_INSEE_DEPART, COM_CODE_INSEE_ARRIVEE, CORR_DISTANCE, CORR_HEURE)
            VALUES (
                '$lig_num',
                $cli_num,
                $res_num,
                (
                    SELECT COM_CODE_INSEE
                    FROM VIK_COMMUNE
                    WHERE COM_NOM = '$noeudDepart'
                ),
                (
                    SELECT COM_CODE_INSEE
                    FROM VIK_COMMUNE
                    WHERE COM_NOM = '$noeudArrivee'
                ),
                $distance,
                to_date('$horaire', 'hh24:mi')
            )
        ";
        $query = $connexion->exec($sql);
    }
    
    if ($cli_num != 0) {
        // Mise à jour client points
        // Modification du nombre de points
        $sql = "UPDATE vik_client
                SET cli_nb_points_ec = cli_nb_points_ec + $res_nb_points_bonus, 
                    cli_nb_points_tot = cli_nb_points_tot + $res_nb_points_bonus
                WHERE cli_num = $cli_num";
        
        // Exécution de la requête
        $query = $connexion->exec($sql);
        $connexion->query("commit");
    }
?>  
<div class="reservation-container">
    <h1>Réservation bien effectuée</h1>
    <?php
        // on regarde si la session est ouverte
        if(isset($_SESSION["prenom"])) {
            $prenom = $_SESSION["prenom"];
            $nom = $_SESSION["nom"];
        } else {
            $prenom = "visiteur";
        }

        if($cli_num != 0) {
            echo "<h2>Merci pour votre commande $prenom $nom</h2>";
        } else {
            echo "<p>Merci pour votre commande $prenom</p>";
        }

        echo "<p>Numéro de réservation : $res_num</p>";
    ?>
    <p>Distance totale : <?php echo $distance; ?>km</p>
    <p>Prix total : <?php echo $tarif; ?> &euro;</p>
    <a href="../../src/index.php" class="button">Revenir à l'accueil</a>
</div>