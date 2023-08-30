<?php
include_once 'Conexao.php';
class Leilao
{
    private $idcliente;
    private $valorpago;
    private $nome;
    private $precoinicial;
    private $saltopreco;
    private $titulo;
    private $dia;
    private $hora;
    private $minuto;
    private $subtitulo;
    private $descricao;
    private $estado;
    private $foto;
    private $usuario;

    public function getIdcliente()
    {
        return $this->idcliente;
    }
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }
    public function getValorpago()
    {
        return $this->valorpago;
    }
    public function setValorpago($valorpago)
    {
        $this->valorpago = $valorpago;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function setNome($nome)
    {
        $this->nome = $nome;
    }
    public function getPrecoinicial()
    {
        return $this->precoinicial;
    }
    public function setPrecoinicial($precoinicial)
    {
        $this->precoinicial = $precoinicial;
    }
    public function getSaltopreco()
    {
        return $this->saltopreco;
    }
    public function setSaltopreco($saltopreco)
    {
        $this->saltopreco = $saltopreco;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function getDia()
    {
        return $this->dia;
    }
    public function setDia($dia)
    {
        $this->dia = $dia;
    }
    public function getHora()
    {
        return $this->hora;
    }
    public function setHora($hora)
    {
        $this->hora = $hora;
    }
    public function getMinuto()
    {
        return $this->minuto;
    }
    public function setMinuto($minuto)
    {
        $this->minuto = $minuto;
    }
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    public function getEstado()
    {
        return $this->estado;
    }
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function actualizarLeilão() // Actualizar leilão
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

            $caminho = "../img/produto-leilao/"; // Pegar o caminho com nome da categoria | nome categoria == nome da pasta

            $nome_foto = $this->getFoto()["name"]; // Pegar o nome da imagem

            if ($nome_foto != strtolower($this->getFoto()["name"])) : // Verificar se nome da imagem contem letras maiúsculas
                $falha[6] = "falha";
                $this->alert("Falha!", "O nome da foto  <strong>" . $nome_foto . "</strong> não pode ter letras  <strong>maiúsculas</strong>", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (file_exists($caminho .  $nome_foto)) : // Verificar
                $falha[7] = "falha";
                $this->alert("Falha!", "A foto  <strong>" . $nome_foto . "</strong> já existe", "alert-warning", "", "btn-warning", "6", "2", "450px", "");
            endif;

            if (count($falha) == 0) : // Se não houver nenhuma falha executa

                $caminho_imagem = "../img/produto-leilao/" . $nome_foto; // Pegar o caminho com nome da categoria | nome categoria == nome da pasta

                move_uploaded_file($this->getFoto()["tmp_name"], $caminho_imagem); // Faz o upload da imagem para seu respectivo caminho

                $sql = 'UPDATE `leilao` SET `nome`=?,`preco_inicial`=?,`salto_preco`=?,`titulo`=?,`dia`=?,`hora`=?,`minuto`=?,`subtitulo`=?,`descricao`=?,`estado`=?,`foto`=?,`usuario`=? WHERE 1';
                $actualizar = Conexao::getConnect()->prepare($sql);
                $actualizar->bindValue(1, htmlspecialchars($this->getNome()));
                $actualizar->bindValue(2, htmlspecialchars($this->getPrecoinicial()));
                $actualizar->bindValue(3, htmlspecialchars($this->getSaltopreco()));
                $actualizar->bindValue(4, htmlspecialchars($this->getTitulo()));
                $actualizar->bindValue(5, htmlspecialchars($this->getDia()));
                $actualizar->bindValue(6, htmlspecialchars($this->getHora()));
                $actualizar->bindValue(7, htmlspecialchars($this->getMinuto()));
                $actualizar->bindValue(8, htmlspecialchars($this->getSubtitulo()));
                $actualizar->bindValue(9, htmlspecialchars($this->getDescricao()));
                $actualizar->bindValue(10, htmlspecialchars($this->getEstado()));
                $actualizar->bindValue(11, htmlspecialchars($nome_foto));
                $actualizar->bindValue(12, htmlspecialchars($this->getUsuario()));
                $actualizar->execute();

                if ($actualizar->rowCount()) :
                    $this->limparTabela();
                    $this->alert("Feito", "Leilão actualizado com sucesso", "alert-success", "bom.png", "btn-success", "6", "2", "450px", "admin.php?sessao=actprodleilao");
                else :
                    $this->alert("Erro!", "<h4 class='text-center'>Leilão não actualizado</h4>", "alert-danger", "erro.png", "btn-danger", "6", "2", "450px", "");
                endif;
            endif;
        endif;
    }

    public function limparTabela()
    {
        $limpar = Conexao::getConnect()->prepare('TRUNCATE TABLE leilaocliente;');
        $limpar->execute();
    }


    public function dadosLeilao() // Consultar dados do produto
    {
        $consultar = Conexao::getConnect()->prepare('SELECT * FROM leilao limit 1;'); // 
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function pagar()
    {
        if (!empty($this->getIdcliente()) && !empty($this->getValorpago())) :

            $this->setIdcliente(preg_replace('/[^[0-9]_]/', ' ', $this->getIdcliente()));
            $this->setValorpago(preg_replace('/[^[0-9]_]/', ' ', $this->getValorpago()));

            $inserir = Conexao::getConnect()->prepare("INSERT INTO leilaocliente (fkcliente,valor_pago) VALUES (?,?)");
            $inserir->bindValue(1, $this->getIdcliente());
            $inserir->bindValue(2, $this->getValorpago());
            $inserir->execute();

            if ($inserir->rowCount()) :
                echo '<script> alert("Pago"); </script>';
                echo '<script> window.location.href=' . $_SERVER["PHP_SELF"] . '?sessao=leilao</script>';
            else :
                echo '<script> alert("Não Pago") </script>';
                echo '<script> window.location.href=' . $_SERVER["PHP_SELF"] . '?sessao=leilao</script>';
            endif;
        endif;
    }

    public function dadosCliente() // Consultar dados do CLIENTE consoante o leilão
    {
        $consultar = Conexao::getConnect()->prepare('SELECT c.nome, lc.valor_pago, lc.data FROM cliente as c inner join leilaocliente as lc on c.idcliente = lc.fkcliente
        ORDER BY lc.valor_pago DESC;');
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function maiorValor() // Maior valor pago
    {
        $consultar = Conexao::getConnect()->prepare('SELECT c.nome, c.sobrenome, Max(lc.valor_pago) FROM leilaocliente as lc INNER JOIN cliente as c on lc.fkcliente = c.idcliente
        ORDER BY lc.valor_pago DESC limit 1;');
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
}
