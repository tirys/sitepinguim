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

if (isset($_GET['acao'])) {
    if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
        $conexao = new Conexao();
        $consulta = $conexao->consulta('
		INSERT into tb_conteudo_tipo (
		tb_conteudo_tipo_nome,
        tb_conteudo_tipo_url
		) values (
		"'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])).'",
		"'.ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_url'])).'"
		)'
        );
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
                    "'.$id.'",
                    "NULL",
                    "NULL",
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
        if (isset($_GET['id'])) 
        {
            $conexao = new Conexao();
            $consulta = $conexao->consulta('UPDATE tb_conteudo_tipo SET 
            tb_conteudo_tipo_nome = "' . $_POST['txt_nome'] . '",
            tb_conteudo_tipo_url = "' . ConverteURL($_POST['txt_url']) . '"
            where tb_conteudo_tipo_id = "' . $_GET['id'] . '"');

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
                    "'.$_GET['id'].'",
                    "NULL",
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
                    tb_caracteristicas_tipo = "'.$_GET['id'].'",
                    tb_caracteristicas_categoria = "NULL",
                    tb_caracteristicas_subcategoria = "NULL",
                    tb_caracteristicas_nome = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_nome])).'",
                    tb_caracteristicas_valor_padrao = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST[$post_value])).'"
                    WHERE tb_caracteristicas_id = "'.$_POST['txt_id_cad_'.$cad].'"'); 
                }
            }    
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

        }//id
        $msgSucesso = 'ok';
    }

    if ($_GET['acao'] == 'excluir') {
        //query separada pra excluir caracteristicas
        //excluir todas as características vinculadas ao conteúdo por si só

        if (isset($_GET['id'])) {

            $conexao = new Conexao();
            $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria where tb_conteudo_categoria_id_tipo = "' . $_GET['id'] . '"');
            $constaLigacao = $conexao->busca($consulta);
            $conexao->desconectar();
            if (empty($constaLigacao)) {
                $conexao = new Conexao();
                $consulta = $conexao->consulta('
			DELETE FROM tb_conteudo_tipo where tb_conteudo_tipo_id = "' . $_GET['id'] . '"');
//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

                $consulta = $conexao->consulta('DELETE  FROM tb_caracteristicas WHERE tb_caracteristicas_tipo ="'.$_GET['id'].'"');

//-------------------------------------------------------------------------------------------------------------------------------------------------------------SE POSSIVEL REAPROVEIRTAR

                $msgSucesso = 'ok';
            } else {
                $msgSucesso = 'nok';
            }
        }
    }
}
?>

<?php
global $editardados;
if (isset($_GET['acao'])) {
    $nomeFormulario = 'Editar ';
    if ($_GET['acao'] == 'resgatar-dados') {
        $action = 'paginas-tipos/editar/' . $_GET['id'];
        $conexao = new Conexao();
        $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_tipo WHERE tb_conteudo_tipo_id = "' . $_GET['id'] . '"');
        $editardados = $conexao->busca($consulta);
        $conexao->desconectar();
    } else {
        $action = 'paginas-tipos/gravar';
        $nomeFormulario = 'Adicionar ';
    }
} else {
    $action = 'paginas-tipos/gravar';
    $nomeFormulario = 'Adicionar ';
}
?>

<?php require_once('public/header.php'); ?>

<table width="100%" border="0" cellpadding="5">



    <tr>
        <td width="31%"><h2>Tipos de Conteúdo</h2></td>
        <td width="42%">
<?php if ($msgSucesso == 'ok') { ?>
                <div class="alert alert-success" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação executada com sucesso!</div>
<?php } ?>

