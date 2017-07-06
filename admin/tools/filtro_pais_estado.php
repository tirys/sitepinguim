<?php 
require_once('../_config.php');
require_once('../conexao/classeconexao.php');
?>
<?php 
if (isset($_POST['id'])){
                $conexao = new classeConexao(); 
                $consulta = $conexao->consulta('
				SELECT * FROM tb_localidade_estado
				WHERE tb_localidade_estado_pais = "'.$_POST['id'].'"
				order by tb_localidade_estado_nome');
				$consultaInformacao = $conexao->busca($consulta);
				if (empty($consultaInformacao)) {
					echo "<option value=''>País sem Estado cadastrado</option>";
					}else{
					echo "<option value=''>Selecione um Esado aqui</option>";
                while($consultaInformacao = $conexao->busca($consulta)){
				?>
                <option value="<?php echo $consultaInformacao['tb_localidade_estado_id'];?>">
				<?php echo $consultaInformacao['tb_localidade_estado_nome'];?>
                </option> 
                  
			
<?php } } } ?>
