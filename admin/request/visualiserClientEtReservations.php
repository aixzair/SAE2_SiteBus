<pre>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <title>Document</title>
</head>
<body>

<?php
    // Visualisation des clients
    require_once("../config/bdd.php");

    $num = isset($_GET['num']) ? $_GET['num'] : "";

    // Requête SQL
    $sql = "select cli_num ,typ_num, dep_num, cli_nom, cli_prenom, cli_ville, cli_telephone, cli_courriel, cli_nb_points_ec, cli_nb_points_tot, cli_date_connec, cli_mdp, cli_est_admin, res_date, lig_num, corr_distance, corr_heure from vik_client
    join vik_reservation using (cli_num)
    join vik_correspondance using (cli_num)
    WHERE cli_num = $num";
    
    $req = $connexion->query($sql);
    /*foreach ($res as $ligne) {
        echo "Numéro client : " . $ligne["CLI_NUM"] . ", " . "Type de client : " . $ligne["TYP_NUM"] . ", " . "Numéro de département : ". $ligne["DEP_NUM"] . ", " . "Nom du client : " . $ligne["CLI_NOM"] .  ", " . "Prenom du client : " . $ligne["CLI_PRENOM"] . ", " . "Ville du client : " . $ligne["CLI_VILLE"] . ", " . "Téléphone du client : " . $ligne["CLI_TELEPHONE"] . ", " . "Mail du client : " . $ligne["CLI_COURRIEL"] . ", " . "Points effectif du client : " . $ligne["CLI_NB_POINTS_EC"] . ", " . "Points total du client : " . $ligne["CLI_NB_POINTS_TOT"] . ", " . "date de connexion du client : " . $ligne["CLI_DATE_CONNEC"] . ", " . "Mot de passe du client : " . $ligne["CLI_MDP"] . ", " . "Prenom du clien : " . $ligne["CLI_EST_ADMIN"] . ", " . "Date de reservation : " . $ligne["RES_DATE"] . ", " . "NUméro de la ligne : " . $ligne["LIG_NUM"] . ", " . "Distance de la correspondance : " . $ligne["CORR_DISTANCE"] . ", " . "Heure de la correspondance : " . $ligne["CORR_HEURE"] . "<br>";
    }*/ 
    echo "<table class='tab'>";
    echo "<thead>";
    echo "<tr class='row header'>";
    echo "<th class='cell'>Numéro de client</th>";
    echo "<th class='cell'>Type</th>";
    echo "<th class='cell'>Département</th>";
    echo "<th class='cell'>Nom</th>";
    echo "<th class='cell'>Prénom</th>";
    echo "<th class='cell'>Ville</th>";
    echo "<th class='cell'>Téléphone</th>";
    echo "<th class='cell'>Mail</th>";
    echo "<th class='cell'>Points effectif</th>";
    echo "<th class='cell'>Points total</th>";
    echo "<th class='cell'>Date de connexion</th>";
    echo "<th class='cell'>Administrateur</th>";
    echo "<th class='cell'>Reservation date</th>";
    echo "<th class='cell'>Numéro de ligne</th>";
    echo "<th class='cell'>Distance de la correspondance</th>";
    echo "<th class='cell'>Heure de la correspondance</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($req as $row) {
        $numClient = $row['CLI_NUM'];
        $typeClient = $row['TYP_NUM'] ?? "Aucun type";
        $departement = $row['DEP_NUM'] ?? "Aucun département";
        $nomClient = $row['CLI_NOM'] ?? "Aucun nom";
        $prenomClient = $row['CLI_PRENOM'] ?? "Aucun prénom";
        $ville = $row['CLI_VILLE'] ?? "Aucune ville";
        $telephone = $row['CLI_TELEPHONE'] ?? "Aucun type";
        $courrielClient = $row['CLI_COURRIEL'] ?? "Aucun courriel";
        $pointsEffectif = $row['CLI_NB_POINTS_EC'] ?? "Aucun points effectifs";
        $pointsTotal = $row['CLI_NB_POINTS_TOT'] ?? "Aucun point total";
        $dateConnec = $row['CLI_DATE_CONNEC'] ?? "Aucune conexion";
        $admin = $row['CLI_EST_ADMIN'] ?? "Pas admin";
        $reservation = $row['RES_DATE'] ?? "Aucune reservation";
        $numLigne = $row['LIG_NUM'] ?? "Aucun numéro de la ligne";
        $corrDistance = $row['CORR_DISTANCE'] ?? "Aucune corréspondance";
        $corrHeure = $row['CORR_HEURE'] ?? "Aucune coréspondance";

        echo "<tr class='row'>";
        echo "<td class='cell'>$numClient</td>";
        echo "<td class='cell'>$typeClient</td>";
        echo "<td class='cell'>$departement</td>";
        echo "<td class='cell'>$nomClient</td>";
        echo "<td class='cell'>$prenomClient</td>";
        echo "<td class='cell'>$ville</td>";
        echo "<td class='cell'>$telephone</td>";
        echo "<td class='cell'>$courrielClient</td>";
        echo "<td class='cell'>$pointsEffectif</td>";
        echo "<td class='cell'>$pointsTotal</td>";
        echo "<td class='cell'>$dateConnec</td>";
        echo "<td class='cell'>$admin</td>";
        echo "<td class='cell'>$reservation</td>";
        echo "<td class='cell'>$numLigne</td>";
        echo "<td class='cell'>$corrDistance</td>";
        echo "<td class='cell'>$corrHeure</td>";
        echo "</tr>";
    }


?>        
</pre>
