<!DOCTYPE html>
<?php
require_once 'vendor/bundler.php';
$url = new UrlParser();

$conexao = new Conexao();

$tituloPage = "Quem Somos";
$quemSomos = $conexao::fetchuniq("SELECT * FROM tb_conteudo WHERE tb_conteudo_id=6");

$seo = $conexao::fetchuniq("SELECT * FROM tb_seo WHERE tb_seo_id=1");
$url->outputMetaporTabela($seo,$data);
?>
<html lang="pt-br">
	<head>
    	<?php include_once("inc_head.php"); ?>
	</head>
	<body class="interna">

		<?php include('inc_topo.php'); ?>

		<section class="fundo-interna">
			<h2><?=$quemSomos['tb_conteudo_texto_curto']?></h2>
			<nav class="breadcrumb">
				<a href="<?=URL_INSTALACAO?>" title="Home">Home</a>
				<span><?=$quemSomos['tb_conteudo_texto_curto']?></span>
			</nav>
		</section>

		<main id="quem-somos">
			<section class="container">
				<div class="row">
					<div class="col-md-6 col-md-push-6 interna-texto">
						<h3 class="titulo-principal"><small><?=$quemSomos['tb_conteudo_texto_curto']?></small>Conheça Nossa História</h3>
							<?=outputLongText($quemSomos['tb_conteudo_texto_longo'])?>
					</div>
					<div class="col-md-6 col-md-pull-6">
						<h3 class="titulo-principal"><small>Confira Nossa</small>estrutura</h3>
		                <div class="slick-1item">
											<?php
												if($quemSomos['tb_conteudo_video']!='' && $quemSomos['tb_conteudo_video']!=null) {
													$video = explode('?v=', $quemSomos['tb_conteudo_video']);
													?>
													<div>
														<div class="embed-responsive embed-responsive-16by9">
															<iframe width="560" height="315" src="https://www.youtube.com/embed/<?=$video[1]?>" frameborder="0" allowfullscreen></iframe>
														</div>
													</div>
												<?php } ?>
												<?php
						 								$iterator->loadBlock('galeria_bloco.html')
						 									->addFilter('urlfyLink',array('#','galeria',1,'tb_galeria_foto_nome'),'tb_galeria_foto_nome')
						 									->addFilter('urlfyImg',array('tb_galeria_foto_nome','galeria'),'tb_galeria_foto_nome')
						 									->iterate($conexao::fetch('SELECT s.tb_conteudo_titulo,g.* FROM tb_conteudo s, tb_galeria_foto g WHERE g.tb_galeria_foto_id_conteudo=s.tb_conteudo_id and s.tb_conteudo_id='.$quemSomos['tb_conteudo_id']));
				 								?>
		                </div>
					</div>
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>
	</body>
</html>
