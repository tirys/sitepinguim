<?php 
require_once('vendor/load.php');
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	$conexao = new Conexao(); 
    //LATITUDE E LONGITUDE 
    $id_cidade    = $_POST['txt_cidade'];
    $id_estado    = $_POST['txt_estado'];
    $cidade       = conexao::fetchuniq("SELECT tb_localidade_cidade_nome FROM tb_localidade_cidade WHERE tb_localidade_cidade_id = {$id_cidade}");
    $nome_cidade  = utf8_decode($cidade['tb_localidade_cidade_nome']);
    $estado       = conexao::fetchuniq("SELECT tb_localidade_estado_nome FROM tb_localidade_estado WHERE tb_localidade_estado_id = {$id_estado}");
    $nome_estado  = utf8_decode($estado['tb_localidade_estado_nome']);
    $str          = urlencode($_POST['txt_endereco'].', '.$_POST['txt_numero'].' '.$_POST['txt_bairro'].', '.$nome_cidade.', '.$nome_estado);
    $response     = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$str);
    $res          = json_decode($response,true);
    $latitude  = '0';
    $longitude = '0';
    $endereco_formatado = $_POST['txt_endereco'].', '.$_POST['txt_numero'].' '.$_POST['txt_bairro'].', '.$nome_cidade.', '.$nome_estado;
    if($res['results'])
    {
        $latitude           = strval($res['results'][0]['geometry']['location']['lat']);
        $longitude          = strval($res['results'][0]['geometry']['location']['lng']);
        $endereco_formatado = $res['results'][0]['formatted_address'];
    }
    $sql ='
    INSERT into tb_unidade (
    tb_unidade_nome,
    tb_unidade_email,
    tb_unidade_endereco,
    tb_unidade_numero,
    tb_unidade_cep,
    tb_unidade_bairro,
    tb_unidade_pais,
    tb_unidade_cidade,
    tb_unidade_estado,
    tb_unidade_complemento,
    tb_unidade_telefone,
    tb_unidade_login,
    tb_unidade_responsavel,
    tb_unidade_depoimento,
    tb_unidade_videos,
    tb_unidade_latitude,
    tb_unidade_longitude,
    tb_unidade_endereco_formatado
    ) values (
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_nome'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_email'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_endereco'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_numero'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_cep'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_bairro'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_pais'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_cidade'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_estado'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_complemento'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_telefone'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_login'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_responsavel'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_depoimento'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_videos'])).'",
    "'.$latitude.'",
    "'.$longitude.'",
    "'.$endereco_formatado.'"
    )';
	  $consulta = $conexao->consulta($sql);
		$msgSucesso = 'ok';
		}
	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
			if (isset($_GET['id'])){

      if(!empty($_POST['servicos'])) 
      {
        foreach($_POST['servicos'] as $servico)
        {
          if(!Conexao::count("SELECT tb_unidade_servico_id FROM tb_unidade_servico WHERE tb_unidade_servico_id_unidade = ".$_GET['id']." AND tb_unidade_servico_id_servico = {$servico}"))
          {
            Conexao::exec("INSERT INTO tb_unidade_servico (tb_unidade_servico_id_unidade, tb_unidade_servico_id_servico) VALUES ('".$_GET['id']."','$servico')");
          }
        }
      }
    	$conexao = new Conexao(); 
      //LATITUDE E LONGITUDE 
      $id_cidade    = $_POST['txt_cidade'];
      $id_estado    = $_POST['txt_estado'];
      $cidade       = conexao::fetchuniq("SELECT tb_localidade_cidade_nome FROM tb_localidade_cidade WHERE tb_localidade_cidade_id = {$id_cidade}");
      $nome_cidade  = utf8_decode($cidade['tb_localidade_cidade_nome']);
      $estado       = conexao::fetchuniq("SELECT tb_localidade_estado_nome FROM tb_localidade_estado WHERE tb_localidade_estado_id = {$id_estado}");
      $nome_estado  = utf8_decode($estado['tb_localidade_estado_nome']);
      $str          = urlencode($_POST['txt_endereco'].', '.$_POST['txt_numero'].' '.$_POST['txt_bairro'].', '.$nome_cidade.', '.$nome_estado);
      $response     = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$str);
      $res          = json_decode($response,true);
      $latitude  = '0';
      $longitude = '0';
      $endereco_formatado = $_POST['txt_endereco'].', '.$_POST['txt_numero'].' '.$_POST['txt_bairro'].', '.$nome_cidade.', '.$nome_estado;
      if($res['results'])
      {
          $latitude           = strval($res['results'][0]['geometry']['location']['lat']);
          $longitude          = strval($res['results'][0]['geometry']['location']['lng']);
          $endereco_formatado = $res['results'][0]['formatted_address'];
      }
      $consulta = $conexao->consulta('
      UPDATE tb_unidade SET 
      tb_unidade_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_nome'])).'",
      tb_unidade_email="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_email'])).'",
      tb_unidade_endereco="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_endereco'])).'",
      tb_unidade_numero="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_numero'])).'",
      tb_unidade_cep="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_cep'])).'",
      tb_unidade_bairro="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_bairro'])).'",
      tb_unidade_pais="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_pais'])).'",
      tb_unidade_cidade="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_cidade'])).'",
      tb_unidade_estado="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_estado'])).'",
      tb_unidade_complemento="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_complemento'])).'",
      tb_unidade_telefone="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_telefone'])).'",
      tb_unidade_login="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_login'])).'",
      tb_unidade_responsavel="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_responsavel'])).'",
      tb_unidade_depoimento="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_depoimento'])).'",
      tb_unidade_videos="'.strip_tags(mysqli_real_escape_string($conexao->obj(), $_POST['txt_videos'])).'",
      tb_unidade_latitude="'.$latitude.'",
      tb_unidade_longitude="'.$longitude.'",
      tb_unidade_endereco_formatado="'.$endereco_formatado.'"
      where tb_unidade_id = "'.$_GET['id'].'"');
      $msgSucesso = 'ok';
      } else {$msgSucesso = 'nok';
      }
		}


	if ($_GET['acao'] == 'excluir'){
		if (isset($_GET['id']))
    {			
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('DELETE FROM tb_unidade where tb_unidade_id = "'.$_GET['id'].'"');
			$msgSucesso = 'ok';
		} 
    else 
    {
      $msgSucesso = 'nok';
		}
	}
	}
