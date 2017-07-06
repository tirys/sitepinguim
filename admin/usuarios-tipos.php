<?php 
require_once('vendor/load.php');
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new classeConexao(); 
	$consulta = $conexao->consulta('
		INSERT into tb_usuario_tipo (
		tb_usuario_tipo_nome,
		tb_usuario_tipo_acesso_total
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_acesso_total'])).'"
		)');
		$msgSucesso = 'ok';
		}
	

	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
			if (isset($_GET['id'])){
			$conexao = new classeConexao(); 
			$consulta = $conexao->consulta('
			UPDATE tb_usuario_tipo SET 
			tb_usuario_tipo_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
			tb_usuario_tipo_acesso_total="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_acesso_total'])).'"
			where tb_usuario_tipo_id = "'.$_GET['id'].'"');
			$msgSucesso = 'ok';
			} else {$msgSucesso = 'nok';
			}
		}


	if ($_GET['acao'] == 'excluir'){
		if (isset($_GET['id'])){			
		$conexao = new classeConexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_usuario where tb_usuario_tipo = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
			if (empty($constaLigacao)){
			$conexao = new classeConexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_usuario_tipo where tb_usuario_tipo_id = "'.$_GET['id'].'"');
			$msgSucesso = 'ok';
		} else {$msgSucesso = 'nok';
		}
	}
	}
	}
?>

<?php 
	global $editardados;
		if (isset($_GET['acao'])){
			$nomeFormulario = 'Editar ';
			if ($_GET['acao'] == 'resgatar-dados') {
				$action = 'usuarios-tipos/editar/'.$_GET['id'];
				
				$conexao = new classeConexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_usuario_tipo 
				WHERE 
				tb_usuario_tipo_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'usuarios-tipos/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'usuarios-tipos/gravar';
			$nomeFormulario = 'Adicionar ';
			}

	?>

<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

    

  <tr>
    <td width="31%"><h2>Usuários</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Usuário</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
		  <th width="638">Nome</th>
		  <th width="28">&nbsp;</th>
			<th width="28">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new classeConexao(); 
    $consulta = $conexao->consulta('
	SELECT * FROM tb_usuario_tipo order by tb_usuario_tipo_nome');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
      <td><?php echo $dados['tb_usuario_tipo_nome'];?></td>
      <td>
        <a href="usuarios-tipos/resgatar-dados/<?php echo $dados['tb_usuario_tipo_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
			<td><a href="usuarios-tipos/excluir/<?php echo $dados['tb_usuario_tipo_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
		  </tr>
    <?php } $conexao->desconectar();	?>
        
	
	</tbody>
	<tfoot>
		<tr>
		  <th>Nome</th>
		  <th>&nbsp;</th>
			<th>&nbsp;</th>
		  </tr>
	</tfoot>
</table>





    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td>&nbsp;</td>
    <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <form action="<?php echo $action?>" method="post" id="dadoscategoria">
        <tr>
          <td width="50"><strong>Nome do Tipo de Usuário</strong></td>
        </tr>
        <tr>
          <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_usuario_tipo_nome']?>" required /></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Nível de Acesso</strong></td>
        </tr>
        <tr>
          <td align="right">
          
          <select name="txt_acesso_total" id="txt_acesso_total" class="form-control">
      
      	<?php 
		if($editardados['tb_usuario_tipo_acesso_total'] == '1'){
			echo '
			<option value="1" selected>Acesso Total</option>
			<option value="1">Acesso Total</option>
        	<option value="0">Acesso Limitado</option>';
			}
		else if($editardados['tb_usuario_tipo_acesso_total'] == '0'){
			echo '
			<option value="0" selected>Acesso Limitado</option>
			<option value="1">Acesso Total</option>
        	<option value="0">Acesso Limitado</option>';
		}
		else{
			echo '
			<option value="1" selected>Acesso Total</option>
        	<option value="0">Acesso Limitado</option>';
		}
		?>
        
        
        
       
        </select>
          
          </td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><input type="submit" class="btn btn-success" value="Gravar" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </form>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<?php require_once('public/footer.php');?>