<?php 
require_once('vendor/load.php');

if (isset($_GET['acao'])){
	
if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
	
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta('SELECT tb_conteudo_id FROM tb_conteudo where tb_conteudo_link_automatico = "'.ConverteURL($_POST['txt_nome']).'" and tb_conteudo_id <> "'.$_GET['id'].'"');
	$contaRegistrosMesmoLinkAutomatico = $conexao->conta($consulta);

	if ($contaRegistrosMesmoLinkAutomatico == 0){		

	$conexao = new Conexao(); 


// tb_conteudo_texto_longo="'.html_entity_decode($_POST['txt_texto_longo'], ENT_QUOTES, 'UTF-8').'",
        //tb_conteudo_texto_longo2="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo2'])).'",

  $consulta = $conexao->consulta('UPDATE tb_conteudo SET 
        tb_conteudo_titulo="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_conteudo_texto_curto="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_curto'])).'",
		    tb_conteudo_texto_longo="'.htmlentities($_POST['txt_texto_longo'], ENT_QUOTES, 'UTF-8').'",
        tb_conteudo_texto_longo2="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo2'])).'",
        tb_conteudo_texto_longo3="'.htmlentities($_POST['txt_texto_longo3'], ENT_QUOTES, 'UTF-8').'",
		    tb_conteudo_texto_longo4="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo4'])).'",
		    tb_conteudo_texto_longo5="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo5'])).'",
		    tb_conteudo_texto_longo6="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo6'])).'",
        tb_conteudo_data="'.ConverteData($_POST['txt_data']).'",
		    tb_conteudo_categoria="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_categoria'])).'",
		    tb_conteudo_subcategoria="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_subcategoria'])).'",
		    tb_conteudo_link_automatico="'.ConverteURL(strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome']))).'",
		    tb_conteudo_descricao_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])).'",
		    tb_conteudo_palavras_chaves_busca="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])).'",
		    tb_conteudo_video="'.(mysqli_real_escape_string($conexao->obj(),$_POST['txt_video'])).'"
        WHERE tb_conteudo_id = "'.$_GET['id'].'"');
	//$consulta = $conexao->consulta($SQL); 
	$msgSucesso = true;
	
	} else {$msgErro = true;}
}
}


//RESGATANDO DADOS DA PÁGINA ESCOLHIDA
$conexao = new Conexao(); 
$consulta = $conexao->consulta('SELECT * FROM tb_conteudo where tb_conteudo_id = "'.$_GET['id'].'"');
$dados = $conexao->busca($consulta);
$link_automatico 	= $dados['tb_conteudo_link_automatico'];

$tipo = $dados['tb_conteudo_tipo'];
$categoria = $dados['tb_conteudo_categoria'];

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


//$consulta = $conexao->consulta('SELECT tb_unidade_id, tb_unidade_nome FROM tb_unidade where tb_unidade_id = "'.$dados['tb_conteudo_unidade_id'].'"');
//$dadosUnidade = $conexao->busca($consulta);

$conexao->desconectar();



//DELETANDO IMAGEM DA CATEOGORIA CASO EXISTA


if (isset($_GET['acao2'])){
		//DELETANDO A IMAGEM GRANDE SE EXISTIR E SE FOR SOLICITADO
		
		if ($_GET['acao2'] == 'deletar-foto-destaque'){
			if($dados['tb_conteudo_imagem_pequena'] <> NULL) {
			$conexao = new Conexao(); 
					$consulta = $conexao->consulta('update tb_conteudo set tb_conteudo_imagem_pequena = NULL where tb_conteudo_id = "'.$_GET['id'].'"');
					unlink('uploads/images/conteudo/'.$dados['tb_conteudo_imagem_pequena']); 
					$dados['tb_conteudo_imagem_pequena'] = NULL;
					$conexao->desconectar();
			}
			else {
			$msgErro = true;
			}
		$msgSucesso = true;
		}

		////////////////////////////////////////////////////////////////
	
		//DELETANDO A IMAGEM GRANDE SE EXISTIR E SE FOR SOLICITADO
		if ($_GET['acao2'] == 'deletar-foto-grande'){
		if($dados['tb_conteudo_imagem_grande'] <> NULL) {
		$conexao = new Conexao(); 
				$consulta = $conexao->consulta('update tb_conteudo set tb_conteudo_imagem_grande = NULL where tb_conteudo_id = "'.$_GET['id'].'"');
				unlink('uploads/images/conteudo/'.$dados['tb_conteudo_imagem_grande']); 
				$dados['tb_conteudo_imagem_grande'] = NULL;
				$conexao->desconectar();
		}
		else {
		$msgErro = true;
		}
	$msgSucesso = true;
	}
}

