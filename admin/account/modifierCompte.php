<pre>
    <?php

        require_once("../config/bdd.php");
        
        if (isset($_GET["num"])) {
            if (is_numeric($_GET["num"])) {
                $cli_num = $_GET["num"];
                $requete = "
                    SELECT CLI_PRENOM, CLI_NOM, DEP_NUM, CLI_VILLE, CLI_TELEPHONE, CLI_COURRIEL
                    FROM VIK_CLIENT
                    WHERE CLI_NUM = $cli_num
                ";
                $resultat = $connexion->query($requete);
                $ligne = $resultat->fetch(PDO::FETCH_ASSOC);

                if (!empty($ligne)) {
                    $cli_prenom = $ligne["CLI_PRENOM"];
                    $cli_nom = $ligne["CLI_NOM"];
                    $cli_dep = $ligne["DEP_NUM"];
                    $cli_ville = $ligne["CLI_VILLE"];
                    $cli_tel = $ligne["CLI_TELEPHONE"];
                    $cli_mail = $ligne["CLI_COURRIEL"];
                } else {
                    unset($cli_num);
                }
            }
        }

        if (isset($_POST["prenom"])) {
            if (empty($_POST["prenom"])) {
                $prenom_message = "Ce champs doit être complété.";
            } elseif (!preg_match("/^[[:alpha:]ÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇàâäéèêëïîôöùûüÿç\-\s]+$/i", $_POST["prenom"])) {
                $prenom_message = "Ce champs doit contenir que des lettres.";
            } else {
                $prenom = htmlspecialchars($_POST["prenom"]);
            }
        }
        if (isset($_POST["nom"])) {
            if (empty($_POST["nom"])) {
                $nom_message = "Ce champs doit être complété.";
            } elseif (!preg_match("/^[[:alpha:]ÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇàâäéèêëïîôöùûüÿç\-\s]+$/i", $_POST["nom"])) {
                $nom_message = "Ce champs doit contenir que des lettres.";
            }
            $nom = htmlspecialchars($_POST["nom"]);
        }
        if (isset($_POST["mail"])) {
            if (empty($_POST["mail"])) {
                $mail_message = "Ce champs doit être complété.";
            } elseif (!preg_match("/^[a-zA-Z.]+@[a-zA-Z]+\.[a-zA-Z]+$/i", $_POST["mail"])) {
                $mail_message = "Entrez une adresse mail valide. Exemple : \"toto@mail.com\"";
            } else {
                $mail = htmlspecialchars(strtolower($_POST["mail"]));
            }
        }
        if (isset($_POST["ville"])) {
            if (empty($_POST["ville"])) {
                $ville_message = "Ce champs doit être complété.";
            } elseif (!preg_match("/^[[:alpha:]ÀÂÄÉÈÊËÏÎÔÖÙÛÜŸÇàâäéèêëïîôöùûüÿç\-\s]+$/i", $_POST["ville"])) {
                $ville_message = "Entrez un nom de ville valide";
            } else {
                $ville = htmlspecialchars($_POST["ville"]);
            }            
        }
        if (isset($_POST["depNum"])) {
            if (!empty($_POST["ville"])
            && empty($_POST["depNum"])) {
                $depNum_message = "Entrez un numéro de département.";
            } elseif (!preg_match("/^[0-9 ]{3}$/", $_POST["depNum"])) {
                $depNum_message = "Entrez un numéro de département valide.";
            } else {
                $depNum = $_POST["depNum"];
            }
        }
        if (isset($_POST["tel"])) {
            if (!empty($_POST["tel"]) && !preg_match("/^[0-9]{10}$/", $_POST["tel"])) {
                $tel_message = "Entrez un numéro de téléphone valide.";
            } elseif (empty($_POST["tel"])) {
                $tel = "NULL";
            } else {
                $tel = "033" . substr($_POST["tel"], 1);
            }
        }

        if (isset($cli_num) && isset($prenom) && isset($nom) && isset($mail) && isset($ville) && isset($tel) && isset($depNum)) {
            $requete = "
                UPDATE VIK_CLIENT
                SET CLI_NOM = '$nom', CLI_PRENOM = '$prenom', CLI_COURRIEL = '$mail',
                    CLI_VILLE = '$ville', CLI_TELEPHONE = $tel, DEP_NUM = $depNum
                WHERE CLI_NUM = $cli_num
            ";
            $connexion->exec($requete);
            // Revenir à la page précédente
            header("Location: voirCompte.php");
        }
    ?>
