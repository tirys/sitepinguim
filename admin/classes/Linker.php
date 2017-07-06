<?php
class Linker
{
	/*
		* Author: Igor Soares <igor.larcs@hotmail.com>
		* obs:  caso a conexão com o banco de dados mude, dar um jeito de injetar dependência na classe, NUNCA chamar outro objeto dentro desse objeto.
		 * protected  @tabela String que estabelece a tabela na qual a linkagem ocorre
     	ex: 'tb_comentarios'
     	campo de linkagem -> 'tb_comentarios_id_produto' (definido mais pra frente)
     */
	protected $tabela = 'tb_conteudo';
	/*
     * protected  @ancora Array associativo que define o campo de linkagem definido acima
     	ex: array('tb_comentarios_id_produto' => 140)
     */
	protected $ancora;
	/*
     * protected  @fields Array associativo que define os campos do formulário e suas respectivas translações para com o banco
     	ex: array('tb_comentarios_nome' => 'nome', 'tb_comentarios_mensagem' => 'mensagem') ONDE
     	(nome do campo 'mensagem' no formulário quivale a 'mensagem', 'nome', etc..)
     */
	protected $fields;
	/*
     * protected  @output Qualquer tipo de mensagem a ser passada
     */
	protected $output;
	/*
     * exemplo de uso classe Linker:
			*	 $linker = new Linker();
			*	 $linker->addAnchor(array('tb_conteudo_categoria' => 103 ));
			*	 $linker->addFields(array('tb_conteudo_titulo' => 'nome',
			*														'tb_conteudo_texto_curto' => 'email',
			*														'tb_conteudo_texto_longo' =>'comentario',
			*														'tb_conteudo_data' => date("Y-m-d")));
			*	 $linker->exec();
		*
     */
	public function __construct()
	{

	}

	public function exec()
	{
		if($this->checkParams())
		{
				if($this->postHandler())
				{
						$this->dbHandler($this->queryPrep());
						$this->outputMsg();
				}
		}
	}

	private function outputMsg()
	{
			if(!empty($this->output))
			{
				echo '<script>alert("'.$this->output.'")</script>';
				//echo '<span class="alert alert-warning"><strong>'.$this->output.'</strong></span><br/><br/><br/>';
			}
	}
	private function dbHandler($query_str)
	{
		if(!empty($query_str))
		{
			if($query_str != 'vazio')
			{
				if(!conexao::exec($query_str))
				{
					$this->output = "ERROR: Something went wrong, please try again later!";
				}
				else
				{
					$this->output = "SUCCESS: Submitted successfully!";
				}
			}
			else
			{
					$this->output = "ERRO: Please, fill up all fields!";
			}
		}
		else
		{
				$this->output = "ERRO: User already exists!";
		}
		return $this;
	}

	private function queryPrep()
	{
			$query_check = 'SELECT * FROM '.$this->tabela.' WHERE ';
			foreach($this->fields as $key => $val)
			{
				if($val != date("Y-m-d") )
				{
					$query_check.= $key.' = "'.mysqli_real_escape_string(conexao::object(),$val).'" AND ';
				}
			}
			$query_check = rtrim($query_check, " AND ");

			if(conexao::count($query_check))
			{
					// $query_str = 'UPDATE '.$this->tabela.' SET ';
					// foreach($this->fields as $key => $val)
					// {
					// 	$query_str .= $key.' = "'.mysqli_real_escape_string(conexao::object(),$this->val).'",';
					// }
					// $query_str = rtrim($query_check, ",");
					// reset($this->ancora);
					// $query_str .= 'WHERE '.key($this->ancora).' = "'.current($this->ancora).'"';
					$query_str = '';
			}
			else
			{
				$array_keys = array();
				$array_vals = array();
				foreach($this->fields as $key=>$val)
				{
					array_push($array_keys, $key);
					array_push($array_vals, '"'.mysqli_real_escape_string(conexao::object(),$val).'"');
				}
				if(in_array('"vazio"', $array_vals))
				{
					$query_str = 'vazio';
				}
				else
				{
					$keyz 	= implode(',',$array_keys);
					$values = implode(',',$array_vals);
					reset($this->ancora);
					$query_str = 'INSERT INTO '.$this->tabela.' ( '.$keyz.','.key($this->ancora).') VALUES ('.$values.','.current($this->ancora).')';
				}

			}
			return  $query_str;
	}

	private function postHandler()
	{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
					if(isset($_POST['name']))
					{
							return $this->checkPOST($this->fields);
					}
			}
			return false;
	}

	private function checkPOST($array_params)
	{
		foreach($array_params as $key => $val)
		{
				if(isset($_POST[$val]))
				{
					if(!empty($_POST[$val]))
					{
						$this->fields[$key] = $_POST[$val];
					}
					else
					{
						$this->fields[$key] = 'vazio';
					}
				}
				else
				{
					$this->fields[$key] = $val;
				}
		}
		return $this;
	}

	private function checkParams()
	{
		if(!empty($this->ancora) && !empty($this->fields))
		{
				return true;
		}
		return false;
	}

	public function addAnchor($param)
	{
			if(is_array($param))
			{
					$this->ancora = $param;
			}
	}

	public function addFields($param)
	{
			if(is_array($param))
			{
					$this->fields = $param;
			}
	}


}
