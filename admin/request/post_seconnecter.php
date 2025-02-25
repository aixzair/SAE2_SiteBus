<?php
    
    // Connexion à la base de données
    require_once("../config/bdd.php");

    // Requête SQL
    $sql = "select cli_courriel, cli_mdp, cli_num from vik_client";

    // Préparation de la requête
    $resultat = $connexion->query($sql);

    // Récupération des données du formulaire

    $cli_courriel = $_POST["courriel"];
  
    $mdp = $_POST["mdp"];
  
    function verifCompte($courriel, $mdp, $connexion) {
  
        // Requ?te SQL
  
        $sql = "SELECT * FROM vik_client WHERE CLI_COURRIEL = :courriel AND CLI_MDP = :mdp";
  
      
  
        // Pr?paration de la requ?te
  
        $stmt = $connexion->prepare($sql);
  
        $stmt->bindValue(':courriel', $courriel);
  
        $stmt->bindValue(':mdp', sha1($mdp));
  
        $stmt->execute();
    ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="../../src/css/admin.css" rel="stylesheet">
            <title>Erreur de connexion</title>
        </head>
        <body>
            
        </body>
        </html>

    <?php
        if ($stmt->rowCount() == 0) {
            echo("<div class='erreur'>");
            echo("<p>Erreur de connexion</p>");
            echo("<br>");
            echo("<a href='seConnecter.php'>Retour à la page de connexion</a>");
            echo("</div>");
        } 
  
        foreach ($stmt as $ligne) {
            echo( $ligne["CLI_COURRIEL"]);
  
            echo("<br>");
  
            // Cr?ation de la session
  
            session_start();
  
            $_SESSION["nom"] = $ligne["CLI_NOM"];
            $_SESSION["prenom"] = $ligne["CLI_PRENOM"];
            $_SESSION["courriel"] = $ligne["CLI_COURRIEL"];
            $_SESSION["num"] = $ligne["CLI_NUM"];
  
            // Redirection vers la page d'accueil
           header("Location: ../../src/index.php");
  
          }
      }    
  verifCompte($cli_courriel,$mdp,$connexion);
?>
