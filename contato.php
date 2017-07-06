<!DOCTYPE html>
<html lang="pt-br">
	<head>
    	<?php include_once("inc_head.php"); ?>
	</head>
	<body class="interna">

		<?php include('inc_topo.php'); ?>
		
		<section class="fundo-interna">
			<h2>Contato</h2>
			<nav class="breadcrumb">
				<a href="index.php">Home</a>
				<span>Contato</span>
			</nav>
		</section>

		<main id="contato">
			<section class="container">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 interna-texto text-center">
						<h3 class="titulo-principal titulo-principal--block"><small>Preencha o formulário e</small>Envie-nos uma mensagem</h3>
						<form id="contato-form" class="form row">
							<div class="col-sm-4">
								<div class="floating-placeholder">
									<input id="nome" type="text">
									<label for="nome">Nome</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="floating-placeholder">
									<input id="email" type="text">
									<label for="email">Email</label>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="floating-placeholder">
									<input id="telefone" type="text">
									<label for="telefone">Telefone</label>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="floating-placeholder textarea">
									<textarea id="mensagem" type="text"></textarea>
									<label for="mensagem">Mensagem</label>
								</div>
							</div>
							<div class="col-sm-12">
								<button type="submit" class="botao-principal">enviar</button>
							</div>
						</form>
					</div>
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>
	</body>
</html>
