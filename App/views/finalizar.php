<?php // 
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlEncomenda.php';
$cp = new ControlProduto();
$ce = new ControlEncomenda();
if (!isset($_SESSION)) :
	session_start();
endif;
if (!is_array($_GET['qtpd']) || !isset($_GET['qtpd']) || !isset($_SESSION['idcliente'])) : ?>
	<script>
		window.location.href = '<?php $_SERVER['PHP_SELF']; ?>?sessao=home';
	</script>
<?php endif;
$detalhe = "";
// $array = array(); // Array de parcela 0
$array[] = 0;
if (isset($_POST['btn-pedido-encomenda'])) : // Verificar pedido
	$detalhe = $_POST['detalhe'];
	$parc = $_POST['parcela'] ?? $array;
	verificarPedido($_POST['nome'], $_POST['email'], $_POST['endereco'], $_POST['telefone'], $_POST['detalhe'], $parc, $_POST['idproduto']);
endif;
if (isset($_POST['btn-finalizar-pedido'])) : // Encomendar
	$parc = $_POST['parcela'] ?? $array; 
	$ce->encomendar($_SESSION['idcliente'], $_SESSION['carrinho'], $_POST['detalhe'], $_GET['qtpd'], $parc, $_POST['idproduto']);
endif;
?>
<div id="breadcrumb" class="section">
	<!-- BREADCRUMB -->
	<div class="container">
		<!-- container -->
		<div class="row">
			<!-- row -->
			<div class="col-md-12">
				<h3 class="breadcrumb-header">Finalizar compra</h3>
				<ul class="breadcrumb-tree">
					<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
					<li class="active">Finalizar compra</li>
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
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
			<div class="row">
				<!-- row -->
				<div class="col-md-7">
					<div class="billing-details">
						<!-- Billing Details -->
						<div class="section-title">
							<h3 class="title">Endereço de Entrega</h3>
						</div>
						<div class="form-group">
							<input class="input" style="background-color:gainsboro" type="text" name="nome" value="<?php echo $_SESSION['nomecli'] . ' ' . $_SESSION['sobrenome']; ?>" placeholder="Nome" readonly>
						</div>
						<div class="form-group">
							<input class="input" style="background-color:gainsboro" type="email" name="email" value="<?php echo $_SESSION['email']; ?>" placeholder="Email" readonly>
						</div>
						<div class="form-group">
							<input class="input" style="background-color:gainsboro" type="text" name="endereco" value="<?php echo $_SESSION['bairro'] . ' - ' . $_SESSION['rua']; ?>" placeholder="Endereço 1" readonly>
						</div>
						<div class="form-group">
							<input class="input" style="background-color:gainsboro" type="tel" name="telefone" value="<?php echo $_SESSION['telefone1']; ?>" placeholder="Número de telefone" readonly>
						</div>
					</div>
					<!-- /Billing Details -->
					<!-- /Shiping Details -->
					<div class="order-notes">
						<!-- Order notes -->
						<textarea class="input" name="detalhe" placeholder="Mais detalhes..." maxlength="250" required><?php echo $detalhe; ?></textarea>
					</div>
					<!-- /Order notes -->
				</div>
				<div class="col-md-5 order-details">
					<!-- Order Details -->
					<div class="order-summary">
						<div class="order-products">
							<div class="order-col">
								<div id="n">*Produtos com entrega</div>
								<div><i id="icone" class="fa fa-truck"></i></div>
							</div>
							<div class="order-col">
								<div id="n">*Segurança 100% garantida</div>
								<div><i id="icone" class="fa fa-lock"></i></div>
							</div>
							<div class="order-col">
								<div id="n">*Só pagas depois de recebr o produto</div>
								<div><i id="icone" class="fa fa-dollar"></i></div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Order Details -->
				<div class="col-md-5 order-details">
					<!-- Order Details -->
					<div class="section-title text-center">
						<h3 class="title">Seu Pedido</h3>
					</div>
					<div class="order-summary">
						<div class="order-col">
							<div><strong>PRODUTOS</strong></div>
							<!-- <div><strong>Q</strong></div> -->
							<div><strong>TOTAL</strong></div>
						</div>
						<div class="order-products">
							<?php
							$preco_total_produtos = 0; // valor inicial que será usado no somatório do valor total do produto
							if (empty($_SESSION['carrinho']) && !isset($_COOKIE['carrinho'])) : // Se o carrinho estiver vazio
								?>
								<script>
									window.location.href = '<?php $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho';
								</script>
							<?php
							else :
								if (empty($_SESSION['carrinho'])) : // Se sessão estiver vazia adicionar na sessão o id que esta guardado no cookie carrinho
									$_SESSION['carrinho'] = unserialize(stripcslashes($_COOKIE['carrinho']));
								endif;
								$i = 0;
								$q = 0; ?>
								<div class="order-products"> <?php
																	$idproduto = array(); // Array de id de produtos em prestação
																	$nomeproduto = array(); // Array de nome de produtos em prestação
																	$preco = array(); // Array de preço em parcela de produtos em prestação
																	foreach ($_SESSION['carrinho'] as $id) :
																		foreach ($cp->produtoCarrinho($id) as $dados) :
																			$idproduto[] = $dados['idproduto']; // Pegar o id do produto independentemente do seu estado
																			?>
											<div class="order-col">
												<div>
													<?php if ($dados['fkestado'] == 3) : // Pegar nome e preço de produto em prestação
																	$nomeproduto[] = $dados['nome'];
																	$preco[] = $dados['preco_ac'];
																else : // se não estiver em prestação pega o preço 0
																	$preco[] = 0;
																endif;
																if (isset($_GET['qtpd']) && is_array($_GET['qtpd'])) :
																	echo $dados['nome']; // Nome dos produtos
																else :
																	echo 0;
																endif;
																?>
												</div>
												<div class="" style="color:#D10024;">
													<?php
																if (isset($_GET['qtpd']) && is_array($_GET['qtpd'])) :
																	echo (int) preg_replace('/[^[0-9]_]/', '', base64_decode(base64_decode($_GET['qtpd'][$q++]))); // Quantidade de produto
																	$total = $dados['preco_ac'] *  (int) preg_replace('/[^[0-9]_]/', '', base64_decode(base64_decode($_GET['qtpd'][$i++]))); // Preço total
																else : echo 0;
																endif;

																?>
												</div>
												<div>
													<?php if (isset($_GET['qtpd']) && is_array($_GET['qtpd'])) :
																	echo number_format($total, 2, ',', '.'); // Preço total
																else : echo 0;
																endif;
																?> Akz
												</div>
											</div>
									<?php $preco_total_produtos += $total; // Somatório dos preços totais
											endforeach;
										endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if (count($nomeproduto) != 0) : // Mensagem
							echo '<script>alert("⛔ O seu carrinho de compra contém produto(s) em prestação, este produto paga-se em duas prestações.\n\n*O valor do produto da primeira prestação é de 50% ou acima dos 50% do seu preço normal e o valor da segunda prestação será o restante do valor a pagar.\n\nOBS: Caso deseje pagar o produto directamenta com 100% do seu preço, ou seja, sem prestações adicione o preço normal do produto no valor da 1ª prestação.");</script>'; ?>
							<div class="order-col">
								<div><strong>Produto(s) em prestação</strong></div>
								<div><strong>Valor da 1ª prestação</strong></div>
							</div>
						<?php endif; ?>
						<div class="row">
							<div class="col-md-8 col-sm-8 col-xs-8">
								<?php // Produto em prestação 
								foreach ($nomeproduto as $nomeprod) : // Nome de produto em prestação 
									?>
									<!-- <div class="col-md-2 col-sm-2 col-xs-2">
										<div class="input-checkbox">
											<input type="checkbox" id="<?php echo $nomeprod; ?>" name="checkbox[]" value="1">
											<label for="<?php echo $nomeprod; ?>">
												<span></span>
											</label>
										</div>
									</div> -->
									<div class="form-group">
										<div class="bg-danger" style="padding:5px;">
											<h6>1ª parcela de <?php echo $nomeprod; ?></h6>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								<?php foreach ($preco as $precoprod) : // Preço de produto em prestação 
									?>
									<div class="form-group" <?php if ($precoprod == 0) : echo 'hidden'; // Se não for um produto em prestação esconde o seu input
																endif; ?>>
										<input type="number" name="parcela[]" value="<?php echo ($precoprod / 2); ?>" max="<?php echo $precoprod; ?>" min="<?php echo ($precoprod / 2); ?>" step="1" class="form-control">
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<?php foreach ($idproduto as $idprod) : // Preço de produto em prestação 
							?>
							<input type="number" name="idproduto[]" value="<?php echo $idprod; ?>" hidden>
						<?php endforeach; ?>

						<div class="order-col">
							<div class="bg-info"><strong>Entrega</strong></div>
							<div class="bg-info"><strong>GRÁTIS</strong></div>
						</div>
						<div class="order-col">
							<div><strong>TOTAL</strong></div>
							<div><strong class="order-total"><?php if (isset($preco_total_produtos)) : echo number_format($preco_total_produtos, 2, ',', '.'); // Preço total
																endif; ?></strong> <strong>Akz</strong></div>
						</div>
					</div>
					<div class="payment-method">
						<!-- <div class="input-radio">
							<input type="radio" name="payment" id="payment-1">
							<label for="payment-1">
								<span></span>
								Cartão de Crédito
							</label>
							<div class="caption" id="caption">
								<p class="text-justify">Pague com o cartão multicaixa na entrega do produto.</p>
							</div>
						</div> -->
						<!-- <div class="input-radio">
							<input type="radio" name="payment" id="payment-2">
							<label for="payment-2">
								<span></span>
								Transferência Bancária Directa - IBAN
							</label>
							<div class="caption" id="caption">
								<p class="text-justify">Faça a transferência bancária na conta do Koop e entregue o recibo no momento em que for entre o produto.</p>
								<h5>BAI - Koop</h5>
								<h5 class="text-center" id="conta">AO 96321458790</h5>
								<h5>BIC - Koop</h5>
								<h5 class="text-center" id="conta">AO 96321458790</h5>
								<h5>BCI - Koop</h5>
								<h5 class="text-center" id="conta">AO 96321458790</h5>
							</div>
						</div> -->
						<div class="input-radio">
							<input type="radio" name="payment" id="payment-3">
							<label for="payment-3">
								<span></span>
								Parcela de produto em prestação
							</label>
							<div class="caption" id="caption">
								<p class="text-justify">A 1ª parcela é paga no momento que for entregue o produto, onde será entregue um documento assumindo o compromentimento de pagamento da 2ª parcela.</p>
								<p class="text-justify">O pagamento pode ser parcelado até em 2 prestações, a 1ª parcela é paga no dia da entrega.</p>
							</div>
						</div>
						<!-- <div class="input-radio">
							<input type="radio" name="payment" id="payment-4">
							<label for="payment-4">
								<span></span>
								Depósito Bancário
							</label>
							<div class="caption" id="caption">
								<p class="text-justify">Faça o depósito na conta do Koop e entregue o recibo no momento em que for entre o produto</p>
								<h5>BAI - Koop</h5>
								<h5 class="text-center" id="conta">9 6 3 2 1 4 5 8 7 9 0</h5>
								<h5>BIC - Koop</h5>
								<h5 class="text-center" id="conta">9 6 3 2 1 4 5 8 7 9 0</h5>
								<h5>BCI - Koop</h5>
								<h5 class="text-center" id="conta">9 6 3 2 1 4 5 8 7 9 0</h5>
							</div>
						</div> -->
						<div class="input-radio">
							<input type="radio" name="payment" id="payment-5">
							<label for="payment-5">
								<span></span>
								Cash na entrega
							</label>
							<div class="caption" id="caption">
								<p>Pague com o dinheiro em mão na entrega.</p>
							</div>
						</div>
					</div>
					<div class="input-checkbox">
						<input type="checkbox" id="terms" onclick=" termoCodicao()">
						<label for="terms">
							<span></span>
							Li e aceito os <a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=termoscondicoes" style="color:#D10024">termos & condições</a>
						</label>
					</div>
					<button type="submit" name="btn-pedido-encomenda" id="btn-pedido-encomenda" class="primary-btn order-submit btn btn-md btn-primary btn-block mb-4 mt-4"><i class="fa fa-send-o"></i> Fazer o Pedido da Encomenda</button>
				</div>
				<!-- /Order Details -->
			</div>
			<!-- /row -->
		</form>
		<script>
			var btn = document.getElementById('btn-pedido-encomenda');
			btn.disabled = true;

			function termoCodicao() {
				var termos = document.getElementById('terms');
				var btn = document.getElementById('btn-pedido-encomenda');
				if (termos.checked) {
					btn.disabled = false;
				} else {
					btn.disabled = true;
				}
			}
		</script>
		<?php function verificarPedido(string $nome, string $email, string $endereco, string $telefone, string $detalhe, array $parcela, array $idproduto)
		{ ?>
			<div class="modal fade" id="modalVerificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<img src="../img/logo/koop-logo.png" alt="" style="text-align:center">
							<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
							<div class="modal-body">
								<h4 style="font-family:monospace" class="text-center"><i class="fa fa-eye" style="color:darkred"></i> Verifique se os dados estão correctos</h4>
								<!-- <p style="font-family:monospace" class="text-center">Pode fazer suas alterações aqui e finalizar o pedido</p> -->
								<div class="row">
									<div class=" col-md-12 form-group">
										<input type="text" class="form-control input" value="<?php echo $nome; ?>" name="nome" placeholder="Nome completo" readonly>
									</div>
								</div>
								<div class="row">
									<div class=" col-md-12 form-group">
										<input type="email" class="form-control input" value="<?php echo $email; ?>" name="email" placeholder="Email" readonly>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group">
										<input type="text" class="form-control input" name="end1" value="<?php echo $endereco; ?>" placeholder="Endereço" readonly>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group">
										<input type="text" class="form-control input" name="tel1" value="<?php echo $telefone; ?>" placeholder="Número de telefone" readonly>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 form-group">
										<textarea class="form-control input" name="detalhe" placeholder="Mais detalhes..." maxlength="250" autofocus required><?php echo $detalhe; ?></textarea>
									</div>
								</div>
								<?php foreach ($parcela as $vp) : ?>
									<input type="number" name="parcela[]" value="<?php echo $vp ?>" readonly hidden>
								<?php endforeach; ?>

								<?php foreach ($idproduto as $id) : ?>
									<input type="number" name="idproduto[]" value="<?php echo $id ?>" readonly hidden>
								<?php endforeach; ?>

									<div class="row">
										<div class="col-md-12">
											<button type="submit" name="btn-finalizar-pedido" class="btn btn-success"><i class="fa fa-check"></i> Finalizar Pedido</button>
											<a name="btn-finalizar-pedido" href="<?php $_SERVER['PHP_SELF'];?>?sessao=perfil&info-pessoal=" class="btn btn-primary"><i class="fa fa-male"></i> Actualizar</a>
											<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>										
										</div>
									</div>	
									<br>
									<div class="col-md-4">
									</div>
								</div>
							</form>
						</div>
					</div>
	</div>
<?php } ?>
</div>
<!-- /container -->
</div>
<!-- /SECTION -->