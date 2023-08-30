<?php
include_once '../models/ProdutoDAO.php';
include_once '../models/Estado.php';
include_once '../models/SubCategoria.php';
include_once '../models/Usuario.php';
class Controlproduto
{

    private $pn;
    private $es;
    private $ct;
    private $us;

    public function __construct()
    {
        $this->pd = new ProdutoDAO();
        $this->es = new Estado();
        $this->ct[0] = new SubCategoria();
        $this->ct[1] = new SubCategoria();
        $this->us = new Usuario();
        $this->us = new Usuario();
    }

    public function cadprodNormal($nome, $quantidade, $preco_ac, $idestado, $preco_at, $descricao, $subcategoria, $idusuario, $foto)
    {

        // Dados do produto
        $this->pd->setNome($nome);
        $this->pd->setQuantidade($quantidade);
        $this->pd->setpreco_ac($preco_ac);
        $this->pd->setpreco_at($preco_at);
        $this->pd->setDescricao($descricao);
        $this->pd->setFoto($foto);

        // $id = (int)$subcategoria; // Outra forma de limpar letras de uma variável
        $idsubcategoria = preg_replace("/[^0-9]/", "", $subcategoria); // Pegar o ID da subcategoria e limpar o nome da subcategoria
        $nomesubcategoria = str_replace($idsubcategoria, "", $subcategoria); // Pegar o nome da subcategoria e limpar o ID
        if (!isset($_SESSION)) :
            session_start();
        endif;
        $_SESSION['subcategoria'] = $nomesubcategoria;

        $this->es->setIdestado($idestado);
        $this->ct[0]->setNome($nomesubcategoria); // Nome da subcategoria
        $this->ct[1]->setIdsubcategoria((int) $idsubcategoria); // Id da subcategoria
        $this->us->setId($idusuario); // Id do usuario

        $this->pd->cadastrarProduto($this->es, $this->ct[0], $this->us, $this->ct[1]); // Cadastrar produto
    }
    public function cadMaisFoto($foto, $idproduto)
    {
        $this->ct[0]->setNome($_SESSION['subcategoria']);
        $this->pd->setIdproduto($idproduto);
        $this->pd->setFoto($foto);
        $this->pd->cadMaisFoto($this->ct[0]);
    }
    public function novosProdutos()
    {
        return $this->pd->novosProdutos();
    }
    public function produtoMaisvendido()
    {
        return $this->pd->produtoMaisvendido();
    }
    public function fotoProduto($idproduto)
    {
        $this->pd->setIdproduto($idproduto);
        return $this->pd->fotoProduto();
    }
    public function produtoCarrinho($idproduto)
    {
        $this->pd->setIdproduto($idproduto);
        return $this->pd->produtoCarrinho();
    }
    public function pesquisarProduto($produto)
    {
        $this->pd->setNome($produto);
        return $this->pd->pesquisarProduto();
    }
    public function produto()
    { 
        return $this->pd->buscarProdutos();
    }
    public function actualizarproduto($idprod, $nome, $quant,  $pac,  $pat, $desc, $est, $cat, $user,$visi )
    {
        $this->pd->setIdproduto($idprod);
        $this->pd->setNome($nome);
        $this->pd->setQuantidade($quant);
        $this->pd->setPreco_ac($pac);
        $this->pd->setPreco_at($pat);
        $this->pd->setDescricao($desc);
        $this->pd->setFkestado($est);
        $this->pd->setFkcategoria($cat);
        $this->pd->setUsuario($user);
        $this->pd->setVisibilidade($visi);
        return $this->pd->actualizarprodutos();
    }
    public function eliminarproduto($idprod)
    {
        $this->pd->setIdproduto($idprod);
        return $this->pd->eliminarprodutos();
    }
}
