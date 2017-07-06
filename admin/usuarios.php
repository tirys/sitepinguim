<?php 
require_once('vendor/load.php');
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new conexao(); 
	$consulta = $conexao->consulta('
		INSERT into tb_usuario (
		tb_usuario_nome,
		tb_usuario_email,
		tb_usuario_senha,
		tb_usuario_tipo
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_email'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_senha'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'"
		)');
		$msgSucesso = 'ok';
		}
	

	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
			if (isset($_GET['id'])){
			$conexao = new conexao(); 
			//die(var_dump($conexao->obj()));
			$consulta = $conexao->consulta('
			UPDATE tb_usuario SET 
			tb_usuario_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
			tb_usuario_email="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_email'])).'",
			tb_usuario_senha="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_senha'])).'",
			tb_usuario_tipo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'"
			where tb_usuario_id = "'.$_GET['id'].'"');
			$msgSucesso = 'ok';
			} else {$msgSucesso = 'nok';
			}
		}


	if ($_GET['acao'] == 'excluir'){
		if (isset($_GET['id'])){			
		$conexao = new conexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_relacao_usuario_x_cidade where tb_relacao_usuario_x_cidade_usuario = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
			
			$conexao = new conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_usuario where tb_usuario_id = "'.$_GET['id'].'"');
			
			$consulta = $conexao->consulta('
			DELETE FROM tb_relacao_usuario_x_cidade where tb_relacao_usuario_x_cidade_usuario = "'.$_GET['id'].'"');
			
			$consulta = $conexao->consulta('
			DELETE FROM tb_relacao_usuario_x_unidade where tb_relacao_usuario_x_unidade_usuario = "'.$_GET['id'].'"');
			
			$consulta = $conexao->consulta('
			DELETE FROM tb_relacao_usuario_x_tipo_lead where tb_relacao_usuario_x_tipo_lead_usuario = "'.$_GET['id'].'"');
			
			$msgSucesso = 'ok';
			} else {$msgSucesso = 'nok';}
			
			} else {$msgSucesso = 'nok';

	}
	
	
	
	
//		DELEÇÃO DE USUÁRIO COM BLOQUEIO SE O USUÁRIO JÁ ESTIVER DELEGADO PARA ALGUMA UNIDADE OU REGIÃO	
//		if ($_GET['acao'] == 'excluir'){
//		if (isset($_GET['id'])){			
//		$conexao = new conexao(); 
//		$consulta = $conexao->consulta('SELECT * FROM tb_relacao_usuario_x_cidade where tb_relacao_usuario_x_cidade_usuario = "'.$_GET['id'].'"');
//		$constaLigacao = $conexao->busca($consulta);
//		$conexao->desconectar();	
//			if (empty($constaLigacao)){
//			
//			$conexao = new conexao(); 
//			$consulta = $conexao->consulta('SELECT * FROM tb_relacao_usuario_x_unidade where tb_relacao_usuario_x_unidade_usuario = "'.$_GET['id'].'"');
//			$constaLigacao2 = $conexao->busca($consulta);
//			$conexao->desconectar();	
//			if (empty($constaLigacao2)){
//			$conexao = new conexao(); 
//			$consulta = $conexao->consulta('
//			DELETE FROM tb_usuario where tb_usuario_id = "'.$_GET['id'].'"');
//			
//			$consulta = $conexao->consulta('
//			DELETE FROM tb_relacao_usuario_x_cidade where tb_relacao_usuario_x_cidade_usuario = "'.$_GET['id'].'"');
//			
//			$consulta = $conexao->consulta('
//			DELETE FROM tb_relacao_usuario_x_unidade where tb_relacao_usuario_x_unidade_usuario = "'.$_GET['id'].'"');
//			
//			$msgSucesso = 'ok';
//			} else {$msgSucesso = 'nok';}
//			
//			} else {$msgSucesso = 'nok';
//		}
//	}
//	}
	
	
	
	
	
	
	
	
	
	}
?>












<?php 
	global $editardados;
		if (isset($_GET['acao'])){
			$nomeFormulario = 'Editar ';
			if ($_GET['acao'] == 'resgatar-dados') {
				$action = 'usuarios/editar/'.$_GET['id'];
				
				$conexao = new conexao(); 
				$consulta = $conexao->consulta('
				SELECT tb_usuario.*, tb_usuario_tipo.* FROM tb_usuario left join tb_usuario_tipo ON
				tb_usuario.tb_usuario_tipo = tb_usuario_tipo.tb_usuario_tipo_id 
				WHERE 
				tb_usuario_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'usuarios/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'usuarios/gravar';
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
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Usário</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
		  <th width="151">Nome</th>
		  <th width="264">E-mail</th>
		  <th width="118">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new conexao(); 
    $consulta = $conexao->consulta('
	SELECT * FROM tb_usuario order by tb_usuario_nome');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
      <td><?php echo $dados['tb_usuario_nome'];?></td>
      <td><?php echo $dados['tb_usuario_email'];?></td>
      <td align="right">
      
      <a href="usuarios-relacao-tipos-lead/resgatar-dados/<?php echo $dados['tb_usuario_id'];?>" title="Editar" class="btn btn-primary btn-xs">Tipos de Lead</a>
      
        <a href="usuarios-relacao-cidades/resgatar-dados/<?php echo $dados['tb_usuario_id'];?>" title="Editar" class="btn btn-primary btn-xs">Cidades</a>
        
        <a href="usuarios-relacao-unidades/resgatar-dados/<?php echo $dados['tb_usuario_id'];?>" title="Editar" class="btn btn-primary btn-xs">Unidades</a>
        <a href="usuarios/resgatar-dados/<?php echo $dados['tb_usuario_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
        <a href="usuarios/excluir/<?php echo $dados['tb_usuario_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Excluir</a></td>
		  </tr>
    <?php } $conexao->desconectar();	?>
        
	
	</tbody>
	<tfoot>
		<tr>
		  <th>Nome</th>
		  <th>E-mail</th>
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
          <td width="50"><strong>Nome do Usuário</strong></td>
        </tr>
        <tr>
          <td><strong>
            <input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_usuario_nome']?>" required />
          </strong></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>E-mail</strong></td>
        </tr>
        <tr>
          <td><strong>
            <input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $editardados['tb_usuario_email']?>" required />
          </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Senha</strong></td>
        </tr>
        <tr>
          <td><strong>
            <input name="txt_senha" type="text" class="form-control" id="txt_senha" value="<?php echo $editardados['tb_usuario_senha']?>" required />
          </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Tipo de Usuário</strong></td>
        </tr>
        <tr>
          <td><strong>
     
            
        <select name="txt_tipo" id="txt_tipo" class="form-control">
        <?php 
        $conexao = new conexao(); 
        if (isset($_GET['acao'])){
        if ($_GET['acao'] == 'resgatar-dados') {

        ?>
        <option value="<?php echo $editardados['tb_usuario_tipo_id'];?>"> <?php echo $editardados['tb_usuario_tipo_nome'];?></option>
        <?php }}
        
        $consulta = $conexao->consulta('SELECT * FROM tb_usuario_tipo ORDER BY tb_usuario_tipo_nome');      
        while($listaTipo = $conexao->busca($consulta)){?>
        <option value="<?php echo $listaTipo['tb_usuario_tipo_id'];?>"> <?php echo $listaTipo['tb_usuario_tipo_nome'];?></option>
        <?php } $conexao->desconectar();	?>
        </select>
            
          </strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><strong>
            <input type="submit" class="btn btn-success" value="Gravar" />
          </strong></td>
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