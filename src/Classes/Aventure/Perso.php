<?php
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
    /* Méthode utilisée par toutes les classes filles */
    public function taper(Perso $cible) : string {
        return $this->nom . ' tape '.$cible->getNom().'.<br />';
    }
    /* Méthode utilisée par toutes les classes filles mais dont l'implémentation dépend de la classe fille */
    abstract function multi(Perso $cible);
}