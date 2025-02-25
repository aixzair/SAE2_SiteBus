<?php
    require("choisirLigne.php");

    if (isset($_GET["noeud1"]) && isset($_GET["noeud2"])) {
        $noeud1 = $_GET["noeud1"];
        $noeud2 = $_GET["noeud2"];
        echo ("départ : " .$_GET["noeud1"] . " | arrivée : " . $_GET["noeud2"]);
        
    }
?>
<?php
    if(isset($numLigne)){
?>
<form action="" method="GET">
    <label>Ville de départ</label>
    <input type="hidden" name="numLigne" value="<?php echo($numLigne); ?>">
    <select name="noeud1" id="noeud1">
        <?php
            $requeteNoeud = "
            (select com_nom from vik_ligne
            join vik_noeud using(lig_num)
            join vik_commune using(com_code_insee)
            where upper(lig_num)= '$numLigne'
            group by com_nom)
            union
            (select com_nom from vik_ligne
            join vik_noeud using(lig_num)
            join vik_commune com1 on com1.com_code_insee= com_code_insee_suivant
            where upper(lig_num)= '$numLigne'
            group by com_nom)
            ";
            $resultatNoeud = $connexion->query($requeteNoeud);
            foreach ($resultatNoeud as $ligneNoeud) {
                ?>
            <option value="<?php echo($ligneNoeud["COM_NOM"]); ?>" <?php if (isset($_GET["noeud1"]) && $_GET["noeud1"] == $ligneNoeud["COM_NOM"]) echo("selected='selected'"); ?>><?php echo($ligneNoeud["COM_NOM"] ); ?></option>
                <?php
            }
        ?>
    </select>
    <label>Ville d'arrivée</label>
    <select name="noeud2" id="noeud2">
        <?php
            $resultatNoeud = $connexion->query($requeteNoeud);
            foreach ($resultatNoeud as $ligneNoeud) {
                ?>
            <option value="<?php echo($ligneNoeud["COM_NOM"]); ?>" <?php if (isset($_GET["noeud2"]) && $_GET["noeud2"] == $ligneNoeud["COM_NOM"]) echo("selected='selected'"); ?>><?php echo($ligneNoeud["COM_NOM"] ); ?></option>
                <?php
            }
        ?>
    </select>
    <button type="submit">Choisir</button>
</form>
<?php
    }
?>