<?php
  session_start();
  include('simpleImage.php');
  include('../../conexao/classeconexao.php');
  include('../../funcoes/func_uteis.php');
 

	//RESGATANDO DADOS DA CATEGORIA
	$conexao = new classeConexao(); 
	$consulta = $conexao->consulta('SELECT tb_conteudo.*, tb_conteudo_categoria.* from tb_conteudo left join tb_conteudo_categoria on tb_conteudo_categoria.tb_conteudo_categoria_id=tb_conteudo.tb_conteudo_categoria where tb_conteudo.tb_conteudo_id = "'.$_GET['id'].'"');
	$DadosConteudo = $conexao->busca($consulta);
	$conexao->desconectar();




    $username = ConverteURLimagem($DadosConteudo['tb_conteudo_link_automatico']);
    $original = ConverteURLimagem($username.'_'.$_FILES['pPic']['name']);
	if (!empty($_FILES)) {
	
	$tempFile = $_FILES['pPic']['tmp_name'];
	$targetPath = '../../../uploads/images/fotos';
	$targetFile =  str_replace('//','/',$targetPath) . ConverteURLimagem($_FILES['pPic']['name']);
	$targetFile2 =  str_replace('//','/',$targetPath) . ConverteURLimagem($_FILES['pPic']['name']);
	
	move_uploaded_file($tempFile,$targetFile);
	
	echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	
	$conexao = new classeConexao(); 
	$consulta = $conexao->consulta('INSERT INTO tb_galeria_foto (tb_galeria_foto_nome, tb_galeria_foto_nome_thumb, tb_galeria_foto_id_conteudo) VALUES ("big_'.$original.'","thumb_'.$original.'","'.$_GET['id'].'")');		
  
   $image = new SimpleImage();
   $image->load($targetFile);
   $image->resizeToWidth($DadosConteudo['tb_conteudo_categoria_galeria_foto_grande_largura']);
   $image->save($targetPath.'/big_'.$original);   
   $image->load($targetFile2);
   $image->resizeToWidth($DadosConteudo['tb_conteudo_categoria_galeria_foto_pequena_largura']);
   $image->save($targetPath.'/thumb_'.$original);

   

	
}
?>