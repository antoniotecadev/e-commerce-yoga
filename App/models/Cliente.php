<?php
include_once 'Conexao.php';
include_once 'Pessoa.php';
class Cliente extends Pessoa
{ // Modelo cliente
    private $rua;
    private $sexo;
    private $bairro;
    private $sobrenome;
    private $datanascimento;
    public function getRua()
    {
        return $this->rua;
    }
    public function setRua($rua)
    {
        $this->rua = $rua;
    }
    public function getSexo()
    {
        return $this->sexo;
    }
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function getBairro()
    {
        return $this->bairro;
    }
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }
    public function getSobrenome()
    {
        return $this->sobrenome;
    }
    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
    }
    public function getDatanascimento()
    {
        return $this->datanascimento;
    }
    public function setDatanascimento($datanascimento)
    {
        $this->datanascimento = $datanascimento;
    }

    // Funções para acessar a base de dados
    public function criarConta()
    {
        // Verificar a idade do cliente
        $data = date('Y');
        $idade = $data - substr($this->getDatanascimento(), 0, 4);

        if ((!empty($this->getNome())) && (!empty($this->getSobrenome())) && (!empty($this->getTelefone()))
            && (!empty($this->getBairro())) && (!empty($this->getRua())) && (!empty($this->getEmail())) && (!empty($this->getPalavrapasse()))
        ) :

            if (!preg_match("/^[a-z\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getNome())) :
                $this->alert("Falha!", "Nome não é válido <strong>Não introduzir</strong> 0-9 :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[a-z\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getSobrenome())) :
                $this->alert("Falha!", "Sobrenome não é válido <strong>Não introduzir</strong> 0-9 :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[0-9]+$/i", $this->getTelefone())) :
                $this->alert("Falha!", "Número de telefone não é válido <strong>Não introduzir</strong> letras :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\ etc.", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[a-z0-9\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\:\,\.\- ]+$/i", $this->getBairro())) :
                $this->alert("Falha!", "Bairro não é válido <strong>Não introduzir</strong> ; ~ ` ! @ # $ % & ( ) - _ = + / < > ? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[a-z0-9\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\:\,\.\- ]+$/i", $this->getRua())) :
                $this->alert("Falha!", "Rua não é válida <strong>Não introduzir</strong> :; ~ ` ! @ # $ % & ( ) _ = + / < > ? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[a-z@0-9.\-\_]+$/i", $this->getEmail())) :
                $this->alert("Falha!", "E-mail não é válido <strong>Não introduzir</strong> :; ~ ` ! # $ % & ( ) = + / < > , ? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!preg_match("/^[a-z0-9]+$/i", $this->getPalavrapasse())) :
                $this->alert("Falha!", "Palavra - passe não é válida <strong>Não introduzir</strong> :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (strlen($this->getNome()) < 5) : //Contar a quantidade de caracteres
                $this->alert("Falha!", "<strong>" . $this->getNome() . "</strong> Nome muito curto ", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (strlen($this->getSobrenome()) < 5) : //Contar a quantidade de caracteres
                $this->alert("Falha!", "<strong>" . $this->getSobrenome() . "</strong> Sobrenome muito curto  ", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (strlen($this->getTelefone()) != 9) : //Contar a quantidade de caracteres
                $this->alert("Falha!", "Número de telefone deve ter 9 dígitos", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (strlen($this->getPalavrapasse()) < 6) : // Verificar palavra passe
                $this->alert("Falha!", "Palavra - passe muito curta", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif ($idade < 16) :
                $this->alert("Erro!", "Não é permitido criar conta à menor de <strong>16</strong> anos", "alert-danger", "btn-danger", "erro.png", "javascript:history.go(-1)", "Retificar");
            elseif (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) :
                $this->alert("Erro!", "E-mail inválido", "alert-danger", "btn-danger", "erro.png", "javascript:history.go(-1)", "Retificar");
            else :
                // Limpar símbolos
                $this->setNome(preg_replace('/[^[a-z]_]/', ' ', $this->getNome()));
                $this->setSobrenome(preg_replace('/[^[a-z]_]/', ' ', $this->getSobrenome()));
                $this->setTelefone(preg_replace('/[^[0-9]_]/', ' ', $this->getTelefone()));
                $this->setBairro(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getBairro()));
                $this->setRua(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getrua()));
                $this->setEmail(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getEmail()));
                $this->setPalavrapasse(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getPalavrapasse()));
                $sql = "INSERT INTO cliente (nome,sobrenome,datanascimento,sexo,telefone1,bairro,rua,email,pass) VALUES
            (?,?,?,?,?,?,?,?,?)";

                try {
                    $pdo = Conexao::getConnect();
                    $inserir = $pdo->prepare($sql);
                    $inserir->bindValue(1, $this->getNome());
                    $inserir->bindValue(2, $this->getSobrenome());
                    $inserir->bindValue(3, $this->getDatanascimento());
                    $inserir->bindValue(4, $this->getSexo());
                    $inserir->bindValue(5, $this->getTelefone());
                    $inserir->bindValue(6, $this->getBairro());
                    $inserir->bindValue(7, $this->getRua());
                    $inserir->bindValue(8, $this->getEmail());
                    $inserir->bindValue(9, md5(md5($this->getPalavrapasse())));
                    $inserir->execute();
                } catch (PDOException $e) {
                    if ($e->getCode() == 23000) { // Código para violação de restrição de integridade
                        if (strpos($e->getMessage(), 'telefone1_UNIQUE') !== false)
                            $this->alert("Erro!", "<p class='text-center'>O número de telefone " . $this->getTelefone() . ", já está registado. Por favor, use um número diferente.</p>", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "RETIFICAR");
                        elseif (strpos($e->getMessage(), 'email_UNIQUE') !== false || strpos($e->getMessage(), "for key 'email'") !== false)
                            $this->alert("Erro!", "<p class='text-center'>O endereço de email <b>" . $this->getEmail() . "</b>,  já está registado. Por favor, use um email diferente.</p>", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "RETIFICAR");
                    } else
                        $this->alert("Falha!", "<p class='text-center'>Ocorreu um erro ao registar. Por favor, tente novamente.</p>", "alert-warning", "btn-warning", "erro.png", "javascript:history.go(-1)", "TENTAR NOVAMENTE");
                    return;
                }

                $this->setId($pdo->lastInsertId()); // Valor do ID incrementado automaticamente para uma linha acabada de inserir na tabela produto
                if ($inserir->rowCount()) :
                    $consultar = Conexao::getConnect()->prepare('SELECT  idcliente, nome, sobrenome, datanascimento, sexo,telefone1,bairro,rua,email FROM cliente WHERE idcliente = ?');
                    $consultar->bindValue(1, $this->getId());
                    $consultar->execute();

                    if ($consultar->rowCount()) :
                        $cliente = $consultar->fetchAll(\PDO::FETCH_ASSOC);
                        if (!isset($_SESSION)) :
                            session_start();
                        endif;
                        foreach ($cliente as $dados) :
                        endforeach;
                        //  $envio = mail("antonioteca@hotmail.com", "Dados da sua Conta Koop", "<img src='../img/logo/koop-logo.png'><br><strong>Nome: </strong>".$dados['nome']." ".$dados['sobrenome']."<br><strong>Data de nascimento: </strong>".$dados['datanascimento']."<br><strong>Sexo: </strong>".$dados['sexo']."<br><strong>Número de telefone: </strong>".$dados['telefone1']."<br><strong>Bairro: </strong>".$dados['bairro']."<br><strong>Rua: </strong>".$dados['rua']."<br><strong>E-mail: </strong>". $dados['email']."<br><strong>Palavra-passe: </strong>".$this->getPalavrapasse()."<br><br>http://www.koopangola.com<br><strong>Email: </strong>koop@koopangola.com","Content-type: text/html; charset=UTF-8\r\nDe:koop@koopangola");
                        // if($envio){
                        // }
                        // enviarDadosClienteEmail($dados['nome'], $dados['sobrenome'], $dados['datanascimento'], $dados['sexo'], $dados['telefone1'], $dados['bairro'], $dados['rua'], $dados['email'], $this->getPalavrapasse());
                        $this->alert(
                            "Cadastro",
                            "" . "feito com sucesso, clique continuar para começar as suas compras no <strong>KOOP</strong>",
                            "alert-success",
                            "btn-success",
                            "bom.png",
                            "../views/index.php?cli=true&nome=" . base64_encode(base64_encode($dados['nome'])) . "&sobrenome=" . base64_encode(base64_encode($dados['sobrenome'])) . "&eml=" . base64_encode(base64_encode($dados['email'])),
                            "continuar"
                        );
                    endif;
                else :
                    $this->alert("Erro!", "Verifique seu número de telefone ou email, eles devem estar a ser usado por um outro cliente", "alert-danger", "btn-danger", "erro.png", "javascript:history.go(-1)", "Voltar a tentar");
                endif; // Fim do insert->rowCount
            endif; // fim preg_match
        endif; // fim empty
    }
    public function actDadosCli()
    {
        // Verificar a idade do cliente
        $data = date('Y');
        $idade = $data - substr($this->getDatanascimento(), 0, 4);
        if (!preg_match("/^[a-z\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getNome())) :
            $this->alert("Falha!", "Nome não é válido <strong>Não introduzir</strong> 0-9 :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (!preg_match("/^[a-z\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getSobrenome())) :
            $this->alert("Falha!", "Sobrenome não é válido <strong>Não introduzir</strong> 0-9 :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\, etc.", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (!preg_match("/^[0-9]+$/i", $this->getTelefone())) :
            $this->alert("Falha!", "Número de telefone não é válido <strong>Não introduzir</strong> letras :; ~ ` ! @ # $ % & ( ) - _ = + / < > , .? [ ]{ } * | \\ etc.", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (!preg_match("/^[a-z0-9\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\:\,\.\- ]+$/i", $this->getBairro())) :
            $this->alert("Falha!", "Bairro não é válido <strong>Não introduzir</strong> ; ~ ` ! @ # $ % & ( ) - _ = + / < > ? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (!preg_match("/^[a-z0-9\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û\:\,\.\- ]+$/i", $this->getRua())) :
            $this->alert("Falha!", "Rua não é válida <strong>Não introduzir</strong> :; ~ ` ! @ # $ % & ( ) _ = + / < > ? [ ]{ } * | \\ etc", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (strlen($this->getNome()) < 5) : //Contar a quantidade de caracteres
            $this->alert("Falha!", "<strong>" . $this->getNome() . "</strong> Nome muito curto ", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (strlen($this->getSobrenome()) < 5) : //Contar a quantidade de caracteres
            $this->alert("Falha!", "<strong>" . $this->getSobrenome() . "</strong> Sobrenome muito curto  ", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (strlen($this->getTelefone()) != 9) : //Contar a quantidade de caracteres
            $this->alert("Falha!", "Número de telefone deve ter 9 dígitos", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif ($idade < 16) :
            $this->alert("Erro!", "Não é permitido idade menor que <strong>16</strong> anos", "alert-danger", "btn-danger", "erro.png", "javascript:history.go(-1)", "Retificar");
        else :
            $sql = 'UPDATE `cliente` SET `nome`=?,`sobrenome`=?,`datanascimento`=?,`sexo`=?,`telefone1`=?,`bairro`=?,`rua`=? WHERE idcliente = ?';
            $actualizar = Conexao::getConnect()->prepare($sql);
            $actualizar->bindValue(1, htmlspecialchars($this->getNome()));
            $actualizar->bindValue(2, htmlspecialchars($this->getSobrenome()));
            $actualizar->bindValue(3, htmlspecialchars($this->getDatanascimento()));
            $actualizar->bindValue(4, htmlspecialchars($this->getSexo()));
            $actualizar->bindValue(5, htmlspecialchars($this->getTelefone()));
            $actualizar->bindValue(6, htmlspecialchars($this->getBairro()));
            $actualizar->bindValue(7, htmlspecialchars($this->getRua()));
            $actualizar->bindValue(8, htmlspecialchars($this->getId()));
            $actualizar->execute();
            if ($actualizar->rowCount()) :
                $consultar = Conexao::getConnect()->prepare('SELECT  idcliente, nome, sobrenome, datanascimento, sexo,telefone1,bairro,rua,email FROM cliente WHERE idcliente = ?');
                $consultar->bindValue(1, $this->getId());
                $consultar->execute();
                $cliente = $consultar->fetchAll(\PDO::FETCH_ASSOC);
                if ($consultar->rowCount()) :
                    if (!isset($_SESSION)) :
                        session_start();
                    endif;
                    foreach ($cliente as $dados) :
                        $_SESSION['idcliente'] = $dados['idcliente'];
                        $_SESSION['nomecli'] = $dados['nome'];
                        $_SESSION['sobrenome'] = $dados['sobrenome'];
                        $_SESSION['datanascimento'] = $dados['datanascimento'];
                        $_SESSION['sexo'] = $dados['sexo'];
                        $_SESSION['telefone1'] = $dados['telefone1'];
                        $_SESSION['bairro'] = $dados['bairro'];
                        $_SESSION['rua'] = $dados['rua'];
                        $_SESSION['email'] = $dados['email'];
                    endforeach;
                    $this->alert("Feito", "<p class='text-center'>Actualização de dados efectuada com sucesso.</p>", "alert-success", "btn-success", "bom.png", "?sessao=perfil", "OK");
                else :
                    $this->alert("Erro!", "<p class='text-center'>Consulta de dados actualizados não efectuada.</p>", "alert-danger", "btn-danger", "erro.png", "", "OK");
                endif;
            else :
                $this->alert("Erro!", "<p class='text-center'>1- Verifique seu número de telefone ou email, eles devem estar a ser usado por um outro cliente</p>.<p class='text-center'>2- Caso não tenha feito nenhuma alteração nos dados não será possível actualizar os mesmos.</p>", "alert-danger", "btn-danger", "erro.png", "javascript:history.go(-1)", "OK");
            endif; // Fim do insert->rowCount
        endif;
    }
    public function actPalavraPasse($pass, $pass1, $pass2)
    {
        if (!preg_match("/^[a-z0-9]+$/i", $pass)) :
            $this->alert("Falha!", "<p class='text-center'>Palavra - passe actual não é válida.</p>", "alert-warning", "btn-warning", "erro.png", "", "OK");
        elseif (!preg_match("/^[a-z0-9]+$/i", $pass1)) :
            $this->alert("Falha!", "<p class='text-center'>Nova palavra - passe não é válida.</p>", "alert-warning", "btn-warning", "erro.png", "", "OK");
        else :
            $sql = "SELECT c.nome from cliente as c WHERE c.pass=? ";
            $alterar = Conexao::getConnect()->prepare($sql);
            $alterar->bindValue(1, htmlspecialchars(md5(md5($pass))));
            $alterar->execute();
            if ($alterar->rowCount() > 0) : // Se existir um usuário
                if ($pass1 == $pass2) :
                    $sql = 'UPDATE `cliente` SET `pass`=? WHERE idcliente = ?';
                    $actualizar = Conexao::getConnect()->prepare($sql);
                    $actualizar->bindValue(1, htmlspecialchars(md5(md5($pass1))));
                    $actualizar->bindValue(2, htmlspecialchars($this->getId()));
                    $actualizar->execute();
                    if ($alterar->rowCount() > 0) :
                        $this->alert("Feito", "<p class='text-center'>Palavra - passe alterada.</p>", "alert-success", "btn-success", "bom.png", "", "OK");
                    else :
                        $this->alert("Erro!", "<p class='text-center'>Palavra - passe não alterada.</p>", "alert-danger", "btn-danger", "erro.png", "", "OK");
                    endif;
                else :
                    $this->alert("Erro!", "<p class='text-center'>Nova palavra - passe não coincide com a palavra - passe repetida.</p>", "alert-warning", "btn-warning", "erro.png", "", "OK");
                endif;
            else :
                $this->alert("Erro!", "<p class='text-center'>Palavra - passe actual errada.</p>", "alert-danger", "btn-danger", "erro.png", "", "OK");
            endif;
        endif;
    }

    public function encontrarCliente($telemail)
    {
        $sql = "SELECT nome from cliente WHERE (email=? or telefone1=?)";
        $encontrar = Conexao::getConnect()->prepare($sql);
        $encontrar->bindValue(1, htmlspecialchars($telemail));
        $encontrar->bindValue(2, htmlspecialchars($telemail));
        $encontrar->execute();
        if ($encontrar->rowCount()) :
        // $encontrar->fetchAll(\PDO::FETCH_ASSOC);
        else :
        endif;
    }

    public function alert($titulo, $mensagem, $tipo, $btn, $img, $href, $op)
    { // Função para chamar o alert
        echo '<div class="container">
        <form action="">
            <div class = "row">
                <div class = "col-xs-10 col-md-offset-1 col-md-10">
                    <div class="alert ' . $tipo . '">
                    <img src="../img/alert/' . $img . '" width=50px; height=50px; alt="">
                        <strong>' . $titulo . '</strong> ' . $mensagem . '
                        <div class="col-xs-offset-10">
                            <a href="' . $href . '"  class="btn btn-sm ' . $btn . '" data-dismiss="alert">' . $op . '</a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>';
    }

    public function buscarCliente()
    { // Método para buscar Clientes
        $cliente = Conexao::getConnect()->prepare("SELECT *FROM cliente ORDER BY idcliente DESC");
        $cliente->execute();
        return $cliente->fetchAll(\PDO::FETCH_ASSOC);
    }
}

function enviarDadosClienteEmail($nome, $sobrenome, $datanascimento, $sexo, $telefone, $bairro, $rua, $email, $palavrapasse)
{
    $imagem_nome = "../img/logo/koop-logo.png";
    $arquivo = fopen($imagem_nome, 'r');
    $contents = fread($arquivo, filesize($imagem_nome));
    $encoded_attach = chunk_split(base64_encode($contents));
    fclose($arquivo);
    $limitador = "_=======" . date('YmdHms') . time() . "=======_";

    $mailheaders = "From: Koop <koop@koopangola.com>\r\n";
    $mailheaders .= "MIME-version: 1.0\r\n";
    $mailheaders .= "Content-type: multipart/related; boundary=\"$limitador\"\r\n";
    $cid = date('YmdHms') . '.' . time();

    $texto = "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
	    <meta charset='utf-8'>
    </head>
    <body>
    <img src=\"cid:$cid\"><br><br>
        <strong>Nome: </strong>" . $nome . " " . $sobrenome . "<br>
        <strong>Data de nascimento: </strong>" . $datanascimento . "<br>
        <strong>Sexo: </strong>" . $sexo . "<br>
        <strong>Número de telefone: </strong>" . $telefone . "<br>
        <strong>Bairro: </strong>" . $bairro . "<br>
        <strong>Rua: </strong>" . $rua . "<br>
        <strong>E-mail: </strong>" . $email . "<br>
        <strong>Palavra-passe: </strong>" . $palavrapasse . "<br><br>
        <div>
        <p>Koop é um e-commerce Angolano desenvolvido pelo Koop(Empresa de tecnologia de software).</p>
                        <nav>
                            <h5>Linhas de produtos que o koop vende:</h5>
                            <ol>
                                <li><i style='color:greenyellow;''></i> Tv's</li>
                                <li><i style='color:greenyellow;'></i> Alimentos</li>
                                <li><i style='color:greenyellow;''></i> Vestuários</li>
                                <li><i style='color:greenyellow;'></i> Smartphone</li>
                                <li><i style='color:greenyellow;></i> Mobílias</li>
                                <li><i style='color:greenyellow;'></i> Ferramentas</li>
                                <li><i style='color:greenyellow;'></i> Utensílios plásticos</li>
                                <li><i style='color:greenyellow;'></i> Produtos para crianças</li>
                                <li><i style='color:greenyellow;'></i> Electrodomésticos</li>
                                <li><i style='color:greenyellow;'></i> Produtos de beleza</li>
                                <li><i style='color:greenyellow;'></i> Produtos de higiene</li>
                                <li><i style='color:greenyellow;'></i> Artigos de cozinha</li>
                                <li><i style='color:greenyellow;'></i> Instrumentos musicais</li>
                                <li><i style='color:greenyellow;'></i> Aparelhos de son</li>
                                <li><i style='color:greenyellow;'></i> Acessórios pessoais(joias, relógios...)</li>
                                <li><i style='color:greenyellow;'></i> etc.</li>
                            </ol>
                        </nav>
                    </div>
        <br>
        <a href='http://www.koopangola.com'>www.koopangola.com</a><br><br>
        <p>O MERCADO NUM CLICK 👌<p>
    </body>
    </html>
    ";

    $msg_body = "--$limitador\r\n";
    $msg_body .= "Content-type: text/html; charset=utf-8\n";
    $msg_body .= "$texto\r\n";
    $msg_body .= "--$limitador\r\n";
    $msg_body .= "Content-type: image/png; name=\"$imagem_nome\"\r\n";
    $msg_body .= "Content-Transfer-Encoding: base64\r\n";
    $msg_body .= "Content-ID: <$cid>\r\n";
    $msg_body .= "\n$encoded_attach\r\n";
    $msg_body .= "--$limitador--\r\n";

    $envio = mail($email, '=?UTF-8?B?' . base64_encode("Dados da sua Conta Koop") . '?=', $msg_body, $mailheaders);
    if ($envio) {
    }
}
