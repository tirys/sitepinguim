<?php
class Mailer{

	//TODO: CHECAR SE O INPUT É UM ARRAY, SE FOR, DES-ARRAYZAR ELE (FUTUROS PROJETOS)

	private $email;
	private $fields = array();
	private $field_names = array();
	private $error;
	private $title;
	
	function __construct($param = array(), $spam, $titulo, $button)
	{
	
		foreach($param as $single_param)
		{
				$var_2 = ucfirst($single_param); 
				$var_2 = str_replace("_", " ",$var_2);
				array_push($this->field_names,$var_2);
		}


		foreach($_POST as $key=>$value)
		{
			if(in_array($key,$param))
			{
				array_push($this->fields,$value);
			}
		}

		if(isset($_POST[$button]))
		{
				$this->pegaTitulo($titulo);
				
				$this->pegaEmail();  
				
				$this->enviaEmail();
		}
		
		/*else
		{
			if($_SERVER['REQUEST_METHOD'] == 'POST')
			{
					$this->pegaTitulo($titulo);
					
					$this->pegaEmail();  
					
					$this->enviaEmail();

			}

		}*/

	}

	private function pegaTitulo($str)
	{
		return $this->title = $str;
	}

	private function pegaEmail()
	{
		foreach($this->fields as $field)
		{
			if(filter_var($field, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $field))
			{
				$this->email = $field;
			}

		}
			if($this->email == NULL)
			{
				$this->error = 'no_email';
			}
	}

	private function enviaEmail()
	{
		foreach($this->fields as $field)
		{
			if(empty($field) || in_array($field,$this->field_names))
			{
				$this->error = 'vazio'; 
			}
			
		}


		if($this->retornaErro() == 'ok')
	
			{
				$msg = $this->criaMensagem($this->email);
				$mail = $this->disparaEmail($msg);
			}
		else
			{
/*				echo '<br/>';
				echo '<span style="display:block;" class="alert alert-danger">'.$this->retornaErro().'</span><br/>';
				echo '<div class="clearfix"></div>';
*/
			echo '<script type="text/javascript">window.location.href="contato-erro"</script>';	
			}

	}

	private function criaMensagem($email)
	{	
		date_default_timezone_set('America/Sao_Paulo');
		setlocale(LC_ALL, "pt_BR", "ptb");
		$Data = strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))) ." - ".date("H",time()).":".date("i",time()).":".date("s",time());

		$array = array_combine($this->field_names, $this->fields);
		
		$mensagem = $this->title." ".utf8_decode('Móveis Maschieto')."\n";
		
		foreach($array as $key=>$value)
		{
			$mensagem .= $key.': '.$value."\n";
		}
			 $mensagem = $mensagem . "Enviado Data: $Data";
			 return $mensagem;
	}

	private function disparaEmail($mensagem)
	{
		$mail = new PHPMailer(); 
		$email = $this->email;
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)    // 1 = errors and messages      // 2 = messages only
		$mail->SetLanguage("br","admin/tools/phpmailer_v51/language/");
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPAutoTLS = false;
		$mail->Host       = "smtp.agenciaprospecta.com.br"; // sets the SMTP server
		$mail->Port       = 587;                    // set the SMTP port
		$mail->Username   = "send@agenciaprospecta.com.br"; // SMTP account username
		$mail->Password   = "prospecta14";        // SMTP account password
		$mail->AddReplyTo($email,'Reply'); //responder
		$mail->SetFrom('send@agenciaprospecta.com.br', 'web'); //de
		$mail->AddAddress("jessica@agenciaprospecta.com.br", "web"); //para
		//$mail->AddAddress("web@agenciaprospecta.com.br", "web"); //para
		//$mail->AddAddress(tb_config_cadastral_email_formulario_contato, tb_config_cadastral_nome); //para
		$mail->Subject    = "[".utf8_decode('Móveis Maschieto')."] - ".utf8_decode($this->title);

		$mail->MsgHTML(nl2br(utf8_decode($mensagem)));
		if(!$mail->Send())
		{
			echo '<script type="text/javascript">window.location.href="contato-erro"</script>';	
		}
		else
		{
/*			echo '<br/>';
			echo '<span style="display:block;" class="alert alert-success"><strong>SUCESSO</strong>: Seu e-mail foi enviado, por favor aguarde nosso retorno!</span>';
			echo '<div class="clearfix"></div>';
*/
			echo '<script type="text/javascript">window.location.href="contato-sucesso"</script>';	

		}
	}

	private function validaSpam($spam)
	{
		if(isset($_POST[$spam]))
			{
				return false; 
			}
			else
			{
				return  true;
			}
	}

	private function retornaErro()
	{
		if($this->error)
		{
			switch($this->error)
			{
				case 'vazio':
				$str =  '<strong>ERRO</strong>: Nenhum dos Campos requisitados podem estar vazios!';
				return $str;
				break;

				case 'no_email':
				$str =  '<strong>ERRO</strong>: E-mail inválido!';
				return $str;
				break;

				case 'email_not_sent':
				$str =  '<strong>ERRO</strong>: E-mail não enviado!';
				return $str;
				break;
			}
		}
		else
		{
			$str = 'ok';
			return $str;
		}
	}


}