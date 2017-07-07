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
	<body>
		<!-- <div id="loader-wrapper">
			<div id="loader"></div>
		</div> -->

		<main class="home">

			<?php include('inc_topo.php'); ?>

			<section id="banner" class="display-flex">

				<?php $banner = $conexao::fetchuniq("SELECT * FROM tb_banner WHERE tb_banner_id=1"); ?>
				<a href="<?=$banner['tb_banner_link']?>" target="_blank" title="<?=$banner['tb_banner_nome']?>">
					<img src="<?=urlfyImg($banner['tb_banner_imagem'], 'banners')?>" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>">
					<img src="images/legenda-banner.png" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>" class="legenda-banner">
				</a>

				<?php $banner = $conexao::fetchuniq("SELECT * FROM tb_banner WHERE tb_banner_id=2"); ?>
				<a href="<?=$banner['tb_banner_link']?>" target="_blank" title="<?=$banner['tb_banner_nome']?>">
					<img src="<?=urlfyImg($banner['tb_banner_imagem'], 'banners')?>" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>">
					<img src="images/legenda-banner.png" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>" class="legenda-banner">
				</a>

				<?php $banner = $conexao::fetchuniq("SELECT * FROM tb_banner WHERE tb_banner_id=3"); ?>
				<a href="<?=$banner['tb_banner_link']?>" target="_blank" title="<?=$banner['tb_banner_nome']?>">
					<img src="<?=urlfyImg($banner['tb_banner_imagem'], 'banners')?>" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>">
					<img src="images/legenda-banner.png" alt="<?=$banner['tb_banner_nome']?>" title="<?=$banner['tb_banner_nome']?>" class="legenda-banner">
				</a>
				<a href="#promocoes" class="seta-banner" title="Role a página"><i class="ti-angle-down"></i></a>
			</section>

			<section id="promocoes" class="p120 text-center">
				<div class="container">
					<?php $promocoesTxt = $conexao::fetchuniq("SELECT tb_conteudo_texto_curto, tb_conteudo_titulo FROM tb_conteudo WHERE tb_conteudo_id=2"); ?>
					<h2 class="titulo-principal detalhe"><small><?=$promocoesTxt['tb_conteudo_texto_curto']?></small><span><?=$promocoesTxt['tb_conteudo_titulo']?></span></h2>
					<br><br>
					<!-- limita em 5 itens -->
					<div class="lista-promo clearfix">
						<?php
						$iterator->loadBlock('promocoes_home_bloco.html')
							->addFilter('urlfyImg',array('tb_conteudo_imagem_pequena','conteudo'),'tb_conteudo_imagem_pequena')
							->iterate($conexao::fetch('SELECT tc.* FROM tb_conteudo tc WHERE tc.tb_conteudo_categoria=7 LIMIT 5'));
						 ?>

					</div>
					<br><br>
					<a href="<?=URL_INSTALACAO?>promocoes" class="botao-principal">devorar todas as promoções</a>
				</div>
			</section>

			<?php $franqueadoTxt = $conexao::fetchuniq("SELECT tb_conteudo_texto_curto, tb_conteudo_titulo FROM tb_conteudo WHERE tb_conteudo_id=3"); ?>
			<section id="franqueado" class="p120 branco text-center">
				<h2 class="titulo-principal wow bounceIn"><?=$franqueadoTxt['tb_conteudo_titulo']?></h2>
				<a href="#" target="_blank" class="botao-principal wow bounceIn"><?=$franqueadoTxt['tb_conteudo_texto_curto']?></a>
			</section>

			<?php $cardapioTxt = $conexao::fetchuniq("SELECT tb_conteudo_texto_curto, tb_conteudo_titulo FROM tb_conteudo WHERE tb_conteudo_id=4"); ?>
			<section id="cardapio" class="p160 text-center branco">
				<div class="container">
					<h2 class="titulo-principal detalhe"><small><?=$cardapioTxt['tb_conteudo_titulo']?></small><span><?=$cardapioTxt['tb_conteudo_texto_curto']?></span></h2>
					<ul class="nav nav-tabs" role="tablist">
						<?php
							$categorias = $conexao::fetch("SELECT * FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id_tipo = 6");
							foreach ($categorias as $key => $categoria) {
								if($key==0)
									echo '<li role="presentation" class="active">';
								else
									echo '<li role="presentation">';
						?>
							<a href="#<?=$categoria['tb_conteudo_categoria_url']?>" aria-controls="<?=$categoria['tb_conteudo_categoria_url']?>" role="tab" data-toggle="tab" class="icon-item">
			                    <span>
			                        <img src="images/icone-<?=$categoria['tb_conteudo_categoria_url']?>.png" alt="<?=$categoria['tb_conteudo_categoria_nome']?>" title="<?=$categoria['tb_conteudo_categoria_nome']?>">
			                        <img src="images/icone-<?=$categoria['tb_conteudo_categoria_url']?>-hover.png" alt="<?=$categoria['tb_conteudo_categoria_nome']?>" title="<?=$categoria['tb_conteudo_categoria_nome']?>">
			                    </span>
			                    <span><?=$categoria['tb_conteudo_categoria_nome']?></span>
	                    	</a>
	          	</li>
						<?php } ?>

					</ul>
					<div class="tab-content row">
						<!--
							limita em 6 itens para cada tab-pane
							ou seja, serão 6 itens para cada categoria (burgers, bebidas, sobremesas)
						-->
						<?php
							foreach ($categorias as $key => $categoria) {
								if($key==0)
									echo "<div role='tabpanel' class='tab-pane fade in active' id='{$categoria['tb_conteudo_categoria_url']}'>";
								else
									echo "<div role='tabpanel' class='tab-pane fade' id='{$categoria['tb_conteudo_categoria_url']}'>";

								$iterator->loadBlock('prato_bloco.html')
									->addFilter('urlfyLink',array('cardapio-detalhe','cardapio',1,'tb_conteudo_link_automatico'),'tb_conteudo_link_automatico')
									->addFilter('urlfyImg',array('tb_conteudo_imagem_pequena','conteudo'),'tb_conteudo_imagem_pequena')
									->iterate($conexao::fetch('SELECT tc.* FROM tb_conteudo tc WHERE tc.tb_conteudo_categoria='.$categoria['tb_conteudo_categoria_id'].' LIMIT 6'));

								echo '</div>';
							}
						?>
					</div>
					<br><br>
					<a href="<?=URL_INSTALACAO?>cardapio-listagem" class="botao-principal">quero comer o cardápio completo</a>
				</div>
				<img src="images/img-cardapio-1.png" class="layer img-cardapio-1 hidden-xs" data-depth="-0.5">
				<img src="images/img-cardapio-2.png" class="layer img-cardapio-2 hidden-xs" data-depth="-0.7">
				<img src="images/img-cardapio-3.png" class="layer img-cardapio-3 hidden-xs" data-depth="0.2">
				<img src="images/img-cardapio-4.png" class="layer img-cardapio-4 hidden-xs" data-depth="-0.5">
				<img src="images/img-cardapio-5.png" class="layer img-cardapio-5 hidden-xs" data-depth="0.5">
				<img src="images/img-cardapio-6.png" class="img-cardapio-6 hidden-xs">
				<img src="images/img-cardapio-7.png" class="layer img-cardapio-7 hidden-xs" data-depth="0.2">
			</section>

			<?php $unidadesTxt = $conexao::fetchuniq("SELECT tb_conteudo_texto_curto, tb_conteudo_titulo FROM tb_conteudo WHERE tb_conteudo_id=5"); ?>
			<section id="unidades" class="p120 pb0">
				<div class="container">
					<div class="row display-flex flex-reverse block-xs">
						<div class="col-md-4 text-center">
							<h2 class="titulo-principal wow bounceIn"><small><?=$unidadesTxt['tb_conteudo_texto_curto']?></small><?=$unidadesTxt['tb_conteudo_titulo']?></h2>
							<a href="<?=URL_INSTALACAO?>unidades" class="botao-principal wow bounceIn">encontrar um pinguim</a>
						</div>
						<br class="visible-xs">
						<br class="visible-xs">
						<br class="visible-xs">
						<div class="col-md-7 col-sm-offset-0 col-xs-10 col-xs-offset-1"><img src="images/img-unidades.png" alt="Unidades Le Pingue" title="Unidades Le Pingue" class="img-centro wow slideInUp"></div>
					</div>
				</div>
			</section>

		</main>

		<?php include('inc_rodape.php'); ?>

        <script type="text/javascript" src="js/jquery.parallax.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				// Loader
				$(window).on('load', function(){
				    setTimeout(function(){
				      	$('html').addClass('loaded');
				    }, 500);
				});

				setTimeout(function(){
					shave('#cardapio .item p', 70, {character: '...'});
				}, 1000);

				$(window).scroll(function() {
					var winOffset = $(this).scrollTop() + $(this).height() * .75;
					$('.titulo-principal.detalhe, #unidades').each(function(index, el) {
						var titleOffset = $(el).offset().top;
						if(winOffset > titleOffset)
							$(el).addClass('ativo');
					});
				});

                $('#cardapio').parallax({
                    relativeInput: false,
                    clipRelativeInput: false,
                    invertX: true,
                    invertY: true,
                    limitX: 0,
                    scalarX: 10,
                    originX: -0.2,
                    originY: -0.2,
                    frictionY: .2
                });

				$('.slick-banner').slick({
					dots: false,
					arrows: true,
					infinite: true,
					loop: true,
					slidesToShow: 1,
					slidesToScroll: 1,
					swipeToSlide: true,
					fade: true,
					speed: 1000,
					autoplay: true,
					autoplaySpeed: 5000,
					pauseOnHover: false
				});
			});
		</script>
	</body>
</html>
