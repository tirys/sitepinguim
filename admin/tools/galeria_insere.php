<?php
require_once '../../Builder.php';
require_once '../classes/Conexao.php';
if(isset($_GET['id']) && isset($_GET['src']))
{
	$filename = $_GET['src'];
	$id = $_GET['id'];
	$thumb = 'thumbnail_'.$filename;
	$conexao = new Conexao();
	$consulta = $conexao->consulta("INSERT INTO tb_galeria_foto (tb_galeria_foto_id_conteudo, tb_galeria_foto_destaque, tb_galeria_foto_nome, tb_galeria_foto_nome_thumb) VALUES('$id',NULL, '$filename','$thumb')");	
}