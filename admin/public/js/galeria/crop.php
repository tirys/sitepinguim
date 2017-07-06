<?php

// ideally one day this can do more than one image... 
// they would be stacked up to crop all at once in 
// Impromptu.. thus returning an array
date_default_timezone_set('UTC');

ini_set('display_errors',1);
ini_set('log_errors',1);
error_reporting(E_ALL);

define('DS', DIRECTORY_SEPARATOR);
define('CURR_DIR', dirname(__FILE__) . DS);
define('UPLOAD_DIR', '../../../uploads/images/galeria/');

require "gd_image.php";
$gd = new GdImage();

foreach($_POST['imgcrop'] as $k => $v) {
	
	/*
		1) delete the resized image from upload, we will only be working with the full size
		2) compute new coordinates of full size image
		3) crop full size image
		4) resize the cropped image to what ever size we need
	*/
	
	// 1) delete resized, move to full size
	$filePath = UPLOAD_DIR . $v['filename'];
	$fullSizeFilePath = UPLOAD_DIR . $gd->createName($v['filename'], '_FULLSIZE');
	$thumb = UPLOAD_DIR . 'thumbnail_'.$gd->createName($v['filename']);

	unlink($filePath);
	rename($fullSizeFilePath, $filePath);

	// 2) compute the new coordinates
	$scaledSize = $gd->getProperties($filePath);
	$percentChange = $scaledSize['w'] / 500; // we know we scaled by width of 500 in upload
	$newCoords = array(
		'x' => $v['x'] * $percentChange,
		'y' => $v['y'] * $percentChange,
		'w' => $v['w'] * $percentChange,
		'h' => $v['h'] * $percentChange
	);

	// 3) crop the full size image
	//maybe crop the resized image??
	$gd->crop($filePath, $newCoords['x'], $newCoords['y'], $newCoords['w'], $newCoords['h']);

	$parts = explode('__',$v['filename']);
	$tamanho_grande = $parts[1];
	$tamanho_pequeno = $parts[2];

	// 4) resize the cropped image to whatever size we need (lets go with 200 wide)
	//aqui que eu seto o final output da cropagem \/
	$tamanhos_grandes = explode('x',$tamanho_grande);
	$tamanhos_pequenos = explode('x',$tamanho_pequeno);
	
	
	if($tamanhos_grandes[0] == $tamanhos_grandes[1])
	{
		//se é quadrado
		$wwidth = $tamanhos_grandes[0];
		$hheight = $tamanhos_grandes[1];

		$wwidth_2 = ($tamanhos_pequenos[0]);
		$hheight_2 =($tamanhos_pequenos[1] + $tamanhos_pequenos[1]*0.2);

		
/*		$wwidth = $tamanhos_grandes[0] ;
		$hheight = $tamanhos_grandes[1] + ($tamanhos_grandes[1]);

		$wwidth_2 = ($tamanhos_pequenos[0]*0.8);
		$hheight_2 =($tamanhos_pequenos[1]*0.6);
*/
	}
	else
	{
		//se é retangulo
		//thumb ta ruim pra caraio sem maldade

		$wwidth = ($tamanhos_grandes[0]);
		$hheight = ($tamanhos_grandes[1]);

		//teoricamente thumb \/	
		$wwidth_2 = ($tamanhos_pequenos[0]);
		$hheight_2 = ($tamanhos_pequenos[1] +$tamanhos_pequenos[1]*0.2 );

	}


	$ar = $gd->getAspectRatio($newCoords['w'], $newCoords['h'], $wwidth, $hheight);
	$att = $gd->getAspectRatio($newCoords['w'], $newCoords['h'], $wwidth_2, $hheight_2);

	$gd->copy($filePath, $thumb); //copia thumb a partir da full_size
	$gd->resize($filePath, $ar['w'], $ar['h']); 
	$gd->resize($thumb, $att['w'], $att['h']); 
	//salvar no bd

}

echo "1";
