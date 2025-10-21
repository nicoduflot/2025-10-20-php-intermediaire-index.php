<?php
namespace App\Utrain;

class FreePublicUser extends PublicUser{
    protected $age;
    public function __construct($nom, $age, $statut = '')
    {
        parent::__construct($nom, $statut);
        $this->age = $age;
    }

    public function verifInterface(){
        echo self::PRIXABO.'<br />';
        echo self::TOCTOC.'<br />';
    }

    public function setPrixAbo()
    {
        $this->prixabo = parent::setPrixAbo();
        if($this->age <= 18){
            return $this->prixabo = 0;
        }
        return $this->prixabo;
    }
}