<?php
include_once 'Conexao.php';
class Comentario
{
    private $comentario;
    private $avaliacao;
    private $fkproduto;
    private $fkcliente;
    private $idproduto;
    private $salto;

    public function getComentario()
    {
        return $this->comentario;
    }
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }
    public function getAvaliacao()
    {
        return $this->avaliacao;
    }
    public function setAvaliacao($avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }
    public function getFkproduto()
    {
        return $this->fkproduto;
    }
    public function setFkproduto($fkproduto)
    {
        $this->fkproduto = $fkproduto;
    }
    public function getFkcliente()
    {
        return $this->fkcliente;
    }
    public function setFkcliente($fkcliente)
    {
        $this->fkcliente = $fkcliente;
    }
    public function getIdproduto()
    {
        return $this->idproduto;
    }
    public function setIdproduto($idproduto)
    {
        $this->idproduto = $idproduto;
    }
    public function getSalto()
    {
        return $this->salto;
    }
    public function setSalto($salto)
    {
        $this->salto = $salto;
    }
    // Comentar um produto
    public function comentar()
    {

        $this->setComentario(preg_replace('/[^[a-z0-9]_]/', ' ', $this->getComentario()));
        $this->setAvaliacao(preg_replace('/[^[0-5]_]/', ' ', $this->getAvaliacao()));
        $this->setFkproduto(preg_replace('/[^[0-9]_]/', ' ', $this->getFkproduto()));
        $this->setFkcliente(preg_replace('/[^[0-9]_]/', ' ', $this->getFkcliente()));

        $comentar = Conexao::getConnect()->prepare('CALL `proced_comentar`(?, ?, ?, ?);');
        $comentar->bindValue(1, htmlspecialchars($this->getComentario()));
        $comentar->bindValue(2, htmlspecialchars($this->getAvaliacao()));
        $comentar->bindValue(3, htmlspecialchars($this->getFkproduto()));
        $comentar->bindValue(4, htmlspecialchars($this->getFkcliente()));
        $comentar->execute();
        if ($comentar->rowCount()) : ?>
            <script>
                window.location.href = '<?php $_SERVER['PHP_SELF']; ?>';
            </script>
<?php else :
            $this->alertComentario("Comentario", "não enviado", "alert-danger", "btn-danger", "times");
        endif;
    }
    public function consultarComentario()
    { // consultar comentarios de um produto
        $consultar = Conexao::getConnect()->prepare('CALL `proced_ver_comentario`(?,?);'); // Procedure
        $consultar->bindValue(1, $this->getIdproduto());
        $consultar->bindValue(2, $this->getSalto());
        $consultar->execute();
        return $consultar->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function alertComentario($titulo, $mensagem, $tipo, $btn, $icon)
    { // Função para chamar o alert
        echo '
            <div class = "row">
                <div class = "col-md-12">
                    <div class="alert ' . $tipo . '">
                    <i class="fa fa-' . $icon . '"></i>
                    <strong>' . $titulo . '</strong> ' . $mensagem . '
                        <a class="btn btn-sm ' . $btn . '" data-dismiss="alert">ok</a>
                    </div>
                </div>
          </div>
          ';
    }
}
