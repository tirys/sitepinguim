<?php
  require_once('vendor/load.php');
  $id = $_GET['id'];
  $itensUnidade[] = "";

  $nome = conexao::fetchuniq("SELECT tb_unidade_nome FROM tb_unidade WHERE tb_unidade_id = {$id}");

  $cardapio = conexao::fetch("SELECT tb_conteudo.tb_conteudo_id, tb_conteudo.tb_conteudo_titulo FROM tb_conteudo WHERE tb_conteudo.tb_conteudo_tipo = 6");

  $itens = conexao::fetch("SELECT tb_unidade_cardapio.tb_unidade_cardapio_id_conteudo FROM tb_unidade_cardapio WHERE tb_unidade_cardapio.tb_unidade_cardapio_id_unidade = ".$id);

  foreach ($itens as $value){
    $itensUnidade[] = $value['tb_unidade_cardapio_id_conteudo'];
  }

?>
<?php require_once('public/header.php');?>

<input type="hidden" name="id_unidade" value="<?= $id ?>">
<table width="100%" border="0" cellpadding="5">
  <tr>
    <td width="31%"><h2>Cardápio da Unidade <?= $nome['tb_unidade_nome'] ?></h2></td>
  </tr>
</table>

<form>
  <table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
      <thead>
        <tr>
          <th width="100px;">Ativo / Inativo</th>
          <th width="100px;">Identificador</th>
          <th width="700px;">Nome</th>    
        </tr>
      </thead>
      <tbody>

      <?php
          foreach($cardapio as $value){
            echo '<tr>';

            if(in_array($value['tb_conteudo_id'], $itensUnidade)){
              echo '<td width="100px;"><input type="checkbox" name="cardapio" value="'.$value['tb_conteudo_id'].'" checked></td>';
              echo '<td width="100px;">'.$value['tb_conteudo_id'].'</td>';
              echo '<td width="700px;">'.$value['tb_conteudo_titulo'].'</td>';
            }else{
              echo '<td width="100px;"><input type="checkbox" name="cardapio" value="'.$value['tb_conteudo_id'].'"></td>';
              echo '<td width="100px;">'.$value['tb_conteudo_id'].'</td>';
              echo '<td width="700px;">'.$value['tb_conteudo_titulo'].'</td>';
            }
            
            echo '</tr>';
          }
      ?>
      </tbody>
  </table>
</form>


  

<?php require_once('public/footer.php');?>

<script type="text/javascript">
  
  $('[name=cardapio]').on('change', function(){
    var id_item = $(this).attr('value');
    var id_unidade = $('[name=id_unidade]').val();
    var check = $(this).is(":checked");
    $.ajax({
      method: "POST",
      url: "tools/adiciona_remove_cardapio.php",
      data: { idUnidade: id_unidade, idItem: id_item, acao: check }
    })
    .done(function() {
    });

  });

  

</script>