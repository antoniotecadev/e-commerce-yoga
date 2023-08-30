<?php
include_once '../models/Cliente.php';
class ControlCliente
{
    private $cl;
    public function __construct()
    {
        $this->cl = new Cliente(); 
    }

    public function criarConta($nome, $sobnome, $data, $sexo, $tel, $bairro, $rua, $email, $pass)
    {
        $this->cl->setNome($nome);
        $this->cl->setSobrenome($sobnome);
        $this->cl->setDatanascimento($data);
        $this->cl->setSexo($sexo);
        $this->cl->setTelefone($tel);
        $this->cl->setBairro($bairro);
        $this->cl->setRua($rua);
        $this->cl->setEmail($email);
        $this->cl->setPalavrapasse($pass);
        $this->cl->criarConta();
    }
    public function actDadosCli($nome, $sobrenome, $tel, $bairro, $rua, $datanasc, $sexo)
    {
        if (!isset($_SESSION)) :
            session_start();
        endif;
        $this->cl->setNome($nome);
        $this->cl->setSobrenome($sobrenome);
        $this->cl->setDatanascimento($datanasc);
        $this->cl->setSexo($sexo);
        $this->cl->setTelefone($tel);
        $this->cl->setBairro($bairro);
        $this->cl->setRua($rua);
        $this->cl->setId($_SESSION['idcliente']);
        $this->cl->actDadosCli();
    }
    public function actpass($pass, $pass1, $pass2){
        if (!isset($_SESSION)) :
            session_start();
        endif;
        $this->cl->setId($_SESSION['idcliente']);        
        return $this->cl->actPalavraPasse($pass, $pass1, $pass2);        
    }

    public function encontrarCliente($telemail){
        $this->cl->encontrarCliente($telemail);
    }
    public function buscarCliente(){
        return $this->cl->buscarCliente();
    }
    
}
