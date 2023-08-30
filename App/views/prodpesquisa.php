<?php
include_once '../controllers/ControlProduto.php';
$cp = new ControlProduto();
if (isset($_POST['btn-esquisar']) && !empty($_POST['procurar'])) :
    foreach ($cp->pesquisarProduto($_POST['procurar']) as $p) :
    // var_dump($p);
    endforeach;
else :
    echo '<script> document.location.href = history.go(-1); </script>';
endif;
?>
<style>
    table#table-pesquisa tr:hover {
        background-color: rgb(206, 206, 255)
    }

    table#table-pesquisa tr {
        transition: background-color 1s;
    }
</style>
<div id="breadcrumb" class="section">
    <!-- BREADCRUMB -->
    <div class="container">
        <!-- container -->
        <div class="row">
            <!-- row -->
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
                    <li class="active">Pesquisa</li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /BREADCRUMB -->
<section class="cart_area">
    <!--================Cart Area =================-->
    <div class="container">
        <div class="cart_inner">
            <div class="">
                <table class="table" id="table-pesquisa">
                    <tbody>
                        <?php if (isset($_POST['btn-esquisar']) && !empty($_POST['procurar'])) :
                            foreach ($cp->pesquisarProduto($_POST['procurar']) as $p) :
                                $numero = (int) substr($p['foto'], -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
                                if ($numero == 1) : ?>

                                    <tr>
                                        <td>
                                            <div class="product-img">
                                                <img src="../img/<?php echo strtolower($p['nomecategoria']) .  "/" .  $p['foto']; ?>" alt="" height="50px" width="50px">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $p['nome'] . '&pac=' . $p['preco_ac'] . '&pat=' . $p['preco_at'] . '&es=' . $p['nomeestado'] . '&cat=' . $p['nomecategoria'] . '&desc=' . $p['descricao'] . '&icp=' . base64_encode(base64_encode($p['idproduto'])); ?>"><?php echo $p['nome']; ?></a>
                                            <p><?php echo $p['nomecategoria']; ?></p>
                                        </td>
                                        <td class="preco-total">
                                            <?php echo number_format($p['preco_ac'], 2, ',', '.'); ?>
                                        </td>
                                        <td>
                                            <a href="<?php $_SERVER['PHP_SELF']; ?>?btn-add-carrinho&icpad=<?php echo base64_encode(base64_encode($p['idproduto'])) ?>" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i></a>
                                        </td>
                                    </tr>
                        <?php endif;
                            endforeach;
                        endif;
                        echo isset($p) ? '<p>Resultados para <strong>"' . $_POST['procurar'] . '"</strong><p>' : '<p>Não foram encotrados resultados para <strong>"' . $_POST['procurar'] . '"</strong><p>'; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->