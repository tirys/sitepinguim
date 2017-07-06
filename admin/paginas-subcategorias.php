<style>
.glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>
<?php 
require_once('vendor/load.php');
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('
		INSERT into tb_conteudo_subcategoria (
		tb_conteudo_subcategoria_nome,
		tb_conteudo_subcategoria_id_categoria,
		tb_conteudo_subcategoria_url,
		tb_conteudo_subcategoria_palavras_chaves_busca,
		tb_conteudo_subcategoria_descricao_busca,
    tb_conteudo_subcategoria_ordem
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_id_categoria'])).'",
		"'.ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_url'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])).'",
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_ordem'])).'"

		)');

//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR
        if(isset($_POST['formNome']) && isset($_POST['formVal']))
        {
            $a_txt_nome_caracteristica = $_POST['formNome'];
            $a_txt_valor_caracteristica = $_POST['formVal'];
            //rint_r($a_txt_valor_caracteristica);
            $id = mysql_insert_id();
                foreach(array_combine($a_txt_nome_caracteristica,$a_txt_valor_caracteristica) as $nome=>$val )
                {
                    $consulta = $conexao->consulta('
                    INSERT INTO tb_caracteristicas (
                    tb_caracteristicas_tipo,
                    tb_caracteristicas_categoria,
                    tb_caracteristicas_subcategoria,
                    tb_caracteristicas_nome,
                    tb_caracteristicas_valor_padrao
                    ) VALUES (
                    "NULL",
                    "NULL",
                    "'.$id.'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$nome)).'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$val)).'"
                     )'
                     );
                }

         }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR


		$msgSucesso = 'ok';
	}
	
	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_GET['id'])){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			UPDATE tb_conteudo_subcategoria SET 
			tb_conteudo_subcategoria_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
			tb_conteudo_subcategoria_id_categoria="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_id_categoria'])).'",
			tb_conteudo_subcategoria_url="'.ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_url'])).'",
      tb_conteudo_subcategoria_palavras_chaves_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])).'",
      tb_conteudo_subcategoria_descricao_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])).'",
      tb_conteudo_subcategoria_ordem="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_ordem'])).'"
			where tb_conteudo_subcategoria_id = "'.$_GET['id'].'"');
		
    	//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

             if(isset($_POST['formNome']) && isset($_POST['formVal']))
        {
            $a_txt_nome_caracteristica = $_POST['formNome'];
            $a_txt_valor_caracteristica = $_POST['formVal'];
            //rint_r($a_txt_valor_caracteristica);
                foreach(array_combine($a_txt_nome_caracteristica,$a_txt_valor_caracteristica) as $nome=>$val )
                {
                    $consulta = $conexao->consulta('
                    INSERT INTO tb_caracteristicas (
                    tb_caracteristicas_tipo,
                    tb_caracteristicas_categoria,
                    tb_caracteristicas_subcategoria,
                    tb_caracteristicas_nome,
                    tb_caracteristicas_valor_padrao
                    ) VALUES (
                    "NULL",
                    "NULL",
                    "'.$_GET['id'].'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$nome)).'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$val)).'"
                     )'
                     );
                }
         }
            if(isset($_POST['txt_nome_cad_1']))
            {

              $count_concatenado =trim($_POST['txt_array_cad']);
              $cads = explode('-',$count_concatenado);
              foreach($cads as $cad)
              {

                  $post_nome = 'txt_nome_cad_'.$cad;
                  $post_value = 'txt_valor_cad_'.$cad;
                  $consulta = $conexao->consulta('UPDATE tb_caracteristicas SET 
                  tb_caracteristicas_tipo = "NULL",
                  tb_caracteristicas_categoria = "NULL",
                  tb_caracteristicas_subcategoria = "'.$_GET['id'].'",
                  tb_caracteristicas_nome = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_nome])).'",
                  tb_caracteristicas_valor_padrao = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_value])).'"
                  WHERE tb_caracteristicas_id = "'.$_POST['txt_id_cad_'.$cad].'"'); 
              }
            }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR


      }//id
			$msgSucesso = 'ok';
	}
	
	
	
	
	
	if ($_GET['acao'] == 'excluir'){

	
		if (isset($_GET['id'])){
					
		$conexao = new Conexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_conteudo where tb_conteudo_subcategoria = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
			if (empty($constaLigacao)){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_conteudo_subcategoria where tb_conteudo_subcategoria_id = "'.$_GET['id'].'"');
      //-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

                $consulta = $conexao->consulta('DELETE  FROM tb_caracteristicas WHERE tb_caracteristicas_subcategoria ="'.$_GET['id'].'"');

//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR


			$msgSucesso = 'ok';
		} else {$msgSucesso = 'nok';}
		}
		
	}
}
?>


