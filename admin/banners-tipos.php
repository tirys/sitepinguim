<?php 
require_once('vendor/load.php');

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		$conexao = new Conexao(); 
	$consulta = $conexao->consulta('UPDATE tb_banner_tipo SET 
        tb_banner_tipo_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_banner_tipo_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_largura'])).'",
        tb_banner_tipo_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_altura'])).'"			
        where tb_conteudo_id = "'.$_GET['id'].'"');
$msgSucesso = true;

}

if ($_GET['acao'] == 'excluir'){
		if (isset($_GET['id'])){
		$conexao = new Conexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_banner where tb_banner_id_tipo = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
		if (empty($constaLigacao)){
		$conexao = new Conexao(); 
		$consulta = $conexao->consulta('
		DELETE FROM tb_banner_tipo where tb_banner_tipo_id = "'.$_GET['id'].'"');
		$msgSucesso = 'ok';
		} else {$msgSucesso = 'nok';}
		}
		$msgSucesso = true;
	}
}
?>
<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

    

  <tr>
    <td width="40%"><h2>Tipos de Banners</h2></td>
    <td width="53%">
      <?php if ($msgSucesso == true){?>
      <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
      <?php } ?>
      
     

    </td>
    <td width="7%" align="right">
    
    <a href="banners-tipos-adicionar/nova/" class="btn btn-success" title="Adicionar">Novo Tipo de Banner</a>
    
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
      <thead>
        <tr>
          <th width="104">Identificador</th>
          <th width="342">Nome</th>
          <th width="212"> Largura</th>
          <th width="212">Altura</th>
          <th width="29">&nbsp;</th>
          <th width="33">&nbsp;</th>
          </tr>
        </thead>
      <tbody>
        
        <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('SELECT * from tb_banner_tipo order by tb_banner_tipo_nome desc');
	
    while($dados = $conexao->busca($consulta)){?>
        <tr>
          <td><?php echo $dados['tb_banner_tipo_id'];?></td>
          <td><?php echo $dados['tb_banner_tipo_nome'];?></td>
          <td><?php echo $dados['tb_banner_tipo_largura'];?></td>
          <td><?php echo $dados['tb_banner_tipo_altura'];?></td>
          <td><a href="banners-tipos-editar/resgatar-dados/<?php echo $dados['tb_banner_tipo_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
          <td><a href="banners-tipos/excluir/<?php echo $dados['tb_banner_tipo_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
          </tr>
        <?php } $conexao->desconectar();?>
        
        </tbody>
      <tfoot>
        <tr>
          <th>Identificador</th>
          <th>Nome</th>
          <th>Largura</th>
          <th>Altura</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          </tr>
        </tfoot>
      </table>
      <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>



<?php require_once('public/footer.php');?>