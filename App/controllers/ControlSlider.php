<?php
include_once '../models/Slider.php';
class ControlSlider
{
    private $sl;
    public function __construct()
    {
        $this->sl = new Slider();
    }
    public function cadastrarImagem(string $descricao, $foto, string $visibilidade, int $usuario)
    {
        $this->sl->setDescricao($descricao);
        $this->sl->setFoto($foto);
        $this->sl->setVisibilidade($visibilidade);
        $this->sl->setUsuario($usuario);
        $this->sl->cadastrarImagem();
    }
    public function imagemSlider(){
        return $this->sl->imagemSlider();
    }
     public function actualizarimgslider($foto, $desc,$prim, $visi, $idslider)
    {
        $this->sl->setFoto($foto);
        $this->sl->setDescricao($desc);
        $this->sl->setPrimeiro($prim);
        $this->sl->setVisibilidade($visi);
        $this->sl->setIdslider($idslider);
        return $this->sl->actualizarImgSlider();
    }
}