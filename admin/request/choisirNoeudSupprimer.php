<?php
    require_once("../config/bdd.php");
    require("choisirLigne.php");

    if (isset($_GET["com"]) && isset($_GET["numLigne"])) {
        $numLigne = $_GET["numLigne"];
        $com_num = $_GET["com"];
        
        // Vérifier si pas dernière -> si count = 0, c'est le dernier
        $sqlVD = "SELECT COUNT(com_code_insee) AS nb FROM (
            SELECT DISTINCT com_code_insee FROM vik_noeud
            WHERE lig_num = :numLigne)
            WHERE com_code_insee = :com_num";
        
        $stmtVD = $connexion->prepare($sqlVD);
        $stmtVD->bindParam(':numLigne', $numLigne);
        $stmtVD->bindParam(':com_num', $com_num);
        $stmtVD->execute();
        $resVD = $stmtVD->fetchColumn();
        
        if ($resVD == 0) {
            // Si count = 0
            $sqlVDOui = "DELETE FROM vik_noeud
            WHERE com_code_insee_suivant = :com_num";

            $stmtVDOui = $connexion->prepare($sqlVDOui);
            $stmtVDOui->bindParam(':com_num', $com_num);
            $stmtVDOui->execute();
            
            echo ("Suppression de $com_num");
        } else {
            // Vérifier si pas première -> si count = 0, c'est le premier
            $sqlVP = "SELECT COUNT(com_code_insee_suivant) AS NB FROM (
            SELECT DISTINCT com_code_insee_suivant FROM vik_noeud
            WHERE lig_num = :numLigne)
            WHERE com_code_insee_suivant = :com_num";
        
            $stmtVP = $connexion->prepare($sqlVP);
            $stmtVP->bindParam(':numLigne', $numLigne);
            $stmtVP->bindParam(':com_num', $com_num);
            $stmtVP->execute();
            $resVP = $stmtVP->fetchColumn();
            
            if ($resVP == 0) {
                // Si count = 0
                $sqlVPOui = "DELETE FROM vik_noeud
                WHERE com_code_insee = :com_num";

                $stmtVPOui = $connexion->prepare($sqlVPOui);
                $stmtVPOui->bindParam(':com_num', $com_num);
                $stmtVPOui->execute();
                
                echo ("Suppression de $com_num");
            } else {
                // Sinon on change une des deux lignes pour supprimer l'autre
                $sqlFin1 = "UPDATE vik_noeud
                SET noe_distance_prochain = (
                    (SELECT DISTINCT noe_distance_prochain FROM vik_noeud
                    WHERE com_code_insee = :com_num
                    AND lig_num = :numLigne) +
                    (SELECT DISTINCT noe_distance_prochain FROM vik_noeud
                    WHERE com_code_insee_suivant = :com_num
                    AND lig_num = :numLigne))
                WHERE com_code_insee_suivant = :com_num";

                $sqlFin2 = "UPDATE vik_noeud
                SET com_code_insee_suivant = (
                    SELECT DISTINCT com_code_insee_suivant FROM vik_noeud
                    WHERE com_code_insee = :com_num
                    AND lig_num = :numLigne)
                WHERE com_code_insee_suivant = :com_num";

                $sqlFin3 = "DELETE FROM vik_noeud
                WHERE com_code_insee = :com_num";

                $stmtFin1 = $connexion->prepare($sqlFin1);
                $stmtFin1->bindParam(':com_num', $com_num);
                $stmtFin1->bindParam(':numLigne', $numLigne);
                $stmtFin1->execute();

                $stmtFin2 = $connexion->prepare($sqlFin2);
                $stmtFin2->bindParam(':com_num', $com_num);
                $stmtFin2->bindParam(':numLigne', $numLigne);
                $stmtFin2->execute();

                $stmtFin3 = $connexion->prepare($sqlFin3);
                $stmtFin3->bindParam(':com_num', $com_num);
                $stmtFin3->execute();
            }
        }
    }
?>

<?php
    if (isset($numLigne)) {
?>
<form action="" method="GET">
    <label><strong>Ville de la ligne <?php echo ("$numLigne"); ?></strong></label><br>
    <input type="hidden" name="numLigne" value="<?php echo($numLigne); ?>">
    <?php
    $requeteNoeud = "
        (SELECT com_nom, com_code_insee AS com_num FROM vik_ligne
        JOIN vik_noeud USING(lig_num)
        JOIN vik_commune USING(com_code_insee)
        WHERE UPPER(lig_num) = :numLigne
        GROUP BY com_nom, com_code_insee)
        UNION
        (SELECT com_nom, com_code_insee_suivant AS com_num FROM vik_ligne
        JOIN vik_noeud USING(lig_num)
        JOIN vik_commune com1 ON com1.com_code_insee = com_code_insee_suivant
        WHERE UPPER(lig_num) = :numLigne
        GROUP BY com_nom, com_code_insee_suivant)
    ";
    $stmtNoeud = $connexion->prepare($requeteNoeud);
    $stmtNoeud->bindParam(':numLigne', $numLigne);
    $stmtNoeud->execute();
    $resultatNoeud = $stmtNoeud->fetchAll();

    foreach ($resultatNoeud as $ligneNoeud) {
        ?>
        <label for="com"><?php echo($ligneNoeud["COM_NOM"]); ?>
            <input type="radio" name="com" id="com" value="<?php echo($ligneNoeud["COM_NUM"]); ?>">
        </label><br>
        <?php
    }
    ?>
    <button type="submit">Choisir</button>
</form>
<?php
    }
?>
