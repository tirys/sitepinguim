<?php
    require_once '../vendor/bundler_ext.php';
	if(isset($_GET['cidade']))
	{
		$cidadeNome = $_GET['cidade'];
		$res 		= conexao::fetch("SELECT * FROM tb_unidade 
	                                  LEFT JOIN tb_localidade_estado ON tb_unidade.tb_unidade_estado = tb_localidade_estado.tb_localidade_estado_id 
	                                  LEFT JOIN tb_localidade_cidade ON tb_unidade.tb_unidade_cidade = tb_localidade_cidade.tb_localidade_cidade_id
									  WHERE tb_localidade_cidade.tb_localidade_cidade_nome = '".$cidadeNome."'"); 
		if($res)
		{
			?>
            <h3 class="titulo-principal titulo-local"><?=$_GET['cidade']?></h3>
            <div class="listagem-itens">
                <?php
                    $iterator->loadBlock('unidades_bloco.html')
                             ->addFilter('urlfyLink',array('unidades-detalhe','unidade',1,'tb_unidade_login'),'tb_unidade_login')
                             ->addFilter('urlfyImg',array('tb_unidade_imagem','unidade'),'tb_unidade_imagem')
                             ->iterate($res);
                ?>
            </div>
			<?php
		}
		else
		{
			?>
	            <h3 class="titulo-principal titulo-local"><?=$_GET['cidade']?></h3>
				<div class="listagem-itens">
				<p>Ainda não temos unidades no local, <a href="<?=URL_INSTALACAO?>landing">CLIQUE AQUI</a> e saiba mais!</p>
				</div>
			<?php
		}
	}
	else
	{
		echo "<script type='text/javascript'>window.location.href = '".URL_INSTALACAO."'</script>";
	}
?>	