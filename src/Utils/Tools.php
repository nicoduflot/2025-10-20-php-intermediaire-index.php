<?php

namespace Utils;

/* Tools est une classe statique : Pas de constructeur donc pas d'instance de classe a créer */

class Tools{
    static $pi = 3.1415926535898;

    public static function circo($rayon) : float {
        return (2 * $rayon) * self::$pi;
    }

    public static function makeSlug($text) : string{
        /* convertir en minuscule */
        $text = strtolower($text);
        $text = preg_replace(
            /* remplace les caractères spéciaux par un tiret */
            array('/&.*/', '/\W/'),
            '-',
            /* remplacer les caractères accentués par l'équivalent sans accent */
            preg_replace(
                '/&([A-Za-z]{1,2})(grave|acute|circ|cedil|uml|lig);/',
                '$1', 
                htmlentities($text, ENT_NOQUOTES, 'UTF-8')
            )
        );

        /* transformer les tirets multiples en une seul tiret */
        $text = preg_replace('/-+/', '-', $text);

        /* retirer les tiret en début et fin de nom de fichier */
        $text = trim($text, '-');

        return $text;
    }
}