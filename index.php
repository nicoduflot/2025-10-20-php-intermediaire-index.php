<?php
session_start();
//require_once './src/Classes/Banque/Compte.php';
//require_once './src/Utils/Tools.php';
include './src/includes/autoload.php';

use App\Banque\Compte;
use Utils\Tools;

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
                    <h2>Principes de la POO</h2>
                </header>
                <p>
                    Un objet est la réprésentation de quelque chose de matériel ou non à laquelle on associe des propriétés et des actions.
                </p>
                <p>
                    Une voiture, un compte bancaire, un personnage, etc peuvent être définis en tant qu'objets.
                </p>
                <p>
                    Un objet est défini par des attributs et des méthodes.
                </p>
                <h3>Attribut</h3>
                <p>
                    Les attributs sont des éléments ou caractères propres à l'objet.
                </p>
                <p>
                    Un compte bancaire, aura par exemple :
                </p>
                <ul>
                    <li>La civilité : nom, prénom du détenteur</li>
                    <li>le solde</li>
                    <li>le numéro d'agence</li>
                    <li>Le rib</li>
                    <li>l'iban</li>
                </ul>
                <h3>Les méthodes</h3>
                <p>
                    Les actions ou capacités applicable à l'objet.
                </p>
                <p>
                    Le compte bancaire de base aura comme méthodes :
                </p>
                <ul>
                    <li>Modifier le solde</li>
                    <li>Effectuer un virement vers un autre objet de type compte</li>
                    <li>Info sur le compte</li>
                </ul>
                <h3>Instance</h3>
                <p>
                    Un objet est une instance d'une classe. La classe défini l'objet, ses attributs et ses méthodes ainsi qu'un constructeur. C'est le constructeur qui gère la création de l'objet final.
                </p>
                <h3>Encapsulation</h3>
                <p>
                    Les attributs et les méthodes de l'objet sont donc encapsulés dans la classe. L'utilisateur de l'objet ne doit pas modifier le code de la classe mais utilisera l'objet via ses méthodes. En général il n'utilise pas directement ses attributs, ils seront <q>privés</q>
                </p>
                <h3>Créer la classe <q>Compte</q></h3>
                <p>
                    On crée les attributs en privé
                </p>
                <p>
                    On crée ensuite le <q>constructor</q>
                </p>
                <p>
                    Le constructeur sert a contruire l'objet lors de son instantiation. Il peut contenir du code et il définit les variables a renseigner lors de l'instanciation.
                </p>
                <p>
                    Comme les attributs sont privés, il faut, pour pouvoir les lire et / ou les modifier, créer des méthodes particulières, nommées getter ( ou Assesseur, pour les lire) et setter (ou Mutateur, pour les modifier).
                </p>
                <?php
                echo Compte::welcomeUser() . '<br />';

                /* Création du premier objet compte */
                $moncompte = new Compte('Duflot', 'Nicolas', 'CCP-987654', '0123456', 'NOM RIB', 'MON IBAN FR', 2500);
                var_dump($moncompte);
                var_dump($moncompte->getNom());
                var_dump($moncompte->getNumagence());

                $compteDestinataire = new Compte('Magic', 'Eric', 'CCP-456789', '6543210', 'RIB ERIC', 'IBAN FR ERIC', 2500);

                $moncompte->virement(400, $compteDestinataire);
                var_dump($moncompte->getSolde());
                var_dump($moncompte->typeCompte());
                echo $moncompte->infoCompte();
                ?>
                <h2>Les classes statiques</h2>
                <p>
                    Se sont des classes, généralement sans constructeur, qui contiennent une série de méthodes que l'on peut invoquer sans avoir besoin de créer une instance de la classe.
                </p>
                <p>
                    Il est d'ailleurs IMPOSSIBLE de créer une instance de classe si elle ne possèdent pas de constructeur
                </p>
                <?php
                echo Tools::PI.'<br />';
                echo Tools::circo(3).'<br />';
                ?>
            </article>
            
            <article>
                <header>
                    <h2>Les namespaces</h2>
                </header>
                <h3>Pourquoi les namespaces ?</h3>
                <p>
                    Il est possible de retrouver dans un projet qui grandit, deux classes ayant le même nom mais pas forcément le même environnement ou la même utilité.
                </p>
                <code>
                    <pre>
