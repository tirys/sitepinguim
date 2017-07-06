<?php
class UrlParser
{
	private $tipo_listagem;
	private $pagination;
	private $page;
	private $results = array();

	public function __construct($param = null)
	{
		if($param)
		{
			$this->queryPrep($param);
		}
		else
		{
			$this->queryPrep($this->getParam());
		}
	}

	public function outputMeta($data)
	{	
		$title 		 = $data['nome_site']. " | ".$data['descricao'];
		$description = $data['descricao'];
		$keywords    = $data['palavras_chave'];
		echo '
    <title>'.$title.'</title>
    <meta name="description" content="'.$description.'"/>
    <meta name="keywords" content="'.$keywords.'"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="index, follow, NOODP, NOYDIR"/>
    <meta name="author" content="Agência Prospecta"/>
    <meta name="revisit" content="2 days"/>'."\n";
	
	}

    public function outputMetaDinamico($conteudo, $data)
    {
        $title 		 = $conteudo['tb_conteudo_titulo']. " | ".$data['nome_site'];
        $description = $conteudo['tb_conteudo_descricao_busca'];
        $keywords    = $conteudo['tb_conteudo_palavras_chaves_busca'];
        echo '
    <title>'.$title.'</title>
    <meta name="description" content="'.$description.'"/>
    <meta name="keywords" content="'.$keywords.'"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="index, follow, NOODP, NOYDIR"/>
    <meta name="author" content="Agência Prospecta"/>
    <meta name="revisit" content="2 days"/>'."\n";

    }

    public function outputMetaporTabela($seo, $data)
    {
        $title 		 = $seo['tb_seo_nome']. " | ".$data['nome_site'];
        $description = $seo['tb_seo_descricao'];
        $keywords    = $seo['tb_seo_palavras_chave'];
        echo '
    <title>'.$title.'</title>
    <meta name="description" content="'.utf8_encode($description).'"/>
    <meta name="keywords" content="'.utf8_encode($keywords).'"/>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="pt-br">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="index, follow, NOODP, NOYDIR"/>
    <meta name="author" content="Agência Prospecta"/>
    <meta name="revisit" content="2 days"/>'."\n";

    }

	public function addPagination($num, $pseudo_1 ,$second_num, $pseudo_2)
	{		
		PseudoRoute::route($pseudo_1, $pseudo_2, $second_num, 'link_search');
		$this->pagination = $num;
		$res = $this->results;	
		$count = count($res);
		if(ceil($count/$num) >= 1)
		{
			if(isset($_GET['link_search']))
			{
				if(intval($_GET['link_search']) != 0 && intval($_GET['link_search']) <= ceil($count/$num))
				{
					$this->page = intval($_GET['link_search']); 
				}
				else
				{
					$this->page = 1;
				}
			}
			else
			{
				$this->page = 1;
			}
		}
		$str_2 = '';
		for ($i=0; $i < ceil($count/$num) ; $i++) 
		{ 
			$k = ($i+1);
			if($k == $this->page)
			{
				$str_2 .='<li><a class="item ativo" href="'.URL_INSTALACAO.$pseudo_2.'/'.$k.'">'.$k.'</a></li>';
			}
			else
			{
				$str_2 .='<li><a class="item" href="'.URL_INSTALACAO.$pseudo_2.'/'.$k.'">'.$k.'</a></li>';
			}
		}
	
		return $str = "<ul class='paginacao'>".$str_2."</ul>";
	}

	public function listaPagination($str)
	{
		echo $str;
	}

