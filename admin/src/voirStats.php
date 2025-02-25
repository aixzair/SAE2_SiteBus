<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menus.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Statistiques</title>
</head>
<body>
    <!-- Barre de navigation -->
    <?php require_once("header.php");?>

    <button onclick="location.href = '../admin/request/statClients.php';" > Voir statistiques des clients </button> 
    <button onclick="location.href = '../admin/request/statsPlusMoinsFrequentes.php';"> Voir statistiques des lignes  </button>

    <!-- Pied de page -->
    <footer>
                <?php require_once("footer.php");?>
    </footer>
</body>
</html>

