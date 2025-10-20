<?php

namespace Utils;

/* Tools est une classe statique : Pas de constructeur donc pas d'instance de classe a créer */

class Tools{
    static $pi = 3.1415926535898;

    public static function circo($rayon) : float {
        return (2 * $rayon) * self::$pi;
    }
}