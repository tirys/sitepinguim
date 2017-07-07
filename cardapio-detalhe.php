<!DOCTYPE html>
<?php
require_once 'vendor/bundler.php';
$url = new UrlParser();

$conexao = new Conexao();
$link = $_GET['link_automatico'];

$seo = $conexao::fetchuniq("SELECT * FROM tb_seo WHERE tb_seo_id=2");
$url->outputMetaporTabela($seo,$data);

$prato = $conexao::fetchuniq("SELECT * FROM tb_conteudo WHERE tb_conteudo_link_automatico = '$link'");
$categoria = $conexao::fetchuniq("SELECT * FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id=".$prato['tb_conteudo_categoria']);
$titulo_pagina = $prato['tb_conteudo_titulo'];
?>
<html lang="pt-br">
	<head>
			<base href="<?=URL_INSTALACAO?>">
    	<?php include_once("inc_head.php"); ?>
	</head>
	<body class="interna">

		<?php include('inc_topo.php'); ?>

		<section class="fundo-interna">
			<h2><?=$prato['tb_conteudo_titulo']?></h2>
			<nav class="breadcrumb">
				<a href="<?=URL_INSTALACAO?>" title="Home">Home</a>
				<a href="<?=URL_INSTALACAO?>cardapio-listagem" title="Cardápio">Cardápio</a>
				<a href="<?=URL_INSTALACAO?>cardapio-listagem#<?=$categoria['tb_conteudo_categoria_url']?>"><?=$categoria['tb_conteudo_categoria_nome']?></a>
				<span><?=$prato['tb_conteudo_titulo']?></span>
			</nav>
		</section>

		<main id="cardapio">
			<section class="container">
				<div class="row branco">
					<div class="col-md-6 col-md-push-6 interna-texto">
						<h3 class="titulo-principal"><small><?=$categoria['tb_conteudo_categoria_nome']?></small><?=$prato['tb_conteudo_titulo']?></h3>
							<?=outputLongText($prato['tb_conteudo_texto_longo'])?>
					</div>
					<div class="col-md-6 col-md-pull-6">
		                <div class="slick-1item">
											<div class="slick-1item">
			 								 <?php
			 									 if($prato['tb_conteudo_video']!='' && $prato['tb_conteudo_video']!=null) {
			 										 $video = explode('?v=', $prato['tb_conteudo_video']);
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
			 												 ->iterate($conexao::fetch('SELECT s.tb_conteudo_titulo,g.* FROM tb_conteudo s, tb_galeria_foto g WHERE g.tb_galeria_foto_id_conteudo=s.tb_conteudo_id and s.tb_conteudo_id='.$prato['tb_conteudo_id']));
			 									 ?>
			 							 </div>
		                </div>
					</div>
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>
	</body>
</html>
