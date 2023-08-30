<?php
include_once '../models/Encomenda.php';
class ControlEncomenda
{
    private $en;
    public function __construct()
    {
        $this->en = new Encomenda();
    }
    public function encomendar(int $idcliente, array $idproduto, string $detalhe, array $quantidade, array $parcela, array $idprod)
    {
        $this->en->setIdcliente($idcliente);
        $this->en->setIdproduto($idproduto);
        $this->en->setDetalhe($detalhe);
        $this->en->setQuantidade($quantidade);
        $this->en->setParcela($parcela);
        $this->en->setIdprodo($idprod);
        $this->en->encomendar();
    }
    public function notificacaoEncomenda()
    {
        return $this->en->notificacaoEncomenda();
    }
    public function dadosProduto($idcliente)
    {
        $this->en->setIdcliente($idcliente);
        return $this->en->dadosProduto();
    }
     public function visualizar($idcliente, $operacao, $idusuario, $info)
    {
        $this->en->setIdcliente($idcliente);
        $this->en->setOperacao($operacao);
        $this->en->setDetalhe($info);
        $this->en->setIdusuario($idusuario); 
        $this->en->visualizar();
    }
    public function operador($idusuario)
    {
        $this->en->setIdusuario($idusuario);
        return $this->en->operador();
    }
}
