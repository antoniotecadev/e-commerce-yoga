<?php
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlSlider.php';
$cp = new ControlProduto();
$cs = new ControlSlider();
if (!isset($_SESSION)) :
    session_start();
endif;
?>
<div class="row" style="margin-top:150px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr style="font-size: 13px;">
                            <th>Actualizar</th>
                            <th>Nome da Imagem <img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Descrição <img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Visibilidade<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Imagem Inicial<img src="../img/tabela/sort_both.png" alt=""></th>
                            <th>Imagem<img src="../img/tabela/sort_both.png" alt=""></th>
                    </thead>
                    <tbody>
                        <?php foreach ($cs->imagemSlider() as $slider) :  ?>
                            <tr class="odd gradeX">
                                <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=actfotoslider&idslider=<?php echo $slider['idslider'] . '&ns=' . $slider['foto'] . '&desc=' . $slider['descricao'] . '&visi=' . $slider['visibilidade'] . '&est=' . $slider['primeiro']; ?>"><img style="margin-left: 40px;" src="../img/imgicons/page_edit.png"></a></td>
                                </td>
                                <td> <?php echo $slider['foto']; ?></td>
                                <td> <?php echo $slider['descricao']; ?></td>
                                <td> <?php echo $slider['visibilidade']; ?></td>
                                <?php
                                    if($slider['primeiro'] == 'active'):?>
                                <td> <?php echo $slider['primeiro']; ?></td>
                                <?php
                                    else:?>
                                    <td> <?php echo 'Desactivado'; ?></td><?php
                                    endif;
                                ?>
                                <td><img src="../img/sliders/<?php echo $slider['foto'];?>" height="50" width="150" ></td>
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