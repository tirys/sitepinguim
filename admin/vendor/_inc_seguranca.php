<?php
error_reporting(E_ALL);
/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site
*
* @author Thiago Belem <contato@thiagobelem.net>
* @link http://thiagobelem.net/
*
* @version 1.0
* @package SistemaSeguranca
*/
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] 		= true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] 	= false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'

// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['validaSempre'] 	= true;       // Deseja validar o usuário e a senha a cada carregamento de página?

$_SG['paginaLogin'] = __DIR__; // Página de login
$_SG['tabela'] = 'tb_usuario';       // Nome da tabela onde os usuários são salvos
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================

// Verifica se precisa fazer a conexão com o MySQL
//if ($_SG['conectaServidor'] == true) {
//$_SG['link'] = mysql_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_SG['servidor']."].");
//mysql_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
//}

// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao']) 
{
	@session_start();
}
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) 
{
	global $_SG;
	$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
	// Usa a função addslashes para escapar as aspas
	$nusuario = addslashes($usuario);
	$nsenha   = addslashes($senha);
	// Monta uma consulta SQL (query) para procurar um usuário
	$conexao = new Conexao(); 
	$consulta = $conexao->consulta("SELECT `tb_usuario_id`, `tb_usuario_nome`, `tb_usuario_tipo` FROM `".$_SG['tabela']."` WHERE ".$cS." `tb_usuario_email` = '".$nusuario."' AND ".$cS." `tb_usuario_senha` = '".$nsenha."' LIMIT 1");
	$resultado = $conexao->busca($consulta);
	//echo $resultado['tb_usuario_nome'];
	// Verifica se encontrou algum registro
	if (empty($resultado)) 
	{
		// Nenhum registro foi encontrado => o usuário é inválido
		return false;
	} 
	else 
	{
		// O registro foi encontrado => o usuário é valido
		// Definimos dois valores na sessão com os dados do usuário
		$_SESSION['usuarioID']   = $resultado['tb_usuario_id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
		$_SESSION['usuarioNome'] = $resultado['tb_usuario_nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		$_SESSION['usuarioTipo'] = $resultado['tb_usuario_tipo']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
		// Verifica a opção se sempre validar o login
		if ($_SG['validaSempre'])
		{
			// Definimos dois valores na sessão com os dados do login
			$_SESSION['usuarioLogin'] = $usuario;
			$_SESSION['usuarioSenha'] = $senha;
			session_write_close();
		}
		return true;
	}
}

/*
	Função pra validação de email(esqueceu senha)
*/
function validaEmail($email)
{	
	global $_SG;
	if($email != "prospecta" )
	{
		$nemail 	 = addslashes($email);
		$conexao     = new Conexao();
		$consulta	 = $conexao->consulta("SELECT * FROM `".$_SG['tabela']."` WHERE ".$cS." `tb_usuario_email` = '".$nemail."' LIMIT 1");
		$resultado   = $conexao->busca($consulta);
		if(!empty($resultado))
		{
			$str = $resultado['tb_usuario_id'].'@@@'.$resultado['tb_usuario_nome'].'@@@'.$resultado['tb_usuario_senha'];
			return $str;
		}
		return false;
	}
	return false;
}

/**
* Função que protege uma página
*/
function protegePagina() 
{
	global $_SG;
	if (!isset($_SESSION['usuarioID']) OR !isset($_SESSION['usuarioNome'])) 
	{
		expulsaVisitante();
	} 
	if ($_SG['validaSempre']) 
	{
		if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) 
		{
			expulsaVisitante();
		}
	}
}

/**
* Função para expulsar um visitante
*/
function expulsaVisitante() 
{
	global $_SG;
	unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
	header("Location: ".$_SG['paginaLogin']);
}