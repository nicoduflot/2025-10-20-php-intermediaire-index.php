<?php
namespace App\Utrain;

class PublicUser implements Utrain_Interface, Toto_Interface{
    protected $nomutilisateur;
    protected $statut;
    protected $prixabo;

    public function __construct($nom, $statut = '')
    {
        $this->nomutilisateur = $nom;
        $this->statut = $statut;
        $this->setPrixAbo();
    }

    /**
     * Get the value of nomutilisateur
     */ 
    public function getNomutilisateur()
    {
        return $this->nomutilisateur;
    }

    /**
     * Get the value of prixabo
     */ 
    public function getPrixabo()
    {
        return $this->prixabo;
    }

    public function setPrixAbo()
    {
        if($this->statut === 'Pompier'){
            return $this->prixabo = self::PRIXABO / 2;
        }else{
            return $this->prixabo = self::PRIXABO;
        }
    }

    public function youpi(){
        echo self::TOCTOC.'<br />';
    }
}