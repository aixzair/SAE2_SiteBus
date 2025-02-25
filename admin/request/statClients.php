<!--http://localhost/ils_etaient_neuf/admin/request/statClients.php-->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../src/css/menus.css">
        <link rel="stylesheet" href="../../src/css/style.css">
        <link rel="stylesheet" href="../../src/css/admin.css">
        <title>Statistiques clients</title>
    </head>
    <body>
        <?php require_once("../../src/header.php"); ?>

        <h2>Clients avec le plus de points total :</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nb points totaux</th>
            </tr>
            <?php 
                $request = "
                SELECT  CLI_NUM, cli_nom, CLI_PRENOM,
                        cli_nb_points_tot
                FROM vik_client
                WHERE   cli_est_admin = 0
                        AND cli_nb_points_tot IS NOT NULL
                ORDER BY cli_nb_points_tot DESC
                ";
        
                // Exécution de la requête SQL
                $result = $connexion->query($request);
        
                // Affichage des résultats de la requête SQL
                foreach ($result as $ligne) {
                ?>
                    <tr>
                        <td><?php echo($ligne["CLI_NUM"]); ?></td>
                        <td><?php echo($ligne["CLI_NOM"]); ?></td>
                        <td><?php echo($ligne["CLI_PRENOM"]); ?></td>
                        <td><?php echo($ligne["CLI_NB_POINTS_TOT"]); ?></td>
                    </tr>
                <?php
                }
            ?>
        </table>
        <br/>
    
        <h2>Clients avec le plus de réservations :</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nb réservations</th>
            </tr>
            <?php 
                $request = "
                SELECT  cli_num, cli_nom, cli_prenom, nb_reservation
                FROM (
                    select  cli_num, count(res_num) as nb_reservation
                    from vik_reservation
                    group by cli_num)
                JOIN vik_client using(cli_num)
                WHERE lower(cli_nom) <> 'non inscrit'
                ORDER BY nb_reservation desc, cli_num
                ";
        
                // Exécution de la requête SQL
                $result = $connexion->query($request);
        
                // Affichage des résultats de la requête SQL
                foreach ($result as $ligne) {
                ?>
                    <tr>
                        <td><?php echo($ligne["CLI_NUM"]); ?></td>
                        <td><?php echo($ligne["CLI_NOM"]); ?></td>
                        <td><?php echo($ligne["CLI_PRENOM"]); ?></td>
                        <td><?php echo($ligne["NB_RESERVATION"]); ?></td>
                    </tr>
                <?php
                }
            ?>
        </table>
        <br/>

        <h2>Clients avec le plus de réservations le mois dernier :</h2>
        <br/>

        <table class="tab">
            <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nb réservations</th>
            </tr>
            <?php 
                $request = "
                select  cli_num, cli_nom, cli_prenom, nb_reservation
                from (
                    select  cli_num, count(res_num) as nb_reservation
                    from (
                        select *
                        from vik_reservation
                        where to_number(to_char(res_date, 'mm')) = to_number(to_char(sysdate, 'mm')) - 1
                        order by res_date)
                    group by cli_num)
                join vik_client using(cli_num)
                where lower(cli_nom) <> 'non inscrit'
                order by nb_reservation desc, cli_num
                ";
        
                // Exécution de la requête SQL
                $result = $connexion->query($request);
        
                // Affichage des résultats de la requête SQL
                foreach ($result as $ligne) {
                    ?>
                        <tr>
                            <td><?php echo($ligne["CLI_NUM"]); ?></td>
                            <td><?php echo($ligne["CLI_NOM"]); ?></td>
                            <td><?php echo($ligne["CLI_PRENOM"]); ?></td>
                            <td><?php echo($ligne["NB_RESERVATION"]); ?></td>
                        </tr>
                    <?php
                    }
                ?>
                
        </table>
        <br/>

        <footer>
            <?php require_once("../../src/footer.php"); ?>
        </footer>
    </body>
</html>