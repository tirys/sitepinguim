<?php
class DadosCadastrais 
{	
	public static function serialize($data)
	{
		$return = array();
		foreach ($data as $single_data) 
		{
			if(!array_key_exists($single_data['tb_config_cadastral_codigo'], $return))
			{
				$return[$single_data['tb_config_cadastral_codigo']] = $single_data['tb_config_cadastral_valor'];
			}
		}
		return $return;
	} 
}	