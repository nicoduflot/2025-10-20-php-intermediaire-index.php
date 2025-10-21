<?php
namespace App\CorpoInc;

class UtilisateurStandard extends Utilisateur{
    protected $statut = 'utilisateur';

    public function getPermissions() : array {
        return ['lecture', 'modification_profil'];
    }
}