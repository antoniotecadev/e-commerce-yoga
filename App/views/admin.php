<?php
include_once '../controllers/ControlProduto.php';
include_once '../controllers/ControlCliente.php';

// Função para chamar o modal que mostra os clientes
function mostarCliente()
{
	$cp = new ControlProduto();
	$cl = new ControlCliente();

?>
	<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
						<span aria-hidden="true">&times;</span>
					</button>
					<a class="hvr-bubble-float-center"><h1 style="margin-left: 220px; color: rgb(154, 0, 2)"><strong>Clientes Cadastrados </strong><i class="fa fa-users"></i></h1></a>
				</div>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<div class="row">
						<div class="col-lg-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<table width="105%" class="table table-striped table-bordered table-hover" id="dataTables-example">
										<thead>
											<tr style="font-size: 15px; text-align: center">
												<th>Mais</th>
												<th>Nome <img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Sobrenome <img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Sexo<img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Telefone<img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Bairro<img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Rua<img src="../img/tabela/sort_both.png" alt=""></th>
												<th>E-mail<img src="../img/tabela/sort_both.png" alt=""></th>
												<th>Data de Nascimento<img src="../img/tabela/sort_both.png" alt=""></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($cl->buscarCliente() as $cliente) :  ?>
												<tr class="odd gradeX">
													<td></td>
													<td> <?php echo $cliente['nome']; ?></td>
													<td> <?php echo $cliente['sobrenome']; ?></td>
													<td> <?php echo $cliente['sexo']; ?></td>
													<td> <?php echo $cliente['telefone1']; ?></td>
													<td> <?php echo $cliente['bairro']; ?></td>
													<td> <?php echo $cliente['rua']; ?></td>
													<td> <?php echo $cliente['email']; ?></td>
													<td> <?php echo $cliente['datanascimento']; ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
								<!-- /.panel-body -->
							</div>
							<!-- /.panel -->
						</div>
						<!-- /.col-lg-12 -->
					</div>
					<!-- /.row -->
				</form>
			</div>
		</div>
	</div>
<?php } ?>
<?php
if (!isset($_SESSION)) :
	session_start();
endif;
if (!$_SESSION['nome'] || !$_SESSION['nivel']) :
	header("location: entrar.php");
else :
	$nome = $_SESSION['nome'];
	$nivel = $_SESSION['nivel'];
	$foto = $_SESSION['foto'];
endif;
include_once '../controllers/ControlEncomenda.php';
$ce = new ControlEncomenda();

if (isset($_GET['modalCliente'])) {
	// echo '<script>alert()</script>';
	mostarCliente();
}

?>
<!DOCTYPE HTML>
<html lang="pt-br">

<head>
	<title>Koop Admin</title>
	<link rel="shortcut icon" href="icon-koop.png" type="image/png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<script type="text/javascript">
								function Actualizar(){
									window.location.reload();
								}
							</script>
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
	<link href="../css/estilo.css" rel="stylesheet" type="text/css" media="all" /><!-- Custom Theme files -->
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/dataTables.bootstrap.css" rel="stylesheet"><!-- DataTables CSS -->
	<link href="../css/dataTables.responsive.css" rel="stylesheet"><!-- DataTables Responsive CSS -->
	<link href="../css/hover.css" rel="stylesheet"><!-- DataTables Responsive CSS -->
	<script src="../js/jquery.min.js"></script>
	<!--js-->
	<script src="../js/Chart.min.js"></script>
	<!--static chart-->
	<script src="//cdn.jsdelivr.net/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script><!-- geo chart -->
	<script>
		window.modernizr || document.write('<script src="lib/modernizr/modernizr-custom.js"><\/script>')
	</script>
	<script src="../js/chartinator.js"></script> <!-- Chartinator  -->
	<!--skycons-icons-->
	<script src="../js/skycons.js"></script>
	<!--//skycons-icons-->
</head>

