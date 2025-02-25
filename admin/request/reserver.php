<?php
    require_once("../config/bdd.php");
    
    if (isset($_POST["nbCorrespondances"]) && is_numeric($_POST["nbCorrespondances"])) {
        $nbCorrespondances = intval($_POST["nbCorrespondances"]);
    } else {
        $nbCorrespondances = 1;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <link type="text/css" rel="stylesheet" href="../../src/css/menus.css">
    <link type="text/css" rel="stylesheet" href="../../src/css/style.css">


    <title>Réserver votre ligne</title>
</head>
<body>
    <?php require_once("../../src/header.php");?>
    <div class = "container">
    <h1 class="title">Choisir un trajet</h1>
            <hr>
    <?php
        for ($numCorrespondance = 1; $numCorrespondance <= $nbCorrespondances; $numCorrespondance++) {
            // Choisir ligne
            if (!isset($_POST["numLigne$numCorrespondance"])) {
    ?>
    <form action="" method="POST">
        <?php
            for ($i = 1; $i <= $nbCorrespondances; $i++) {
                if (isset($_POST["numLigne$i"]))
                    echo("<input type='hidden' name='numLigne$i' value='" . $_POST["numLigne$i"] . "'/>");
                if (isset($_POST["noeudDepart$i"]))
                    echo("<input type='hidden' name='noeudDepart$i' value='" . $_POST["noeudDepart$i"] . "'/>");
                if (isset($_POST["noeudArrivee$i"]))
                    echo("<input type='hidden' name='noeudArrivee$i' value='" . $_POST["noeudArrivee$i"] . "'/>");
                if (isset($_POST["horaire$i"]))
                    echo("<input type='hidden' name='horaire$i' value='" . $_POST["horaire$i"] . "'/>");
            }
        ?>
        <select name="numLigne<?php echo($numCorrespondance); ?>" id="numLigne<?php echo($numCorrespondance); ?>" <?php if ($numCorrespondance != $nbCorrespondances) echo('disabled="disabled"'); ?>>
        <?php
            $requete = "
                SELECT LIG_NUM
                FROM VIK_LIGNE
                ORDER BY to_number(rtrim(trim(LIG_NUM), 'AB'))
            ";
            $resultat = $connexion->query($requete);

            foreach ($resultat as $ligne) {
        ?>
        <option value="<?php echo($ligne["LIG_NUM"]); ?>" <?php if (isset($_POST["numLigne$numCorrespondance"]) && $_POST["numLigne$numCorrespondance"] == $ligne["LIG_NUM"]) echo('selected="selected"'); ?>><?php echo(trim($ligne["LIG_NUM"])); ?></option>
        <?php
            }
        ?>
        </select>
        <input type="hidden" name="nbCorrespondances" value="<?php echo($nbCorrespondances); ?>">
        <button type="submit">Sélectionner</button>
    </form>
    <br>
    <?php
            } elseif (!isset($_POST["noeudDepart$numCorrespondance"]) && !isset($_POST["noeudArrivee$numCorrespondance"])) {
                // Choisir noeud de départ et noeud d'arrivée
    ?> 
        <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $nbCorrespondances; $i++) {
                    if (isset($_POST["numLigne$i"]))
                        echo("<input type='hidden' name='numLigne$i' value='" . $_POST["numLigne$i"] . "'/>");
                    if (isset($_POST["noeudDepart$i"]))
                        echo("<input type='hidden' name='noeudDepart$i' value='" . $_POST["noeudDepart$i"] . "'/>");
                    if (isset($_POST["noeudArrivee$i"]))
                        echo("<input type='hidden' name='noeudArrivee$i' value='" . $_POST["noeudArrivee$i"] . "'/>");
                    if (isset($_POST["horaire$i"]))
                        echo("<input type='hidden' name='horaire$i' value='" . $_POST["horaire$i"] . "'/>");
                }
            ?>
            <select disabled="disabled">
                <option selected="selected"><?php echo($_POST["numLigne$numCorrespondance"]); ?></option>
            </select>
            <input type="hidden" name="numLigne<?php echo($numCorrespondance); ?>" value="<?php echo($_POST["numLigne$numCorrespondance"]); ?>">
            <label>Ville de départ</label>
            <select name="noeudDepart<?php echo($numCorrespondance); ?>" id="noeudDepart<?php echo($numCorrespondance); ?>">
            <?php
                $requete = "
                    (
                        SELECT COM_NOM
                        FROM VIK_LIGNE
                        JOIN VIK_NOEUD USING (LIG_NUM)
                        JOIN vik_commune USING (COM_CODE_INSEE)
                        WHERE upper(LIG_NUM) = '". $_POST["numLigne$numCorrespondance"] . "'
                        GROUP BY COM_NOM
                    ) UNION (
                        SELECT COM_NOM
                        FROM VIK_LIGNE
                        JOIN VIK_NOEUD USING (LIG_NUM)
                        JOIN vik_commune com1 ON com1.COM_CODE_INSEE = COM_CODE_INSEE_suivant
                        WHERE upper(LIG_NUM) = '". $_POST["numLigne$numCorrespondance"] . "'
                        GROUP BY COM_NOM
                    )
                ";
                $resultat = $connexion->query($requete);
                foreach ($resultat as $ligne) {
            ?>
                <option value="<?php echo($ligne["COM_NOM"]); ?>" <?php if (isset($_POST["noeudDepart$numCorrespondance"]) && $_POST["noeudDepart$numCorrespondance"] == $ligne["COM_NOM"]) echo('selected="selected"'); ?>><?php echo($ligne["COM_NOM"]); ?></option>
            <?php
                    }
            ?>
            </select>
            <label>Ville d'arrivée</label>
            <select name="noeudArrivee<?php echo($numCorrespondance); ?>" id="noeudArrivee<?php echo($numCorrespondance); ?>">
            <?php
                $requete = "
                    (
                        SELECT COM_NOM
                        FROM VIK_LIGNE
                        JOIN VIK_NOEUD USING (LIG_NUM)
                        JOIN vik_commune USING (COM_CODE_INSEE)
                        WHERE upper(LIG_NUM) = '". $_POST["numLigne$numCorrespondance"] . "'
                        GROUP BY COM_NOM
                    ) UNION (
                        SELECT COM_NOM
                        FROM VIK_LIGNE
                        JOIN VIK_NOEUD USING (LIG_NUM)
                        JOIN vik_commune com1 ON com1.COM_CODE_INSEE = COM_CODE_INSEE_suivant
                        WHERE upper(LIG_NUM) = '". $_POST["numLigne$numCorrespondance"] . "'
                        GROUP BY COM_NOM
                    )
                ";
                $resultat = $connexion->query($requete);
                foreach ($resultat as $ligne) {
            ?>
                <option value="<?php echo($ligne["COM_NOM"]); ?>" <?php if (isset($_POST["noeudArrivee$numCorrespondance"]) && $_POST["noeudArrivee$numCorrespondance"] == $ligne["COM_NOM"]) echo('selected="selected"'); ?>><?php echo($ligne["COM_NOM"]); ?></option>
            <?php
                    }
            ?>
            </select>
            <input type="hidden" name="nbCorrespondances" value="<?php echo($nbCorrespondances); ?>">
            <button type="submit">Sélectionner</button>
        </form>
        <br>
    <?php
            } elseif (!isset($_POST["horaire$numCorrespondance"]) ) {
                // Choisir horaire
                $lig_num = str_pad($_POST["numLigne$numCorrespondance"], 3);
                $noeudDepart = $_POST["noeudDepart$numCorrespondance"];

                $requete = "
                    SELECT to_char(NOE_HEURE_PASSAGE, 'hh24:mi') AS CORR_HORAIRE
                    FROM VIK_NOEUD
                    WHERE LIG_NUM = '$lig_num' AND COM_CODE_INSEE = (
                        SELECT COM_CODE_INSEE
                        FROM VIK_COMMUNE
                        WHERE COM_NOM = '$noeudDepart'
                    )
                ";
                $resultat = $connexion->query($requete);
    ?> 
        <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $nbCorrespondances; $i++) {
                    if (isset($_POST["numLigne$i"]))
                        echo("<input type='hidden' name='numLigne$i' value='" . $_POST["numLigne$i"] . "'/>");
                    if (isset($_POST["noeudDepart$i"]))
                        echo("<input type='hidden' name='noeudDepart$i' value='" . $_POST["noeudDepart$i"] . "'/>");
                    if (isset($_POST["noeudArrivee$i"]))
                        echo("<input type='hidden' name='noeudArrivee$i' value='" . $_POST["noeudArrivee$i"] . "'/>");
                    if (isset($_POST["horaire$i"]))
                        echo("<input type='hidden' name='horaire$i' value='" . $_POST["horaire$i"] . "'/>");
                }
            ?>
            <select name="numLigne<?php echo($numCorrespondance); ?>" id="numLigne<?php echo($numCorrespondance); ?>" disabled="disabled">
                <option value="<?php echo($_POST["numLigne$numCorrespondance"]); ?>" selected="selected"><?php echo($_POST["numLigne$numCorrespondance"]); ?></option>
            </select>
            <label>Ville de départ</label>
            <select name="noeudDepart<?php echo($numCorrespondance); ?>" id="noeudDepart<?php echo($numCorrespondance); ?>" disabled="disabled">
                <option value="<?php echo($_POST["noeudDepart$numCorrespondance"]); ?>" selected="selected"><?php echo($_POST["noeudDepart$numCorrespondance"]); ?></option>
            </select>
            <label>Ville d'arrivée</label>
            <select name="noeudArrivee<?php echo($numCorrespondance); ?>" id="noeudArrivee<?php echo($numCorrespondance); ?>" disabled="disabled">
                <option value="<?php echo($_POST["noeudArrivee$numCorrespondance"]); ?>"  selected="selected"><?php echo($_POST["noeudArrivee$numCorrespondance"]); ?></option>
            </select>
            <select name="horaire<?php echo($numCorrespondance); ?>" id="horaire<?php echo($numCorrespondance); ?>">
                <?php
            foreach ($resultat as $ligne) {
                ?>
            <option value="<?php echo($ligne["CORR_HORAIRE"]); ?>" <?php if (isset($_POST["horaire$numCorrespondance"]) && $_POST["horaire$numCorrespondance"] == $ligne["CORR_HORAIRE"]) echo('selected="selected"'); ?>><?php echo($ligne["CORR_HORAIRE"]); ?></option>
                <?php
            }
                ?>
            </select>
            <input type="hidden" name="nbCorrespondances" value="<?php echo($nbCorrespondances + 1); ?>">
            <button type="submit">Ajouter</button>
            <br>
        </form>
    <?php
            } else {
                // Lignes ajoutées
    ?>
        
        <select name="numLigne<?php echo($numCorrespondance); ?>" id="numLigne<?php echo($numCorrespondance); ?>" disabled="disabled">
            <option value="<?php echo($_POST["numLigne$numCorrespondance"]); ?>" selected="selected"><?php echo($_POST["numLigne$numCorrespondance"]); ?></option>
        </select>
        <label>Ville de départ</label>
        <select name="noeudDepart<?php echo($numCorrespondance); ?>" id="noeudDepart<?php echo($numCorrespondance); ?>" disabled="disabled">
            <option value="<?php echo($_POST["noeudDepart$numCorrespondance"]); ?>" selected="selected"><?php echo($_POST["noeudDepart$numCorrespondance"]); ?></option>
        </select>
        <label>Ville d'arrivée</label>
        <select name="noeudArrivee<?php echo($numCorrespondance); ?>" id="noeudArrivee<?php echo($numCorrespondance); ?>" disabled="disabled">
            <option value="<?php echo($_POST["noeudArrivee$numCorrespondance"]); ?>"  selected="selected"><?php echo($_POST["noeudArrivee$numCorrespondance"]); ?></option>
        </select>
        <select name="horaire<?php echo($numCorrespondance); ?>" id="horaire<?php echo($numCorrespondance); ?>" disabled="disabled">
            <option value="<?php echo($_POST["horaire$numCorrespondance"]); ?>"  selected="selected"><?php echo($_POST["horaire$numCorrespondance"]); ?></option>
        </select>
        <input type="hidden" name="nbCorrespondances" value="<?php echo($nbCorrespondances); ?>">
        <button type="button" disabled="disabled">Ajouté</button>
        <br>
        <hr>
    <?php
            }
        }
        if ($nbCorrespondances > 1 && !isset($_POST["numLigne$nbCorrespondances"])) {
            ?>
    <form action="post_reserver.php" method="POST">
        <?php
            foreach ($_POST as $cle => $valeur) {
                echo("<input type='hidden' name='$cle' value='$valeur'/>\n");
            }
        ?>
        <button type="submit">Réserver</button>
    </form>
            <?php
        }
    ?>
    </div>
    <footer class="footer">
        <?php require_once("../../src/footer.php")?>
</footer>
    
</body>
</html>