<?php
	/*	
		>load.php<
		*Carrega o arquivo de configuração externo e consequentemente todas as constantes
	*/
	require_once('../Builder.php');
	$build = new Builder();
	$config = $build->getConfig();
	$require = [ 'vendor/_inc_seguranca.php', 'classes/Conexao.php', 'tools/uteis.php', 'classes/Lock.php' ];
	foreach ($require as $single_require) 
	{
		require_once $single_require;
	}
	define('URL_INSTALACAO', $config->get('site.url'));
	define('PASTA_ADMIN', $config->get('admin.name'));
	protegePagina();