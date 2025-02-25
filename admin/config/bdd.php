<?php

    $dsn = "oci:dbname=kiutoracle18.unicaen.fr:1521/info.kiutoracle18.unicaen.fr;charset=AL32UTF8";
    $identifiant = "agile_6";
    $motDePasse = "agile_6";

   try {
        // Connexion à la base de données
		$connexion = new PDO($dsn,$identifiant,$motDePasse);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$res = true;
        $connexion->close=function ()
        {
            $connexion=null;
        };
	} catch (PDOException $erreur) {
		echo $erreur->getMessage();
        $res = false;
	}

    if (!$res) {
        echo ("<hr/> Connexion impossible à la base de données <br/>");
    }
   

?>