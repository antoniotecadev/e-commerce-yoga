<?php
include_once 'Conexao.php';
class Encomenda
{
    private $detalhe;
    private $idcliente;
    private $idproduto;
    private $quantidade;
    private $parcela;
    private $idprodo;
    private $idusuario;
    private $operacao; 

    public function getDetalhe()
    {
        return $this->detalhe;
    }
    public function setDetalhe(string $detalhe)
    {
        $this->detalhe = $detalhe;
    }
    public function getIdcliente()
    {
        return $this->idcliente;
    }
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    }
    public function getIdproduto()
    {
        return $this->idproduto;
    }
    public function setIdproduto(array $idproduto)
    {
        $this->idproduto = $idproduto;
    }
    public function getQuantidade()
    {
        return $this->quantidade;
    }
    public function setQuantidade(array $quantidade)
    {
        $this->quantidade = $quantidade;
    }
    public function getParcela()
    {
        return $this->parcela;
    }
    public function setParcela(array $parcela)
    {
        $this->parcela = $parcela;
    }
    public function getIdprodo()
    {
        return $this->idprodo;
    }
    public function setIdprodo(array $idprodo)
    {
        $this->idprodo = $idprodo;
    }
    public function getOperacao()
    {
        return $this->operacao;
    }
    public function setOperacao($operacao)
    {
        $this->operacao = $operacao;
    }
    public function getIdusuario()
    {
        return $this->idusuario;
    }
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    public function encomendar()
    {
        if (empty($this->getIdcliente()) && empty($this->getIdproduto()) && empty($this->getDetalhe()) && empty($this->getQuantidade())) :

        else :
            $this->setIdcliente(preg_replace('/[^[0-9]_]/', '', $this->getIdcliente()));
            $this->setIdproduto(preg_replace('/[^[0-9]_]/', '', $this->getIdproduto()));
            $this->setDetalhe(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getDetalhe()));
            $this->setQuantidade(preg_replace('/[^[0-9]_]/', '', $this->getQuantidade()));
            $sql = 'INSERT INTO encomendacliente (fkcliente, detalhe) VALUES (?, ?)'; // Cadastrar cliente
            $pdo = Conexao::getConnect();
            $pdo->beginTransaction(); // Início da transação
            $inserir = $pdo->prepare($sql);
            $inserir->bindValue(1, $this->getIdcliente());
            $inserir->bindValue(2, htmlspecialchars($this->getDetalhe()));
            $inserir->execute();
            $idencocli = $pdo->lastInsertId(); // Valor do ID incrementado automaticamente para uma linha acabada de inserir na tabela encomendacliente

            if (!$inserir->rowCount()) :
                die(""); // Parar a execução
            endif; // Fim do insert->rowCount
            $this->cadastrarProdutos($pdo, $idencocli);
        endif;
    }

    public function cadastrarProdutos($pdo, $idencocli)
    {
        $feito = array(); // Array de falhas
        $q = 0; //
        foreach ($this->getIdproduto() as $idprod) :
            $inserir = $pdo->prepare('INSERT INTO encomendaproduto (fkencocli, fkproduto, quantidade) VALUES (?, ?, ?)');
            $inserir->bindValue(1, $idencocli);
            $inserir->bindValue(2, $idprod);
            $inserir->bindValue(3, base64_decode(base64_decode($this->getQuantidade()[$q++])));
            $inserir->execute();

            if (!$inserir->rowCount()) :
                die(""); // Parar a execução
            endif;
        endforeach;
        $this->produtoPrestacao($pdo);
    }

    public function produtoPrestacao($pdo)
    {
        $p = 0;
        foreach ($this->getIdprodo() as $idp) :
            $inserir = $pdo->prepare('INSERT INTO prestacao (parcela, fkproduto) VALUES (?, ?);');
            $inserir->bindValue(1, $this->getParcela()[$p++]);
            $inserir->bindValue(2, $idp);
            $inserir->execute();

            if (!$inserir->rowCount()) :
                $pdo->rollBack(); // Cancelar as transações
                die(""); // Parar a execução
            else :
                $feito[0] = true;
            endif;
        endforeach;
        $pdo->commit(); // Finalizar as transações
        if (count($feito) > 0) :
            if (!isset($_SESSION)) :
                session_start();
            endif;
            $ids = array(); // Array que guarda id
            $i = 0;
            foreach ($this->getIdproduto() as $id) : // Eliminar produtos do carrinho
                $ids[$i++] = "&icquant[]=" . base64_encode(base64_encode($id)); // Adicionar quantidades no array e com as suas chaves
            endforeach;
            $this->enviarEmailEncomenda();
?>
            <script>
                window.location.href = "<?php $_SERVER['PHP_SELF']; ?>?sessao=home&encomenda=true<?php foreach ($ids as $v) : echo $v; endforeach;  ?>";
            </script>
            <?php endif;
    }

    public function notificacaoEncomenda()
    {
        $consultar = Conexao::getConnect()->prepare('SELECT * FROM `view_notificacao_encomenda`;'); // Views
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }

    // dados do produto
    public function dadosProduto()
    {
        $this->setIdcliente(preg_replace('/[^[0-9]_]/', ' ', $this->getIdcliente()));
        $consultar = Conexao::getConnect()->prepare('CALL `proced_encomenda_produto`(?);'); // procedimento
        $consultar->bindValue(1, htmlspecialchars($this->getIdcliente()));
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function visualizar()
    {
        $this->setIdcliente(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getIdcliente()));
        $this->setDetalhe(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getDetalhe()));
        $actualizar = Conexao::getConnect()->prepare('UPDATE encomendacliente SET visibilidade = ?, fkusuario = ?, porqueanulada = ? WHERE id=?'); // procedimento
        $actualizar->bindValue(1, htmlspecialchars($this->getOperacao()));
        $actualizar->bindValue(2, htmlspecialchars($this->getIdusuario())); 
        $actualizar->bindValue(3, htmlspecialchars($this->getDetalhe())); 
        $actualizar->bindValue(4, htmlspecialchars($this->getIdcliente()));
        $actualizar->execute();
        if ($actualizar->rowCount()) :
            if ($this->getOperacao() == 2) : ?>
                <script>
                    alert("✅ Encomenda adicionada como pendente.");
                    window.location.href = 'admin.php';
                </script>;
            <?php elseif ($this->getOperacao() == 3) : ?>
                <script>
                    alert("✅ Encomenda anulada.");
                    window.location.href = 'admin.php';
                </script>;
            <?php elseif ($this->getOperacao() == 4) : ?>
                <script>
                    alert("✅ Encomenda adicionada como concluída.");
                    window.location.href = 'admin.php';
                </script>;
            <?php endif;
        else : ?>
            <script>
                alert("Erro❗\n Operação não efectuada.");
            </script>;
