<?php
include_once '../models/Usuario.php';
Class ControlUsuario    {
    private $us;
    public function __construct(){
        $this->us = new Usuario();
    }
    public function entrarConta(string $email, string $pass){ 
        $this->us->setEmail($email);
        $this->us->setPalavrapasse($pass);
        $this->us-> entrarConta();
    }
    public function usarios(){
        return $this->us->buscarUsuarios();
    }
    public function niveis(){
        return $this->us->carregarNivel(); 
    }
    public function cadastro(string $nome, string $email, string $telefone, string $pass, int $nivel, $foto){
        $this->us->setNome($nome);
        $this->us->setEmail($email);
        $this->us->setTelefone($telefone);
        $this->us->setPalavrapasse($pass);
        $this->us->setNivel($nivel);
        $this->us->setFoto($foto);
        $this->us->cadastrar();
       
    }
}
    





