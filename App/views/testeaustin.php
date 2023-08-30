<?php
include_once '../controllers/ControlEstado.php';
include_once '../controllers/ControlSubCategoria.php';
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlUsuario.php';

$ce = new ControlEstado();
$csc = new ControlSubCategoria();
$cp = new ControlProduto();
$cu = new ControlUsuario();

if (!isset($_SESSION)) :
    session_start();
endif;
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) :
    header("location: entrar.php");
else :
    $idusuario = $_SESSION['idusuario'];
endif;

$n = "";
$q = "";
$precoac = "";
$precoat = 0;
$desc = "";
if (isset($_POST['btn'])) { // Cadastrar produtos
    $cp->cadprodNormal($_POST['nome'], $_POST['quantidade'], $_POST['precoac'], $_POST['estado'], $_POST['precoat'], $_POST['descricao'], $_POST['categoria'], $idusuario, $_FILES['foto']);
    $n = $_POST['nome'];
    $q = $_POST['quantidade'];
    $precoac = $_POST['precoac'];
    $precoat = $_POST['precoat'];
    $desc = $_POST['descricao'];
}
if (isset($_POST['btnadd'])) { // Adicionar mais foto ao produto
    $cp->cadMaisFoto($_FILES['maisfoto'], $_GET['idprod']);
}

?>
<div class="row" style="margin-top:130px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1 compose-right">
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                Cadastro de produto
                            </div>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadastrarprod" method="post" name="frmprod" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" value="<?php echo $n; ?>" name="nome" placeholder="Nome do produto" required maxlength="50" title="Nome com 15 caracteres no máximo">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" value="<?php echo $q; ?>" name="quantidade" placeholder="Quantidade" required min="0" title="Quantidade do produto">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" value="<?php echo $precoac; ?>" name="precoac" min="0" placeholder="Preço actual" required title="Preço actual">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="akz">Akz</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="estado" id="estado" class="form-control" onchange="habilitar()">
                                            <?php foreach ($ce->estados() as $v) : ?>
                                                <option value="<?php echo $v['idestado']; ?>"><?php echo $v['nomeestado']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" value="<?php echo $precoat; ?>" name="precoat" placeholder="Preço antigo" min="0" maxlength="10" required title="Preço antigo">
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="akz">Akz</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <textarea name="descricao" placeholder="Descrição do produto" required maxlength="250" title="No máximo 250 caracteres"><?php echo $desc; ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="categoria">Sub-categoria</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-1">
                                        <select name="categoria" id="categoria" class="form-control">
                                            <?php foreach ($csc->todasSubcategorias() as $v) : ?>
                                                <option value="<?php echo $v['idcategoria'] . $v['nomecategoria']; ?>"><?php echo $v['nomecategoria']; ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Largura e altura da foto:</label><span> 600 x 600px</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="foto" required id="foto">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="submit" value="Cadastrar" name="btn">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-6">
                                <?php if (isset($_GET['foto'])) : if ($_GET['foto'] == 'true') : ?>
                                        <?php cadMaisFoto() ?>;
                                <?php endif;
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->