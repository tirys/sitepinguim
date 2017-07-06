<?php 
require_once('vendor/load.php');

if (isset($_GET['acao'])){
	
if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('UPDATE tb_banner_tipo SET 
        tb_banner_tipo_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_banner_tipo_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_largura'])).'",
        tb_banner_tipo_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_altura'])).'"			
        where tb_banner_tipo_id = "'.$_GET['id'].'"');
$msgSucesso = true;

}

}
//RESGATANDO DADOS DA PÁGINA ESCOLHIDA
$conexao = new Conexao(); 
$consulta = $conexao->consulta('SELECT * FROM tb_banner_tipo where tb_banner_tipo_id = "'.$_GET['id'].'"');
$dados = $conexao->busca($consulta);
				


?>








<?php require_once('public/header.php');?>
    
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="5">
      <form action="banners-tipos-editar/gravar/<?php echo $_GET['id']?>" method="post">
        
        <tr>
          <td colspan="3"><h1>Editar Tipo de Banner          </h1></td>
          <td width="20%" align="right"><input type="submit" class="btn btn-success" value="Gravar Alteração" /></td>
          </tr>
        <tr>
          <td width="20%">Nome da Página</td>
          <td width="20%">Largura</td>
          <td colspan="2">Altura</td>
          </tr>
        <tr>
          <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $dados['tb_banner_tipo_nome']?>" /></td>
          <td><input name="txt_largura" type="text" class="form-control" id="txt_largura" value="<?php echo $dados['tb_banner_tipo_largura']?>" /></td>
          <td colspan="2"><input name="txt_altura" type="text" class="form-control" id="txt_altura" value="<?php echo $dados['tb_banner_tipo_altura']?>" /></td>
          </tr>
        
        </form>
      </table>
      <h1><br />
    </h1></td>
  </tr>
  </table>
<p>&nbsp;</p>
<?php require_once('public/footer.php');?>