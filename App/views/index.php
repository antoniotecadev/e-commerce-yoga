<?php
include_once '../controllers/ControlCategoria.php';
include_once '../controllers/ControlSubCategoria.php';
include_once '../controllers/ControlLeilao.php';
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlUsuario.php';

$cc = new ControlCategoria();
$csc = new ControlSubCategoria();
$cl = new ControlLeilao();
$cp = new ControlProduto();
$cu = new ControlUsuario();

// var_dump($cp->produtoMaisvendido());
foreach ($cl->dadosLeilao() as $vl) : // Consultar dados
endforeach;

if (!isset($_SESSION)) :
	session_start();
endif;
// Adicionar produto ao carrinho de compra
if (isset($_GET['btn-add-carrinho']) || isset($_POST['btn-add-carrinho'])) :
	$_GET['icpad'] = $_GET['icpad'] ?? $_POST['idprodad'];
	if (isset($_GET['icpad'])) :
		$id_prod = base64_decode(base64_decode($_GET['icpad'])); // Pegar o id
		$_SESSION['carrinho'][$id_prod] = $id_prod; // Adicionar o id em um array da sessão

		setcookie('carrinho', ""); // Limpar o cookie caso existe
		unset($_COOKIE['carrinho']); // apagar o cookie caso exista
		setcookie('carrinho', serialize($_SESSION['carrinho']), Time() + 3600); // criar um novo cookie adicionando a sessão
		if (isset($_GET['pgn'])) :
			if ($_GET['pgn'] == 'true') : // Se for na mesma página
				header('refresh:0;url=' . $_SERVER['PHP_SELF']);
			elseif ($_GET['pgn'] == 'false') : ?>
				<script>
					document.location.href = history.go(-1); // Este codigo no telefone não funciona correctamente
				</script>
	<?php endif;
		endif;
	endif;
endif;

// Eliminar produto do carrinho de compra pelo post
if (isset($_POST['btn-eliminar'])) :
	if (isset($_POST['idprodel'])) :
		$id_prod = $_POST['idprodel'];
		unset($_SESSION['carrinho'][$id_prod]); // Apagar o produto do carrinho
		setcookie('carrinho', ""); // Limpar o cookie caso existe
		unset($_COOKIE['carrinho']); // apagar o cookie caso exista
		// Criar o cookie somente se a session for diferente de vazio
		if (!empty($_SESSION['carrinho'])) :
			setcookie('carrinho', serialize($_SESSION['carrinho']), time() + 3600); // Criar novo cookie
		endif;
		header('refresh:0;url=' . $_SERVER['PHP_SELF'] . '?sessao=vercarrinho');
	endif;
endif;
// Eliminar produto do carrinho de compra pelo get
if (isset($_GET['icquant'])) :
	if (is_array($_GET['icquant'])) :
		foreach ($_GET['icquant'] as $id) :
			unset($_SESSION['carrinho'][base64_decode(base64_decode($id))]); // Apagar o produto do carrinho
			setcookie('carrinho', ""); // Limpar o cookie caso existe
			unset($_COOKIE['carrinho']); // apagar o cookie caso exista
			// Criar o cookie somente se a session for diferente de vazio
			if (!empty($_SESSION['carrinho'])) :
				setcookie('carrinho', serialize($_SESSION['carrinho']), time() + 3600); // Criar novo cookie
			endif;
		endforeach;
	endif;
endif;
$email = "";
if (isset($_POST['iniciar-sessao'])) :
	$email = $_POST['email'];
	$cu->entrarConta($_POST['email'], $_POST['password']);
	if (isset($cu)) : // Se palavra passe for errada executa
		login("<strong>Erro</strong>, E-mail / n° de telefone ou palavra-passe errada", $email); // Erro no email/número de telefone ou palavra passe
	endif;
elseif (isset($_POST['entrar'])) :
	login("", "");
