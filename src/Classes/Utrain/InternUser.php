<?php
namespace App\Utrain;

class InternUser implements Utrain_Interface{
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
        if($this->statut === 'Cadre'){
            return $this->prixabo = self::PRIXABO / 6;
        }else{
            return $this->prixabo = self::PRIXABO / 3;
        }
    }

    public function getWifi() : string {
        return 'L\'utilisateur du transport a le wifi sans pub';
    }
}