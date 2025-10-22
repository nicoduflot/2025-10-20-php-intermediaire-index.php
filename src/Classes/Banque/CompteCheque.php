<?php
namespace App\Banque;

use App\Banque\Carte;
use Utils\Tools;

class CompteCheque extends Compte{
    /* Attribut(s) propres à CompteCheque */
    private $carte;
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
        $numcarte,
        $codepin,
        $solde = 0,
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
        $this->carte = new Carte($numcarte, $codepin);
    }

    /* getter(s) || setter(s) */
    /**
     * Get the value of carte
     */ 
    public function getCarte()
    {
        return $this->carte;
    }

    /* méthodes propres au CompteCheque */
    public static function generatePin() : string{
        $pin = ''. rand(0, 9). rand(0, 9). rand(0, 9). rand(0, 9);
        return $pin;
    }

    public static function generateCardNumber() : string {
        $numcarte = ''.
            self::generatePin(). ' '.
            self::generatePin(). ' '.
            self::generatePin(). ' '.
            self::generatePin();
        return $numcarte;
    }

    public function payerParCarte(string $numcarte, string $codepin, float $montant, Compte $destinataire) : string {
        $message = '';
        /* verifier numacarte de codepin OK */
        if( $this->getCarte()->getNumcarte() === $numcarte && $this->getCarte()->getCodepin() === $codepin ){
            if( $this->virement($montant, $destinataire) ){
                $etatSolde = ($this->getSolde() < 0 )? 'débiteur' : 'créditeur' ;
                $message = '
                Un paiement de '.$montant.$this->getDevise().' avec la carte n° '.$this->getCarte()->getNumcarte().' 
                a été effectué pour '. $destinataire->getNom() .'<br />
                Compte : '.$etatSolde.' : <b>'.$this->getSolde().$this->getDevise().'</b>
                ';
                return $message;
            }
            return $message;
        }else{
            $message = 'Une erreur est survenur lors de la tentative de paiement d\'un montant de '.$montant.$this->getDevise().' vers le destinataire ' . $destinataire->getNom(). ' ' .$destinataire->getPrenom() . '.';
            return $message;
        }
    }

    /* methode(s) de la classe mère surchargée(s) */
    public function infoCompte(): string{
        $ficheCompte = parent::infoCompte();
        $ficheCompte .= '<div class="my-2">Carte n°<b>'. $this->getCarte()->getNumcarte() .'</b></div>';
        return $ficheCompte;
    }

    /* methode(s) d'enregistrement dans la bdd */
    public function insertCompte(){
        $cardId = $this->getCarte()->insertCard();
        $params = $this->getParams();
        $params['cardid'] = $cardId;
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
            `decouvert`,
            `cardid`
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
            :decouvert,
            :cardid
            )
        ';
        $this->id = Tools::insertBDD($sql, $params);
        return true;
    }
}