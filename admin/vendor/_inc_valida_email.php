<?php
require_once("_inc_seguranca.php"); 
require_once("tools/email_senha_envia.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$email = (isset($_POST['email'])) ? $_POST['email'] : '';
	$name  = (isset($_POST['name'])) ? $_POST['name'] : '';

	if (validaEmail($email)) 
	{
		$str = validaEmail($email);
		$params = explode('@@@',$str);
		$id = $params[0];
		$nome = $params[1];
		$senha = $params[2];

		if(enviaSenha($email,$name,$id,$nome,$senha))
		{
			header("Location: ../senha?msg=1");
		}
		else
		{
			header("Location: ../senha?msg=3");

		}
	} 
	else 
	{
		//expulsaVisitante();
		//display de mensagem avisando que o email do mano não é válido at all
		header("Location: ../senha?msg=2");
	}



}