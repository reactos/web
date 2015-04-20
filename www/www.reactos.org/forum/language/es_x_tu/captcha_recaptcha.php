<?php
/**
*
* recaptcha [Spanish [Es]]
*
* @package language
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com).
* @version $Id: captcha_recaptcha.php 9933 2009-08-06 09:12:21Z marshalrusty $
* @copyright (c) 2009 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2009 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'RECAPTCHA_LANG'				=> 'es',
	'RECAPTCHA_NOT_AVAILABLE'		=> 'Para poder usar reCaptcha, debes crear una cuenta en <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'CAPTCHA_RECAPTCHA'				=> 'reCaptcha',
	'RECAPTCHA_INCORRECT'			=> 'El código de confirmación visual que insertaste era incorrecto',

	'RECAPTCHA_PUBLIC'				=> 'Clave Pública reCaptcha',
	'RECAPTCHA_PUBLIC_EXPLAIN'		=> 'Tu Clave Pública reCaptcha. Se pueden obtener las claves en <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'RECAPTCHA_PRIVATE'				=> 'Clave Privada reCaptcha',
	'RECAPTCHA_PRIVATE_EXPLAIN'		=> 'Tu Clave Privada reCaptcha. Se pueden obtener las claves en <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',

	'RECAPTCHA_EXPLAIN'				=> 'En un esfuerzo por prevenir inserciones automáticas requerimos que introduzcas las dos palabras mostradas dentro del campo de texto.',
));

?>