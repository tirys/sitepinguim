<?php
require_once('vendor/load.php');

if (isset($_GET['acao'])) {
    if ($_GET['acao'] == 'gravar' and $_SERVER['REQUEST_METHOD'] == 'POST'){
		

        $conexao = new Conexao();
        $consulta = $conexao->consulta('SELECT tb_conteudo_id FROM tb_conteudo where tb_conteudo_link_automatico = "' . ConverteURL($_POST['txt_nome']) . '"');
        
		$contaRegistrosMesmoLinkAutomatico = $conexao->conta($consulta);
        if ($contaRegistrosMesmoLinkAutomatico == 0) {



            // SE DEU ERRO NA INSERÇÃO, RECUPERA INFORMAÇÕES DA subCATEGORIA ANTERIORMENTE ESCOLHIDA

            $conexao = new Conexao();
            $consulta = $conexao->consulta('SELECT 	tb_conteudo_categoria_id_tipo FROM tb_conteudo_categoria where tb_conteudo_categoria_id = "' . $_POST['txt_categoria'] . '"');
            while ($consultaConteudoTipo = $conexao->busca($consulta)) {
                $var_tipo_conteudo = $consultaConteudoTipo['tb_conteudo_categoria_id_tipo'];
            }

            $conexao = new Conexao();
            $consulta = $conexao->consulta('INSERT INTO tb_conteudo (
		tb_conteudo_titulo,
		tb_conteudo_texto_curto,
		tb_conteudo_texto_longo,
		tb_conteudo_texto_longo2,
		tb_conteudo_texto_longo3,
		tb_conteudo_texto_longo4,
		tb_conteudo_texto_longo5,
		tb_conteudo_texto_longo6,
		tb_conteudo_data,
		tb_conteudo_tipo,
		tb_conteudo_categoria,
		tb_conteudo_subcategoria,
		tb_conteudo_link_automatico,
		tb_conteudo_descricao_busca,
		tb_conteudo_palavras_chaves_busca,
		tb_conteudo_video
		) values (
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_curto'])) . '",
                "' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo']) . '",
				"' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo2']) . '",
				"' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo3']) . '",
				"' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo4']) . '",
				"' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo5']) . '",
				"' . mysqli_real_escape_string($conexao->obj(),$_POST['txt_texto_longo6']) . '",
                "' . ConverteData(mysqli_real_escape_string($conexao->obj(),$_POST['txt_data'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$var_tipo_conteudo)) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_categoria'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_subcategoria'])) . '",
                "' . ConverteURL(mysqli_real_escape_string($conexao->obj(),$_POST['txt_nome'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_descricao_busca'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_palavra_chave'])) . '",
                "' . strip_tags(mysqli_real_escape_string($conexao->obj(),$_POST['txt_video'])) . '"
                )');
            header("location: ../../paginas-editar/resgatar-dados/" . $consulta);

            $msgSucesso = true;
        } else {
            $msgErro = true;
        }
    }
}
?>