?>

<?php require_once('public/header.php');?>

  <table width="100%" border="0" cellpadding="5">
  <tr>
    <td colspan="3" valign="top"><table width="100%" border="0" cellpadding="5">
      <form action="paginas-editar/gravar/<?php echo $_GET['id']?>" method="post">
        
        <tr>
          <a style="margin-left:10px;" href="paginas/listar/<?php echo $dados['tb_conteudo_categoria'];?>"><span><i class="fa fa-arrow-left"></i></span> Voltar Para a Listagem de Conteudo</a>          
          <td colspan="4"><h1>Editar Página</h1>

          <?php 
	 if ($msgErro == true){?>
      <div class="alert alert-danger" style="padding:5px; margin-top:18px; margin-bottom:0px;">Já existe um conteúdo com este. Escolha outro nome.</div>
      <?php } ?>
          </td>
          <td align="right"><input type="submit" class="btn btn-success" value="Gravar Alteração" /></td>
          </tr>
        <tr>
          <td width="20%">Nome da Página</td>
          <td width="20%">Texto Curto</td>
          <td width="20%">Categoria</td>
          <td width="20%">Sub-Categoria</td>
          <td width="20%">Data</td>
          </tr>
        <tr>
          <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $dados['tb_conteudo_titulo']?>" /></td>
          <td><input name="txt_texto_curto" type="text" class="form-control" id="txt_texto_curto" value="<?php echo $dados['tb_conteudo_texto_curto']?>" maxlength="500" /></td>
          <td><!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS -->
            <select name="txt_categoria" id="txt_categoria" class="form-control" onchange="getValor(this.value, 0)">
              <option value="<?php echo $dados['tb_conteudo_categoria']?>"><?php echo $dadosCategoria['tb_conteudo_categoria_nome']?></option>
              <?php 
				// CHAMANDO DEMAIS CATEGORIAS
				$conexao = new Conexao(); 
                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria order by tb_conteudo_categoria_nome');
                while($consultaCategoria = $conexao->busca($consulta)){
					?>
              	<option value="<?php echo $consultaCategoria['tb_conteudo_categoria_id']?>"><?php echo $consultaCategoria['tb_conteudo_categoria_nome']?></option>
              <?php } ?>
              </select>
            <!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS --></td>
          <td>
          
          
          <select name="txt_subcategoria" id="txt_subcategoria" class="form-control">
            <option value="<?php echo $dados['tb_conteudo_subcategoria']?>"><?php echo $dadosSubCategoria['tb_conteudo_subcategoria_nome']?></option>
			<?php 
				// BUSCANDO O NOME E O ID DA CATEGORIA QUE FOI SELECIONADA PARA ADICIONAR UM NOVO REGISTRO
				$conexao = new Conexao(); 
                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_subcategoria where tb_conteudo_subcategoria_id_categoria = "'.$dados['tb_conteudo_categoria'].'" order by tb_conteudo_subcategoria_nome');
                while($consultaCategoriaPrincipal = $conexao->busca($consulta)){
				?>
            <option value="<?php echo $consultaCategoriaPrincipal['tb_conteudo_subcategoria_id']?>"><?php echo $consultaCategoriaPrincipal['tb_conteudo_subcategoria_nome']?></option>
            <?php } ?>
            </select>
            
            
            </td>
          <td><input name="txt_data" type="text" class="form-control" id="txt_data" value="<?php echo DesConverteData($dados['tb_conteudo_data'])?>" /></td>
        </tr>
        <tr>
          <td colspan="5">Descrição Motor de Busca</td>
        </tr>
        <tr>
          <td colspan="5"><input name="txt_descricao_busca" type="text" class="form-control" id="txt_descricao_busca" value="<?php echo $dados['tb_conteudo_descricao_busca']?>" /></td>
        </tr>
        <tr>
          <td colspan="5">Palavras-Chaves (separado por vírgula)</td>
        </tr>
        <tr>
          <td colspan="5"><input name="txt_palavra_chave" type="text" class="form-control" id="txt_palavra_chave" value="<?php echo $dados['tb_conteudo_palavras_chaves_busca']?>" style="width: 100%" /></td>
        </tr>
             <tr>
                  <td colspan="5">Conteúdo</td>
              </tr>
 <?php 
 //<?php echo html_entity_decode($dados['tb_conteudo_texto_longo'], ENT_QUOTES, 'UTF-8'); 
