<?php session_start(); ?> 

<header>
    <?php 
        $cheminAbsolu = realpath(__DIR__ . '/../admin/config/bdd.php');
        require_once($cheminAbsolu);
    ?>


    <?php if (!isset($_SESSION["prenom"])) { ?>
        <nav class="wrapper">
            <ul class="menuClient">
                <li class="actif">
                    <a href="../src/index.php" title="">Accueil</a>
                </li>
                <li>
                
                    <a href="../src/lignesReseau.php" title="">Lignes du réseau</a>
                </li>
                <li>
                    <a href="../src/planReseau.php" title="">Carte du réseau</a>
                </li>
                <li>
                    <a href="../admin/request/reserver.php" title="">Réserver mon billet</a>
                </li>
                <li>
                    <a href="../src/vikingTransport.php" title="">À propos de Viking Transport</a>
                </li>

                <input class="connexion" onClick="window.location.href='../admin/request/seConnecter.php';" type="button" value="Se connecter">
            </ul>
        </nav>
    <?php } ?>

    <?php 
        require_once(__DIR__ . '/../admin/config/estAdmin.php');
        if (isset($_SESSION["prenom"])) {
            ?>
            <nav class="wrapper">
                
                <?php if (estAdmin()) { ?>
                    <ul class="menuAdmin">
                        <li class="actif">
                            <a href="../src/index.php" title="">Accueil</a>
                        </li>
                        <li>
                            <a href="../src/lignesReseau.php" title="">Lignes du réseau</a>
                        </li>
                        <li>
                            <a href="../src/planReseau.php" title="">Carte du réseau</a>
                        </li>
                        <li>
                            <a href="../admin/account/voirCompte.php" title="">Voir comptes clients</a>
                        </li>
                        <li>
                            <a href="../src/voirStats.php" title="">Voir statistiques</a>
                        </li>
                        <li>
                            <a href="../src/vikingTransport.php" title="">À propos de Viking Transport</a>
                            
                        </li>
                        <input class="deconnexionAdmin" onClick="window.location.href='../admin/config/deconnexion.php';"type="button" value="Se déconnecter">

                    </ul>
                    <?php } else {?> 
                    <ul class="menuClient">
                        <li class="actif">
                            <a href="../src/index.php" title="">Accueil</a>
                        </li>
                        <li>
                            <a href="../src/lignesReseau.php" title="">Lignes du réseau</a>
                        </li>
                        <li>
                            <a href="../src/planReseau.php" title="">Carte du réseau</a>
                        </li>
                        <li>
                            <a href="../admin/request/reserver.php" title="">Réserver mon billet</a>
                        </li>
                        <li>
                            <a href="../user/monCompte.php" title="">Voir mon compte</a>
                        </li>
                        <li>
                            <a href="classements.php" title="">Trouver un trajet</a>
                        </li>
                        <li>
                            
                            <a href="../src/vikingTransport.php" title="">À propos de Viking Transport</a>
                        </li>
                        <input class="deconnexionClient" onClick="window.location.href='../admin/config/deconnexion.php';"type="button" value="Se déconnecter">
                    </ul>
                <?php }  ?>
            <?php }?>
        </nav>
</header>