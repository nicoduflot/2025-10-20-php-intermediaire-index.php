<?php 

namespace App\Banque;

use Utils\Tools;

 class Compte{
    protected string $nom ;
    protected string $prenom;
    protected string $numcompte;
    protected string $numagence;
    protected string $rib;
    protected string $iban;
    protected float  $solde;
    protected float  $decouvert;
    protected string $devise;
    protected $id;
    protected $params;

    /**
     * @param string $nom - nom du détenteur
     * @param string $prenom - prénom du détenteur
     * @param string $numcompte - numéro de compte
     * @param string $numagence - numéro d'agence
     * @param string $rib
     * @param string $iban
     * @param float  $solde
     * @param float  $decouvert - autorisation de découvert (nombre positif)
     * @param string $devise
     */
    public function __construct(
        $nom,
        $prenom,
        $numcompte,
        $numagence,
        $rib,
        $iban,
        $solde = 0,
        $decouvert = 0,
        $devise = '€'
    )
    {
        $this->nom = $nom ;
        $this->prenom = $prenom ;
        $this->numcompte = $numcompte ;
        $this->numagence = $numagence ;
        $this->rib = $rib ;
        $this->iban = $iban ;
        $this->solde = $solde ;
        $this->decouvert = $decouvert ;
        $this->devise = $devise ;
        $this->id = null;
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

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of numcompte
     */ 
    public function getNumcompte()
    {
        return $this->numcompte;
    }

    /**
     * Set the value of numcompte
     *
     * @return  self
     */ 
    public function setNumcompte($numcompte)
    {
        $this->numcompte = $numcompte;

        return $this;
    }

    /**
     * Get the value of numagence
     */ 
    public function getNumagence()
    {
        return $this->numagence;
    }

    /**
     * Set the value of numagence
     *
     * @return  self
     */ 
    public function setNumagence($numagence)
    {
        $this->numagence = $numagence;

        return $this;
    }

    /**
     * Get the value of rib
     */ 
    public function getRib()
    {
        return $this->rib;
    }

    /**
     * Set the value of rib
     *
     * @return  self
     */ 
    public function setRib($rib)
    {
        $this->rib = $rib;

        return $this;
    }

    /**
     * Get the value of iban
     */ 
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Set the value of iban
     *
     * @return  self
     */ 
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * Get the value of solde
     */ 
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */ 
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of decouvert
     */ 
    public function getDecouvert()
    {
        return $this->decouvert;
    }

    /**
     * Set the value of decouvert
     *
     * @return  self
     */ 
    public function setDecouvert($decouvert)
    {
        $this->decouvert = $decouvert;

        return $this;
    }

    /**
     * Get the value of devise
     */ 
    public function getDevise()
    {
        return $this->devise;
    }

    /**
     * Set the value of devise
     *
     * @return  self
     */ 
    public function setDevise($devise)
    {
        $this->devise = $devise;

        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /* Méthode(s) de l'objet */

    public function modifierSolde($montant) : void {
        $this->solde = $this->solde + $montant;
    }

    public function virement($montant, Compte $destinataire) : bool {
        /* il faut vérifier si le montnt est un nombre et s'il est supérieur à 0 */
        if( !is_float($montant) && !is_int($montant) || $montant <= 0 ){
            echo '<p>Le montant doit être un nombre strictement supérieur à 0<br /> 
                    Virement impossible vers le compte '. $destinataire->getNumcompte() .'</p>';
            return false;
        }
        /* il faut vérifier si l'autorisation de découver n'est pas dépassée */
        if( $this->getSolde() - $montant < ( -$this->getDecouvert()) ){
             echo '<p>Le paiement dépasse votre autorisation de découvert initialement de '.$this->getDecouvert().$this->getDevise().'<br /> 
                    Virement impossible vers le compte '. $destinataire->getNumcompte() .'</p>';
            return false;
        }
        $this->modifierSolde(-$montant);
        $destinataire->modifierSolde($montant);
        echo '<p>Le compte '. $destinataire->getNumcompte() .
            ' a été crédité de '. $montant . ' '  . $this->getDevise() . '</p>';
        return true;
    }

    /**
     * @return string
     */
    public function typeCompte() : string {
        $className = get_class($this);
        $namespace = __NAMESPACE__.'\\';
        $className = str_replace($namespace, '', $className);
        return $className;
    }

    /**
     * @return string
     */
    public function infoCompte() : string {
        $ficheCompte = '';
        $etatSolde = ($this->getSolde() < 0 )? 'débiteur' : 'créditeur' ;
        $ficheCompte = '
            <div class="my-2"><b>'. $this->typeCompte() .'</b></div>
            <div class="my-2"><b>'. $this->getNom() .' ' . $this->getPrenom() . '</b></div>
            <div class="my-2"><b>' . $this->getNumagence() . '</b></div>
            <div class="my-2"><b>'. $this->getRib() .'</b></div>
            <div class="my-2"><b>'. $this->getIban() .'</b></div>
            <div class="my-2">Compte '. $etatSolde .' <b> '. $this->getSolde() .' '. $this->getDevise() .'</b></div>
        ';
        return $ficheCompte;
    }

    /* exemple de méthode statique */
    public static function welcomeUser() : string {
        return '<h2>Bienvenue Chez CorpoInc !</h2>';
    }

    /* Insertion compte base de données */

    /* Crée des paramètre de requête communs à tous les type de compte */
    public function getParams(){
        $this->params = [
            'typecompte' => $this->typeCompte(),
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'numcompte' => $this->numcompte,
            'numagence' => $this->numagence,
            'rib' => $this->rib,
            'iban' => $this->iban,
            'solde' => $this->solde,
            'devise' => $this->devise,
            'decouvert' => $this->decouvert
        ];
        return $this->params;
    }

    public function insertCompte(){
        $params = $this->getParams();
        $sql = '
            INSERT INTO `compte` ( 
            `typecompte`,
            `nom`,
            `prenom`,
            `numcompte`,
            `numagence`,
            `rib`,
            `iban`,
            `solde`,
            `devise`,
            `decouvert`
            ) VALUES (
            :typecompte,
            :nom,
            :prenom,
            :numcompte,
            :numagence,
            :rib,
            :iban,
            :solde,
            :devise,
            :decouvert
            )
        ';
        $this->id = Tools::insertBDD($sql, $params);
        return true;
    }

    public function updateCompte() : bool {
        $params = $this->getParams();
        $params['id'] = $this->getId();
        //var_dump($params);
        $sql = '
            UPDATE `Compte` 
            SET 
                `typecompte` = :typecompte,
                `nom` = :nom ,
                `prenom` = :prenom ,
                `numcompte` = :numcompte ,
                `numagence` = :numagence ,
                `rib` = :rib ,
                `iban` = :iban ,
                `solde` = :solde ,
                `devise` = :devise ,
                `decouvert` = :decouvert 
            WHERE 
                `id` = :id
        ';
        Tools::queryBDD($sql, $params);
        return true;
    }

    public function suppCompte() : bool{
        $sql = '
        DELETE FROM `compte` 
        WHERE `id` = :id;
        ';
        $params = ['id' => $this->id];
        Tools::queryBDD($sql, $params);
        return true;
    }
 }