/* ./src/Models/User.php */
class User{}

/* ./src/Admin/User.php */
class User{}
                    </pre>
                </code>
                <p>
                    PHP renverra l'erreur <code>Cannot redeclare class User</code> car les deux classes seront considérée comme occupant le même espace.
                </p>
                                <p>
                    Grâce aux namespaces, on pourra différencier les deux classes selon leur contexte
                </p>
                <code>
                    <pre>
/* ./src/Models/User.php */
namespace Models;
class User{
    public function __construct(){

    }

    public function cestQui(){
        return 'Je suis un utilisateur';
    }
}
                    </pre>
                </code>
                <code>
                    <pre>
/* ./src/Admin/User.php */
namespace Admin
class User{
    public function __construct(){

    }

    public function cestQui(){
        return 'Je suis un administrateur';
    }
}
                    </pre>
                </code>
                <p>
                    Maintenant, il s'agit d'appeler les deux classes dans le fichier principal et d'indiquer qu'on les utilisent
                </p>
                <code>
                    <pre>
/* index.php */
require './src/Models/User.php';
require './src/Admin/User.php';

$user = new Models\User();
$admin = new Admin\User();
                    </pre>
                </code>
                <ul>
                    <li>Les namespaces servent à organiser le code et éviter les conflits de noms.</li>
                    <li>Ils sont souvent alignés avec l’arborescence des fichiers.</li>
                    <li>On peut utiliser use pour simplifier l’utilisation de classes avec un namespace.</li>
                </ul>
                <h3>Use</h3>
                <p>
                    Le mot-clé use permet d’importer une classe (ou une fonction ou une constante) depuis un autre espace de nom, pour éviter d’avoir à écrire son nom complet à chaque fois.
                </p>
                <p>
                    Quand on veut utiliser une classe définie dans un autre namespace, on doit la référencer avec son nom complet (FQCN - Fully Qualified Class Name) :
                </p>
                <code>
                    <pre>
$user = new \App\Models\User();
                    </pre>
                </code>
                <p>
                    Peu lisible si on dois l'utiliser plusieurs fois.
                </p>
                <p>
                    <b>Avec use</b>
                </p>
                <code>
                    <pre>
use App\Models\User;

$user = new User();
                    </pre>
                </code>
                <ul>
                    <li>use ne charge pas une classe. Il ne fait pas de require ou d’include.</li>
                    <li>Il sert juste à donner un raccourci local au nom complet d’une classe.</li>
                </ul>
                <h4>Utiliser des alias</h4>
                <p>
                    Quand on importe deux classes qui ont le même nom, on peut les renommer localement :
                </p>
                <code>
                    <pre>
use App\Models\User as UserModel;
use App\Admin\User as AdminUser;

