<?php
    function calculerDistance($connexion, $noeudDepart, $noeudArrivee, $ligne){
        $distance = 0;
        $noeudCourant = $noeudDepart;
        while ($noeudCourant != $noeudArrivee) {
            $sql = "
                select distinct noe.lig_num, com1.com_nom as noeud_courant, com2.com_nom as noeud_suivant, noe.noe_distance_prochain as distance
                from vik_noeud noe
                join vik_commune com1 on noe.com_code_insee = com1.com_code_insee
                join vik_commune com2 on noe.com_code_insee_suivant = com2.com_code_insee
                where com1.com_nom = '" . str_replace("'", "''", $noeudCourant) . "' and noe.lig_num = '$ligne'
            ";
            $query = $connexion->query($sql);
            $noeud = $query->fetch();
            
            $distance += floatval($noeud["DISTANCE"]);
            $noeudCourant = $noeud["NOEUD_SUIVANT"];
        }
        return $distance;
    }
?>