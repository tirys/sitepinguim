<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
* 
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation; either version 2 
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
*/

function removeSpecialChars($oldText)
{
     if ( strlen($oldText) > strlen(utf8_decode($oldText)) )
    {
        $oldText = utf8_decode($oldText);
    }
    $newText = preg_replace('[^a-zA-Z0-9_-.]', '', strtr($oldText, 'áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ', 'aaaaeeiooouucAAAAEEIOOOUUC_'));
    if ( !(strlen($newText) > 0) )
    {
        $newText = 'nome_invalido-'.getRandomNumbers().getRandomNumbers();
    }
    return $newText;
}


 
class SimpleImage {
   
   var $image;
   var $image_type;
 
   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {
         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {
         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {
         $this->image = imagecreatefrompng($filename);
      }
   }
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=100, $permissions=null) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image,$filename);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image,$filename);
      }   
      if( $permissions != null) {
         chmod($filename,$permissions);
      }
   }
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);         
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }   
   }
   function getWidth() {
      return imagesx($this->image);
   }
   function getHeight() {
      return imagesy($this->image);
   }
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }
   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }
   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100; 
      $this->resize($width,$height);
   }
   
   
   function resize_height_width_fixed($width,$height) {
	  
	  $width_max = $width;
	  $height_max = $height;
	  
	  $width_original = $this->getWidth();
      $height_original = $this->getheight(); 		
		
	  if ($width_original > $width){
	  $height = ($width / $width_original) * $height_original;
	  }else{
	  $width = ($height / $height_original) * $width_original ;
	  }
	
	  if ($height_original < $height){
	  $height = (($height_original - $height)*-1) + $height;
	  $width = ($height / $height_original) * $width_original ;
	  }		  	

      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, $height, $height, $height_max, $height_max, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
	  
	  //imagecopyresampled($new_image, $source_image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height);
	  
	  
	  

   }      
   
   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;   
   }      
   
   
   
   
   
   
   
   
   function resize_image($destination_width, $destination_height, $type = 0) { 
    // $type (1=crop to fit, 2=letterbox) 
    $source_width = $this->getWidth(); 
    $source_height = $this->getHeight(); 
    $source_ratio = $source_width / $source_height; 
    $destination_ratio = $destination_width / $destination_height; 
    if ($type == 1) { 
        // crop to fit 
        if ($source_ratio > $destination_ratio) { 
            // source has a wider ratio 
            $temp_width = (int)($source_height * $destination_ratio); 
            $temp_height = $source_height; 
            $source_x = (int)(($source_width - $temp_width) / 2); 
            $source_y = 0; 
        } else { 
            // source has a taller ratio 
            $temp_width = $source_width; 
            $temp_height = (int)($source_width / $destination_ratio); 
            $source_x = 0; 
            $source_y = (int)(($source_height - $temp_height) / 2); 
        } 
        $destination_x = 0; 
        $destination_y = 0; 
        $source_width = $temp_width; 
        $source_height = $temp_height; 
        $new_destination_width = $destination_width; 
        $new_destination_height = $destination_height; 
    } else { 
        // letterbox 
        if ($source_ratio < $destination_ratio) { 
            // source has a taller ratio 
            $temp_width = (int)($destination_height * $source_ratio); 
            $temp_height = $destination_height; 
            $destination_x = (int)(($destination_width - $temp_width) / 2); 
            $destination_y = 0; 
        } else { 
            // source has a wider ratio 
            $temp_width = $destination_width; 
            $temp_height = (int)($destination_width / $source_ratio); 
            $destination_x = 0; 
            $destination_y = (int)(($destination_height - $temp_height) / 2); 
        } 
        $source_x = 0; 
        $source_y = 0; 
        $new_destination_width = $temp_width; 
        $new_destination_height = $temp_height; 
    } 
    $new_image = imagecreatetruecolor($destination_width, $destination_height); 
    if ($type > 1) { 
        imagefill($new_image, 0, 0, imagecolorallocate ($new_image, 0, 0, 0)); 
    } 
    imagecopyresampled($new_image,  $this->image, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height); 
    $this->image = $new_image;   
} 
   
   
   
   
   
   
   
   
   
   
}
?>