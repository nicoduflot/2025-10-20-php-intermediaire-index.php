<?php
/* Lancer la session php pour utiliser $_SESSION */

use Utils\Tools;

session_start();
/*require_once './src/Classes/Banque/Compte.php';*/
include './src/includes/autoload.php';

/*use App\Compte\Compte;*/

/*$monCompte = unserialize($_SESSION['monCompte']);*/

/*
var_dump($monCompte);
var_dump($monCompte->getNom());
*/

/* la création de fichier est lancée */
if(isset($_POST['createFile']) && $_POST['createFile'] === 'Envoyer'){
    if( isset($_POST['titre']) && $_POST['titre'] !== ''){
        date_default_timezone_set('Europe/Paris');
        /*
        On va utiliser le tite pour générer le nom de fichier
        Mais les noms de fichiers ne doivent généralement pas contenir : 
            espace, caractères spéciaux, etc.
        => utiliser une fonction maison pour créer un slug du titre
        */
        $slug = Tools::makeSlug($_POST['titre']);
        echo $slug.'<br />';
        $dirYear = date('Y');
        $dirMonth = date('m');
        $prefixFile = date('d-h-i');
        $fileName = $prefixFile.'-'.$slug;
        echo $prefixFile.'<br />';
        echo $fileName.'<br />';
        $pathDir = './files/wiki/'. $dirYear . '/' . $dirMonth;
        $pathFile = $pathDir . '/' . $fileName.'.txt';
        echo $pathFile.'<br />';
        /* création des répéertoires s'ils n'existent pas */
        if(!file_exists($pathFile)){
            mkdir($pathDir, 0777, true);
        }
        /* création du fichier texte */
        if(!$file = fopen($pathFile, 'w+b')){
            echo 'Impossible de créer le fichier '.$pathFile.'<br />';
        }else{
            fwrite($file, $_POST['titre'].PHP_EOL);
            fwrite($file, $_POST['message']);
            fclose($file);
            header('location: ./formulaire.php');
        }
    }
}

