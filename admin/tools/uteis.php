<?php
global $msgSucesso;
global $msgErro;
/*
	urlfyLink
*/

function urlfyImg($param, $type)
{
	if(file_exists($_SERVER['DOCUMENT_ROOT'].ADMIN_PATH.'uploads/images/'.$type.'/'.$param))
	{
		$res = ADMIN_URL.'uploads/images/'.$type.'/'.$param;
	}
	else
	{
		$res = 	'http://placehold.it/500x500';
	}
	return $res;
}

function urlfyLink($parser1, $parser2, $qnt = null, $extra = null)
{
	if($qnt || $extra)
	{
		if(strpos($extra, ',') !== false)
		{
			$extras = explode(',', $extra);
			foreach ($extra as $single_extra) 
			{
				$concat = '/'.$single_extra;
			}
			$str = PseudoRoute::route($parser1, $parser2, $qnt);
			$str.= $concat;
		}
		else
		{
			$str = PseudoRoute::route($parser1, $parser2, $qnt).'/'.$extra;
		}
	}
	else
	{
		$str = PseudoRoute::route($parser1, $parser2);
	}
	return $str;
}	

function formatDateBlog($param)
{
	$D = explode("-",$param);
	$Data = $D[2].' de '.RetornaMesFull($D[1]).' de '.$D[0];
	return $Data;
}

//sepá precisa dar include nessa porra
// CONVERTE DATA PARA GRAVAR NO MYSQL COMO TIMESTAMP
function ConverteData($Data) {
	if(isset($Data)){
		 if (strpos($Data,'/') !== false)
		 {
		 $D = explode("/",$Data);
		 $Data = $D[2].'-'.$D[1].'-'.$D[0];
		 return $Data;

		 }
		 else
		 {
		 //workaround \/
		 $D = explode("-",$Data);
		 $Data = $D[2].'/'.$D[1].'/'.$D[0];
		 return $Data;
		 }
	}
}
function hehData($Data)
{
		 $D = explode("-",$Data);
		 $Data = $D[1].'/'.$D[2].'/'.$D[0];
		 return $Data;

}
// CONVERTE DATA PARA TIMESTAMP NO MYSQL PARA DATA FORMATO PT-BR
function DesConverteData($Data) {
	if(isset($Data)){
		 $D = explode("-",$Data);
		 $Data = $D[2].'/'.$D[1].'/'.$D[0];
		 //$Data = str_replace('-','/',$Data);
	return $Data;
 }

}
// CONVERTE DATA PARA TIMESTAMP NO MYSQL PARA DATA FORMATO PT-BR
function DesConverteDataHora($Data) {
	if(isset($Data)){
		 $Data = str_replace(':','-',$Data);
		 $Data = str_replace(' ','-',$Data);
		 $D = explode("-",$Data);
		 $Data = $D[2].'/'.$D[1].'/'.$D[0].' '.$D[3].':'.$D[4].':'.$D[5];
		 //$Data = str_replace('-','/',$Data);
	return $Data;
 }

}

function outputLongText($str)
{
	$texto_longo = htmlspecialchars_decode($str);
return 
<<<HERE
$texto_longo
HERE;
}

function smallifyFirstWord($param)
{
    $output = '';
    $sigh = explode(' ', $param);
    foreach($sigh as $i => $single_word)
    {       
        if($i == 0)
        {
            $output .= '<small>'.$single_word.'</small>';
        }
        else
        {
            $output .= $single_word.' ';
        }
    }
    echo $output;

}

function strongifyLastWord($param)
{
    $output = '';
    $sigh = explode(' ', $param);
    foreach($sigh as $i => $single_word)
    {       
        if(($i +1) == count($sigh))
        {
            $output .= '<strong>'.$single_word.'</strong>';
        }
        else
        {
            $output .= $single_word.' ';
        }
    }
    echo $output;
}

function spacefyLastWord($param)
{
    $output = '';
    $sigh = explode(' ', $param);
    foreach($sigh as $i => $single_word)
    {       
        if(($i +1) == count($sigh))
        {
            $output .= '<br/>'.$single_word;
        }
        else
        {
            $output .= $single_word.' ';
        }
    }
    echo $output;
}

function firstWordFromFile($param)
{
    $sigh = explode('.', $param);
    echo $sigh[0];
}


function RetornaDia($str)
{
	switch ($str) {
	  case 'Sunday':
		  return "Domingo";
		  break;
	  case 'Monday':
		  return "Segunda";
		  break;
	  case 'Tuesday':
		  return "Terça";
		  break;
	  case 'Wednesday':
		  return "Quarta";
		  break;
	  case 'Thursday':
		  return "Quinta";
		  break;
	  case 'Friday':
		  return "Sexta";
		  break;
	  case 'Saturday':
		  return "Sábado";
		  break;

	  default:
		 return $mes;
		}
}

//Retorna array com submenu
function retornaSubmenu($query)
{
    $val = array();
    $key = array();
    $submenu_array = array();
    $res = conexao::fetch($query);
    foreach($res as $single_res)
    {
         array_push($val, $single_res['tb_conteudo_link_automatico']);
         array_push($key, $single_res['tb_conteudo_titulo']);
    }
    return $submenu_array = array_combine($key, $val);
}

