<?php
include_once 'Conexao.php';
include_once 'Pessoa.php';
class Usuario extends Pessoa
{ // Modelo usuário
    private $nivel;
    private $foto;
    // Métodos gets e setts de usuário
    public function getNivel()
    {
        return $this->nivel;
    }
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
    public function entrarConta()
    {
        if ((!empty($this->getEmail())) && (!empty($this->getPalavrapasse()))) :
            if (preg_match("/^[a-z@0-9.\-\_]+$/i", $this->getEmail()) && preg_match("/^[a-z0-9]+$/i", $this->getPalavrapasse())) :
                $email =  preg_replace('/[^[a-z0-9]_]/', '', $this->getEmail());
                $palavrapasse =  preg_replace('/[^[:alnum:]_]/', '', $this->getPalavrapasse());
                if (strlen($palavrapasse) == 15) :
                        $sqlusuario = 'SELECT u.idusuario, u.nome, u.email, u.telefone, u.pass, n.nivel, u.foto
                    FROM usuario AS u INNER JOIN nivelacesso AS n ON n.idnivel = u.fknivel
                    WHERE (email =? or telefone =?) and pass =?;';
                        $entrar = Conexao::getConnect()->prepare($sqlusuario);
                else :
                    $sqlcliente = 'SELECT  idcliente, nome, sobrenome, datanascimento, sexo, telefone1, bairro , rua ,email
                    FROM cliente WHERE (email =? or telefone1 =?) and pass =?;';
                    $entrar = Conexao::getConnect()->prepare($sqlcliente);
                endif;
                $entrar->bindValue(1, htmlspecialchars($email));
                $entrar->bindValue(2, htmlspecialchars($email));
                $entrar->bindValue(3, htmlspecialchars(md5(md5($palavrapasse)))); // Criptografar a senha
                $entrar->execute();
                if ($entrar->rowCount() > 0) : // Se usuário está cadastrado executa
                    if (!isset($_SESSION)) :
                        session_start();
                    endif;
                    $user = $entrar->fetchAll(\PDO::FETCH_ASSOC);
                    foreach ($user as $dados) :
                        if (strlen($palavrapasse) == 15) :
                            $_SESSION['idusuario'] = $dados['idusuario'];
                            $_SESSION['nome'] = $dados['nome'];
                            $_SESSION['nivel'] = $dados['nivel'];
                            $_SESSION['foto'] = $dados['foto'];
                            header("location: ../views/admin.php");
                        else :
                            $_SESSION['idcliente'] = $dados['idcliente'];
                            $_SESSION['nomecli'] = $dados['nome'];
                            $_SESSION['sobrenome'] = $dados['sobrenome'];
                            $_SESSION['datanascimento'] = $dados['datanascimento'];
                            $_SESSION['sexo'] = $dados['sexo'];
                            $_SESSION['telefone1'] = $dados['telefone1'];
                            $_SESSION['bairro'] = $dados['bairro'];
                            $_SESSION['rua'] = $dados['rua'];
                            $_SESSION['email'] = $dados['email'];
                        endif;
                        ?>
                        <script>
                            window.location.href = '<?php $_SERVER['PHP_SELF'];?>';
                        </script>
<?php
                    endforeach;
                else :
                    return false;
                endif;
            endif;
        endif;
    }
           
