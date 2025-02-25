<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link  type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <link  type="text/css" rel="stylesheet" href="../../src/css/style.css">
    <link  type="text/css" rel="stylesheet" href="../../src/css/menus.css">
</head>
<body>
 
<?php

// requête SQL pour récupérer toutes les lignes de la table vik_ligne
$request = "SELECT lig_num, cd.com_nom AS com_nom_debu, ct.com_nom as com_nom_fin FROM vik_ligne JOIN vik_commune CD on com_code_insee_debu = cd.com_code_insee JOIN vik_commune ct on com_code_insee_term = ct.com_code_insee ORDER BY to_number(rtrim(trim(lig_num),'AB'))";

// Exécution de la requête SQL
$result = $connexion->query($request);

echo "<table class='tab'>";
        echo "<thead>";
            echo "<tr class='row header'>";
                echo "<th class='cell'>Ligne</th>";
                echo "<th class='cell'>Ville de départ</th>";
                echo "<th class='cell'>Ville d'arriver</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
foreach ($result as $ligne) {
    $lig_num = $ligne["LIG_NUM"];
    $com_nom_debu = $ligne["COM_NOM_DEBU"] ?? "";
    $com_nom_fin = $ligne["COM_NOM_FIN"] ?? "";

            echo "<tr class='row'>";
                echo "<td class='cell'>" . "<a href='../admin/request/visualiserHoraire.php?lig_num=$lig_num' style='color:black'>" . $lig_num ."</a>" . "</td>";
                echo "<td class='cell'>" . $com_nom_debu . "</td>";
                echo "<td class='cell'>" . $com_nom_fin . "</td>";
            echo "</tr>";
}

echo "</tbody>";
echo "</table>";

?>

</body>
</html>
