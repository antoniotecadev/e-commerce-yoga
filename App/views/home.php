<?php
include_once '../controllers/ControlCategoria.php';
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlSubCategoria.php';
include_once '../controllers/ControlLeilao.php';
include_once '../controllers/ControlSlider.php';
include_once '../controllers/ControlUsuario.php';



$cp = new ControlProduto();
$cc = new ControlCategoria();
$csc = new ControlSubCategoria();
$cl = new ControlLeilao();
$cs = new ControlSlider();
$cu = new ControlUsuario();


foreach ($cl->dadosLeilao() as $vl) : // Consultar dados
endforeach;
?>
<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
	<!--data-ride="carousel" transação de imagem automático-->
	<ol class="carousel-indicators" id="slider">
		<!-- Indicadores-os pontos -->
		<li data-target="#carousel" data-slide-to="0" class="active"></li>
		<li data-target="#carousel" data-slide-to="1"></li>
		<li data-target="#carousel" data-slide-to="2"></li>
		<li data-target="#carousel" data-slide-to="3"></li>
	</ol>
	<div class="container-fluider">
		<div class="carousel-inner" role="listbox">
			<!--onde vai estar o conteudo-->
			<?php foreach ($cs->imagemSlider() as $imagem) :
				if ($imagem['visibilidade'] == 'activado') : ?>
					<div class="item <?php echo $imagem['primeiro']; ?>">
						<img class="d-block w-100" src="../img/sliders/<?php echo $imagem['foto']; ?>" alt="" height="">
					</div>
			<?php endif;
			endforeach; ?>
		</div>
		<!-- carousel-inner -->
	</div>
	<a href="#carousel" class="left carousel-control" data-slide="prev">
	</a>
	<a href="#carousel" class="right carousel-control" data-slide="next">
	</a>
