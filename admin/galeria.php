<?php
require_once('vendor/load.php');
require_once('public/header.php');
if(isset($_GET['delete']))
{
	if($_GET['param']=='appended')
	{
		$conexao3 = new Conexao();
		$consulta3 = $conexao3->consulta('DELETE FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = "'.$_GET['id'].'" AND tb_galeria_foto_id = last_insert_id()');
									//DELETE FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo =  '332'
	}
	else
	{
		$conexao3 = new Conexao();
		$consulta3 = $conexao3->consulta('DELETE FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = "'.$_GET['id'].'" AND tb_galeria_foto_id = "'.$_GET['param'].'"');

	}
	unlink($_GET['delete']);
	unlink($_GET['delete_2']);

}
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('SELECT tb_conteudo.*, tb_conteudo_categoria.* from tb_conteudo left join tb_conteudo_categoria on tb_conteudo_categoria.tb_conteudo_categoria_id=tb_conteudo.tb_conteudo_categoria where tb_conteudo.tb_conteudo_id = "'.$_GET['id'].'"');
	$DadosConteudo = $conexao->busca($consulta);
	$conexao->desconectar();

	$dimensao_g = $DadosConteudo['tb_conteudo_categoria_galeria_foto_grande_largura'].'x'.$DadosConteudo['tb_conteudo_categoria_galeria_foto_grande_altura'];
	$dimensao_p = $DadosConteudo['tb_conteudo_categoria_galeria_foto_pequena_largura'].'x'.$DadosConteudo['tb_conteudo_categoria_galeria_foto_pequena_altura'];
	$nome = $DadosConteudo['tb_conteudo_link_automatico'];
	
	$largura_original 	= $DadosConteudo['tb_conteudo_categoria_galeria_foto_grande_largura'];
	$altura_original 	= $DadosConteudo['tb_conteudo_categoria_galeria_foto_grande_altura'];

	$nova_largura    	= $largura_original*0.5; 

	$nova_altura = ($altura_original/$largura_original)*$nova_largura;

	$ratio = ($largura_original/$altura_original);

	include_once('public/js/galeria/scripts.php');
?>
<script type="text/javascript">
			$(function() {
				$('#UploadImages').uberuploadcropper({
					//---------------------------------------------------
					// uploadify options..
					//---------------------------------------------------
					fineuploader: {
						//debug : true,
						request	: { 
							// params: {}
							endpoint: 'public/js/galeria/upload.php?id=<?=$_GET["id"]?>&d_p=<?=$dimensao_p?>&d_g=<?=$dimensao_g?>&nome=<?=$nome?>' 
						},						
						validation: {
							//sizeLimit	: 0,
							allowedExtensions: ['jpg','jpeg','png','gif']
						}
					},
					//---------------------------------------------------
					//now the cropper options..
					//---------------------------------------------------
					jcrop: {
						aspectRatio  : <?=$ratio?>, 
						allowSelect  : false, //can reselect
						allowResize  : true,  //can resize selection
						setSelect    : [ 0, 0, <?=$nova_largura?>, <?=$nova_altura?> ], //these are the dimensions of the crop box x1,y1,x2,y2
						minSize      : [ 200, 200 ], //if you want to be able to resize, use these
						maxSize      : [ 900, 900 ]
					},
					//---------------------------------------------------
					//now the uber options..
					//---------------------------------------------------
					folder           : 'uploads/images/galeria/', // only used in uber, not passed to server
					cropAction       : 'public/js/galeria/crop.php', // server side request to crop image
					onComplete       : function(e,imgs,data){ 
						var $PhotoPrevs = $('#PhotoPrevs');
						for(var i=0,l=imgs.length; i<l; i++)
						{
							var src = '\''+ String('uploads/images/galeria/'+ imgs[i].filename)+'\'';
							var src_2 = '\''+ String('uploads/images/galeria/'+'thumbnail_'+imgs[i].filename)+'\'';
							var param = '\''+'appended'+'\'';
							$PhotoPrevs.append('<div class="img-galeria-crop" onclick="return del_img('+src+','+src_2+',<?=$_GET["id"]?>,'+param+')"><img src="uploads/images/galeria/'+'thumbnail_'+imgs[i].filename +'?d='+ (new Date()).getTime() +'" /><div class="overlay-img"><p>Excluir</p></div></div>');
							$('#actual_insert').load("tools/galeria_insere.php?id=<?=$_GET['id']?>&src="+imgs[i].filename);
							setTimeout(function(){ location.reload(); }, 1000);

						}
					}
				});
				
			});
		</script>
	<body>
<a style="margin-left:10px;" href="paginas-editar/resgatar-dados/<?php echo $_GET['id'];?>"><span><i class="fa fa-arrow-left"></i></span> Conteudo</a>          
		<div id="wrapper">
			<h1>Galeria de Imagens</h1>
			<div id="msg" class="well"><h4>Arraste uma imagem abaixo ou selecione os arquivos manualmente </h4></div>
			
			<div id="actual_insert" ></div>	
			<div id="UploadImages">
				<noscript>Por favor, ative o JavaScript para poder manipular as imagens.</noscript>
			</div>

			<div id="PhotoPrevs">
			<?php
			$id = $_GET['id'];
			$conexao2 = new Conexao();
			$sql = 'SELECT * FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = "'.$id.'"';
			$consulta2 = $conexao2->consulta($sql);
			while($dados2 = $conexao2->busca($consulta2))
				{ 
				$src = 		'uploads/images/galeria/'.$dados2['tb_galeria_foto_nome'];
				$src_2 = 	'uploads/images/galeria/'.$dados2['tb_galeria_foto_nome_thumb'];
				?>
 			<div class="img-galeria-crop" onclick="return del_img('<?=$src?>','<?=$src_2?>',<?=$_GET['id']?>,<?=$dados2['tb_galeria_foto_id']?>)">
				<img  src="uploads/images/galeria/<?=$dados2['tb_galeria_foto_nome_thumb']?>" /> 
				<div class="overlay-img"><p>Excluir</p></div>
			</div>
			<?php }
			?>
			</div>
		</div>
	</body>