</pre>
<?php
    if (isset($cli_num)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier compte</title>
    <link rel="stylesheet" href="../../src/css/menus.css">
        <link rel="stylesheet" href="../../src/css/admin.css">
        <link rel="stylesheet" href="../../src/css/style.css">
</head>
<body>
<form method="POST" action="">
    <?php require_once("../../src/header.php"); ?>
    <div class="container">
        <h1 class="title">Modification du compte</h1>
        <hr>
        <!-- prenom -->
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" <?php if (isset($cli_prenom)) echo("value='" . $cli_prenom . "'" ); ?>/>
        <?php
            if (isset($prenom_message)) {
                echo "<small>" . $prenom_message . "</small>";
            }
        ?>
        <br/>
        <!-- nom -->
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" <?php if (isset($cli_nom)) echo("value='" . $cli_nom . "'" ); ?>/>
        <?php
            if (isset($nom_message)) {
                echo "<small>" . $nom_message . "</small>";
            }
        ?>
        <br/>
        <!-- departement -->
        <label for="depNum">Département :</label>
        <select name="depNum" id="depNum" <?php if (isset($cli_dep)) echo("value='" . $cli_dep . "'" ); ?>>
        <?php
            if (isset($depNum_message)) {
                echo "<small>" . $depNum_message . "</small>";
            }
        ?>
            <?php
                $requete = "
                    SELECT DEP_NUM, DEP_NOM
                    FROM VIK_DEPARTEMENT
                ";
                $resultat = $connexion->query($requete);
                foreach ($resultat as $ligne) {
            ?>
            <option value="<?php echo($ligne["DEP_NUM"]); ?>"<?php if (isset($cli_dep) && $ligne["DEP_NUM"] == $cli_dep) echo("selected='selected'") ?>><?php echo($ligne["DEP_NOM"]); ?></option>
            <?php
                }
            ?>
        </select>
        <br/>
        <!-- mail -->
        <label for="mail">Mail :</label>
        <input type="mail" name="mail" id="mail" <?php if (isset($cli_mail)) echo("value='" . $cli_mail . "'" ); ?>/>
        <?php
            if (isset($mail_message)) {
                echo "<small>" . $mail_message . "</small>";
            }
        ?>
        <br/>
        <!-- ville -->
        <label for="ville">Ville :</label>
        <input type="text" name="ville" id="ville" <?php if (isset($cli_ville)) echo("value='" . $cli_ville . "'" ); ?>/>
        <?php
            if (isset($ville_message)) {
                echo "<small>" . $ville_message . "</small>";
            }
        ?>
        <br/>
        <!-- telephone -->
        <label for="tel">Téléphone :</label>
        <input type="tel" name="tel" id="tel" <?php if (isset($cli_tel)) echo("value='0" . substr($cli_tel, 4) . "'" ); ?>/>
        <?php
            if (isset($tel_message)) {
                echo "<small>" . $tel_message . "</small>";
            }
        ?>
        <input type="hidden" name="num" value="<?php if (isset($cli_num)) echo($cli_num); ?>"/>
        <br/>
        <button type="submit">Changer les informations</button>
    </div>
</form>


</body>
</html>
<?php
    } else {
?>
<p>Aucun client sélectionné</p>
<?php
    }
?>