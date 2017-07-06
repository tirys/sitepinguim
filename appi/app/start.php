<?php
use Slim\Slim;
use Slim\Middleware;
use Noodlehaus\Config;
use Appi\Helpers\Auth;

ini_set('display_errors','On');
define('INC_ROOT', dirname(__DIR__)); //var/www
require(INC_ROOT.'/vendor/autoload.php');

$app  = new Slim();
//configura todos os middlewares e dependencias
$app->add(new \JsonApiMiddleware());
$app->view(new \JsonApiView);
$authChecker = new Auth($app);
$app->config = Config::load(INC_ROOT."/config.php");

//Autenticação simples -> usuario e senha (definidos no config)
$app->add(new \Slim\Middleware\HttpBasicAuth($authChecker, array(
    'path' => '/appi/', // optional, defaults to '/'
    'realm' => 'Protected API' // optional, defaults to 'Protected Area'
)));

$addHeaders = function($app){
	return function() use ($app){
		$app->response()->headers->set('Access-Control-Allow-Origin', '*');
		$app->response()->headers->set('Access-Control-Allow-Headers', 'Content-Type');
		$app->response()->headers->set('Content-Type', 'application/json');
		$app->response()->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
	};	
};

//Database
$app->container->singleton('db', function() use ($app){
		return new PDO('mysql:host='.$app->config->get('databases.'.$app->config->get('main.name').'.host').';dbname='.$app->config->get('databases.'.$app->config->get('main.name').'.name'), 
						$app->config->get('databases.'.$app->config->get('main.name').'.username'),
						$app->config->get('databases.'.$app->config->get('main.name').'.password'));
});


$app->get('/appi/',$addHeaders($app), function() use ($app) {
    $res = $app->db->query("SELECT * FROM tb_config_cadastral")->fetchAll(PDO::FETCH_ASSOC);
    $app->render(200,$res);
});


//"categorias"
$app->get('/appi/produtos',$addHeaders($app), function() use ($app) {
	$filtros = $app->db->query("SELECT * FROM tb_conteudo WHERE tb_conteudo_categoria = 49")->fetchAll(PDO::FETCH_ASSOC);
    $res = array('results' => $filtros);
    $app->render(200,$res);
});

//"produtos listagem"
$app->get('/appi/produtos/:param',$addHeaders($app), function($param) use ($app) {
	$produtos = $app->db->query("SELECT * FROM `tb_conteudo` WHERE `tb_conteudo_texto_longo2` LIKE '%".$param."%'")->fetchAll(PDO::FETCH_ASSOC);
    $res = array('results' => $produtos);
    $app->render(200,$res);
});

//quemsomos 
$app->get('/appi/quemsomos',$addHeaders($app), function() use ($app) {
	$textos = $app->db->query("SELECT * FROM tb_conteudo WHERE tb_conteudo_categoria = 14 AND tb_conteudo_id = 328 OR tb_conteudo_id = 329")->fetchAll(PDO::FETCH_ASSOC);
    $res = array('results' => $textos);
    $app->render(200,$res);
});


//"produto"
$app->get('/appi/produto/:param',$addHeaders($app), function($param) use ($app) {
	$produtos = $app->db->query("SELECT * FROM `tb_conteudo` WHERE `tb_conteudo_link_automatico` = '".$param."'")->fetchAll(PDO::FETCH_ASSOC);
    $res = array('results' => $produtos);
    $app->render(200,$res);
});


//post de contato
$app->post('/appi/contato', $addHeaders($app), function() use ($app){

	date_default_timezone_set('America/Sao_Paulo');
	setlocale(LC_ALL, "pt_BR", "ptb");
	$Data = strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))) ." - ".date("H",time()).":".date("i",time()).":".date("s",time());
    $Data = utf8_decode($Data);
    $json = $app->request->getBody();
    $data = json_decode($json, true);	
    $mensagem  =	"CONTATO APP Agência Prospecta\n";
	foreach ($data as $key => $value) 
	{
		$mensagem  .= ucfirst($key).": ".$value."\n";
	}
	$mensagem .= "Enviado Data: $Data";	

	$mail = new PHPMailer;
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)    // 1 = errors and messages      // 2 = messages only
	$mail->SetLanguage("br","projetoadmin/tools/phpmailer_v51/language/");
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = "smtp.agenciaprospecta.com.br"; // sets the SMTP server
	$mail->Port       = 587;                    // set the SMTP port
	$mail->Username   = "send@agenciaprospecta.com.br"; // SMTP account username
	$mail->Password   = "prospecta14";        // SMTP account password
	$mail->AddReplyTo($email,'Reply'); //responder
	$mail->SetFrom('send@agenciaprospecta.com.br', 'Prospecta');
	$mail->AddAddress('atendimento@agenciaprospecta.com.br', 'Prospecta');
	$mail->Subject    = "[".utf8_decode('Agência Prospecta')."] - CONTATO APP";
	
	$mail->MsgHTML(nl2br(utf8_decode($mensagem)));
	if($mail->Send())
	{
		$app->render(200,array('sucesso'));
	}

});


