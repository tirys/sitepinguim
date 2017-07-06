<?php 
require_once('../vendor/load_ext.php');
if (isset($_POST['id'])){
                $conexao = new Conexao(); 
                $consulta = $conexao->consulta('SELECT * FROM tb_localidade_cidade
				WHERE tb_localidade_cidade_estado = "'.$_POST['id'].'"
				order by tb_localidade_cidade_nome');

				$count = $conexao->conta($consulta);
				if (!$count) 
					{ 
						echo "<option value=''>Estado sem Cidade cadastrado</option>";
					}
					else
					{
                		while($consulta_whatev = $conexao->busca($consulta))
                			{ ?>
                					<option value="<?php echo $consulta_whatev['tb_localidade_cidade_id'];?>">
									<?php echo $consulta_whatev['tb_localidade_cidade_nome'];?>
                					</option>          
			
<?php } } } ?>