function retornaSubmenuSubCategoria($query)
{
    $val = array();
    $key = array();
    $submenu_array = array();
    $res = conexao::fetch($query);
    foreach($res as $single_res)
    {
         array_push($val, $single_res['tb_conteudo_subcategoria_url']);
         array_push($key, $single_res['tb_conteudo_subcategoria_nome']);
    }
    return $submenu_array = array_combine($key, $val);
}


function encryptIt($q)
{
  $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
  $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
  return( $qEncoded );
}

function decryptIt($q)
{
$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
return( $qDecoded );
}

// CONVERTE STRING EM URL AMIGÁVEL
function ConverteURL($str){
	$str = str_replace("'", "",$str);
	$str = str_replace("\"", "",$str);
	$str = str_replace("º", "",$str);
	$str = str_replace("ª", "",$str);
	$str = strtolower( strip_tags( preg_replace( array( '/[\/`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', RetiraAcentos($str) ) ) ) );
	return $str;
}


// CONVERTE NOME DA IMAGEM EM URL AMIGÁVEL
function ConverteURLimagem($str){
	$str = strtolower( strip_tags( preg_replace( array( '/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', RetiraAcentos($str) ) ) ) );
	return $str;

}
function RetornaMesFull($mes){
  switch ($mes) {
	  case '01':
		  return "Janeiro";
		  break;
	  case '02':
		  return "Fevereiro";
		  break;
	  case '03':
		  return "Março";
		  break;
	  case '04':
		  return "Abril";
		  break;
	  case '05':
		  return "Maio";
		  break;
	  case '06':
		  return "Junho";
		  break;
	  case '07':
		  return "Julho";
		  break;
	  case '08':
		  return "Agosto";
		  break;
	  case '09':
		  return "Setembro";
		  break;
	  case '10':
		  return "Outubro";
		  break;
	  case '11':
		  return "Novembro";
		  break;
	  case '12':
		  return "Dezembro";
		  break;
	  default:
		 return $mes;
  }
}

function RetornaMes($mes){
  switch ($mes) {
	  case '01':
		  return "JAN";
		  break;
	  case '02':
		  return "FEV";
		  break;
	  case '03':
		  return "MAR";
		  break;
	  case '04':
		  return "ABR";
		  break;
	  case '05':
		  return "MAI";
		  break;
	  case '06':
		  return "JUN";
		  break;
	  case '07':
		  return "JUL";
		  break;
	  case '08':
		  return "AGO";
		  break;
	  case '09':
		  return "SET";
		  break;
	  case '10':
		  return "OUT";
		  break;
	  case '11':
		  return "NOV";
		  break;
	  case '12':
		  return "DEZ";
		  break;
	  default:
		 return $mes;
  }
}

function Truncate($string, $max = 160, $rep = '…')
{
    if (strlen($string) <= ($max + strlen($rep)))
    {
        return $string;
    }
    $leave = $max - strlen ($rep);
    return substr_replace($string, $rep, $leave);
}

function RetiraAcentos($texto)
{
  $array1 = array(   "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
					 , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
  $array2 = array(   "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
					 , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
  return str_replace( $array1, $array2, $texto );
}

function getURI()
{
  return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function embedaYoutube($url)
{
	$rx = '~
	/embed/?([^&]+)
	~x';
	$has_match = preg_match($rx, $url, $matches);
	if($has_match)
	{
	    $url_output = $url;
	}
	else
	{

	    $parts = parse_url($url);
	    $id = str_replace('v=','',$parts['query']);
	    $url_output = "https://www.youtube.com/embed/".$id;
	}

	return $url_output;
}

function retornaIdYoutube($url)
{
	    $parts = parse_url($url);
	    return str_replace('v=','',$parts['query']);

}

function randomString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

function retornaEstado($sigla) {
	switch ($sigla) {
		case 'AC':
			return "Acre";
			break;
		case 'AL':
			return "Alagoas";
			break;
		case 'AM':
			return "Amazonas";
			break;
		case 'AP':
			return "Amapá";
			break;
		case 'BA':
			return "Bahia";
			break;
		case 'CE':
			return "Ceará";
			break;
		case 'DF':
			return "Distrito Federal";
			break;
		case 'ES':
			return "Espírito Santo";
			break;
		case 'GO':
			return "Goiás";
			break;
		case 'MA':
			return "Maranhão";
			break;
		case 'MG':
			return "Minas Gerais";
			break;
		case 'MS':
			return "Mato Grosso do Sul";
			break;
		case 'MT':
			return "Mato Grosso";
			break;
		case 'PA':
			return "Pará";
			break;
		case 'PB':
			return "Paraíba";
			break;
		case 'PE':
			return "Pernambuco";
			break;
		case 'PI':
			return "PiauÃ­";
			break;
		case 'PR':
			return "ParanÃ¡";
			break;
		case 'RJ':
			return "Rio de Janeiro";
			break;
		case 'RN':
			return "Rio Grande do Norte";
			break;
		case 'RO':
			return "RondÃ´nia";
			break;
		case 'RR':
			return "Roraima";
			break;
		case 'RS':
			return "Rio Grande do Sul";
			break;
		case 'SC':
			return "Santa Catarina";
			break;
		case 'SE':
			return "Sergipe";
			break;

		default:
			return $sigla;
	}
}

?>
