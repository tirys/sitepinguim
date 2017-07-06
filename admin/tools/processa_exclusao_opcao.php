<?php
require_once('includes/_inc_config_unificada.php');
if($_POST['id'])
{
	$id = mysqli_real_escape_string($conexao->obj(),$_POST['id']);
	$conexao = new classeConexao();
	$consulta_nome = $conexao->consulta("SELECT  `tb_caracteristica_opcao_valor` FROM `tb_caracteristica_opcao` WHERE `tb_caracteristica_opcao_id` ='$id' ");
	$datta = $conexao->busca($consulta_nome); 
	if($consulta = $conexao->consulta("DELETE  FROM tb_caracteristica_opcao WHERE tb_caracteristica_opcao_id ='$id'"))
	{
		echo '<div class="alert alert-success" role="alert">'.$datta['tb_caracteristica_opcao_valor'].' Excluido com Sucesso</div>';
		echo'<script>setTimeout(function(){location.reload()}, 1000);</script>';
	}
	else
	{
		echo '<div class="alert alert-danger" role="alert">'.$datta['tb_caracteristica_opcao_valor'].' Impossível de Excluir</div>';
		echo'<script>location.reload();</script>';
	}
}
?>