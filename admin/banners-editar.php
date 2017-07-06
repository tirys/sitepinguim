<?php 
require_once('vendor/load.php');
if (isset($_GET['acao'])){
if ($_GET['acao'] == 'gravar'){
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('UPDATE tb_banner SET 
        tb_banner_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_banner_link="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
        tb_banner_janela="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_janela'])).'",
        tb_banner_id_tipo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'",
		    tb_banner_data_inicia="'.ConverteData($_POST['txt_data_inicializa']).'",
		    tb_banner_data_finaliza="'.ConverteData($_POST['txt_data_finaliza']).'",
		    tb_banner_descricao="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao'])).'"
        where tb_banner_id = "'.$_GET['id'].'"');
$msgSucesso = true;
}
}


//RESGATANDO DADOS DA PÁGINA ESCOLHIDA
$conexao = new Conexao(); 
$consulta = $conexao->consulta('SELECT tb_banner_tipo.*, tb_banner.* from tb_banner left join tb_banner_tipo on tb_banner_tipo.tb_banner_tipo_id = tb_banner.tb_banner_id_tipo where tb_banner.tb_banner_id = "'.$_GET['id'].'" order by tb_banner_tipo_nome desc');
$dados = $conexao->busca($consulta);
?>




<?php require_once('public/header.php');?>
    	<table width="100%" border="0" cellpadding="5">
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="5">
    <!--style="margin-top:-195px;"-->
      <form action="banners-editar/gravar/<?php echo $_GET['id']?>" method="post">
        
        <tr>
          <td width="80%"><h1>Editar Banner            </h1></td>
          <td width="20%" align="right"><input type="submit" class="btn btn-success" value="Gravar Alteração" /></td>
          </tr>
        <tr>
          <td colspan="2">
            <table width="100%" border="0" cellpadding="5">
              <tr>
                <td>Nome do Banner</td>
                <td>Link</td>
                <td>Janela</td>
                <td>Categoria</td>
                <td>Data de Início da Exibição</td>
                <td>Data de Término da Exibição</td>
                </tr>
              <tr>
                <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $dados['tb_banner_nome']?>" /></td>
                <td><input name="txt_link" type="text" class="form-control" id="txt_link" value="<?php echo $dados['tb_banner_link']?>"/></td>
                <td>
                
                  <select name="txt_janela" id="txt_janela" class="form-control">
                  	
                    <?php if ($dados['tb_banner_janela'] == "_self"){
						echo "<option value='_self' selected='selected'>Abrir na mesma janela</option>";
						}else{
						echo "<option value='_blank' selected='selected'>Abrir em uma nova janela</option>";
						}
						?>
                    <option value="_self">Abrir na mesma janela</option>
                    <option value="_blank">Abrir em uma nova janela</option>
                  </select></td>
                <td><select name="txt_tipo" id="txt_tipo" class="form-control">
                 <option value="<?php echo $dados['tb_banner_tipo_id']?>" selected="selected"><?php echo $dados['tb_banner_tipo_nome']?></option>
                  <?php 
  				// CHAMANDO DEMAIS CATEGORIAS
                $conexao = new Conexao(); 
                $consulta = $conexao->consulta('SELECT * FROM tb_banner_tipo order by tb_banner_tipo_nome');
                while($consultaCategoria = $conexao->busca($consulta)){?>
                  <option value="<?php echo $consultaCategoria['tb_banner_tipo_id']?>"><?php echo $consultaCategoria['tb_banner_tipo_nome']?></option>
                  <?php } ?>
                  </select></td>
                <td><input name="txt_data_inicializa" type="text" class="form-control" id="txt_data_inicializa" value="<?php echo DesConverteData($dados['tb_banner_data_inicia'])?>" readonly data-format="dd/MM/yyyy" />
                  </input></td>
                <td><input name="txt_data_finaliza" type="text" class="form-control" id="txt_data_finaliza" value="<?php echo DesConverteData($dados['tb_banner_data_finaliza'])?>" readonly data-format="dd/MM/yyyy" />
                  </input></td>
                </tr>
              <tr>
                <td>Descrição do Banner</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="6"><input name="txt_descricao" type="text" class="form-control" id="txt_descricao" value="<?php echo $dados['tb_banner_descricao']?>" /></td>
                </tr>
            </table></td>
        </tr>
        
        </form>
      </table>
      <h1><br />
      </h1></td>
    <td width="3%" align="right" valign="top">&nbsp;</td>
    
    <td width="19%" align="right" valign="top">
    
    <table width="170" border="0" cellpadding="5">
      <tr>
        <td width="170" bgcolor="#f2f2f2"><strong>Imagem Esquerda</strong><sub><br />
          Largura <?php echo $dados['tb_banner_tipo_largura']?>px | Altura <?php echo $dados['tb_banner_tipo_altura']?>px</sub></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f2f2f2"><?php if (isset($dados['tb_banner_imagem'])){?>
          <img src="uploads/images/banners/<?php echo $dados['tb_banner_imagem']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
          <?php } else {?>
          <img src="images/thumbnail.png" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
          <?php }?></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#f2f2f2"><form action="banners-foto-crop/<?php echo $_GET['id']?>/<?php echo $dados['tb_banner_tipo_largura']?>/<?php echo $dados['tb_banner_tipo_altura']?>/banners/<?php echo ConverteURL($dados['tb_banner_nome'])?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
          <input type="file" class="form-control" name="image" size="30" />
          <br />
          <input type="submit" name="upload" value="Upload" class="btn btn-info" />
        </form></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  </table>
<?php require_once('public/footer.php');?>

