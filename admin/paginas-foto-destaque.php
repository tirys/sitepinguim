<?php 
require_once('vendor/load.php');
//RESGATANDO DADOS DA P�?GINA ESCOLHIDA
$conexao = new Conexao(); 
$consulta = $conexao->consulta('SELECT * FROM tb_conteudo where tb_conteudo_id = "'.$_GET['id'].'"');
$dados = $conexao->busca($consulta);
				$link_automatico 	= $dados['tb_conteudo_link_automatico'];
				

//RESGATANDO DADOS DA CATEGORIA
$consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria where tb_conteudo_categoria_id = "'.$dados['tb_conteudo_categoria'].'"');
$dadosCategoria = $conexao->busca($consulta);

				$largura_foto_destaque 	= $dadosCategoria['tb_conteudo_categoria_galeria_imagem_pequena_largura'];
				$altura_foto_destaque 	= $dadosCategoria['tb_conteudo_categoria_galeria_imagem_pequena_altura'];
				$largura_foto_principal = $dadosCategoria['tb_conteudo_categoria_galeria_imagem_grande_largura'];
				$altura_foto_principal 	= $dadosCategoria['tb_conteudo_categoria_galeria_imagem_grande_altura'];

//RESGATANDO DADOS DA CATEGORIA
$consulta = $conexao->consulta('SELECT * FROM tb_conteudo_subcategoria where tb_conteudo_subcategoria_id = "'.$dados['tb_conteudo_subcategoria'].'"');
$dadosSubCategoria = $conexao->busca($consulta);
$conexao->desconectar();
?>
<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td colspan="3"><h1>Editar Foto em Destaque</h1></td>
    <td width="25%" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" valign="top"><table width="100%" border="0" cellpadding="5">
      <tr>
        <td width="20%"><?php echo $dados['tb_conteudo_titulo']?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellpadding="5">
        <tr>
          <td width="20%"><p>&nbsp;</p>
            <div id="box_popup" class="box_popup">
              <div class="bp_titulo">
                <div class="bp_titulo_1">Alterar Foto</div>
                <!--bp_titulo_1-->
                <span class="bp_fechar"><img src="public/js/crop/img/fechar.png" alt="" /></span> </div>
              <div class="bp_load">
                <div class="bp_load_1"><img src="public/js/crop/img/loader.gif" alt="" /> Carregando...</div>
                <!--bp_load_1-->
              </div>
            </div>
            <!--box_popup-->
            <div id="conteudo">
              <div class="bloco">
                <div class="img"><img class="img_1" src="<?php echo "uploads/images/conteudo/".$dados['tb_conteudo_imagem_pequena'];?>" width="<?php echo $largura_foto_destaque?>" height="<?php echo $altura_foto_destaque?>" alt="" /></div>
                <a href="javascript:;" class="btn btn-success troca_imagem_destaque">Alterar imagem</a> </div>
            </div>
            <!--conteudo-->
            &nbsp;
          </p></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </form>
</table>
<p>&nbsp;</p>

<link rel="stylesheet" type="text/css" href="public/js/crop/css/style.css"/>
<script type="text/javascript" src="public/js/crop/js/jquery.form.js"></script>
<script type="text/javascript">
  /// FUNÇÃO POPUP ALTERAR FOTO
  $(document).ready(function() {
	  $(".troca_imagem_destaque").click(function() {
			  var tabBox_1 = (".box_popup");
		  $(tabBox_1).fadeIn(300);
			  var popMargTop = ($(tabBox_1).height() + 24) / 2; 
			  var popMargLeft = ($(tabBox_1).width() + 24) / 2; 
		  $(tabBox_1).css({ 
			  'margin-top' : -popMargTop,
			  'margin-left' : -popMargLeft
		  });
		
			  $("body").append('<div id="mask"></div>');
			  $("#mask").fadeIn(300);
			  		$.post("public/js/crop/ajax/imagefile.php?nome=<?php echo $link_automatico?>&tipo=destaque&id=<?php echo $_GET['id']?>&altura=<?php echo $altura_foto_destaque?>&largura=<?php echo $largura_foto_destaque?>", function(img){
						
		  		    complete:$(".bp_load").fadeIn(0).html(img);
				});
		  return false;
	  });
	  
	    $(".bp_fechar").live('click', function() { 
		  $("#mask , #box_popup").fadeOut(300 , function(){
			  $("#mask").remove();
			  $("#box_popup").remove();
			  $("body").append('<div id="box_popup" class="box_popup"></div>');
			  $("#box_popup").append('<div class="bp_titulo"><div class="bp_titulo_1">Alterar Foto</div><span class="bp_fechar"><img src="public/js/crop/img/fechar.png" alt="" /></span></div>');
			  $("#box_popup").append('<div class="bp_load"><div class="bp_load_1"><img src="public/js/crop/img/loader.gif" alt="" />Carregando...</div></div>');
                          
		  }); 
		  
		  return false;
	  });
          
          
          
  });
  
  
  /// ENVIA A IMAGEM
  $(document).ready(function(){ 
	$('#photoimg').live('change', function(){ 
	  $(".preview").html('');
	  $(".fileinput_button").hide(0);
	  $(".fileinput_load").fadeIn(0);
	  $(".fileinput_load").html('<img src="public/js/crop/img/loader-2.gif" alt="" />');
	  $("#imageform").ajaxForm({
		target: '.preview'
	  }).submit();
	});
  }); 
</script>


<?php require_once('public/footer.php');?>




