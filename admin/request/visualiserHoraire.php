<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Lignes du réseau</title>
        <link rel="stylesheet" href="../../src/css/menus.css">
        <link rel="stylesheet" href="../../src/css/admin.css">
        <link rel="stylesheet" href="../../src/css/style.css">


    </head>
    <body>
        <!-- Barre de navigation -->
<?php require_once("../../src/header.php");?>
<?php
    // Récupération des informations de connexion à la base de données
    require_once("../config/bdd.php");
     // On récupère lig_num dans l'URL
     if(isset($_GET['lig_num'])){
        $lig_num = $_GET['lig_num'];
     }


    // Système de recherche de membre par nom
    echo "<form action='visualiserHoraire.php?lig_num=$lig_num' method='POST'>";
    echo "<input type='text' name='search' placeholder='Rechercher une ville'>";
    echo "<input type='submit' name='submit' value='Rechercher'>";
    echo "</form>";

    // Si le bouton submit est cliqué
    if (isset($_POST['submit'])) {
        // On récupère la valeur de l'input search et le mettre en toUpperCase
        $search = $_POST['search'];

         // requête SQL 
        $request = "select to_char(noe_heure_passage, 'HH24:MI:SS') as heure_passage,com_nom from vik_noeud
    join vik_commune using(com_code_insee) where lig_num = '$lig_num' and com_nom LIKE '%$search%' order by noe_heure_passage";


        // On prépare la requête
        $result = $connexion->prepare($request);

        // On exécute la requête
        $result->execute();

        // On compte le nombre de résultat
        $count = $result->rowCount();
    }
    else {
        $request = "select to_char(noe_heure_passage, 'HH24:MI:SS') as heure_passage,com_nom from vik_noeud
    join vik_commune using(com_code_insee) where lig_num = '$lig_num' order by noe_heure_passage";


        // On prépare la requête
        $result = $connexion->prepare($request);

        // On exécute la requête
        $result->execute();

        // On compte le nombre de résultat
        $count = $result->rowCount();
    }
   
   
    echo "<table class='tab'>";
            echo "<thead>";
                echo "<tr class='row header'>";
                    echo "<th class='cell'>Horaire</th>";
                    echo "<th class='cell'>Ville de passage</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
          
    // Vérification du résultat de la requête SQL
        foreach ($result as $ligne) {
            echo "<tr class='row'>";
            echo( '<td class="cell">'. $ligne["HEURE_PASSAGE"]. " </td>"); 
            echo( '<td class="cell">'. $ligne["COM_NOM"]. " </td>");
        }
        echo "</tbody>";
        echo "</table>";
    

?>



<footer class="footer">
        <?php require_once("../../src/footer.php")?>
</footer>
    </body>
</html>

