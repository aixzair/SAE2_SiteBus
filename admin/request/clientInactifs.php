<?php

    session_start();
    require_once("../config/bdd.php");

    // Requête SQL
    $sql_supPts = "UPDATE vik_client SET cli_nb_points_ec = 0 WHERE ROUND(MONTHS_BETWEEN(SYSDATE, cli_date_connec) / 12, 2) BETWEEN 1 AND 2";
    $sql_supCompte= "delete from VIK_CLIENT where round((sysdate - CLI_DATE_CONNEC) /365.25, 2)>2";

    $connexion->exec($sql_supPts);
    $connexion->exec($sql_supCompte);

    echo "Ligne pour prouver : INSERT INTO VIK_CLIENT (cli_num, cli_nom, cli_prenom, cli_courriel, cli_mdp, cli_nb_points_ec, cli_date_connec) values (69, 'MAUVAIS','Garçon','mg@gmal.com', '0408', 100, to_date('11/11/2011', 'dd/mm/yyyy'));";
    echo "<br>Le tri a été fait chez les inactifs";
    
?>