<?php
namespace Utils;

use PDO;
use PDOException;

/* Tools est une classe statique : Pas de constructeur donc pas d'instance de classe a créer */

class Tools implements Config_interface{
    

    public static function circo($rayon) : float {
        return (2 * $rayon) * self::PI;
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

    /* Connexion à la base de donnée */

    public static function setBdd($dbHost = self::DBHOST, $dbName = self::DBNAME, $dbUser = self::DBUSER, $dbPsw = self::DBPSW ) : mixed {
        try{
            $bdd = new PDO(
                "mysql:host=$dbHost;dbname=$dbName;charset=UTF8",
                $dbUser,
                $dbPsw
            );
        }catch (PDOException $e) {
            echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Une exceptiona été lancée<br />
                    Message : ' . $e->getMessage() . '<br />
                    Code : ' . $e->getCode() . '<br />
                    Fichier : ' . $e->getFile() . '<br />
                    Ligne : ' . $e->getLine() . '<br />
                    Trace : ' . $e->getTraceAsString() . '<br />
                    Précédent : ' . $e->getPrevious() . '<br />
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            ';
            $bdd = false;
        }
        return $bdd;
    }

    /**
     * Permet toutes les requêtes BDD, en revanche, dans le cas d'un INSERT, ne renvoie pas le dernier ID enregistré
     * @param string $sql - requête SLS (pourra être utilisée en bindParam)
     * @param array $params : tableau des paramètres liés (bindParams)
     * @param bool $bdd : si true, on utilise la bdd locale sinon la connexion vers une autre bdd
     * @return mixed
     */
    public static function queryBDD($sql, $params = [], $bdd = true ) : mixed {
        if($bdd){
            $bdd = self::setBdd();
        }
        $req = $bdd->prepare($sql);
        $req->execute($params);
        return $req;
    }

    /**
     * requête INSERT dans la BDD, renvoie le dernier ID enregistré
     * @param string $sql - requête SLS (pourra être utilisée en bindParam)
     * @param array $params : tableau des paramètres liés (bindParams)
     * @param bool $bdd : si true, on utilise la bdd locale sinon la connexion vers une autre bdd
     * @return mixed
     */
    public static function insertBDD($sql, $params = [], $bdd = true ) : mixed {
        if($bdd){
            $bdd = self::setBdd();
        }
        $req = $bdd->prepare($sql);
        $req->execute($params);
        return $bdd->lastInsertId();
    }
}