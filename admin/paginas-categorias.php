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
$lock = new Lock();
global $msgSucesso;

if (isset($_GET['acao'])){
	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('SELECT tb_conteudo_categoria_id FROM tb_conteudo_categoria where tb_conteudo_categoria_url = "'.ConverteURL($_POST['txt_nome']).'"');
	$contaRegistrosMesmaURL = $conexao->conta($consulta);
	if ($contaRegistrosMesmaURL == 0){		
	

  $conexao = new Conexao(); 
  $consulta = $conexao->consulta('
    INSERT into tb_conteudo_categoria (
    tb_conteudo_categoria_nome,
    tb_conteudo_categoria_url,
    tb_conteudo_categoria_id_tipo,
    tb_conteudo_categoria_galeria_imagem_pequena_largura,
    tb_conteudo_categoria_galeria_imagem_pequena_altura,
    tb_conteudo_categoria_galeria_imagem_grande_largura,
    tb_conteudo_categoria_galeria_imagem_grande_altura,
    tb_conteudo_categoria_galeria_foto_pequena_largura,
    tb_conteudo_categoria_galeria_foto_pequena_altura,
    tb_conteudo_categoria_galeria_foto_grande_largura,
    tb_conteudo_categoria_galeria_foto_grande_altura,
    tb_conteudo_categoria_palavras_chaves_busca,
    tb_conteudo_categoria_descricao_busca,
    tb_conteudo_categoria_ordem
    ) values (
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
    "'.ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_url'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_id_tipo'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_larg'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_alt'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_larg'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_alt'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_pqn_larg'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_pqn_alt'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_gde_larg'])).'", 
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_gde_alt'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])).'",
    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_ordem'])).'"

    )');
   
    if(isset($_POST['lock_handler']))
    {
        //ressaltar que não ta tendo id por enquanto...
        //last_insert_id
        $id_lock = $conexao->ultimo_id();
        
        if($_POST['lock_handler'] == 0)
        {
          $handle = 9999;
        }
        else
        {
          $handle = $_POST['lock_handler'];
        }

        $lock->addLock('paginas', $id_lock, $handle);
    }
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
                    "'.$id.'",
                    "NULL",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$nome)).'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$val)).'"
                     )'
                     );
                }

         }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

		$msgSucesso = 'ok';
		
		} else {$msgSucesso = 'nok';}
	}
	
	
	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_GET['id'])){
			
      //aqui lock reader pra add ou del lock
      $read = $lock->lockReader();
      if($read)
      { 
        if($read == 'delete')
        {
          $lock->delLock('paginas',$_GET['id']);
        }
        elseif($read == 'add')
        {
          $lock->addLock('paginas',$_GET['id'],$_POST['lock_handler']);
          //retornando false
        }
        else
        {
          $reduntant = 'reduntant';
          //nothing
        }
      }
			
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			SELECT tb_conteudo_categoria_id FROM tb_conteudo_categoria where tb_conteudo_categoria_url = "'.ConverteURL($_POST['txt_nome']).'" and tb_conteudo_categoria_id <> "'.$_GET['id'].'"');
			$contaRegistrosMesmaURL = $conexao->conta($consulta);
			if ($contaRegistrosMesmaURL == 0){	
			
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			UPDATE tb_conteudo_categoria SET 
			tb_conteudo_categoria_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
			tb_conteudo_categoria_url="'.ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_url'])).'",
			tb_conteudo_categoria_id_tipo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_id_tipo'])).'",
			tb_conteudo_categoria_galeria_imagem_pequena_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_larg'])).'",
			tb_conteudo_categoria_galeria_imagem_pequena_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_alt'])).'",
			tb_conteudo_categoria_galeria_imagem_grande_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_larg'])).'",
			tb_conteudo_categoria_galeria_imagem_grande_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_alt'])).'",
			tb_conteudo_categoria_galeria_foto_pequena_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_pqn_larg'])).'",
			tb_conteudo_categoria_galeria_foto_pequena_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_pqn_alt'])).'",
			tb_conteudo_categoria_galeria_foto_grande_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_gde_larg'])).'",
			tb_conteudo_categoria_galeria_foto_grande_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_foto_gde_alt'])).'",
      tb_conteudo_categoria_palavras_chaves_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])).'",
      tb_conteudo_categoria_descricao_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])).'",
      tb_conteudo_categoria_ordem="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_ordem'])).'"   
			where tb_conteudo_categoria_id = "'.$_GET['id'].'"');
			
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
                    "'.$_GET['id'].'",
                    "NULL",
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
                  tb_caracteristicas_categoria = "'.$_GET['id'].'",
                  tb_caracteristicas_subcategoria = "NULL",
                  tb_caracteristicas_nome = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_nome])).'",
                  tb_caracteristicas_valor_padrao = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_value])).'"
                  WHERE tb_caracteristicas_id = "'.$_POST['txt_id_cad_'.$cad].'"'); 
              }
            }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

      $msgSucesso = 'ok';
			} else {$msgSucesso = 'nok';}
			
      }//id
						
	}
	
	if ($_GET['acao'] == 'excluir'){

	
		if (isset($_GET['id'])){
					
		$conexao = new Conexao(); 
		$consulta = $conexao->consulta('SELECT * FROM tb_conteudo where tb_conteudo_categoria = "'.$_GET['id'].'"');
		$constaLigacao = $conexao->busca($consulta);
		$conexao->desconectar();	
			if (empty($constaLigacao)){
			$conexao = new Conexao(); 
			$consulta = $conexao->consulta('
			DELETE FROM tb_conteudo_categoria where tb_conteudo_categoria_id = "'.$_GET['id'].'"');

      //-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

                $consulta = $conexao->consulta('DELETE  FROM tb_caracteristicas WHERE tb_caracteristicas_categoria ="'.$_GET['id'].'"');

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
				$action = 'paginas-categorias/editar/'.$_GET['id'];
				
				$conexao = new Conexao(); 
				$consulta = $conexao->consulta('
				SELECT * FROM tb_conteudo_categoria 
				WHERE 
				tb_conteudo_categoria_id = "'.$_GET['id'].'"
				');
				$editardados = $conexao->busca($consulta);
				$conexao->desconectar();
			   	
				
				
			}else{
			$action = 'paginas-categorias/gravar';
			$nomeFormulario = 'Adicionar ';
			}
		}else{
			$action = 'paginas-categorias/gravar';
			$nomeFormulario = 'Adicionar ';
			}

	?>

<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

    

  <tr>
    <td width="31%"><h2>Categoria da Página</h2></td>
    <td width="42%">
     <?php if ($msgSucesso == 'ok'){?>
    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
    <?php } ?>
    
    <?php if ($msgSucesso == 'nok'){?>
    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
    <?php } ?>
    </td>
    <td width="3%" align="left">&nbsp;</td>
    <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Categoria</h3></td>
  </tr>
  <tr>
    <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
        <thead>
		<tr>
			<th width="390">Nome da Categoria</th>
			<th width="346">URL Amigável</th>
			<th width="346">Tipo da Categoria</th>
			<th width="29">&nbsp;</th>
			<th width="31">&nbsp;</th>
		  </tr>
	</thead>
	<tbody>
    
    <?php 
	$conexao = new Conexao(); 
    $consulta = $conexao->consulta('
	SELECT tb_conteudo_categoria.*, tb_conteudo_tipo.* 
	FROM tb_conteudo_categoria LEFT JOIN tb_conteudo_tipo 
	ON tb_conteudo_categoria.tb_conteudo_categoria_id_tipo = tb_conteudo_tipo.tb_conteudo_tipo_id
	');
	
					
	
    while($dados = $conexao->busca($consulta)){?>
    <tr>
			<td><?php echo $dados['tb_conteudo_categoria_nome'];?></td>
			<td><?php echo $dados['tb_conteudo_categoria_url'];?></td>
			<td><?php echo $dados['tb_conteudo_tipo_nome'];?></td>
			<td>
			  <a href="paginas-categorias/resgatar-dados/<?php echo $dados['tb_conteudo_categoria_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
			<td><a href="paginas-categorias/excluir/<?php echo $dados['tb_conteudo_categoria_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
		  </tr>
    <?php } $conexao->desconectar();	?>
        
	
	</tbody>
	<tfoot>
		<tr>
			<th>Nome da Categoria</th>
			<th>URL Amigável</th>
			<th>Tipo da Categoria</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		  </tr>
	</tfoot>
</table>





    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td>&nbsp;</td>
    <td valign="top"><table width="100%" border="0" cellpadding="5">
       
		  <?php 
		  if ($nomeFormulario == 'Editar '){
		  if (isset($editardados['tb_conteudo_categoria_imagem'])){?>
          <tr>
          <td colspan="2"><strong>Imagem2</strong></td>
        </tr>
        <tr>
          <td colspan="2"> 
		<img src="uploads/images/categoria/<?php echo $editardados['tb_conteudo_categoria_imagem']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
        
		<?php } else {?>
        <img src="images/thumbnail.png" width="260" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:100%; height:auto;" />
        <?php }?>
        <form action="paginas-categoria-foto-crop/<?php echo $_GET['id']?>/225/220/destaque/<?php echo $editardados['tb_conteudo_categoria_url']?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
          <input type="file" class="form-control" name="image" size="30" />
          <br />
          <input type="submit" name="upload" value="Upload" class="btn btn-info" style="width:100%;" />
        </form>
        <hr>
        <?php }?>
            </td>
        </tr>
            </table>

      <form action="<?php echo $action?>" method="post" id="dadoscategoria">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><strong>Nome da Nova Categoria</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_conteudo_categoria_nome']?>" required />
            <hr></td>
        </tr>

         <?php
            if($_SESSION['usuarioTipo'] == 1)
              { ?>
          <tr>
            <td colspan="2"><strong>Adicionar Trava</strong></td>
          </tr>
          <tr>
          <td colspan="2">
          <?php
            $lock->lockHandler('paginas');
          ?>
          <hr/></td>
          </tr>   
    <?php
            }
         ?> 


        <tr>
          <td colspan="2"><strong>URL Amigável</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_url" type="text" class="form-control" id="txt_url" value="<?php echo $editardados['tb_conteudo_categoria_url']?>" required />
            <hr></td>
        </tr>
       <tr>
          <td colspan="2"><strong>Ordem</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_ordem" type="number" min="0" step="1" max="99" class="form-control" id="txt_ordem" value="<?php echo $editardados['tb_conteudo_categoria_ordem']?>" required />
            <hr></td>
        </tr>

        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">Tipo da Página</td>
        </tr>
        <tr>
          <td colspan="2"><select name="txt_id_tipo" id="txt_id_tipo" class="form-control">
            <?php 
		$conexao = new Conexao(); 
            if (isset($_GET['acao'])){
            if ($_GET['acao'] == 'resgatar-dados') {
	        $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_tipo WHERE tb_conteudo_tipo_id = "'.$editardados['tb_conteudo_categoria_id_tipo'].'"'); 
			$buscaNomeCategoria = $conexao->busca($consulta);	
			?>
            <option value="<?php echo $buscaNomeCategoria['tb_conteudo_tipo_id'];?>"> <?php echo $buscaNomeCategoria['tb_conteudo_tipo_nome'];?></option>
            <?php }}
			
        $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_tipo ORDER BY tb_conteudo_tipo_nome');      
        while($listaCategoria = $conexao->busca($consulta)){?>
            <option value="<?php echo $listaCategoria['tb_conteudo_tipo_id'];?>"> <?php echo $listaCategoria['tb_conteudo_tipo_nome'];?></option>
            <?php } $conexao->desconectar();	?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><strong>Imagem Pequena</strong></td>
        </tr>
        <tr>
          <td width="50%">Largura</td>
          <td>Altura</td>
        </tr>
        <tr>
          <td><input name="txt_img_pqn_larg" type="text" class="form-control sonumero" id="txt_img_pqn_larg" value="<?php echo $editardados['tb_conteudo_categoria_galeria_imagem_pequena_largura']?>" required/></td>
          <td><input name="txt_img_pqn_alt" type="text" class="form-control sonumero" id="txt_img_pqn_alt" value="<?php echo $editardados['tb_conteudo_categoria_galeria_imagem_pequena_altura']?>" required/></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Imagem Grande</strong></td>
        </tr>
        <tr>
          <td>Largura</td>
          <td>Altura</td>
        </tr>
        <tr>
          <td><input name="txt_img_gde_larg" type="text" class="form-control sonumero" id="txt_img_gde_larg" value="<?php echo $editardados['tb_conteudo_categoria_galeria_imagem_grande_largura']?>" required/></td>
          <td><input name="txt_img_gde_alt" type="text" class="form-control sonumero" id="txt_img_gde_alt" value="<?php echo $editardados['tb_conteudo_categoria_galeria_imagem_grande_altura']?>" required/></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Galeira de Foto Pequena</strong></td>
        </tr>
        <tr>
          <td> Largura</td>
          <td>Altura</td>
        </tr>
        <tr>
          <td><input name="txt_foto_pqn_larg" type="text" class="form-control sonumero" id="txt_foto_pqn_larg" value="<?php echo $editardados['tb_conteudo_categoria_galeria_foto_pequena_largura']?>" required/></td>
          <td><input name="txt_foto_pqn_alt" type="text" class="form-control sonumero" id="txt_foto_pqn_alt" value="<?php echo $editardados['tb_conteudo_categoria_galeria_foto_pequena_altura']?>" required/></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Galeira Foto Grande</strong></td>
        </tr>
        <tr>
          <td>Largura</td>
          <td>Altura</td>
        </tr>
        <tr>
          <td><input name="txt_foto_gde_larg" type="text" class="form-control sonumero" id="txt_foto_gde_larg" value="<?php echo $editardados['tb_conteudo_categoria_galeria_foto_grande_largura']?>" required/></td>
          <td><input name="txt_foto_gde_alt" type="text" class="form-control sonumero" id="txt_foto_gde_alt" value="<?php echo $editardados['tb_conteudo_categoria_galeria_foto_grande_altura']?>" required/></td>
        </tr>
        <tr>
          <td colspan="2"><hr></td>
        </tr>
        <tr>
          <td colspan="2"><strong>Palavras-Chaves</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_palavra_chave" type="text" class="form-control" id="txt_palavra_chave" value="<?php echo $editardados['tb_conteudo_categoria_palavras_chaves_busca']?>" required /></td>
          </tr>
        <tr>
          <td colspan="2"><hr></td>
          </tr>
        <tr>
          <td colspan="2"><strong>Descrição para mecanismo de pesquisa</strong></td>
        </tr>
        <tr>
          <td colspan="2"><input name="txt_descricao_busca" type="text" class="form-control" id="txt_descricao_busca" value="<?php echo $editardados['tb_conteudo_categoria_descricao_busca']?>" required /></td>
        </tr>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->
            <tr>
              <td colspan="2"><strong>Características:<br/><br/></strong>
            </tr>
                <?php
                $str = "";
                if(isset($_GET['id']) && ($_GET['acao'] != 'editar') )
                {
                $id =  $_GET['id'];
                $conexao =  new Conexao();
                //derramar tipo
                $consulta_tipo = $conexao->consulta('SELECT `tb_caracteristicas_id`, `tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` 
                  FROM `tb_caracteristicas` WHERE `tb_caracteristicas_tipo` = "'.$editardados['tb_conteudo_categoria_id_tipo'].'" ');

                $conta_tipo = $conexao->conta($consulta_tipo);
                if($conta_tipo)
                {
                  echo '<tr><td colspan="2"><strong><br/><br/>Características Herdadas:<br/><br/></strong></tr>';
                  
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

                $consulta = $conexao->consulta("SELECT `tb_caracteristicas_id`, `tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM `tb_caracteristicas` WHERE `tb_caracteristicas_categoria` ='$id' ");
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
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input type="submit" class="btn btn-success" value="Gravar" /></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
    </table></td>
      </form>
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