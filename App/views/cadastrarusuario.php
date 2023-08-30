<?php
include_once '../controllers/ControlUsuario.php';
$cu = new ControlUsuario();
if (!isset($_SESSION)) :
    session_start();
endif;
if (!$_SESSION['nome'] || !$_SESSION['nivel']) :
    header("location: entrar.php");
endif;
?>
<div class="row" style="margin-top:100px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-8 col-md-offset-2 compose-right">
                    <?php
                    $n = "";
                    $e = "";
                    $t = "";
                    $p = "";
                    if (isset($_POST['btn'])) {
                        $cu->cadastro($_POST['nome'], $_POST['email'], $_POST['tel'], $_POST['pass'], $_POST['nivel'], $_FILES['foto']);
                        $n = $_POST['nome'];
                        $e = $_POST['email'];
                        $t = $_POST['tel'];
                        $p = $_POST['pass'];
                    }
                    ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=usuario" class="hvr-bubble-float-left">Lista de usuários <i class="fa fa-arrow-circle-left"></i> <i class="fa fa-user"></i></a>
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                Cadastro de usuário
                            </div>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadastrarusuario" method="post" name="frmprod" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="nome" value="<?php echo $n; ?>" placeholder="Nome" required maxlength="25" title="Nome com 24 caracteres no máximo">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" value="<?php echo $e; ?>" placeholder="E-mail" required maxlength="30" title="E-mail com 25 caracteres no máximo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="tel" name="tel" value="<?php echo $t; ?>" placeholder="Número de telefone" required maxlength="13" title="Número de telefone">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="pass" value="<?php echo $p; ?>" placeholder="Palavra-passe" required maxlength="15" title="Password com 15 caracteres no máximo">
                                    </div>
                                </div>
                                <label for="nivel">Nível</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select name="nivel" id="nivel" class="form-control">
                                                <?php foreach ($cu->niveis() as $v) : ?>
                                                    <option value="<?php echo $v['idnivel']; ?>"><?php echo $v['nivel']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="file" name="foto" id="foto">
                                </div>
                                <input type="submit" value="Cadastrar" name="btn">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/-->