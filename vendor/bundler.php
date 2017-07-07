<?php
	require 'Builder.php';
	$builder = new Builder();
	$config = $builder->getConfig();
	define('URL_INSTALACAO', $config->get('site.url'));
	define('ADMIN_PATH', $config->get('admin.path'));
	define('ADMIN_URL', $config->get('admin.url'));
	function autoload_classes($class_name)
	{
		$builder = new Builder();
		$config = $builder->getConfig();
		$path = $config->get('admin.path');
	    $file = $_SERVER['DOCUMENT_ROOT'].$path.'classes/' . $class_name. '.php';
	    if (file_exists($file))
	    {
	        require_once($file);
	    }
	}
	spl_autoload_register('autoload_classes');
	include_once $_SERVER['DOCUMENT_ROOT'].ADMIN_PATH.'tools/uteis.php';
	$data = DadosCadastrais::serialize(Conexao::fetch("SELECT * FROM tb_config_cadastral"));
	$iterator = new Itr('templates/partials/');
?>
