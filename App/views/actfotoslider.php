<?php
include_once '../controllers/ControlEstado.php';
include_once '../controllers/ControlSlider.php';
include_once '../controllers/ControlCategoria.php';
include_once '../controllers/ControlProduto.php';

$ce = new ControlEstado();
$cs = new ControlSlider();
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

<div class="col-md-10 col-md-offset-1 compose-right" style="margin-top:150px;">
    <?php
    $ns = $_GET['ns'];
    $desc = $_GET['desc'];
    $visi = $_GET['visi'];
    $est = $_GET['est'];
    $idslider = $_GET['idslider'];

    if (isset($_POST['btn'])) : // Actualizar imagens
        $ns = $_POST['nome'];
        $desc = $_POST['descricao'];
        $visi = $_POST['visi'];
        $est = $_POST['est'];
        $idp = $_POST['idp'];

        $cs->actualizarimgslider($ns, $desc, $est, $visi, $idp);
    endif;
    ?>
    <div class="inbox-details-default">
        <div class="inbox-details-body">
            <div class="form alert-info">
                Actualização de Imagens do Slider.
            </div>
            <form action="" method="post" name="frmprod" enctype="multipart/form-data">
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nome da Imagem</label>
                        <input type="text" value="<?php echo $ns; ?>" name="nome" placeholder="Nome do produto" required maxlength="20" title="Nome com 15 caracteres no máximo">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visibilidade"> <i class="fa fa-eye"></i> Visibilidade</label></br>
                            <select name="visi" id="visi" class="form-control">
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
                            <label for="est">Foto Iniçial</label></br>
                            <select name="est" id="est" class="form-control">
                            <?php
                            if ($est == 'active'):?>
                                <option value="<?php echo $est; ?>"><?php echo $est; ?></option> <?php
                            else:?>
                                <option value="<?php echo $est; ?>"><?php echo 'Desactivado'; ?></option> <?php
                            endif;
                            ?>
                                <?php
                                if ($est != "active") : ?>
                                    <option value="active"><?php echo "Active"; ?></option>
                                <?php else : ?>
                                    <option value=""><?php echo "Desactivado"; ?></option>
                                <?php endif;
                                ?>
                            </select>
                        </div> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Descrição</label> 
                        <textarea name="descricao" placeholder="Descrição daImagem" required maxlength="250" title="No máximo 250 caracteres"><?php echo $desc; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="submit" value="Actualizar" name="btn">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="idp" value="<?php echo $idslider; ?>">
            </form>
        </div>
    </div>
</div>
</div>
</div>
