<?php
require_once 'vendor/bundler.php';
$url = new UrlParser();
$url->outputMeta($data);

$conexao = new Conexao();

if(@$_POST['newsletter-email'] != '' && @$_POST['newsletter-email'] != null) {
	$conexao::exec("INSERT INTO tb_newsletter VALUES (null, '{$_POST['newsletter-email']}')");
	$mensagemSucesso = '<br><br><div class="container"><p class="alert alert-success">Email cadastrado com sucesso</p></div>';
}
else {
	$mensagemSucesso = '';
}
?>
			<div id="newsletter" class="p30 bg-primaria text-center branco">
				<div class="container display-flex w100p-sm block-xs">
					<span class="fz24 iron uppercase col-md-7 col-sm-8">Saiba de todas as novidades e promoções!</span>
					<br class="visible-xs"><br class="visible-xs"><br class="visible-xs">
					<form method="post" name="form-newsletter" id="form-newsletter" class="form display-flex col-sm-4">
						<div class="floating-placeholder">
							<input id="newsletter-email" name="newsletter-email" type="text" required="" />
							<label for="newsletter-email">Digite seu email</label>
						</div>
						<button type="submit" name="submit" class="iron uppercase">ENVIAR</button>
					</form>
				</div>
					<?=$mensagemSucesso?>
			</div>
			<footer id="rodape" class="branco">
				<div class="container p80">
					<div class="row text-center-sm">
						<div class="col-md-3 col-sm-4">
							<h3 class="iron fz24 uppercase mb30">institucional</h3>
							<ul>
								<li class="mb10"><a href="<?=URL_INSTALACAO?>quem-somos" title="Quem Somos">Quem Somos</a></li>
								<li class="mb10"><a href="<?=URL_INSTALACAO?>cardapio-listagem" title="Cardápio">Cardápio</a></li>
								<li class="mb10"><a href="<?=URL_INSTALACAO?>promocoes" title="Promoções">Promoções</a></li>
								<li class="mb10"><a href="<?=$data['seja_franqueado_link']?>" target="_blank" title="Seja Franqueado">Seja Franqueado</a></li>
								<li class="mb10"><a href="<?=URL_INSTALACAO?>contato" title="Contato">Contato</a></li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-4">
							<br class="visible-xs">
							<br class="visible-xs">
							<br class="visible-xs">
							<h3 class="iron fz24 uppercase mb30">Cardápio</h3>
							<ul>
								<?php
									$categorias = $conexao::fetch("SELECT * FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id_tipo = 6");
									foreach ($categorias as $key => $categoria) {
								?>
									<li class="mb10"><a href="<?=URL_INSTALACAO?>cardapio-listagem#<?=$categoria['tb_conteudo_categoria_url']?>" title="<?=$categoria['tb_conteudo_categoria_nome']?>"><?=$categoria['tb_conteudo_categoria_nome']?></a></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-md-3 col-sm-4">
							<br class="visible-xs">
							<br class="visible-xs">
							<br class="visible-xs">
							<h3 class="iron fz24 uppercase mb30">Franqueados</h3>
							<ul>
								<li class="mb10"><a href="<?=$data['link_webmail']?>" target="_blank" title="Webmail">Webmail</a></li>
								<li class="mb10"><a href="#" target="_blank" title="Acesso Restrito">Acesso Restrito</a></li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-12">
							<br class="visible-sm visible-xs">
							<br class="visible-sm visible-xs">
							<br class="visible-sm visible-xs">
							<h3 class="iron fz24 uppercase mb30">Redes Sociais</h3>
							<a href="<?=$data['facebook']?>" target="_blank" class="fa-stack fa-lg fz30">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
							</a>
							<a href="<?=$data['instagram']?>" target="_blank" class="fa-stack fa-lg fz30">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
							</a>
							<a href="<?=$data['snapchat']?>" target="_blank" class="fa-stack fa-lg fz30">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-snapchat-ghost fa-stack-1x fa-inverse"></i>
							</a>
						</div>
					</div>
				</div>
				<div class="container-fluid text-center p30 bg-secundaria">
					<span>© Le Pinguê 2017 - Todos os direitos reservados | <a href="http://www.agenciaprospecta.com.br" title="Marketing Digital" target="_blank">Agência Prospecta</a></span>
				</div>
			</footer>
			<div class="container text-center p30">
				<span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores libero repellendus tempora. A modi sed, accusantium deleniti delectus tempore voluptatibus commodi, ex, alias corporis consequuntur numquam molestiae blanditiis qui dolore.</span>
			</div>