	public function listaImgDetalhe()
	{
		$res = $this->results;
      	$str_normal = '';
      	$str_thumb = '';
        $images = array();
        $names = array();
        $final = array();
        $k = 0;

      foreach($res as $single_result)
      {
      	$name = $single_result['tb_conteudo_titulo'];
        if(!$single_result['tb_conteudo_imagem_grande'])
        {
          $id   = $single_result['tb_conteudo_id'];
          $check_galeria = Conexao::fetch("SELECT tb_galeria_foto_nome FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = '$id'");

          foreach($check_galeria as $foto_galeria)
          {
            $actual_pic = 'admin/uploads/images/galeria/'.$foto_galeria['tb_galeria_foto_nome'];
            if(in_array($name, $names))
            {

            	$k++;
            	$name = $single_result['tb_conteudo_titulo'].'_'.$k;
            }
            array_push($names, $name);
            array_push($images,$actual_pic);
          }
        }

        else
        {
          $actual_pic = 'admin/uploads/images/conteudo/'.$single_result['tb_conteudo_imagem_grande'];
           array_push($names, $name);
           array_push($images,$actual_pic);


          $id   = $single_result['tb_conteudo_id'];
          $check_galeria = Conexao::fetch("SELECT tb_galeria_foto_nome FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = '$id'");

          foreach($check_galeria as $foto_galeria)
          {
            $actual_pic_2 = 'admin/uploads/images/galeria/'.$foto_galeria['tb_galeria_foto_nome'];
            if(in_array($name, $names))
            {
            	$k++;
            	$name = $single_result['tb_conteudo_titulo'].'_'.$k;
            }
            array_push($names, $name);
            array_push($images,$actual_pic_2);
          }


        }
      }
      	$final = array_combine($names, $images);
		foreach($final as $key => $value)
		{
			$str_heh .= '<a href="'.URL_INSTALACAO.$value.'" title="'.$key.'" class="fancybox" rel="gallery"><img src="'.URL_INSTALACAO.$value.'" alt="'.$key.'" title="'.$key.'"></a>'."\n";
		}
			$str = <<<HERE
                <div class="img-detalhe">
                	$str_heh
                </div>
HERE;
	echo $str;

	}
	
	public function listaSlick($param = null)
	{
		$res = $this->results;
		if($param)
		{
			$res = $param;
		}
      	$str_normal ='';
      	$str_thumb ='';
        $images = array();
        $names = array();
        $final = array();
        $k = 0;

      foreach($res as $single_result)
      {
      	$name = $single_result['tb_conteudo_titulo'];
        if(!$single_result['tb_conteudo_imagem_grande'])
        {
          $id   = $single_result['tb_conteudo_id'];
          $check_galeria = Conexao::fetch("SELECT tb_galeria_foto_nome FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = '$id'");

          foreach($check_galeria as $foto_galeria)
          {
            $actual_pic = 'admin/uploads/images/galeria/'.$foto_galeria['tb_galeria_foto_nome'];
            if(in_array($name, $names))
            {

            	$k++;
            	$name = $single_result['tb_conteudo_titulo'].'_'.$k;
            }
            array_push($names, $name);
            array_push($images,$actual_pic);
          }
        }

        else
        {
          $actual_pic = 'admin/uploads/images/conteudo/'.$single_result['tb_conteudo_imagem_grande'];
           array_push($names, $name);
           array_push($images,$actual_pic);


          $id   = $single_result['tb_conteudo_id'];
          $check_galeria = Conexao::fetch("SELECT tb_galeria_foto_nome FROM tb_galeria_foto WHERE tb_galeria_foto_id_conteudo = '$id'");

          foreach($check_galeria as $foto_galeria)
          {
            $actual_pic_2 = 'admin/uploads/images/galeria/'.$foto_galeria['tb_galeria_foto_nome'];
            if(in_array($name, $names))
            {
            	$k++;
            	$name = $single_result['tb_conteudo_titulo'].'_'.$k;
            }
            array_push($names, $name);
            array_push($images,$actual_pic_2);
          }


        }
      }
      	$final = array_combine($names, $images);
		foreach($final as $key => $value)
		{
			$str_normal .= '<div><a href="'.URL_INSTALACAO.$value.'" title="'.$key.'" class="fancybox" rel="gallery"><img src="'.URL_INSTALACAO.$value.'" alt="'.$key.'" title="'.$key.'"></a></div>'."\n";
			//$str_normal .= 	'<div><div class="zoom-container"><img class="zoom" src="'.URL_INSTALACAO.$value.'" alt="'.$key.'" title="'.$key.'"></div></div>'."\n";
			$str_thumb .= '<div><img src="'.URL_INSTALACAO.$value.'" alt="'.$key.'" title="'.$key.'"></div>'."\n";
		}

		$str = <<<HERE
                <div class="slick-detalhe-grande">
                	$str_normal
                </div>
            <div class="slick-detalhe-thumb">
                	$str_thumb
                </div>
HERE;
	echo $str;
	}

private function paginationHandler()
	{
		$results_to_iterate = $this->results;
		$divider   			= $this->pagination; 
		$param 	  			= max(array_keys($results_to_iterate)); 
		$container 			= [];
		$counter   			=  0;
		$temp 	   			= []; 
		
		for($i=0; $i < $param ; $i++) 
		{
			array_push($temp, $results_to_iterate[$i]);
			if(($i + 1)%$divider == 0)
			{
				$counter++;  
				if(!array_key_exists($counter, $container))
				{
					$container[$counter] = $temp;
				}
				$temp = [];
			}
			if($i == ($param - 1)) 
			{
				$counter++;  
				array_push($temp, $results_to_iterate[$i +1]);
				if(!array_key_exists($counter, $container))
				{
					$container[$counter] = $temp;
				}
			}
		}
		return $container;
	}


