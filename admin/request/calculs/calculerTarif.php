<?php
    function calculerTarif($connexion, $distance){
        $query = "
            SELECT TAR_MIN_DIST, TAR_MAX_DIST, TAR_VALEUR
            FROM VIK_TARIF
            WHERE $distance BETWEEN TAR_MIN_DIST AND TAR_MAX_DIST
        ";
        $resultat = $connexion->query($query) ;
        $ligne = $resultat->fetch();

        return intval($ligne["TAR_VALEUR"]);
    }
?>