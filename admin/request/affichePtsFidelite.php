<?php
    // Connexion à la base de données
    require_once("../config/bdd.php");

    // Requête SQL
    $sql = "select cli_nom, round((sysdate - cli_date_connec) /365.25, 2) as jour from vik_client";

    // Préparation de la requête
    $query = $connexion->prepare($sql);
?>