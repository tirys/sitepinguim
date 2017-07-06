<?php
  session_start();
  include"../conexao/config.php";
    
  /// ID SESSÃO
  $id_session = 1;
  
//  echo "altura: ".$_GET['largura'];
//  echo "</br>";
//  echo "altura: ".$_GET['altura'];
//  echo "nome: ".$_GET['nome'];
  
  /// POST
  $largura = $_POST['largura'];
  $altura  = $_POST['altura'];

  /// PEGA A IMAGEM ATUAL
  $sql_crop = mysql_query("SELECT tb_conteudo_imagem_temporaria FROM tb_conteudo WHERE tb_conteudo_id = '".$_GET['id']."'") or die(mysql_error());
			  $res_crop = mysql_fetch_array($sql_crop);
						  $img_temp  = $res_crop['tb_conteudo_imagem_temporaria'];
?>
<script type="text/javascript" src="js/crop/js/jquery.Jcrop.js"></script>
<style type="text/css">
.box_crop{width:auto; height:auto; float:left;}
.box_crop .box_crop_titulo{width:620px; height:30px; float:left; font:12px Verdana, Arial, Helvetica, sans-serif; color:#444;}
.box_crop .box_crop_titulo span{width:auto; height:auto; float:left; margin:7px 0 0 10px}
.box_crop .box_crop_img{width:600px; height:400px; float:left; margin:0 10px 3px 10px;}
.box_crop .box_crop_img .box_crop_img_2{width:auto; height:auto; float:left;}
.box_crop .box_crop_btn{width:620px; height:42px; float:left;}
.box_crop .box_crop_btn .cropform_load{width:16px; height:11px; float:left; margin:16px 0 0 13px;}
.box_crop .box_crop_btn .cropform_retorno{width:200px; height:15px; float:left; margin:14px 0 0 13px; font:11px Verdana, Arial, Helvetica, sans-serif; color:#F00;}
#botao{width:auto; height:auto; float:left; padding:8px 14px; border:1px solid #DDD; background:#79B0D5; font:11px Verdana, Arial, Helvetica, sans-serif; color:#FFF; font-weight:bold;}
.jcrop-holder{direction:ltr; text-align:left;}
.jcrop-vline,.jcrop-hline{background:#FFF url(Jcrop.gif) top left repeat;font-size:0;position:absolute;}
.jcrop-vline{height:100%;width:1px!important;}
.jcrop-hline{height:1px!important;width:100%;}
.jcrop-vline.right{right:0;}
.jcrop-hline.bottom{bottom:0;}
.jcrop-handle{background-color:#333;border:1px #eee solid;font-size:1px;}
.jcrop-tracker{height:100%; width:100%; -webkit-tap-highlight-color:transparent; -webkit-touch-callout:none; -webkit-user-select:none;}
.jcrop-handle.ord-n{left:50%;margin-left:-4px;margin-top:-4px;top:0;}
.jcrop-handle.ord-s{bottom:0;left:50%;margin-bottom:-4px;margin-left:-4px;}
.jcrop-handle.ord-e{margin-right:-4px;margin-top:-4px;right:0;top:50%;}
.jcrop-handle.ord-w{left:0;margin-left:-4px;margin-top:-4px;top:50%;}
.jcrop-handle.ord-nw{left:0;margin-left:-4px;margin-top:-4px;top:0;}
.jcrop-handle.ord-ne{margin-right:-4px;margin-top:-4px;right:0;top:0;}
.jcrop-handle.ord-se{bottom:0;margin-bottom:-4px;margin-right:-4px;right:0;}
.jcrop-handle.ord-sw{bottom:0;left:0;margin-bottom:-4px;margin-left:-4px;}
.jcrop-dragbar.ord-n,.jcrop-dragbar.ord-s{height:7px;width:100%;}
.jcrop-dragbar.ord-e,.jcrop-dragbar.ord-w{height:100%;width:7px;}
.jcrop-dragbar.ord-n{margin-top:-4px;}
.jcrop-dragbar.ord-s{bottom:0;margin-bottom:-4px;}
.jcrop-dragbar.ord-e{margin-right:-4px;right:0;}
.jcrop-dragbar.ord-w{margin-left:-4px;}
.jcrop-light .jcrop-vline,.jcrop-light .jcrop-hline{background:#FFF; filter:Alpha(opacity=70)!important; opacity:.70!important;}
.jcrop-light .jcrop-handle{-moz-border-radius:3px; -webkit-border-radius:3px; background-color:#000; border-color:#FFF; border-radius:3px;}
.jcrop-dark .jcrop-vline,.jcrop-dark .jcrop-hline{background:#000; filter:Alpha(opacity=70)!important; opacity:.7!important;}
.jcrop-dark .jcrop-handle{-moz-border-radius:3px; -webkit-border-radius:3px; background-color:#FFF; border-color:#000; border-radius:3px;}
.jcrop-holder img,img.jcrop-preview{max-width:none;}
</style>

<script language="Javascript">
  /// ENVIA A IMAGEM RECORTADA
  $(document).ready(function(){ 
	$(".cropform_btn").click(function(){
	  $(".cropform_btn").hide(0);
	  $(".cropform_btn_2").fadeIn(0);
	  $(".cropform_retorno").html('');
	  $(".cropform_load").fadeIn(0);
	  $(".cropform_load").html('<img src="js/crop/img/loader-facebook.gif" alt="" />');
	  $("#cropform").ajaxForm({
		target: '.cropform_retorno'
	  });
	});
  });

  /// PEGA AS DISMENSÕES DA IMAGEM PARA RECORTE
  $(function(){
	  $('#cropbox').Jcrop({
		  aspectRatio: <?php echo $_GET['largura']?> / <?php echo $_GET['altura']?>,
		  setSelect: [ 0, 0, <?php echo $_GET['largura']?>, <?php echo $_GET['altura']?> ],
		  bgOpacity: 0.7,
		  bgColor: '#000',
		  addClass: 'jcrop-light',
		  onSelect: updateCoords
	  });
  });
  function updateCoords(c){
	  $('#x').val(c.x);
	  $('#y').val(c.y);
	  $('#w').val(c.w);
	  $('#h').val(c.h);
  };
</script>

<div class="box_crop">
    <div class="box_crop_titulo">
        <span>Para recortar esta imagem, arraste a área abaixo e, em seguida, clique em "Definir fotografia".</span>
    </div><!--box_crop_titulo-->
  
    <div class="box_crop_img">
    	<?php
		/// ALINHAR IMAGEM
		$top  = (402 - $altura) / 2;
		$left = (602 - $largura) / 2;
		?>
    	<div class="box_crop_img_2" style="margin:<?php echo $top;?>px 0 0 <?php echo $left;?>px;">
            <img id="cropbox" src="../uploads/images/conteudo/temp/<?php echo $img_temp;?>" alt="" />
        </div><!--box_crop_img_2-->
    </div><!--box_crop_img-->
    
    <div class="box_crop_btn">
        <form id="cropform" method="post" enctype="multipart/form-data" action="js/crop/ajax/cropform.php?nome=<?php echo $_GET['nome']?>&tipo=<?php echo $_GET['tipo']?>&id=<?php echo $_GET['id'];?>&altura=<?php echo $_GET['altura'];?>&largura=<?php echo $_GET['largura'];?>">
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <input type="submit" class="cropform_btn" id="botao" style="float:left; margin:7px 0 0 10px;" value="Definir fotografia" />
        </form>
        	<!--Botão_falso-->
            <input type="submit" class="cropform_btn_2" id="botao" style="float:left; margin:7px 0 0 10px; display:none;" value="Definir fotografia" />
        <div class="cropform_load"></div>
        <div class="cropform_retorno"></div>
    </div><!--box_crop_btn-->
</div><!--box_crop-->