<?php require_once('public/header.php'); ?>
<table width="100%" border="0" cellpadding="5">
    <form action="paginas-adicionar/gravar/<?php echo $_GET['id'] ?>" method="post">
    
        <tr>
            <td colspan="3"><h1>Nova Página</h1></td>
            <td width="37%" align="right">
                <?php if ($msgErro == true) { ?>
                    <div class="alert alert-danger" style="padding:5px; margin-top:18px; margin-bottom:0px;">Já existe um conteúdo com este. Escolha outro nome.</div>
                <?php } ?>


            </td>
            <td width="7%" align="right"><input type="submit" class="btn btn-success" /></td>
        </tr>
        <tr>
            <td colspan="5"><table width="100%" border="0" cellpadding="5">
                    <tr>
                        <td width="20%">Nome da Página</td>
                        <td width="20%">Texto Curto</td>
                        <td width="20%">Categoria</td>
                        <td width="20%">Sub-Categoria</td>
                        <td width="20%">Data</td>
                    </tr>
                    <tr>
                        <td><input name="txt_nome" type="text" class="form-control" id="txt_nome" value="<?php if (isset($_POST['txt_nome'])) {
                    echo $_POST['txt_nome'];
                } ?>" /></td>
                        <td><input name="txt_texto_curto" type="text" class="form-control" id="txt_texto_curto" value="<?php if (isset($_POST['txt_texto_curto'])) {
                    echo $_POST['txt_texto_curto'];
                } ?>" maxlength="500"/></td>
                        <td>

                            <!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS -->
                            <select name="txt_categoria" id="txt_categoria" class="form-control" onchange="getValor(this.value, 0)">

                                <?php
                                // SE DEU ERRO NA INSERÇÃO, RECUPERA INFORMAÇÕES DA CATEGORIA ANTERIORMENTE ESCOLHIDA
                                if (isset($_POST['txt_categoria'])) {
                                    $conexao = new Conexao();
                                    $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria where tb_conteudo_categoria_id = "' . $_POST['txt_categoria'] . '"');
                                    while ($consultaCategoriaAnterior = $conexao->busca($consulta)) {
                                        ?>
                                        <option value="<?php if (isset($_POST['txt_categoria'])) {
                                    echo $_POST['txt_categoria'];
                                } ?>"><?php echo $consultaCategoriaAnterior['tb_conteudo_categoria_nome']; ?></option>          
                                    <?php }
                                } ?>


                                <?php
                                // BUSCANDO O NOME E O ID DA CATEGORIA QUE FOI SELECIONADA PARA ADICIONAR UM NOVO REGISTRO
                                $tipo = NULL;
                                $conexao = new Conexao();
                                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria where tb_conteudo_categoria_id = "' . $_GET['id'] . '" order by tb_conteudo_categoria_nome');
								while ($consultaCategoriaPrincipal = $conexao->busca($consulta)) {
                                	$tipo = $consultaCategoriaPrincipal['tb_conteudo_categoria_id_tipo'];
									?>
                                    <option value="<?php echo $consultaCategoriaPrincipal['tb_conteudo_categoria_id'] ?>"><?php echo $consultaCategoriaPrincipal['tb_conteudo_categoria_nome'] ?></option>          
                                <?php } ?>

								<?php
                                // CHAMANDO DEMAIS CATEGORIAS
								$conexao = new Conexao();
                                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_categoria order by tb_conteudo_categoria_nome');
                                while ($consultaCategoria = $conexao->busca($consulta)) {
								    ?>
                                    <option value="<?php echo $consultaCategoria['tb_conteudo_categoria_id'] ?>"><?php echo $consultaCategoria['tb_conteudo_categoria_nome'] ?></option>          
                                <?php } ?>
                            </select>
                            <!-- CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS CATEGORIAS -->

                        </td>
                        <td>
                            <select name="txt_subcategoria" id="txt_subcategoria" class="form-control">

            <?php
            // SE DEU ERRO NA INSERÇÃO, RECUPERA INFORMAÇÕES DA subCATEGORIA ANTERIORMENTE ESCOLHIDA
            if (isset($_POST['txt_subcategoria'])) {
                $conexao = new Conexao();
                $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_subcategoria where tb_conteudo_subcategoria_id = "' . $_POST['txt_subcategoria'] . '"');
                while ($consultaSubCategoriaAnterior = $conexao->busca($consulta)) {
                    ?>
                                                    <option value="<?php if (isset($_POST['txt_subcategoria'])) {
                                                echo $_POST['txt_subcategoria'];
                                            } ?>"><?php echo $consultaSubCategoriaAnterior['tb_conteudo_subcategoria_nome']; ?></option>          
                <?php }
            } ?>


            <?php
            // BUSCANDO O NOME E O ID DA CATEGORIA QUE FOI SELECIONADA PARA ADICIONAR UM NOVO REGISTRO
            $conexao = new Conexao();
            $consulta = $conexao->consulta('SELECT * FROM tb_conteudo_subcategoria where tb_conteudo_subcategoria_id_categoria = "' . $_GET['id'] . '" order by tb_conteudo_subcategoria_nome');
            while ($consultaCategoriaPrincipal = $conexao->busca($consulta)) {
                ?>
                                                <option value="<?php echo $consultaCategoriaPrincipal['tb_conteudo_subcategoria_id'] ?>"><?php echo $consultaCategoriaPrincipal['tb_conteudo_subcategoria_nome'] ?></option>          
            <?php } ?>

                                        </select></td>
                                    <td><input name="txt_data" type="text" class="form-control" id="txt_data" value="<?php if (isset($_POST['txt_data'])) {
                echo $_POST['txt_data'];
            } else {
                echo date("j-m-Y");
            } ?>" /></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Descrição Motor de Busca</td>
                                    <td colspan="2">Palavras-Chaves (separado por vírgula)</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><input name="txt_descricao_busca" type="text" class="form-control" id="txt_descricao_busca" value="<?php if (isset($_POST['txt_descricao_busca'])) {
                echo $_POST['txt_descricao_busca'];
            } ?>" /></td>
                                    
                                    <td colspan="2"><input name="txt_palavra_chave" type="text" class="form-control" id="txt_palavra_chave" value="<?php if (isset($_POST['txt_palavra_chave'])) {
                echo $_POST['txt_palavra_chave'];
            } ?>" /></td>
                                </tr>
                                
            <?php 
            //checar categoria
            	if($_GET['id'] != 57){ ?>
                                    
                                <tr>
                                    <td colspan="5">Conteúdo</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                    <textarea id="texto_longo" name="txt_texto_longo" rows="10" cols="80">
                                    </textarea>
            						<script type="text/javascript">
                                      var editor = CKEDITOR.replace('txt_texto_longo');
                                      CKFinder.setupCKEditor(editor, '../../js/ckeditor/ckfinder');
                                    </script></td>
                                </tr>
                                <input type="hidden" name="txt_texto_longo2" value="<?=isset($dados['tb_conteudo_texto_longo2']) ? $dados['tb_conteudo_texto_longo2'] : NULL;?>" />
            					<input type="hidden" name="txt_texto_longo3" value="<?=isset($dados['tb_conteudo_texto_longo3']) ? $dados['tb_conteudo_texto_longo3'] : NULL;?>" />
                                <input type="hidden" name="txt_texto_longo4" value="<?=isset($dados['tb_conteudo_texto_longo4']) ? $dados['tb_conteudo_texto_longo4'] : NULL;?>" />
            					<input type="hidden" name="txt_texto_longo5" value="<?=isset($dados['tb_conteudo_texto_longo5']) ? $dados['tb_conteudo_texto_longo5'] : NULL;?>" />
                                <input type="hidden" name="txt_texto_longo6" value="<?=isset($dados['tb_conteudo_texto_longo6']) ? $dados['tb_conteudo_texto_longo6'] : NULL;?>" />

            <?php
            	}else{
                          ?>
                                <tr>
                                    <td colspan="5">Conteúdo</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                    <textarea id="texto_longo" name="txt_texto_longo" rows="10" cols="80">
                                    </textarea>
                                    <script type="text/javascript">
                                      var editor = CKEDITOR.replace('txt_texto_longo');
                                      CKFinder.setupCKEditor(editor, '../../js/ckeditor/ckfinder');
                                    </script></td>
                                </tr>
                                <tr>
                                    <td colspan="5">Link da Notícia</td>
                                </tr>
                                <tr>
                                <td colspan="5">
                                <input type="text" class="form-control" name="txt_texto_longo2" value="<?=isset($dados['tb_conteudo_texto_longo2']) ? $dados['tb_conteudo_texto_longo2'] : NULL;?>" />
                                </td>
                                </tr>
                                <input type="hidden" name="txt_texto_longo3" value="<?=isset($dados['tb_conteudo_texto_longo3']) ? $dados['tb_conteudo_texto_longo3'] : NULL;?>" />
                                <input type="hidden" name="txt_texto_longo4" value="<?=isset($dados['tb_conteudo_texto_longo4']) ? $dados['tb_conteudo_texto_longo4'] : NULL;?>" />
                                <input type="hidden" name="txt_texto_longo5" value="<?=isset($dados['tb_conteudo_texto_longo5']) ? $dados['tb_conteudo_texto_longo5'] : NULL;?>" />
                                <input type="hidden" name="txt_texto_longo6" value="<?=isset($dados['tb_conteudo_texto_longo6']) ? $dados['tb_conteudo_texto_longo6'] : NULL;?>" />
            

<?php
	} ?>                        
                </table></td>
        </tr>

		<tr>
          <td colspan="5">Vídeo <i>(código de incorporação)</i></td>
        </tr>
        <tr>
          <td colspan="5">
          <textarea id="txt_video" name="txt_video" rows="3" cols="80" class="form-control" style="width:100%"></textarea>
          </td>
        </tr>    

        <tr>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="16%">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </form>
</table>
<?php require_once('public/footer.php'); ?>

