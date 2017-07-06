<?php
require_once('vendor/load.php');
require_once('public/header.php');

if (isset($_GET['acao2'])){
if ($_GET['acao2'] == 'deletar'){
		if (isset($_GET['id2'])){
			
	//creio que o unlink seja non-related to the actual crop		
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('SELECT * from tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = "'.$_GET['id2'].'"');
    $dados = $conexao->busca($consulta);
	
     unlink('../uploads/images/fotos/'.$dados['tb_galeria_foto_nome']); 
     unlink('../uploads/images/fotos/'.$dados['tb_galeria_foto_nome_thumb']); 

     $conexao->desconectar();
			
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_galeria_foto where tb_galeria_foto_id = "'.$_GET['id2'].'"');
			 $conexao->desconectar();
			 
			

		}
		$msgSucesso = true;
		header ('location: ../paginas-foto-galeria/'.$_GET['id']);
	}
}


?>


<link rel="stylesheet" type="text/css" href="public/js/uploadify/css/uploadify.css">
<script type="text/javascript" src="public/js/uploadify/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="public/js/uploadify/js/swfobject.js"></script>
<script type="text/javascript" src="public/js/uploadify/js/jquery.uploadify.v2.1.4.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $('#file_upload').uploadify({
	'fileExt'     : '*.png;*.jpg;*.gif;*.bmp',
	'removeCompleted': true,
  	'fileDesc'    : 'Documents (.png, .jpg, .gif, .bmp)',
	'onAllComplete' : function() {
		alert('Upload Realizado com sucesso! \nClique em Ok para recarregar a página.');
		setTimeout("location.reload(true);",0);
		},
	'multi' 		: true,
    'uploader'  	: 'js/uploadify/js/uploadify.swf',
    'cancelImg' 	: 'js/uploadify/js/cancel.png',
    'auto'      	: true,
	<?php if (isset($_GET['id2'])){?>
    'script'		: '../../../../public/js/uploadify/upload.php?id=<?php echo $_GET['id']?>',
	<?php }else{?>
    'script'		: '../../public/js/uploadify/upload.php?id=<?php echo $_GET['id']?>',
	<?php }?>
	
    'buttonText'	: 'Galeira de Fotos',
    'fileDataName'  : 'pPic'
  });
});
</script>

<table width="100%" border="0">
  <tr>
    <td width="5"><input id="file_upload" name="file_upload" type="file" /></td>
    <td width="271">&lt;- Clique e adicione.</td>
    <td width="600" align="right"><a href="paginas-editar/resgatar-dados/<?php if (isset($_GET['id'])){echo $_GET['id'];}?>" title="Retornar" class="btn btn-info"> Retonar para o Conteúdo</a></td>
  </tr>
</table>



<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    
    
    
    
    
       <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('SELECT * from tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = "'.$_GET['id'].'" order by tb_galeria_foto_id desc');
	
    while($dados = $conexao->busca($consulta)){?>
    <table width="180" border="1" align="left" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <td><img src="../uploads/images/fotos/<?php echo htmlentities($dados['tb_galeria_foto_nome_thumb']);?>" style="min-width:180px; max-width:180px;" /></td>
      </tr>
      <tr>
        <td align="center"><a href="paginas-foto-galeria/editar/<?php echo $_GET['id']?>/deletar/<?php echo $dados['tb_galeria_foto_id'];?>">Deletar Foto <br />
        <?php echo $dados['tb_galeria_foto_nome'];?></a></td>
        </tr>
      </table>
    <?php } $conexao->desconectar();?>
    

    
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?php 
require_once('public/footer.php');?>
