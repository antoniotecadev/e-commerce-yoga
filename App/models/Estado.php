<?php
include_once 'Conexao.php';
Class Estado {

    private $idestado;
    private $nome;

    public function getIdestado(){
        return $this->idestado;
    }
    public function setIdestado($idestado){
        $this->idestado = $idestado;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }

    public function carregarEstado(){ // Método para buscar os estados
        $estado= Conexao::getConnect()->prepare('SELECT * FROM estado');
        $estado->execute();
        return $estado->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}