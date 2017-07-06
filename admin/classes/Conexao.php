<?php
$build = new Builder();
$config = $build->getConfig();
define('USER', $config->get('database.username'));
define('BD', $config->get('database.name'));
define('SERVER', $config->get('database.host'));
define('SENHA', $config->get('database.password'));

class Conexao {

	protected $user     = USER; // Usuário do banco de dados
	protected $senha    = SENHA; // Senha do banco de dados
	protected $bd       = BD; // Nome do Banco de dados MySQL
	protected $server   = SERVER; //host – servidor
	protected $con;


	//Construtor
	public function __construct()
	{
		$this->con = mysqli_connect($this->server, $this->user, $this->senha,$this->bd) or die('Falha ao conectar com o banco de dados');
	}

	//retorna o objeto da conexão
	public function obj()
	{
		return $this->con;
	}

	//Encerra a conexão
	public function desconectar()
	{
		mysqli_close($this->con);
	}

	public function ultimo_id()
	{
		return mysqli_insert_id($this->con);
	}
	//Executa query sql
	public function consulta($sql)
	{
		$res = mysqli_query($this->con,$sql) or die(mysqli_error($this->con));
		if(!$res)
		{
			return false;
		}
		else
		{
			if(substr($sql,0,6) == 'INSERT' && mysqli_insert_id($this->con))
			{
				return mysqli_insert_id($this->con);
			}
			else
			{
				return $res;
			}
		}
		mysqli_free_result($res);
	}

	//Número de resultados que atendem a uma dada consulta
	public function conta($res) {
		if($res){
			return mysqli_num_rows($res);
		}
	}

	//Array resultado do select
	public function busca($res) {
		if($res){
			return mysqli_fetch_array($res,MYSQLI_ASSOC);
		}
	}


	public static function query($query_str)
	{
		$conexao = new Conexao();
		if($consulta = $conexao->consulta($query_str))
		{
			return true;
		}

		return false;
	}

	public static function object()
	{
		$conexao = new Conexao();
		return $conexao->obj();
	}

	public static function exec($query_str)
	{
		$conexao = new Conexao();
		if($consulta = $conexao->consulta($query_str))
		{
			return true;
		}

		return false;

	}

	public static function count($query_str)
	{
		$conexao = new Conexao();
		$consulta = $conexao->consulta($query_str);
		$count = $conexao->conta($consulta);
		$conexao->desconectar();
		if($count)
		{
			return $count;
		}
		return false;
	}

	public static function fetch($query_str)
	{
		$results = array();
		$conexao = new Conexao();
		$consulta = $conexao->consulta($query_str);
		while($dados = $conexao->busca($consulta))
		{
				array_push($results, $dados);
		}
		$conexao->desconectar();
		return $results;
	}

	public static function fetchuniq($query_str)
	{
		$results = array();
		$conexao = new Conexao();
		$consulta = $conexao->consulta($query_str);
		while($dados = $conexao->busca($consulta))
		{
			array_push($results, $dados);

		}
		$conexao->desconectar();
		return array_shift($results);
	}


}
?>
