<?php
include_once '../controllers/ControlCliente.php';

$cc = new ControlCliente();

if (isset($_POST['btn-actualizar'])) : ?>
    <script>
        var r = confirm('Tem a certeza que pretende actualizar ?');
        if (r == true) {
            window.location.href = '<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil&confirm=true<?php echo '&nome=' . $_POST['nome'] . '&sobrenome=' . $_POST['sobrenome'] . '&tel1=' . $_POST['tel1'] . '&tel2=' . $_POST['tel2'] . '&bairro=' . $_POST['bairro'] . '&rua=' . $_POST['rua'] . '&datanasc=' . $_POST['datanasc'] . '&sexo=' . $_POST['sexo']; ?>';
        }
    </script><?php 
 elseif (isset($_POST['btn-alterar'])):
//   echo $_POST['pass'];
$cc->actpass($_POST['pass'],$_POST['pass1'],$_POST['pass2']);
endif;
if (isset($_GET['confirm']) == 'true') :
    $cc->actDadosCli($_GET['nome'], $_GET['sobrenome'], $_GET['tel1'], $_GET['bairro'], $_GET['rua'], $_GET['datanasc'], $_GET['sexo']);
endif;
?>
<div id="breadcrumb" class="section">

    <!-- BREADCRUMB -->
    <div class="container">
        <!-- container -->
        <div class="row">
            <!-- row -->
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
                    <li class="active"><b>Perfil</b></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<div class="section">
    <!-- SECTION -->
    <div class="container">
        <!-- container -->
        <div class="row">
            <!-- row -->
            <div id="aside" class="col-md-3">
                <!-- ASIDE -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=perfil" method="Post" name="frmprod" enctype="multipart/form-data">
                    <div class="aside">
                        <!-- aside Widget -->
                        <?php if (isset($_GET['info-pessoal'])) : ?>
                            <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil">
                                <h3 style="font-size: 14px;" class="aside-title"><i class="fa  fa-check-circle" style="color:chartreuse"></i> <?php echo $_SESSION['nomecli'] . ' ' . $_SESSION['sobrenome']; ?></h3>
                            </a>
                        <?php elseif (isset($_GET['alter-pass'])) : ?>
                            <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil">
                                <h3 style="font-size: 14px;" class="aside-title"><i class="fa  fa-check-circle" style="color:chartreuse"></i> <?php echo $_SESSION['nomecli'] . ' ' . $_SESSION['sobrenome']; ?></h3>
                            </a>
                        <?php endif; ?>
                        <i class="fa fa-user"></i> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=perfil&info-pessoal=">
                            <span style="color:#D10024">Informações pessoais</span><br>
                            Actualiza o teu nome, data de nascimento, sexo, número de telefone, bairro e rua.
                        </a>
                        <hr>
                        <i class="fa fa-lock"></i> <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=perfil&alter-pass=">
                            <span style="color:#D10024">Inicio de sessão</span><br>
                            Alterar palavra-passe.
                        </a>
                        <hr>
                    </div>
                    <!-- /aside Widget -->
                </form>
                <!-- /aside Widget -->
                <div class="aside">

                </div>
                <!-- /aside Widget -->
            </div>
            <!-- /ASIDE -->
            <div id="store" class="col-md-9">
                <!-- STORE -->
                <div class="row">
                    <?php if (isset($_GET['info-pessoal'])) : ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="nome" class="form-control input-lg" value="<?php echo $_SESSION['nomecli']; ?>" maxlength="20" aria-describedby="nameHelp" placeholder="*Nome" title="Nome, 20 caracters no máximo " required>
                                </div>
                                <div class="form-group col-md-6 mb-4">
                                    <input type="text" name="sobrenome" class="form-control input-lg" value="<?php echo $_SESSION['sobrenome']; ?>" maxlength="15" placeholder="*Sobrenome" title="Sobrenome, 15 caracters no máximo " required>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <span class="brand-name" id="">Data de Nascimento</span>
                                    <input type="date" name="datanasc" class="form-control input-lg" value="<?php echo $_SESSION['datanascimento']; ?>" placeholder="Data de nascimento" title="Data de Nascimento" required>
                                </div>
                                <div class="form-group col-md-2 ">
                                    <span class="brand-name">Sexo</span>
                                    <div class="input-radio">
                                        <input type="radio" name="sexo" value="Masculino" id="masculino" title="Masculino" <?php if ($_SESSION['sexo'] == 'Masculino' || $_SESSION['sexo'] == 'masculino') : ?> checked<?php endif; ?>>
                                        <label for="masculino">
                                            <span></span>
                                            Masculino
                                        </label>
                                    </div>
                                    <div class="input-radio">
                                        <input type="radio" name="sexo" value="Femenino" id="Femenino" title="Femenino" <?php if ($_SESSION['sexo'] == 'Femenino' || $_SESSION['sexo'] == 'femenino') : ?> checked<?php endif; ?>>
                                        <label for="Femenino">
                                            <span></span>
                                            Femenino
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="tel" name="tel1" class="form-control input-lg" value="<?php echo $_SESSION['telefone1']; ?>" maxlength="9" placeholder="*Número de telefone " title="Número de telefone" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <input class="form-control input-lg" readonly>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <input type="text" name="bairro" class="form-control input-lg" value="<?php echo $_SESSION['bairro']; ?>" maxlength="15" placeholder="*Bairro" title="Bairro, no máximo 15 caracteres" required>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <input type="text" name="rua" class="form-control input-lg" value="<?php echo $_SESSION['rua']; ?>" maxlength="20" placeholder="*Rua" title="Rua, no máximo 20 caracteres" required>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <button type="submit" name="btn-actualizar" class="btn btn-lg btn-success btn-block mb-4 mt-4"><i class="fa fa-refresh"></i> Actualizar dados</button>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil" name="btn-cancelar" class="btn btn-lg btn-info btn-block mb-4 mt-4"><i class="fa fa-times"></i> Cancelar</a>
                                </div>
                            </div>
                        </form>
                    <?php elseif (isset($_GET['alter-pass'])) : ?>
                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="row">
                                <div class="form-group col-md-6 col-md-offset-3 mb-4">
                                    <input type="password" name="pass" class="form-control input-lg" maxlength="10" aria-describedby="nameHelp" placeholder="Palavra-passe actual" title="Digite a palavra-passe actual" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-md-offset-3  mb-4">
                                    <input type="password" name="pass1" class="form-control input-lg" maxlength="10" placeholder="Palavra-passe nova" title="Digite a nova palavra-passe" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-md-offset-3  ">
                                    <input type="password" name="pass2" class="form-control input-lg" maxlength="10" placeholder="Repete a palavra passe nova" title="Digite novamente a palavra-passe" required>
                                    <input type="hidden" name="idcli" value="<?php echo $_SESSION['nomecli']; ?>" class="form-control input-lg">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-md-offset-3  ">
                                    <button type="submit" name="btn-alterar" class="btn btn-lg btn-success btn-block mb-4 mt-4"><i class="fa fa-refresh"></i> Alterar palavra-passe</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-md-offset-3  ">
                                    <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil" name="btn-cancelar" class="btn btn-lg btn-info btn-block mb-4 mt-4"><i class="fa fa-times"></i> Cancelar</a>
                                </div>
                            </div>
                </div>
                </form>
            <?php else : ?>
                <div class="form-group col-md-12 mb-4">
                    <h2 class="text-center"><i class="fa  fa-check-circle" style="color:chartreuse"></i> <?php echo $_SESSION['nomecli'] . ' ' . $_SESSION['sobrenome']; ?></h2>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Data de nascimento:</h5> <?php echo $_SESSION['datanascimento']; ?>
                    </p>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Sexo:</h5> <?php echo $_SESSION['sexo']; ?>
                    </p>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Telefone:</h5> <?php echo $_SESSION['telefone1']; ?>
                    </p>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Bairro:</h5> <?php echo $_SESSION['bairro']; ?>
                    </p>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Rua:</h5> <?php echo $_SESSION['rua']; ?>
                    </p>
                </div>
                <div class="form-group col-md-4 mb-4">
                    <p>
                        <h5 style="color:#D10024">Email:</h5> <?php echo $_SESSION['email']; ?>
                    </p>
                </div>
            <?php endif; ?>
            </div>
            <!-- /store products -->
            <div class="store-filter clearfix">

            </div>
            <!-- /store bottom filter -->
        </div>
        <!-- /STORE -->
    </div>
    <!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /SECTION -->