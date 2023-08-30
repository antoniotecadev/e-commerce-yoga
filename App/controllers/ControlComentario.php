<?php
include_once '../models/Comentario.php';
class ControlComentario
{
    private $cm;
    public function __construct()
    {
        $this->cm = new Comentario();
    }

    public function comentarProduto($comentario, $avaliacao, $fkproduto, $fkcliente)
    {
        $this->cm->setComentario($comentario);
        $this->cm->setAvaliacao($avaliacao);
        $this->cm->setFkproduto($fkproduto);
        $this->cm->setFkcliente($fkcliente);
       
        $this->cm->comentar();
    }
    public function consultarComentario($idproduto, $salto){
        $this->cm->setIdproduto($idproduto);
        $this->cm->setSalto($salto);
        return $this->cm->consultarComentario();
    }

    
}