<?php if ($msgSucesso == 'nok') { ?>
                <div class="alert alert-warning" style="padding:5px; margin-top:18px; margin-bottom:0px;">Ação não executada.</div>
            <?php } ?>
        </td>
        <td width="3%" align="left">&nbsp;</td>
        <td width="24%" align="left"><h3><?php echo $nomeFormulario; ?>Tipo</h3></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
                <thead>
                    <tr>
                      <th width="40%">Nome</th>
                        <th width="52%">URL Amigável</th>
                        <th width="4%">&nbsp;</th>
                        <th width="4%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $conexao = new Conexao();
                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_tipo');
                $total = $conexao->conta($consulta);
                while ($dados = $conexao->busca($consulta)) {
                    ?>
                        <tr>
                          <td><?php echo $dados['tb_conteudo_tipo_id']; ?> - <?php echo $dados['tb_conteudo_tipo_nome']; ?></td>
                            <td><?php echo $dados['tb_conteudo_tipo_url']; ?></td>
                            <td>
                                <a href="paginas-tipos/resgatar-dados/<?php echo $dados['tb_conteudo_tipo_id']; ?>" title="Editar" class="btn btn-primary btn-xs"><span class="fa fa-pencil"></span></a></td>
                            <td><a href="paginas-tipos/excluir/<?php echo $dados['tb_conteudo_tipo_id']; ?>" title="Excluir" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></td>
                        </tr>
                <?php } $conexao->desconectar(); ?>


                </tbody>
                <tfoot>
                    <tr>
                      <th>Nome</th>
                        <th>URL Amigável</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
            </table>



            <p>&nbsp;</p>
      <p>&nbsp;</p></td>
        <td>&nbsp;</td>
        <td valign="top">



      <form action="<?php echo $action ?>" method="post" id="dadostipo">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">

                    <tr>
                        <td width="50" colspan="2"><strong>Nome do  Tipo</strong></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php echo $editardados['tb_conteudo_tipo_nome'] ?>" required />
                            <hr></td>
                    </tr>
                    <tr>
                      <td colspan="2"><strong>URL Amigável</strong></td>
                    </tr>
                    <tr>
                      <td colspan="2"><input name="txt_url" type="text" class="form-control" id="txt_url" value="<?php echo $editardados['tb_conteudo_tipo_url'] ?>" required /><hr></td>
                    </tr>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->
                    <tr>
                      <td colspan="2"><strong>Características:<br/><br/></strong>
                    </tr>
                        <?php
                        $str = "";                       
                        if(isset($_GET['id']) && $_GET['acao'] != 'editar'){
                        $conexao =  new Conexao();
                        $id = mysqli_real_escape_string($conexao->obj(),$_GET['id']);
                        $consulta = $conexao->consulta("SELECT `tb_caracteristicas_id`, `tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM `tb_caracteristicas` WHERE `tb_caracteristicas_tipo` ='$id' ");
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
                        <td colspan="2" align="right"><input type="submit" style="margin-top:5px;" class="btn btn-success" value="Gravar" /></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>

            </table>
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
 $('#btn_add').click(Conexaotion()
{
  hold_id++;
  
  var out_placeholder = 'Nome da Característica '+(hold_id+1);
  var out_placeholder_2 = 'Valor Padrão '+(hold_id+1);


  $("<tr><td colspan='2' style='display:block; width:100%'><label>Nome</label><input name='formNome[]' type='text' class='form-control' id='formNome[]'  placeholder='"+out_placeholder+"' required /></td></tr><hr><tr><td colspan='2' style='display:block; width:100%'><label>Valor Padrão</label><input name='formVal[]' type='text' class='form-control' id='formVal[]'  placeholder='"+out_placeholder_2+"' required /></td></tr>").appendTo("#addlist_car");
});
</script>
<script type="text/javascript">
Conexaotion processaExclusao(i,id)
{
    var count = i;
    var id_car = id;
    $('#span_cont').html('<span style="font-size:20px;" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Carregando...');
                setTimeout(Conexaotion(){
                $('#caracteristica_container_'+String(count)).load("tools/processa_exclusao_caracteristica.php",{"id":id_car})
            }, 1000);
 }               

</script>
<!--#######################################################################################################################################SE POSSIVEL REAPROVEITAR-->
<?php require_once('public/footer.php'); ?>