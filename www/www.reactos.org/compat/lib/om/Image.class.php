<?php
    /*
    CompatDB - ReactOS Compatability Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    */


/**
 * class Image
 * 
 */
class Image
{



  /**
   * @FILLME
   *
   * @access public
   */
  public static function toPNG($img_source, $save_to, $str)
  {
    $font = 2;
    
		$size = GetImageSize($img_source);
		$im_in = ImageCreateFromPNG($img_source);
		
		$im_out = imagecreatetruecolor($size[0], $size[1]);
		
		ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
		   
		#Find X & Y for note
		$X_var = imagesx($im_out) - imagefontwidth($font)*strlen($str);
		$Y_var = imagesy($im_out) - imagefontheight($font);
		
		#Color
		$white = ImageColorAllocate($im_out, 0, 0, 0);
		
		#Add note(simple: site address)
		ImageString($im_out,$font,$X_var,$Y_var,$str,$white);
		
		ImagePNG($im_out, $save_to); // Create image
		ImageDestroy($im_in);
		ImageDestroy($im_out);
  } // end of member function icon



  /**
   * @FILLME
   *
   * @access public
   */
  public static function toJPG($img_source, $save_to, $str)
  {
    $font = 2;
    
		$size = GetImageSize($img_source);
		$im_in = ImageCreateFromJPEG($img_source);
		
		$im_out = imagecreatetruecolor($size[0], $size[1]);
		
		ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
		   
		#Find X & Y for note
		$X_var = imagesx($im_out) - imagefontwidth($font)*strlen($str);
		$Y_var = imagesy($im_out) - imagefontheight($font);
		
		#Color
		$white = ImageColorAllocate($im_out, 0, 0, 0);
		
		#Add note(simple: site address)
		ImageString($im_out,$font,$X_var,$Y_var,$str,$white);
		
		ImageJPEG($im_out, $save_to, 100); // Create image
		ImageDestroy($im_in);
		ImageDestroy($im_out);
  } // end of member function icon



  /**
   * @FILLME
   *
   * @access public
   */
  public static function thumb($type, $img_source, $save_to, $width, $str)
  { 
    switch ($type) {

      // PNG
      case 'image/png':
        self::thumbPNG($img_source, $save_to, $width, $str);
        break;

      // JPEG
      case 'image/jpeg':
        self::thumbJPG($img_source, $save_to, $width, $str);
        break;

      // ...
      default:
      echo 'domg:'.$type;
        break;
    }

  } // end of member function icon



  /**
   * @FILLME
   *
   * @access public
   */
  public static function thumbPNG($img_source, $save_to, $width, $str)
  {
    $font = 2;
    
		$size = GetImageSize($img_source);
		$im_in = ImageCreateFromPNG($img_source);
		
		$new_height = ($width * $size[1]) / $size[0]; // Generate new height for image
		$im_out = imagecreatetruecolor($width, $new_height);
		
		ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $width, $new_height, $size[0], $size[1]);
		   
		#Find X & Y for note
		$X_var = imagesx($im_out) - imagefontwidth($font)*strlen($str);
		$Y_var = imagesy($im_out) - imagefontheight($font);
		
		#Color
		$white = ImageColorAllocate($im_out, 0, 0, 0);
		
		#Add note(simple: site address)
		ImageString($im_out,$font,$X_var,$Y_var,$str,$white);
		
		ImagePNG($im_out, $save_to); // Create image
		ImageDestroy($im_in);
		ImageDestroy($im_out);

  } // end of member function icon



  /**
   * @FILLME
   *
   * @access public
   */
  public static function thumbJPG($img_source, $save_to, $width, $str)
  {
    $font = 2;
 
		$size = GetImageSize($img_source);
		$im_in = ImageCreateFromJPEG($img_source);
		
		$new_height = ($width * $size[1]) / $size[0]; // Generate new height for image
		$im_out = imagecreatetruecolor($width, $new_height);
		
		ImageCopyResampled($im_out, $im_in, 0, 0, 0, 0, $width, $new_height, $size[0], $size[1]);
		
		#Find X & Y for note
		$X_var = imagesx($im_out) - imagefontwidth($font)*strlen($str);
		$Y_var = imagesy($im_out) - imagefontheight($font);
		
		#Color
		$white = ImageColorAllocate($im_out, 0, 0, 0);
		
		#Add note(simple: site address)
		ImageString($im_out,$font,$X_var,$Y_var,$str,$white);
		
		ImageJPEG($im_out, $save_to, 100); // Create image
		ImageDestroy($im_in);
		ImageDestroy($im_out);

  } // end of member function icon



} // end of Award
?>
