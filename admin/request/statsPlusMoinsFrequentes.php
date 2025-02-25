<script src="../src/js/index.js"></script>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link  type="text/css" rel="stylesheet" href="../../src/css/admin.css">
    <link  type="text/css" rel="stylesheet" href="../../src/css/menus.css">
    <link  type="text/css" rel="stylesheet" href="../../src/css/style.css">

</head>
<body>
    

<?php
require_once("../config/bdd.php");
require_once("../../src/header.php");
    if (isset($_GET["stat"]) && isset($_GET["ordre"]) && isset($_GET["nombre"])) {
        if($_GET["ordre"]==0){
            $desc= "desc";
        }else{
            $desc= "";
        }
        $nombre= $_GET["nombre"];
        if($_GET["stat"]==0){
            
        $sqlMax= "SELECT count(lig_num) from vik_ligne";
        $max = $connexion->query($sqlMax);
        $max= $max->fetchColumn();
        $nombre= $nombre*$max/100;

            $sql= "select lig_num, nb from
            ((select lig_num, count(*) as nb from vik_correspondance
            group by lig_num)
            union
            
            ((select lig_num, 0 as nb from vik_ligne
            minus
            select lig_num, 0 as nb from vik_correspondance
            )))
            
            order by nb ".$desc.", to_number(rtrim(trim(lig_num),'AB')) ".$desc."
            fetch FIRST ".$nombre." rows only";

            $result = $connexion->query($sql);
            echo ("<table class='tab'><thead><tr><th colspan='2'>Statistiques</th></tr></thead><tbody>");
            foreach ($result as $ligne) {
                echo("<tr><td>".$ligne["LIG_NUM"]."</td><td>". $ligne["NB"]."</td></tr>");
            }
            echo("</tbody></table>");

        }else{

            $sqlMax= "select count(count(*)) as nb from vik_correspondance
            join vik_commune com1 on com_code_insee_depart=com1.com_code_insee
            join vik_commune com2 on com_code_insee_arrivee=com2.com_code_insee
            group by (com1.com_nom, com2.com_nom)";
            $max = $connexion->query($sqlMax);
            $max= $max->fetchColumn();
            $nombre= $nombre*$max/100;

            $sql="select com1.com_nom as com1, com2.com_nom as com2, count(*) as nb from vik_correspondance
            join vik_commune com1 on com_code_insee_depart=com1.com_code_insee
            join vik_commune com2 on com_code_insee_arrivee=com2.com_code_insee
            group by (com1.com_nom, com2.com_nom)
            order by nb ".$desc."
            fetch FIRST ".$nombre." rows only";
            $result = $connexion->query($sql);

            echo ("<table><thead><tr><th colspan='2'>Statistiques</th></tr></thead><tbody>");
            foreach ($result as $ligne) {
                echo("<tr><td>".$ligne["COM1"]." - ".$ligne["COM2"]."</td><td>". $ligne["NB"]."</td></tr>");
            }
            echo("</tbody></table>");
        }
        
    }
?>
<form action="" method="GET">
    <label>Stat à afficher</label>
    <select name="stat" id="stat">
        <option value='0'>Lignes</option>
        <option value='1'>Trajets</option>
    </select>
    <label>Ordre</label>
    <select name="ordre" id="ordre">
        <option value='0'>Plus fréquenté</option>
        <option value='1'>Moins fréquenté</option>
    </select>
    <label>Nombre</label>

    
    <input type='range' id='nombre' min='1' max='100' value='1' step='1' name='nombre' list='powers'><datalist id='powers'>
        <option value='0'>
        <option value='25'>
        <option value='50'>
        <option value='75'>
        <option value='100'>
        </datalist>
        
    <label for='nombre'><span class="range-result" data-input="nombre"></span>%</label>
    <script>
        const rangeResults = document.querySelectorAll('.range-result');

        rangeResults.forEach(function(rangeResult) {
            const rangeInput = document.querySelector('#' + rangeResult.dataset.input);
  
            if (rangeInput) {
                rangeResult.innerHTML = rangeInput.value;
    
  	            rangeInput.addEventListener('input', function() {
   		            rangeResult.innerHTML = this.value;
                });
            }
        });
    </script>
    <button type="submit">Choisir</button>
</form>
<footer class="footer">
        <?php require_once("../../src/footer.php")?>
</footer>

</body>
</html>
