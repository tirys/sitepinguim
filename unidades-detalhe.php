<!DOCTYPE html>
<html lang="pt-br">
	<head>
    	<?php include_once("inc_head.php"); ?>
	</head>
	<body class="interna">

		<?php include('inc_topo.php'); ?>
		
		<section class="fundo-interna">
			<h2>Unidade São José do Rio Preto</h2>
			<nav class="breadcrumb">
				<a href="index.php">Home</a>
				<a href="unidades-listagem.php">Unidades</a>
				<span>Unidade São José do Rio Preto</span>
			</nav>
		</section>

        <div id="mapa" style="width: 100%; height: 300px;"></div>
		
		<main id="unidades">
			<section class="container">
				<div class="row">
					<div class="col-md-6 col-md-push-6 interna-texto">
						<h3 class="titulo-principal"><small>Unidades</small>Unidade São José do Rio Preto</h3>
                        <strong class="fz18 display-block"><i class="fa fa-phone"></i> Telefone</strong>
                        <p>(17) 3304-0772</p>
                        <strong class="fz18 display-block"><i class="fa fa-envelope"></i> Email</strong>
                        <a href="mailto:contato@moveismaschieto.com.br">contato@moveismaschieto.com.br</a>
                        <strong class="fz18 display-block"><i class="fa fa-map-marker"></i> Endereço</strong>
                        <p>Rod. Roberto Mário Perosa, KM 11.5, Ibirá - SP, 15860-000</p>
					</div>
					<div class="col-md-6 col-md-pull-6">
		                <div class="slick-1item">
							<div>
								<div class="embed-responsive embed-responsive-16by9">
									<iframe width="560" height="315" src="https://www.youtube.com/embed/RzUPDekoR4U" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                    <div>
		                        <a href="images/img-interna.jpg" class="fancybox" rel="gallery">
		                            <img src="images/img-interna.jpg" alt="Nome do Produto" title="Nome do Produto">
		                        </a>
		                    </div>
		                </div>
					</div>
				</div>
			</section>
		</main>
		<?php include('inc_rodape.php'); ?>

		    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1ULS0scKPvY9pUPdKte5A97sTwqVtzO8&libraries=places"></script>
		    <script type="text/javascript">
		    //Google Map API
		        function initialize() {
		          var image = 'images/icone-mapa.png'; //ICONE
		          var endereco = 'Rod. Roberto Mário Perosa, KM 11.5, Ibirá - SP, 15860-000' // ENDEREÇO DO MAPA
        		  //var styles = [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}];
		          var mapOptions = {
	          		//styles,
		            zoom: 17, 
		            scrollwheel:true,
		            mapTypeId: google.maps.MapTypeId.ROADMAP
		          };
		          var map = new google.maps.Map(document.getElementById('mapa'), mapOptions);  
		          geocoder = new google.maps.Geocoder();      
		          geocoder.geocode({'address':endereco}, function(results, status){ 
		              if( status = google.maps.GeocoderStatus.OK){
		                  latlng = results[0].geometry.location;
		                  var marker = new google.maps.Marker({
		                      position: latlng,
		                      map: map,
		                      //icon: image,
		                      title: 'Fort3' //NOME DA UNIDADE
		                  });     
		                  map.setCenter(latlng); 
		              }
		          });  
		        }
		        google.maps.event.addDomListener(window, 'load', initialize);
		    </script> 

	</body>
</html>
