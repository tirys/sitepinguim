<?php
require_once '../../Builder.php';
require_once '../classes/Conexao.php';
require_once '_inc_seguranca.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	$senha 	 = (isset($_POST['senha']))   ? $_POST['senha']   : '';
	if (validaUsuario($usuario, $senha)) 
	{
		header("Location: ../config-dados-cadastrais");
	} 
	else 
	{
		expulsaVisitante();
	}
}