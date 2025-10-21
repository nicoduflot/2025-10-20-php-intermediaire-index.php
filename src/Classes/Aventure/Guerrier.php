<?php
namespace JDR;

class Guerrier extends Perso{
    public function __construct($nom)
    {
        parent::__construct($nom);
    }

    public function multi(Perso $cible) : string {
        return $this->nom . ' se met en colère (berserk) et tape super fort '.$cible->getNom().', occasionnant des dégâts doubles.<br />';
    }
}