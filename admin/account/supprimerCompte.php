<?php
    // Connexion à la base de données
    require_once("../config/bdd.php");

    // Récupération des données de l'URL ?num=... si elles existent et sont définies
    $num = isset($_GET['num']) ? $_GET['num'] : "";

    // Mise en place de la requête SQL
    $requeteCorrespondances = "DELETE FROM vik_correspondance WHERE CLI_NUM = :num";
    $requeteReservations = "DELETE FROM vik_reservation WHERE CLI_NUM = :num";
    $requeteClients = "DELETE FROM vik_client WHERE CLI_NUM = :num";

    // Préparation de la requête
    $stmt1 = $connexion->prepare($requeteCorrespondances);
    $stmt2 = $connexion->prepare($requeteReservations);
    $stmt3 = $connexion->prepare($requeteClients);

    // Liaison du paramètre
    $stmt1->bindParam(':num', $num);
    $stmt2->bindParam(':num', $num);
    $stmt3->bindParam(':num', $num);

    // Exécution de la requête
    $stmt1->execute();
    $stmt2->execute();
    $stmt3->execute();

    // Fermeture de la requête
    $stmt1->closeCursor();
    $stmt2->closeCursor();
    $stmt3->closeCursor();

    // Redirection vers la page d'accueil
    header("Location: voirCompte.php");
?>
