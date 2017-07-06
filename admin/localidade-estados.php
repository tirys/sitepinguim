<?php 
require_once('vendor/load.php');
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('
		INSERT into tb_localidade_estado (
		tb_localidade_estado_pais,
		tb_localidade_estado_nome,
		tb_localidade_estado_sigla
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_pais'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_sigla'])).'"
		)');
		$msgSucesso = 'ok';
		}
	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
			if (isset($_GET['id'])){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			UPDATE tb_localidade_estado SET 
			tb_localidade_estado_pais="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_pais'])).'",
			tb_localidade_estado_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
			tb_localidade_estado_sigla="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_sigla'])).'"
			where tb_localidade_estado_id = "'.$_GET['id'].'"');
			$msgSucesso = 'ok';
			} else {$msgSucesso = 'nok';
			}
		}

	if ($_GET['acao'] == 'excluir'){
		if (isset($_GET['id'])){			
		$conexao = new Conexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_localidade_cidade where tb_localidade_cidade_estado = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
			if (empty($constaLigacao)){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_localidade_estado where tb_localidade_estado_id = "'.$_GET['id'].'"');
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
				$action = 'localidade-estados/editar/'.$_GET['id'];
				
				$conexao = new Conexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_localidade_estado 
				WHERE 
				tb_localidade_estado_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'localidade-estados/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'localidade-estados/gravar';
			$nomeFormulario = 'Adicionar ';
			}

	?>

<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

    

  <tr>
    <td width="31%"><h2>Estados</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Estado</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
		  <th width="638">Nome</th>
		  <th width="638">Sigla</th>
		  <th width="28">&nbsp;</th>
			<th width="28">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('
	SELECT * FROM tb_localidade_estado order by tb_localidade_estado_nome');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
      <td><?php echo $dados['tb_localidade_estado_nome'];?></td>
      <td><?php echo $dados['tb_localidade_estado_sigla'];?></td>
      <td>
        <a href="localidade-estados/resgatar-dados/<?php echo $dados['tb_localidade_estado_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
			<td><a href="localidade-estados/excluir/<?php echo $dados['tb_localidade_estado_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a></td>
		  </tr>
    <?php } $conexao->desconectar();	?>
        
	
	</tbody>
	<tfoot>
		<tr>
		  <th>Nome</th>
		  <th>Sigla</th>
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
          <td><strong>Nome do País</strong></td>
        </tr>
        <tr>
          <td>
          
          <select name="txt_pais" id="txt_pais" class="form-control">
            <?php 
			$conexao = new Conexao(); 
            if (isset($_GET['acao'])){
            if ($_GET['acao'] == 'resgatar-dados') {
	        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_pais WHERE tb_localidade_pais_id = "'.$editardados['tb_localidade_estado_pais'].'"'); 
			$buscaNomeCategoria = $conexao->busca($consulta);	
			?>
            <option value="<?php echo $buscaNomeCategoria['tb_localidade_pais_id'];?>"> <?php echo $buscaNomeCategoria['tb_localidade_pais_nome'];?></option>
            <?php }}
			
			$consulta = $conexao->consulta('SELECT * FROM tb_localidade_pais ORDER BY tb_localidade_pais_nome');      
			while($listaCategoria = $conexao->busca($consulta)){?>
			<option value="<?php echo $listaCategoria['tb_localidade_pais_id'];?>"> <?php echo $listaCategoria['tb_localidade_pais_nome'];?></option>
			<?php } $conexao->desconectar();	?>
          </select>
          
          
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="50"><strong>Nome do Estado</strong></td>
        </tr>
        <tr>
          <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_localidade_estado_nome']?>" required /></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Sigla do Estado</strong></td>
        </tr>
        <tr>
          <td><input name="txt_sigla" type="text" class="form-control" id="txt_sigla" value="<?php echo $editardados['tb_localidade_estado_sigla']?>" required /></td>
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