	public function grabResult()
	{
		if($this->page && $this->pagination)
		{
			$num_res = ($this->page * $this->pagination);
			if( count($this->results) > $this->pagination)
			{
					$arr_display = $this->paginationHandler(); 
					return $arr_display[$this->page];
			}
			else
			{
		 			return $this->results;
			}
		}
		else
		{
 			return $this->results;
		}
	}

	private function autoCheck($table, $where, $param)
	{
		if(class_exists('Conexao'))
		{
			$sql = "SELECT * FROM {$table} WHERE {$where} = '{$param}' ";
			$conteudo_count = Conexao::count($sql);
			if($conteudo_count)
			{
				$id_used = $table.'_id';
				if($table != 'tb_conteudo')
				{
					if(!strpos($table, 'uni'))
					{
						$sql_2 = "SELECT * FROM tb_conteudo LEFT JOIN {$table} ON tb_conteudo.{$table} = {$table}.{$id_used} WHERE {$table}.{$where} = '{$param}' ";
						return $conteudos = Conexao::fetch($sql_2);
					}
					else
					{
						return $conteudos = Conexao::fetch($sql);
					}
				}
				else
				{
					return $conteudos = Conexao::fetch($sql);
				}
			}
			return false;
		}
		else
		{
			die('Missing Dependency');
		}
	}

	private function queryPrep($param)
	{
		$what_to_check = array('tipo','categoria','unidade','unidade-detalhe','subcategoria','default');
		foreach($what_to_check as $tipo)
		{
			if($tipo == 'default')
			{
				$table = 'tb_conteudo';
				$where = 'tb_conteudo_link_automatico';
				$res = $this->autoCheck($table, $where, $param);
				if($res)
				{
					$res[0]['tb_conteudo_texto_longo'] = html_entity_decode($res[0]['tb_conteudo_texto_longo'], ENT_QUOTES, 'UTF-8');
					$this->results = $res;
					return true;
				}
			}
			elseif($tipo == 'unidade')
			{
				$table = 'tb_unidade uni LEFT JOIN tb_localidade_estado est ON est.tb_localidade_estado_id = uni.tb_unidade_estado LEFT JOIN tb_localidade_cidade cid ON cid.tb_localidade_cidade_id = uni.tb_unidade_cidade';
				$where = 'est.tb_localidade_estado_sigla';
				$res = $this->autoCheck($table, $where, $param);
				if($res)
				{
					$this->results = $res;
					return true;
				}
			}
			elseif($tipo == 'unidade-detalhe')
			{
				$table = 'tb_unidade uni LEFT JOIN tb_localidade_estado est ON est.tb_localidade_estado_id = uni.tb_unidade_estado LEFT JOIN tb_localidade_cidade cid ON cid.tb_localidade_cidade_id = uni.tb_unidade_cidade';
				$where = 'tb_unidade_login';
				$res = $this->autoCheck($table, $where, $param);
				if($res)
				{
					$this->results = $res;
					return true;
				}
			}
			else
			{
				$table = 'tb_conteudo_'.$tipo;
				$where = $table.'_url';
				$res = $this->autoCheck($table, $where, $param);
				if($res)
				{

					$res[0]['tb_conteudo_texto_longo'] = html_entity_decode($res[0]['tb_conteudo_texto_longo'], ENT_QUOTES, 'UTF-8');
					$this->results = $res;
					return true;
				}
			}
		}
			return false;
	}

	public function returnParam()
	{
		return $this->getParam();
	}

	private function getParam()
	{
		if(isset($_GET['link_automatico']))
		{
			$param = $_GET['link_automatico'];
		}
		elseif(isset($_GET['link_search'])) 
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$check = explode('/',$actual_link);
			$count = count($check) - 2;
			$param = $check[$count];
		}
		else
		{
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$check = explode('/',$actual_link);
			$count = count($check) - 1;
			$param = $check[$count];
		}
			return $param;
	}
}
