		<link href="public/js/galeria/jQuery-Impromptu/jquery-impromptu.css" rel="stylesheet" type="text/css" />
		<link href="public/js/galeria/fineuploader/fineuploader.css" rel="stylesheet" type="text/css" />
		<link href="public/js/galeria/Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>		
		<script type="text/javascript" src="public/js/galeria/jQuery-Impromptu/jquery-impromptu.js"></script>
		<script type="text/javascript" src="public/js/galeria/fineuploader/jquery.fineuploader-3.0.js"></script>
		<script type="text/javascript" src="public/js/galeria/Jcrop/jquery.Jcrop.min.js"></script>
		<script type="text/javascript" src="public/js/galeria/jquery-uberuploadcropper.js"></script>
		
		<script type="text/javascript">
		function del_img(id,id_2,id_3,param)
		{
		 $.ajax({
		        url: 'galeria.php?delete='+id+'&delete_2='+id_2+'&id='+id_3+'&param='+param,
		        success: function() {
		            alert('Deletado com Sucesso.');
		            location.reload();
		        }
		    });		
		}
		</script>
	<style type="text/css">
	.img-galeria-crop{
		display: inline-block;
		border: 1px solid transparent;
		position: relative;
		cursor: pointer;
		margin: 3px;
		overflow: hidden;
	}
	.img-galeria-crop p{
		position: absolute;
		top: 20px;
		left:0;
		bottom: 0;
		right: 0;
		margin: auto;
	    z-index: 2;
	    color: #fff;
	    text-align: center;
	    text-transform: uppercase;
	}
	.img-galeria-crop .overlay-img{
		position: absolute;
		left:0;
		bottom: -100%;
		right: 0;
		width: 100%;
		height: 30%;
		background: rgba(255,0,0,.6);
		-webkit-transition:all ease .2s;
		-moz-transition:all ease .2s;
		-ms-transition:all ease .2s;
		-o-transition:all ease .2s;
		transition:all ease .2s;
	}
	.img-galeria-crop:hover .overlay-img{
		bottom: 0;
	}
	</style>