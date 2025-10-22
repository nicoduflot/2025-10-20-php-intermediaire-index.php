<?php
namespace App\Parser;

abstract class Parser{
    public $content;
 
    public function __construct($file) {
        $this->readFile($file);
    }
 
    public function readFile($file) {
        if (file_exists($file)) {
            $this->content = file_get_contents($file);
        }
    }
}