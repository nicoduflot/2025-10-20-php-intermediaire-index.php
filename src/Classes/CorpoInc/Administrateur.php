<?php
namespace App\CorpoInc;

class Administrateur extends Editeur{
    protected $statut = 'admin';

    public function getPermissions() : array {
        return ['lecture', 'modification_profil', 'ecriture', 'modification_contenu', 'publication', 'gestion_utilisateur', 'administration'];
    }

    /* Méthode propre à l'administrateur */
    public function gestionUtilisateur(){
        return 'Droits de gestion des utilisateurs<br />';
    }
    
    public function adminSite(){
        return 'Droits d\'administration du site<br />';
    }
}