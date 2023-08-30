<?php
include_once 'Conexao.php';
include_once 'Produto.php';

class ProdutoDAO extends Produto
{
    private $idestado;
    private $idsubcategoria;
    private $idusuario;
    private $nomecat;

    public function cadastrarProduto($ides,  $nocat, $idus, $idca)
    {

        $this->idestado = $ides;
        $this->nomecat = $nocat; 
        $this->idusuario = $idus;
        $this->idsubcategoria = $idca;

        $this->init();
    }

    public function init()
    {
        $this->validarFoto(true);
    }

    public function validarFoto($confir)
    {

        if (!$this->getFoto()["name"]) :
            $this->alert("Falha!", "Adiciona a foto do produto", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        else :

            $largura = 600; // Largura máxima em pixels
            $altura = 600; // Altura máxima em pixels
            $tamanho = 307200; // Tamanho máximo da foto em bytes
            $falha = array(); // Array de falhas

            if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $this->getFoto()["type"])) : // Verifica se o arquivo é uma foto
                $falha[1] = "falha";
                $this->alert("Falha!", "Não é uma foto, que vocé adicionou", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;
            $dimensoes = getimagesize($this->getFoto()["tmp_name"]); // Pega as dimensões da imagem

            if ($dimensoes[0] > $largura) : // Verifica se a largura da imagem é maior que a largura permitida
                $falha[2] = "falha";
                $this->alert("Falha!", "A largura da imagem não deve ultrapassar  <strong>" . $largura . "</strong> pixels", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;
            if ($dimensoes[1] > $altura) : //  Verifica se a altura da imagem é maior que a altura permitida
                $falha[3] = "falha";
                $this->alert("Falha!", "A altura da imagem não deve ultrapassar  <strong>" . $altura . "</strong> pixels", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;
            // Verifica se o tamanho da imagem é maior que o tamanho permitido
            if ($this->getFoto()["size"] > $tamanho) :
                $falha[4] = "falha";
                $this->alert("Falha!", "A imagem deve ter no máximo  <strong>" . $tamanho . "</strong> bytes ou  <strong>" . ($tamanho / 1024) . "</strong> KB", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            $caminho = "../img/" . strtolower($this->nomecat->getNome()) . "/"; // Pegar o caminho com nome da categoria | nome categoria == nome da pasta

            $nome_imagem = $this->getFoto()["name"]; // Pegar o nome da imagem

            if ($nome_imagem != strtolower($this->getFoto()["name"])) : // Verificar se nome da imagem contem letras maiúsculas
                $falha[6] = "falha";
                $this->alert("Falha!", "O nome da foto  <strong>" . $nome_imagem . "</strong> não pode ter letras  <strong>maiúsculas</strong>", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (file_exists($caminho .  $nome_imagem)) : // Verificar
                $falha[7] = "falha";
                $this->alert("Falha!", "A foto  <strong>" . $nome_imagem . "</strong> já existe", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (count($falha) == 0) : // Se não houver nenhuma falha executa

                $caminho_imagem = "../img/" . strtolower($this->nomecat->getNome()) . "/" . $nome_imagem; // Pegar o caminho com nome da categoria | nome categoria == nome da pasta

                move_uploaded_file($this->getFoto()["tmp_name"], $caminho_imagem); // Faz o upload da imagem para seu respectivo caminho
                if ($confir == true) :
                    $numero = (int) substr($nome_imagem, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
                    if ($numero != 1) :
                        $falha[8] = "falha";
                        $this->alert("Falha!", "O nome da foto principal <strong>" . $nome_imagem . "</strong> deve ter  <strong>01</strong> no final", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
                    endif;
                    if (count($falha) == 0) : // Se não houver nenhuma falha executa
                        $this->validarProduto($nome_imagem);
                    endif;
                elseif ($confir == false) :
                    $this->validarMaisFoto($nome_imagem);
                endif;
            endif;
        endif;
    }
    public function validarProduto($foto)
    {
        // Verificação de entrada
        if (!preg_match("/^[a-z0-9\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getNome())) :
            $this->alert("Falha!", "Nome do produto não é válido<br><strong>Não introduzir</strong> :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        elseif (!preg_match("/^[0-9]+$/i", $this->getQuantidade())) :
            $this->alert("Falha!", "Quantidade não é válida", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        elseif (!preg_match("/^[0-9]+$/i", $this->getPreco_ac())) :
            $this->alert("Falha!", "Preço actual não é válido<br><strong>Não introduzir</strong> letras :;~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        elseif (!preg_match("/^[0-9]+$/i", $this->getPreco_at())) :
            $this->alert("Falha!", "Preço antigo não é válido<br><strong>Não introduzir</strong> letras :;~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        elseif (!preg_match("/^[a-z@0-9.\-\_\,\:\%\(\)\?\+\/\!\$\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\ ]+$/i", $this->getDescricao())) :
            $this->alert("Falha!", "Descrição do produto não é válida<br><strong>Não introduzir</strong> ~ ; <> ` # & * [ ]{ } * = | \, etc.", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        else :
            // inserir dados do usuário na base de dados
            $sql = 'INSERT INTO produto (nome, quantidade, preco_ac, preco_at, descricao, fkestado, fkcategoria, fkusuario)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

            $pdo = Conexao::getConnect();
            $pdo->beginTransaction(); // Início da transação
            $inserir = $pdo->prepare($sql);
            $inserir->bindValue(1, $this->getNome());
            $inserir->bindValue(2, $this->getQuantidade());
            $inserir->bindValue(3, $this->getPreco_ac());
            $inserir->bindValue(4, $this->getPreco_at());
            $inserir->bindValue(5, $this->getDescricao());
            $inserir->bindValue(6, $this->idestado->getIdestado());
            $inserir->bindValue(7, $this->idsubcategoria->getIdsubcategoria());
            $inserir->bindValue(8, $this->idusuario->getId());
            $inserir->execute();

            $idproduto = $pdo->lastInsertId(); // Valor do ID incrementado automaticamente para uma linha acabada de inserir na tabela produto

            if (!$inserir->rowCount()) :
                die(""); // Parar a execução
                $this->alert("Erro!", "<h4 class='text-center'>Produto não cadastrado</h4><h6 class='text-center'>E-mail ou número de telefone já cadastrado</h6>", "alert-danger", "erro.png", "btn-danger", "6", "2", "450px", "");
            endif; // Fim do insert->rowCount

            $this->cadastrarFoto($pdo, $foto, $idproduto, $this->getNome()); // Cadastrar foto

        endif; // Fim da verificação de entrada
    }

    public function cadastrarFoto($pdo, $foto, $idproduto, $nomeprod)
    { // Método para cadastrar foto
        $inserirfoto = $pdo->prepare('INSERT INTO produtofoto (foto, fkproduto) VALUES (?, ?)');
        $inserirfoto->bindValue(1, $foto);
        $inserirfoto->bindValue(2, $idproduto);
        $inserirfoto->execute();

        if (!$inserirfoto->rowCount()) :
            $pdo->rollBack(); // Cancelar as transações
            die(""); // Parar a execução
            $this->alert("Erro!", "<h4 class='text-center'>Foto do produto não cadastrada</h4>", "alert-danger", "erro.png", "btn-danger", "6", "2", "450px", "");
        else :
            $this->alert("Feito", "Produto cadastrado com sucesso", "alert-success", "bom.png", "btn-success", "6", "2", "450px", "admin.php?sessao=cadastrarprod&foto=true&nomeproduto=" . $nomeprod . "&idprod=" . $idproduto . "");
        endif; // Fim do insert->rowCount

        $pdo->commit(); // Finalizar as transações
    } 

    public function cadMaisFoto($nomecat)
    { // add foto de um produto
        $this->nomecat = $nomecat;
        $this->validarFoto(false);
    }

    public function validarMaisFoto($foto)
    { // Validar mais foto

        $inserirfoto = Conexao::getConnect()->prepare('INSERT INTO produtofoto (foto, fkproduto) VALUES (?, ?)');
        $inserirfoto->bindValue(1, $foto);
        $inserirfoto->bindValue(2, $this->getIdproduto());
        $inserirfoto->execute();

        if (!$inserirfoto->rowCount()) :
            $this->alert("Erro!", "<h4 class='text-center'>Foto do produto não adicionada</h4><h6 class='text-center'>E-mail ou número de telefone já cadastrado</h6>", "alert-danger", "erro.png", "btn-danger", "6", "2", "450px", "");
        else :
            $this->alert("Feito", "Foto adicionada com sucesso", "alert-success", "bom.png", "btn-success", "6", "2", "450px", "");
        endif; // Fim do insert->rowCount
    }
    public function alert($titulo, $mensagem, $tipo, $icon, $btn, $n1, $n2, $px, $href)
    { // Função para chamar o alert
        echo '<div class="container">
        <form action="">
            <div class = "row">
                <div class = "col-md-' . $n1 . ' col-md-offset-' . $n2 . '">
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
    // Consultar os últimos 10 produtos cadastrado
    public function novosProdutos()
    {
        $consultar = Conexao::getConnect()->prepare('SELECT * FROM view_novo_produto;'); // Views
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
    //Consultar foto do produto
    public function fotoProduto()
    {
        $consultar = Conexao::getConnect()->prepare('SELECT pf.foto FROM produto AS p INNER JOIN produtofoto AS pf
        ON p.idproduto = pf.fkproduto WHERE p.idproduto =?;');
        $consultar->bindValue(1, $this->getIdproduto());
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
    // Consultar os produtos mais vendidos
    public function produtoMaisvendido()
    {
        $consultar = Conexao::getConnect()->prepare('SELECT * FROM `view_produto_mais_vendido`;'); // Views
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
    // Consultar produtos do carrinho
    public function produtoCarrinho()
    {
        $consultar = Conexao::getConnect()->prepare('CALL `proced_ver_carrinho`(?);'); // procedimento
        $consultar->bindValue(1, $this->getIdproduto());
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function pesquisarProduto()
    {
        $this->setNome(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getNome()));
        $consultar = Conexao::getConnect()->prepare('CALL `proced_pesquisa`(?);'); // procedimento
        $consultar->bindValue(1, htmlspecialchars($this->getNome()));
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
     //////////////////////////////////////////////////////////////////////////////////////////////////////
    private $idproduto;
    private $nome;
    private $quantidade;
    private $preco_ac;
    private $preco_at;
    private $descricao;
    private $fkestado;
    private $fkcategoria;
    private $usuario;
    private $visibilidade;

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
    public function getFkestado()
    {
        return $this->fkestado;
    }
    public function setFkestado($fkestado)
    {
        $this->fkestado = $fkestado;
    }
    public function getFkcategoria()
    {
        return $this->fkcategoria;
    }
    public function setFkcategoria($fkcategoria)
    {
        $this->fkcategoria = $fkcategoria;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    public function getVisibilidade()
    {
        return $this->visibilidade;
    }
    public function setVisibilidade($visibilidade)
    {
        $this->visibilidade = $visibilidade;
    }

    public function alertprod($titulo, $mensagem, $tipo, $icon, $btn, $n1, $n2, $px, $herf)
    { // Função para chamar o alert
        echo '<div class="container">
        <form action="">
            <div class = "row">
                <div class = "col-md-' . $n1 . ' col-md-offset-' . $n2 . '">
                    <div class="alert ' . $tipo . ' fade in">
                        <img src="../img/alert/' . $icon . '" alt="">
                        <strong>' . $titulo . '</strong> ' . $mensagem . '
                        <a href= "'.$herf.'" class="btn ' . $btn . '" data-dismiss="alert" style="margin-left:' . $px . '">ok</a>
                    </div>
                </div>
            </div>
            </form>
        </div>';
    }
    public function buscarProdutos()
    {
        // acessar a base de dados
        $sql = 'SELECT p.idproduto, p.nome, p.quantidade, p.preco_ac, p.preco_at, p.data, p.descricao, 
        p.visibilidade, p.fkestado, p.fkcategoria, e.nomeestado, c.nomecategoria, sc.nomecategoria AS subcategoria
        , u.nome AS nomeusuario, pf.foto FROM produto AS p JOIN estado AS e ON p.fkestado = e.idestado 
        JOIN subcategoria AS sc ON p.fkcategoria = sc.idcategoria JOIN usuario AS u ON p.fkusuario = u.idusuario 
        JOIN categoria AS c ON sc.fkcategoria = c.idcategoria JOIN produtofoto AS pf ON p.idproduto = pf.fkproduto 
        GROUP BY p.nome';
        $buscar = Conexao::getConnect()->prepare($sql);
        $buscar->execute();

        if ($buscar->rowCount() > 0) : // Se existir um Produto
            return $buscar->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $this->alertprod("Aviso!", "Nenhum Produto cadastrado", "alert-info", "", "btn-info", "6", "0", "450px","");
        endif;
    }
    public function actualizarProdutos()
    {
        // acessar a base de dados
        $sql = "UPDATE produto set nome = ".'?'.", quantidade = ?, preco_ac = ?, preco_at = ?, descricao = ".'?'." , fkestado = ?, fkcategoria = ?, fkusuario = ".'?'.", visibilidade = ".'?'." where idproduto = ?";

        $buscar = Conexao::getConnect()->prepare($sql);
        $buscar->bindValue(1, $this->getNome());
        $buscar->bindValue(2, $this->getQuantidade());
        $buscar->bindValue(3, $this->getPreco_ac());
        $buscar->bindValue(4, $this->getPreco_at());
        $buscar->bindValue(5, $this->getDescricao());
        $buscar->bindValue(6, $this->getFkestado());
        $buscar->bindValue(7, $this->getFkcategoria());
        $buscar->bindValue(8, $this->getUsuario());
        $buscar->bindValue(9, $this->getVisibilidade());
        $buscar->bindValue(10, $this->getIdproduto());
        $buscar->execute();
        if ($buscar->rowCount() > 0) : // Se existir um Produto
            $this->alertprod("Feito!", "Produto Actualizado com Sucesso", "alert-success", "", "btn-success", "6", "2", "450px","admin.php?sessao=prodadmin");
            return $buscar->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $this->alertprod("Erro!", "Não Foi possivel Actualizar o Produto", "alert-danger", "", "btn-danger", "6", "0", "450px","");
        endif;
    }
    public function eliminarProdutos()
    {
        // acessar a base de dados
        $sql = "DELETE FROM produto WHERE idproduto = ?";

        $buscar = Conexao::getConnect()->prepare($sql);
        $buscar->bindValue(1, $this->getIdproduto());
        $buscar->execute();
        if ($buscar->rowCount() > 0) : // Se existir um Produto
            $this->alertprod("Feito!", "Produto Eliminado com Sucesso", "alert-success", "", "btn-success", "6", "0", "450px","admin.php?sessao=prodadmin");
            return $buscar->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $this->alertprod("Erro!", "Não Foi possivel Eliminar o Produto", "alert-danger", "", "btn-danger", "6", "0", "450px","admin.php?sessao=prodadmin");
        endif;
    }
}
