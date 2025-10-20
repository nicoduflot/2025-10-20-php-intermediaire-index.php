<?php

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
                    <h2>Classes étendues</h2>
                </header>
                <h3>Principes</h3>
                <p>
                    Une classe est étendue quand elle possède une classe fille. La classe fille
                    hérite automatiquement des attributs et des méthodes de la classe mère. L'avantage
                    est que la classe fille peut posséder ses propres méthodes et attributs, mais elle peut aussi
                    surcharger les méthodes de la classe mère en les redéfinissants. Mais si on veut pouvoir redéfinir,
                    par exemple, les getters ou setters de la classe mère, les attributs concernés dans la classe
                    mère doivent être alors déclarés en protected et plus en private.
                </p>
            </article>
        </section>
        <section class="row">
            <article>
                <header>
                    <h2>Création des comptes qui héritent de la classe compte</h2>
                </header>
                <p>
                    On crée un compte chèque et un compte à intérêt.
                </p>
                <h3>Le compte chèque</h3>
                <ul>
                    <li>Possède une carte de paiement</li>
                    <li>Possède une méthode payerparcarte</li>
                </ul>
                <h4>La carte de paiement</h4>
                <ul>
                    <li>Un numéro de carte</li>
                    <li>Un PIN</li>
                </ul>
                <h3>Le compte intérêts</h3>
                <ul>
                    <li>Possède un taux d'intérêt</li>
                    <li>Possède une méthode crediterinterets</li>
                    <li>Le virement ne permet pas de rendre débiteur le compteinteret</li>
                </ul>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Compte Chèque</h2>
                </header>
                <?php
                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Compte Intéret</h2>
                </header>
                <?php
                ?>
                <div>
                    <?php
                    ?>
                </div>
            </article>
        </section>
        <section>
            <article>
                <header>
                    <h2>Surcharger une propriété ou une méthode</h2>
                </header>
                <h3>L'opérateur de résolution de portée</h3>
                <p>
                    On peut déclarer dans une classe mère, un attribut ou une méthode qui devrat être surchargée dans une classe fille.
                    Par exemple, la méthode de la classe fille fait exactement ce que fait la méthode de la classe mère mais elle modifie peut-être un attribut propre à la classe fille. Dans la déclaration de la méthode surchargée de la classe fille, il faut tout d'abord récupérer la méthode de la classe mère en utilisant l'opérateur de résolution de portée, <code>::</code> précédé d'un des mots clefs suivant : parent, self ou static.
                </p>
                <p>
                    Dans le cas présent, c'est le mot parent qui nous intéressera. on écrira alors dans la déclaration de la méthode surchargée par la lasse fille :
                </p>
                <code>
                    <pre>
