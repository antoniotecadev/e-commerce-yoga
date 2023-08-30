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
<div class="row" style="margin-top:150px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadastrarusuario" class="hvr-bubble-float-left">Cadastrar Usuário <i class="fa fa-user"></i><i class="glyphicon-plus"></i></a>
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Código <img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Nome<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>email<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Telefone<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Nível<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Foto<img src="../img/tabela/sort_both.png" alt=""></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cu->usarios() as $usuario) :  ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $usuario['idusuario']; ?></td>
                                <td> <?php echo $usuario['nome']; ?></td>
                                <td> <?php echo $usuario['email']; ?></td>
                                <td> <?php echo $usuario['telefone']; ?></td>
                                <td> <?php echo $usuario['nivel']; ?></td>
                                <td class="center"> <img src="../img/usuario/<?php echo $usuario['foto']; ?>" class="img-rounded text-center" alt=""></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->