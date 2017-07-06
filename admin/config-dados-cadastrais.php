<?php 
require_once('vendor/load.php');
global $msgSucesso;
if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST')
  {
  	$conexao = new Conexao(); 
  	$consulta = $conexao->consulta('SELECT tb_config_cadastral_id FROM tb_config_cadastral where tb_config_cadastral_codigo = "'.$_POST['txt_codigo'].'"');
  	$contaRegistrosMesmaURL = $conexao->conta($consulta);
  	if ($contaRegistrosMesmaURL == 0){			
    $conexao = new Conexao(); 
    $consulta = $conexao->consulta('
      INSERT into tb_config_cadastral (
      tb_config_cadastral_nome,
      tb_config_cadastral_codigo,
      tb_config_cadastral_valor
      ) values (
      "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
      "'.mysqli_real_escape_string($conexao->obj(),$_POST['txt_codigo']).'",
      "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_valor'])).'"
      )') ;
  		  $msgSucesso = 'ok';
		} 
    else 
    {
      $msgSucesso = 'nok';
    }
	}
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST')
  {
		if (isset($_GET['id']))
    {
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			SELECT tb_config_cadastral_id FROM tb_config_cadastral where tb_config_cadastral_codigo = "'.$_POST['txt_codigo'].'" and tb_config_cadastral_id <> "'.$_GET['id'].'"');
			$contaRegistrosMesmaURL = $conexao->conta($consulta);
      if ($contaRegistrosMesmaURL == 0)
      { 
        $conexao = new Conexao(); 
        $consulta = $conexao->consulta('
        UPDATE tb_config_cadastral SET 
        tb_config_cadastral_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_config_cadastral_codigo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_codigo'])).'",
        tb_config_cadastral_valor="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_valor'])).'"   
        where tb_config_cadastral_id = '.$_GET['id']);
        $msgSucesso = 'ok';
			} 
      else 
      {
        $msgSucesso = 'nok';
      }
    }//id
	}
if ($_GET['acao'] == 'excluir')
{
  		if (isset($_GET['id']))
      {
    			$conexao = new Conexao(); 
    			$consulta = $conexao->consulta('
    			DELETE FROM tb_config_cadastral where tb_config_cadastral_id = "'.$_GET['id'].'"');
    			$msgSucesso = 'ok';

		}
	}
}
global $editardados;
		if (isset($_GET['acao'])){
			$nomeFormulario = 'Editar ';
      $lock = true;
			if ($_GET['acao'] == 'resgatar-dados') {
				$action = 'config-dados-cadastrais/editar/'.$_GET['id'];
				
				$conexao = new Conexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_config_cadastral 
				WHERE 
				tb_config_cadastral_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
				
			}else{
			$action = 'config-dados-cadastrais/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'config-dados-cadastrais/gravar';
			$nomeFormulario = 'Adicionar ';
			}
	?>
<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="31%"><h2>Dados Cadastrais</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Dados Cadastrais</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
			<th width="390">Nome da Configuração</th>
			<th width="346">Código da Configuração</th>
			<th width="346">Valor da Configuração</th>
			<th width="29">&nbsp;</th>
			<th width="31">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    <?php 
  	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('SELECT * FROM tb_config_cadastral');
    while($dados = $conexao->busca($consulta)){?>
    <tr>
			<td><?php echo $dados['tb_config_cadastral_nome'];?></td>
			<td><?php echo $dados['tb_config_cadastral_codigo'];?></td>
			<td><?php echo $dados['tb_config_cadastral_valor'];?></td>
			<td>
			  <a href="config-dados-cadastrais/resgatar-dados/<?php echo $dados['tb_config_cadastral_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
			<td>
      <?php
        if($_SESSION['usuarioTipo'] == 1)
        {
      ?>
        <a href="config-dados-cadastrais/excluir/<?php echo $dados['tb_config_cadastral_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
      <?php
        }
      ?>
      </td>
		  </tr>
    <?php } $conexao->desconectar();	?>
	</tbody>
	<tfoot>
		<tr>
			<th>Nome da Configuração</th>
			<th>Código da Configuração</th>
			<th>Valor da Configuração</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		  </tr>
	</tfoot>
</table>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td>&nbsp;</td>
    <td valign="top"><table width="100%" border="0" cellpadding="5"></td>
    </tr>
    </table>
      <form action="<?php echo $action?>" method="post" id="dadoscategoria">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><strong>Nome da Nova Configuração</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_config_cadastral_nome']?>" required />
            <hr></td>
        </tr>
        <tr>
          <td colspan="2"><strong>URL Amigável (Código)</strong></td>
        </tr>
        <tr>
        <?php
        $output = '';
        if(isset($lock))
        {
          $output = 'readonly';
        }
        ?>
          <td colspan="2"><input <?=$output?> name="txt_codigo" type="text" class="form-control" id="txt_codigo" value="<?php echo $editardados['tb_config_cadastral_codigo']?>" required />
            <hr></td>
        </tr>
       <tr>
          <td colspan="2"><strong>Valor da Nova Configuração</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_valor" type="text" class="form-control" id="txt_valor" value="<?php echo $editardados['tb_config_cadastral_valor']?>" required />
            <hr></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input type="submit" class="btn btn-success" value="Gravar" /></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
    </table></td>
      </form>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php require_once('public/footer.php');?>