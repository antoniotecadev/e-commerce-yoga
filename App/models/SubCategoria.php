<?php
include_once 'Conexao.php';
class SubCategoria
{
    private $fkcategoria;
    private $nome;
    private $idsubcategoria;
    private $chek;
    private $inicio;
    private $quantidade_pg;
    private $preco1;
    private $preco2;
    private $idest;

    public function getFkcategoria()
    {
        return $this->fkcategoria;
    }
    public function setFkcategoria($fkcategoria)
    {
        $this->fkcategoria = $fkcategoria;
    }
    public function getIdsubcategoria(){
        return $this->idsubcategoria;
    }
    public function setIdsubcategoria($idsubcategoria){
        $this->idsubcategoria = $idsubcategoria;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getChek(){
        return $this->chek;
    }
    public function setCheck($chek){
        $this->chek = $chek;
    }
    public function getInicio(){
        return $this->inicio;
    }
    public function setInicio($inicio){
        $this->inicio = $inicio;
    }
    public function getQuantidade_pg(){
        return $this->quantidade_pg;
    }
    public function setQuantidade_pg($quantidade_pg){
        $this->quantidade_pg = $quantidade_pg;
    }
    public function getPreco1(){
        return $this->preco1;
    }
    public function setPreco1($preco1){
        $this->preco1 = $preco1;
    }
    public function getPreco2(){
        return $this->preco2;
    }
    public function setPreco2($preco2){
        $this->preco2 = $preco2;
    }
    public function getIdest(){
        return $this->idest;
    }
    public function setIdest($idest){
        $this->idest = $idest;
    }

    public function carregarSubcategoria()
    { // Método para buscar as categoria
        $subcategoria = Conexao::getConnect()->prepare("SELECT DISTINCT sb.nomecategoria, sb.idcategoria as idsubcategoria, c.idcategoria,e.nomeestado,e.idestado from categoria as c JOIN subcategoria as sb ON c.idcategoria=sb.fkcategoria JOIN produto as p on sb.idcategoria=p.fkcategoria JOIN estado as e on p.fkestado=e.idestado WHERE e.idestado= 1 AND p.visibilidade = 'activado' ");
        $subcategoria->execute();
        return $subcategoria->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function subcategorias()
    { // Método para buscar as categoria para o ficheiro subcategoria
        $this->setFkcategoria(preg_replace('/[^[0-9]_]/', ' ', $this->getFkcategoria()));
        $subcategoria = Conexao::getConnect()->prepare('SELECT sb.idcategoria, sb.nomecategoria, COUNT(*) FROM subcategoria as sb INNER JOIN produto as p ON sb.idcategoria = p.fkcategoria
        WHERE sb.fkcategoria = ? GROUP BY sb.nomecategoria');
        $subcategoria->bindValue(1, htmlspecialchars($this->getFkcategoria()));
        $subcategoria->execute();
        return $subcategoria->fetchAll(\PDO::FETCH_ASSOC);
    } 

    public function buscarSubcategoria($sql)
    { // Método para buscar as categoria
        $consulta= Conexao::getConnect()->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function todasSubcategorias()
    { // Método para buscar as categoria
        $consulta= Conexao::getConnect()->prepare('SELECT idcategoria, nomecategoria FROM subcategoria');
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function consultaChekOf()
    { 
        $consulta= Conexao::getConnect()->prepare('CALL `proced_filtrar_preco_m`(?, ?, ?, ?, ?);');
        $consulta->bindValue(1, $this->getPreco1());
        $consulta->bindValue(2, $this->getPreco2());
        $consulta->bindValue(3, $this->getInicio());
        $consulta->bindValue(4, $this->getQuantidade_pg());
        $consulta->bindValue(5, $this->getIdest());
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultaProdAleatorio()
    { 
        $consulta= Conexao::getConnect()->prepare('CALL `proced_prod_aleatorio`(?, ?, ?);');
        $consulta->bindValue(1, $this->getIdest());
        $consulta->bindValue(2, $this->getInicio());
        $consulta->bindValue(3, $this->getQuantidade_pg());
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultaSubCat()
    { 

        $consulta= Conexao::getConnect()->prepare('CALL `proced_subcat`(?, ?, ?, ?);');
        $consulta->bindValue(1, $this->getIdest());
        $consulta->bindValue(2, $this->getIdsubcategoria());
        $consulta->bindValue(3, $this->getInicio());
        $consulta->bindValue(4, $this->getQuantidade_pg());
        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

/* SEM PROCEDURE

    public function consultaSubCat()
    {
        $sql = "
            SELECT 
                p.idproduto, p.nome, p.preco_ac, p.preco_at, p.descricao, 
                p.visibilidade, e.nomeestado, e.idestado, sc.nomecategoria,
                pf.foto, c.idcategoria, sc.idcategoria AS idsubcategoria 
            FROM 
                produto p 
            JOIN 
                estado e ON p.fkestado = e.idestado 
            JOIN 
                subcategoria sc ON p.fkcategoria = sc.idcategoria 
            JOIN 
                categoria c ON sc.fkcategoria = c.idcategoria 
            JOIN 
                produtofoto pf ON pf.fkproduto = p.idproduto 
            WHERE 
                e.idestado = ? 
                AND sc.idcategoria = ? 
            GROUP BY 
                p.nome 
            LIMIT ?, ?
        ";

        $consulta = Conexao::getConnect()->prepare($sql);
        $consulta->bindValue(1, $this->getIdest(), \PDO::PARAM_INT);
        $consulta->bindValue(2, $this->getIdsubcategoria(), \PDO::PARAM_INT);
        $consulta->bindValue(3, $this->getInicio(), \PDO::PARAM_INT);
        $consulta->bindValue(4, $this->getQuantidade_pg(), \PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function consultaProdAleatorio()
    {
        $sql = "
            SELECT 
                p.idproduto, p.nome, p.preco_ac, p.preco_at, p.descricao, 
                p.visibilidade, pf.foto, e.nomeestado, sc.nomecategoria, 
                sc.idcategoria AS idsubcategoria, c.idcategoria AS idcategoria, 
                e.idestado 
            FROM 
                produto p
            JOIN 
                produtofoto pf ON p.idproduto = pf.fkproduto
            JOIN 
                estado e ON p.fkestado = e.idestado
            JOIN 
                subcategoria sc ON p.fkcategoria = sc.idcategoria
            JOIN 
                categoria c ON sc.fkcategoria = c.idcategoria
            WHERE 
                e.idestado = ?
            GROUP BY 
                p.nome
            LIMIT ?, ?
        ";

        $consulta = Conexao::getConnect()->prepare($sql);
        $consulta->bindValue(1, $this->getIdest(), \PDO::PARAM_INT);
        $consulta->bindValue(2, $this->getInicio(), \PDO::PARAM_INT);
        $consulta->bindValue(3, $this->getQuantidade_pg(), \PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
        
    public function consultaCheckOf()
    {
        $sql = "
            SELECT 
                p.idproduto, p.nome, p.preco_ac, p.preco_at, p.descricao, 
                pf.foto, e.nomeestado, c.nomecategoria 
            FROM 
                produto p 
            JOIN 
                produtofoto pf ON p.idproduto = pf.fkproduto 
            JOIN 
                estado e ON p.fkestado = e.idestado 
            JOIN 
                subcategoria c ON p.fkcategoria = c.idcategoria 
            WHERE 
                p.fkcategoria = ? 
                AND p.preco_ac BETWEEN ? AND ? 
            GROUP BY 
                p.nome 
            LIMIT ?, ?
        ";

        $consulta = Conexao::getConnect()->prepare($sql);

        $consulta->bindValue(1, $this->getIdcategoria(), \PDO::PARAM_INT);
        $consulta->bindValue(2, $this->getPreco1(), \PDO::PARAM_INT);
        $consulta->bindValue(3, $this->getPreco2(), \PDO::PARAM_INT);
        $consulta->bindValue(4, $this->getInicio(), \PDO::PARAM_INT);
        $consulta->bindValue(5, $this->getQuantidade_pg(), \PDO::PARAM_INT);

        $consulta->execute();
        return $consulta->fetchAll(\PDO::FETCH_ASSOC);
    }
 */
}