<?php
include_once '../models/Categoria.php';
class ControlCategoria
{
    private $ct;
    public function __construct()
    {
        $this->ct = new Categoria();
    }

    public function categoriaN($Idestado, $idsc){
        $this->ct->setIdest($Idestado);
        $this->ct->setIdcategoria($idsc);
        return $this->ct->categoriaN();
    }

    public function categoriaPP($Idestado,$estado){
        $this->ct->setIdest($Idestado);
        $this->ct->setNome($estado);
        return $this->ct->categoriaPP();
    }
    public function todasCategorias($Idestado){
        $this->ct->setIdest($Idestado);
        return $this->ct->todasCategorias();
    }

    public function categorias()
    {
        return $this->ct->carregarCategoria();
    }
    public function categoriasprod()
    {
        return $this->ct->carregarCategoriaprod();
    }

}
