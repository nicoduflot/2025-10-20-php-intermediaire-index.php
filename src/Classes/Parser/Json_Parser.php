<?php
namespace App\Parser;

class Json_Parser extends Parser implements Parser_Interface{
    public function parseFile() {
        return json_decode($this->content);
    }
}