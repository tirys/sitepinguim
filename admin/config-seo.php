<?php
require_once('vendor/load.php');
global $msgSucesso;
if (isset($_GET['acao'])){
    if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST')
    {

            $conexao = new Conexao();
            $consulta = $conexao->consulta('
      INSERT into tb_seo (
      tb_seo_link,
      tb_seo_nome,
      tb_seo_descricao,
      tb_seo_palavras_chave
      ) values (
      "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
      "'.mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome']).'",
      "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao'])).'",
      "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_chave'])).'"
      )') ;
            $msgSucesso = 'ok';

    }
    if ($_GET['acao'] == 'editar' and $_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_GET['id']))
        {
            $conexao = new Conexao();

                $conexao = new Conexao();
                $consulta = $conexao->consulta('
        UPDATE tb_seo SET 
        tb_seo_link ="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_link'])).'",
        tb_seo_nome="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
        tb_seo_descricao ="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao'])).'",   
        tb_seo_palavras_chave ="'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_chave'])).'"   
        where tb_seo_id = '.$_GET['id']);
                $msgSucesso = 'ok';
            }

        }//id
    }
    if ($_GET['acao'] == 'excluir')
    {
        if (isset($_GET['id']))
        {
            $conexao = new Conexao();
            $consulta = $conexao->consulta('
    			DELETE FROM tb_seo where tb_seo_id = "'.$_GET['id'].'"');
            $msgSucesso = 'ok';

        }

}
global $editardados;
if (isset($_GET['acao'])){
    $nomeFormulario = 'Editar ';
    $lock = true;
    if ($_GET['acao'] == 'resgatar-dados') {
        $action = 'config-seo/editar/'.$_GET['id'];

        $conexao = new Conexao();
        $consulta = $conexao->consulta('
				SELECT * FROM tb_seo 
				WHERE 
				tb_seo_id = "'.$_GET['id'].'"
				');
        $editardados = $conexao->busca($consulta);
        $conexao->desconectar();

    }else{
        $action = 'config-seo/gravar';
        $nomeFormulario = 'Adicionar ';
    }
}else{
    $action = 'config-seo/gravar';
    $nomeFormulario = 'Adicionar ';
}
?>
<?php require_once('public/header.php');?>
    <table width="100%" border="0" cellpadding="5">
        <tr>
            <td width="31%"><h2>Dados Seo</h2></td>
            <td width="42%">
                <?php if ($msgSucesso == 'ok'){?>
                    <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
                <?php } ?>

                <?php if ($msgSucesso == 'nok'){?>
                    <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Registro está sendo utilizado em outros conteúdos!</div>
                <?php } ?>
            </td>
            <td width="3%" align="left">&nbsp;</td>
            <td width="24%" align="left"><h3><?php echo $nomeFormulario;?> Dados Seo</h3></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
                    <thead>
                    <tr>
                        <th width="390">Link</th>
                        <th width="346">Nome</th>
                        <th width="346">Descricao</th>
                        <th width="29">&nbsp;</th>
                        <th width="31">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $conexao = new Conexao();
                    $consulta = $conexao->consulta('SELECT * FROM tb_seo');
                    while($dados = $conexao->busca($consulta)){?>
                        <tr>
                            <td><?php echo $dados['tb_seo_link'];?></td>
                            <td><?php echo $dados['tb_seo_nome'];?></td>
                            <td><?php echo $dados['tb_seo_descricao'];?></td>
                            <td>
                                <a href="config-seo/resgatar-dados/<?php echo $dados['tb_seo_id'];?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
                            <td>
                                <?php
                                if($_SESSION['usuarioTipo'] == 999)
                                {
                                    ?>
                                    <a href="config-seo/excluir/<?php echo $dados['tb_seo_id'];?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } $conexao->desconectar();	?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Link</th>
                        <th>Nome</th>
                        <th>Descricao</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    </tfoot>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p></td>
            <td>&nbsp;</td>
            <td valign="top"><table width="100%" border="0" cellpadding="5"></td>
                    </tr>
                </table>
                <form action="<?php echo $action?>" method="post" id="dadoscategoria">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2"><strong>Link</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input name="txt_link" type="text" class="form-control" id="txt_link" value="<?php echo $editardados['tb_seo_link']?>" required />
                                <hr></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Nome</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_seo_nome']?>" required />
                                <hr></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Descricao</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input name="txt_descricao" type="text" class="form-control" id="txt_descricao" value="<?php echo $editardados['tb_seo_descricao']?>" required />
                                <hr></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Palavras Chave</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input name="txt_chave" type="text" class="form-control" id="txt_descricao" value="<?php echo $editardados['tb_seo_palavras_chave']?>" required />
                                <hr></td>
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
<?php require_once('public/footer.php');?>