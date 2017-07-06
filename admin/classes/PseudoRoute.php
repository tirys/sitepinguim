<?php
class PseudoRoute
{
	private static function startClass()
	{
		//caso queira adicionar mais validações
		//templating pattern \/
		 self::checkFile();	
	}

	private static function checkFile()
	{
		if(!file_exists('.htaccess'))
		{
			$htaccess_rule = "<IfModule mod_rewrite.c>
			ErrorDocument 404 ".URL_INSTALACAO."erros/404.php
			  RewriteEngine On

				#força www
				RewriteCond %{HTTP_HOST} !^$
				RewriteCond %{HTTP_HOST} ^([^.]+)\.([a-z]{2,4})$ [NC]
				RewriteCond %{HTTPS}s ^on(s)|
				RewriteRule ^ http%1://www.%{HTTP_HOST}%{REQUEST_URI} [R=301,L]

				#tira .php
				RewriteCond %{REQUEST_FILENAME} !-f
				RewriteCond %{REQUEST_FILENAME}\.php -f
		        RewriteRule ^(.*)$ $1.php?codshow=$1
			</IfModule>";

			file_put_contents('.htaccess', $htaccess_rule);
		}
		return true;
	}
	
	private static function writeHandler($view, $name, $param = null, $link_name = null)
	{
		$arr_var['rewrite'] = '				RewriteRule ^'.$name.'?$												'.$view.'.php';
		$arr_var['href'] 	= URL_INSTALACAO.$name;
		if($param && is_numeric($param))
		{
				$str = '';
				$str_2 = '';
			
				for ($k = 0; $k < $param; $k++) 
				{
					$str .= '/([_0-9a-z-]+)/';
				}				
					$str = rtrim($str, '/');
					$str = str_replace('//', '/', $str);

				for ($l = 0; $l < $param; $l++) 
				{
					if($l == 0 && $param <= 1)
					{
						if($link_name)
						{
							$str_2 .= $link_name.'=$1&';
						}
						else
						{
							$str_2 .= 'link_automatico=$1&';
						}
					}
					else
					{
						if($link_name && $l > 0)
						{
							$str_2 .= $link_name.'=$'.($l + 1).'&';
						}
						elseif($link_name)
						{
							$str_2 .= 'link_automatico=$1&';
						}
						else
						{
							$str_2 .= 'link_automatico_'.($l + 1).'=$'.($l + 1).'&';

						}
					}
				}				
					$str_2 = rtrim($str_2, '&');
					$arr_var['rewrite'] = '				RewriteRule ^'.$name.$str.'?$									'.$view.'.php?'.$str_2;
		}
		return $arr_var;
	}

	public static function route($view, $name, $param = null, $link_name = null)
	{
		self::startClass();
		$var = self::writeHandler($view, $name, $param, $link_name);
		if(!strpos(file_get_contents('.htaccess'), $var['rewrite']))
		{
			$lines = file('.htaccess'); 
			$last = sizeof($lines) - 1 ; 
			unset($lines[$last]); 
			$fp = fopen('.htaccess', 'w'); 
			fwrite($fp, implode('', $lines)); 		
			fwrite($fp,$var['rewrite']); 		
			fwrite($fp,"\r\n"."</IfModule>"); 		
			fclose($fp); 
		}
		
		return $var['href'];
	}

}
