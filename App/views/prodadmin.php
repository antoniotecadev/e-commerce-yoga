<?php
include_once '../controllers/ControlProduto.php';
$cp = new ControlProduto();
if (!isset($_SESSION)) :
    session_start();
endif;
?>

<div class="row" style="margin-top:100px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover table-responsive-sm"  id="dataTables-example">
                    <thead >
                        <tr style="font-size: 12px; font-weight: 500">
                            <th >Mais</th>
                            <th>Actualizar</th>
                            <th>Visiblidade</th>
                            <th>Nome</th>
                            <th>Preço Ac</th>
                            <th>Preço At</th>
                            <th>Estado</th>
                            <th>Categoria</th>
                            <th>SubCategoria</th>
                            <th>Imagem</th>
                            <th>idproduto</th>
                            <th>Quantidade</th>
                            <th>Descrição</th>
                            <th>Data</th>
                            <th>Usuário</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cp->produto() as $produto) :  ?>
                            <tr class="odd gradeX">
                                <td> </td>
                                <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=prodActualizar&idProduto=<?php echo $produto['idproduto'] . '&np=' . $produto['nome'] . '&qt=' . $produto['quantidade'] . '&pac=' . $produto['preco_ac'] . '&pat=' . $produto['preco_at'] . '&desc=' . $produto['descricao'] . '&est=' . $produto['nomeestado'] . '&cat=' . $produto['nomecategoria'] . '&sub=' . $produto['subcategoria'] . '&visi=' . $produto['visibilidade'] . '&idest=' . $produto['fkestado'] . '&idcat=' . $produto['fkcategoria']. '&ft=' . $produto['foto']; ?>"><img style="margin-left: 40px;" src="../img/imgicons/page_edit.png"></a></td>
                                </td>
                                <td width="1px"> <?php echo $produto['visibilidade']; ?></td>
                                <td> <?php echo $produto['nome']; ?></td>
                                <td> <?php echo $produto['preco_ac'].'kz'; ?></td>
                                <td> <?php echo $produto['preco_at'].'kz'; ?></td>
                                <td> <?php echo $produto['nomeestado']; ?></td>
                                <td> <?php echo $produto['nomecategoria']; ?></td>
                                <td> <?php echo $produto['subcategoria']; ?></td>
                                <td class="center"> <img width="80px" height="60px" src="../img/<?php echo strtolower($produto['subcategoria']);?>/<?php echo $produto['foto'];?>" class="img-rounded text-center" alt="Sem Foto"></td>
                                <td> <?php echo $produto['idproduto']; ?></td>
                                <td> <?php echo $produto['quantidade']; ?></td>
                                <td> <?php echo $produto['descricao']; ?></td>
                                <td> <?php echo $produto['data']; ?></td>
                                <td> <?php echo $produto['nomeusuario']; ?></td>
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