public function methodeParente(){
    parent::methodeParente(); 
    $this->attributEnfant = true;
}
                    </pre>
                </code>
                <h3>L'opérateur de résolution de portée et les constantes</h3>
                <p>
                    Certains attribut dans une classe peuvent être une constante
                </p>
                <p>
                    Constante : <br />
                    Une constante est une variable qui ne stockera qu'une et unique valeur.
                </p>
                <p>
                    Part défaut (si rien n'est précisé) une constante déclarée dans une classe sera publique dans une classe.<br />
                    Pour définir une constante dans une classe par exemple :
                </p>
                <code>
                    <pre>
public const MACONSTANTE = 25;
                    </pre>
                </code>
                <p>
                    Pour accéder à une constante dans la classe où elle a été créé, on utilise l'opérateur de portée avec le mot clef self
                </p>
                <code>
                    <pre>
$varDansMethode = self::MACONSTANTE / 5;
                    </pre>
                </code>
                <p>
                    Pour accéder à une constante dans la classe parente, on utilise l'opérateur de portée avec le mot clef parent
                </p>
                <code>
                    <pre>
$varDansMethode = parent::MACONSTANTE / 2.5;
                    </pre>
                </code>
                <p>
                    Il est aussi possible de surcharger la constante dans la classe fille, et à l'aide de l'opérateur de portée, décider dans les méthodes de la classe fille de prendre l'originale (celle de la classe mère) avec parent:: ou celle surchargée par la fille avec self::
                </p>
                <p>
                    Par exemple :
                </p>
                <code>
                    <pre>
class Mere{

    publique const MACONSTANTE = 25;

    publique function __construct(){

    }

    publique function methode(){
        $maVarDansMethode = self::MACONSTANTE / 4;
        /* 25 / 5 =  5 */
        return $maVarDansMethode;
    }
}

class Enfant extends Mere{
    publique const MACONSTANTE = 20;
    private $isItTrue = false;

    publique function __construct(){

    }

    public function getIsItTrue(){
        return this->isItTrue;
    }

    publique function methode(){
        if($this->getIsItTrue()){
            $maVarDansMethode = self::MACONSTANTE / 5;
            /* 20 / 5 = 4 */
        }else{
            $maVarDansMethode = parent::MACONSTANTE / 2.5;
            /* 25 / 2.5 = 10 */
        }
        return $maVarDansMethode;
    }
}
                    </pre>
                </code>
                <p>
                    On peut dans le code hors classe accéder directement à la valeur de la constante pour chaque classe.
                </p>
                <code>
                    <pre>
echo Mere::MACONSTANTE;
/* Affiche 25 */
$classe = 'Mere';
echo $classe::MACONSTANTE;
/* Affiche 25 */

echo Enfant::MACONSTANTE;
/* Affiche 20 */
                    </pre>
                </code>
            </article>
        </section>
        <section>
            <article>
                <header>
                    <h2>
                        Les Propriétés et méthodes statiques
                    </h2>
                </header>
                <p>
                    Les propriétés ou méthodes statiques sont des propriétés ou méthodes qui ne s'utilisent pas à partir de l'instance d'une classe mais qui appartiennent à la classe dans laquelle elles sont définies.
                </p>
                <p>
                    Elles auront la même définition et la même valeur pour toutes les instance de la classe et on peux y accéder sans instancier la classe.
                </p>
                <p>
                    On ne peut pas accéder à une propriété statique depuis un objet. Une propriété statique peut, au contrainte d'une constante de classe, changer de valeur au cours du temps.
                </p>
                <p>
                    Par exemple :
                </p>
                <code>
                    <pre>
class Enfant extends Mere{
    protected static $coffreAJouets
    __construct(){

    }

    public function ajoutJouet($jouet){
        self::$coffreAJouets[] = $jouet;
    }

    public function contenuCoffre(){
        foreach(self::$coffreAJouets as $jouet){
            echo $jouet.', ';
        }
    }

}                        
                    </pre>
                </code>
                <p>
                    Utilisé dans le code suivant :
                </p>
                <code>
                    <pre>
$soeur = new Enfant();
$frere = new Enfant();
$soeur->ajoutJouet('Buzz l\'Éclair');
$frere->ajoutJouet('X-wing lego');
$soeur->contenuCoffre();
/* affiche Buzz l'éclair, X-wing lego */
$frere->contenuCoffre();
/* affiche Buzz l'éclair, X-wing lego */
                    </pre>
                </code>
            </article>
        </section>
        <section>
            <article>
                <header>
                    <h2>
                        Les classes et méthodes abstraites
                    </h2>
                </header>
                <p>
                    Dans l'exemple des comptes, on laisse la possibilité de créer un compte simple (classe mère de compte à intérêt et compte chèque)
                </p>
                <p>
                    Normalement, on ne peut que créer des comptes à intérêts ou des comptes chèques, donc la classe mère Compte devrait être une classe abstraite, définissant tous les attributs et toutes les méthodes communes aux classes filles, et seulement dans les classes filles on définit les méthodes qui sont différentes.
                </p>
                <p>
                    La classe mère étant définie en tant que classe abstraite ne sera pas invocable (impossible de créer une instance de cette classe). Elle servira de modèle général pour toutes les classes enfants.
                </p>
                <p>
                    Tous le attributs et les méthodes privées (en protected) seront utilisables et implémentées directement par les classes filles.
                </p>
                <p>
                    En revanche, si une méthode, utilisée par toutes les classes filles mais dont le résultat ou comportement est différent, la méthode est déclarée abstraite dans la classe mère : on ne fait que la déclaration de la méthode dans la classe mère mais il devient alors OBLIGATOIRE de la déclarer et de l'implémenter dans TOUTES les classes filles.
                </p>
                <p>
                    Un classe mère Perso, qui implémente les attributs et les méthode communes au classe filles.
                </p>
                <p>
                    Chaque classe fille aura une méthode multi (un coup spécial) mais son utilisation varie énormément par type de personnage.
                </p>
                <p>
                    Cette méthode est donc déclarée en méthode abstraite dans la classe abstraite et devra obligatoirement être implémentée dans toutes les classes filles.
                </p>
                <div class="row">
                    <div class="col-md-4">
                        <h3>La classe Perso</h3>
                <code>
                    <pre>
&lt?php
namespace JDR;
abstract class Perso{
    protected $nom;
    public function __construct($nom){
        $this->nom = $nom;
    }
    
    /**
    * Get the value of nom
    */ 
    public function getNom()
    {
        return $this->nom;
    }
    
    /**
    * Set the value of nom
    *
    * @return  self
    */ 
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }
    
    public function taper(Perso $perso){
        return $this->nom . ' tape '. $perso->nom . '&lt;br /&gt;';
    }
    
    abstract protected function multi(Perso $cible);
}
                    </pre>
                </code>
                    </div>
                    <div class="col-md-8">
                        <h3>La classe Voleur</h3>
                <code>
                    <pre>
