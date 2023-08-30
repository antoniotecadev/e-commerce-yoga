<?php
include_once '../models/Estado.php';
Class ControlEstado{
    private $es;
    public function __construct(){
        $this->es = new Estado();
    }
    public function estados(){
        return $this->es->carregarEstado(); 
    }


}