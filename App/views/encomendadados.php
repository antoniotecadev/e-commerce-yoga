<?php
        if(!isset($_SESSION)):
            session_start();
        endif;
        if(!$_SESSION['nome'] || !$_SESSION['nivel']):
        header("location: entrar.php");
        endif;
        include_once '../controllers/ControlEncomenda.php';
        $ce = new ControlEncomenda();
    ?>
    <div class="row" style="margin-top:150px;">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <h4 class="text-center" style="color:#FC8213"><?php echo $_GET['titulo'];?></h4>
                    <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th><img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Cliente<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Data de pedido<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Sexo<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Telefone<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>E-mail<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Bairro<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Rua<img src="../img/tabela/sort_both.png" alt=""></th>
                                <th>Detalhe<img src="../img/tabela/sort_both.png" alt=""></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($ce->notificacaoEncomenda() as $dados) :
							if ($dados['visibilidade'] == $_GET['vs']) : 
                            $info = $_GET['vs'] == 3? '&info='.$dados['porqueanulada']:''; 
                            ?>
                                <tr class="odd gradeX">
                                <td> <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=dadosencomenda<?php echo '&del=' . $dados['detalhe'] . '&data=' . $dados['dataencomenda'] . '&nome=' . $dados['nome'] . '&sobrenome=' . $dados['sobrenome'] . '&sexo=' . $dados['sexo'] . '&tel1=' . $dados['telefone1'] . '&email=' . $dados['email'] . '&bairro=' . $dados['bairro'] . '&rua=' . $dados['rua'] . '&icclt=' . base64_encode(base64_encode($dados['id'])) . '&titulo='.$_GET['titulo'].'&usr='. base64_encode(base64_encode($dados['fkusuario'])) . $info; ?>">Abrir</a></td>
                                <td> <?php echo $dados['nome'] . ' ' . $dados['sobrenome'];?></td>
                                <td> <?php echo $dados['dataencomenda'];?></td>
                                <td> <?php echo $dados['sexo'];?></td>
                                <td> <?php echo $dados['telefone1'];?></td>
                                <td> <?php echo $dados['email'];?></td>
                                <td> <?php echo $dados['bairro'];?></td>
                                <td> <?php echo $dados['rua'];?></td>
                                <td> <?php echo $dados['detalhe'];?></td>
                            </tr>
                            <?php endif;
							endforeach; ?>
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