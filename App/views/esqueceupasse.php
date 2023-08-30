<?php
include_once '../controllers/ControlCliente.php';
$cc = new ControlCliente();
 if(isset($_POST['pesquisar'])):
    $cc->encontrarCliente($_POST['telemail']);
 endif;   
?>
<div id="breadcrumb" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<!-- SECTION -->
<div class="section">
    <!-- container -->
    <div class="container">
            <!-- Order Details -->
            <div class="col-md-6 col-md-offset-3 order-details">
                <div class="section-title text-center">
                    <h4 class="title">Encontrar a tua conta</h4>
                </div>
                <hr>
                <div class="order-summary">
                <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
                    <div class="row">
                        <div class="form-group col-md-12">
                            Insere o teu e-mail ou número de telefone para procurares a tua conta.
                            <input type="text" name="telemail" class="form-control" maxlength="20" placeholder="Número de telefone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3 col-xs-offset-3 col-md-offset-3 col-md-3">
                            <button type="submit" name="pesquisar" class="btn btn-success">Pesquisar</button>
                        </div>
                        <div class="col-xs-2 col-md-2">
                            <a href="<?php $_SERVER['PHP_SELF'];?>" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <!-- /Order Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
                  