$user1 = new UserModel();
$user2 = new AdminUser();
                    </pre>
                </code>
            </article>
            <article>
                <header>
                    <h2>Le destructeur</h2>
                </header>
                <p>
                    La "vie" d'un objet est limité à l'éxécution de son script.
                    Il est possible de donner des instructions à l'objet juste avant sa destruction.
                </p>
                <p>
                    La méthode <code>__destruct(){}</code> se lance automatiquement quand un objet est détruit et s'éxécute juste avant sa déstruction complète. 
                    Cela est utiles dans les cas suivant : enregistrement des données de l'objet en BDD, en session
                </p>
            </article>
            <article>
                <header>
                    <h2>Un objet d'une page à l'autre ?</h2>
                </header>
                <p>
                    Donc si un objet est détruit d'une page à l'autre, comment peut-on "passer" cet objet ?
                </p>
                <h3>Serialize / unserialize</h3>
                <p>
                    En utilisant les session PHP, il est possible d'y enregistrer l'objet créé.
                </p>
                <p>
                    <code>$_SESSION['objetSession'] = serialize($objetScript);</code>
                </p>
                <?php
                $_SESSION['monCompte'] = serialize($moncompte);
                var_dump($_SESSION);
                ?>
                <p>
                    L'objet est donc enregistré ou "sérializé" dans la session PHP. Quand on arrive sur l'autre page, on peut donc récupérer cet objet de le "désérializant dans une variable"
                </p>
                <p>
                    <code>$objetScript = unserialize($_SESSION['objetSession']);</code>
                </p>
                <p>
                    En associant donc le destructeur avec l'enregistrement en session de l'objet, on peut donc créer un objet sur une page et l'utiliser sur les autres pages du site ou de l'application.
                </p>
            </article>
            
            <article>
                <header>
                    <h2>
                        require ou require_once ?
                    </h2>
                </header>
                <p>
                    Quand on commence à organiser son code orienté objet en plusieurs fichiers, on se retrouve souvent à inclure des classes plusieurs fois sans le vouloir.
                </p>
                <code>
                    <pre>
// src/Utils/Logger.php
class Logger {
    public function log($msg) {
        echo "[LOG] $msg";
    }
}

// src/Models/User.php
require 'src/Utils/Logger.php';

class User {
    private $logger;

    public function __construct() {
        $this->logger = new Logger();
    }
}

//index.php
// script.php
require 'src/Utils/Logger.php';
require 'src/Models/User.php';

$user = new User(); // Error : Cannot redeclare class Logger
                    </pre>
                </code>
                <p>
                    require_once empêche qu’un même fichier soit inclus plusieurs fois :
                </p>
                <code>
                    <pre>
require_once 'src/Utils/Logger.php';
require_once 'src/Models/User.php';
                    </pre>
                </code>
                <p>
                    Pour bien utiliser require_once avec la POO et les namespaces :
                </p>
                <ul>
                    <li>PHP ne "sait pas" ce qu’il y a dans le fichier tant que tu ne l’as pas inclus.</li>
                    <li>Si on ne fait pas attention à l’ordre ou aux doublons, il y aura des erreurs de redéclaration.</li>
                    <li>C’est pourquoi, en POO moderne, on recommande de créer un utilitaire de chargement communément appelé "autoloading"</li>
                </ul>
                <h3>l'autoloading</h3>
                <p>
                    Avec les namespaces, on peut déléguer à PHP le chargement automatique des classes selon leur nom complet :
                </p>
                <code>
                    <pre>
use App\Utils\Logger;

$logger = new Logger(); // PHP l’inclura automatiquement avec un autoloader
                    </pre>
                </code>
                <p>
                    Grace à un autoloader (composer inclu un autoloader comme PSR-4), PHP saura que :
                </p>
                <ul>
                    <li><code>App\Utils\Logger;</code> &rarr; correspond au fichier <code>src/Utils/Logger.php</code></li>
                    <li>Et il l'incluera une seule fois, au bon moment.</li>
                </ul>
                <p>
                    Pour résumer :
                </p>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th><code>require</code></th>
                            <th><code>require_once</code></th>
                            <th><code>Autoloader (moderne)</code></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Inclut chaque fois</td>
                            <td>Inclut une seule fois</td>
                            <td>Charge automatiquement</td>
                        </tr>
                        <tr>
                            <td>Risque de doublons</td>
                            <td>Sécurise les inclusions</td>
                            <td>Évite totalement les require</td>
                        </tr>
                        <tr>
                            <td>Gère manuellement</td>
                            <td>Gère manuellement</td>
                            <td>Gère tout via les namespaces</td>
                        </tr>
                    </tbody>
                </table>
            </article>
        </section>
    </main>
    <?php
    include './src/Widgets/footer.php';
    ?>
</body>
</html>