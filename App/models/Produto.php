<?php
abstract class Produto
{

    private $idproduto;
    private $nome;
    private $quantidade;
    private $preco_ac;
    private $preco_at;
    private $descricao;
    private $foto;
    private $preco1;
    private $preco2;
    private $idcategoria;
    private $inicio;
    private $quantpg;

    abstract function cadastrarProduto($idestado, $idsubcategoria, $idusuario, $nomeest);
    abstract function validarProduto($foto);
    abstract function validarFoto($confir);

    public function getIdproduto()
    {
        return $this->idproduto;
    }
    public function setIdproduto($idproduto)
    {
        $this->idproduto = $idproduto;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }
    public function getPreco_ac()
    {
        return $this->preco_ac;
    }
    public function setPreco_ac($preco_ac)
    {
        $this->preco_ac = $preco_ac;
    }
    public function getPreco_at()
    {
        return $this->preco_at;
    }
    public function setPreco_at($preco_at)
    {
        $this->preco_at = $preco_at;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function getPreco1()
    {
        return $this->preco1;
    }
    public function setPreco1($preco1)
    {
        $this->preco1 = $preco1;
    }
    public function getPreco2()
    {
        return $this->preco2;
    }
    public function setPreco2($preco2)
    {
        $this->preco2 = $preco2;
    }
    public function getIdcategoria()
    {
        return $this->idcategoria;
    }
    public function setIdcategoria($idcategoria)
    {
        $this->idcategoria = $idcategoria;
    }
    public function getInicio()
    {
        return $this->inicio;
    }
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }
    public function getQuantpg()
    {
        return $this->quantpg;
    }
    public function setQuantpg($quantpg)
    {
        $this->quantpg = $quantpg;
    }
}
