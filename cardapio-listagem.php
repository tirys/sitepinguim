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
	<body class="interna listagem">

		<?php include('inc_topo.php'); ?>

		<section class="fundo-interna">
			<h2>Cardápio</h2>
			<nav class="breadcrumb">
				<a href="<?=URL_INSTALACAO?>" title="Home">Home</a>
				<span>Cardápio</span>
			</nav>
		</section>

		<main id="cardapio">
			<section class="container">
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
				<br><br>
				<div class="tab-content row">
					<?php
						foreach ($categorias as $key => $categoria) {
							if($key==0)
								echo "<div role='tabpanel' class='tab-pane fade in active' id='{$categoria['tb_conteudo_categoria_url']}'>";
							else
								echo "<div role='tabpanel' class='tab-pane fade' id='{$categoria['tb_conteudo_categoria_url']}'>";

							$iterator->loadBlock('prato_bloco.html')
								->addFilter('urlfyLink',array('cardapio-detalhe','cardapio',1,'tb_conteudo_link_automatico'),'tb_conteudo_link_automatico')
								->addFilter('urlfyImg',array('tb_conteudo_imagem_pequena','conteudo'),'tb_conteudo_imagem_pequena')
								->iterate($conexao::fetch('SELECT tc.* FROM tb_conteudo tc WHERE tc.tb_conteudo_categoria='.$categoria['tb_conteudo_categoria_id']));

							echo '</div>';
						}
					?>
					<!-- <div role="tabpanel" class="tab-pane fade in active" id="burgers">
						<div class="col-md-4 col-sm-6">
							<a href="cardapio-detalhe.php" class="item" title="Salmão">
								<img src="images/cardapio.jpg" alt="Salmão" title="Salmão" class="img-centro">
								<span class="display-flex flex-column">
									<strong class="fz18 mb5 display-block uppercase">Salmão</strong>
									<p>Inspirado na culinária brasileira, o Tuba possui pão de mandiocaInspirado na culinária brasileira, o Tuba possui pão de mandioca</p>
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
					<div role="tabpanel" class="tab-pane fade" id="bebidas">
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
					<div role="tabpanel" class="tab-pane fade" id="sobremesas">
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
					</div> -->
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				setTimeout(function(){
					shave('#cardapio .item p', 70, {character: '...'});
				}, 1000);

				$('.nav-tabs').sticky({topSpacing: $('#topo').outerHeight()});

				function getHashFilter() {
				    var hash = location.hash;
				    // get filter=filterName
				    var matches = location.hash.match(/#([^&]+)/i);
				    var hashFilter = matches && matches[1];
				    return hashFilter && decodeURIComponent(hashFilter);
				}

			  	// bind filter button click
				$('.nav-tabs a').click(function (e) {
					// animate to proper tabs start
			        $('html,body').animate({
			          scrollTop: $('main #sticky-wrapper').offset().top - $("#topo").outerHeight() //ALTURA DO TOPO
			        }, 1000, 'easeInOutExpo');

				    // set filter in hash
			    	var filterAttr = $(this).attr('aria-controls');
				    location.hash = '#' + encodeURIComponent(filterAttr);
				});

			  	function onHashchange() {
				    var hashFilter = getHashFilter();
				    var events = [];
			    	$('.nav-tabs a').each(function() {
			    		events.push($(this).attr('aria-controls'));
			    	});
				    // set selected class on button
				    if ($.inArray(hashFilter, events) > -1) {
				      $('.nav-tabs').find('[aria-controls="' + hashFilter + '"]').tab('show');
				    }
			  	}

			  	$(window).on('hashchange', onHashchange);
			  	// trigger event handler to init tabs
			  	onHashchange();
			});
		</script>
	</body>
</html>
