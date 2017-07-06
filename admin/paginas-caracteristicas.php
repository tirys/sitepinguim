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
<?php require_once('vendor/load.php');?>

<?php 
if($_GET['id'])
{
  $conexao = new Conexao();
  $id_conteudo = strip_tags(mysqli_real_escape_string($conexao->obj(),$_GET['id']));
  $consulta_conteudo = $conexao->consulta("SELECT `tb_conteudo_titulo`,`tb_conteudo_tipo`,`tb_conteudo_categoria`,`tb_conteudo_subcategoria` FROM tb_conteudo WHERE tb_conteudo_id = '$id_conteudo'");
  $dados_conteudo = $conexao->busca($consulta_conteudo);
  
  $id_tipo = $dados_conteudo['tb_conteudo_tipo'];
  
  $id_categoria = $dados_conteudo['tb_conteudo_categoria'];
  
  $id_subcategoria = $dados_conteudo['tb_conteudo_subcategoria'];
  //checar se existe algum tipo de característica vinculadas às variáveis acima /\
  //antes disso checar os nomes do tipo, caracteristica e sub
  $consulta_tipo = $conexao->consulta("SELECT `tb_conteudo_tipo_nome` FROM tb_conteudo_tipo WHERE tb_conteudo_tipo_id = '$id_tipo'");
  $consulta_cat = $conexao->consulta("SELECT `tb_conteudo_categoria_nome` FROM tb_conteudo_categoria WHERE tb_conteudo_categoria_id = '$id_categoria'");
  $consulta_sub = $conexao->consulta("SELECT `tb_conteudo_subcategoria_nome` FROM tb_conteudo_subcategoria WHERE tb_conteudo_subcategoria_id = '$id_subcategoria'");
  $nome_tipo = $conexao->busca($consulta_tipo);
  $nome_cat = $conexao->busca($consulta_cat);
  $nome_sub = $conexao->busca($consulta_sub);

}
else
{
 header("Location: config-dados-cadastrais");
}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
//                                                                            DB STUFF
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
       if(isset($_POST['formOpcao']))
        {
            $a_txt_opcao = $_POST['formOpcao'];
                foreach($a_txt_opcao as $val)
                {
                    $consulta = $conexao->consulta('
                    INSERT IGNORE INTO tb_caracteristica_opcao (
                    tb_caracteristica_opcao_conteudo,
                    tb_caracteristica_opcao_caracteristica_id,
                    tb_caracteristica_opcao_valor
                    ) VALUES (
                    "'.$id_conteudo.'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_carac_id'])).'",
                    "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$val)).'")

                    ON DUPLICATE KEY UPDATE
                    tb_caracteristica_opcao_valor = "'.strip_tags(mysqli_real_escape_string($conexao->obj(),$val)).'";');
                }
         }

             $count_concatenado =trim($_POST['array_opt']);
              $cads = explode('-',$count_concatenado);
              foreach($cads as $cad)
              {
                  $post_valor = 'txt_opcao_'.$cad;
                  $consulta = $conexao->consulta('UPDATE tb_caracteristica_opcao SET 
                  tb_caracteristica_opcao_conteudo = "'.$id_conteudo.'",
                  tb_caracteristica_opcao_valor = "'.$_POST[$post_valor].'"
                  WHERE tb_caracteristica_opcao_id = "'.$_POST['txt_id_opt_'.$cad].'"'); 
              }        

             //display de msg de sucesso I guess
  
  }

//-------------------------------------------------------------------------------------------------------------------------------------------------------------------
//                                                                            DB STUFF
//-------------------------------------------------------------------------------------------------------------------------------------------------------------------

?>

<?php require_once('public/header.php');?>
<div class="container">
  <div class="row clearfix">
    <div class="col-md-12">
     <div class="page-header">
  <h1>Gerenciar Características <small>vinculadas ao conteúdo - <strong><?=$dados_conteudo['tb_conteudo_titulo']?></strong></small></h1>
  <div class="well" id="span_cont"></div><br/><br/>
</div>

      <div class="col-md-4">
              <h4 class="list-group-item-heading">Tipo - <strong><?=($nome_tipo['tb_conteudo_tipo_nome'] != '' ? $nome_tipo['tb_conteudo_tipo_nome']  : 'NÃO DEFINIDO' )?></strong></h4>
          <?php if($nome_tipo['tb_conteudo_tipo_nome'])  {?>
            <div class="panel-group" id="painel-carac-tipo">
           
            <!--PANEL NOME    (TAMANHO)-->    
            <?php  
                $consulta_car_tipo = $conexao->consulta("SELECT `tb_caracteristicas_id`,`tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM tb_caracteristicas WHERE tb_caracteristicas_tipo = '$id_tipo'");
                $i = 0;
                while($dados_car_tipo = $conexao->busca($consulta_car_tipo))
                {  $i ++; ?>
              
              <!--adicionar um form aqui -->
              <form id="form_tipo_<?=$i?>" method="post" action="paginas-caracteristicas/<?=$id_conteudo?>">
              <div class="panel panel-default"><!-- panel marker-->
              
                    <div class="panel-heading">
                       <a class="panel-title" data-toggle="collapse" data-parent="#painel-carac-tipo" href="#painel-nome-tipo_<?=$i?>"><?=$dados_car_tipo['tb_caracteristicas_nome']?> </a>
                    </div><!-- name of the stuff stays here-->
                    <input type="hidden" name="txt_carac_id" id="txt_carac_id" value="<?=$dados_car_tipo['tb_caracteristicas_id']?>"/>

                    <div id="painel-nome-tipo_<?=$i?>" class="panel-collapse collapse in"> <!--marker-->
                    
                    <div class="panel-body">
                        <span class="label label-primary"> Valor Padrão</span>
                        <input type="text" class="form-control" disabled style="background-color:#ccc" value="<?=$dados_car_tipo['tb_caracteristicas_valor_padrao']?>" / > <!--padrao stays here-->
                    </div>
                    <?php 
                    $current_id = $dados_car_tipo['tb_caracteristicas_id'];
                    $consulta_opcao = $conexao->consulta("SELECT `tb_caracteristica_opcao_id`,`tb_caracteristica_opcao_conteudo`, `tb_caracteristica_opcao_valor` FROM tb_caracteristica_opcao WHERE `tb_caracteristica_opcao_caracteristica_id` = '$current_id' AND `tb_caracteristica_opcao_conteudo` = '$id_conteudo'");
                    $k = 0;
                    $str = " ";
                    while($dados_opcao = $conexao->busca($consulta_opcao)){
                    $k++;  
                      ?>
              <div class="panel-body">
                  <input type="text" style="width:85%" class="form-control pull-left" name="txt_opcao_<?=$k?>" required value="<?=$dados_opcao['tb_caracteristica_opcao_valor']?>" / > 
                  <input type="hidden" id="txt_id_opt_<?=$k?>" name="txt_id_opt_<?=$k?>" value="<?=$dados_opcao['tb_caracteristica_opcao_id']?>" />
                  <input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao(<?=$dados_opcao['tb_caracteristica_opcao_id']?>)"/>
              </div>
                    <?php 
                    $str .= $k.'-';
                  } 
                
                    ?>
                 <input type="hidden" name="array_opt" value="<?=$str?>"/> 
                <!--adicionar um form aqui -->
                <div id="add_tipo_<?=$i?>"></div>

                </form>  
                <button class="btn btn-success pull-right" onclick="submitForm(form_tipo_<?=$i?>)" style="margin:15px;"><span class="glyphicon glyphicon-ok"></button>  <!-- BOTAO SUBMITTA AJAX input type submit mesmo que se foda-->
                <input type="button" class="btn btn-primary pull-left" onclick = "appendInput('tipo',<?=$i?>)" style="margin:15px; width:40px; height:34px; font-size:15px; font-weight:bold;" value="+"><!-- BOTAO ADD-->

              </div><!--marker-->


            </div><!-- panel marker-->

<?php                }
                ?>
            
            <!--PANEL NOME    (TAMANHO)-->  

            </div>
            <?php } ?>
    </div>


<!--CAT-->
    <div class="col-md-4">
              <h4 class="list-group-item-heading">Categoria - <strong><?=($nome_cat['tb_conteudo_categoria_nome'] != '' ? $nome_cat['tb_conteudo_categoria_nome']  : 'NÃO DEFINIDO' )?></strong></h4>
            
            <?php if($nome_cat['tb_conteudo_categoria_nome'])  {?>
            <div class="panel-group" id="painel-carac-cat">
           
            <!--PANEL NOME    (TAMANHO)-->    
            <?php  
                $consulta_car_cat = $conexao->consulta("SELECT `tb_caracteristicas_id`,`tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM tb_caracteristicas WHERE tb_caracteristicas_categoria = '$id_categoria'");
                $i = 0;
                while($dados_car_cat = $conexao->busca($consulta_car_cat))
                {  $i ++; ?>
              
              <!--adicionar um form aqui -->
              <form id="form_cat_<?=$i?>" method="post" action="paginas-caracteristicas/<?=$id_conteudo?>">
              <div class="panel panel-default"><!-- panel marker-->
              
                    <div class="panel-heading">
                       <a class="panel-title" data-toggle="collapse" data-parent="#painel-carac-cat" href="#painel-nome-cat_<?=$i?>"><?=$dados_car_cat['tb_caracteristicas_nome']?> </a>
                    </div><!-- name of the stuff stays here-->
                    <input type="hidden" name="txt_carac_id" id="txt_carac_id" value="<?=$dados_car_cat['tb_caracteristicas_id']?>"/>

                    <div id="painel-nome-cat_<?=$i?>" class="panel-collapse collapse in"> <!--marker-->
                    
                    <div class="panel-body">
                        <span class="label label-primary"> Valor Padrão</span>
                        <input type="text" class="form-control" disabled style="background-color:#ccc" value="<?=$dados_car_cat['tb_caracteristicas_valor_padrao']?>" / > <!--padrao stays here-->
                    </div>
                    <?php 
                    $current_id = $dados_car_cat['tb_caracteristicas_id'];
                    $consulta_opcao = $conexao->consulta("SELECT `tb_caracteristica_opcao_id`,`tb_caracteristica_opcao_conteudo`, `tb_caracteristica_opcao_valor` FROM tb_caracteristica_opcao WHERE `tb_caracteristica_opcao_caracteristica_id` = '$current_id' AND `tb_caracteristica_opcao_conteudo` = '$id_conteudo'");
                    $k = 0;
                    $str = " ";
                    while($dados_opcao = $conexao->busca($consulta_opcao)){
                    $k++;  
                      ?>
              <div class="panel-body">
                  <input type="text" style="width:85%" class="form-control pull-left" name="txt_opcao_<?=$k?>" required value="<?=$dados_opcao['tb_caracteristica_opcao_valor']?>" / > 
                  <input type="hidden" id="txt_id_opt_<?=$k?>" name="txt_id_opt_<?=$k?>" value="<?=$dados_opcao['tb_caracteristica_opcao_id']?>" />
                  <input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao(<?=$dados_opcao['tb_caracteristica_opcao_id']?>)"/>
              </div>
                    <?php 
                    $str .= $k.'-';
                  } 
                
                    ?>
                 <input type="hidden" name="array_opt" value="<?=$str?>"/> 
                <!--adicionar um form aqui -->
                <div id="add_cat_<?=$i?>"></div>

                </form>  
                <button class="btn btn-success pull-right" onclick="submitForm(form_cat_<?=$i?>)" style="margin:15px;"><span class="glyphicon glyphicon-ok"></button>  <!-- BOTAO SUBMITTA AJAX input type submit mesmo que se foda-->
                <input type="button" class="btn btn-primary pull-left" onclick = "appendInput('cat',<?=$i?>)" style="margin:15px; width:40px; height:34px; font-size:15px; font-weight:bold;" value="+"><!-- BOTAO ADD-->

              </div><!--marker-->


            </div><!-- panel marker-->

<?php                }
                ?>
            
            <!--PANEL NOME    (TAMANHO)-->  


            </div>
            <?php } ?>
    </div>

<!--SUBCAT-->
    <div class="col-md-4">
              <h4 class="list-group-item-heading">SubCategoria - <strong><?=($nome_sub['tb_conteudo_subcategoria_nome'] != '' ? $nome_sub['tb_conteudo_subcategoria_nome']  : 'NÃO DEFINIDO' )?></strong></h4>

            <?php if($nome_sub['tb_conteudo_subcategoria_nome'])  {?>
            <div class="panel-group" id="painel-carac-sub">
           
            <!--PANEL NOME    (TAMANHO)-->    
            <?php  
                $consulta_car_sub = $conexao->consulta("SELECT `tb_caracteristicas_id`,`tb_caracteristicas_nome`, `tb_caracteristicas_valor_padrao` FROM tb_caracteristicas WHERE tb_caracteristicas_subcategoria = '$id_subcategoria'");
                $i = 0;
                while($dados_car_sub = $conexao->busca($consulta_car_sub))
                {  $i ++; ?>
              
              <!--adicionar um form aqui -->
              <form id="form_sub_<?=$i?>" method="post" action="paginas-caracteristicas/<?=$id_conteudo?>">
              <div class="panel panel-default"><!-- panel marker-->
              
                    <div class="panel-heading">
                       <a class="panel-title" data-toggle="collapse" data-parent="#painel-carac-sub" href="#painel-nome-sub_<?=$i?>"><?=$dados_car_sub['tb_caracteristicas_nome']?> </a>
                    </div><!-- name of the stuff stays here-->
                    <input type="hidden" name="txt_carac_id" id="txt_carac_id" value="<?=$dados_car_sub['tb_caracteristicas_id']?>"/>

                    <div id="painel-nome-sub_<?=$i?>" class="panel-collapse collapse in"> <!--marker-->
                    
                    <div class="panel-body">
                        <span class="label label-primary"> Valor Padrão</span>
                        <input type="text" class="form-control" disabled style="background-color:#ccc" value="<?=$dados_car_sub['tb_caracteristicas_valor_padrao']?>" / > <!--padrao stays here-->
                    </div>
                    <?php 
                    $current_id = $dados_car_sub['tb_caracteristicas_id'];
                    $consulta_opcao = $conexao->consulta("SELECT `tb_caracteristica_opcao_id`,`tb_caracteristica_opcao_conteudo`, `tb_caracteristica_opcao_valor` FROM tb_caracteristica_opcao WHERE `tb_caracteristica_opcao_caracteristica_id` = '$current_id' AND `tb_caracteristica_opcao_conteudo` = '$id_conteudo'");
                    $k = 0;
                    $str = " ";
                    while($dados_opcao = $conexao->busca($consulta_opcao)){
                    $k++;  
                      ?>
              <div class="panel-body">
                  <input type="text" style="width:85%" class="form-control pull-left" name="txt_opcao_<?=$k?>" required value="<?=$dados_opcao['tb_caracteristica_opcao_valor']?>" / > 
                  <input type="hidden" id="txt_id_opt_<?=$k?>" name="txt_id_opt_<?=$k?>" value="<?=$dados_opcao['tb_caracteristica_opcao_id']?>" />
                  <input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao(<?=$dados_opcao['tb_caracteristica_opcao_id']?>)"/>
              </div>
                    <?php 
                    $str .= $k.'-';
                  } 
                
                    ?>
                 <input type="hidden" name="array_opt" value="<?=$str?>"/> 
                <!--adicionar um form aqui -->
                <div id="add_sub_<?=$i?>"></div>

                </form>  
                <button class="btn btn-success pull-right" onclick="submitForm(form_sub_<?=$i?>)" style="margin:15px;"><span class="glyphicon glyphicon-ok"></button>  <!-- BOTAO SUBMITTA AJAX input type submit mesmo que se foda-->
                <input type="button" class="btn btn-primary pull-left" onclick = "appendInput('sub',<?=$i?>)" style="margin:15px; width:40px; height:34px; font-size:15px; font-weight:bold;" value="+"><!-- BOTAO ADD-->

              </div><!--marker-->


            </div><!-- panel marker-->

<?php                }
                ?>
            
            <!--PANEL NOME    (TAMANHO)-->  


            </div>
<?php } ?>            
    </div>

<!--append func-->      


    </div>
  </div>
</div>

<script>
function submitForm(nome)
{
  form = '#'+ nome;
  document.getElementById(form).submit()
}

function appendInput(tipo,i)
{
  var tipo = tipo;
  var i = i;

  //validacao de tipo TODO
  if(tipo =='tipo')
  {

    //if tipo, if categ, if subcateg too
    var div = '#add_tipo_'+i;

    $('<div class="panel-body"><input type="text" style="width:85%" required class="form-control pull-left" name="formOpcao[]" value="" / ><input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao()"/></div>').appendTo(div);
  }
  else if(tipo =='cat')
  {
        var div = '#add_cat_'+i;

    $('<div class="panel-body"><input type="text" style="width:85%" required class="form-control pull-left" name="formOpcao[]" value="" / ><input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao()"/></div>').appendTo(div);


  }
  else
  {
        var div = '#add_sub_'+i;

    $('<div class="panel-body"><input type="text" style="width:85%" required class="form-control pull-left" name="formOpcao[]" value="" / ><input type="button" class="btn btn-danger pull-right" value="X" style="font-weight:bold" onclick="processaExclusao()"/></div>').appendTo(div);

  }
  
}

function processaExclusao(id)
{
    $('#span_cont').html('<span style="font-size:20px;" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Carregando...')
    if(id)
      {
            setTimeout(function(){
                $('#span_cont').load("tools/processa_exclusao_opcao.php",{"id":id})
            }, 1000);

      }
      else
      {
        alert('Por favor, adicione a opção antes de excluí-la');  
      }
}
</script>
<?php require_once('public/footer.php');?>