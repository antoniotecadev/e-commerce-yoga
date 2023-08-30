<?php
include_once '../controllers/ControlLeilao.php';
include_once '../controllers/ControlUsuario.php';

$cl = new ControlLeilao();
$cu = new ControlUsuario();

foreach ($cl->maiorValor() as $valor) : // Consultar o maior valor pago
endforeach;

foreach ($cl->dadosLeilao() as $v) : // Consultar dados
endforeach;

if ($v['estado'] == 'desactivado' || $v['estado'] == null) :?>
	<script>window.location.href ='<?php $_SERVER['PHP_SELF'];?>?sessao=home';</script>
<?php endif;
	if (isset($_POST['btn-pago'])) :
		if (isset($_SESSION['idcliente'])) :
			$cl->pagar($_SESSION['idcliente'], $_POST['valor_pago']);
		else :
			login("", "");
		endif;
	endif;
?>

<style>
	table#table-leilao tr:hover {
		background-color: rgb(206, 206, 255)
	}

	table#table-leilao tr {
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
					<li class="active"><?php echo $v['nome'];?></li>
				</ul>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /BREADCRUMB -->
<div id="hot-deal" class="section">
	<!-- HOT DEAL SECTION -->
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="hot-deal">
					<h2 class="text-uppercase"> <i class="fa fa-legal"></i> Termino ⏰</h2>
					<ul class="hot-deal-countdown timer">
						<li class="justify-content-center align-items-center">
							<div id="dia">
								<div class="timer_num"><?php echo $v['dia']; ?></div>
								<span>Dia</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="hora">
								<div class="timer_num"><?php echo $v['hora']; ?></div>
								<span>Horas</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="min">
								<div class="timer_num"><?php echo $v['minuto']; ?></div>
								<span>Minutos</span>
							</div>
						</li>
						<li class="justify-content-center align-items-center">
							<div id="seg">
								<div class="timer_num"><?php echo 0; ?></div>
								<span>Segundos</span>
							</div>
						</li>
					</ul>


					<p>aproveite esta oportunidade antes que o tempo termine</p>
					<a class="primary-btn cta-btn">Entrega grátis</a>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
</div>
</div>
</div>
<div class="section">
	<!-- SECTION -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div class="col-md-5 col-md-push-2">
				<!-- Product main img -->
				<div id="product-main-img">
					<div class="product-preview">
						<img src="../img/produto-leilao/<?php echo $v['foto'];?>" alt="">
					</div>
				</div>
			</div>
			<!-- /Product main img -->
			<div class="col-md-2  col-md-pull-5">
				<!-- Product thumb imgs -->
				<div id="product-imgs">
					<div class="product-preview">
						<img src="../img/produto-leilao/<?php echo $v['foto'];?>" alt="">
					</div>
				</div>
			</div>
			<!-- /Product thumb imgs -->
			<div class="col-md-5">
				<!-- Product details -->
				<div class="product-details">
					<h2 class="product-name"><?php echo $v['nome']; // nome do produto
												?></h2>
					<div>
						<div class="product-rating">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>
					</div>
					<div>
						<h3 class="product-price"><?php echo number_format($v['preco_inicial'], 2, ',', '.'); ?></h3>
						<span class="product-available">Preço inicial</span>
					</div>
					<p><?php echo $v['descricao']; ?></p>
					<ul class="product-links">
						<li>Compartilhar:</li>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="#"><i class="fa fa-envelope"></i></a></li>
						<li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					</ul><br>
					<div class="add-to-cart">
						<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=leilao" method="post">
							<div class="qty-label">
								Quanto pagas
								<div class="input-number">
									<input type="text" id="salto_preco" value="<?php echo $v['salto_preco']; ?>" readonly hidden>
									<input type="text" id="preco_inicial" value="<?php if (isset($valor['Max(lc.valor_pago)'])) : echo $valor['Max(lc.valor_pago)'];
																					else : echo $v['preco_inicial'];
																					endif; ?>" readonly hidden>
									<input type="number" name="valor_pago" value="<?php if (isset($valor['Max(lc.valor_pago)'])) : echo  $valor['Max(lc.valor_pago)'];
																					else : echo $v['preco_inicial'];
																					endif; ?>" readonly>
									<span class="qty-up">+</span>
									<span class="qty-down">-</span>
								</div>
							</div>
							<button type="submit" name="btn-pago" class="add-to-cart-btn"><i class="fa fa-check"></i> Pago</button>
						</form>
						<p style="color:lightslategray;"> <i class="fa fa-warning" style="color:red;"></i> Não pode pagar um valor já pago.</p><br>
						<?php if (isset($valor['nome'])) : ?>
							<p><strong style="color:green;"><?php echo $valor['nome'] . ' ' . $valor['sobrenome']; ?></strong> está na frente para comprar o(a) <h4><?php echo $v['nome']; ?></h4>
							</p>
						<?php endif; ?>
					</div>
					<div class="table-responsive" style="height:515px">
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
			<!-- /Product details -->
			<div class="col-md-12">
				<!-- Product tab -->
				<div id="product-tab">
					<ul class="tab-nav">
						<!-- product tab nav -->
						<li class="active"><a data-toggle="tab" href="#tab1">Sobre leilão</a></li>
						<li><a data-toggle="tab" href="#tab2">Descrição</a></li>
					</ul>
					<!-- /product tab nav -->
					<div class="tab-content">
						<!-- product tab content -->
						<div id="tab1" class="tab-pane fade in active">
							<!-- tab1  -->
							<div class="row">
								<div class="col-md-12">
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
								</div>
							</div>
						</div>
						<!-- /tab1  -->
						<div id="tab2" class="tab-pane fade in">
							<!-- tab2  -->
							<div class="row">
								<div class="col-md-12">
									<p><?php echo $v['descricao']; ?></p>
								</div>
							</div>
						</div>
						<!-- /tab2  -->
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
					<h3 class="title">Brevemente em Leilão</h3>
				</div>
			</div>
			<div class="col-md-3 col-xs-6">
				<!-- product -->
				<div class="product">
					<div class="product-img">
						<img src="../img/product01.png" alt="">
					</div>
					<div class="product-body">
						<p class="product-category">Categoria</p>
						<h3 class="product-name"><a href="#">nome do produto vai aqui</a></h3>
						<div class="product-rating">
						</div>
					</div>
				</div>
			</div>
			<!-- /product -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /Section -->