endif;
function login($msg, $email) // Método para chamar o modal de login
{ ?>
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
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
						<h4>Iniciar Sessão</h4>
						<p style="color:red;"><?php echo $msg; ?></p>
						<div class="row">
							<div class=" col-md-12 form-group">
								<input type="text" class="form-control input-lg" value="<?php echo $email; ?>" name="email" id="email" placeholder="Email ou número de telefone" required autofocus>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 form-group">
								<input type="password" class="form-control input-lg" name="password" id="password" placeholder="Palavra-Passe" required>
							</div>
						</div>
					</div>
					<div class="col-md-6 form-group">
						<div class="checkbox">
							<label for="manter-sessao">
								<input type="checkbox" id="manter-sessao" value="">Manter sessão
							</label>
						</div>
					</div>
					<div class="col-md-12 form-group">
						<a class="text-blue" style="color:rgb(209, 0, 36)" href="<?php $_SERVER['PHP_SELF']; ?>?sessao=esqueceupasse">Esqueceu sua palavra-passe?</a>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-12 form-group">
								<button type="submit" name="iniciar-sessao" style="background-color:rgb(209, 0, 36); color:white;" class="btn btn-lg btn-block">Iniciar sessão</button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9 col-sm-9 col-xs-10 form-group">
								Ainda não possui uma conta Koop ?
								<a class="text-blue" style="color:rgb(209, 0, 36)" href="criarconta.php">Criar Conta</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Koop</title>
	<!-- <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">Google font -->
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" /><!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="../css/core-style.css" /><!-- Cor-style-modal -->
	<link type="text/css" rel="stylesheet" href="../css/slick.css" /> <!-- Slick -->
	<link type="text/css" rel="stylesheet" href="../css/slick-theme.css" /> <!-- Slick-theme -->
	<link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" /><!-- nouislider -->
	<link rel="stylesheet" href="../css/font-awesome.min.css"><!-- Font Awesome Icon -->
	<link type="text/css" rel="stylesheet" href="../css/style.css" /><!-- Custom stlylesheet -->
	<link href="../flag-icons/css/flag-icon.min.css" rel="stylesheet">
	<link rel="shortcut icon" href="icon-koop.png" type="image/png">
	<style>
		.menu-fixo {
			position: fixed;
			top: 0;
			z-index: 999;
			width: 100%;
		}

		.btn-link {
			color: #ccc;
			font-weight: 500;
			-webkit-transition: 0.2s color;
			transition: 0.2s color;
		}

		.btn-link:hover {
			-webkit-transition: all 500ms ease 0s;
			transition: all 500ms ease 0s;
			text-decoration: none;
			outline: none;
			color: #D10024;
			font-family: 'Open Sans', sans-serif;
			font-weight: 400;
		}
	</style>
</head>

<body>
	<header>
		<!-- HEADER -->
		<div id="top-header">
			<!-- TOP HEADER -->
			<div class="container">

				<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=home" style="position: fixed;width: 60px;height: 60px;bottom: 120px;right: 40px;background-color: #D10024;color:#FFF;border-radius: 50px;text-align: center;font-size: 30px;box-shadow: 1px 1px 2px #888;z-index:1000;"><i style="margin-top: 16px" class="fa fa-home"></i></a>
				<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho" style="position: fixed;width: 60px;height: 60px;bottom: 40px;right: 40px;background-color: #D10024;color:#FFF;border-radius: 50px;text-align: center;font-size: 30px;box-shadow: 1px 1px 2px #888;z-index:1000;"><label style="color:white; font-size:9pt;"><?php if (isset($_SESSION['carrinho'])) : echo count($_SESSION['carrinho']);
																																																																																		else : echo 0;
																																																																																		endif; ?></label><i style="margin-top: 16px" class="fa fa-shopping-cart"></i></a>

				<ul class="header-links pull-left">
					<li><a href="tel:+244932359808"><i class="fa fa-phone"></i> +244 932 561 531</a></li>
					<li><a href="#"><i class="fa fa-envelope-o"></i> koop@koopangola.com </a></li>
					<li><a href="#"><i class="fa fa-map-marker"></i> Morro Bento II</a></li>
				</ul>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<ul class="header-links pull-right">
						<?php
						if (!isset($_SESSION)) :
							session_start();
						endif;
						if (isset($_SESSION['nomecli']) || isset($_SESSION['sobrenome'])) : ?>
							<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil"><i class="fa  fa-check-circle" style="color:chartreuse"></i> <?php echo $_SESSION['nomecli'] . " " . $_SESSION['sobrenome']; ?></a></li>
							<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=perfil"><i class="fa fa-male"></i> Perfil</a></li>
							<li><a href="sair.php"><i class="fa fa-sign-out"></i> Sair</a></li>
						<?php endif; ?>
						<li><button type="submit" name="entrar" class="btn-link"><i class="fa fa-user"></i>Entrar</button></li>
						<li><a href="../views/criarconta.php"><i class="fa fa-user-plus"></i>Criar conta</a></li>
					</ul>
				</form>
			</div>
		</div><!-- /TOP HEADER -->
		<div id="header">
			<!-- MAIN HEADER -->
			<div class="container">
				<!-- container -->
				<div class="row">
					<!-- row -->
					<div class="col-md-2">
						<!-- LOGO -->
						<div class="header-logo">
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home" class="logo">
								<img src="../img/logo/koop-logo.png" alt="">
							</a>
						</div>
					</div><!-- /LOGO -->
					<div class="col-md-7 col-sm-12">
						<!-- SEARCH BAR PARA SMARTPHONE E TABLET-->
						<div class="header-search visible-xs visible-sm hidden-md hidden-lg">
							<form action="<?php $_SERVER['PHP_SELF']; ?>?sessao=prodpesquisa" method="post">
								<input type="search" name="procurar" class="input input-xs" list="produtos" placeholder="Olá! 🙂, <?php if (isset($_SESSION['nomecli']) || isset($_SESSION['sobrenome'])) : echo $_SESSION['nomecli'];
																																	endif; ?> procure aqui" style="font-size:xx-small; border-radius: 50px 0px 0px 50px;">
								<button class="search-btn" type="submit" name="btn-esquisar" style="font-size:xx-small;">Procurar</button>
							</form>
						</div>
						<datalist id="produtos">
							<?php foreach ($cp->produtoMaisvendido() as $pmv) :
								foreach ($csc->carregarSubcategorias() as $c) :
									if (file_exists("../img/" . strtolower($c['nomecategoria']) . "/" . $pmv['foto'])) : // Se foto existe na pasta is true
										$numero = (int) substr($pmv['foto'], -5); // Pegar os 5 últimos caracteres da foto ex: telefone5.png = 5.png depois converter para inteiro ex: 5.png = 5
										if ($numero == 1) : ?>
											<option value="<?php echo $pmv['nome']; ?>"><?php echo $pmv['nomecategoria']; ?></option>
							<?php endif;
									endif;
								endforeach;
							endforeach?>
						</datalist>
						<!-- SEARCH BAR PARA COMPUTADOR MÉDIO E MAIOR-->
						<div class="header-search visible-md visible-lg hidden-xs hidden-sm">
							<form action="<?php $_SERVER['PHP_SELF'] ?>?sessao=prodpesquisa" method="post">
								<input type="search" name="procurar" class="input input-xs" list="produtos" style="border-radius: 50px 0px 0px 50px;" placeholder="Olá! 🙂, <?php if (isset($_SESSION['nomecli']) || isset($_SESSION['sobrenome'])) : echo $_SESSION['nomecli'];
																																											endif; ?> procure aqui">
								<button class="search-btn" type="submit" name="btn-esquisar">Procurar</button>
							</form>
						</div>
					</div> <!-- /SEARCH BAR -->
					<div class="col-md-3 col-sm-12 clearfix">
						<i class="flag-icon flag-icon-ao h1" title="Angola" id="ao"></i>
						<!-- ACCOUNT -->
						<div class="header-ctn">
							<div class="dropdown">
								<!-- Cart -->
								<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho">
									<i class="fa fa-shopping-cart"></i>
									<span>Carrinho de compra</span>
									<div class="qty"><?php if (isset($_SESSION['carrinho'])) : echo count($_SESSION['carrinho']);
														else : echo 0;
														endif; ?></div>
								</a>
							</div> <!-- /Cart -->
							<div class="menu-toggle">
								<!-- Menu Toogle -->
								<a href="#">
									<i class="fa fa-bars"></i>
									<span>Menu</span>
								</a>
							</div>
							<!-- /Menu Toogle -->
						</div>
					</div>
					<!-- /ACCOUNT -->
				</div>
				<!-- row -->
			</div>
			<!-- container -->
		</div>
		<!-- /MAIN HEADER -->
	</header>
	<!-- /HEADER -->
	<nav id="navigation" class="menu">
		<!-- NAVIGATION -->
		<div class="container">
			<!-- container -->
			<div id="responsive-nav">
				<!-- responsive-nav -->
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<ul class="main-nav nav navbar-nav">
						<!-- NAV -->
						<li class="active"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=home">Casa</a></li>
						<li class="nav-item submenu dropdown" id="menu">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button">Loja</a>
							<ul class="dropdown-menu" style="background-color:black;">
								<li class="nav-item col-md-12">
									<a class="nav-link" id="item" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(2)) . '&ne=' . base64_encode(base64_encode("Promoção")); ?>"><i class="fa fa-th" style="color:red"></i> Produto(s) em promoção</a>
								</li>
								<?php if ($vl['estado'] == 'activado') : ?>
									<li class="nav-item col-md-12">
										<a class="nav-link" id="item" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=leilao"><i class="fa fa-legal" style="color:red"></i> Produto em leilão</a>
									</li>
								<?php endif; ?>
								<li class="nav-item col-md-12">
									<a class="nav-link" id="item" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(3)) . '&ne=' . base64_encode(base64_encode("Prestação")); ?>"><i class="fa fa-th-large" style="color:red"></i> Produto(s) em prestação</a>
								</li>
								<li class="nav-item col-md-12">
									<a class="nav-link" id="item" href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho"><i class="fa fa-shopping-cart" style="color:red"></i> Ver carrinho de compra (<span style="color:white"><?php if (isset($_SESSION['carrinho'])) : echo count($_SESSION['carrinho']);
																																																										else : echo 0;
																																																										endif; ?></span>)</a>
								</li>
							</ul>
						</li>
						<li class="nav-item submenu dropdown" id="menu">
							<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button">Categorias</a>
							<ul class="dropdown-menu" style="min-width:480px; background-color:black;">
								<ul class="nav navbar-nav">
									<?php foreach ($cc->todasCategorias(1) as $v) : ?>
										<li class="nav-item"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idc=<?php echo base64_encode(base64_encode($v['idcategoria'])) . '&ne=' . base64_encode(base64_encode($v['nomeestado'])) . '&idest=' . base64_encode(base64_encode(1)) ?>" style="margin-left:10px;"><i class="fa fa-caret-right" style="color:red"></i> <?php echo ucfirst($v['nomecategoria']); ?></a></li>
									<?php endforeach; ?>
								</ul>
							</ul>
						</li>
						<li class="visible-md visible-lg hidden-xs hidden-sm"><button type="submit" name="entrar" class="btn-link" style="margin-top: 18px">Entrar</button></li>
						<li><a href="../views/criarconta.php">Criar conta</a></li>
						<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=faleconnosco">Fale connosco</a></li>
						<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=sobrenos">Sobre nós</a></li>
						<!---->
					</ul>
				</form>
				<!-- /NAV -->
			</div>
			<!-- /responsive-nav -->
		</div>
		<!-- /container -->
	</nav>
	<!-- /NAVIGATION -->



	<?php // Array de páginas
	$arr_pag = array(
		'home' => "home.php",
		'produtoalea' => "produtoaleatorio.php",
		'finalizar' => "finalizar.php",
		'produto' => "produto.php",
		'vercarrinho' => "vercarrinho.php",
		'leilao' => "leilao.php",
		'faleconnosco' => "faleconnosco.php",
		'sobrenos' => "sobrenos.php",
		'subcategoria' => "subcategoria.php",
		'prodpesquisa' => "prodpesquisa.php",
		'termoscondicoes' => "termoscondicoes.php",
		'politicaprivacidade' => "politicaprivacidade.php",
		'perfil' => "perfil.php",
		'esqueceupasse' => "esqueceupasse.php",
	);
	if (isset($_GET['sessao'])) :
		if (array_key_exists($_GET['sessao'], $arr_pag) === true) :
			include($arr_pag[$_GET['sessao']]);
		elseif ($_GET['sessao'] === '') :
			include('home.php');
		elseif (!isset($_GET['sessao'])) :
			include('home.php');
		else :
			include('home.php');
		endif;
	else :
		include('home.php');
	endif;
	?>
	<!-- NEWSLETTER -->
	<div id="newsletter" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<div class="newsletter">
						<p>Inscreva - se no <strong>NEWSLETTER</strong></p>
						<form>
							<input class="input" type="email" placeholder="Insira o Seu Email">
							<button class="newsletter-btn"><i class="fa fa-envelope"></i> Se inscrever</button>
						</form>
						<ul class="newsletter-follow">
							<li>
								<a href="#"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-instagram"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-whatsapp"></i></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /NEWSLETTER -->

	<!-- FOOTER -->
	<footer id="footer">
		<!-- top footer -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Sobre Nós</h3>
							<p class="text-justify"><strong>Koop</strong> é um e-commerce Angolano desenvolvido pelo Koop(Empresa de tecnologia de software).</p>
							<ul class="footer-links">
								<li><a href="#"><i class="fa fa-map-marker"></i>Morro Bento II</a></li>
								<li><a href="#"><i class="fa fa-phone"></i>+244-932-561-531</a></li>
								<li><a href="#"><i class="fa fa-envelope-o"></i>koopangola@hotmail.com</a></li>
							</ul>
						</div>
					</div>

					<div class="clearfix visible-xs"></div>
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
								<h3 class="footer-title">Loja</h3>
								<ul class="footer-links">
									<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=vercarrinho">Ver Carrinho de Compra</a></li>
									<li><button type="submit" name="entrar" class="btn-link">Entrar em Minha Conta</button></li>
									<li><a href="../views/criarconta.php">Criar conta</a></li>
									<li><a href="#">Ajuda</a></li>
								</ul>
							</form>
						</div>
					</div>
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">Informação</h3>
							<ul class="footer-links">
								<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=sobrenos">Sobre Nós</a></li>
								<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=faleconnosco">Fale connosco</a></li>
								<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=politicaprivacidade">Política de Privacidade</a></li>
								<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=termoscondicoes">Termos e Condições</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3 col-xs-6">
						<div class="footer">
							<h3 class="footer-title">outros</h3>
							<ul class="footer-links">
								<!-- <li><a href="#">Sócia</a></li> -->
								<?php if ($vl['estado'] == 'activado') : ?>
									<li><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=leilao">Leilão</a></li>
								<?php endif ?>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(2)) . '&ne=' . base64_encode(base64_encode("Promoção")); ?>">Promoções</a></li>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=subcategoria&idest=<?php echo base64_encode(base64_encode(3)) . '&ne=' . base64_encode(base64_encode("Prestação")); ?>">Prestações</a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /top footer -->
		<!-- bottom footer -->
		<div id="bottom-footer" class="section">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12 text-center">
						<ul class="footer-payments">
							<!-- <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li> -->
							<li><img src="../img/logo/koop-logo.png" class="img-rounded" alt=""></li>
						</ul>
						<span class="copyright">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script> Todos os direitos reservados | Este modelo é feito <i class="fa fa-heart-o" aria-hidden="true"></i> com <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</span>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /bottom footer -->
	</footer>
	<!-- /FOOTER -->
	<!-- Include all js compiled plugins (below), or include individual files as needed -->
	<!-- jQuery Plugins -->
	<script src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/slick.min.js"></script>
	<script src="../js/nouislider.min.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script src="../js/main.js"></script>
	<script src="../js/custom.js"></script>
	<script src="../js/three.min.js"></script>

	<script>
		$('#quickview').modal('toggle'); // Chamar o modal para mostrar o detalhe do produto
		$('#view-bem-vindo').modal('toggle'); // Modal de boas vindas
		$('#modal').modal('toggle'); // Modal de login ao comentar 
		$('#modalVerificar').modal('toggle'); // Modal para verificar os dados do pedido de encomenda
		$(function() {
			var nav = $('.menu');
			$(window).scroll(function() {
				if ($(this).scrollTop() > 150) {
					nav.addClass("menu-fixo");
				} else {
					nav.removeClass("menu-fixo");
				}
			});
		});
	</script>

</body>


</html>