&lt;?php
namespace JDR;
use JDR\Perso;

class Voleur extends Perso{
    public function __construct($nom)
    {
        parent::__construct($nom);
    }

    public function multi(Perso $cible){
        return $this->nom . ' tape par derrière le coquin '. $cible->nom . '&lt;br /&gt;';
    }
}
                    </pre>
                </code>
                        <h3>La classe Guerrier</h3>
                <code>
                    <pre>
&lt;?php
namespace JDR;
use JDR\Perso;

class Guerrier extends Perso{
    public function __construct($nom)
    {
        parent::__construct($nom);
    }

    public function multi(Perso $cible){
        return $this->nom . ' tape super fort '. $cible->nom . '&lt;br /&gt;';
    }
}
                    </pre>
                </code>
                    </div>
                </div>
                <?php

                ?>
            </article>
        </section>
        <section class="row">
            <article>
                <header>
                    <h2>Les interfaces</h2>
                </header>
                <p>
                    Les interfaces répondent au problème suivants : une classe mère radio ayant tous les attributs et les méthodes communes à une radio FM, une radio cassette, une radio cd et une radio cassette et cd.
                </p>
                <p>
                    Quatre classes filles : radio FM, Radio cassette, radio cd et radio cassette cd.
                </p>
                <p>
                    Plutôt que de créer toutes les options dans la classe mère, les classe filles vont implémenter des interfaces différentes correspondant à la fm, la cassette, et le cd.
                </p>
                <ul>
                    <li>une classe mère Radio.</li>
                    <li>une classe fille radio FM qui étends radio et qui implémente l'interface FM</li>
                    <li>une classe fille radio cassette qui étends radio et qui implémente l'interface FM et l'interface cassette</li>
                    <li>une classe fille radio cd qui étends radio et qui implémente l'interface FM et l'interface cd</li>
                    <li>une classe fille radio cassette cd qui étends radio et qui implémente l'interface FM , linterface casset et l'interface cd</li>
                </ul>
                <p>
                    Attention, les interfaces ne peuvent que définir que la signature d'une méthode, pas sont implémentation.
                </p>
                <p>
                    Donc les méthodes déclarées dans l'interface devront être publiques (elles sont implémentées en dehors de l'interface) et les constantes de l'interface ne pourront pas être écrasées par la classe qui en hérite.
                </p>
            </article>
            <article>
                <header>
                    <h2>Créer l'interface</h2>
                </header>
                <p>
                    On utilise le mot <code>interface</code> à la place du mot <code>class</code>
                </p>
                <code>
                    <pre>
