<?php
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlComentario.php';
include_once '../controllers/ControlUsuario.php';
$cp = new ControlProduto();
$cc = new ControlComentario();
$cu = new ControlUsuario();
if (!isset($_GET['np']) || !isset($_GET['icp']) || !isset($_GET['cat'])) : ?>
	<script>
		window.location.href = '<?php $_SERVER['PHP_SELF']; ?>?sessao=home';
	</script>
<?php endif;
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
					<li class="active"><?php echo $_GET['np']; ?></li>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->
<div class="section">
	<!-- SECTION -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div class="col-md-5 col-md-push-2">
				<!-- Product main img -->
				<div id="product-main-img">
					<?php
					if (isset($_GET['icp'])) :
						if (preg_match("/^[0-9]+$/i", base64_decode(base64_decode($_GET['icp'])))) : // Se for um número executa
							$fotos = $cp->fotoProduto(base64_decode(base64_decode($_GET['icp'])));
							foreach ($fotos as $f) : ?>
								<div class="product-preview">
									<img src="../img/<?php echo strtolower($_GET['cat']) . '/' . $f['foto']; ?>" alt="">
								</div>
					<?php endforeach;
						endif;
					endif;
					?>
				</div>
			</div>
			<!-- /Product main img -->
			<div class="col-md-2  col-md-pull-5">
				<!-- Product thumb imgs -->
				<div id="product-imgs">
					<?php
					if (isset($_GET['icp'])) :
						if (preg_match("/^[0-9]+$/i", base64_decode(base64_decode($_GET['icp'])))) : // Se for um número executa
							$fotos = $cp->fotoProduto(base64_decode(base64_decode($_GET['icp'])));
							foreach ($fotos as $f) : ?>
								<div class="product-preview">
									<img src="../img/<?php echo strtolower($_GET['cat']) . '/' . $f['foto']; ?>" alt="">
								</div>
					<?php endforeach;
						endif;
					endif;
					?>
				</div>
			</div>
			<!-- /Product thumb imgs -->
			<div class="col-md-5">
				<!-- Product details -->
				<div class="product-details">
					<h2 class="product-name"><?php echo $_GET['np']; ?></h2>
					<div>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star-o"></i>
						</div>
						<!-- Fora de serviço por enquanto por:Teca<a class="review-link" href="#">10 Análise(s) | Adicione seu comentário</a> -->
						</ul>
					</div>
					<div>
						<h3 class="product-price"><?php if (isset($_GET['pac'])) : echo number_format($_GET['pac'], 2, ',', '.');
													endif; ?>
							<?php if ($_GET['es'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
								?>
								<del class="product-old-price"><?php if (isset($_GET['pat'])) : echo number_format($_GET['pat'], 2, ',', '.');
																	endif; ?></del></h3>
					<?php endif; ?>
					<span class="product-available"><?php echo $_GET['es']; ?></span>
					</div>
					<p class="text-justify"><?php if (isset($_GET['desc'])) : echo $_GET['desc'];
											endif; ?></p>
					<div class="add-to-cart">
						<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get">
							<input type="text" name="pgn" value="false" hidden>
							<input type="text" name="icpad" value="<?php echo $_GET['icp']; ?>" hidden>
							<button type="submit" name="btn-add-carrinho" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Adicionar ao carrinho</button>
						</form>
					</div>
					<ul class="product-links">
						<li>Categoria:</li>
						<li><a href="#"><?php echo $_GET['cat']; ?></a></li>
					</ul>
					<ul class="product-links">
						<li>Compartilhar:</li>
						<li><a href="https://www.facebook.com/sharer.php?u=<?php echo $_SERVE['PHP_SELF']; ?>" target="_blank" title="Compartilhar <?php echo $_GET['np'];?> no Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="http://twitter.com/intent/tweet?text=<?php echo $_GET['np'];?>&url=<?php echo $_SERVER['SERVER_NAME'];?>&via=seunomenotwitter" title="Twittar sobre <?php echo $_GET['np'];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					</ul>
				</div>
			</div>
			<!-- /Product details -->
			<div class="col-md-12">
				<!-- Product tab -->
				<div id="product-tab">
					<ul class="tab-nav">
						<!-- product tab nav -->
						<li><a data-toggle="tab" href="#tab1">Descrição</a></li>
						<li class="active"><a data-toggle="tab" href="#tab3">Comentários (3)</a></li>
					</ul>
					<!-- /product tab nav -->
					<div class="tab-content">
						<!-- product tab content -->
						<div id="tab1" class="tab-pane fade in">
							<!-- tab1  -->
							<div class="row">
								<div class="col-md-12">
									<p><?php if (isset($_GET['desc'])) : echo $_GET['desc'];
										endif; ?></p>
								</div>
							</div>
						</div>
						<!-- /tab1  -->
						<div id="tab3" class="tab-pane fade in active">
							<!-- tab3  -->
							<div class="row">
								<!-- Rating -->
								<div class="col-md-3">
									<div id="rating">
										<div class="rating-avg">
											<?php
											$geral = 0;
											$contar = 0;
											$salto = 0;
											$saltoalterado = 0;
											// Pegar os saltos para consultar os comentários
											if (isset($_POST['btn-ver-comentario1'])) :
												$salto = 0; // Para pesquisar
												$saltoalterado = 1; // Para autofocus
											elseif (isset($_POST['btn-ver-comentario2'])) :
												$salto = 3;
											elseif (isset($_POST['btn-ver-comentario3'])) :
												$salto = 6;
											endif;
											foreach ($cc->consultarComentario(base64_decode(base64_decode($_GET['icp'])), $salto) as $dados) : // Dados do comentário
												$geral += $dados['avaliacao']; // Somatorio de todas as avaliações
												$contar = ++$contar; // Número de clientes que comentaram
											endforeach;
											?>
											<span><?php
													if ($contar == 0) :
														$contar = 1;
													endif;
													echo number_format($geral / $contar, 1); // todas a valiações dividindo pelo número de clientes que deu a sua avaliação 
													?></span>
											<div class="rating-stars">
												<?php for ($i = 0; $i < number_format($geral / $contar); $i++) : ?>
													<i class="fa fa-star"></i>
													<?php endfor;
													switch (number_format($geral / $contar)): // Número dado na avaliação / clientes que deram avaliação
														case 0: // Repete a estrela vazia 5 vezes
															for ($i = 0; $i < 5; $i++) : ?>
															<i class="fa fa-star-o"></i>
														<?php endfor;
															break;
														case 1: // Repete a estrela vazia 4 vezes
															for ($i = 0; $i < 4; $i++) : ?>
															<i class="fa fa-star-o"></i>
														<?php endfor;
															break;
														case 2: // Repete a estrela vazia 3 vezes
															for ($i = 0; $i < 3; $i++) : ?>
															<i class="fa fa-star-o"></i>
														<?php endfor;
															break;
														case 3: // Repete a estrela vazia 2 vezes
															for ($i = 0; $i < 2; $i++) : ?>
															<i class="fa fa-star-o"></i>
														<?php endfor;
															break;
														case 4: // Repete a estrela vazia 1 vez
															for ($i = 0; $i < 1; $i++) : ?>
															<i class="fa fa-star-o"></i>
													<?php endfor;
														break;
												// Case 5: Não repete a estrela vazia
												endswitch; ?>
											</div>
										</div>
										<!-- Número das etrelas dadas a cada tipo de numeração de estrela -->
										<ul class="rating">
											<?php // Valores inicias
											$c1 = 0;
											$c2 = 0;
											$c3 = 0;
											$c4 = 0;
											$c5 = 0;
											foreach ($cc->consultarComentario(base64_decode(base64_decode(($_GET['icp']))), $salto) as $dados) : // Dados do comentário?
												switch ($dados['avaliacao']): // Números de estrelas
													case 1:
														$c1 += 1; // contar o número de etrela ⭐
														break;
													case 2:
														$c2 += 1; // contar o número de etrela ⭐⭐
														break;
													case 3:
														$c3 += 1; // contar o número de etrela ⭐⭐⭐
														break;
													case 4:
														$c4 += 1; // contar o número de etrela ⭐⭐⭐⭐
														break;
													case 5:
														$c5 += 1; // contar o número de etrela ⭐⭐⭐⭐⭐
														break;
												endswitch;
											endforeach; ?>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
													</div>
													<div class="rating-progress">
														<div style="width:<?php echo ($c5 / $contar) * 100;?>px;"></div>
														<!--Calcular a percetangem de 5 estrelas dada ao produto-->
													</div>
													<span class="sum"><?php echo $c5; ?></span> <!-- Quantas vezes a estrela se repete-->
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div style="width:<?php echo ($c4 / $contar) * 100; ?>px;"></div>
														<!--Calcular a percetangem de 4 estrelas dada ao produto-->
													</div>
													<span class="sum"><?php echo $c4; ?></span> <!-- Quantas vezes a estrela se repete-->
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div style="width:<?php echo ($c3 / $contar) * 100; ?>px;"></div>
														<!--Calcular a percetangem de 3 estrelas dada ao produto-->
													</div>
													<span class="sum"><?php echo $c3; ?></span>
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div style="width:<?php echo ($c2 / $contar) * 100; ?>px;"></div>
														<!--Calcular a percetangem de 2 estrelas dada ao produto-->
													</div>
													<span class="sum"><?php echo $c2; ?></span> <!-- Quantas vezes a estrela se repete-->
												</li>
												<li>
													<div class="rating-stars">
														<i class="fa fa-star"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</div>
													<div class="rating-progress">
														<div style="width:<?php echo ($c1 / $contar) * 100; ?>px;"></div>
														<!--Calcular a percetangem de 1 estrela dada ao produto-->
													</div>
													<span class="sum"><?php echo $c1; ?></span> <!-- Quantas vezes a estrela se repete-->
												</li>
										</ul>
									</div>
								</div>
								<!-- /Rating -->

								<!-- Reviews -->
								<div class="col-md-6">
									<div id="reviews">
										<ul class="reviews">
											<?php

											foreach ($cc->consultarComentario(base64_decode(base64_decode($_GET['icp'])), $salto) as $dados) : // Dados do comentário

												?>
												<li>
													<div class="review-heading">
														<h5 class="name"><?php echo $dados['nome'] . " " . $dados['sobrenome']; ?></h5>
														<p class="date"><?php echo $dados['data']; ?></p>
														<div class="review-rating">
															<?php for ($i = 0; $i < $dados['avaliacao']; $i++) : ?>
																<!--Repete consoante o número dado na avaliação-->
																<i class="fa fa-star"></i>
																<!--Repete consoante o número dado na avaliação-->
																<?php endfor;
																	switch ($dados['avaliacao']): // Número dado na avaliação
																		case 0: // Repete a estrela vazia 5 vezes
																			for ($i = 0; $i < 5; $i++) : ?>
																		<i class="fa fa-star-o empty"></i>
																	<?php endfor;
																			break;
																		case 1: // Repete a estrela vazia 4 vezes
																			for ($i = 0; $i < 4; $i++) : ?>
																		<i class="fa fa-star-o empty"></i>
																	<?php endfor;
																			break;
																		case 2: // Repete a estrela vazia 3 vezes
																			for ($i = 0; $i < 3; $i++) : ?>
																		<i class="fa fa-star-o empty"></i>
																	<?php endfor;
																			break;
																		case 3: // Repete a estrela vazia 2 vezes
																			for ($i = 0; $i < 2; $i++) : ?>
																		<i class="fa fa-star-o empty"></i>
																	<?php endfor;
																			break;
																		case 4: // Repete a estrela vazia 1 vez
																			for ($i = 0; $i < 1; $i++) : ?>
																		<i class="fa fa-star-o empty"></i>
																<?php endfor;
																		break;
																// Case 5: Não repete a estrela vazia
																endswitch; ?>
														</div>
													</div>
													<div class="review-body">
														<p><?php echo $dados['comentario']; ?></p>
													</div>
												</li>
											<?php endforeach; ?>
										</ul>
										<!-- Ver maios comentários -->
										<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
											<ul class="reviews-pagination">
												<?php if ($salto == 0) : ?>
													<li class="active"><button name="btn-ver-comentario1" type="submit" class="btn btn-link">1</button></li>
													<li><button type="submit" name="btn-ver-comentario2" class="btn btn-link" href="#">2</button></li>
													<li><button type="submit" name="btn-ver-comentario3" class="btn btn-link" href="#">3</button></li>
												<?php
												elseif ($salto == 3) : ?>
													<li><button name="btn-ver-comentario1" type="submit" class="btn btn-link" href="#">1</button></li>
													<li class="active"><button type="submit" name="btn-ver-comentario2" class="btn btn-link">2</button></li>
													<li><button type="submit" name="btn-ver-comentario3" class="btn btn-link" href="#">3</button></li>
												<?php
												elseif ($salto == 6) : ?>
													<li><button name="btn-ver-comentario1" type="submit" class="btn btn-link" href="#">1</button></li>
													<li><button type="submit" name="btn-ver-comentario2" class="btn btn-link" href="#">2</button></li>
													<li class="active"><button type="submit" name="btn-ver-comentario3" class="btn btn-link">3</button></li>
												<?php
												else : ?>
													<li class="active"><button name="btn-ver-comentario1" type="submit" class="btn btn-link" href="#">1</button></li>
													<li><button type="submit" name="btn-ver-comentario2" class="btn btn-link" href="#">2</button></li>
													<li><button type="submit" name="btn-ver-comentario3" class="btn btn-link" href="#">3</button></li>
												<?php endif; ?>
											</ul>
										</form>

									</div>
								</div>
								<!-- /Reviews -->
								<div class="col-md-3">
									<?php
									if (isset($_POST['btn-comentar'])) :
										if (!isset($_SESSION)) :
											session_start();
										endif;
										if (isset($_GET['icp']) && isset($_SESSION['idcliente'])) :
											if (!isset($_POST['avaliacao'])) :
												$cc->comentarProduto($_POST['comentario'], $_POST['avaliacao'] = 0, base64_decode(base64_decode($_GET['icp'])), $_SESSION['idcliente']);
											else :
												$cc->comentarProduto($_POST['comentario'], $_POST['avaliacao'], base64_decode(base64_decode($_GET['icp'])), $_SESSION['idcliente']);
											endif;
										else :
											login("", "");
										endif;
									endif
									?>
									<!-- Review Form -->
									<div id="review-form">
										<form class="review-form" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
											<?php if ($saltoalterado == 1 || $salto == 3 || $salto == 6) : // autofocus ao ver mais comentários
												?>
												<textarea class="input" name="comentario" onfocus="this.value='';" placeholder="Seu Comentário" maxlength="123" required autofocus></textarea>
											<?php else : ?>
												<textarea class="input" name="comentario" onfocus="this.value='';" placeholder="Seu Comentário" maxlength="123" required></textarea>
											<?php endif; ?>
											<div class="input-rating">
												<span>Sua Avaliação: </span>
												<div class="stars">
													<input id="star5" name="avaliacao" value="5" type="radio"><label for="star5"></label>
													<input id="star4" name="avaliacao" value="4" type="radio"><label for="star4"></label>
													<input id="star3" name="avaliacao" value="3" type="radio"><label for="star3"></label>
													<input id="star2" name="avaliacao" value="2" type="radio"><label for="star2"></label>
													<input id="star1" name="avaliacao" value="1" type="radio"><label for="star1"></label>
												</div>
											</div>
											<button type="submit" name="btn-comentar" class="primary-btn">Comentar <i class="fa fa-comments"></i></button>
										</form>
									</div>
								</div>
								<!-- /Review Form -->
							</div>
						</div>
						<!-- /tab3  -->
					</div>
					<!-- /product tab content  -->
				</div>
			</div>
			<!-- /product tab -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->

<!-- Section -->
<div class="section">
	<!-- container -->
	<div class="container">
		<div class="row">
			<!-- row -->
			<div class="col-md-12">
				<div class="section-title text-center">
					<h3 class="title">Produtos Relacionados</h3>
				</div>
			</div>
			<?php
			foreach ($cp->produtoMaisvendido() as $pr) : // Listar produtos relacionados
				if (file_exists("../img/" . strtolower($_GET['cat']) . "/" . $pr['foto'])) : // Se foto existe na pasta is true
					relacionados($_GET['cat'], $pr['foto']);
				endif;
			endforeach;
			function relacionados($pasta, $foto)
			{
				global $pr; // variável global: pode ser acessada em qualquer lugar do código //Método que mostra novos produtos
				$numero = (int) substr($foto, -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
				if ($numero == 1) : ?>
					<!-- product -->
					<div class="col-md-3 col-xs-6">
						<div class="product">
							<div class="product-img">
								<img src="../img/<?php echo strtolower($pasta) . '/' . $foto; ?>" alt="">
								<div class="product-label">
									<span class="new"><?php echo $pr['nomeestado']; ?></span>
								</div>
							</div>
							<div class="product-body">
								<p class="product-category"><?php echo $pr['nomecategoria']; ?></p>
								<h3 class="product-name"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $pr['nome'] . '&pac=' . $pr['preco_ac'] . '&pat=' . $pr['preco_at'] . '&es=' . $pr['nomeestado']  . '&cat=' . $pr['nomecategoria'] . '&desc=' . $pr['descricao'] . '&icp=' . base64_encode(base64_encode($pr['idproduto'])); ?>">
										<div><?php echo $pr['nome']; ?></div>
									</a></h3>
								<h4 class="product-price"><?php echo number_format($pr['preco_ac'], 2, ',', '.'); ?>Akz
									<?php if ($pr['nomeestado'] == 'Promoção') : // Se o produto está em promoção mostrar o seu valor antigo
												?>
										<del class="product-old-price"><?php echo number_format($pr['preco_at'], 2, ',', '.'); ?></del></h4>
							<?php endif; ?>
							<div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div>
							<div class="product-btns">
								<a class="btn btn-link" href="<?php $_SERVER['PHP_SELF']; ?>?sessao=produto&np=<?php echo $pr['nome'] . '&pac=' . $pr['preco_ac'] . '&pat=' . $pr['preco_at'] . '&es=' . $pr['nomeestado'] . '&cat=' . $pr['nomecategoria'] . '&desc=' . $pr['descricao'] . '&icp=' . base64_encode(base64_encode($pr['idproduto'])); ?>">
									<p style="font-size:9pt;">Detalhe&nbsp;Completo</p>
								</a>
							</div>
							</div>
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get">
								<input type="text" name="pgn" value="false" hidden>
								<input type="text" name="icpad" value="<?php echo base64_encode(base64_encode($pr['idproduto'])); ?>" hidden>
								<div class="add-to-cart">
									<button type="submit" name="btn-add-carrinho" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> adicionar ao carrinho</button>
								</div>
							</form>
						</div>
					</div>
					<!-- /product -->
			<?php endif;
			} ?>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /Section -->
<!-- Modal -->
