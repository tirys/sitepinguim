<?php include"../conexao/config.php";

  
//  echo "altura: ".$_GET['largura'];
//  echo "</br>";
//  echo "altura: ".$_GET['altura'];
//  echo "</br>";  
//  echo "nome: ".$_GET['nome'];
//  echo "</br>";  
//  echo "tipo: ".$_GET['tipo'];

?>

<div class="imagefile">
    <div class="preview"></div>
    
    <span class="fileinput_button">
        <img src="js/crop/img/botao_input_file.png" alt="" />
        <form id="imageform" method="post" enctype="multipart/form-data" action="js/crop/ajax/imageform.php?nome=<?php echo $_GET['nome']?>&tipo=<?php echo $_GET['tipo']?>&id=<?php echo $_GET['id'];?>&altura=<?php echo $_GET['altura'];?>&largura=<?php echo $_GET['largura'];?>">
            <input type="file" id="photoimg" name="photoimg" />
        </form>
    </span>
    
    <div class="fileinput_load"></div>
</div><!--imagefile-->