//<?php echo $dados['tb_conteudo_texto_longo']
 ?>

              <tr>
                  <td colspan="5">
                  <textarea id="texto_longo" name="txt_texto_longo" rows="10" cols="80">
                  <?php echo html_entity_decode($dados['tb_conteudo_texto_longo'], ENT_QUOTES, 'UTF-8'); ?> 
                  </textarea>
                  <script type="text/javascript">
                    var editor = CKEDITOR.replace('txt_texto_longo');
                    CKFinder.setupCKEditor(editor, '../../public/js/ckeditor/ckfinder');
                  </script></td>
              </tr>
              <tr>
              <input id="icon_container" type="hidden" name="txt_texto_longo2" value="<?=isset($dados['tb_conteudo_texto_longo2']) ? $dados['tb_conteudo_texto_longo2'] : NULL;?>" />
          <?php 
            if($dados['tb_conteudo_categoria'] == 66666666)
            {
          ?>
            </tr>
               <tr>
                    <td colspan="5">Diferenciais</td>
                </tr>
              <tr>
                  <td colspan="5">
                  <textarea id="texto_longo3" name="txt_texto_longo3" rows="10" cols="80">
                  <?php echo html_entity_decode($dados['tb_conteudo_texto_longo3'], ENT_QUOTES, 'UTF-8'); ?> 
                  </textarea>
                  <script type="text/javascript">
                    var editor = CKEDITOR.replace('txt_texto_longo3');
                    CKFinder.setupCKEditor(editor, '../../public/js/ckeditor/ckfinder');
                  </script></td>
              </tr>
            <tr>

          <?php    
            }
            else
            {
          ?>
              <input type="hidden" name="txt_texto_longo3" value="<?=isset($dados['tb_conteudo_texto_longo3']) ? $dados['tb_conteudo_texto_longo3'] : NULL;?>" />
          <?php    
            }
          ?>           
              <input type="hidden" name="txt_texto_longo4" value="<?=isset($dados['tb_conteudo_texto_longo4']) ? $dados['tb_conteudo_texto_longo4'] : NULL;?>" />
              <input type="hidden" name="txt_texto_longo5" value="<?=isset($dados['tb_conteudo_texto_longo5']) ? $dados['tb_conteudo_texto_longo5'] : NULL;?>" />
              <input type="hidden" name="txt_texto_longo6" value="<?=isset($dados['tb_conteudo_texto_longo6']) ? $dados['tb_conteudo_texto_longo6'] : NULL;?>" />

  		<tr>
          <td colspan="5">Vídeo <i>(código de incorporação)</i></td>
        </tr>
        <tr>
          <td colspan="5">
          <textarea id="txt_video" name="txt_video" rows="3" cols="80" class="form-control" style="width:100%"><?php echo $dados['tb_conteudo_video']?></textarea>
          </td>
        </tr>    
        </form>
    </table>
      <h1><br />
      </h1></td>
   
