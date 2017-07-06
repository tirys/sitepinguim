<?php 
require_once('vendor/load.php');

header('Content-Type: text/html; charset=utf-8');

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar'){

	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('INSERT INTO tb_banner (
		tb_banner_nome,
		tb_banner_link,
		tb_banner_janela,
		tb_banner_id_tipo,
		tb_banner_data_inicia,
		tb_banner_data_finaliza,
		tb_banner_descricao		
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_janela'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_tipo'])).'",
        "'.ConverteData($_POST['txt_data_inicializa']).'",
        "'.ConverteData($_POST['txt_data_finaliza']).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao'])).'"		
		)');		

header ("location: ../../banners/listar/".$_POST['txt_tipo']);

$msgSucesso = true;
	}
}

?>

<?php require_once('public/header.php');?>


	<script type="text/javascript">
		function getValor(valor){
			$("#txt_subcategoria").html("<option value='0'>Carregando...</option>");
			setTimeout(function(){
				document.getElementById('txt_subcategoria').style.display = 'block';
				$("#txt_subcategoria").load("tools/filtro_subcategoria.php",{id:valor})
			}, 100);

		};
    </script>
   

<table width="100%" border="0" cellpadding="5">
<form action="banners-adicionar/gravar/<?php echo $_GET['id']?>" method="post">
  <tr>
    <td colspan="3"><h1>Novo Banner</h1></td>
    <td width="37%" align="right">
     
      
    
    </td>
    <td width="7%" align="right"><input type="submit" class="btn btn-success" value="Criar Banner" /></td>
  </tr>
  <tr>
    <td colspan="5"><table width="100%" border="0" cellpadding="5">
      <tr>
        <td>Nome do Banner</td>
        <td>Link</td>
        <td>Janela</td>
        <td>Categoria</td>
        <td>Data de Início da Exibição</td>
        <td>Data de Término da Exibição</td>
        </tr>
      <tr>
        <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php if (isset($_POST['txt_nome'])){echo $_POST['txt_nome'];}?>" /></td>
        <td><input name="txt_link" type="text" class="form-control" id="txt_link" value="<?php if (isset($_POST['txt_texto_curto'])){echo $_POST['txt_texto_curto'];}?>"/></td>
        <td>
          
          <!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS --><!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS -->
          
          <select name="txt_janela" id="txt_janela" class="form-control">
            <option value="_self">Abrir na mesma janela</option>
            <option value="_blank">Abrir em uma nova janela</option>
        </select></td>
        <td><select name="txt_tipo" id="txt_tipo" class="form-control">
          
          <?php 
				// CHAMANDO DEMAIS CATEGORIAS
                $conexao = new Conexao(); 
                $consulta = $conexao->consulta('SELECT * FROM tb_banner_tipo order by tb_banner_tipo_nome');
                while($consultaCategoria = $conexao->busca($consulta)){?>
          <option value="<?php echo $consultaCategoria['tb_banner_tipo_id']?>"><?php echo $consultaCategoria['tb_banner_tipo_nome']?></option>
          <?php } ?>
          </select>
          
        </td>
        <td><input data-format="dd/MM/yyyy" name="txt_data_inicializa" id="txt_data_inicializa" type="text" class="form-control" readonly />
          </input></td>
        <td>
        
           <input data-format="dd/MM/yyyy" name="txt_data_finaliza" id="txt_data_finaliza" type="text" class="form-control" readonly></input>
        </td>
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
        <td colspan="6"><input name="txt_descricao" type="text" class="form-control" id="txt_descricao" value="<?php if (isset($_POST['txt_descricao'])){echo $_POST['txt_descricao'];}?>" /></td>
        </tr>
      </table></td>
    </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="16%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </form>
</table>
<p>&nbsp;</p>


<?php require_once('public/footer.php');?>