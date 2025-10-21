<?php

use Utils\Tools;

include './src/includes/autoload.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Intermédiaire</title>
    <?php
    include './src/Utils/head.php';
    ?>
</head>
<body data-bs-theme="dark">
    <header>
        <div class="container">
            <h1>PHP Intermédiaire</h1>
        </div>
    </header>
    <div class="container">
        <?php include './src/Widgets/navbar.php'; ?>
    </div>
    <main class="container">
        <section class="row">
            <article class="col-md-6">
                <header>
                    <h2>PDO</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    PDO ou "Php Data Object" est un moyen de se connecter à une base de données et un moyen
                    de manipuler cette bdd. Son avantage tient dans le fait qu'on utilise les mêmes méthodes pour
                    manipuler des bases de données différentes (MySql, PostGre, Oracle, etc.).
                </p>
                <h2>Connexion avec PDO</h2>
                <p>
                    Il faut pour se connecter :
                </p>
                <ul>
                    <li>L'hôte</li>
                    <li>le nom de la bdd</li>
                    <li>le charset utilisé dans la bdd</li>
                    <li>identifiant utilisateur bdd</li>
                    <li>mot de passe utilisateur bdd</li>
                </ul>
                <p>
                    new PDO("mysql:host=&lsaquo;nom de l'hôte&rsaquo;;dbname=&lsaquo;nom bdd&rsaquo;;
                    charset=&lsaquo;jeu de caractère bdd&rsaquo;", "&lsaquo;nom de l'utilisateur&rsaquo;",
                    "&lsaquo;mdp utilisateur&rsaquo;");
                </p>
                <code>
                    //exemple<br />
                    $bdd = new PDO("mysql:host=localhost;dbname=2025-07-07-php-inter;charset=UTF8", "root", "");
                </code>
                <h3>Tester la connexion</h3>
                <?php
                try{
                    $bdd = new PDO(
                        'mysql:host=localhost;dbname=2025-10-20-php-intermediaire;charset=UTF8', 
                        'root', 
                        '', 
                        array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
                        echo '<p>Connexion à la base de données réussie</p>';
                }catch(Exception $e){
                    echo '<p>Erreur de connexion : ' . $e->getMessage() . '</p>';
                }
                ?>
                <p>
                    On automatise avec la classe statique Tools la connexion à la BDD
                </p>
                <?php
                $bdd = Tools::setBdd();
                ?>
            </article>
            <article class="col-md-6">
                <header>
                    <h2>Requêter avec PDO</h2>
                </header>
                <p>
                    On peut utiliser la méthode query
                </p>
                <code>
                    $response = $bdd->query("SELECT * FROM `jeux_video`");
                </code>
                <?php
                $response = $bdd->query('SELECT * FROM `jeux_video`');
                var_dump($response);
                var_dump($response->queryString);
                ?>
                <p>
                    $response contient désormais le jeu d'enregistrements récupéré via la requête.
                    On ne peut pas exploiter $response directement, il va falloir utliser les méthodes
                    de PDO désormais utilisables avec $response.
                </p>
                <p>
                    <code>
                        $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);<br />
                        print_r($unEnregistrement);<br />
                        $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);<br />
                        print_r($unEnregistrement);<br />
                        $unEnregistrement = $response->fetch(PDO::FETCH_BOTH);<br />
                        print_r($unEnregistrement);
                    </code>
                </p>
            </article>
            <article class="col-md-6">
                <?php
                echo '<pre>';
                $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);
                print_r($unEnregistrement);
                $unEnregistrement = $response->fetch(PDO::FETCH_NUM);
                print_r($unEnregistrement);
                $unEnregistrement = $response->fetch(PDO::FETCH_BOTH);
                print_r($unEnregistrement);
                echo '</pre>';
                ?>
            </article>
            <article class="col-md-6">
                <p>
                    Il faut, selon le mode de récupération des données (la constante FETCH_...), indiquer dans la réponse la clef de la données de l'enretitrement
                </p>
                <?php
                echo '<pre>';
                print_r($unEnregistrement['nom']);
                echo '</pre>';
                echo '<pre>';
                print_r($unEnregistrement[7]);
                echo '</pre>';
                ?>
                <p>
                    fetch() renvoie l'enregistrement actuel où se trouve le curseur dans le jeu d'enregistrement.
                    Une fois qu'il a renvoyé les données, le curseur passe à l'enregistrement suivant.
                </p>
                <p>
                    Il faut, une fois qu'on a fini d'utiliser les données, "fermer" le curseur.
                </p>
                <code>
                    $response->closeCursor();
                </code>
                <p>
                    Si on essaie de récupérer des données de la réponse après la fermeture du curseur, on obtient l'erreur suivante : 
                </p>
                <?php
                $response->closeCursor();
                $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);
                print_r($unEnregistrement['nom']);
                ?>
            </article>
            <article class=" my-5">
                <header>
                    <h2 id="tabJeux">Exploiter les résultats</h2>
                </header>
                <p>
                    Maintenant, on relance la requête et on va afficher les résultats
                    dans un tableau généré par une boucle
                </p>
                <?php
                /*  lancer la requête suivante SELECT * FROM `Jeux_video` ORDER BY `ID` DESC */
                $response = Tools::queryBDD('SELECT * FROM `jeux_video` ORDER BY `ID` DESC');
                ?>
                <div class="table-responsive" style="height: 300px;">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Possesseur</th>
                                <th>Prix</th>
                                <th>Console</th>
                                <th>nb joueurs max</th>
                                <th>Commentaire(s)</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* on parcour les enregistrements reçus */
                            while($donnees = $response->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <tr>
                                    <td><?= $donnees['nom'] ?></td>
                                    <td><?= $donnees['possesseur'] ?></td>
                                    <td><?= $donnees['prix'] ?></td>
                                    <td><?= $donnees['console'] ?></td>
                                    <td><?= $donnees['nbre_joueurs_max'] ?></td>
                                    <td><?= $donnees['commentaires'] ?></td>
                                    <td style="width: 250px;">
                                        <a href="./actionJV.php?action=mod&idJV=<?= $donnees['ID'] ?>"><button class="btn btn-primary">Modifier</button></a> 
                                        <a href="./actionJV.php?action=sup&idJV=<?= $donnees['ID'] ?>"><button class="btn btn-danger">Supprimer</button></a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                $response->closeCursor();
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les requêtes préparées</h2>
                </header>
                <p>
                    Si on veut pouvoir choisir des paramètres pour la recherche (comme des filtres), il faut utiliser
                    les méthodes PDO de préparation de requête.
                </p>
                <?php
                /* Lier par clef dans la requête */
                $sql = 'SELECT * FROM `jeux_video` WHERE `ID` = :id;';
                $response = $bdd->prepare($sql);
                $idJeux = 1;
                $response->bindParam(':id', $idJeux, PDO::PARAM_INT);
                $response->execute();
                echo '<pre>';
                $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);
                print_r($unEnregistrement);
                echo '</pre>';

                /* Lier par ordre dans la requête */
                $sql = 'SELECT * FROM `jeux_video` WHERE `ID` = ? AND 1 = ? ;';
                $response = $bdd->prepare($sql);
                $idJeux = 1;
                $secondParam = 1;
                $response->bindParam(1, $idJeux, PDO::PARAM_INT);
                $response->bindParam(2, $secondParam, PDO::PARAM_INT);
                $response->execute();
                echo '<pre>';
                $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);
                print_r($unEnregistrement);
                echo '</pre>';

                /* lier par clef dans la requête avec plusieurs paramètres dans execute */
                $sql = 'SELECT * FROM `jeux_video` WHERE `ID` = :id AND `possesseur` LIKE :possesseur;';
                $response = $bdd->prepare($sql);
                $response->execute(
                    ['id' => 1, 'possesseur' => 'Florent']
                );
                echo '<pre>';
                $unEnregistrement = $response->fetch(PDO::FETCH_ASSOC);
                print_r($unEnregistrement);
                echo '</pre>';
                ?>
            </article>
            <article class="col-md-6">
                <h3 id="search">Recherche jeux</h3>
                <form action="./pdo.php#search">
                    <fieldset class="form-group my-2">
                        <label for="possesseur" class="form-label">Possesseur</label>
                        <input type="text" class="form-control" name="possesseur" id="possesseur" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="prixmax" class="form-label">Prix Maximum</label>
                        <input type="text" class="form-control" name="prixmax" id="prixmax" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="console" class="form-label">Console</label>
                        <input type="text" class="form-control" name="console" id="console" />
                    </fieldset>
                    <p class="my-2">
                        <button class="btn btn-outline-primary" name="soumettre" type="submit" value="soumettre">Rechercher</button>
                    </p>
                </form>
                <?php
                $tabFields = [];
                $tabConditions = [];
                $conditions = '';
                /* quand le formulaire est soumis */
                if( isset($_GET['soumettre']) && $_GET['soumettre'] === 'soumettre'){
                    if(isset($_GET['possesseur']) && $_GET['possesseur'] !== ''){
                        $tabFields['possesseur'] = $_GET['possesseur'];
                        $tabConditions[] = ' `possesseur` = :possesseur ';
                    }
                    
                    if(isset($_GET['prixmax']) && $_GET['prixmax'] !== ''){
                        $tabFields['prixmax'] = $_GET['prixmax'];
                        $tabConditions[] = ' `prix` <= :prixmax ';
                    }
                    
                    if(isset($_GET['console']) && $_GET['console'] !== ''){
                        $tabFields['console'] = $_GET['console'];
                        $tabConditions[] = ' `console` = :console ';
                    }

                    /*
                    var_dump($tabFields);
                    var_dump($tabConditions);
                    */

                    if( count($tabConditions) > 0){
                        for($i = 0; $i < count($tabConditions); $i++){
                            $conditions .= ($i === 0)? ' WHERE ' : ' AND ' ;
                            $conditions .= $tabConditions[$i];
                        }
                    }
                }

                $sql = 'SELECT * FROM `jeux_video` ' .  $conditions . ' ORDER BY `nom`;' ;
                /*var_dump($sql);*/
                $req = $bdd->prepare($sql);
                $req->execute($tabFields);

                ?>
                <div class="table-responsive" style="height: 300px;">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Jeu</th>
                                <th>Possesseur</th>
                                <th>Prix</th>
                                <th>Console</th>
                                <th>nb joueurs max</th>
                                <th>Commentaire(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* on parcour les enregistrements reçus */
                            while($donnees = $req->fetch(PDO::FETCH_ASSOC)){
                            ?>
                                <tr>
                                    <td><?= $donnees['nom'] ?></td>
                                    <td><?= $donnees['possesseur'] ?></td>
                                    <td><?= $donnees['prix'] ?></td>
                                    <td><?= $donnees['console'] ?></td>
                                    <td><?= $donnees['nbre_joueurs_max'] ?></td>
                                    <td><?= $donnees['commentaires'] ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                $req->closeCursor();
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Manipulation des enregistrements</h2>
                </header>
                <h3>Ajoût de données</h3>
                <form method="post" action="./pdo.php#tabJeux">
                    <!--  action="./pdo.php#tabJeux" -->
                    <fieldset class="form-group my-2">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" id="nom" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="possesseur" class="form-label">Possesseur</label>
                        <input type="text" class="form-control" name="possesseur" id="possesseur" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="console" class="form-label">Console</label>
                        <input type="text" class="form-control" name="console" id="console" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="prix" class="form-label">Prix</label>
                        <input type="text" class="form-control" name="prix" id="prix" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="nbre_joueurs_max" class="form-label">Nombre de joueurs max</label>
                        <input type="text" class="form-control" name="nbre_joueurs_max" id="nbre_joueurs_max" />
                    </fieldset>
                    <fieldset class="form-group my-2">
                        <label for="commentaires" class="form-label">Commentaire</label>
                        <input type="text" class="form-control" name="commentaires" id="commentaires" />
                    </fieldset>
                    <p class="my-2">
                        <button class="btn btn-outline-primary" name="ajoutJeu" type="submit" value="ajoutJeu">Ajouter le jeu</button>
                    </p>
                </form>
                <?php
                /*var_dump($_POST);*/
                if( isset($_POST['ajoutJeu']) && $_POST['ajoutJeu'] === 'ajoutJeu' ){
                    $params = $_POST;
                    unset($params['ajoutJeu']);
                    /*var_dump($params);*/

                    /*
                    INSERT INTO `table` 
                    ( `COLUMN` ) VALUES ( valeurs ) ;
                    */

                    $keys = '(';
                    $values = '(';
                    $firstParam = true;
                    foreach($params as $key => $value){
                        if(!$firstParam){
                            $keys .= ', ';
                            $values .= ', ';
                        }
                        $firstParam = false;
                        $keys .= $key;
                        $values .= ':'.$key;
                    }
                    $keys .= ')';
                    $values .= ')';

                    /*
                    var_dump($keys);
                    var_dump($values);
                    */

                    $sql = 'INSERT INTO `jeux_video` '. $keys . ' VALUES ' . $values . ';';

                    /*var_dump($sql);*/
                    $req = $bdd->prepare($sql);
                    $req->execute($params) or die(var_dump($bdd->errorInfo()));
                    ?>
                    <script>
                        document.location.href= './pdo.php';
                    </script>
                    <?php
                }
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/Widgets/footer.php';
    ?>
</body>
</html>