<!--http://localhost/ils_etaient_neuf/admin/request/trouverTrajets.php-->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../src/css/menus.css">
        <link rel="stylesheet" href="../../src/css/style.css">
        <link rel="stylesheet" href="../../src/css/admin.css">
        <title>Trouver les trajets</title>
    </head>
    <body>
        <?php require_once("../../src/header.php"); ?>

        <?php
            // Calcule les chemins
            $chemins = trouverTousLesChemins(14047, 61006, $connexion); // 14367 61006
        ?>

        <br/>
        <h2>Chemins possibles</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Itinéraire</th>
                <th>Distance</th>
                <th>Durée</th>
            </tr>
            <?php
                $index = 0;
                $distanceIndex = 0;
                $dureeIndex = 0;
                $distanceMin = 0.0;
                $dureeMin = 0.0;
                $retourDistance = 0.0;
                $retourDuree = 0.0;

                // Affiche et trouve les chemins plus court et plus rapide.
                foreach ($chemins as $chemin) {
                    afficherChemin($connexion, $chemin, $retourDistance, $retourDuree);

                    if ($index == 0) {
                        $distanceMin = $retourDistance;
                        $dureeMin = $retourDuree;
                    }

                    if ($retourDistance < $distanceMin) {
                        $distanceMin = $retourDistance;
                        $distanceIndex = $index;
                    }

                    if ($retourDuree < $dureeMin) {
                        $dureeMin = $retourDuree;
                        $dureeIndex = $index;
                    }

                    $retourDistance = 0.0;
                    $retourDuree = 0.0;
                    $index++;
                }
            ?>
        </table>

        <br/>
        <h2>Chemins le plus court :</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Itinéraire</th>
                <th>Distance</th>
                <th>Durée</th>
            </tr> <!-- Affiche chemin plus court -->
            <?php afficherChemin($connexion, $chemins[$distanceIndex], $retourDistance, $retourDuree); ?>
        </table>

        <br/> <!-- Affiche chemin plus rapide -->
        <h2>Chemins le plus rapide :</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Itinéraire</th>
                <th>Distance</th>
                <th>Durée</th>
            </tr>
            <?php afficherChemin($connexion, $chemins[$dureeIndex], $retourDistance, $retourDuree); ?>
        </table>

    </body>
</html>

<?php
    function trouverTousLesChemins($A, $B, $connexion) {
        $cheminActuel = array($A);  // Initialise un chemin actuel avec le point de départ A
        $tousLesChemins = array();  // Stocke tous les chemins trouvés
        
        // Appel récursif pour explorer tous les voisins de A
        $nRecur = 0;
        dfs($A, $B, $cheminActuel, $tousLesChemins, $connexion, $nRecur);
        $nRecur--;
        
        return $tousLesChemins;
    }
    
    // Fonction de recherche en profondeur (DFS)
    function dfs($noeud, $destination, &$cheminActuel, &$tousLesChemins, $connexion, &$nRecur) {
        if ($nRecur >= 10) {
            return;
        }

        if ($noeud == $destination) {
            $tousLesChemins[] = $cheminActuel;  // Ajoute le chemin actuel à la liste des chemins trouvés
            return;                             // Arrête l'exploration de ce chemin
        }

        $request = "
            SELECT DISTINCT com_code_insee_suivant
            FROM vik_noeud
            WHERE com_code_insee = $noeud"
        ;

        $voisins = $connexion->query($request);
        
        foreach ($voisins as $voisin) {
            if (!in_array($voisin["COM_CODE_INSEE_SUIVANT"], $cheminActuel)) {  // Évite les cycles
                $cheminActuel[] = $voisin["COM_CODE_INSEE_SUIVANT"];  // Ajoute le voisin au chemin actuel
                $nRecur++;
                dfs($voisin["COM_CODE_INSEE_SUIVANT"], $destination, $cheminActuel, $tousLesChemins, $connexion, $nRecur);  // Appel récursif pour explorer le voisin
                $nRecur--;
                array_pop($cheminActuel);  // Retire le voisin du chemin actuel pour explorer d'autres voisins
            }
        }
    }

    function afficherChemin($connexion, $chemin, &$distance, &$duree) {
    // Initialize variables
    $sChemin = "";
    $noeudPassee = $chemin[0];
    $distance = 0.0;
    $duree = 0.0;

    // Iterate over the path
    for ($i = 0; $i < count($chemin); $i++) {
        // Get the commune name
        $codeInsee = $chemin[$i];
        $request = "SELECT com_nom FROM vik_commune WHERE com_code_insee = $codeInsee";
        $commune = $connexion->query($request)->fetch();

        // Add the commune to the path
        $sChemin .= $commune["COM_NOM"] . " > ";

        if ($i < count($chemin) - 1) {
            // Get the distance and duration between current and next commune
            $noeud = $chemin[$i + 1];
            $request = "
                SELECT DISTINCT
                    com1.com_nom AS depart,
                    com2.com_nom AS arrivee,
                    noe_distance_prochain AS distance,
                    MIN(noe_duree_prochain) AS duree
                FROM vik_noeud noe
                JOIN vik_commune com1 ON noe.com_code_insee = com1.com_code_insee
                JOIN vik_commune com2 ON noe.com_code_insee_suivant = com2.com_code_insee
                WHERE com1.com_code_insee = $noeudPassee
                    AND com2.com_code_insee = $noeud
                GROUP BY com1.com_nom, com2.com_nom, noe_distance_prochain";

            $result = $connexion->query($request)->fetch();

            if ($result !== false) {
                // Access the array offsets and perform the necessary operations
                $distance += floatval($result["DISTANCE"]);
                $duree += floatval($result["DUREE"]);
            }

            $noeudPassee = $noeud;
        }
    }

    // Remove the trailing " > "
    $sChemin = substr($sChemin, 0, -3);

    // Display the path, total distance, and total duration
    echo "
        <tr>
            <td>$sChemin</td>
            <td>$distance km</td>
            <td>$duree min</td>
        </tr>
    ";
} 
?>