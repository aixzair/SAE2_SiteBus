<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menus.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Classements</title>
</head>
    <body>
        <!-- Haut de page -->
        <?php require_once("header.php");?>

        <button onclick="location.href = '../admin/request/classementTrajetDistance.php';" > Voir les trajets classés par distance </button> 
        <button onclick="location.href = '../admin/request/classementTrajetDuree.php';"> Voir les trajets classés par durée  </button>

        <!-- Pied de page -->
        <footer>
                <?php require_once("footer.php");?>
        </footer>
    </body>
</html>

