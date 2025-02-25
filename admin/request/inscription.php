<pre>
    <?php

        require_once("../config/bdd.php");

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
                $tel = "";
            } else {
                $tel = "0033" . substr($_POST["tel"], 1);
            }
        }
        if (isset($_POST["motDePasse"])) {
            if (empty($_POST["motDePasse"])) {
                $motDePasse_message = "Ce champs doit être complété.";
            } else {
                $motDePasse = sha1(htmlspecialchars($_POST["motDePasse"]));
            }
        }
        if (isset($_POST["motDePasseVerif"])) {
            if (empty($_POST["motDePasseVerif"])) {
                $motDePasseVerif_message = "Ce champs doit être complété.";
            } elseif ($_POST["motDePasseVerif"] != $_POST["motDePasse"]) {
                $motDePasseVerif_message = "Les mots de passe doivent correspondre.";
            }
        }

        if (isset($prenom) && isset($nom) && isset($mail) && isset($ville) && isset($nom) && isset($tel) && isset($depNum)) {
            $requete = "
                SELECT MAX(CLI_NUM) + 1 AS NUM
                FROM VIK_CLIENT
            ";
            $resultat = $connexion->query($requete);
            $ligne = $resultat->fetch(PDO::FETCH_ASSOC);
            $num = $ligne["NUM"];
            $requete = "
                INSERT INTO VIK_CLIENT (CLI_NUM, TYP_NUM, DEP_NUM, CLI_NOM, CLI_PRENOM, CLI_VILLE, CLI_TELEPHONE, CLI_COURRIEL, CLI_NB_POINTS_EC, CLI_NB_POINTS_TOT, CLI_DATE_CONNEC, CLI_MDP)
                VALUES ($num, 1, '$depNum', '$nom', '$prenom', '$ville', '$tel', '$mail', 0, 0, SYSDATE, '$motDePasse')
            ";
            $connexion->exec($requete);
        }
    ?>
</pre>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../src/css/admin.css">
        
        <title>S'inscrire</title>
    </head>

    <body>
        <form method="POST" action="" class="container">
            <h1 class="title">Inscription</h1>
            <hr>
            <!-- prenom -->
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" <?php if (isset($_POST["prenom"])) echo("value='" . $_POST["prenom"] . "'" ); ?>/>
            <?php
                if (isset($prenom_message)) {
                    echo "<small>" . $prenom_message . "</small>";
                }
            ?>
            <br/> 
            <!-- nom -->
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" <?php if (isset($_POST["nom"])) echo("value='" . $_POST["nom"] . "'" ); ?>/>
            <?php
                if (isset($nom_message)) {
                    echo "<small>" . $nom_message . "</small>";
                }
            ?>
            <br/>
            <!-- departement -->
            <label for="depNum">Département :</label>
            <select name="depNum" id="depNum" <?php if (isset($_POST["depNum"])) echo("value='" . $_POST["deNum"] . "'" ); ?>>
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
                <option value="<?php echo($ligne["DEP_NUM"]); ?>"><?php echo($ligne["DEP_NOM"]); ?></option>
                <?php
                    }
                ?>
            </select>
            <br/>
            <!-- mail -->
            <label for="mail">Mail :</label>
            <input type="text" name="mail" id="mail" <?php if (isset($_POST["mail"])) echo("value='" . $_POST["mail"] . "'" ); ?>/>
            <?php
                if (isset($mail_message)) {
                    echo "<small>" . $mail_message . "</small>";
                }
            ?>
            <br/>
            <!-- ville -->
            <label for="ville">Ville :</label>
            <input type="text" name="ville" id="ville" <?php if (isset($_POST["ville"])) echo("value='" . $_POST["ville"] . "'" ); ?>/>
            <?php
                if (isset($ville_message)) {
                    echo "<small>" . $ville_message . "</small>";
                }
            ?>
            <br/>
            <!-- telephone -->
            <label for="tel">Numéro de téléphone :</label>
            <input type="tel" name="tel" id="tel" <?php if (isset($_POST["tel"])) echo("value='" . $_POST["tel"] . "'" ); ?>/>
            <?php
                if (isset($tel_message)) {
                    echo "<small>" . $tel_message . "</small>";
                }
            ?>
            <br/>
            <!-- mot de passe -->
            <label for="motDePasse">Mot de passe :</label>
            <input type="password" name="motDePasse" id="motDePasse"/>
            <?php
                if (isset($motDePasse_message)) {
                    echo "<small>" . $motDePasse_message . "</small>";
                }
            ?>
            <br/>
            <!-- verifie mot de passe -->
            <label for="motDePasseVerif">Vérification mot de passe :</label>
            <input type="password" name="motDePasseVerif" id="motDePasseVerif"/>
            <?php
                if (isset($motDePasseVerif_message)) {
                    echo "<small>" . $motDePasseVerif_message . "</small>";
                }
            ?>
            <br/>
            <button type="submit" >S'inscrire</button>

        </form>
    </body>
</html>