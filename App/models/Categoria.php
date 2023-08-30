<?php
include_once 'Conexao.php';
class Categoria
{

    private $nome;
    private $idcategoria;
    private $idest;


    public function getIdcategoria()
    {
        return $this->idcategoria;
    }
    public function setIdcategoria($idcategoria)
    {
        $this->idcategoria = $idcategoria;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getIdest()
    {
        return $this->idest;
    }
    public function setIdest($idest)
    {
        $this->idest = $idest;
    }

    public function categoriaN()
    { // Método para buscar as Categorias de Produtos Normais.
        $this->setIdest(preg_replace('/[^[0-9]_]/', ' ', $this->getIdest()));
        $this->setIdcategoria(preg_replace('/[^[0-9]_]/', ' ', $this->getIdcategoria()));
        $categoria = Conexao::getConnect()->prepare("SELECT sb.nomecategoria, sb.idcategoria AS subcategoria, sb.imgcapa, c.idcategoria,e.nomeestado,e.idestado from categoria as c JOIN subcategoria as sb ON c.idcategoria=sb.fkcategoria JOIN produto as p on sb.idcategoria=p.fkcategoria JOIN estado as e on p.fkestado=e.idestado WHERE e.idestado=? AND p.visibilidade = 'activado' AND c.idcategoria=? GROUP BY sb.nomecategoria");
        $categoria->bindValue(1, $this->getIdest());
        $categoria->bindValue(2, $this->getIdcategoria());
        $categoria->execute();
        return $categoria->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function categoriaPP()
    { // Método para buscar as Categorias de Produtos em Promoção e PrestaÇão.
        $this->setIdest(preg_replace('/[^[0-9]_]/', ' ', $this->getIdest()));
        $categoria = Conexao::getConnect()->prepare("SELECT c.nomecategoria, c.idcategoria,e.nomeestado,e.idestado, sb.idcategoria as subcategoria, sb.imgcapa from categoria as c JOIN subcategoria as sb ON c.idcategoria=sb.fkcategoria JOIN produto as p on sb.idcategoria=p.fkcategoria JOIN estado as e on p.fkestado=e.idestado WHERE e.idestado=? AND p.visibilidade = 'activado' GROUP BY c.nomecategoria");
        $categoria->bindValue(1, $this->getIdest());
        $categoria->execute();

        if (!$categoria->rowCount()) :
            $this->alert("Informação!", "<h4 class='text-center' style='margin-left: 40px'>Desculpe! Sem produtos em ".$this->getNome()." no momento.</h4>", "alert-info", "info.png", "btn-info", "6", "3", "450px", "index.php?sessao=home");
        endif; // Fim do insert->rowCount
        return $categoria->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function todasCategorias()
    { // Método para buscar as Categorias de Produtos em Promoção e PrestaÇão.
        $this->setIdest(preg_replace('/[^[0-9]_]/', ' ', $this->getIdest()));
        $categoria = Conexao::getConnect()->prepare("SELECT c.nomecategoria, c.idcategoria,e.nomeestado,e.idestado, sb.idcategoria as subcategoria, c.imgcapa from categoria as c JOIN subcategoria as sb ON c.idcategoria=sb.fkcategoria JOIN produto as p on sb.idcategoria=p.fkcategoria JOIN estado as e on p.fkestado=e.idestado WHERE e.idestado=? AND p.visibilidade = 'activado' GROUP BY c.nomecategoria");
        $categoria->bindValue(1, $this->getIdest());
        $categoria->execute();
        return $categoria->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function carregarCategoria()
    { // Método para buscar as categoria
        $categoria = Conexao::getConnect()->prepare('SELECT DISTINCT c.nomecategoria, c.idcategoria,e.nomeestado, c.imgcapa from categoria as c JOIN subcategoria as sb ON c.idcategoria=sb.fkcategoria JOIN produto as p on sb.idcategoria=p.fkcategoria JOIN estado as e on p.fkestado=e.idestado WHERE e.idestado= 1');
        $categoria->execute();
        return $categoria->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function carregarCategoriaprod()
    { // Método para buscar as categoria
        $categoria = Conexao::getConnect()->prepare('SELECT * FROM subcategoria');
        $categoria->execute();
        return $categoria->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function alert($titulo, $mensagem, $tipo, $icon, $btn, $n1, $n2, $px, $href)
    { // Função para chamar o alert
        echo '<div class="container">
        <form action="">
            <div class = "row">
                <div class = "col-md-' . $n1 . ' col-md-offset-' . $n2 . ' col-md-offset+5">
                    <div class="alert ' . $tipo . ' fade in">
                        <img src="../img/alert/' . $icon . '" alt="">
                        <strong>' . $titulo . '</strong> ' . $mensagem . '
                        <a href="' . $href . '" class="btn ' . $btn . '" data-dismiss="alert" style="margin-left:' . $px . '">ok</a>
                    </div>
                </div>
            </div>
            </form>
        </div>';
    }
}
