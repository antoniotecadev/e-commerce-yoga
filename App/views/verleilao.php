<?php
include_once '../controllers/ControlLeilao.php';
$cl = new ControlLeilao();

if (!isset($_SESSION)) :
    session_start();
endif;
if (!isset($_SESSION['nome']) || !isset($_SESSION['nivel'])) :
    header("location: entrar.php");
else :
    $idusuario = $_SESSION['idusuario'];
endif;
?>
<style>
    table#table-leilao tr:hover {
        background-color: rgb(206, 206, 255)
    }

    table#table-leilao tr {
        transition: background-color 1s;
    }

    strong {
        color: #337AB7;
    }
</style>
<div class="row" style="margin-top:110px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1 compose-right">
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                <h3>ESTATÍSTICAS DO LEILÃO</h3>
                            </div>
                            <?php foreach ($cl->dadosLeilao() as $v) : ?>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <h4><strong>Nome: </strong> <?php echo $v['nome']; ?></h4>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <h4><strong>Preço inicial: </strong> <?php echo $v['preco_inicial']; ?></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 form-group">
                                        <h4><strong>Termino</strong></h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <h4><strong>Dia:</strong> <?php echo $v['dia']; ?></h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <h4><strong>Hora:</strong> <?php echo $v['hora']; ?></h4>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <h4><strong>Minuto: </strong> <?php echo $v['minuto']; ?></h4>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table" id="table-leilao">
                                                <thead>
                                                    <tr class="active">
                                                        <th>Nome</th>
                                                        <th>Valor a pagar</th>
                                                        <th>Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cl->dadosCliente() as $dados) : ?>
                                                        <tr class="info">
                                                            <td>
                                                                <h5 class="name"><?php echo $dados['nome']; ?></h5>
                                                            </td>
                                                            <td class="preco">
                                                                <h5 class="preco"><?php echo number_format($dados['valor_pago'], 2, ',', '.'); ?> Akz</h5>
                                                            </td>
                                                            <td>
                                                                <p class="date"><?php echo $dados['data']; ?></p>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/-->