<?php
namespace JDR;

class Voleur extends Perso{
    public function __construct($nom)
    {
        parent::__construct($nom);
    }

    public function multi(Perso $cible) : string {
        return $this->nom . ' tape par derrière '.$cible->getNom().', occasionnant des dégâts supplémentaires.<br />';
    }
}