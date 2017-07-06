<?php
class MetaHandler
{
	private $constants 	= array(); 
	private $atuais 	= array();
	private $param;

	function __construct($param = null)
	{
		//o que muda são três coisas basicamente
		//que são as seguinteah
		//ai é só dar uma populadinha e brasil

		/*
	 	<html lang="pt-br">
		
		<title>$title</title>
		<meta name="description" content="$description"/>
		<meta name="keywords" content="$keywords"/>
	 	
	 	<meta charset="utf-8">
	 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Language" content="pt-br">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta name="robots" content="$robots"/>
		<meta name="title" content="$title"/>
		<meta name="author" content="$author"/>
		<meta name="revisit" content="$revisit"/>
		*/

			$constantes = get_defined_constants(true);
			$this->constants = $constantes['user'];
			$this->pegaConstantes();			
			if($param)
			{
				$this->param = $param;
			}
			$this->exibeMeta($this->montaMeta($this->checkConstantes($this->param)));
	}

	public function retornaPage()
	{
		$param =  $this->checkConstantes($this->param);
		return $param['simple'];
	}

	private function pegaConstantes()
	{
		$all = $this->constants;
		$constantes_uteis  =  array('tb_config_cadastral_nome',
									'tb_config_cadastral_descricao',
									'tb_config_cadastral_palavras_chaves',
									'var_conteudo_titulo',
									'var_conteudo_texto_curto',
									'var_conteudo_descricao_busca',
									'var_conteudo_palavras_chaves_busca',
									'var_unidade_nome',
									'var_unidade_depoimento',
									'var_serv_nome',
									'var_localidade_cidade_nome',
									'var_localidade_estado_nome',
									'var_conteudo_categoria_descricao_busca',
									'var_conteudo_categoria_nome',
									'var_conteudo_subcategoria_nome',
									'var_conteudo_subcategoria_descricao_busca');
		
		$atuais = array_intersect_key($all,array_flip($constantes_uteis));
		return $this->atuais = $atuais;

	}

