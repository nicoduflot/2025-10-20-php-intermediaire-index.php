<?php
namespace App\Parser;

class Yaml_Parser extends Parser implements Parser_Interface{
    public function yaml_parse(){
        return 'yaml parsé';
    }

    public function parseFile() {
        return $this->yaml_parse($this->content);
    }
}