<?php 
require_once('../_config.php');
require_once('../conexao/classeconexao.php');
?>
<?php 
if (isset($_POST['id'])){
                $conexao = new classeConexao(); 
                $consulta = $conexao->consulta('
				SELECT * FROM tb_conteudo_subcategoria
				WHERE tb_conteudo_subcategoria_id_categoria = "'.$_POST['id'].'"
				order by tb_conteudo_subcategoria_nome');
                while($consultaSubCategoria = $conexao->busca($consulta)){
				?>
                <option value="<?php echo $consultaSubCategoria['tb_conteudo_subcategoria_id'];?>">
				<?php echo $consultaSubCategoria['tb_conteudo_subcategoria_nome'];?>
                </option>          
			
<?php }} ?>

