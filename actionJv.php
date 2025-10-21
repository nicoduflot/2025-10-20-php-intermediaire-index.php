<?php

use Utils\Tools;

include './src/includes/autoload.php';

$formMod = false;
$formSup = false;
$modBdd = false;
$id = '';
if( isset($_GET['action']) && $_GET['action'] !== '' && isset($_GET['idJV']) && $_GET['idJV'] !== '' ){
    $idJV = $_GET['idJV'];
    $formMod = ($_GET['action'] === 'mod');
    $formSup = ($_GET['action'] === 'sup');

    $sql = 'SELECT * FROM `jeux_video` WHERE `ID` = :id ';
    $params = ['id' => $idJV];
    $req = Tools::queryBDD($sql, $params);

    if( !$infosJeu = $req->fetch(PDO::FETCH_ASSOC) ){
        $nom = '';
        $possesseur = '';
        $console = '';
        $prix = '';
        $nbr_joueurs_max = '';
        $commentaires = '';
        $id = '';
    }else{
        $nom = $infosJeu['nom'];
        $possesseur = $infosJeu['possesseur'];
        $console = $infosJeu['console'];
        $prix = $infosJeu['prix'];
        $nbre_joueurs_max = $infosJeu['nbre_joueurs_max'];
        $commentaires = $infosJeu['commentaires'];
        $id = $infosJeu['ID'];
    }
}

/* Cas modification ou suppression ou demande non traitée */

if(isset($_POST['modBdd'])){
    switch($_POST['modBdd']){
        case 'modJeu':
            $sql = '
                UPDATE 
                    `jeux_video` 
                SET 
                    `nom` = :nom,
                    `possesseur` = :possesseur,
                    `console` = :console,
                    `prix` = :prix,
                    `nbre_joueurs_max` = :nbre_joueurs_max,
                    `commentaires` = :commentaires,
                    `date_modif` = now() 
                WHERE 
                    `ID` = :ID
            ';
            $modBdd = true;
        break;
        case 'supJeu':
            $sql = '
                DELETE FROM 
                    `jeux_video` 
                WHERE 
                    `ID` = :ID
            ';
            $modBdd = true;
        break;
        default:
            $modBdd = false;
    }
}

if($modBdd){
    $params = $_POST;
    unset($params['modBdd']);
    Tools::queryBDD($sql, $params);
    header('location: ./pdo.php');
}

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
        <section>
            <article>
                <header>
                    <h2>Gestion des jeux</h2>
                </header>
                <?php
                /* Modification d'un jeu */
                if($formMod && $id !== ''){
                ?>
                    <h3>Modifier le jeu </h3>
                    <form method="post" action="./actionJV.php">
                        <input type="hidden" name="ID" value="<?= $id ?>" />
                        <fieldset class="form-group my-2">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" name="nom" id="nom" value="<?= $nom ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="possesseur" class="form-label">Possesseur</label>
                            <input type="text" class="form-control" name="possesseur" id="possesseur" value="<?= $possesseur ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="console" class="form-label">Console</label>
                            <input type="text" class="form-control" name="console" id="console" value="<?= $console ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="prix" class="form-label">Prix</label>
                            <input type="text" class="form-control" name="prix" id="prix" value="<?= $prix ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="nbJmax" class="form-label">Nombre de joueurs max</label>
                            <input type="text" class="form-control" name="nbre_joueurs_max" id="nbre_joueurs_max" value="<?= $nbre_joueurs_max ?>" />
                        </fieldset>
                        <fieldset class="form-group my-2">
                            <label for="commentaires" class="form-label">Commentaire</label>
                            <input type="text" class="form-control" name="commentaires" id="commentaires" value="<?= $commentaires ?>" />
                        </fieldset>
                        <p class="my-2">
                            <button class="btn btn-outline-primary" name="modBdd" type="submit" value="modJeu">Modifier le jeu</button>
                        </p>
                    </form>
                <?php
                }
                /* Suppression d'un jeu */
                if($formSup && $id !== ''){
                ?>
                    <h3>Supprimer le jeu </h3>
                    <form method="post" action="./actionJV.php">
                        <input type="hidden" name="ID" value="<?= $id ?>" />
                        Êtes-vous sûr de vouloir supprimer le jeu suivant : <b><?= $nom ?></b> ?
                        <p class="my-2">
                            <button class="btn btn-outline-danger" name="modBdd" type="submit" value="supJeu">Supprimer le jeu</button>
                            <a href="./pdo.php"><button class="btn btn-outline-secondary" type="button">Annuler</button></a>
                        </p>
                    </form>
                <?php
                }
                /* le jeu n'existe pas */
                if($id === '' && $modBdd === false){
                    ?>
                    <h3>Le jeu recherché n'existe pas</h3>
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