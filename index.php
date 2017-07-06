<!DOCTYPE html>
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
				<a href="#" target="_blank" title="Título Banner">
					<img src="images/banner1.jpg" alt="Título Banner" title="Título Banner">
					<img src="images/legenda-banner.png" alt="Título Banner" title="Título Banner" class="legenda-banner">
				</a>
				<a href="#" target="_blank" title="Título Banner">
					<img src="images/banner2.jpg" alt="Título Banner" title="Título Banner">
					<img src="images/legenda-banner.png" alt="Título Banner" title="Título Banner" class="legenda-banner">
				</a>
				<a href="#" target="_blank" title="Título Banner">
					<img src="images/banner3.jpg" alt="Título Banner" title="Título Banner">
					<img src="images/legenda-banner.png" alt="Título Banner" title="Título Banner" class="legenda-banner">
				</a>
				<a href="#promocoes" class="seta-banner" title="Role a página"><i class="ti-angle-down"></i></a>
			</section>
			
			<section id="promocoes" class="p120 text-center">
				<div class="container">
					<h2 class="titulo-principal detalhe"><small>Saboreie nossas melhores</small><span>promoções</span></h2>
					<br><br>
					<!-- limita em 5 itens -->
					<div class="lista-promo clearfix">
						<a href="#" target="_blank" title="Promoção">
							<img src="images/promocao.jpg" alt="Promoção" title="Promoção" class="img-centro">
						</a>
						<a href="#" target="_blank" title="Promoção">
							<img src="images/promocao.jpg" alt="Promoção" title="Promoção" class="img-centro">
						</a>
						<a href="#" target="_blank" title="Promoção">
							<img src="images/promocao.jpg" alt="Promoção" title="Promoção" class="img-centro">
						</a>
						<a href="#" target="_blank" title="Promoção">
							<img src="images/promocao.jpg" alt="Promoção" title="Promoção" class="img-centro">
						</a>
						<a href="#" target="_blank" title="Promoção">
							<img src="images/promocao.jpg" alt="Promoção" title="Promoção" class="img-centro">
						</a>
					</div>
					<br><br>
					<a href="promocoes.php" class="botao-principal">devorar todas as promoções</a>
				</div>
			</section>

			<section id="franqueado" class="p120 branco text-center">
				<h2 class="titulo-principal wow bounceIn">a melhor hamburgueria do brasil</h2>
				<a href="#" target="_blank" class="botao-principal wow bounceIn">quero uma pra mim</a>
			</section>
	
			<section id="cardapio" class="p160 text-center branco">
				<div class="container">
					<h2 class="titulo-principal detalhe"><small>Aprecie sem moderação nosso</small><span>cardápio</span></h2>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#burgers" aria-controls="burgers" role="tab" data-toggle="tab" class="icon-item">
			                    <span>
			                        <img src="images/icone-burgers.png" alt="Burgers" title="Burgers">
			                        <img src="images/icone-burgers-hover.png" alt="Burgers" title="Burgers">
			                    </span>
			                    <span>Burgers</span>
	                    	</a>
                    	</li>
						<li role="presentation">
							<a href="#bebidas" aria-controls="bebidas" role="tab" data-toggle="tab" class="icon-item">
			                    <span>
			                        <img src="images/icone-bebidas.png" alt="Bebidas" title="Bebidas">
			                        <img src="images/icone-bebidas-hover.png" alt="Bebidas" title="Bebidas">
			                    </span>
			                    <span>Bebidas</span>
	                    	</a>
	                    </li>
						<li role="presentation">
							<a href="#sobremesas" aria-controls="sobremesas" role="tab" data-toggle="tab" class="icon-item">
			                    <span>
			                        <img src="images/icone-sobremesas.png" alt="Sobremesas" title="Sobremesas">
			                        <img src="images/icone-sobremesas-hover.png" alt="Sobremesas" title="Sobremesas">
			                    </span>
			                    <span>Sobremesas</span>
	                    	</a>
	                    </li>
					</ul>
					<div class="tab-content row">
						<!--
							limita em 6 itens para cada tab-pane
							ou seja, serão 6 itens para cada categoria (burgers, bebidas, sobremesas)
						-->
						<div role="tabpanel" class="tab-pane flex-list fade in active" id="burgers">
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane flex-list fade" id="bebidas">
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane flex-list fade" id="sobremesas">
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
							<div class="col-md-4 col-sm-6">
								<a href="cardapio-detalhe.php" class="item" title="Salmão">
									<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
									<span class="display-flex flex-column">
										<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
										<p>Inspirado na culinária brasileira, o Tuba possui pão de mandioca...</p>
									</span>
								</a>
							</div>
						</div>
					</div>
					<br><br>
					<a href="cardapio-listagem.php" class="botao-principal">quero comer o cardápio completo</a>
				</div>
				<img src="images/img-cardapio-1.png" class="layer img-cardapio-1 hidden-xs" data-depth="-0.5">
				<img src="images/img-cardapio-2.png" class="layer img-cardapio-2 hidden-xs" data-depth="-0.7">
				<img src="images/img-cardapio-3.png" class="layer img-cardapio-3 hidden-xs" data-depth="0.2">
				<img src="images/img-cardapio-4.png" class="layer img-cardapio-4 hidden-xs" data-depth="-0.5">
				<img src="images/img-cardapio-5.png" class="layer img-cardapio-5 hidden-xs" data-depth="0.5">
				<img src="images/img-cardapio-6.png" class="img-cardapio-6 hidden-xs">
				<img src="images/img-cardapio-7.png" class="layer img-cardapio-7 hidden-xs" data-depth="0.2">
			</section>

			<section id="unidades" class="p120 pb0">
				<div class="container">
					<div class="row display-flex flex-reverse block-xs">
						<div class="col-md-4 text-center">
							<h2 class="titulo-principal wow bounceIn"><small>Encontre a melhor hamburgueria do brasil mais próxima de você</small>unidades</h2>
							<a href="unidades.php" class="botao-principal wow bounceIn">encontrar um pinguim</a>
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
