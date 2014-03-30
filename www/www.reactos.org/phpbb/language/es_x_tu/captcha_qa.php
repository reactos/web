<?php
/**
*
* recaptcha [Spanish [Es]]
*
* @package language
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com).
* @version $Id: captcha_qa.php 9966 2009-08-12 15:12:03Z Kellanved $
* @copyright (c) 2009 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010 
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
	'CAPTCHA_QA'				=> 'Q&amp;A (Preguntas y Respuestas)',
	'CONFIRM_QUESTION_EXPLAIN'   => 'Esta pregunta es una forma de evitar inserciones automatizadas por spambots.',
	'CONFIRM_QUESTION_WRONG'	=> 'Has proporcionado una respuesta incorrecta a la pregunta.',

	'QUESTION_ANSWERS'			=> 'Respuestas',
	'ANSWERS_EXPLAIN'			=> 'Por favor introduce respuestas válidas para la pregunta, una por línea.',
	'CONFIRM_QUESTION'			=> 'Pregunta',

	'ANSWER'					=> 'Respuesta',
	'EDIT_QUESTION'				=> 'Editar pregunta',
	'QUESTIONS'					=> 'Preguntas',
	'QUESTIONS_EXPLAIN'         => 'Por cada formulario de envío donde hayas habilitado el plugin Q&amp;A, a los usuarios se les formulará una de las preguntas especificadas aquí. Para usar este plugin al menos una pregunta debe ser configurada en el idioma por defecto del foro. Estas preguntas deberían ser fáciles de responder para la mayoría de tus usuarios pero más allá de la habilidad de un robot capaz de realizar una búsqueda en Google™. Usar un amplio conjunto de preguntas y cambiarlas de forma regular dará el mejor resultado. Activa la opción de Chequeo Estricto si tu pregunta depende de tildes, mayúsculas o puntuación.',
	'QUESTION_DELETED'         => 'Pregunta eliminada',
	'QUESTION_LANG'            => 'Idioma',
	'QUESTION_LANG_EXPLAIN'      => 'El idioma en el que esta pregunta y sus respuestas están escritas.',
	'QUESTION_STRICT'         => 'Chequeo Estricto',
	'QUESTION_STRICT_EXPLAIN'   => 'A activar si quieres forzar la mezcla de mayúsculas y minúsculas, caracteres especiales de puntuación y el espacio en blanco.',

	'QUESTION_TEXT'            => 'Pregunta',
	'QUESTION_TEXT_EXPLAIN'      => 'La pregunta a presentar al usuario.',

	'QA_ERROR_MSG'				=> 'Por favor rellena todos los campos e introduce al menos una respuesta.',
	'QA_LAST_QUESTION'			=> 'No puedes eliminar todas las preguntas mientras el plugin esté activo.',
));

?>