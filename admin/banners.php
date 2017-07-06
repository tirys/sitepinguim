<?php 
require_once('vendor/load.php');

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('
		INSERT into tb_banner (
		tb_banner_nome,
		tb_banner_link,
		tb_banner_janela,
		tb_banner_id_tipo,
		tb_banner_data_inicia,
		tb_banner_data_finaliza
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_janela'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'",
        "'.$_POST['txt_data_inicializa'].'",
		"'.$_POST['txt_data_finaliza'].'"
		)');
		$msgSucesso = true;
	}
	
	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_GET['id'])){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('UPDATE tb_banner SET 
        tb_banner_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_banner_link="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
        tb_banner_janela="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_janela'])).'",
        tb_banner_id_tipo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'",
		    tb_banner_data_inicia="'.$_POST['txt_data_inicializa'].'",
		    tb_banner_data_finaliza="'.$_POST['txt_data_finaliza'].'"
        where tb_banner_id = "'.$_GET['id'].'"');
		}
		$msgSucesso = true;
	}
}


if (isset($_GET['acao2'])){
if ($_GET['acao2'] == 'excluir'){
		if (isset($_GET['id2'])){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_banner where tb_banner_id = "'.$_GET['id2'].'"');
		}
		$msgSucesso = true;
	}
}
?>


<?php require_once('public/header.php');?>

<table width="100%" border="0" cellpadding="5">

  <tr>
    <td width="40%"><h2>Banners</h2></td>
    <td width="53%">
      <?php if ($msgSucesso == true){?>
      <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
      <?php } ?>
      
     

    </td>
    <td width="7%" align="right">
    

              <a href="banners-adicionar/nova/<?=$_GET['id']?>" class="btn btn-success" title="Adicionar">Novo Banner</a>
    
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
      <thead>
        <tr>
          <th width="104">Identificador</th>
          <th width="407">Nome</th>
          <th width="165">Link</th>
          <th width="286">Data Início</th>
          <th width="253">Data Fim</th>
          <th width="370">Tipo de Banner</th>
          <th width="29">&nbsp;</th>
          <th width="33">&nbsp;</th>
          </tr>
        </thead>
      <tbody>
        
        <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('SELECT tb_banner_tipo.*, tb_banner.* from tb_banner left join tb_banner_tipo on tb_banner_tipo.tb_banner_tipo_id = tb_banner.tb_banner_id_tipo where tb_banner.tb_banner_id_tipo = "'.$_GET['id'].'" order by tb_banner_tipo_nome desc');
	
    while($dados = $conexao->busca($consulta)){?>
        <tr>
          <td><?php echo $dados['tb_banner_id'];?></td>
          <td><?php echo $dados['tb_banner_nome'];?></td>
          <td><?php echo $dados['tb_banner_link'];?></td>
          <td><?php echo DesConverteData($dados['tb_banner_data_inicia']);?></td>
          <td><?php echo DesConverteData($dados['tb_banner_data_finaliza']);?></td>
          <td><?php echo $dados['tb_banner_tipo_nome'];?></td>
          <td><a href="banners-editar/resgatar-dados/<?php echo $dados['tb_banner_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
          <td><a href="banners/listar/<?php echo $dados['tb_banner_tipo_id'];?>/excluir/<?php echo $dados['tb_banner_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
          </tr>
        <?php } $conexao->desconectar();?>
        
        </tbody>
      <tfoot>
        <tr>
          <th>Identificador</th>
          <th>Nome</th>
          <th>Link</th>
          <th>Data Início</th>
          <th>Data Fim</th>
          <th>Tipo de Banner</th>
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