</div>
<!--carousel-->
</div>
<div class="section">
	<!-- SECTION -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div class="col-md-4 col-xs-6">
				<!-- shop -->
				<div class="shop">
					<div class="shop-img">
						<img src="../img/capa-promocao/capa-promocao.jpg" alt="">
					</div>
					<div class="shop-body">
						<h3>Produto(s) em<br>Promoção</h3>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(2)) . '&ne=' . base64_encode(base64_encode("Promoção")); ?>" class="cta-btn">Compre Agora <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<!-- /shop -->
			<div class="col-md-4 col-xs-6">
				<!-- shop -->
				<div class="shop">
					<div class="shop-img">
						<img src="../img/capa-leilao/capa-leilao.jpg" alt="">
					</div>
					<?php if ($vl['estado'] == 'activado') : ?>
						<div class="shop-body">
							<h3>Produto em<br>Leilão</h3>
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=leilao" class="cta-btn">Compre Agora <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					<?php else : ?>
						<div class="shop-body">
							<h3>Aguarde<br>Pelo leilão...</h3>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<!-- /shop -->
			<div class="col-md-4 col-xs-6">
				<!-- shop -->
				<div class="shop">
					<div class="shop-img">
						<img src="../img/capa-prestacao/capa-prestacao.jpg" alt="">
					</div>
					<div class="shop-body">
						<h3>Produto(s) em<br>Prestação</h3>
						<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(3)) . '&ne=' . base64_encode(base64_encode("Prestação")); ?>" class="cta-btn">Compre Agora <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			</div>
			<?php foreach ($cc->todasCategorias(1) as $v) : ?>
				<!-- /shop -->
				<div class="col-md-4 col-xs-6">
					<!-- shop -->
					<div class="shop">
						<div class="shop-img">
							<img src="../img/capa-categoria/<?php echo $v['imgcapa']; ?>" alt="">
						</div>
						<div class="shop-body">
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idc=<?php echo base64_encode(base64_encode($v['idcategoria'])) . '&ne=' . base64_encode(base64_encode($v['nomeestado'])) . '&idest=' . base64_encode(base64_encode(1)) ?>" class="cta-btn"><?php echo $v['nomecategoria']; ?> <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</div>
				<!-- /shop -->
			<?php endforeach; ?>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<div class="section">
	<!-- SECTION -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div class="col-md-12">
				<!-- section title -->
				<h4 class=""><img src="../img/logo/koop-logo.png" alt=""></h4>
				<div class="section-title">
					<div class="section-nav">
						<ul class="section-tab-nav tab-nav">
							<?php foreach ($csc->carregarSubcategorias() as $v) : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($v['idsubcategoria'])) . '&ne=' . base64_encode(base64_encode($v['nomeestado'])) . '&idc=' . base64_encode(base64_encode($v['idcategoria'])) . '&idest=' . base64_encode(base64_encode($v['idestado'])); ?>"><?php echo $v['nomecategoria']; ?></a></li>
							<?php endforeach ?>
							<?php  ?>
						</ul>
						<div><br></div>
					</div>
					<h3 class="title">Novos Produtos</h3>
				</div>
			</div>
			<!-- /section title -->
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
														<?php if ($_POST['nome_est'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
																?>
															<del class="product-old-price"><?php echo number_format($_POST['preco_at'], 2, ',', '.'); ?></del></h4>
														<?php endif; ?>
														<div class="row">
															<div class="col-md-6">
																<p class="text-justify"><?php echo $_POST['desc']; // Descricao
																							?></p>
															</div>
														</div>
														<a href="<?php $_SERVER['PHP_SELF'] ?>?sessao=produto&np=<?php echo $_POST['nome'] . '&pac=' . $_POST['preco_ac'] . '&pat=' . $_POST['preco_at'] . '&es=' . $_POST['nome_est'] . '&cat=' . $_POST['nome_cat'] . '&desc=' . $_POST['desc'] . '&icp=' . base64_encode(base64_encode($_POST['id_prod'])); ?>">Ver Delhate Completo do Produto</a>
												</div>
												<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=home" method="get">
													<!-- Add to Cart Form -->
													<input type="text" name="pgn" value="true" hidden>
													<input type="text" name="icpad" value="<?php echo base64_encode(base64_encode($_POST['id_prod'])); ?>" hidden>
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
				</div>
				<!-- ****** Quick View Modal Area End ****** -->
			<?php endif; ?>
			<div class="col-md-12">
				<!-- Products tab & slick -->
				<div class="row">
					<div class="products-tabs">
						<div id="tab1" class="tab-pane active">
							<!-- tab -->
							<div class="products-slick" data-nav="#slick-nav-1">
								<?php
								// product 
								foreach ($cp->novosProdutos() as $nvp) : // Mostrar produto novo
									if ($nvp['visibilidade'] == 'activado') : 
									novosProdutos($nvp['nomecategoria'], $nvp['foto']);
									endif;
								endforeach;
								function novosProdutos($pasta, $foto)
								{
									global $nvp; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
									$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
									if ($numero == 1) :
							
										?>
										<div class="product">
											<div class="product-img">
												<img src="../img/<?php echo strtolower($pasta) . '/' . $foto; ?>" alt="">
												
												<div class="product-label">
													<span class="new"><?php echo $nvp['nomeestado']; ?></span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category" id=""><?php echo $nvp['nomecategoria']; ?></p>
												<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $nvp['nome'] . '&pac=' . $nvp['preco_ac'] . '&pat=' . $nvp['preco_at'] . '&es=' . $nvp['nomeestado'] . '&cat=' . $nvp['nomecategoria'] . '&desc=' . $nvp['descricao'] . '&icp=' . base64_encode(base64_encode($nvp['idproduto'])); ?>">
														<div><?php echo $nvp['nome']; ?></div>
													</a></h3>
												<h4 class="product-price"><?php echo number_format($nvp['preco_ac'], 2, ',', '.'); ?>Akz
													<?php if ($nvp['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
																?>
														<del class="product-old-price"><?php echo number_format($nvp['preco_at'], 2, ',', '.'); ?></del></h4>
											<?php endif; ?>
											<div class="product-rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
											</div>
											<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=home" method="post">

												<input type="text" name="id_prod" value="<?php echo $nvp['idproduto']; ?>" hidden>
												<input type="text" name="nome" value="<?php echo $nvp['nome']; ?>" hidden>
												<input type="text" name="foto" value="<?php echo $nvp['foto']; ?>" hidden>
												<input type="text" name="preco_ac" value="<?php echo $nvp['preco_ac']; ?>" hidden>
												<input type="text" name="preco_at" value="<?php echo $nvp['preco_at']; ?>" hidden>
												<input type="text" name="desc" value="<?php echo $nvp['descricao']; ?>" hidden>
												<input type="text" name="nome_est" value="<?php echo $nvp['nomeestado']; ?>" hidden>
												<input type="text" name="nome_cat" value="<?php echo $nvp['nomecategoria']; ?>" hidden>

												<div class="product-btns">
													<button type="submit" name="btn-detalhe" class="btn btn-link"><i class="fa fa-eye"></i><span class="tooltipp">Ver detalhe</span></button>
												</div>
											</div>
											</form>
											<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=home" method="get">
												<input type="text" name="pgn" value="true" hidden>
												<input type="text" name="icpad" value="<?php echo base64_encode(base64_encode($nvp['idproduto'])); ?>" hidden>
												<div class="add-to-cart">
													<button type="submit" name="btn-add-carrinho" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
												</div>
											</form>
										</div>
								<?php endif;
								} ?>
								<!--/ product -->
							</div>
							<div id="slick-nav-1" class="products-slick-nav"></div>
						</div>
						<!-- /tab -->
					</div>
				</div>
			</div>
			<!-- Products tab & slick -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section" style="background-image: url('../img/produto-leilao/<?php if ($vl['estado'] == 'activado') : echo $vl['foto'];endif; ?>');">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="hot-deal">
					<ul class="hot-deal-countdown timer">
						<li class="justify-content-center align-items-center">
							<div id="dia">
								<div id="day" class="timer_num"><?php echo $vl['dia']; ?></div>
								<span>Dias</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="hora">
								<div id="hour" class="timer_num"><?php echo $vl['hora']; ?></div>
								<span>Horas</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="min">
								<div id="minute" class="timer_num"><?php echo $vl['minuto']; ?></div>
								<span>Minutos</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="seg">
								<div id="second" class="timer_num"><?php echo 0; ?></div>
								<span>Segundos</span>
							</div>
						</li>
					</ul>
					<?php if ($vl['estado'] == 'activado') : ?>
					<h2 class="text-uppercase" style="color:white;"><?php echo $vl['titulo']; ?></h2>
					<p style="color:white;"> <?php echo $vl['subtitulo']; ?></p>
					<a class="primary-btn cta-btn" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=leilao">Compre agora</a>
					<?php else:?>
						<h2 class="text-uppercase" style="color:white;">brevemente</h2>
						<p style="color:white;">produto em leilão estará disponível</p>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /HOT DEAL SECTION -->
<div class="section">
	<!-- SECTION -->
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<!-- section title -->
			<div class="col-md-12">
				<h4 class=""><img src="../img/logo/koop-logo.png" alt=""></h4>
				<div class="section-title">
					<div class="section-nav">
						<ul class="section-tab-nav tab-nav">
							<?php foreach ($csc->carregarSubcategorias() as $v) : ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idsc=<?php echo base64_encode(base64_encode($v['idsubcategoria'])) . '&ne=' . base64_encode(base64_encode($v['nomeestado'])) . '&idc=' . base64_encode(base64_encode($v['idcategoria'])) . '&idest=' . base64_encode(base64_encode($v['idestado'])); ?>"><?php echo $v['nomecategoria']; ?></a></li>
							<?php endforeach ?>
						</ul>
						<div><br></div>
					</div>
					<h3 class="title">Mais vendido</h3>
				</div>
			</div>
			<!-- /section title -->
			<!-- Products tab & slick -->
			<div class="col-md-12">
				<!-- Products tab & slick -->
				<div class="row">
					<div class="products-tabs">
						<div id="tab6" class="tab-pane active">
							<!-- tab -->
							<div class="products-slick" data-nav="#slick-nav-6">
								<?php
								foreach ($cp->produtoMaisvendido() as $pmv) :
									if ($pmv['visibilidade'] == 'activado') : 
										maisVendidos($pmv['nomecategoria'], $pmv['foto']);
									endif;
								endforeach;
								function maisVendidos($pasta, $foto)
								{
									global $pmv; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
									$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
									if ($numero == 1) :
										?>
										<div class="product">
											<div class="product-img">
												<img src="../img/<?php echo strtolower($pasta) . '/' . $foto; ?>" alt="">
												<div class="product-label">
													<span class="new"><?php echo $pmv['nomeestado']; ?></span>
												</div>
											</div>
											<div class="product-body">
												<p class="product-category" id=""><?php echo $pmv['nomecategoria']; ?></p>
												<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $pmv['nome'] . '&pac=' . $pmv['preco_ac'] . '&pat=' . $pmv['preco_at'] . '&es=' . $pmv['nomeestado'] . '&cat=' . $pmv['nomecategoria'] . '&desc=' . $pmv['descricao'] . '&icp=' . base64_encode(base64_encode($pmv['idproduto'])); ?>">
														<div><?php echo $pmv['nome']; ?></div>
													</a></h3>
												<h4 class="product-price"><?php echo number_format($pmv['preco_ac'], 2, ',', '.'); ?>Akz
													<?php if ($pmv['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
																?>
														<del class="product-old-price"><?php echo number_format($pmv['preco_at'], 2, ',', '.'); ?></del></h4>
											<?php endif; ?>
											<div class="product-rating">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
											</div>
											<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

												<input type="text" name="id_prod" value="<?php echo $pmv['idproduto']; ?>" hidden>
												<input type="text" name="nome" value="<?php echo $pmv['nome']; ?>" hidden>
												<input type="text" name="foto" value="<?php echo $pmv['foto']; ?>" hidden>
												<input type="text" name="preco_ac" value="<?php echo $pmv['preco_ac']; ?>" hidden>
												<input type="text" name="preco_at" value="<?php echo $pmv['preco_at']; ?>" hidden>
												<input type="text" name="desc" value="<?php echo $pmv['descricao']; ?>" hidden>
												<input type="text" name="nome_est" value="<?php echo $pmv['nomeestado']; ?>" hidden>
												<input type="text" name="nome_cat" value="<?php echo $pmv['nomecategoria']; ?>" hidden>

												<div class="product-btns">
													<button type="submit" name="btn-detalhe" class="btn btn-link"><i class="fa fa-eye"></i><span class="tooltipp">Ver detalhe</span></button>
												</div>
											</form>
											</div>
											<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=home" method="get">
												<input type="text" name="pgn" value="true" hidden>
												<input type="text" name="icpad" value='<?php echo base64_encode(base64_encode($pmv['idproduto'])); ?>' hidden>
												<div class="add-to-cart">
													<button type="submit" name="btn-add-carrinho" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
												</div>
											</form>
										</div>
								<?php endif;
								} ?>
								<!--/ product -->
							</div>
							<div id="slick-nav-6" class="products-slick-nav"></div>
						</div>
						<!-- /tab -->
					</div>
				</div>
			</div>
			<!-- Products tab & slick -->
			<!-- /Products tab & slick -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Mais vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-2" class="products-slick-nav"></div>
					</div>
				</div>
				<div class="products-widget-slick" data-nav="#slick-nav-2">
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach; ?>
					</div>
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach;
						?>
						<!-- /product widget -->
					</div>
				</div>
			</div>
			<div class="clearfix visible-sm visible-xs"></div>
			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Mais vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-3" class="products-slick-nav"></div>
					</div>
				</div>
				<div class="products-widget-slick" data-nav="#slick-nav-3">
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach; ?>
					</div>
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach;
						?>
						<!-- /product widget -->
					</div>
				</div>
			</div>
			<div class="clearfix visible-sm visible-xs"></div>
			<div class="col-md-4 col-xs-6 hidden-xs">
				<div class="section-title">
					<h4 class="title">Mais vendido</h4>
					<div class="section-nav">
						<div id="slick-nav-4" class="products-slick-nav"></div>
					</div>
				</div>
				<div class="products-widget-slick" data-nav="#slick-nav-4">
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach; ?>
					</div>
					<div>
						<?php
						foreach ($cp->produtoMaisvendido() as $pmvw) : // Mostrar produto novo
							if ($pmvw['visibilidade'] == 'activado') :
								maisVendido($pmvw['nomecategoria'], $pmvw['foto']);
							endif;
						endforeach;
						?>
						<!-- /product widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
<?php function maisVendido($pasta, $foto)
{
	global $pmvw; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
	$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
	if ($numero == 1) :
		?>
		<!-- product widget -->
		<div class="product-widget">
			<div class="product-img">
				<img src="../img/<?php echo strtolower($pasta) . '/' . $foto; ?>" alt="">
			</div>
			<div class="product-body">
				<p class="product-category"><?php echo $pmvw['nomecategoria']; ?></p>
				<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $pmvw['nome'] . '&pac=' . $pmvw['preco_ac'] . '&pat=' . $pmvw['preco_at'] . '&es=' . $pmvw['nomeestado'] . '&cat=' . $pmvw['nomecategoria'] . '&desc=' . $pmvw['descricao'] . '&icp=' . base64_encode(base64_encode($pmvw['idproduto'])); ?>">
						<div><?php echo $pmvw['nome']; ?></div>
					</a></h3>
				<h4 class="product-price"><?php echo number_format($pmvw['preco_ac'], 2, ',', '.'); ?>Akz
					<?php if ($pmvw['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
								?>
						<del class="product-old-price"><?php echo number_format($pmvw['preco_at'], 2, ',', '.'); ?></del></h4>
			<?php endif; ?>
			</div>
		</div>
	<?php endif;
	}
	if (!isset($_SESSION)) :
		session_start();
	endif;
	if (isset($_GET['cli'])) :
		if ($_GET['cli'] == 'true' && !isset($_POST['entrar'])) :
			mensagem('BEM - VIND🤗', "Os dados da sua conta foram enviados para o seu email: <strong>".base64_decode(base64_decode($_GET['eml']))."</strong>", "OK"); 
		endif;
	elseif (isset($_GET['encomenda'])) :
		if ($_GET['encomenda'] == 'true') :
			mensagem('  ✔ Pedido feito', 'O seu pedido está a ser processado...<br>Entraremos em contacto com o(a) senhor(a) em menos de <strong>24h</strong>', 'Ok'); 
		endif;
	endif;
	function mensagem($titulo, $mensagem, $button)
	{
		?>
	<!-- Modal -->
	<div class="modal fade" id="view-bem-vindo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="row">
						<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
							<img src="../img/logo/koop-logo.png" alt="">
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
							<h1 style="color:green"><?php echo $titulo; ?></h1>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
						<?php if (isset($_SESSION['nomecli']) || isset($_SESSION['sobrenome'])) : ?>
							<h2 class="text-center"><?php echo  $_SESSION['nomecli']." ".$_SESSION['sobrenome'];?></h2>
						<?php endif; ?>
							<p class="text-center" style="font-size:14pt;"><?php echo $mensagem; ?></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="<?php $_SERVER['PHP_SELF'];?>?sessao=home" class="btn btn-success"> <i class="fa fa-shopping-cart"></i> <?php echo $button; ?></a>
				</div>
			</div>
		</div>
	</div>
	<!--/Modal  -->
<?php }
