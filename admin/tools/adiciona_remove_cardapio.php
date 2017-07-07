<?php

require_once('../vendor/load_ext.php');

$unidade = $_POST['idUnidade'];
$item = $_POST['idItem'];
$acao = $_POST['acao'];

$conexao = new Conexao(); 
if($acao == 'true'){
	$consulta = $conexao->consulta('INSERT INTO tb_unidade_cardapio(tb_unidade_cardapio_id_unidade, tb_unidade_cardapio_id_conteudo) VALUES ('.$unidade.', '.$item.')');
}elseif($_POST['acao'] == 'false'){
	$consulta = $conexao->consulta('DELETE FROM tb_unidade_cardapio where tb_unidade_cardapio_id_unidade = '.$unidade.' and tb_unidade_cardapio_id_conteudo = '.$item.' limit 1');
}

$conexao->desconectar();

?>