<?php
namespace App\Banque;

class Carte{
    private $numcarte;
    private $codepin;

    /**
     * Constructor
     * @param string $numcarte - numéro de la carte
     * @param string $codepin - code secret
     */
    public function __construct($numcarte, $codepin){
        $this->numcarte = $numcarte;
        $this->codepin = $codepin;
    }

    /**
     * Get the value of numcarte
     */ 
    public function getNumcarte()
    {
        return $this->numcarte;
    }    

    /**
     * Get the value of codepin
     */ 
    public function getCodepin()
    {
        return $this->codepin;
    }

    /* Méthode d'enregistrement de la carte en bdd */

}