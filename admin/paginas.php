<?php
require_once('vendor/load.php');
$lock = new Lock();
if (isset($_GET['acao']))
{
  	if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST')
    {
    	$conexao = new Conexao();
    	$consulta = $conexao->consulta('
    		INSERT into tb_conteudo_categoria (
    		tb_conteudo_categoria_nome,
    		tb_conteudo_categoria_galeria_imagem_pequena_largura,
    		tb_conteudo_categoria_galeria_imagem_pequena_altura,
    		tb_conteudo_categoria_galeria_imagem_grande_largura,
    		tb_conteudo_categoria_galeria_imagem_grande_altura
    		) values (
    		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
            "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_larg'])).'",
            "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_alt'])).'",
            "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_larg'])).'",
            "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_alt'])).'"
    		)');
    		$msgSucesso = true;
  	}

  	if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST')
    {
  		if (isset($_GET['id']))
      {
    			$conexao = new Conexao();
    			$consulta = $conexao->consulta('UPDATE tb_conteudo_categoria SET
            tb_conteudo_categoria_nome="'.$_POST['txt_nome'].'",
            tb_conteudo_categoria_galeria_imagem_pequena_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_larg'])).'",
            tb_conteudo_categoria_galeria_imagem_pequena_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_pqn_alt'])).'",
            tb_conteudo_categoria_galeria_imagem_grande_largura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_larg'])).'",
    	     	tb_conteudo_categoria_galeria_imagem_grande_altura="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_img_gde_alt'])).'"
            where tb_conteudo_categoria_id = "'.$_GET['id'].'"');
  		}
    		$msgSucesso = true;
  	}
} //ACAO 1

if (isset($_GET['acao2']))
{
  if ($_GET['acao2'] == 'excluir')
  {
    		if (isset($_GET['id2']))
        {
    			 $conexao = new Conexao();
    			 $consulta = $conexao->consulta('
    			 DELETE FROM tb_conteudo where tb_conteudo_id = "'.$_GET['id2'].'"');
    		}
    		  $msgSucesso = true;
  }
} //ACAO 2   ?>
<?php require_once('public/header.php');?>
<table width="100%" border="0" cellpadding="5">

  <tr>
    <td width="13%"><h2>Páginas</h2></td>
    <td width="53%">
      <?php if ($msgSucesso == true){?>
      <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
      <?php } ?>
    </td>

    <td width="27%" align="right">
    <?php
              $id = $_GET['id'];
              //workaround \/
              if($id != 8)
              {
                $lock->lock_btn('paginas','<a href="paginas-adicionar/nova/'.$id.'" class="btn btn-success" title="Adicionar">Nova Página</a>');
              }
  ?>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
      <thead>
        <tr>
          <th width="104">Identificador</th>
          <th width="342">Nome</th>
          <th width="212"> Categoria</th>
          <?php
          if($_GET['id'] != 10475745745)
          { ?>
            <th width="212">Sub-Categoria</th>
    <?php   }
          else
          { ?>
            <th width="212">URL da promoção</th>
    <?php   } ?>
          <th width="165">Data</th>
          <th width="33">&nbsp;</th>
          <?php $lock->lock_btn('paginas','<th width="29">&nbsp;</th>'); ?>
          </tr>
        </thead>
      <tbody>

        <?php
	       $conexao = new Conexao();
         $consulta = $conexao->consulta('SELECT tb_conteudo.*, tb_conteudo_categoria.*, tb_conteudo_subcategoria.* from tb_conteudo left join tb_conteudo_categoria on tb_conteudo_categoria.tb_conteudo_categoria_id=tb_conteudo.tb_conteudo_categoria left join tb_conteudo_subcategoria on tb_conteudo_subcategoria.tb_conteudo_subcategoria_id=tb_conteudo.tb_conteudo_subcategoria where tb_conteudo.tb_conteudo_categoria = "'.$_GET['id'].'" order by tb_conteudo_data desc');

    while($dados = $conexao->busca($consulta)){?>
        <tr>
          <td><?php echo $dados['tb_conteudo_id'];?></td>
          <td><?php echo $dados['tb_conteudo_titulo'];?></td>
          <td><?php echo $dados['tb_conteudo_categoria_nome'];?></td>
          <?php
          if($dados['tb_conteudo_categoria_id'] != '10475745745')
          { ?>
            <td><?php echo $dados['tb_conteudo_subcategoria_nome'];?></td>
  <?php   }
          else
          { ?>
            <td><?php echo 'promocao/'.$dados['tb_conteudo_link_automatico'];?></td>
  <?php   } ?>
          <td><?php echo DesConverteData($dados['tb_conteudo_data']);?></td>
          <td>
          <?php
            if($_GET['id'] != 8)
            {
            //workaround
          ?>    
            <a href="paginas-editar/resgatar-dados/<?php echo $dados['tb_conteudo_id'];?>" title="Editar" class="btn btn-primary btn-xs">
            <span class="fa fa-pencil"></span></a></td>
          <?php
            }
          ?>

            <?php
              $id_cat = $dados['tb_conteudo_categoria_id'];
              $id = $dados['tb_conteudo_id'];
                $lock->lock_btn('paginas','<td><a href="paginas/listar/'.$id_cat.'/excluir/'.$id.'" title="Excluir" class="btn btn-danger btn-xs">
                                <span class="fa fa-times"></span>&nbsp;</a></td>');
            ?>
          </tr>
        <?php } $conexao->desconectar();?>
        </tbody>
      <tfoot>
        <tr>
          <th>Identificador</th>
          <th>Nome</th>
          <th>Categoria</th>
          <th>Sub-Categoria</th>
          <th>Data</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          </tr>
        </tfoot>
      </table>

      <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<?php require_once('public/footer.php');?>
