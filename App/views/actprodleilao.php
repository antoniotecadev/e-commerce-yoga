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
<div class="row" style="margin-top:130px;">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-10 col-md-offset-1 compose-right">
                    <?php
                    $nome = "";
                    $precoin = "";
                    $saltopreco = "";
                    $titulo = "";
                    $subtitulo = "";
                    $dia = "";
                    $hora = "";
                    $minuto = "";
                    $desc = "";
                    $estado = "";
                    if (isset($_POST['btn-actualizar'])) { // Cadastrar produtos
                        $cl->actualizarLeilão($_POST['nome'], $_POST['precoin'], $_POST['salto_preco'], $_POST['titulo'], $_POST['dia'], $_POST['hora'], $_POST['minuto'], $_POST['subtitulo'], $_POST['descricao'], $_POST['estado'], $_FILES['foto'], $idusuario);
                        $nome = $_POST['nome'];
                        $precoin = $_POST['precoin'];
                        $saltopreco = $_POST['salto_preco'];
                        $titulo = $_POST['titulo'];
                        $subtitulo = $_POST['subtitulo'];
                        $dia = $_POST['dia'];
                        $hora = $_POST['hora'];
                        $minuto = $_POST['minuto'];
                        $desc = $_POST['descricao'];
                        $estado = $_POST['estado'];
                    }

                    ?>
                    <div class="inbox-details-default">
                        <div class="inbox-details-body">
                            <div class="form alert-info">
                                Actualizar produto em leilão
                            </div>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=actprodleilao" method="post" name="frmprod" enctype="multipart/form-data">
                                <?php foreach ($cl->dadosLeilao() as $v) : ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $v['nome']; ?>" name="nome" placeholder="Nome do produto" required maxlength="20" title="Nome com 15 caracteres no máximo">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" value="<?php echo $v['preco_inicial']; ?>" name="precoin" min="0" placeholder="Preço" required title="Preço">
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label for="akz">Akz</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" value="<?php echo $v['salto_preco']; ?>" name="salto_preco" placeholder="Salto do preço" required min="0" title="Salto do preço">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $v['titulo']; ?>" name="titulo" placeholder="Título" required maxlength="40" title="Titulo com 40 caracteres no máximo">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" value="<?php echo $v['subtitulo']; ?>" name="subtitulo" placeholder="Subtítulo" required maxlength="100" title="Subtítulo com 100 caracteres no máximo">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="number" name="dia" value="<?php echo $v['dia']; ?>" placeholder="Dia" min="1" max="31" title="Dia" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="hora" value="<?php echo $v['hora']; ?>" placeholder="Hora" min="1" max="24" title="Hora" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" name="minuto" value="<?php echo $v['minuto']; ?>" placeholder="Minuto" min="1" max="60" title="Minuto" required>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea name="descricao" placeholder="Descrição do produto" required maxlength="250" title="No máximo 250 caracteres"><?php echo $v['descricao']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="estado">Estado</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-md-offset-1">
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="<?php echo $v['estado']; ?>"><?php echo ucfirst($v['estado']); ?></option>
                                                <?php if ($v['estado'] == 'Activado' || $v['estado'] == 'activado') : ?>
                                                    <option value="desactivado">Desactivado</option>
                                                <?php else : ?>
                                                    <option value="activado">Activado</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Largura e altura da foto:</label><span> 600 x 600px</span>
                                            </div>
                                            <div class="form-group">
                                                <input type="file" name="foto" required id="foto">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="submit" value="Actualizar" name="btn-actualizar">
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