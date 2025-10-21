<?php
namespace Utils;

interface Config_interface{
    /* Constante pi pour tools */
    public const PI = 3.1415926535898;
    /* Mapping namespace et classes pour l'autoload */
    public const AUTOLOAD_ALIASES = [
        
    ];
    
    /* Configuration de la base de données par défaut */
    public const DBHOST = '';
    public const DBNAME = '';
    public const DBUSER = '';
    public const DBPSW = '';
}