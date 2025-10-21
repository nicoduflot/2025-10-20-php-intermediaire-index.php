<?php
namespace App\Banque;

class CompteInteret extends Compte{
    /* Attribut(s) propres à CompteCheque */
    private $taux;
    /**
     * @param string $nom - nom du détenteur
     * @param string $prenom - prénom du détenteur
     * @param string $numcompte - numéro de compte
     * @param string $numagence - numéro d'agence
     * @param string $rib
     * @param string $iban
     * @param string $numcarte
     * @param string $codepin
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
        $taux = 0.03,
        $decouvert = 0,
        $devise = '€'
    )
    {
        parent::__construct(
            $nom ,
            $prenom,
            $numcompte,
            $numagence,
            $rib,
            $iban,
            $solde,
            $decouvert,
            $devise
        );
        $this->taux = $taux;
        $this->decouvert = 0;
    }

    /**
     * Get the value of taux
     */ 
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * Set the value of taux
     *
     * @return  self
     */ 
    public function setTaux($taux)
    {
        $this->taux = $taux;
        return $this;
    }

    /* méthodes propres au CompteCheque */

    public function crediterInterets() : string {
        $message = '';
        if($this->getSolde() > 0){
            $interets = $this->getSolde()*$this->getTaux();
            $this->modifierSolde($interets);
            $message ='Le compte à taux '.($this->getTaux()*100).'% a été crédité de '.$interets.$this->getDevise().'.<br />Solde créditeur de '.$this->getSolde().$this->getDevise().'';
        }else{
            $message ='Le compte à taux '.($this->getTaux()*100).'% n\'a pas de crédit suffisant pour créditer les intérêts';
        }
        return $message;
    }

    /* methode(s) de la classe mère surchargée(s) */
    public function infoCompte(): string{
        $ficheCompte = parent::infoCompte();
        $ficheCompte .= '<div class="my-2">Taux d\'intérêts : '.($this->getTaux()*100).'%<b></b></div>';
        return $ficheCompte;
    }

    /* methode(s) d'enregistrement dans la bdd */

    
}