<?php
include_once '../controllers/ControlSlider.php';

$cs = new ControlSlider();

if (!isset($_SESSION)) :
    session_start();
endif;
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) :
    header("location: entrar.php");
else :
    $idusuario = $_SESSION['idusuario'];
endif;
?>

<div class="row" style="margin-top:130px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1 compose-right">
                    <?php
                    $desc = "";
                    if (isset($_POST['btn-cadastrar'])) { // Cadastrar imagem do slider
                        $cs->cadastrarImagem($_POST['descricao'], $_FILES['imagem'], $_POST['visibilidade'],  $idusuario);
                        $desc = $_POST['descricao'];
                    }
                    ?>
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                Cadastro de imagem do slider
                            </div>
                            <form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=cadfotoslider" method="post" name="frmprod" enctype="multipart/form-data">
                                <center>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <textarea name="descricao" placeholder="Descrição da imagem" required maxlength="100" title="No máximo 100 caracteres"><?php echo $desc; ?></textarea>
                                        </div>
                                    </div>
                                </center>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="visibilidade"> <i class="fa fa-eye"></i> Visibilidade</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="visibilidade" id="visibilidade" class="form-control">
                                            <option value="activado">Activado</option>
                                            <option value="desactivado">Desactivado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Largura e altura da imagem:</label><span> 1600 x 450px</span>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="imagem" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="submit" value="Cadastrar imagem" name="btn-cadastrar">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/-->