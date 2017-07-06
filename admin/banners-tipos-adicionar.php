<?php 
require_once('vendor/load.php');

header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){

	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('INSERT INTO tb_banner_tipo (
		tb_banner_tipo_nome,
		tb_banner_tipo_largura,
		tb_banner_tipo_altura
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_largura'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_altura'])).'"
		)');		
		

header ("location: ../banners-tipos");

$msgSucesso = true;
	}
}

?>

<?php require_once('public/header.php');?>
   

<table width="100%" border="0" cellpadding="5">
<form action="banners-tipos-adicionar/gravar" method="post">
  <tr>
    <td width="56%" colspan="3"><h1>Novo Tipo de Banner</h1></td>
    <td width="37%" align="right">
     <?php 
	 if ($msgErro == true){?>
      <div class="alert alert-danger" style="padding:5px; margin-top:18px; margin-bottom:0px;">Já existe um conteúdo com este. Escolha outro nome.</div>
      <?php } ?>
      
    
    </td>
    <td width="7%" align="right"><input type="submit" class="btn btn-success" /></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="5">
      <tr>
        <td width="20%">Nome</td>
        <td width="10%">Largura da Imagem</td>
        <td width="10%">Altura da Imagem</td>
        </tr>
      <tr>
        <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php if (isset($_POST['txt_nome'])){echo $_POST['txt_nome'];}?>" /></td>
        <td><input name="txt_largura" type="text" class="form-control sonumero" id="txt_largura" value="<?php if (isset($_POST['txt_largura'])){echo $_POST['txt_largura'];}?>"/></td>
        <td><input name="txt_altura" type="text" class="form-control sonumero" id="txt_altura" value="<?php if (isset($_POST['txt_altura'])){echo $_POST['txt_altura'];}?>"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  </form>
</table>
<?php require_once('public/footer.php');?>