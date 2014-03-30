<?php
/**
*
* recaptcha [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2009 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-11-17
* @copyright (c) 2011 phpBBItalia.net - translated on 2011-06-17
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'RECAPTCHA_LANG'				=> 'it',
	'RECAPTCHA_NOT_AVAILABLE'		=> 'Per poter utilizzare reCaptcha, è necessario creare un account su <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'CAPTCHA_RECAPTCHA'				=> 'reCaptcha',
	'RECAPTCHA_INCORRECT'			=> 'Il codice di conferma visuale che hai inviato non è corretto',

	'RECAPTCHA_PUBLIC'				=> 'Chiave pubblica reCaptcha',
	'RECAPTCHA_PUBLIC_EXPLAIN'		=> 'La tua chiave pubblica reCaptcha. Le chiavi possono essere ottenute su <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',
	'RECAPTCHA_PRIVATE'				=> 'Chiave privata reCaptcha',
	'RECAPTCHA_PRIVATE_EXPLAIN'		=> 'La tua chiave privata reCaptcha. Le chiavi possono essere ottenute su <a href="http://www.google.com/recaptcha">www.google.com/recaptcha</a>.',

	'RECAPTCHA_EXPLAIN'				=> 'Per prevenire invii automatici, ti chiediamo di inserire il testo visualizzato.',
));

?>