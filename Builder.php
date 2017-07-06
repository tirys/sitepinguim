<?php
use Noodlehaus\Config;
define('INC_ROOT', __DIR__); 
class Builder
{
	protected $config;

	public function __construct()
	{
		require 'vendor/autoload.php';
		$this->config = Config::load(INC_ROOT.'/config.php');
	}

	public function getConfig()
	{
		return $this->config;
	}
	public function getFile($filetypes, $size)
	{
		$path = $this->config->get('admin.name').'/uploads/arquivos';
		$storage = new \Upload\Storage\FileSystem('../'.$path);
		$file = new \Upload\File('arquivo', $storage);
        $file->addValidations(array(
            new \Upload\Validation\Mimetype($filetypes),
            new \Upload\Validation\Size($size)
        ));
        return $file;
	}
	public function getMailer()
	{
		return $mail = new PHPMailer;
	}
}