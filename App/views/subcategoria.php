	<?php
	include_once '../controllers/ControlCategoria.php';

	$cc = new ControlCategoria();
	$idest = base64_decode(base64_decode($_GET['idest']));
	$estado = base64_decode(base64_decode($_GET['ne']));

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
						<?php if ($idest == 1) : ?>
							<li class="active">Produtos <b><?php echo $estado ?></b></li>
						<?php else : ?>
							<li class="active">Produtos em <b><?php echo $estado ?></b></li>
						<?php endif; ?>
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
				<?php
				if ($idest == 1) : 
					$idsc = base64_decode(base64_decode($_GET['idc']));
					$funcao = 'categoriaN'; 
					foreach ($cc->$funcao($idest, $idsc) as $cat) :
				?>
					<div class="col-md-4 col-xs-6">
						<!-- shop -->
						<div class="shop">
							<div class="shop-img">
							<img src="../img/capa-subcategoria/<?php echo $cat['imgcapa']; ?>" alt="">
							</div>
							<center>
								<div style="margin-top: 65px;" class="shop-body">
									<?php
									if ($idest == 1) : ?>
										<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($cat['idcategoria'])) . '&ne=' . base64_encode(base64_encode($cat['nomeestado'])) . '&idest=' . base64_encode(base64_encode($cat['idestado'])) . '&idsc=' . base64_encode(base64_encode($cat['subcategoria'])); ?>" class="cta-btn"><?php echo $cat['nomecategoria']; ?><i class="fa fa-arrow-circle-right"></i></a>
									<?php else : ?>
										<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($cat['idcategoria'])) . '&ne=' . base64_encode(base64_encode($cat['nomeestado'])) . '&idest=' . base64_encode(base64_encode($cat['idestado'])) . '&idsc=' . base64_encode(base64_encode($cat['subcategoria'])) . '&idcat='; ?>" class="cta-btn"><?php echo $cat['nomecategoria']; ?><i class="fa fa-arrow-circle-right"></i></a>
									<?php endif;
									?>
								</div>
							</center>
						</div>
						<!-- /shop -->
					</div>
				<?php endforeach ?>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION --><?php 
				else :
					$funcao = 'categoriaPP';
					foreach ($cc->$funcao($idest,$estado) as $cat) :
				?>
					<div class="col-md-4 col-xs-6">
						<!-- shop -->
						<div class="shop">
							<div class="shop-img">
							<img src="../img/capa-subcategoria/<?php echo $cat['imgcapa']; ?>" alt="">
							</div>
							<center>
								<div style="margin-top: 65px;" class="shop-body">
									<?php
									if ($idest == 1) : ?>
										<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($cat['idcategoria'])) . '&ne=' . base64_encode(base64_encode($cat['nomeestado'])) . '&idest=' . base64_encode(base64_encode($cat['idestado'])) . '&idsc=' . base64_encode(base64_encode($cat['subcategoria'])); ?>" class="cta-btn"><?php echo $cat['nomecategoria']; ?><i class="fa fa-arrow-circle-right"></i></a>
									<?php else : ?>
										<a href="<?php echo $_SERVER['PHP_SELF']; ?>?sessao=produtoalea&idc=<?php echo base64_encode(base64_encode($cat['idcategoria'])) . '&ne=' . base64_encode(base64_encode($cat['nomeestado'])) . '&idest=' . base64_encode(base64_encode($cat['idestado'])) . '&idsc=' . base64_encode(base64_encode($cat['subcategoria'])) . '&idcat='; ?>" class="cta-btn"><?php echo $cat['nomecategoria']; ?><i class="fa fa-arrow-circle-right"></i></a>
									<?php endif;
									?>
								</div>
							</center>
						</div>
						<!-- /shop -->
					</div>
				<?php endforeach ?>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->
				<?php endif;
			?>