<?php
/**
*
* recaptcha [French]
*
* @package language
* @version $Id$
* @copyright (c) 2009 phpBB Group, (c) Maël Soucaze
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
	'RECAPTCHA_LANG'				=> 'fr',
	'RECAPTCHA_NOT_AVAILABLE'		=> 'Avant de pouvoir utiliser reCAPTCHA, vous devez créer un compte sur <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'CAPTCHA_RECAPTCHA'				=> 'reCAPTCHA',
	'RECAPTCHA_INCORRECT'			=> 'Le code de confirmation visuelle que vous avez saisi est incorrect',

	'RECAPTCHA_PUBLIC'				=> 'Clé publique reCAPTCHA ',
	'RECAPTCHA_PUBLIC_EXPLAIN'		=> 'Votre clé publique sur reCAPTCHA. Les clés peuvent être obtenues sur <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'RECAPTCHA_PRIVATE'				=> 'Clé privée reCAPTCHA ',
	'RECAPTCHA_PRIVATE_EXPLAIN'		=> 'Votre clé privée sur reCAPTCHA. Les clés peuvent être obtenues sur <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',

	'RECAPTCHA_EXPLAIN'				=> 'Dans un effort de prévention luttant contre les actions automatisées, nous vous demandons de bien vouloir saisir les deux mots affichés dans le champ de texte ci-dessous.',
));

?>