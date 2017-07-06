<?php 
      require_once('vendor/load.php');
      require_once('public/header.php');
?>
<table width="100%" border="0" cellpadding="5">
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['upload'])
    {
      $tipos = array('application/pdf','text/plain','text/csv');
      $tamanho = '2M';
      $file = $build->getFile($tipos,$tamanho);
  try { 
      $file->upload();

    $data = array(
        'name'       => $file->getNameWithExtension(),
        'extension'  => $file->getExtension(),
        'size'       => $file->getSize(),
        'path'       => 'uploads/arquivos/'.rawurlencode($file->getNameWithExtension())
    );

    $execute = Conexao::exec("INSERT INTO tb_arquivos (tb_arquivos_nome, tb_arquivos_tipo, tb_arquivos_tamanho, tb_arquivos_path) VALUES ('".$data['name']."','".$data['extension']."','".$data['size']."','".$data['path']."')");
    $msgSucesso = ['ARQUIVO ENVIADO COM SUCESSO:', $file->getNameWithExtension()];
  } catch (\Exception $e) {
      $msgSucesso = ['ERRO:', 'Arquivo não suportado, já existente ou maior que 2MBs'];
  }
    }
    if(isset($_GET['acao']) && $_GET['acao'] == 'excluir')
    {
      $id = mysqli_real_escape_string(Conexao::object(), $_GET['id']);
      $nome_arquivo = Conexao::fetchuniq("SELECT tb_arquivos_nome FROM tb_arquivos WHERE tb_arquivos_id = {$id}");
      unlink('uploads/arquivos/'.$nome_arquivo['tb_arquivos_nome']);
      $execute = Conexao::exec("DELETE FROM tb_arquivos WHERE tb_arquivos_id = {$id}"); 
      $msgSucesso = ['ARQUIVO DELETADO COM SUCESSO:', ''];
    }
?>
  <tr>
    <td width="13%"><h2>Arquivos</h2></td>
    <td width="53%">
      <?php 
      if ($msgSucesso){?>
      <div class="alert alert-warning" style="padding:5px; margin-top:28px; margin-bottom:0px;"><?=$msgSucesso[0].' '.$msgSucesso[1]?></div>
      <?php } ?>
    </td>
    <td width="27%" align="right">
      <form method="POST" enctype="multipart/form-data">
          <input type="file" name="arquivo" value=""/>
          <input type="submit" name="upload" class="btn btn-success" value="Subir Arquivo"/>
      </form>
    </td>
  </tr>
  <tr>
    <td colspan="3" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0" class="table display" id="data_table">
      <thead>
        <tr>
          <th width="104">Identificador</th>
          <th width="250">Nome</th>
          <th width="150">Caminho</th>
          <th width="50">Tipo</th>
          <th width="120">Data</th>
          <th width="33">Tamanho</th>
          <th width="33">&nbsp;</th>
          </tr>
        </thead>
      <tbody>
<?php
    $arquivos = Conexao::fetch("SELECT * FROM tb_arquivos");
     foreach($arquivos as $single_arquivo)
      { 
?>
        <tr>
          <td><?=$single_arquivo['tb_arquivos_id']?></td>
          <td><?=$single_arquivo['tb_arquivos_nome']?></td>
          <td><?=$single_arquivo['tb_arquivos_path']?></td>
          <td><?=$single_arquivo['tb_arquivos_tipo']?></td>
          <td><?=$single_arquivo['tb_arquivos_data']?></td>
          <td><?=$single_arquivo['tb_arquivos_tamanho']?> Bytes</td>
          <td>
            <a href="arquivos/excluir/<?=$single_arquivo['tb_arquivos_id']?>" title="Editar" class="btn btn-danger btn-xs">Excluir</a></td>
          </tr>
<?php
     } 
?>
        </tbody>
      <tfoot>
        <tr>
          <th>Identificador</th>
          <th>Nome</th>
          <th>Categoria</th>
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
