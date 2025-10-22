<?php
namespace App\Banque;

use Utils\Tools;

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

    /**
     * Set the value of numcarte
     *
     * @return  self
     */ 
    public function setNumcarte($numcarte)
    {
        $this->numcarte = $numcarte;

        return $this;
    }

    /**
     * Set the value of codepin
     *
     * @return  self
     */ 
    public function setCodepin($codepin)
    {
        $this->codepin = $codepin;

        return $this;
    }

    /* Méthode d'enregistrement de la carte en bdd */
    public function insertCard() : int {
        $sql ='INSERT INTO `carte` (`cardnumber`, `codepin`) VALUE ( :cardnumber, :codepin );';
        $params = ['cardnumber' => $this->numcarte, 'codepin' => $this->codepin ];
        return Tools::insertBDD($sql, $params);
    }

    public function suppCarte() : bool{
        $sql = '
            DELETE FROM `carte` 
            WHERE 
                `cardnumber` = :cardnumber 
            AND 
                `codepin` = :codepin;
        ';
        $params = [
            'cardnumber' => $this->numcarte,
            'codepin' => $this->codepin
        ];
        Tools::queryBDD($sql, $params);
        return true;
    }
}