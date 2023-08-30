<?php
include_once '../models/SubCategoria.php';
class ControlSubCategoria
{
    private $ct;
    public function __construct()
    {
        $this->ct = new SubCategoria();
    }
    
    public function buscarsubCategoria($sql){
        return $this->ct->buscarsubCategoria($sql);
    }

    public function carregarSubcategorias()
    {
        return $this->ct->carregarSubcategoria();
    }
    
    public function todasSubcategorias()
    {
        return $this->ct->todasSubcategorias();
    }

    public function consultaChekOf($idest, int $preco1, int $preco2, int $incio, int $quantidade_pg)
    {
        $this->ct->setIdest($idest);
        $this->ct->setPreco1($preco1);
        $this->ct->setPreco2($preco2);
        $this->ct->setInicio($incio);
        $this->ct->setQuantidade_pg($quantidade_pg);
        return $this->ct->consultaChekOf();
    }
    public function consultaProdAleatorio($idest, int $incio, int $quantidade_pg)
    {	
        $this->ct->setIdest($idest);
        $this->ct->setInicio($incio);
        $this->ct->setQuantidade_pg($quantidade_pg);
        return $this->ct->consultaProdAleatorio();
    }
    public function consultaSubCat($idest, $idsc, int $incio, int $quantidade_pg)
    {
        $this->ct->setIdest($idest);
        $this->ct->setIdsubcategoria($idsc);
        $this->ct->setInicio($incio);
        $this->ct->setQuantidade_pg($quantidade_pg);
        return $this->ct->consultaSubCat();
    }
}
