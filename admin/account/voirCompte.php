<?php

    // Connexion à la base de données
    require_once("../config/bdd.php");
    require_once("../../src/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../src/css/style.css">
    <link type="text/css" rel="stylesheet" href="../../src/css/menus.css">
    <link type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php



    // Requête SQL
    $sql = "SELECT * FROM vik_client LEFT JOIN vik_correspondance USING (cli_num) LEFT JOIN vik_reservation USING (res_num, cli_num)";

    // Préparation de la requête
    $query = $connexion->prepare($sql);

    // Fonction pour récupérer tous les membres + boutons pour voir toutes les réservations + bouton pour supprimer un membre + bouton pour modifier un membre
    function membreInfo($connexion, $sql, $query) {
        // Lancement de la requête
        $query->execute();

        // Système de recherche de membre par nom
        echo "<form action='voirCompte.php' method='POST'>";
        echo "<input type='text' name='search' placeholder='Rechercher un membre par nom'>";
        echo "<input type='submit' name='submit' value='Rechercher'>";
        echo "</form>";

        // Si le bouton submit est cliqué
        if (isset($_POST['submit'])) {
            // On récupère la valeur de l'input search et le mettre en toUpperCase
            $search = strtoupper($_POST['search']);

            // On prépare la requête
            $sql = "SELECT distinct * FROM vik_client LEFT JOIN vik_correspondance USING (cli_num) LEFT JOIN vik_reservation USING (res_num, cli_num) WHERE CLI_NOM LIKE '%$search%'";

            // On prépare la requête
            $query = $connexion->prepare($sql);

            // On exécute la requête
            $query->execute();

            // On compte le nombre de résultat
            $count = $query->rowCount();
        } else {
            // On prépare la requête
            $sql = "SELECT distinct * FROM vik_client LEFT JOIN vik_correspondance USING (cli_num) LEFT JOIN vik_reservation USING (res_num, cli_num)";

            // On prépare la requête
            $query = $connexion->prepare($sql);

            // On exécute la requête
            $query->execute();

            // On compte le nombre de résultat
            $count = $query->rowCount();
        }
        // Création d'un tableau complet avec le numéro de client, le nom, le prénom, l'adresse mail et des boutons pour modifier, supprimer et voir les réservations de chaque membre
        echo "<table class='tab'>";
        echo "<thead>";
        echo "<tr class='row header'>";
        echo "<th class='cell'>Numéro de client</th>";
        echo "<th class='cell'>Nom</th>";
        echo "<th class='cell'>Prénom</th>";
        echo "<th class='cell'>Courriel</th>";
        echo "<th class='cell'>Réservations</th>";
        echo "<th class='cell'>Modifier</th>";
        echo "<th class='cell'>Supprimer</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($query as $row) {
            $numClient = $row['CLI_NUM'];
            $nomClient = $row['CLI_NOM'] ?? "Aucun nom";
            $prenomClient = $row['CLI_PRENOM'] ?? "Aucun prénom";
            $courrielClient = $row['CLI_COURRIEL'] ?? "Aucun courriel";

            echo "<tr class='row'>";
            echo "<td class='cell'>$numClient</td>";
            echo "<td class='cell'>$nomClient</td>";
            echo "<td class='cell'>$prenomClient</td>";
            echo "<td class='cell'>$courrielClient</td>";
            echo "<td class='cell'><a href='../request/visualiserClientEtReservations.php?num=$numClient'><button type='button' class='btn btn-primary'>Voir les réservations</button></a></td>";
            echo "<td class='cell'><a href='modifierCompte.php?num=$numClient'><button type='button' class='btn btn-warning'>Modifier</button></a></td>";
            echo "<td class='cell'><a href='supprimerCompte.php?num=$numClient'><button type='button' class='btn btn-danger'>Supprimer</button></a></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Fermeture de la requête
        $query->closeCursor();
    }

    membreInfo($connexion, $sql, $query);
?>