/* téléversement de fichiers */
$messageUpload = '';
if( isset($_POST['uploadFile']) && $_POST['uploadFile'] === 'Charger'){
    $uploadDir = './uploads/';
    /*var_dump(basename($_FILES['fichier']['name']));*/
    $uploadFile = $uploadDir.basename($_FILES['fichier']['name']);
    /*echo $uploadFile;*/
    if(!file_exists($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }
    /* gestion fichiers en doublon */
    if(file_exists($uploadFile)){
        $uploadFile = $uploadDir.'copy-'.basename($_FILES['fichier']['name']);
    }

    if(move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadFile)){
        $messageUpload = 'Votre fichier '. $_FILES['fichier']['name'] .' a bien été téléversé.';
        $upload = true;
    }else{
        $messageUpload = 'Fichier erroné ou erreur de téléversement';
    }
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
        <section class="row">
            <article class="col-md-6">
                <header>
                    <h2>Traitement des formulaires</h2>
                </header>
                <p>
                    Les formulaires servent a récupérer des informations pour traitement, par exemple, un serveur
                    php qui pourra les enregistrer en fichier, en bdd, ou les envoyer par mail.
                </p>
                <p>
                    Un formulaire se déclare à l'aide de la balise <code>form</code>. Il possède des
                    attributs,
                    dont les plus courants et importants sont : <code>method</code> & <code>action</code>
                </p>
                <h3>method</h3>
                <p>
                    C'est la méthode d'envoi des informations du formulaire, il en existe deux :
                </p>
                <ul>
                    <li>GET : les données sont envoyées associées à des
                        noms de variables dans l'url de la page de traitement</li>
                    <li>POST : Les données sont transmises en variables dans
                        l'entête HTTP.
                    </li>
                </ul>
                <p>
                    Si la méthode n'est pas indiquée dans le formulaire,
                    c'est GET qui sera utilisé par défaut
                </p>
                <h3>Action</h3>
                <p>
                    Indique l'url de la page de traitement des données envoyées par le formulaire.
                    Si action n'est pas précisé, le formulaire considère que c'est la page où il
                    se trouve qui sera la page de traitement.
                </p>
                <form method="post" action="./formulaire.php">
                    <fieldset>
                        <legend>
                            Civilité
                        </legend>
                        <p>
                            <label class="form-label" for="nom">Nom</label> : <input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom ici" aria-describedby="info-nom" required />
                        </p>
                        <div id="info-nom" class="alert alert-info">
                            Ce champ doit contenir votre nom d'usage, il est obligatoire.
                        </div>
                        <div id="alert-nom" class="alert alert-warning">
                            Vous devez remplir ce champ pour soumettre le formulaire.
                        </div>
                        <p>
                            <label class="form-label" for="email">Email</label> : <input class="form-control" type="text" name="email" id="email" placeholder="Votre email ici" aria-describedby="info-email" required />
                        </p>
                        <div id="info-email" class="alert alert-info">
                            Ce champ doit contenir votre email de contact, il est obligatoire.
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Description de votre demande</legend>
                        <p>
                            <label class="form-label" for="type-demande">Type de la demande</label>
                            <select class="form-select" name="type-demande" id="type-demande" aria-describedby="info-type-demande" required>
                                <option value="" selected>Choisir le type de la demande</option>
                                <optgroup label="Options unitaires">
                                    <option value="1">Opt 1</option>
                                    <option value="2">Opt 2</option>
                                    <option value="3">Opt 3</option>
                                    <option value="4">Opt 4</option>
                                    <option value="5">Opt 5</option>
                                </optgroup>
                                <optgroup label="Regroupement d'options">
                                    <option value="6">Tout sauf l'option 1</option>
                                    <option value="7">Tout sauf l'option 2</option>
                                    <option value="8">Tout sauf l'option 3</option>
                                </optgroup>
                            </select>
                        </p>
                        <div class="alert alert-info" id="info-type-demande">
                            Vous devez sélectionner le type de la demande, ce champ est obligatoire.
                        </div>
                        <p>
                            Vous représentez :
                        </p>
                        <p class="form-check">
                            <input class="form-check-input" type="radio" name="personne" id="physique" value="physique" checked aria-describedby="info-personne" /> <label class="form-check-label" class="form-label" for="physique">Personne Physique</label><br />
                            <input class="form-check-input" type="radio" name="personne" id="morale" value="morale" aria-describedby="info-personne" /> <label class="form-check-label" class="form-label" for="morale">Personne Morale</label>
                        </p>
                        <div class="alert alert-info" id="info-personne">
                            Votre demande est faîte pour un particulier (personne physique) ou une institution, asso, entreprise, etc(Personne Morale).
                        </div>
                        <p class="form-check">
                            <input class="form-check-input" type="checkbox" name="diff-email" id="diff-email" aria-describedby="info-diff" /> <label class="form-check-label" class="form-label" for="diff-email">Campagne d'emailing</label><br />
                            <input class="form-check-input" type="checkbox" name="diff-tel" id="diff-tel" aria-describedby="info-diff" /> <label class="form-check-label" class="form-label" for="diff-tel">Télé-opérateurs</label><br />
                            <input class="form-check-input" type="checkbox" name="diff-radio" id="diff-radio" aria-describedby="info-diff" /> <label class="form-check-label" class="form-label" for="diff-radio">Publicités radiophoniques</label><br />
                            <input class="form-check-input" type="checkbox" name="diff-tv" id="diff-tv" aria-describedby="info-diff" /> <label class="form-check-label" class="form-label" for="diff-tv">Publicités télévisuelles</label><br />
                        </p>
                        <label class="form-label" for="detail">Détail de vorte demande</label>
                        <p>
                            <textarea class="form-control" name="detail" id="detail" aria-describedby="info-detail" required></textarea>
                        </p>
                        <div class="alert alert-info" id="info-detail">
                            Veuillez préciser votre demande, ce champ est obligatoire
                        </div>
                    </fieldset>
                    <p>
                        <button class="btn btn-outline-success btn-sm" type="submit" name="formeSent" value="Envoyer">Envoyer</button>
                        <button class="btn btn-outline-warning btn-sm" type="reset">Vider le formulaire</button>
                    </p>
                </form>
            </article>
            <article class="col-md-6">
                <?php
                var_dump($_POST);
                /* le formulaire a été envoyé et est correct */
                if( isset($_POST['formeSent']) && $_POST['formeSent'] === 'Envoyer' ){
                    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
                    $email = isset($_POST['email']) ? $_POST['email'] : '';
                    $typeDemande = isset($_POST['type-demande']) ? $_POST['type-demande'] : '';
                    $personne = isset($_POST['personne']) ? $_POST['personne'] : '';
                    $diffEmail = isset($_POST['diff-email']) ? $_POST['diff-email'] : '';
                    $diffTel = isset($_POST['diff-tel']) ? $_POST['diff-tel'] : '';
                    $diffRadio = isset($_POST['diff-radio']) ? $_POST['diff-radio'] : '';
                    $diffTv = isset($_POST['diff-tv']) ? $_POST['diff-tv'] : '';
                    $details = isset($_POST['details']) ? $_POST['details'] : '';
                    ?>
                    <div class="h4">Résultats du formulaire</div>
                    <p>
                        <?= $nom  ?>
                    </p>
                    <p>
                        <?= $email ?>
                    </p>
                    <p>
                        <?= $typeDemande ?>
                    </p>
                    <p>
                        <?= $personne ?>
                    </p>
                    <p>
                        Emailling : <?= $diffEmail ?> <br />
                        Téléphone : <?= $diffTel ?> <br />
                        Radio : <?= $diffRadio ?> <br />
                        TV : <?= $diffTv ?> <br />
                    </p>
                    <p>
                       <?= $details ?>
                    </p>
                    <?php
                }
                ?>
                <h2>Les fichiers</h2>
                <h3>Ouverture et fermeture d'un fichier</h3>
                <p>
                    fopen() et fclose()
                </p>
                <?php
                if(!$monFichierTexte = fopen('./files/file.txt', 'r')){
                    echo '<p>Echec lors de l\'ouverture du fichier</p>';
                }else{
                    echo '<p>Le fichier est présent et ouvert</p>';
                    fclose($monFichierTexte);
                }
                ?>
                <h5>Les options d'ouverture de fichier</h5>
                <table class="table table-dark table-striped">
                    <caption>
                        <b>
                            Liste des modes possibles pour la fonction <span><b>fopen()</b></span> en utilisant
                            le paramètre <code class="parameter">mode</code>
                        </b>
                    </caption>
                    <thead>
                        <tr>
                            <th><code>mode</code></th>
                            <th>Description</th>
                        </tr>

                    </thead>

                    <tbody>
                        <tr>
                            <td><code>&#039;r&#039;</code></td>
                            <td>
                                Ouvre en lecture seule et place le pointeur de fichier au
                                début du fichier.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;r+&#039;</code></td>
                            <td>
                                Ouvre en lecture et écriture et place le pointeur de
                                fichier au début du fichier.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;w&#039;</code></td>
                            <td>
                                Ouvre en écriture seule ; place le pointeur de fichier au
                                début du fichier et réduit la taille du fichier à 0.
                                Si le fichier n&#039;existe pas, on tente de le créer.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;w+&#039;</code></td>
                            <td>
                                Ouvre en lecture et écriture ; le comportement est
                                le même que pour <code>&#039;w&#039;</code>.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;a&#039;</code></td>
                            <td>
                                Ouvre en écriture seule ; place le pointeur de fichier à
                                la fin du fichier. Si le fichier n&#039;existe pas, on tente
                                de le créer. Dans ce mode, la fonction <code>fseek()</code>
                                n&#039;a aucun effet, les écritures surviennent toujours.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;a+&#039;</code></td>
                            <td>
                                Ouvre en lecture et écriture ; place le pointeur de fichier
                                à la fin du fichier. Si le fichier n&#039;existe pas, on tente
                                de le créer. Dans ce mode, la fonction <code>fseek()</code>
                                n&#039;affecte que la position de lecture, les écritures sont toujours
                                ajoutées à la fin.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;x&#039;</code></td>
                            <td>
                                Crée et ouvre le fichier en écriture seulement ; place le pointeur de
                                fichier au début du fichier. Si le fichier existe déjà,
                                <code><b>fopen()</b></code> va échouer, en retournant <b><code>false</code></b> et
                                en générant une erreur de niveau <b><code>E_WARNING</code></b>.
                                Si le fichier n&#039;existe pas, <code><b>fopen()</b></code> tente de le
                                créer. Ce mode est l&#039;équivalent des options <code>O_EXCL|O_CREAT</code>
                                pour l&#039;appel système <code>open(2)</code> sous-jacent.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;x+&#039;</code></td>
                            <td>
                                Crée et ouvre le fichier pour lecture et écriture; le comportement est
                                le même que pour <code>&#039;x&#039;</code>.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;c&#039;</code></td>
                            <td>
                                Ouvre le fichier pour écriture seulement. Si le fichier n&#039;existe pas, il
                                sera créé, s&#039;il existe, il n&#039;est pas tronqué (contrairement à
                                <code>&#039;w&#039;</code>) et l&#039;appel à la fonction n&#039;échoue pas (comme dans
                                le cas de <code>&#039;x&#039;</code>). Le pointeur du fichier est positionné
                                au début. Ce mode peut être utile pour obtenir un verrou (voyez
                                <code>flock()</code>) avant de tenter de modifier le fichier, utiliser
                                <code>&#039;w&#039;</code> pourrait tronquer le fichier avant d&#039;obtenir le verrou
                                (vous pouvez toujours tronquer grâce à <code>ftruncate()</a></code>).
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;c+&#039;</code></td>
                            <td>
                                Ouvre le fichier pour lecture et écriture, le comportement est le même
                                que pour le mode <code>&#039;c&#039;</code>.
                            </td>
                        </tr>

                        <tr>
                            <td><code>&#039;e&#039;</code></td>
                            <td>
                                Défini l&#039;indicateur close-on-exec sur le descripteur de fichier
                                ouvert. Disponible uniquement en PHP compilé sur les systèmes
                                conforme POSIX.1-2008.
                            </td>
                        </tr>

                    </tbody>

                </table>
            </article>
            <article class="col-md-6">
                <h3>Lire un fichier</h3>
                <p>
                    fread()
                </p>
                <pre>
                <?php
                if(!$monFichierTexte = fopen('./files/file.txt', 'r')){
                    echo '<p>Echec lors de l\'ouverture du fichier</p>';
                }else{
                    echo '<p>Le fichier est présent et ouvert</p>';
                    echo '<pre>'. fread($monFichierTexte, filesize('./files/file.txt')) . '</pre>';
                    fclose($monFichierTexte);
                }
                ?>
                </pre>
            </article>
            <article class="col-md-6">
                <h4>Lire un fichier en parcellaire fgets()</h4>
                <?php
                if(!$monFichierTexte = fopen('./files/file.txt', 'r')){
                    echo '<p>Echec lors de l\'ouverture du fichier</p>';
                }else{
                    echo '<p>Le fichier est présent et ouvert</p>';
                    echo '<p>'. fgets($monFichierTexte) . '</p>';
                    echo '<p>'. fgets($monFichierTexte, 10) . '</p>';
                    echo '<p>'. fgets($monFichierTexte) . '</p>';
                    echo '<p>';
                    while(!feof($monFichierTexte)){
                        echo fgets($monFichierTexte);
                    }
                    echo '</p>';
                    fclose($monFichierTexte);
                }
                ?>
            </article>
            <article class="col-md-6">
                <h3>Créer des fichiers</h3>
                <form method="post" id="createFile">
                    <div class="mb-3">
                        <label class="form-label" for="titre">Titre :</label>
                        <input class="form-control" type="text" name="titre" value="" required placeholder="titre fichier" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="message">Texte :</label>
                        <textarea class="form-control" name="message" placeholder="Votre texte ici"></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" name="createFile" value="Envoyer">
                            Envoyer
                        </button>
                        <button type="reset" class="btn btn-warning" value="Annuler">
                            Annuler
                        </button>
                    </div>
                </form>
            </article>
            <article class="col-md-6">
                <h3>Liste des fichiers créées et leurs répertoires</h3>
                <?php
                function dirMap($directory){
                    $map = '<ul>';
                    $folder = opendir($directory);
                    while( $file = readdir($folder)){
                        if($file !== '.' && $file !== '..'){
                            //var_dump($file);
                            if(filetype($directory.'/'.$file) === 'dir'){
                                $map .= '<li>'.$file.'</li>';
                            }else{
                                $map .= '<li><a href="'.$directory.'/'.$file.'" target="_blank">'.$file.'</a></li>';
                            }
                            if(filetype($directory.'/'.$file) === 'dir'){
                                $map .= dirMap($directory.'/'.$file);
                            }
                        }
                    }
                    $map .= '</ul>';
                    return $map;
                }

                echo dirMap('./files/wiki');
                ?>
            </article>
            <article class="col-md-6">
                <h3>Téléverser des fichiers</h3>
                <?php if($messageUpload !== ''){ ?>
                    <div class="alert <?= ($upload)? 'alert-success': 'alert-warning' ?> alert-dismissible fade show" role="alert">
                        <?= $messageUpload ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <form enctype="multipart/form-data" method="post" action="./formulaire.php" id="uploadFile">
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                    <div class="mb-3">
                        <label class="form-label" for="fichier">Fichier :</label>
                        <input class="form-control" type="file" name="fichier" required />
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" name="uploadFile" value="Charger">
                            Envoyer le fichier
                        </button>
                        <button type="reset" class="btn btn-warning" value="Annuler">
                            Annuler
                        </button>
                    </div>
                </form>
            </article>
            <article class="col-md-6">
                <h3>Liste des fichiers créées et leurs répertoires</h3>
                <?php
                echo dirMap('./uploads');
                ?>
            </article>
        </section>
    </main>
    <?php
    include './src/Widgets/footer.php';
    ?>
</body>

</html>