<?php

    if($dadosCategoria['tb_conteudo_categoria_galeria_imagem_pequena_largura'] != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_imagem_pequena_altura']  != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_imagem_grande_largura']  != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_imagem_grande_altura']   != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_pequena_largura']   != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_grande_largura']    != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_grande_altura']     != 0 ) 
    {

?>

    <td width="3%" align="right" valign="top">&nbsp;</td>
    <td width="19%" align="right" valign="top"><table width="170" border="0" cellpadding="5">
  <?php
    if($dadosCategoria['tb_conteudo_categoria_galeria_foto_pequena_largura'] != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_pequena_altura']  != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_grande_largura']  != 0 ||
       $dadosCategoria['tb_conteudo_categoria_galeria_foto_grande_altura']   != 0 )
       {
 ?>

      <tr>
        <td>&nbsp;</td>
      </tr>    

      <tr>
        <td bgcolor="#f2f2f2">
        <strong>Galeria de Fotos</strong><sub><br /><br />
          Administre a galeria de fotos.</sub>
        </td>
      </tr>
     <tr>
        <td bgcolor="#f2f2f2">
                <a href="galeria/<?php echo $_GET['id']?>" class="btn btn-info" style="width:100%;">Galeira de Fotos 2.0</a>
          <?php    }
        ?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="170" bgcolor="#f2f2f2"><strong>Foto Destaque </strong><sub><br /><br />
          Largura <?php echo $largura_foto_destaque?>px | Altura <?php echo $altura_foto_destaque?>px</sub></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f2f2f2">
        <?php if (isset($dados['tb_conteudo_imagem_pequena'])){?>
    <img src="uploads/images/conteudo/<?php echo $dados['tb_conteudo_imagem_pequena']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:170px; height:auto;" />
        
    <?php } else {?>
        <img src="public/images/thumbnail.png" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:170px; height:auto;" />
        <?php }?>
        
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#f2f2f2">
        <form action="paginas-foto-crop/<?php echo $_GET['id']?>/<?php echo $largura_foto_destaque?>/<?php echo $altura_foto_destaque?>/destaque/<?php echo $link_automatico?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
          <input type="file" class="form-control" name="image" size="30" />
          <br />
          <input type="submit" name="upload" value="Upload" class="btn btn-info" style="width:100%;" />
        </form>
        <?php if($dados['tb_conteudo_imagem_pequena'] <> NULL) {
        echo '<a href="paginas-editar/resgatar-dados/'.$_GET['id'].'/deletar-foto-destaque" class="btn btn-danger" style="width:100%;">Deletar Imagem</a>';
    }
    ?>
        </td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2"><strong>Foto Principal </strong><sub><br /><br />
          Largura <?php echo $largura_foto_principal?>px | Altura <?php echo $altura_foto_principal?>px</sub></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#f2f2f2">
        
        <?php if (isset($dados['tb_conteudo_imagem_grande'])){?>
		<img src="uploads/images/conteudo/<?php echo $dados['tb_conteudo_imagem_grande']?>?<?php echo microtime();?>" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:170px; height:auto;" />
        
		<?php } else {?>
        <img src="public/images/thumbnail.png" width="170" height="100" alt="Thumb" class="thumbnail" style="width:auto; max-width:170px; height:auto;" />
        <?php }?>
       
        
        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#f2f2f2"><form action="paginas-foto-crop/<?php echo $_GET['id']?>/<?php echo $largura_foto_principal?>/<?php echo $altura_foto_principal?>/principal/<?php echo $link_automatico?>" method="post" enctype="multipart/form-data" name="photo" id="photo">
          <input type="file" name="image" size="30" class="form-control" />
          <br />
          <input type="submit" name="upload" value="Upload" class="btn btn-info" style="width:100%;" />
        </form>
        
         <?php if($dados['tb_conteudo_imagem_grande'] <> NULL) {
        echo '<a href="paginas-editar/resgatar-dados/'.$_GET['id'].'/deletar-foto-grande" class="btn btn-danger" style="width:100%;">Deletar Imagem</a>';
		}
		?>
        </td>
      </tr>

      <tr><td></td></tr>
      <tr>
        <td bgcolor="#f2f2f2">
        <strong>Características</strong><br/><br/>
        <sub>Administre as características vinculadas<br/><br/><br/> ao conteudo.</sub>
        </td>
      </tr>
      <tr>
        <td bgcolor="#f2f2f2"><a href="paginas-caracteristicas/<?=$_GET['id']?>"><button type="button" id="btn_add" class="btn btn-info"><b><span>Gerenciar Características</span></b></button></a></td>
      </tr>
      </table></td>
  </tr>
  </table>

<?php
    }
?>

<p>&nbsp;</p>
<?php require_once('public/footer.php');?>