<body onload="setInterval('Actualizar()', <?php echo $tempo;?>)">
	<div class="page-container">
		<div class="left-content">
			<div class="mother-grid-inner">
				<!--header start here-->
				<div class="header-main">
					<div class="header-left">
						<div class="logo-name">
							<a href="<?php echo $_SERVER['PHP_SELF']; ?>">
								<h1>Koop Admin</h1>
								<!--<img id="logo" src="" alt="Logo"/>-->
							</a>
						</div>
						<!--search-box-->
						<!--//end-search-box-->
						<div class="clearfix"> </div>
					</div>
					<div class="header-right">
						<div class="profile_details_left">
							<!--notifications of menu start -->
							<ul class="nofitications-dropdown">
								<li class="dropdown head-dpdn">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-envelope"></i><span class="badge">3</span></a>
									<ul class="dropdown-menu">
										<li>
											<div class="notification_header">
												<h3>You have 3 new messages</h3>
											</div>
										</li>

										<li><a href="#">
												<div class="user_img"><img src="images/p4.png" alt=""></div>
												<div class="notification_desc">
													<p>Lorem ipsum dolor</p>
													<p><span>1 hour ago</span></p>
												</div>
												<div class="clearfix"></div>
											</a></li>

										<div class="notification_bottom">
											<a href="#">See all messages</a>
										</div>
								</li>
							</ul>
							</li>
							<?php $contar = 0;
							$pendente = 0;
							$visualizada = 0;
							$nula = 0;
							$concluida = 0;
							foreach ($ce->notificacaoEncomenda() as $d) :
								if ($d['visibilidade'] == 0) :
									$contar += 1;
								endif;
								if ($d['visibilidade'] == 1) :
									$visualizada += 1;
								endif;
								if ($d['visibilidade'] == 2) :
									$pendente += 1;
								endif;
								if ($d['visibilidade'] == 3) :
									$nula += 1;
								endif;
								if ($d['visibilidade'] == 4) :
									$concluida += 1;
								endif;
							endforeach; ?>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell"></i><span class="badge blue"><?php echo $contar; ?></span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3><?php echo $contar; ?> encomenda(s) nova(s)</h3>
										</div>
										<div class="notification_bottom">
											<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=0&titulo=NOVA ENCOMENDA">Ver todas encomendas</a>
										</div>
									</li>
									<?php foreach ($ce->notificacaoEncomenda() as $dados) :
										if ($dados['visibilidade'] == 0) : ?>
											<li style="background-color:powderblue; margin-top:2px;"><a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=dadosencomenda<?php echo '&del=' . $dados['detalhe'] . '&data=' . $dados['dataencomenda'] . '&nome=' . $dados['nome'] . '&sobrenome=' . $dados['sobrenome'] . '&sexo=' . $dados['sexo'] . '&tel1=' . $dados['telefone1'] . '&email=' . $dados['email'] . '&bairro=' . $dados['bairro'] . '&rua=' . $dados['rua'] . '&icclt=' . base64_encode(base64_encode($dados['id'])) . '&anulada=' . '&view=' . '&titulo=NOVA ENCOMENDA' . '&usr=' . base64_encode(base64_encode($dados['fkusuario'])); ?>">
													<div class="user_img"><img src="../img/logo/koop-logo.png" alt=""></div>
													<div class="notification_desc">
														<p><?php echo $dados['nome'] . ' ' . $dados['sobrenome']; ?></p>
														<p><span><?php echo $dados['dataencomenda']; ?></span></p>
													</div>
													<div class="clearfix"></div>
												</a></li>
									<?php endif;
									endforeach; ?>
									<div class="notification_bottom">
										<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=0&titulo=NOVA ENCOMENDA">Ver todas encomendas</a>
									</div>
							</li>
							</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-meh-o"></i><span class="badge blue"><?php echo $visualizada; ?></span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3><?php echo $visualizada; ?> encomenda(s) visualizada(s)</h3>
										</div>
										<div class="notification_bottom">
											<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=1&titulo=ENCOMENDA VISUALIZADA">Ver todas encomendas</a>
										</div>
									</li>
									<?php foreach ($ce->notificacaoEncomenda() as $dados) :
										if ($dados['visibilidade'] == 1) : ?>
											<li style="background-color:aquamarine; margin-top:2px;"><a href="<?php $_SERVER['PHP_SELF'] ?>?sessao=dadosencomenda<?php echo '&del=' . $dados['detalhe'] . '&data=' . $dados['dataencomenda'] . '&nome=' . $dados['nome'] . '&sobrenome=' . $dados['sobrenome'] . '&sexo=' . $dados['sexo'] . '&tel1=' . $dados['telefone1'] . '&email=' . $dados['email'] . '&bairro=' . $dados['bairro'] . '&rua=' . $dados['rua'] . '&icclt=' . base64_encode(base64_encode($dados['id'])) . '&titulo=ENCOMENDA VISUALIZADA' . '&usr=' . base64_encode(base64_encode($dados['fkusuario'])); ?>">
													<div class="user_img"><img src="../img/logo/koop-logo.png" alt=""></div>
													<div class="notification_desc">
														<p><?php echo 'koop' . $dados['fkusuario'] . '20'; ?></p>
														<p><?php echo $dados['nome'] . ' ' . $dados['sobrenome']; ?></p>
														<p><span><?php echo $dados['dataencomenda']; ?></span></p>
													</div>
													<div class="clearfix"></div>
												</a></li>
									<?php endif;
									endforeach; ?>
									<div class="notification_bottom">
										<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=1&titulo=ENCOMENDA VISUALIZADA">Ver todas encomendas</a>
									</div>
							</li>
							</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bookmark"></i><span class="badge orange"><?php echo $pendente; ?></span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3><?php echo $pendente; ?> encomenda(s) pendente(s)</h3>
										</div>
										<div class="notification_bottom">
											<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=2&titulo=ENCOMENDA PENDENTE">Ver todas encomendas</a>
										</div>
									</li>
									<?php foreach ($ce->notificacaoEncomenda() as $dados) :
										if ($dados['visibilidade'] == 2) : ?>
											<li style="background-color:lightgoldenrodyellow; margin-top:2px;"><a href="<?php $_SERVER['PHP_SELF'] ?>?sessao=dadosencomenda<?php echo '&del=' . $dados['detalhe'] . '&data=' . $dados['dataencomenda'] . '&nome=' . $dados['nome'] . '&sobrenome=' . $dados['sobrenome'] . '&sexo=' . $dados['sexo'] . '&tel1=' . $dados['telefone1'] . '&email=' . $dados['email'] . '&bairro=' . $dados['bairro'] . '&rua=' . $dados['rua'] . '&icclt=' . base64_encode(base64_encode($dados['id'])) . '&pendente=' . '&titulo=ENCOMENDA PENDENTE' . '&usr=' . base64_encode(base64_encode($dados['fkusuario'])); ?>">
													<div class="user_img"><img src="../img/logo/koop-logo.png" alt=""></div>
													<div class="notification_desc">
														<p><?php echo 'koop' . $dados['fkusuario'] . '20'; ?></p>
														<p><?php echo $dados['nome'] . ' ' . $dados['sobrenome']; ?></p>
														<p><span><?php echo $dados['dataencomenda']; ?></span></p>
													</div>
													<div class="clearfix"></div>
												</a></li>
									<?php endif;
									endforeach; ?>
									<div class="notification_bottom">
										<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=2&titulo=ENCOMENDA PENDENTE">Ver todas encomendas</a>
									</div>
							</li>
							</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-frown-o"></i><span class="badge red"><?php echo $nula; ?></span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3><?php echo $nula; ?> encomenda(s) anulada(s)</h3>
										</div>
										<div class="notification_bottom">
											<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=3&titulo=ENCOMENDA ANULADA">Ver todas encomendas</a>
										</div>
									</li>
									<?php foreach ($ce->notificacaoEncomenda() as $dados) :
										if ($dados['visibilidade'] == 3) : ?>
											<li style="background-color:bisque; margin-top:2px;"><a href="<?php $_SERVER['PHP_SELF'] ?>?sessao=dadosencomenda<?php echo '&del=' . $dados['detalhe'] . '&data=' . $dados['dataencomenda'] . '&nome=' . $dados['nome'] . '&sobrenome=' . $dados['sobrenome'] . '&sexo=' . $dados['sexo'] . '&tel1=' . $dados['telefone1'] . '&email=' . $dados['email'] . '&bairro=' . $dados['bairro'] . '&rua=' . $dados['rua'] . '&icclt=' . base64_encode(base64_encode($dados['id'])) . '&anulada=' . '&titulo=ENCOMENDA ANULADA' . '&usr=' . base64_encode(base64_encode($dados['fkusuario'])) . '&info=' . $dados['porqueanulada']; ?>">
													<div class="user_img"><img src="../img/logo/koop-logo.png" alt=""></div>
													<div class="notification_desc">
														<p><?php echo 'koop' . $dados['fkusuario'] . '20'; ?></p>
														<p><?php echo $dados['nome'] . ' ' . $dados['sobrenome']; ?></p>
														<p><span><?php echo $dados['dataencomenda']; ?></span></p>
													</div>
													<div class="clearfix"></div>
												</a></li>
									<?php endif;
									endforeach; ?>
									<div class="notification_bottom">
										<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=3&titulo=ENCOMENDA ANULADA">Ver todas encomendas</a>
									</div>
							</li>
							</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-smile-o"></i><span style="color:black;" class="badge blue1"><?php echo $concluida; ?></span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3><?php echo $concluida; ?> encomenda(s) concluída(s)</h3>
										</div>
									</li>
									<div class="notification_bottom">
										<a href="<?php $_SERVER['PHP_SELF']; ?>?sessao=encomendadados&vs=4&titulo=ENCOMENDA CONCLUÍDA">Ver todas encomendas</a>
									</div>
							</li>
							</ul>
							</li>
							<li class="dropdown head-dpdn">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-tasks"></i><span class="badge blue1">9</span></a>
								<ul class="dropdown-menu">
									<li>
										<div class="notification_header">
											<h3>You have 8 pending task</h3>
										</div>
									</li>
									<li><a href="#">
											<div class="task-info">
												<span class="task-desc">Database update</span><span class="percentage">40%</span>
												<div class="clearfix"></div>
											</div>
											<div class="progress progress-striped active">
												<div class="bar yellow" style="width:40%;"></div>
											</div>
										</a></li>
									<li><a href="#">
											<div class="task-info">
												<span class="task-desc">Dashboard done</span><span class="percentage">90%</span>
												<div class="clearfix"></div>
											</div>
											<div class="progress progress-striped active">
												<div class="bar green" style="width:90%;"></div>
											</div>
										</a></li>
									<li><a href="#">
											<div class="task-info">
												<span class="task-desc">Mobile App</span><span class="percentage">33%</span>
												<div class="clearfix"></div>
											</div>
											<div class="progress progress-striped active">
												<div class="bar red" style="width: 33%;"></div>
											</div>
										</a></li>
									<li><a href="#">
											<div class="task-info">
												<span class="task-desc">Issues fixed</span><span class="percentage">80%</span>
												<div class="clearfix"></div>
											</div>
											<div class="progress progress-striped active">
												<div class="bar  blue" style="width: 80%;"></div>
											</div>
										</a></li>
									<li>
										<div class="notification_bottom">
											<a href="#">See all pending tasks</a>
										</div>
									</li>
								</ul>
							</li>
							</ul>
							<div class="clearfix"> </div>
						</div>
						<!--notification menu end -->
						<div class="profile_details">
							<ul>
								<li class="dropdown profile_details_drop">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<div class="profile_img">
											<span class="prfil-img"><img src="../img/usuario/<?php echo $foto; ?>" class="img-circle" alt=""></span>
											<div class="user-name">
												<p><?php echo $nome ?></p>
												<span><?php echo $nivel ?></span>
											</div>
											<i class="fa fa-angle-down lnr"></i>
											<i class="fa fa-angle-up lnr"></i>
											<div class="clearfix"></div>
										</div>
									</a>
									<ul class="dropdown-menu drp-mnu">
										<li> <a href="#"><i class="fa fa-cog"></i> Configurações</a> </li>
										<li> <a href="#"><i class="fa fa-user"></i> Perfil</a> </li>
										<li> <a href="./sair.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="clearfix"> </div>
				</div>
				<!--heder end here-->
				<!-- script-for sticky-nav -->
				<script>
					$(document).ready(function() {
						var navoffeset = $(".header-main").offset().top;
						$(window).scroll(function() {
							var scrollpos = $(window).scrollTop();
							if (scrollpos >= navoffeset) {
								$(".header-main").addClass("fixed");
							} else {
								$(".header-main").removeClass("fixed");
							}
						});

					});
				</script>
				<!-- /script-for sticky-nav -->
				<?php // Array de páginas

				$arr_pag = array(
					'inicialadmin' => "inicialadmin.php",
					'usuario' => "usuario.php",
					'cadastrarusuario' => "cadastrarusuario.php",
					'cadastrarprod' => "cadastrarprod.php",
					'cadfotoslider' => "cadfotoslider.php",
					'actfotoslider' => "actfotoslider.php",
					'actprodleilao' => "actprodleilao.php",
					'dadosencomenda' => "dadosencomenda.php",
					'prodadmin' => "prodadmin.php",
					'prodActualizar' => "prodActualizar.php",
					'encomendadados' => "encomendadados.php",
					'verleilao' => "verleilao.php",
					'sliders' => "sliders.php",
					'teste' => "testeaustin.php",
				);
				if (isset($_GET['sessao'])) :
					if (array_key_exists($_GET['sessao'], $arr_pag) === true) :
						include($arr_pag[$_GET['sessao']]);
					elseif ($_GET['sessao'] === '') :
						include('inicialadmin.php');
					elseif (!isset($_GET['sessao'])) :
						include('inicialadmin.php');
					else :
						include('inicialadmin.php');
					endif;
				else :
					include('inicialadmin.php');
				endif;
				?>
				<!--copy rights start here-->
				<div class="copyrights">
					<p>© 2016 Shoppy. All Rights Reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
				</div>
				<!--COPY rights end here-->
			</div>
		</div>
		<!--slider menu-->
		<div class="sidebar-menu">
			<div class="logo"> <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="#"> <span id="logo"></span>
					<!--<img id="logo" src="" alt="Logo"/>-->
				</a> </div>
			<div class="menu">
				<ul id="menu">
					<li id="menu-home"><a href="<?php echo $_SERVER['PHP_SELF']; ?>"><i class="fa fa-home"></i><span>Inicial</span></a></li>
					<?php if ($nivel == "Administrador" || $nivel == "administrador") : ?>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=usuario"><i class="fa fa-user"></i><span>Usuários</span></a></li>
						<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?&modalCliente"><i class="fa fa-users"></i><span>Clientes</span></a></li>
						<li id="menu-comunicacao"><a href="#"><i class="fa fa-product-hunt"></i><span>Produtos</span></span></a>
							<ul id="menu-comunicacao-sub">
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadastrarprod">Cadastrar Produto</a></li>
								<li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=prodadmin">Listar Produtos</a></li>
							</ul>
						</li>
						<li id="menu-academico"><a href="#"><i class="fa fa-gavel"></i><span>Leilão</span></a>
							<ul id="menu-academico-sub">
								<li id="menu-academico-boletim"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=actprodleilao">Actualizar produdo</a></li>
								<li id="menu-academico-boletim"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=verleilao">Ver leilão</a></li>
							</ul>
						</li>
						<li id="menu-academico"><a href="#"><i class="fa fa-sliders"></i><span>Sliders</span></a>
							<ul id="menu-academico-sub">
								<li id="menu-academico-boletim"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=cadfotoslider">Cadastrar imagem</a></li>
								<li id="menu-academico-boletim"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=sliders">Listar imagens</a></li>
							</ul>
						</li>
					<?php endif; ?>
					<li><a target="_blank" href="index.php"><i class="fa fa-shopping-cart"></i><span>Koop</span></a></li>
				</ul>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
	<!--slide bar menu end here-->
	<script>
		var toggle = true;

		$(".sidebar-icon").click(function() {
			if (toggle) {
				$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
				$("#menu span").css({
					"position": "absolute"
				});
			} else {
				$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
				setTimeout(function() {
					$("#menu span").css({
						"position": "relative"
					});
				}, 400);
			}
			toggle = !toggle;
		});
	</script>
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<script src="../js/bootstrap.min.js"> </script>
	<!-- DataTables JavaScript -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script src="../js/dataTables.bootstrap.min.js"></script>
	<script src="../js/dataTables.responsive.js"></script>
	<script>
		$('#modal').modal('toggle');
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				responsive: true
			});
		});
	</script>
	<!-- mother grid end here-->
</body>

</html>