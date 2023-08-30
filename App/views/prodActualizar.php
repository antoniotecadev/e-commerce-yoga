<?php
include_once '../controllers/ControlEstado.php';
include_once '../controllers/ControlSubCategoria.php';
include_once '../controllers/ControlCategoria.php';
include_once '../controllers/ControlProduto.php';

$ce = new ControlEstado();
$csc = new ControlSubCategoria();
$cc = new ControlCategoria();
$cp = new ControlProduto();

if (!isset($_SESSION)) :
    session_start();
endif;
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) :
    header("location: entrar.php");
else :
    $idusuario = $_SESSION['idusuario'];
endif;
?>
<div class="row" style="margin-top:80px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1 compose-right">
                    <?php
                    $n = $_GET['np'];
                    $q = $_GET['qt'];
                    $precoac = $_GET['pac'];
                    $precoat = $_GET['pat'];
                    $desc = $_GET['desc'];
                    $est = $_GET['est'];
                    $idest = $_GET['idest'];
                    $subcat = $_GET['sub'];
                    $idcat = $_GET['idcat'];
                    $visi = $_GET['visi'];
                    $idprod = $_GET['idProduto'];
                    $foto = $_GET['ft'];

                    if (isset($_POST['btn'])) : // Actualizar produtos
                        $n = $_POST['nome'];
                        $q = $_POST['quantidade'];
                        $precoac = $_POST['precoac'];
                        if ($est == 'promocao') :
                            $precoat = $_POST['precoat'];
                        else :
                            $precoat = 0;
                        endif;
                        $desc = $_POST['descricao'];
                        $est = $_POST['est'];
                        $idest = $_POST['estado'];
                        $subcat = $_POST['subcat'];
                        $idcat = $_POST['categoria'];
                        $visi =  $_POST['visiblidade'];
                        $subcat = $_POST['subcat'];

                        $cp->actualizarproduto($idprod, $n, $q, $precoac, $precoat, $desc, $idest, $idcat, $idusuario, $visi);
                    endif;

                    if (isset($_POST['btnadd'])) { // Adicionar mais foto ao produto
                        $cp->cadMaisFoto($_FILES['maisfoto'], $_GET['idprod']);
                    }
                    ?>
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                Actualização de produto
                            </div>
                            <form action="" method="post" name="frmprod" enctype="multipart/form-data">
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Nome</label>
                                        <input type="text" value="<?php echo $n; ?>" name="nome" placeholder="Nome do produto" required maxlength="20" title="Nome com 15 caracteres no máximo">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Quantidade</label>
                                        <input type="number" value="<?php echo $q; ?>" name="quantidade" placeholder="Quantidade" required min="0" title="Quantidade do produto">
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Preço Actual</label>
                                        <input type="number" value="<?php echo $precoac; ?>" name="precoac" min="0" placeholder="Preço actual" required title="Preço actual">
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <div class="form-group">
                                            <label for="akz">Akz</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="estado">Estado</label>
                                            <select name="estado" id="estado" class="form-control" onchange="habilitar()">
                                                <option value="<?php echo $idest; ?>"><?php echo $est; ?></option>
                                                <?php foreach ($ce->estados() as $v) : if ($v['nomeestado'] != $est) : ?>
                                                        <option value="<?php echo $v['idestado']; ?>"><?php echo $v['nomeestado']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="categoria">Visiblidade</label>
                                            <select name="visiblidade" id="categoria" class="form-control">
                                                <option value="<?php echo $visi; ?>"><?php echo $visi; ?></option>
                                                <?php
                                                if ($visi != "activado") : ?>
                                                    <option value="activado"><?php echo "Activado"; ?></option>
                                                <?php else : ?>
                                                    <option value="desactivado"><?php echo "Desactivado"; ?></option>
                                                <?php endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="categoria">Subcategoria</label>
                                            <select name="categoria" id="categoria" class="form-control">
                                                <option value="<?php echo $idcat; ?>"><?php echo $subcat; ?></option>
                                                <?php foreach ($cc->categoriasprod() as $v) : if ($v['nomecategoria'] != $subcat) : ?>
                                                        <option value="<?php echo $v['idcategoria']; ?>"><?php echo $v['nomecategoria']; ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Preço Antigo</label>
                                        <input type="number" value="<?php echo $precoat; ?>" id="preco_at" name="precoat" placeholder="Preço antigo" min="0" maxlength="10" required title="Preço antigo">
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        <div class="form-group">
                                            <label for="akz">Akz</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Descrição</label>
                                        <textarea name="descricao" placeholder="Descrição do produto" required maxlength="250" title="No máximo 250 caracteres"><?php echo $desc; ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label></label>
                                        <center><img width="300px" height="200px" src="../img/<?php echo strtolower($subcat); ?>/<?php echo $foto; ?>" class="img-rounded text-center" alt="Sem Foto"></center>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="submit" value="Actualizar" name="btn">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="idp" value="<?php echo $idprod; ?>">
                                <input type="hidden" name="est" value="<?php echo $est; ?>">
                                <input type="hidden" name="idest" value="<?php echo $idest; ?>">
                                <input type="hidden" name="subcat" value="<?php echo $subcat; ?>">
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
        </div>
    </div>
</div>
<!--/-->
<?php function cadMaisFoto()
{ ?>
    <div class="inbox-details-default col-md-12" style="margin:-150px 0px 0px 470px;">
        <div class="inbox-details-body">
            <div class="form alert-info">
                Adicionar mais fotos relacionadas ao produto cadastrado
            </div>
            <form action="" method="post" name="frmprod" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <h6><?php echo $_GET['nomeproduto']; ?></h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="maisfoto" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <input type="submit" class="btn" value="Adicionar" name="btnadd">
                    </div>
                    <div class="col-md-4" style="margin-top:10px">
                        <div class="form-group">
                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadastrarprod" class="btn btn-danger">Não Adicionar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/-->
<?php } ?>
<script>
    // var preco_at = document.getElementById('preco_at');
    // preco_at.disabled = true;

    function habilitar() {
        var estado = document.getElementById('estado');
        if (Number(estado.value) == 2) {
            preco_at.disabled = false;
        } else {
            preco_at.disabled = true;
            preco_at.value = 0;
        }
    }
</script>