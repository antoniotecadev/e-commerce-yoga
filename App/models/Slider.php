<?php
include_once 'Conexao.php';
class Slider
{
    private $descricao;
    private $foto;
    private $visibilidade;

    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        return $this->descricao = $descricao;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto($foto)
    {
        return $this->foto = $foto;
    }
    public function getVisibilidade()
    {
        return $this->visibilidade;
    }
    public function setVisibilidade($visibilidade)
    {
        return $this->visibilidade = $visibilidade;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        return $this->usuario = $usuario;
    }
    public function getIdslider()
    {
        return $this->idslider;
    }
    public function setIdslider($idslider)
    {
        return $this->idslider = $idslider;
    }
    public function getPrimeiro()
    {
        return $this->primeiro;
    }
    public function setPrimeiro($primeiro)
    {
        return $this->primeiro = $primeiro;
    }

    public function cadastrarImagem()
    {
        if (!$this->getFoto()["name"]) :
            $this->alert("Falha!", "Adiciona a imagem", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
        else :

            $largura = 1600; // Largura máxima em pixels
            $altura = 450; // Altura máxima em pixels
            $tamanho = 716800; // Tamanho máximo da imagem em bytes
            $falha = array(); // Array de falhas

            if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $this->getFoto()["type"])) : // Verifica se o arquivo é uma imagem
                $falha[1] = "falha";
                $this->alert("Falha!", "Não é uma imagem, que vocé adicionou", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
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

            $caminho = "../img/sliders/"; // Pegar o caminho 

            $nome_imagem = $this->getFoto()["name"]; // Pegar o nome da imagem

            if ($nome_imagem != strtolower($this->getFoto()["name"])) : // Verificar se nome da imagem contem letras maiúsculas
                $falha[6] = "falha";
                $this->alert("Falha!", "O nome da foto  <strong>" . $nome_imagem . "</strong> não pode ter letras  <strong>maiúsculas</strong>", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (file_exists($caminho .  $nome_imagem)) : // Verificar se imagem ja existe na pasta slider
                $falha[7] = "falha";
                $this->alert("Falha!", "A imagem  <strong>" . $nome_imagem . "</strong> já existe", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (!preg_match("/^[a-z@0-9.\-\_\,\;\:\%\(\)\?\+\/\!\$\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\ 
                ]+$/i", $this->getDescricao())) :
                $falha[8] = "falha";
                $this->alert("Falha!", "Descrição da imagem não é válida<br><strong>Não introduzir</strong> = <> ~ ` # & * [ ]{ } * | \\, etc.", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (count($falha) == 0) : // Se não houver nenhuma falha executa

                $caminho_imagem = "../img/sliders/" . $nome_imagem;

                move_uploaded_file($this->getFoto()["tmp_name"], $caminho_imagem); // Faz o upload da imagem para seu respectivo caminho

                $inserir = Conexao::getConnect()->prepare('INSERT INTO `slider`(`descricao`, `foto`, `visibilidade`, `usuario`) VALUES (?,?,?,?)');
                $inserir->bindValue(1, $this->getDescricao());
                $inserir->bindValue(2, $nome_imagem);
                $inserir->bindValue(3, $this->getVisibilidade());
                $inserir->bindValue(4, $this->getUsuario());
                $inserir->execute();

                if ($inserir->rowCount()) :
                    $this->alert("Feito", "Imagem cadastrada com sucesso", "alert-success", "bom.png", "btn-success", "6", "2", "450px", "admin.php?sessao=cadfotoslider");
                else :
                    $this->alert("Erro!", "<h4 class='text-center'>Foto do produto não cadastrada</h4>", "alert-danger", "erro.png", "btn-danger", "6", "2", "450px", "");
                endif;
            endif;
        endif;
    }

    // Consultar imagens do slider
    public function imagemSlider()
    {
        $consultar = Conexao::getConnect()->prepare('SELECT idslider, foto, descricao, primeiro, visibilidade FROM slider;'); // Views
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
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
    public function actualizarImgSlider()
    {
        // acessar a base de dados
        // $sql = "UPDATE produto set nome = ".'?'.", quantidade = ?, preco_ac = ?, preco_at = ?, descricao = ".'?'." , fkestado = ?, fkcategoria = ?, fkusuario = ".'?'.", visibilidade = ".'?'." where idproduto = ?";
        $sql = "UPDATE slider set foto = ".'?'.", descricao = ".'?'.", primeiro = ".'?'.", visibilidade = ".'?'." where idslider = ?";

        $buscar = Conexao::getConnect()->prepare($sql);
        $buscar->bindValue(1, $this->getFoto());
        $buscar->bindValue(2, $this->getDescricao());
        $buscar->bindValue(3, $this->getPrimeiro());
        $buscar->bindValue(4, $this->getVisibilidade());
        $buscar->bindValue(5, $this->getIdslider());
        $buscar->execute();
        if ($buscar->rowCount() > 0) : // Se existir um Produto
            $this->alert("Feito!", "Imagem do Slider Actualizada com Sucesso", "alert-success", "", "btn-success", "6", "2", "450px","admin.php?sessao=sliders");
            return $buscar->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $this->alert("Erro!", "Não Foi possivel Actualizar a Imagem do slider", "alert-danger", "", "btn-danger", "6", "0", "450px","");
        endif;
    }

}
