<?php
namespace App\CorpoInc;

class Editeur extends UtilisateurStandard{
    protected $statut = 'editeur';
    
    public function getPermissions() : array {
        return ['lecture', 'modification_profil', 'ecriture', 'modification_contenu', 'publication'];
    }

    /* Méthode propre à l'éditeur */
    public function write(){
        return 'Écriture des données<br />';
    }
    
    public function update(){
        return 'Mise à jour des données<br />';
    }
    
    public function publish(){
        return 'Publication des données<br />';
    }
}