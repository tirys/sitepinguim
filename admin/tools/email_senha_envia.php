<?php
function enviaSenha($email, $name, $id, $nome, $senha)
{

if ($_SERVER['REQUEST_METHOD'] == "POST"){ //pode nao precisar disso daqui THO

	$PegaSPAM   = strip_tags($name);
	$SPAM		= false;
	
	if(empty($email)){ //se Nome, Email... é vazio, então é SPAM.
		
		$SPAM = true;
		
	}else{
		
		if(empty($PegaSPAM)){ //variavel PegaSPAM é vazio? Se for vazio então não é SPAM - libera envio.

			$SPAM = false;

		}else{ //como PegaSPAM é cheio, então é SPAM - bloqueia envio.
			
			$SPAM = true;
			
		}
		
	}
	
	if(!$SPAM){	

		date_default_timezone_set('America/Sao_Paulo');
		setlocale(LC_ALL, "pt_BR", "ptb");
		$Data = strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))) ." - ".date("H",time()).":".date("i",time()).":".date("s",time());
		
		$mensagem = "REQUISICAO DE SENHA - PROSPECTA CMS 
					Nome: $nome
					Email: $email
					Senha: $senha
					
					Enviado $Data \n\t";


		require_once('phpmailer_v51/class.phpmailer.php');
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)    // 1 = errors and messages      // 2 = messages only
		$mail->SetLanguage("br","phpmailer_v51/language/");
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "smtp.agenciaprospecta.com.br"; // sets the SMTP server
		$mail->Port       = 587;                    // set the SMTP port
		$mail->Username   = "send@agenciaprospecta.com.br"; // SMTP account username
		$mail->Password   = "prospecta14";        // SMTP account password
		$mail->AddReplyTo($Email,$Nome); //responder
		$mail->SetFrom('send@agenciaprospecta.com.br', 'web'); //de
		//$mail->AddAddress("igor.larcs@hotmail.com", "Igor"); //para
		$mail->AddAddress($email, $nome); //para
		$mail->AddBCC($email, 'PROSPECTA'); //cco
		$mail->Subject    = "[".utf8_decode($nome)."] - REQUISICAO DE SENHA PROSPECTA";

		$mail->MsgHTML(nl2br($mensagem));

		if(!$mail->Send()) {
		  echo "<br><p><strong>ERRO ao enviar email.</strong></p> <br /> <i>Error: ".$mail->ErrorInfo."</i> <p><a href='".URL_INSTALACAO."/projetoadmin'><strong>CLIQUE AQUI PARA VOLTAR</strong></a></p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
		} else {
		  echo "<br><p class='medium-h sucesso' style='margin-left:98px;'><strong>Obrigado!</strong> <br>Em breve entraremos em contato.</p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
		}

	
	}//end_if SPAM
	else{
		echo "<br /><p><strong>ERRO ao enviar.</strong></p> <p>Entre em <a href='".URL_INSTALACAO."/projetoadmin'>contato</a> via e-mail.</p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />";
	}

	}//end POST
	return true;
} ?>