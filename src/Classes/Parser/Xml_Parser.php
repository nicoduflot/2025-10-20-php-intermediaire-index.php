<?php
namespace App\Parser;

class Xml_Parser extends Parser implements Parser_Interface{
    public function parseFile() {
        return simplexml_load_string($this->content);
    }
}