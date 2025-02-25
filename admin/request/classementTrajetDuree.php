<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <link type="text/css" rel="stylesheet" href="../../src/css/menus.css">
    <link  type="text/css" rel="stylesheet" href="../../src/css/menus.css">
    <title>Classement trajets par durée</title>
</head>
<body>

<?php
    // Connexion à la base de donnée
    require_once("../config/bdd.php");
    require_once("../../src/header.php");

    //$num = isset($_GET['num']) ? $_GET['num'] : "";

    // Requête SQL
    $sql = "select distinct lig_num,com1.com_nom as COM_NOM, com2.com_nom as COM_NOM_1, noe_duree_prochain as duree_correspondance    from vik_correspondance vik_corr
    join vik_commune com1 on vik_corr.com_code_insee_depart=com1.com_code_insee
    join vik_commune com2 on vik_corr.com_code_insee_arrivee=com2.com_code_insee
    join vik_noeud using(lig_num)
    
    order by duree_correspondance,lig_num";

    $req = $connexion->query($sql);

    echo "<table class='tab'>";
    echo "<thead>";
    echo "<tr class='row header'>";
    echo "<th class='cell'>Ligne</th>";

    echo "<th class='cell'>Nom de la commune de départ</th>";
    echo "<th class='cell'>Nom de la comune d'arrivée</th>";
    echo "<th class='cell'>Heure de la correspondance</th>";

    foreach ($req as $row) {
        $numero_ligne = $row['LIG_NUM'] ?? "Aucune Ligne";
        $comDepart = $row['COM_NOM'] ?? "Aucune commune de départ";
        $comArivee = $row['COM_NOM_1'] ?? "Aucune commune d'arrivée";
        $dureeCorr = $row['DUREE_CORRESPONDANCE'] ?? "Aucun horaire";
        echo "<tr class='row'>";
        echo "<td class='cell'>$numero_ligne</td>";
        echo "<td class='cell'>$comDepart</td>";
        echo "<td class='cell'>$comArivee</td>";
        echo "<td class='cell'>$dureeCorr</td>";
    }
?>
<footer class="footer">
        <?php require_once("../../src/footer.php")?>
</footer>
</body>
</html>