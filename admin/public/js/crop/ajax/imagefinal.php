<?php
  session_start();
  sleep(1);
  include"../conexao/config.php";
  
  
  
$pasta = "../../../../uploads/images/conteudo/temp/";
if(is_dir($pasta))
{
$diretorio = dir($pasta);
while($arquivo = $diretorio->read())
{
if(($arquivo != '.') && ($arquivo != '..'))
{
unlink($pasta.$arquivo);
//echo 'Arquivo '.$arquivo.' foi apagado com sucesso. <br />';
}
}
$diretorio->close();
}
else
{
//echo 'A pasta não existe.';
}
  
  
  
  
  $sql = mysql_query("UPDATE tb_conteudo SET tb_conteudo_imagem_temporaria = '' WHERE tb_conteudo_id = '".$_GET['id']."'") or die(mysql_error());
  

  
if ($_GET['tipo'] == 'destaque'){
  /// PEGA A IMAGEM ATUAL
		$sql = mysql_query("SELECT tb_conteudo_imagem_pequena FROM tb_conteudo WHERE tb_conteudo_id = '".$_GET['id']."'") or die(mysql_error());
		$res = mysql_fetch_array($sql);
		$img  = $res['tb_conteudo_imagem_pequena'];
}else{
		$sql = mysql_query("SELECT tb_conteudo_imagem_grande FROM tb_conteudo WHERE tb_conteudo_id = '".$_GET['id']."'") or die(mysql_error());
		$res = mysql_fetch_array($sql);
		$img  = $res['tb_conteudo_imagem_grande'];

				}				

				
				
?>
<img class="img_1" src="../uploads/images/conteudo/<?php echo $img;?>" width="<?php echo $_GET['largura']?>" height="<?php echo $_GET['altura']?>" alt="" />