<?php
namespace App\Parser;

use Exception;

class Parser_Factory{
     public static function getParser($file) {
 
        switch (pathinfo($file, PATHINFO_EXTENSION)) {
            case "json":
                return new Json_Parser($file);
            case "xml":
                return new Xml_Parser($file);
            case "yml":
                return new Yaml_Parser($file);
            default:
                throw new Exception("File type unsupported");
        }
    }
}