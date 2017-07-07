<!DOCTYPE html>
<?php
require_once 'vendor/bundler.php';
$url = new UrlParser();
$url->outputMeta($data);

$conexao = new Conexao();

?>
<html lang="pt-br">
	<head>
    	<?php include_once("inc_head.php"); ?>
	</head>
	<body class="interna">

		<?php include('inc_topo.php'); ?>

		<section class="fundo-interna">
			<h2>Promoções</h2>
			<nav class="breadcrumb">
				<a href="<?=URL_INSTALACAO?>" title="Home">Home</a>
				<span>Promoções</span>
			</nav>
		</section>

		<main id="promocoes">
			<section class="container">
				<div class="row lista-promo">
					<?php
					$iterator->loadBlock('promocoes_home_bloco.html')
						->addFilter('urlfyImg',array('tb_conteudo_imagem_pequena','conteudo'),'tb_conteudo_imagem_pequena')
						->iterate($conexao::fetch('SELECT tc.* FROM tb_conteudo tc WHERE tc.tb_conteudo_categoria=7'));
					 ?>
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>
	</body>
</html>
