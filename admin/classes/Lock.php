<?php
class Lock
{
	private $config = array();
	private $quant_locks;
	private $page_id;

	function __construct()
	{
		require_once('Conexao.php');
		$this->sessionCheck();
	}


	public function flushSesh()
	{
		unset($_SESSION['lock_config']);
	}

	public function lockReader()
	{
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$id = $this->getPageId();
			if(isset($_POST['lock_handler']))
			{
				if($_POST['lock_handler'] == 0)
				{
					return 'delete';
				}
				elseif($_POST['lock_handler'] != 0)
				{
					return 'add';
				}
				else
				{
					return 'undefined';
				}
			}
		return false;
		}
		return false;
	}


	public function lockHandler($pagina)
	{

		if($this->userCheck())
			{
		
					if($lock = $this->isLocked($pagina))
					{
						($lock == '99999' || $lock == '9999'  ? $output = 'ILIMITADO' : $output = $lock . ' Registro(s)' );
						?>
						<select id="lock_handler" name="lock_handler" class="form-control">
						<option selected="selected" value="<?=$lock?>"><?=$output?></option>		
						<?php if($output != 'ILIMITADO')
						{ ?>
						<option value="0">ILIMITADO</option>		
						<?php }	
						 for($i = 1; $i <= 99; $i++)
						{ ?>
						<option value="<?=$i?>"><?=$i . ' Registro(s)'?></option>		
						<?php }
						?>
						</select>
						<?php

					}
					else
					{ 	
						?>
				
						<select id="lock_handler" name="lock_handler" class="form-control">
						<option selected="selected" value="0">ILIMITADO</option>		
						<?php for($i = 1; $i <= 99; $i++)
						{ ?>
						<option value="<?=$i?>"><?=$i . ' Registro(s)'?></option>		
						<?php }
						?>
						</select>
						<?php
				}
			 }
		
		else
		{
			$this->terminate();
		}
	}

	public function addLock($type,$id,$qnt)
	{	
		return $this->actionLock($type,$id,$qnt);
	}

	public function delLock($type,$id)
	{
		return $this->actionLock($type,$id, '99999');
	}	
	
	public function lock_btn($type, $str) 
	{
		//maybe fazer validação de usuário
		if($this->configInitLocking())
		{

			$conexao = new Conexao();
			$id_cat = $this->page_id;

			$consulta = $conexao->consulta("SELECT `tb_conteudo_id` from tb_conteudo WHERE tb_conteudo_categoria = '$id_cat'");
			$count = $conexao->conta($consulta);
			if($count >= $this->quant_locks)
			{
				$out ='';	
				$this->display($out);
			}
			else
			{
				$this->display($str);
			}

		}

		else
		{
			$this->display($str);
		}
	}


	private function isLocked($type)
	{
		if($this->globalInit())
		{
			$id_to_check = $this->getPageId();
			if(array_key_exists($id_to_check, $_SESSION['lock_config'][$type]))
			{
				$lmao = $_SESSION['lock_config'][$type][$id_to_check]; 
				return $lmao;

			}
			return false;
		}
		return false;
	}

	private function bdAdd($id, $qnt)
	{
		$checka_lock = Conexao::count("SELECT * FROM tb_lock WHERE tb_lock_pagina  = {$id}");
		if($checka_lock)
		{
			$query = Conexao::query("UPDATE tb_lock
											SET tb_lock_pagina_quantidade = {$qnt}
											WHERE tb_lock_pagina = {$id}");
			if($query)
			{
				return true;
			}
			return false;
		}
		else
		{
			$query = Conexao::query("INSERT INTO tb_lock (tb_lock_pagina, tb_lock_pagina_quantidade) VALUES ({$id}, {$qnt})");
			if($query)
			{
				return true;
			}
			return false;
		}

	}


	private function initSesh()
	{
		//popula a $_SESSION['lock_config']
		//com os dados dos bancos, pretty ok tbh 
		$locks = Conexao::fetch("SELECT * FROM tb_lock");
		//ta pegando ja dom
		foreach($locks as $lock)
		{
			$id = $lock['tb_lock_pagina'];
			$qnt = $lock['tb_lock_pagina_quantidade'];
			$_SESSION['lock_config']['paginas'][$id] = $qnt;
		}
	} 


	private function sessionCheck()
	{

		if(isset($_SESSION['lock_config']))
		{
			$this->initSesh();	
			return $this->config = $_SESSION['lock_config'];
		}
		else
		{
			$_SESSION['lock_config'] = array(
			'paginas' => array(),
			'banners'=> array()
			);
			$this->initSesh();	
			
			return $this->config = $_SESSION['lock_config'];
		}

			return false;
	}


	private function add_withinClass($type,$id,$qnt)
	{
		return $this->actionLock($type,$id,$qnt);
	}

	private function delete_withinClass($type,$id)
	{
		return $this->actionLock($type,$id, '99999');
	}	

	private function actionLock($type,$id, $qnt)
	{	
		//adicionar in tha bank \/

		if($this->userCheck())
		{
			$this->globalInit();
			$config_to_use = $this->config;
			
			if(array_key_exists($type, $config_to_use))
			{
				$config_to_use = $config_to_use[$type];
				if(is_array($config_to_use))
				{
						 $_SESSION['lock_config'][$type][$id] =  $qnt;						

						 if($this->bdAdd($id, $qnt))
						 {
						 	return true;
						 }

				}
			}
		}
			return false;
	}


	private function userCheck()
	{
		if(isset($_SESSION['usuarioTipo']))
		{
			$tipo = $_SESSION['usuarioTipo'];	
			if($tipo == 1)
			{
				return true;
			}
		}
		return false;
	}

	private function getPageId()
	{
		if (isset($_GET['id']))
		{
			$id = $_GET['id'];
			return $id;
		}
		else
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";	
			$check = explode('/',$actual_link);
			$count = count($check) - 1;
			$id = $check[$count];
			if(is_numeric($id))
			{
				return $id;				
			}
		}

			return null;
	}


	private function configInitLocking()
	{
			if($this->globalInit())
			{
				if($this->getConfigKeys())
				{

					return true;					
				}	

			}
			return false;
	}


	private function getConfigKeys()
	{
		//DEPRECATED BUT STILL USING IT AYE_LMAO
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";	
		$check = explode('/',$actual_link);
		$offset = array_search('admin', $check);
		$count = count($check) - 1;
		$id = $check[$count];
		$url_param = $check[$offset + 1];	
		
		if(array_key_exists($url_param, $this->config))
		{
			$arr_location = $this->config[$url_param];
			if(array_key_exists($id, $arr_location))
			{	
				$this->page_id = $id;
				$this->quant_locks = $arr_location[$id];

				return true; 
			}

		}
			return false;
	}


	private function globalInit()
	{
		if(!isset($_SESSION['lock_config']))
		{
			throw new Exception('Dependency error');
		}
		else
		{	
		 	return 	$this->config = $_SESSION['lock_config'];
		}

		return false;

	}

	private function display($var)
	{	
		if(isset($var))
		{
			echo $var;		
		}
	}

	private function terminate()
	{
		return false;
	}

	private function log($var)
	{
			if(is_array($var))
			{
				$var = print_r($var,true);
			}
			$str = 'Log:'.date('H:i:s').' --> '.$var;
			var_dump($str);
	}


}
