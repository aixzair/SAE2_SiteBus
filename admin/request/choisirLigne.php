<?php
    require_once("visualiserHoraire.php");

    if (isset($_GET["numLigne"])) {
        $numLigne = $_GET["numLigne"];
    }

    if (isset($_GET["numLigne"])) {

        $requete= "
            SELECT LIG_NUM, CD.COM_NOM AS COM_NOM_DEBU, CT.COM_NOM AS COM_NOM_FIN
            FROM VIK_LIGNE
            JOIN VIK_COMMUNE CD ON COM_CODE_INSEE_DEBU = CD.COM_CODE_INSEE
            JOIN VIK_COMMUNE CT ON COM_CODE_INSEE_TERM = CT.COM_CODE_INSEE
            WHERE LIG_NUM = '$numLigne'
        ";

        $resultat = $connexion->query($requete);
        foreach ($resultat as $ligne) {
            echo($ligne["LIG_NUM"] . ", " . $ligne["COM_NOM_DEBU"] . ", " . $ligne["COM_NOM_FIN"]);
            echo("<br>");
        }
    }
?>

<form action="" method="GET">
    <select name="numLigne" id="numLigne">
        <?php
            $requete = "
                SELECT LIG_NUM
                FROM VIK_LIGNE
            ";
            $resultat = $connexion->query($requete);
            foreach ($resultat as $ligne) {
                // echo("<option value='" . $ligne["LIG_NUM"] . "'>" . $ligne["LIG_NUM"] . "</option>");
                ?>
            <option value="<?php echo($ligne["LIG_NUM"]); ?>" <?php if (isset($_GET["numLigne"]) && $_GET["numLigne"] == $ligne["LIG_NUM"]) echo("selected='selected'"); ?>><?php echo($ligne["LIG_NUM"] ); ?></option>
                <?php
            }
        ?>
    </select>
    <button type="submit">Choisir</button>
</form>