<?php
namespace Appi\Helpers;

class Auth implements \Slim\Middleware\AuthCheckerInterface
{
	protected $app;
	
	public function __construct($app)
	{
		$this->app = $app;
	}

	public function checkCredentials($username, $password)  
	{
		$pass_to_check =$this->app->config->get('databases.'.$this->app->config->get('main.name').'.auth.password'); 
		$user_to_check =$this->app->config->get('databases.'.$this->app->config->get('main.name').'.auth.username'); 

		if($username == $user_to_check && $password == $pass_to_check)
		{
			return true;
		}
		return false;
	}
}