?>


<?php 
	global $editardados;
		if (isset($_GET['acao'])){
			$nomeFormulario = 'Editar ';
			if ($_GET['acao'] == 'resgatar-dados') {
				$action = 'unidades/editar/'.$_GET['id'];
				
				$conexao = new Conexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_unidade 
				WHERE 
				tb_unidade_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'unidades/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'unidades/gravar';
			$nomeFormulario = 'Adicionar ';
			}

	?>

<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">
    

  <tr>
    <td width="31%"><h2>Unidades</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Unidade</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
		  <th width="638">Nome</th>
		  <th width="638">URL</th>
		  <th width="28">&nbsp;</th>
			<th width="28">&nbsp;</th>
      <th width="28">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('
	SELECT * FROM tb_unidade order by tb_unidade_nome');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
      <td><?php echo $dados['tb_unidade_nome'];?></td>
      <td><?php echo $dados['tb_unidade_login'];?></td>
      <td>
        <a href="unidades/resgatar-dados/<?php echo $dados['tb_unidade_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
			<td><a href="unidades/excluir/<?php echo $dados['tb_unidade_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
		  <td>&nbsp;</td>
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
    <td valign="top">


    <table width="100%" border="0" cellpadding="0" cellspacing="0">

	  <?php 
      if ($nomeFormulario == 'Editar ')
	  { ?>
      
        <tr>
          <td><strong>Imagem</strong></td>
        </tr>

        <tr>
          <td>      
			<?php   
            if (!empty($editardados['tb_unidade_imagem']))
            { ?>
              <img src="uploads/images/unidade/<?php echo $editardados['tb_unidade_imagem']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
            <?php 
            } else 
            { ?>
              <img src="images/thumbnail.png" width="260" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
            <?php 
            }//IF_TB_IMAGEM ?>
          </td>
        </tr>
        <tr>
          <td>
            <form action="paginas-unidade-foto-crop/<?php echo $_GET['id']?>/323/429/destaque/<?php echo $editardados['tb_unidade_login']?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
              <input type="file" class="form-control" name="image" size="30" />
              <br />
              <input type="submit" name="upload" value="Upload" class="btn btn-info" style="width:100%;" />
            </form>
          </td>
        </tr>
        
	  <?php 
	  }//if_editaR ?>

      <form action="<?php echo $action?>" method="post" id="dadoscategoria">
        <tr>
          <td width="50"><strong>Nome da Unidade</strong></td>
        </tr>
        <tr>
          <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_unidade_nome']?>" required /></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
        </tr>
        <tr>
          <td><strong>URL</strong></td>
        </tr>
        <tr>
          <td><input name="txt_login" type="text" class="form-control" id="txt_login" value="<?php echo $editardados['tb_unidade_login']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>E-mail</strong></td>
        </tr>
        <tr>
          <td><input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $editardados['tb_unidade_email']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Endereço</strong></td>
        </tr>
        <tr>
          <td><input name="txt_endereco" type="text" class="form-control" id="txt_endereco" value="<?php echo $editardados['tb_unidade_endereco']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Número</strong></td>
        </tr>
        <tr>
          <td><input name="txt_numero" type="text" class="form-control" id="txt_numero" value="<?php echo $editardados['tb_unidade_numero']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>CEP</strong></td>
        </tr>
        <tr>
          <td><input name="txt_cep" type="text" class="form-control" id="txt_cep" value="<?php echo $editardados['tb_unidade_cep']?>" required /></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Bairro</strong></td>
        </tr>
        <tr>
          <td><input name="txt_bairro" type="text" class="form-control" id="txt_bairro" value="<?php echo $editardados['tb_unidade_bairro']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Complemento</strong></td>
        </tr>
        
        <tr>
          <td><input name="txt_complemento" type="text" class="form-control" id="txt_complemento" value="<?php echo $editardados['tb_unidade_complemento']?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>País</strong></td>
        </tr>
        <tr>
          <td>
                    <input name="txt_pais" type="text" readonly class="form-control" id="txt_pais" value="Brasil" />

          
          
          
          
        <?php /*  
          
        <select name="txt_pais" id="txt_pais" class="form-control" onchange="getLocalidadeEstado(this.value, 0)">
        <?php 
        $conexao = new Conexao(); 
        if (isset($_GET['acao'])){
        if ($_GET['acao'] == 'resgatar-dados') {
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_pais WHERE tb_localidade_pais_id = "'.$editardados['tb_unidade_pais'].'"'); 
        $buscaLocalidade = $conexao->busca($consulta);	
        ?>
        <option value="<?php echo $buscaLocalidade['tb_localidade_pais_id'];?>"> <?php echo $buscaLocalidade['tb_localidade_pais_nome'];?></option>
        <?php }}
        
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_pais ORDER BY tb_localidade_pais_nome');      
        while($listaLocalidade = $conexao->busca($consulta)){?>
        <option value="<?php echo $listaLocalidade['tb_localidade_pais_id'];?>"> <?php echo $listaLocalidade['tb_localidade_pais_nome'];?></option>
        <?php } $conexao->desconectar();	?>
        </select>
        
          */ ?>
          
          
          
          
          
          
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Estado</strong></td>
        </tr>
        <tr>
          <td>
          
    	
        <select name="txt_estado" id="txt_estado" class="form-control" onchange="getLocalidadeCidade(this.value, 0)">
        <?php 
        $conexao = new Conexao(); 
        if (isset($_GET['acao'])){
        if ($_GET['acao'] == 'resgatar-dados') {
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_estado WHERE tb_localidade_estado_id = "'.$editardados['tb_unidade_estado'].'"'); 
        $buscaLocalidade = $conexao->busca($consulta);	
        ?>
        <option value="<?php echo $buscaLocalidade['tb_localidade_estado_id'];?>"> <?php echo $buscaLocalidade['tb_localidade_estado_nome'];?></option>
        <?php }}
        
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_estado ORDER BY tb_localidade_estado_nome');      
        while($listaLocalidade = $conexao->busca($consulta)){?>
        <option value="<?php echo $listaLocalidade['tb_localidade_estado_id'];?>"> <?php echo $listaLocalidade['tb_localidade_estado_nome'];?></option>
        <?php } $conexao->desconectar();	?>
        </select>
          
          
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Cidade</strong></td>
        </tr>
        <tr>
          <td>
          
        <select name="txt_cidade" id="txt_cidade" class="form-control">
        <?php 
        $conexao = new Conexao(); 
        if (isset($_GET['acao'])){
        if ($_GET['acao'] == 'resgatar-dados') {
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_cidade WHERE tb_localidade_cidade_id = "'.$editardados['tb_unidade_cidade'].'"'); 
        $buscaLocalidade = $conexao->busca($consulta);	
        ?>
        <option value="<?php echo $buscaLocalidade['tb_localidade_cidade_id'];?>"> <?php echo $buscaLocalidade['tb_localidade_cidade_nome'];?></option>
        <?php }}
        
        $consulta = $conexao->consulta('SELECT * FROM tb_localidade_cidade ORDER BY tb_localidade_cidade_nome');      
        while($listaLocalidade = $conexao->busca($consulta)){?>
        <option value="<?php echo $listaLocalidade['tb_localidade_cidade_id'];?>"> <?php echo $listaLocalidade['tb_localidade_cidade_nome'];?></option>
        <?php } $conexao->desconectar();	?>
        </select>
          
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Telefone</strong></td>
        </tr>
        <tr>
          <td><input name="txt_telefone" type="text" class="form-control" id="txt_telefone" value="<?php echo $editardados['tb_unidade_telefone']?>" required /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Responsável</strong></td>
        </tr>
        <tr>
          <td><input name="txt_responsavel" type="text" class="form-control" id="txt_responsavel" value="<?php echo $editardados['tb_unidade_responsavel']?>" /></td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Depoimento</strong></td>
        </tr>
        <tr>
          <td><input name="txt_depoimento" type="text" class="form-control" id="txt_depoimento" value="<?php echo $editardados['tb_unidade_depoimento']?>"  /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Vídeos (ainda não implementado)</strong> <small>separar por vírgula múltiplos vídeos</small></td>
        </tr>
        <tr>
          <td><input name="txt_videos" type="text" class="form-control" id="txt_videos" value="<?php echo $editardados['tb_unidade_videos']?>"  /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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