&lt;?php
namespace App\Utrain;
interface Utrain_Interface{
    public const PRIXABO = 15;
    public function getNomUtilisateur();
    public function setPrixAbo();
    public function getPrixAbo();
}
                    </pre>
                </code>
                <p>
                    Dans les personnes qui prennent des abonnements, il y a des personne qui travaillent à U-train. Certains seront Cadre et paieront moins chers que les non cadres.
                    Les personnes du public, si elles font parties de la police elle paieront moins chers que le public.
                </p>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Le public</h2>
                </header>
                <p>
                    Les personnes ne travaillant pas pour UTrain
                </p>
                <code>
                    <pre>
&lt;?php
namespace App\Utrain;

class PublicUser implements Utrain_Interface, Toto_Interface{
    protected $nomutilisateur;
    protected $statut;
    protected $prixabo;

    public function __construct($nom, $statut = ''){
        $this->nomutilisateur = $nom;
        $this->statut = $statut;
        $this->setPrixAbo();
    }

    public function getNomUtilisateur()
    {
        echo $this->nomutilisateur;
    }
    
    public function getPrixAbo()
    {
        echo $this->prixabo;
    }

    public function setPrixAbo()
    {
        if($this->statut === 'Pompier'){
            return $this->prixabo = Utrain_Interface::PRIXABO / 2;
        }else{
            return $this->prixabo = Utrain_Interface::PRIXABO;
        }
    }

    public function youpi(){
        echo Toto_Interface::TOCTOC;
    }
}
                    </pre>
                </code>
                <?php

                ?>
            </article>
            <article class="col-lg-6">
                <header>
                    <h2>Les salariés de Utrain</h2>
                </header>
                <p>
                    Les gens qui travaillent à Utrain.
                </p>
                <code>
                    <pre>
&lt;?php
namespace App\Utrain;

use App\Utrain\Utrain_Interface;
class InternUser implements Utrain_Interface{
   protected $nomUtilisateur;
   protected $statut;
   protected $prixAbo;

   public function __construct($nom, $statut = ''){
        $this->nomUtilisateur = $nom;
        $this->statut = $statut;
        $this->setPrixAbo();
   }
    public function getNomUtilisateur(){
        echo $this->nomUtilisateur;
    }
    public function getPrixAbo(){
        echo $this->prixAbo;
    }
    public function setPrixAbo(){
        if($this->statut === 'Cadre'){
            return $this->prixAbo = Utrain_Interface::PRIXABO / 6;
        }else{
            return $this->prixAbo = Utrain_Interface::PRIXABO / 3;
        }
    }

    public function getWifi(){
        echo 'L\'utilisateur du transport a le wifi sans pub';
    }
}
                    </pre>
                </code>
                <?php

                ?>
            </article>
        </section>
        <section class="row">
            <article>
                <header>
                    <h2>les design pattern Factory</h2>
                </header>
                <h3>Principe</h3>
                <p>
                    La factory est une "usine à objets".
                </p>
                <p>
                    C'est une classe sans constructeur mais qui possède une méthode statique qui permet de renvoyer des instances d'autres classes.
                </p>
                <p>
                    Par exemple, pour créer un compte de base on fait <code>$compte = new Compte(
                        &lt;param du compte&gt;);
                    </code>
                </p>
                <p>
                    une factory permettrai d'écrire <code>$compte = CompteFactory::creerCompte('Compte', ['clef' => valeurs, ...]);</code>
                </p>
                <p>
                    Pour créer un compte chèque <code>$compte = CompteFactory::creerCompte('CompteCheque', ['clef' => valeurs, ...]);</code>
                </p>
                <p>
                    Ici, à la création du compte, au lieu d'avoit le détenteur dans l'objet compte, le détenteur serai un objet Detenteur, défini avec une partie des paramètre, et ensuite ajouté au compte.
                </p>
                <pre>
                <?php

                ?>
                </pre>
            </article>
        </section>
    </main>
    <?php
    include './src/Widgets/footer.php';
    ?>
</body>

</html>