<?php
include_once '../Controllers/ControlEncomenda.php';
$ce = new ControlEncomenda();
if (!isset($_SESSION)) :
    session_start();
endif;
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) :
    header("location: entrar.php");
else :
    $idusuario = $_SESSION['idusuario'];
endif;
if (isset($_POST['btn-pendente'])) :
    if (isset($_GET['icclt'])) :
        $ce->visualizar(base64_decode(base64_decode($_GET['icclt'])), 2, $idusuario,'');
    else :
        echo '<script> alert("Erro❗\nEncomenda não adicionada como pendente"); </script>';
    endif;
elseif (isset($_POST['btn-anular'])) :
        confirmacao();
elseif (isset($_POST['btn-concluida'])) :
    if (isset($_GET['icclt'])) :
        $ce->visualizar(base64_decode(base64_decode($_GET['icclt'])), 4, $idusuario,'');
    else :
        echo '<script> alert("Erro❗\nEncomenda não concluída"); </script>';
    endif;
elseif (isset($_GET['view'])) :
    if (isset($_GET['icclt'])) :
        $ce->visualizar(base64_decode(base64_decode($_GET['icclt'])), 1, $idusuario, '');
    else :
        echo '<script> alert("Produto não visualizado"); </script>';
    endif;
elseif (isset($_POST['confirmar'])) :
    if (isset($_GET['icclt'])) :
        $ce->visualizar(base64_decode(base64_decode($_GET['icclt'])), 3, $idusuario, $_POST['info']);
    else :
        echo '<script> alert("Erro❗\nEncomenda não anulada"); </script>';
    endif;
endif;
?>
<style>
    strong {
        color: #FC8213;
    }

    strong#a {
        color: #337AB7;
    }
</style>
<div class="col-md-10 col-md-offset-1 compose-right" style="margin-top:150px;">
    <div class="inbox-details-default">
        <div class="inbox-details-body">
            <div class="form alert-info text-center">
                <h2><?php echo $_GET['nome'] . ' ' . $_GET['sobrenome']; ?></h2>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4><strong><?php echo $_GET['titulo']; ?></strong></h4>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h4><strong>Sexo:</strong> <?php echo $_GET['sexo']; ?></h4>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4><strong>Tel:</strong> <?php echo $_GET['tel1']; ?></h4>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h4><strong>E-mail:</strong> <?php echo $_GET['email']; ?></h4>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4><strong>Bairro:</strong> <?php echo $_GET['bairro']; ?></h4>
                    <hr>
                </div>
                <div class="col-md-6">
                    <h4><strong>Rua:</strong> <?php echo $_GET['rua']; ?></h4>
                    <hr>
                </div>
            </div>
                <div class="row">
                <div class="col-md-6">
                    <textarea maxlength="250"><?php echo $_GET['del']; ?></textarea>
                </div>
                <div class="col-md-6">
                    <strong>Data da encomenda:</strong> <?php echo $_GET['data']; ?>
                </div>
                <?php if(isset($_GET['info'])):?>
                    <div class="col-md-6">
                        <button onclick="verInfo()" class="btn btn-primary">?</button>
                    </div>
                <?php endif;?>
            </div>
            <script>
                function verInfo()  {
                    alert('<?php echo $_GET['info']; ?>');
                }
            </script>
            <div class="row">
                <div class="col-md-6">
                    <strong>OPERADOR: </strong><?php foreach ($ce->operador(base64_decode(base64_decode($_GET['usr']))) as $oper) : echo $oper['nome'];
                                                endforeach; ?>
                </div>
                <div class="col-md-6">
                    <strong>CLIENTE: </strong><?php echo $_GET['nome'] . ' ' . $_GET['sobrenome']; ?>
                    <hr>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="table-produto">
                    <thead>
                        <tr class="active">
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>1ª parcela</th>
                            <th>Total prestação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $t = 0;
                        $tp = 0;
                        $tl = 0;
                        $pl = 0;
                        foreach ($ce->dadosProduto(base64_decode(base64_decode($_GET['icclt']))) as $dados) : ?>
                            <tr class="">
                                <td class="info">
                                    <h5><?php echo $dados['nome']; ?></h5>
                                </td>
                                <td class="danger">
                                    <h5><?php echo number_format($dados['preco_ac'], 2, ',', '.');
                                        $tl += $dados['preco_ac']; ?></h5>
                                </td>
                                <td>
                                    <h5><?php echo $dados['quantidade']; ?></h5>
                                </td>
                                <td class="success">
                                    <h5><?php $r = $dados['preco_ac'] * $dados['quantidade'];
                                        echo number_format($r, 2, ',', '.');
                                        $t += $r; ?></h5>
                                </td>
                                <td>
                                    <h5><?php echo number_format($dados['parcela'], 2, ',', '.');
                                        $pl += $dados['parcela']; ?></h5>
                                </td>
                                <td>
                                    <h5><?php $p = $dados['parcela'] * $dados['quantidade'];
                                        echo number_format($p, 2, ',', '.');
                                        $tp += $p; ?></h5>
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <tr>
                            <td>
                            </td>
                            <td>
                                <strong><?php echo number_format($tl, 2, ',', '.'); ?></strong>
                            </td>
                            <td>
                            </td>
                            <td>
                                <strong id="a"><?php echo number_format($t, 2, ',', '.'); ?></strong> Akz
                            </td>
                            <td>
                                <strong><?php echo number_format($pl, 2, ',', '.'); ?></strong>
                            </td>
                            <td>
                                <strong id="a"><?php echo number_format($tp, 2, ',', '.'); ?></strong> Akz
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="col-md-2">
                        <?php if (isset($_GET['pendente'])) : ?>
                            <div class="form-group">
                                <input type="submit" value="✅ Concluída" name="btn-concluida">
                            </div>
                        <?php else : ?>
                            <div class="form-group">
                                <input type="submit" value="📌 Pendente" name="btn-pendente">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <?php if (!isset($_GET['anulada'])) : ?>
                            <div class="form-group">
                                <input type="submit" value="❌ Anular" style="background-color: #D10024" name="btn-anular">
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php function confirmacao()
{ ?>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="../img/logo/koop-logo.png" alt="" style="text-align:center">
                    <h5 class="modal-title">Por que pretende anular a encomenda ❓</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
                    <div class="modal-body">
                        <textarea name="info" id="" cols="30" rows="8" maxlength="150" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="confirmar" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>