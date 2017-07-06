<?php
require_once('../../Builder.php');
require_once('../classes/Conexao.php');
if($_POST['id'])
{
	$conexao = new Conexao();
	$id = mysqli_real_escape_string($conexao->obj(),$_POST['id']);
	//$tipo = $_POST['tipo'];
	$consulta_nome = $conexao->consulta("SELECT  `tb_caracteristicas_nome` FROM `tb_caracteristicas` WHERE `tb_caracteristicas_id` ='$id' ");
	$datta = $conexao->busca($consulta_nome); 
	if($consulta = $conexao->consulta("DELETE  FROM tb_caracteristicas WHERE tb_caracteristicas_id ='$id'"))
	{
		echo '<tr><td><div class="alert alert-success" role="alert">'.$datta['tb_caracteristicas_nome'].' Excluido com Sucesso</div></td></tr>';
	}
	else
	{
		echo '<tr><td><div class="alert alert-danger" role="alert">'.$datta['tb_caracteristicas_nome'].' Impossível de Excluir</div></td></tr>';
	}
}
?>