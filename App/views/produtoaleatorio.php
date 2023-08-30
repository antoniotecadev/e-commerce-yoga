<?php
include_once '../controllers/ControlSubCategoria.php';

$csc = new ControlSubCategoria();

$idest = base64_decode(base64_decode($_GET['idest'] ?? $_POST['idest']));
$estado = base64_decode(base64_decode($_GET['ne'] ?? $_POST['ne']));
$idsc = base64_decode(base64_decode($_GET['idsc'] ?? $_POST['idsc']));
$id = base64_decode(base64_decode($_GET['idc'] ?? $_POST['idc']));

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
					<?php
					if ($estado == 'Promoção') {
						?> <li class="active">Produtos em <b><?php echo $estado ?></b></li>
					<?php } elseif ($estado == 'Prestação') { ?>
						<li class="active">Produtos em <b><?php echo $estado ?></b></li>
					<?php } else { ?>
						<li class="active">Produtos <b><?php echo $estado ?></b></li>
					<?php																																				}
					?>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->

<?php if (isset($_POST['btn-detalhe'])) : ?>
	<!-- ****** Quick View Modal Area Start ****** -->
	<div class="modal fade" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickview" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="quickview_body">
						<div class="container">
							<div class="row">
								<div class="col-12 col-lg-5">
									<div class="quickview_pro_img">
										<?php // Obter a foto principal
											$n = preg_replace("/[^0-9]/", "", $_POST['foto']);
											$foto = str_replace($n, '01', $_POST['foto']);
											?>
										<img src="../img/<?php echo strtolower($_POST['nome_cat']) . '/' . $foto; ?>" alt="">
									</div>
								</div>
								<div class="col-12 col-lg-7">
									<div class="quickview_pro_des">
										<h4 class="title"><?php echo $_POST['nome']; ?></h4>
										<div class="top_seller_product_rating mb-15">
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
											<i class="fa fa-star" aria-hidden="true"></i>
										</div>
										<h5 class="price"><?php echo number_format($_POST['preco_ac'], 2, ',', '.'); // Preço actual
																?> Akz
											<?php if ($_POST['ne'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
													?>
												<del class="product-old-price"><?php echo number_format($_POST['preco_at'], 2, ',', '.'); ?></del></h4>
											<?php endif; ?>
											<div class="row">
												<div class="col-md-6">
													<p class="text-justify">
														<?php echo $_POST['desc'];
															?></p>
												</div>
											</div>
											<a href="<?php $_SERVER['PHP_SELF'] ?>?sessao=produto&icp=<?php echo  base64_encode(base64_encode($_POST['id_prod'])) . '&np=' . $_POST['nome'] . '&pac=' . $_POST['preco_ac'] . '&pat=' . $_POST['preco_at'] . '&es=' .  base64_decode(base64_decode($_POST['ne'])) . '&cat=' . $_POST['nome_cat'] . '&desc=' . $_POST['desc']; ?>">Ver Delhate Completo do Produto</a>
									</div>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea" method="post">
										<!-- Add to Cart Form -->
										<input type="text" name="idprodad" value="<?php echo base64_encode(base64_encode($_POST['id_prod'])); ?>" hidden>
										<input type="text" name="idc" value="<?php echo base64_encode(base64_encode($id)) ?>" hidden>
										<input type="text" name="ne" value="<?php echo base64_encode(base64_encode($estado)) ?>" hidden>
										<input type="text" name="idest" value="<?php echo base64_encode(base64_encode($idest)); ?>" hidden>
										<input type="text" name="idsc" value="<?php echo base64_encode(base64_encode($idsc)); ?>" hidden>
										<button type="submit" name="btn-add-carrinho" class="cart-submit"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
									</form>
									<div class="share_wf mt-30">
										<p>Partilhar</p>
										<div class="_icon">
											<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
											<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
											<a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
											<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success" onclick="history.go(-1)"><i class="fa fa-arrow-left"></i> Voltar onde estava</button>
					<button type="button" href="javascript:history.go(-1)" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
				</div>
				<!--modal-footer-->
			</div>
		</div>
	</div> <!-- ****** Quick View Modal Area End ****** -->
<?php endif; ?>

<div class="section">
	<!-- SECTION -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div id="aside" class="col-md-3">
				<!-- ASIDE -->
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea" method="Post" name="frmprod" enctype="multipart/form-data">
					<div class="aside">
						<!-- aside Widget -->
						<h3 style="font-size: 18px;" class="aside-title">Categorias</b></a></h3>
						<?php
						foreach ($csc->buscarsubCategoria("SELECT sb.nomecategoria, sb.idcategoria, COUNT(*) FROM subcategoria as sb INNER JOIN produto as p ON sb.idcategoria = p.fkcategoria WHERE sb.fkcategoria = $id AND p.fkestado=$idest AND p.visibilidade = 'activado' GROUP BY sb.nomecategoria") as $subcat) : ?>
							<div class="checkbox-filter">
								<div class="input-checkbox">
									<input type="checkbox" name="chek[]" id="<?php echo $subcat['idcategoria']; ?>" value="<?php echo $subcat['idcategoria']; ?>">
									<label for="<?php echo $subcat['idcategoria']; ?>">
										<span></span>
										<a style="color: black;" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($subcat['idcategoria'])) . '&ne=' . base64_encode(base64_encode($estado)) . '&idc=' . base64_encode(base64_encode($id)) . '&idest=' . base64_encode(base64_encode($idest)); ?>"> <?php echo $subcat['nomecategoria']; ?> </a>
										<small>(<?php echo $subcat['COUNT(*)']; ?>)</small>
									</label>
								</div>
							</div>
							<input type="hidden" name="idc" value="<?php echo base64_encode(base64_encode($id)); ?>">
							<input type="hidden" name="ne" value="<?php echo base64_encode(base64_encode($estado)); ?>">
							<input type="hidden" name="idest" value="<?php echo base64_encode(base64_encode($idest)); ?>">
							<input type="hidden" name="idsc" value="<?php echo base64_encode(base64_encode($idsc)); ?>">
						<?php
						endforeach;
						?>
					</div>
					<!-- /aside Widget -->
					<div class="aside">
						<!-- aside Widget -->
						<h3 class="aside-title">Preço</h3>
						<div class="price-filter">
							<div id="price-slider"></div>
							<div class="input-number price-min">
								<input id="price-min" name="p1" type="number">
								<span class="qty-up">+</span>
								<span class="qty-down">-</span>
							</div>
							<span>-</span>
							<div class="input-number price-max">
								<input id="price-max" name="p2" type="number">
								<span class="qty-up">+</span>
								<span class="qty-down">-</span>
							</div>
						</div>
						<button type="submit" name="btnfiltro" class="primary-btn cta-btn btn-xs" style="margin-top: 10px; font-size:9pt; font-family:monospace">Filtrar preços neste intervalo</button>
					</div>
				</form>
				<?php
				$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;
				$quantidade_pg = 9;
				$inicio = ($quantidade_pg * $pagina) - $quantidade_pg;

				if (isset($_POST['btnfiltro']) || isset($_GET['btnfiltro'])) :
					$p1 = $_GET['p1'] ?? $_POST['p1'];
					$p2 = $_GET['p2'] ?? $_POST['p2'];
					if (isset($_POST['chek']) || isset($_GET['chek'])) :
						if (isset($_GET['chek'])) :
							$chek = $_GET['chek'];
							$chek = preg_replace('/[^[:alnum:]_,]/', '', $chek);
						else :
							$chek = '(' . implode(',', $_POST['chek']) . ')';
							$chek = preg_replace('/[^[:alnum:]_,]/', '', $chek);
						endif;
						$consultaContar = $csc->buscarsubCategoria("SELECT * FROM produto AS p JOIN estado AS e ON p.fkestado=e.idestado JOIN subcategoria AS sc ON p.fkcategoria=sc.idcategoria JOIN categoria AS c ON sc.fkcategoria=c.idcategoria JOIN produtofoto AS pf ON pf.fkproduto=p.idproduto WHERE e.idestado = " . preg_replace('/[^[:alnum:]_]/', '', $idest) . " AND sc.idcategoria IN  (" . $chek . ")  AND `preco_ac` BETWEEN " . preg_replace('/[^[:alnum:]_.]/', '', $p1) . " AND " . preg_replace('/[^[:alnum:]_.]/', '', $p2) . " GROUP BY p.nome");
						$consulta = $csc->buscarsubCategoria("SELECT p.idproduto, p.nome, p.preco_ac, p.preco_at, p.descricao, p.visibilidade, e.nomeestado, e.idestado, sc.nomecategoria,pf.foto,c.idcategoria,sc.idcategoria as idsubcategoria from produto as p JOIN estado as e on p.fkestado=e.idestado JOIN subcategoria as sc on p.fkcategoria=sc.idcategoria JOIN categoria as c ON sc.fkcategoria=c.idcategoria JOIN produtofoto as pf on pf.fkproduto=p.idproduto WHERE e.idestado = " . preg_replace('/[^[:alnum:]_]/', '', $idest) . " AND sc.idcategoria IN (" . $chek . ") and `preco_ac` BETWEEN " . preg_replace('/[^[:alnum:]_.]/', '', $p1) . " AND " . preg_replace('/[^[:alnum:]_.]/', '', $p2) . " GROUP BY p.nome limit " . preg_replace('/[^[:alnum:]_]/', '', $inicio) . ", " . preg_replace('/[^[:alnum:]_.]/', '', $quantidade_pg) . "");
					else :
						$consultaContar = $csc->consultaChekOf($idest, $p1, $p2, 0, 100000000);
						$consulta = $csc->consultaChekOf($idest, $p1, $p2, $inicio, $quantidade_pg);
					endif;
				elseif (isset($_GET['idcat'])) :
					$consultaContar = $csc->consultaProdAleatorio($idest, 0, 10000);
					$consulta = $csc->consultaProdAleatorio($idest, $inicio, $quantidade_pg);
				else :
					$consultaContar = $csc->consultaSubCat($idest, $idsc, 0, 100000000);
					$consulta = $csc->consultaSubCat($idest, $idsc, $inicio, $quantidade_pg);
				endif;

				// CONTANDO PRODUTOS
				foreach ($consultaContar as $prod) :
					foreach ($csc->buscarsubCategoria('SELECT * FROM subcategoria') as $c) :
						if (file_exists("../img/" . $c['nomecategoria'] . "/" . $prod['foto'])) : // Se foto existe na pasta is true
							contar($prod);
						endif;
					endforeach;
				endforeach;
				function contar($foto)
				{
					$numero = (int) substr($foto['foto'], -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
					if ($numero == 1) :
						global $total;
						$total += 1;
					endif;
				}

				$total = $total ?? 0;
				$num_pagina = ceil($total / $quantidade_pg);
				?>
				<!-- /aside Widget -->
				<div class="aside">
					<!-- aside Widget -->
					<h3 class="aside-title">Mais vendido</h3>
					<?php
					foreach ($consulta as $pmv) : // Trazer 4 produtos promocionais da base de dados 
						foreach ($csc->buscarsubCategoria('SELECT * FROM subcategoria') as $cat) : //Trazer todas as categorias da base de dados
							if (file_exists("../img/" . $cat['nomecategoria'] . "/" . $pmv['foto'])) : // Se foto existe na pasta is true
								if ($pmv['visibilidade'] == 'activado') :
								maisVendidos($cat['nomecategoria'], $pmv['foto']);
								endif;
							endif;
						endforeach;
					endforeach;
					function maisVendidos($pasta, $foto)
					{
						global $pmv; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
						$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
						if ($numero == 1) :
							?>
							<div class="product-widget">
								<div class="product-img">
									<img src="../img/<?php echo $pasta . '/' . $foto; ?>" alt="">
								</div>
								<div class="product-body">
									<p class="product-category"><?php echo $pmv['nomecategoria']; ?></p>
									<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&icp=<?php echo  base64_encode(base64_encode($pmv['idproduto'])) . '&np=' . $pmv['nome'] . '&pac=' . $pmv['preco_ac'] . '&pat=' . $pmv['preco_at'] . '&es=' . $pmv['nomeestado']. '&cat=' . $pmv['nomecategoria'] . '&desc=' . $pmv['descricao']; ?>"><?php echo $pmv['nome']; ?></a></h3>
									<h4 class="product-price"><?php echo number_format($pmv['preco_ac'], 2, ',', '.'); ?>Akz
										<?php if ($pmv['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
													?>
											<del class="product-old-price"><?php echo number_format($pmv['preco_at'], 2, ',', '.'); ?>Akz</del></h4>
								<?php endif; ?>
								</div>
							</div>
					<?php endif;
					} ?>
				</div>
				<!-- /aside Widget -->
			</div>
			<!-- /ASIDE -->
			<div id="store" class="col-md-9">
				<!-- STORE -->
				<div class="row">
					<?php
					//product
					foreach ($consulta as $pmv) :
						foreach ($csc->buscarsubCategoria('SELECT * FROM subcategoria') as $cat) :
							if (file_exists("../img/" . $cat['nomecategoria']. "/" . $pmv['foto'])) : // Se foto existe na pasta is true
								if ($pmv['visibilidade'] == 'activado') :
                                produtosPromocao($cat['nomecategoria'], $pmv['foto']);
							    endif;
							endif;
						endforeach;
					endforeach;
					function produtosPromocao($pasta, $foto)
					{
						global $pmv; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
						$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
						if ($numero == 1) :
							?>
							<div class="col-md-4 col-xs-6">
								<div class="product">
									<div class="product-img">
										<img src="../img/<?php echo $pasta. '/' . $foto; ?>" alt="">
										<div class="product-label">
											<!-- <span class="sale">-30%</span> -->
											<span class="new"><?php echo $pmv['nomeestado']; ?></span>
										</div>
									</div>
									<div class="product-body">
										<p class="product-category"><?php echo $pmv['nomecategoria']; ?></p>
										<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&icp=<?php echo  base64_encode(base64_encode($pmv['idproduto'])) . '&np=' . $pmv['nome'] . '&pac=' . $pmv['preco_ac'] . '&pat=' . $pmv['preco_at'] . '&es=' . $pmv['nomeestado'] . '&cat=' . $pmv['nomecategoria'] . '&desc=' . $pmv['descricao']; ?>"><?php echo $pmv['nome']; ?></a></h3>
										<h4 class="product-price"><?php echo number_format($pmv['preco_ac'], 2, ',', '.'); ?>Akz
											<?php if ($pmv['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
														?>
												<del class="product-old-price"><?php echo number_format($pmv['preco_at'], 2, ',', '.'); ?>Akz</del></h4>
									<?php endif; ?>
									</h4>
									<div class="product-rating">
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
									</div>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea" method="post">
										<input type="text" name="id_prod" value="<?php echo $pmv['idproduto']; ?>" hidden>
										<input type="text" name="nome" value="<?php echo $pmv['nome']; ?>" hidden>
										<input type="text" name="foto" value="<?php echo $pmv['foto']; ?>" hidden>
										<input type="text" name="preco_ac" value="<?php echo $pmv['preco_ac']; ?>" hidden>
										<input type="text" name="preco_at" value="<?php echo $pmv['preco_at']; ?>" hidden>
										<input type="text" name="desc" value="<?php echo $pmv['descricao']; ?>" hidden>
										<input type="text" name="ne" value="<?php echo base64_encode(base64_encode($pmv['nomeestado'])); ?>" hidden>
										<input type="text" name="nome_cat" value="<?php echo $pmv['nomecategoria']; ?>" hidden>
										<input type="text" name="idc" value="<?php echo base64_encode(base64_encode($pmv['idcategoria'])); ?>" hidden>
										<input type="text" name="idest" value="<?php echo base64_encode(base64_encode($pmv['idestado'])); ?>" hidden>
										<input type="text" name="idsc" value="<?php echo base64_encode(base64_encode($pmv['idsubcategoria'])); ?>" hidden>
										<div class="product-btns">
											<button type="submit" name="btn-detalhe" class="btn btn-link"><i class="fa fa-eye"></i><span class="tooltipp">Ver detalhe</span></button>
										</div>
									</div>
									</form>
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea" method="post">
										<input type="text" name="idprodad" value="<?php echo base64_encode(base64_encode($pmv['idproduto'])); ?>" hidden>
										<input type="text" name="idc" value="<?php echo base64_encode(base64_encode($pmv['idcategoria'])); ?>" hidden>
										<input type="text" name="ne" value="<?php echo base64_encode(base64_encode($pmv['nomeestado'])); ?>" hidden>
										<input type="text" name="idest" value="<?php echo base64_encode(base64_encode($pmv['idestado'])); ?>" hidden>
										<input type="text" name="idsc" value="<?php echo base64_encode(base64_encode($pmv['idsubcategoria'])); ?>" hidden>
										<div class="add-to-cart">
											<button type="submit" name="btn-add-carrinho" class="btn btn-danger"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
										</div>
									</form>
								</div>
							</div>
					<?php endif;
					} ?>
					<!-- /product -->
				</div>
				<!-- /store products -->
				<div class="store-filter clearfix">
					<?php
					//Verificar a pagina anterior e posterior
					$pagina_anterior = $pagina - 1;
					$pagina_posterior = $pagina + 1;
					?>
					<!-- store bottom filter -->
					<ul class="store-pagination">
						<?php
						if ($pagina_anterior != 0) {
							if (isset($_GET['btnfiltro'])) :
								if (isset($_GET["chek"])) : ?>
									<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_anterior . '&idc=' . base64_encode(base64_encode($id)) . '&chek=' . $chek . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><i class="fa fa-angle-left"></i></a></li>
								<?php else : ?>
									<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_anterior . '&idc=' . base64_encode(base64_encode($id)) . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><i class="fa fa-angle-left"></i></a></li>
								<?php endif; ?>
							<?php elseif (isset($_GET['idcat'])) : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($id)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_anterior . '&idcat=' . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><i class="fa fa-angle-left"></i></a></li>
							<?php else : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($idsc)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_anterior . '&idc=' . base64_encode(base64_encode($id)); ?>"><i class="fa fa-angle-left"></i></a></li>
							<?php endif; ?>
						<?php } else { ?>
						<?php }  ?>
						<?php
						//Apresentar a paginacao
						for ($i = 1; $i < $num_pagina + 1; $i++) {
							$estilo = "";
							if ($pagina == $i) {
								$estilo = "class=\"active\"";
							}
							if (isset($_POST['btnfiltro']) || isset($_GET['btnfiltro'])) :
								if (isset($_POST["chek"]) || isset($_GET["chek"])) : ?>
									<li <?php echo $estilo ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $i . '&idc=' . base64_encode(base64_encode($id)) . '&chek=' . $chek . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><?php echo $i; ?></a></li>
								<?php else : ?>
									<li <?php echo $estilo ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $i . '&idc=' . base64_encode(base64_encode($id)) . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><?php echo $i; ?></a></li>
								<?php endif;  ?>
							<?php elseif (isset($_GET['idcat'])) : ?>
								<li <?php echo $estilo ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($id)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $i . '&idcat=' . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><?php echo $i; ?></a></li>
							<?php else : ?>
								<li <?php echo $estilo ?>><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($idsc)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $i . '&idc=' . base64_encode(base64_encode($id)); ?>"> <?php echo $i; ?> </a></li>
							<?php endif; ?>
						<?php } ?>
						<?php
						if ($pagina_posterior <= $num_pagina) :
							if (isset($_POST['btnfiltro']) || isset($_GET['btnfiltro'])) :
								if (isset($_POST["chek"]) || isset($_GET["chek"])) : ?>
									<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_posterior . '&idc=' . base64_encode(base64_encode($id)) . '&chek=' . $chek . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><i class="fa fa-angle-right"></i></a></li>
								<?php else : ?>
									<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&btnfiltro=<?php echo '' . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_posterior . '&idc=' . base64_encode(base64_encode($id)) . '&p1=' . $p1 . '&p2=' . $p2 . '&idsc=' . base64_encode(base64_encode($idsc)); ?>"><i class="fa fa-angle-right"></i></a></li>
								<?php endif; ?>
							<?php elseif (isset($_GET['idcat'])) : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($id)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_posterior . '&idsc=' . base64_encode(base64_encode($idsc)) . '&idcat='; ?>"><i class="fa fa-angle-right"></i></a></li>
							<?php else : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($idsc)) . '&ne=' . base64_encode(base64_encode($estado)) . '&idest=' . base64_encode(base64_encode($idest)) . '&pagina=' . $pagina_posterior . '&idc=' . base64_encode(base64_encode($id)); ?>"><i class="fa fa-angle-right"></i></a></li>
							<?php endif;
							else : ?>
						<?php endif; ?>
					</ul>
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