<?php endif;
    }
    function operador(){
        $this->setIdusuario(preg_replace('/[^[0-9]_]/', ' ', $this->getIdusuario()));
        $consultar = Conexao::getConnect()->prepare('SELECT nome FROM usuario WHERE idusuario=?;'); // procedimento
        $consultar->bindValue(1, htmlspecialchars($this->getIdusuario()));
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function enviarEmailEncomenda(){
            $consultar = Conexao::getConnect()->prepare('SELECT * FROM `view_encomenda_email`;'); // Views
            $consultar->execute();
            if ($consultar->rowCount()) :
                $res = $consultar->fetchAll(\PDO::FETCH_ASSOC);
                foreach($res as $dados):
                $this->enviar($dados['dataencomenda'], $dados['nome'], $dados['telefone1']);
                endforeach;
            endif;
           
        }

        public function enviar($data, $nome, $telefone){

             $texto='
            <!DOCTYPE html>
            <html lang="pt-br">
            <head>
                <meta charset="utf-8">
            </head>
            <body>
                <h3>Dados do cliente</h3>
                <strong>Nome: </strong>'.$nome.'<br>
                <strong>Telefone: </strong>'.$telefone.'<br>
                
            </body>
            </html>
            ';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: '.$nome.' <koop@koopangola.com>' . "\r\n";

            $envio = mail("koopencomenda@outlook.com ","Encomenda", $texto, $headers);
            if($envio){
             }
        }

        /*
         CASO AS VIEWS NÃO FUNCIONEM
         public function notificacaoEncomenda()
        {
            $sql = "
                SELECT 
                    ec.id AS id,
                    ec.detalhe AS detalhe,
                    ec.dataencomenda AS dataencomenda,
                    ec.visibilidade AS visibilidade,
                    ec.fkusuario AS fkusuario,
                    ec.porqueanulada AS porqueanulada,
                    ct.nome AS nome,
                    ct.sobrenome AS sobrenome,
                    ct.sexo AS sexo,
                    ct.telefone1 AS telefone1,
                    ct.email AS email,
                    ct.bairro AS bairro,
                    ct.rua AS rua
                FROM 
                    encomendacliente ec
                JOIN 
                    cliente ct ON ct.idcliente = ec.fkcliente
                ORDER BY 
                    ec.id DESC
            ";

            $consultar = Conexao::getConnect()->prepare($sql);
            $consultar->execute();
            return $consultar->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function enviarEmailEncomenda()
        {
            $sql = "
                SELECT 
                    ec.dataencomenda AS dataencomenda,
                    ct.nome AS nome,
                    ct.telefone1 AS telefone1
                FROM 
                    encomendacliente ec
                JOIN 
                    cliente ct ON ct.idcliente = ec.fkcliente
                ORDER BY 
                    ec.id DESC
                LIMIT 1
            ";

            $consultar = Conexao::getConnect()->prepare($sql);
            $consultar->execute();

            if ($consultar->rowCount()) {
                $res = $consultar->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($res as $dados) {
                    $this->enviar($dados['dataencomenda'], $dados['nome'], $dados['telefone1']);
                }
            }
        }
    */
}