	private function checkConstantes($param)
	{

		$meta = array();
		$constantes_atuais = $this->atuais;
		$array_conteudo = array('var_conteudo_titulo','var_conteudo_descricao_busca','var_conteudo_texto_curto','var_conteudo_palavras_chaves_busca');
		$array_unidade = array('var_unidade_nome','var_unidade_depoimento','var_localidade_cidade_nome','var_localidade_estado_nome');
		$array_categoria = array('var_conteudo_categoria_nome','var_conteudo_categoria_descricao_busca');
		$array_subcategoria = array('var_conteudo_subcategoria_nome','var_conteudo_subcategoria_descricao_busca');

		//die(var_dump($constantes_atuais));	
		if($param)
		{
			//custom parametro	
			$meta['simple'] 		= $param;
			$meta['title']			= $param;
			//$meta['title'] 			= $constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['tb_config_cadastral_descricao']; 		
			$meta['keywords'] 		= $constantes_atuais['tb_config_cadastral_palavras_chaves'];
			$meta['description'] 	= $constantes_atuais['tb_config_cadastral_descricao'];
			$meta['author'] 		= 'Agência Prospecta';
			$meta['revisit'] 		= '2 days';
			$meta['robots']			= 'index, follow, NOODP, NOYDIR';
			
			return $meta;

		}
		else
		{
			if(count(array_intersect_key(array_flip($array_conteudo), $constantes_atuais)) === count($array_conteudo))
			{
				
				$meta['simple'] 		= $constantes_atuais['var_conteudo_titulo'];
				$meta['title'] 			= $constantes_atuais['var_conteudo_titulo'].' | '.$constantes_atuais['var_conteudo_texto_curto']; 		
				$meta['keywords'] 		= $constantes_atuais['var_conteudo_palavras_chaves_busca'];
				$meta['description'] 	= substr($constantes_atuais['var_conteudo_descricao_busca'],0,157).'...';
				$meta['author'] 		= 'Agência Prospecta';
				$meta['revisit'] 		= '2 days';
				$meta['robots']			= 'index, follow, NOODP, NOYDIR';
			
				return $meta;

			}
			elseif(count(array_intersect_key(array_flip($array_unidade), $constantes_atuais)) === count($array_unidade) && !$param) 
			{

				//não precisa usar utf8_encode (na maioria das vezes)
				$arr_geo = $this->geoInfo(urlencode($constantes_atuais['var_localidade_cidade_nome']));
				$meta['geo'] = array('placename' => $constantes_atuais['var_localidade_cidade_nome']. '-'.$constantes_atuais['var_localidade_estado_nome'],
								'region' => $arr_geo['countryCode'],
								'position' => $arr_geo['lat'].';'.$arr_geo['lng'],
								'icbm' => $arr_geo['lat'].','.$arr_geo['lng']
								);

				$meta['simple'] 		= $constantes_atuais['var_unidade_nome'];
				$meta['title'] 			= $constantes_atuais['var_unidade_nome'] .' | '.$constantes_atuais['tb_config_cadastral_nome']; 		
				$meta['keywords'] 		= $constantes_atuais['var_unidade_nome'].', unidades, em '.$constantes_atuais['var_localidade_cidade_nome'].' '.$constantes_atuais['var_localidade_estado_nome'];
				$meta['description'] 	= $constantes_atuais['var_unidade_nome'].', unidades, em '.$constantes_atuais['var_localidade_cidade_nome'].' '.$constantes_atuais['var_localidade_estado_nome'].'  '. substr($constantes_atuais['var_unidade_depoimento'],0,157).'...';
				$meta['author'] 		= 'Agência Prospecta';
				$meta['revisit'] 		= '2 days';
				$meta['robots']			= 'index, follow, NOODP, NOYDIR';

				return $meta;

			}
			elseif(count(array_intersect_key(array_flip($array_categoria), $constantes_atuais)) === count($array_categoria))
			{
				//listagem de categoria
				$meta['simple'] 		= $constantes_atuais['var_conteudo_categoria_nome'];
				$meta['title'] 			= $constantes_atuais['var_conteudo_categoria_nome'].' | '.$constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['tb_config_cadastral_descricao']; 		
				$meta['keywords'] 		= $constantes_atuais['var_conteudo_categoria_descricao_busca'];
				$meta['description'] 	= $constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['var_conteudo_categoria_nome']. ' '.$constantes_atuais['var_conteudo_categoria_descricao_busca'];
				$meta['author'] 		= 'Agência Prospecta';
				$meta['revisit'] 		= '2 days';
				$meta['robots']			= 'index, follow, NOODP, NOYDIR';

				return $meta;

			}
			elseif(count(array_intersect_key(array_flip($array_subcategoria), $constantes_atuais)) === count($array_subcategoria))
			{
				//listagem de subcategoria	
				$meta['simple'] 		= $constantes_atuais['var_conteudo_subcategoria_nome'];
				$meta['title'] 			= $constantes_atuais['var_conteudo_subcategoria_nome'].' | '.$constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['tb_config_cadastral_descricao']; 		
				$meta['keywords'] 		= $constantes_atuais['var_conteudo_subcategoria_descricao_busca'];
				$meta['description'] 	= $constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['var_conteudo_subcategoria_nome']. ' '.$constantes_atuais['var_conteudo_subcategoria_descricao_busca'];
				$meta['author'] 		= 'Agência Prospecta';
				$meta['revisit'] 		= '2 days';
				$meta['robots']			= 'index, follow, NOODP, NOYDIR';

				return $meta;
			}
			else
			{
				//TA CAINDO AQUI QUANDO CLARAMENTE NAO É A FITA
				//normal
				$meta['simple'] 		= $constantes_atuais['tb_config_cadastral_nome'];
				$meta['title'] 			= $constantes_atuais['tb_config_cadastral_nome'] .' | '.$constantes_atuais['tb_config_cadastral_descricao']; 		
				$meta['keywords'] 		= $constantes_atuais['tb_config_cadastral_palavras_chaves'];
				$meta['description'] 	= $constantes_atuais['tb_config_cadastral_descricao'];
				$meta['author'] 		= 'Agência Prospecta';
				$meta['revisit'] 		= '2 days';
				$meta['robots']			= 'index, follow, NOODP, NOYDIR';
				
				return $meta;
			}
		}
		

	}

	private function montaMeta($meta)
	{
		//$this->log($meta);

		$title = $meta['title'];
		$robots = $meta['robots'];
		$keywords = $meta['keywords'];
		$description = $meta['description'];
		$author = $meta['author'];
		$revisit = $meta['revisit'];

		
		$str = <<<HERE
 	<html lang="pt-br">
	
	<title>$title</title>
	
 	<meta charset="utf-8">
 
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta http-equiv="Content-Language" content="pt-br">
    	
    	<meta name="viewport" content="width=device-width,initial-scale=1">

	<meta name="robots" content="$robots"/>

	<meta name="title" content="$title"/>

	<meta name="description" content="$description"/>

	<meta name="keywords" content="$keywords"/>

	<meta name="author" content="$author"/>

	<meta name="revisit" content="$revisit"/>
HERE;
		//se for unidades \/
		if(array_key_exists('geo', $meta))
		{
			$placename = $meta['geo']['placename'];
			$region = $meta['geo']['region'];
			$position = $meta['geo']['position'];
			$icbm = $meta['geo']['icbm'];

			$str .='
	
	<meta name="geo.placename" content="'.$placename.'" />

	<meta name="geo.region" content="'.$region.'" />

	<meta name="geo.position" content="'.$position.'" /> 

	<meta name="ICBM" content="'.$icbm.'" />';

		}
	
	return $str;
	
	}


	private function exibeMeta($str)
	{
		echo $str;
	}


	private function log($var)
	{
		die(var_dump($var));
	}

	private function geoInfo($search)
	{
		$url = 'http://api.geonames.org/searchJSON?q='.$search.'&maxRows=1&username=prospecta&country=BR';
		
		//http://www.geonames.org/login
		//prospecta
		//pro12151215

		$result = file_get_contents($url);
		$json = json_decode($result, true);
		//$this->log($json);
		return array_shift($json['geonames']);	
	}	



}