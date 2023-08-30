<?php
include_once '../models/Leilao.php';
class ControlLeilao
{
    private $l;
    public function __construct()
    {
        $this->l = new Leilao();
    }

    public function dadosLeilao() // Dados do leilão
    {
        return $this->l->dadosLeilao();
    }
    public function pagar($idcliente, $valorpago) // Valor a pagar pelo produto
    {
        $this->l->setIdcliente($idcliente);
        $this->l->setValorpago($valorpago);
        return $this->l->pagar();
    }
    public function dadosCliente()
    {
        return $this->l->dadosCliente();
    }
    public function maiorValor()
    {
        return $this->l->maiorValor();
    }
    public function actualizarLeilão($nome, $precoinicial, $saltopreco, $titulo, $dia, $hora, $minuto, $subtitulo, $descricao, $estado, $foto, $usuario)
    {
        $this->l->setNome($nome);
        $this->l->setPrecoinicial($precoinicial);
        $this->l->setSaltopreco($saltopreco);
        $this->l->setTitulo($titulo);
        $this->l->setDia($dia);
        $this->l->setHora($hora);
        $this->l->setMinuto($minuto);
        $this->l->setSubtitulo($subtitulo);
        $this->l->setDescricao($descricao);
        $this->l->setEstado($estado);
        $this->l->setFoto($foto);
        $this->l->setUsuario($usuario);
        $this->l->actualizarLeilão();
    }
}
