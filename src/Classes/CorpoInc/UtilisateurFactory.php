<?php
namespace App\CorpoInc;

use InvalidArgumentException;

class UtilisateurFactory{
    public static function creer($type, $login, $motdepasse) : object {
        switch(strtolower($type)){
            case 'utilisateur':
            case 'standard':
                return new UtilisateurStandard($login, $motdepasse);
            case 'editeur':
            case 'moderateur':
                return new Editeur($login, $motdepasse);
            case 'admin':
            case 'administrateur':
                return new Administrateur($login, $motdepasse);
            default:
                throw new InvalidArgumentException('Type d\'utilisateur non reconnu : '.$type.'<br />');
        }
    }
}