<?php 
	global $editardados;
		if (isset($_GET['acao'])){
			$nomeFormulario = 'Editar ';
			if ($_GET['acao'] == 'resgatar-dados') {
				$action = 'paginas-subcategorias/editar/'.$_GET['id'];
				
				$conexao = new Conexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_conteudo_subcategoria 
				WHERE 
				tb_conteudo_subcategoria_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'paginas-subcategorias/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'paginas-subcategorias/gravar';
			$nomeFormulario = 'Adicionar ';
			}

	?>

<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

    

  <tr>
    <td width="31%"><h2>Sub-Categoria</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Sub-Categoria</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
			<th width="390">Nome da Sub-Categoria</th>
			<th width="346">URL Amigável</th>
			<th width="346">Categoria da Página</th>
			<th width="29">&nbsp;</th>
			<th width="31">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('
	SELECT tb_conteudo_subcategoria.*, tb_conteudo_categoria.* 
	FROM tb_conteudo_subcategoria LEFT JOIN tb_conteudo_categoria 
	ON tb_conteudo_subcategoria.tb_conteudo_subcategoria_id_categoria = tb_conteudo_categoria.tb_conteudo_categoria_id
	');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
			<td><?php echo $dados['tb_conteudo_subcategoria_id'];?> - <?php echo $dados['tb_conteudo_subcategoria_nome'];?></td>
			<td><?php echo $dados['tb_conteudo_subcategoria_url'];?></td>
			<td><?php echo $dados['tb_conteudo_categoria_nome'];?></td>
			<td>
		    <a href="paginas-subcategorias/resgatar-dados/<?php echo $dados['tb_conteudo_subcategoria_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
			<td><a href="paginas-subcategorias/excluir/<?php echo $dados['tb_conteudo_subcategoria_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
		  </tr>
    <?php } $conexao->desconectar();	?>
        
	
	</tbody>
	<tfoot>
		<tr>
			<th>Nome da Sub-Categoria</th>
			<th>URL Amigável</th>
			<th>Categoria da Página</th>
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
    
    
    
  
      <tr>
        <td>
        
        
        <?php 
		  if ($nomeFormulario == 'Editar '){
		  if (isset($editardados['tb_conteudo_subcategoria_imagem'])){?>
          <tr>
          <td colspan="2"><strong>Imagem</strong></td>
        </tr>
        <tr>
          <td colspan="2"> 
		<img src="uploads/images/subcategoria/<?php echo $editardados['tb_conteudo_subcategoria_imagem']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
        
		<?php } else {?>
        <img src="images/thumbnail.png" width="260" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
        <?php }?>
        <form action="paginas-subcategoria-foto-crop/<?php echo $_GET['id']?>/450/350/destaque/<?php echo $editardados['tb_conteudo_subcategoria_url']?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
          <input type="file" class="form-control" name="image" size="30" />
          <br />
          <input type="submit" name="upload" value="Upload" class="btn btn-info" style="width:100%;" />
        </form>
        <hr>
        <?php }?>
        </table>
        
        <form action="<?php echo $action?>" method="post">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Nome da Nova Categoria</td>
      </tr>
      <tr>
        <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_conteudo_subcategoria_nome']?>" required />
          <br /></td>
      </tr>
      <tr>
        <td>URL Amigável</td>
      </tr>
      <tr>
        <td><input name="txt_url" type="text" class="form-control" id="txt_url" value="<?php echo $editardados['tb_conteudo_subcategoria_url']?>" required /></td>
      </tr>
<tr>
        <td>Ordem</td>
      </tr>
      <tr>
        <td>
          <input name="txt_ordem" type="number" min="0" step="1" max="99" class="form-control" id="txt_ordem" value="<?php echo $editardados['tb_conteudo_subcategoria_ordem']?>" required />
        </td>
      </tr>      <tr>
        <td>Categoria da Página</td>
      </tr>
      <tr>
        <td>

    	<select name="txt_id_categoria" id="txt_id_categoria" class="form-control">
        
        
		<?php 
        $conexao = new Conexao(); 
            if (isset($_GET['acao'])){
            if ($_GET['acao'] == 'resgatar-dados') {
	        $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id = "'.$editardados['tb_conteudo_subcategoria_id_categoria'].'"'); 
			$buscaNomeCategoria = $conexao->busca($consulta);	
			?> 
            <option value="<?php echo $buscaNomeCategoria['tb_conteudo_categoria_id'];?>">
            <?php echo $buscaNomeCategoria['tb_conteudo_categoria_nome'];?>
            </option>
            <?php }}
		
          $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria ORDER BY tb_conteudo_categoria_nome');      
          while($listaCategoria = $conexao->busca($consulta)){?>
        <option value="<?php echo $listaCategoria['tb_conteudo_categoria_id'];?>">
        <?php echo $listaCategoria['tb_conteudo_categoria_nome'];?>
        </option>
        <?php } $conexao->desconectar();	?>
        </select>
        
        
        <br /></td>
      </tr>
      <tr>
        <td align="left">Palavras-Chaves</td>
      </tr>
      <tr>
        <td align="left"><input name="txt_palavra_chave" type="text" class="form-control" id="txt_palavra_chave" value="<?php echo $editardados['tb_conteudo_subcategoria_palavras_chaves_busca']?>" required /></td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">Descrição para mecanismos de pesquisa</td>
      </tr>
      <tr>
        <td align="left"><input name="txt_descricao_busca" type="text" class="form-control" id="txt_descricao_busca" value="<?php echo $editardados['tb_conteudo_subcategoria_descricao_busca']?>" required /></td>
      </tr>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->
            <tr>
              <td colspan="2"><strong>Características:<br/><br/></strong>
            </tr>
                <?php
                $str = "";
                if(isset($_GET['id']) && $_GET['acao'] != 'editar'){
                $id = $_GET['id'];
                $conexao =  new Conexao();
                
                //derramar categoria
                $consulta_categoria = $conexao->consulta('SELECT `tb_caracteristicas_id`,`tb_caracteristicas_nome`,`tb_caracteristicas_valor_padrao` 
                FROM `tb_caracteristicas` WHERE `tb_caracteristicas_categoria` ="'.$editardados['tb_conteudo_subcategoria_id_categoria'].'"');
                $conta_categoria = $conexao->conta($consulta_categoria);
                if($conta_categoria){
                  echo '<tr><td colspan="2"><strong><br/><br/>Características Herdadas:<br/><br/></strong></tr>';
                  while($dados_categoria = $conexao->busca($consulta_categoria))
                  { ?>
                    <tr>
                      <td colspan="2"><label>Nome</label>
                        <input  type="text" disabled class="form-control" style="background-color:gray; color:#fff;"  value="<?=$dados_categoria['tb_caracteristicas_nome']?>"  /><br/></td>
                    </tr>
                    <tr>
                      <td colspan="2"><label>Valor</label>
                        <input  type="text" disabled class="form-control" style="background-color:gray; color:#fff;"  value="<?=$dados_categoria['tb_caracteristicas_valor_padrao']?>"  /></td>
                    </tr>
                <?php  }//while

                }//if de validação de caracteristicas da categoria*/

                //derramar tipo
                $consulta_specif = $conexao->consulta('SELECT `tb_conteudo_categoria_id_tipo` FROM `tb_conteudo_categoria` WHERE `tb_conteudo_categoria_id` = "'.$editardados['tb_conteudo_subcategoria_id_categoria'].'" ');
                $dados_specif =$conexao->busca($consulta_specif);                 
                $consulta_tipo = $conexao->consulta('SELECT `tb_caracteristicas_id`, `tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` 
                  FROM `tb_caracteristicas` WHERE `tb_caracteristicas_tipo` = "'.$dados_specif['tb_conteudo_categoria_id_tipo'].'" ');

                $conta_tipo = $conexao->conta($consulta_tipo);
                if($conta_tipo)
                {
                  
                  while($dados_tipo = $conexao->busca($consulta_tipo))
                  { ?>
                    <tr>
                      <td colspan="2"><label>Nome</label>
                        <input  type="text" disabled class="form-control" style="background-color:gray; color:#fff;"  value="<?=$dados_tipo['tb_caracteristicas_nome']?>"  /><br/></td>
                    </tr>
                    <tr>
                      <td colspan="2"><label>Valor</label>
                        <input  type="text" disabled class="form-control" style="background-color:gray; color:#fff;"  value="<?=$dados_tipo['tb_caracteristicas_valor_padrao']?>"  /></td>
                    </tr>


                <?php  }//while

                }//if de validação de caracteristicas do tipo*/

                $consulta = $conexao->consulta("SELECT `tb_caracteristicas_id`, `tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM `tb_caracteristicas` WHERE `tb_caracteristicas_subcategoria` ='$id' ");
                $i = 0;
                $str = " ";

                while($data = $conexao->busca($consulta))
                { 
                    $i++;
                    ?>
                    <tbody id="caracteristica_container_<?=$i?>">
                    <tr>
                      <td colspan="2"><label>Nome</label>
                        <input name="txt_nome_cad_<?=$i?>" type="text" class="form-control" id="txt_nome_cad_<?=$i?>" value="<?=$data['tb_caracteristicas_nome']?>" required /><br/></td>
                    </tr>
                    <tr>
                      <td colspan="2"><label>Valor</label>
                        <input name="txt_valor_cad_<?=$i?>" type="text" class="form-control" id="txt_valor_cad_<?=$id?>" value="<?=$data['tb_caracteristicas_valor_padrao']?>" required /></td>
                    </tr>
                    <tr><td><br/><input type="button" onclick="processaExclusao(<?=$i?>,<?=$data['tb_caracteristicas_id']?>)" class="btn btn-danger btn-xs" style="float:left;" value="Excluir Característica" /><div style="float:left; margin-left:10px;" id="span_cont"></div><hr></td><tr/>
                    <input type="hidden" name="txt_id_cad_<?=$i?>" value="<?=$data['tb_caracteristicas_id']?>" />
                    </tbody>    
                
              <?php  
                 $str .= $i.'-';
                        }
                    }
                ?>
            <tr>
                 <input type="hidden" id="txt_array_cad" class="form-control" name="txt_array_cad" value='<?=$str?>' />
                <td colspan="2"><button type="button" id="btn_add" class="btn btn-info" style="margin-top:25px;"><b><span>Adicionar Características</span></b></button></td>
            </tr>
            <tbody id="addlist_car" style="margin:5px 0;">
             </tbody>   
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->

      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><input type="submit" class="btn btn-success" value="Gravar" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
      </form>
    
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->
<script type="text/javascript">
var hold_id = -1;
 $('#btn_add').click(function()
{
  hold_id++;
  
  var out_placeholder = 'Nome da Característica '+(hold_id+1);
  var out_placeholder_2 = 'Valor Padrão '+(hold_id+1);


  $("<tr><td colspan='2' style='display:block; width:100%'><label>Nome</label><input name='formNome[]' type='text' class='form-control' id='formNome[]'  placeholder='"+out_placeholder+"' required /></td></tr><hr><tr><td colspan='2' style='display:block; width:100%'><label>Valor Padrão</label><input name='formVal[]' type='text' class='form-control' id='formVal[]'  placeholder='"+out_placeholder_2+"' required /></td></tr>").appendTo("#addlist_car");
});
</script>
<script type="text/javascript">
function processaExclusao(i,id)
{
    var count = i;
    var id_car = id;
    $('#span_cont').html('<span style="font-size:20px;" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Carregando...');
                setTimeout(function(){
                $('#caracteristica_container_'+String(count)).load("tools/processa_exclusao_caracteristica.php",{"id":id_car})
            }, 1000);

}
</script>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->

<?php require_once('public/footer.php');?>