    public function buscarUsuarios()
    {
        // acessar a base de dados
        $sql = 'SELECT u.idusuario, u.nome, u.email, u.telefone, u.pass, n.nivel, u.foto
        FROM usuario AS u INNER JOIN nivelacesso AS n ON n.idnivel = u.fknivel;';
        $buscar = Conexao::getConnect()->prepare($sql);
        $buscar->execute();

        if ($buscar->rowCount() > 0) : // Se existir um usuário
            return $buscar->fetchAll(\PDO::FETCH_ASSOC);
        else :
            $this->alert("Aviso!", "Nenhum usuário cadastrado", "alert-info", "", "btn-info", "6", "0", "450px");
        endif;
    }
    public function carregarNivel()
    { // Método para buscar os níveis
        $nivel = Conexao::getConnect()->prepare('SELECT * FROM nivelacesso');
        $nivel->execute();
        return $nivel->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function cadastrar()
    { // Cadastrar usuário
        if (empty($this->getFoto()['name'])) :
            $this->validarDados("Sem foto");
        else :
            $this->validarFoto();
        endif;
    }
    public function validarDados($foto)
    { // Método para validar dados
        if ((!empty($this->getEmail())) && (!empty($this->getPalavrapasse())) && (!empty($this->getNome())) && (!empty($this->getTelefone()))) :
            // Verificação de entrada
            if (!preg_match("/^[a-z\á-ú\à-ù\ã-õ\â-û\Á-Ú\À-Ù\Ã-Õ\Â-Û ]+$/i", $this->getNome())) :
                $this->alert("Falha!", "O nome não é válido", "alert-warning", "", "btn-warning", "6", "0", "450px");
            elseif (!preg_match("/^[a-z@0-9.\-\_]+$/i", $this->getEmail())) :
                $this->alert("Falha!", "O email não é válido", "alert-warning", "", "btn-warning", "6", "0", "450px");
            elseif (!preg_match("/^[0-9]+$/i", $this->getTelefone())) :
                $this->alert("Falha!", "O número de telefone não é válido", "alert-warning", "", "btn-warning", "6", "0", "450px");
            elseif (!preg_match("/^[a-z0-9]+$/i", $this->getPalavrapasse())) :
                $this->alert("Falha!", "A palavra-passe não é válida", "alert-warning", "", "btn-warning", "6", "0", "450px");
            elseif (strlen($this->getPalavrapasse()) < 15 || strlen($this->getPalavrapasse()) > 15) : // Verificar palavra passe
                $this->alert("Falha!", "Palavra - passe deve ter 15 caracteres", "alert-warning", "", "btn-warning", "6", "0", "450px");
            else :
                if (strlen($this->getNome()) < 15) : //Contar a quantidade de caracteres
                    $this->alert("Aviso!", "Nome muito curto", "alert-info", "", "btn-info", "6", "0", "450px");
                elseif (str_word_count($this->getNome(), 0) < 2) :
                    $this->alert("Aviso!", "Um único nome não é válido", "alert-info", "", "btn-info", "6", "0", "450px");
                else :
                    // Limpar caracteres especias
                    $nome = preg_replace('/[^[a-z]_]/', ' ', $this->getNome());
                    $email =  preg_replace('/[^[a-z0-9]_]/', '', $this->getEmail());
                    $telefone =  preg_replace('/[^[0-9]_]/', '', $this->getTelefone());
                    $palavrapasse =  preg_replace('/[^[:alnum:]_]/', '', $this->getPalavrapasse());
                    $nivel =  preg_replace('/[^[0-9]_]/', '', $this->getNivel());

                    // inseri dados do usuário na base de dados
                    $sql = 'INSERT INTO usuario (nome, email, telefone, pass, fknivel, foto)
                VALUES (?, ?, ?, ?, ?, ?)';

                    $inserir = Conexao::getConnect()->prepare($sql);
                    $inserir->bindValue(1, htmlspecialchars(ucwords($nome))); // Colocar a letra de cada palavra em maiúscula
                    $inserir->bindValue(2, htmlspecialchars($email));
                    $inserir->bindValue(3, htmlspecialchars($telefone));
                    $inserir->bindValue(4, htmlspecialchars(md5(md5($palavrapasse)))); // Criptografar a senha
                    $inserir->bindValue(5, htmlspecialchars($nivel));
                    $inserir->bindValue(6, htmlspecialchars($foto));
                    $inserir->execute();

                    if ($inserir->rowCount()) :
                        $this->alert("Feito", "Usuário cadastrado com sucesso", "alert-success", "bom.png", "btn-success", "6", "0", "450px");
                    else :
                        $this->alert("Erro!", "<h4 class='text-center'>Usuário não cadastrado</h4><h6 class='text-center'>E-mail ou número de telefone já cadastrado</h6>", "alert-danger", "erro.png", "btn-danger", "4", "1", "150px");
                    endif; // Fim do insert->rowCount
                endif; // Fim da verificação da contagem de caracteres
            endif; // Fim da verificação de entrada
        endif; // Fim da verificação de vazio
    }
    public function alert($titulo, $mensagem, $tipo, $icon, $btn, $n1, $n2, $px)
    { // Função para chamar o alert
        echo '<div class="container">
        <form action="admin.php?sessao=cadastrarusuario">
            <div class = "row">
                <div class = "col-md-' . $n1 . ' col-md-offset-' . $n2 . '">
                    <div class="alert ' . $tipo . ' fade in">
                        <img src="../img/alert/' . $icon . '" alt="">
                        <strong>' . $titulo . '</strong> ' . $mensagem . '
                        <a href="" class="btn ' . $btn . '" data-dismiss="alert" style="margin-left:' . $px . '">ok</a>
                    </div>
                </div>
            </div>
            </form>
        </div>';
    }
    public function validarFoto()
    {

        $largura = 50; // Largura máxima em pixels
        $altura = 50; // Altura máxima em pixels
        $tamanho = 9000; // Tamanho máximo da foto em bytes
        $falha = array(); // Array de falhas
        if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $this->getFoto()["type"])) : // Verifica se o arquivo é uma imagem
            $falha[1] = "falha";
            $this->alert("Falha!", "Não é uma foto, que vocé adicionou", "alert-warning", "", "btn-warning", "6", "0", "450px");
        endif;
        $dimensoes = getimagesize($this->getFoto()["tmp_name"]); // Pega as dimensões da imagem

        if ($dimensoes[0] > $largura) : // Verifica se a largura da imagem é maior que a largura permitida
            $falha[2] = "falha";
            $this->alert("Falha!", "A largura da imagem não deve ultrapassar " . $largura . " pixels", "alert-warning", "", "btn-warning", "6", "0", "450px");
        endif;
        if ($dimensoes[1] > $altura) : //  Verifica se a altura da imagem é maior que a altura permitida
            $falha[3] = "falha";
            $this->alert("Falha!", "A altura da imagem não deve ultrapassar " . $largura . " pixels", "alert-warning", "", "btn-warning", "6", "0", "450px");
        endif;
        // Verifica se o tamanho da imagem é maior que o tamanho permitido
        if ($this->getFoto()["size"] > $tamanho) :
            $falha[4] = "falha";
            $this->alert("Falha!", "A imagem deve ter no máximo " . $tamanho . " bytes", "alert-warning", "", "btn-warning", "6", "0", "450px");
        endif;

        $nome_imagem = strtolower($this->getFoto()["name"]);
        $caminho = "../img/usuario/";

        if (file_exists($caminho .  $nome_imagem)) :
            $falha[5] = "falha";
            $this->alert("Falha!", "A foto " . $nome_imagem . " já existe", "alert-warning", "", "btn-warning", "6", "0", "450px");
        endif;

        if (count($falha) == 0) : // Se não houver nenhuma falha executa
            $caminho_imagem = "../img/usuario/" . $nome_imagem; // Caminho de onde ficará a imagem
            move_uploaded_file($this->getFoto()["tmp_name"], $caminho_imagem); // Faz o upload da imagem para seu respectivo caminho
            $this->validarDados($nome_imagem);
        endif;
    }
}
