<?php
/**
*
* This program is the full and free Spanish (of Spain) phpBB 3.0 Translation.
* Copyright (c) 2007 Huan Manwe for phpbb-es.com
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*
**/

/**
*
* search.php [Spanish [Es]]
*
* @package language
* @version $Id: $
* @copyright (c) 2007 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com) basado en la version argentina hecha por larveando.com.ar ).
* @author - ImagePack made by Xoom (webmaster of http://www.muchografico.com and colaborator of http://www.phpbb-es.com)
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License 
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
	'ALL_AVAILABLE'	=> 'Todos los disponibles',
	'ALL_RESULTS'	=> 'Todos los resultados',
	
	'DISPLAY_RESULTS'	=> 'Mostrar resultados como',
	
	'FOUND_SEARCH_MATCH'		=> 'Se encontró %d coincidencia',
	'FOUND_SEARCH_MATCHES'		=> 'Se encontraron %d coincidencias',
	'FOUND_MORE_SEARCH_MATCHES'	=> 'Se encontraron más de %d coincidencia',
	
	'GLOBAL'	=> 'Anuncio global',
	
	'IGNORED_TERMS'			=> 'Ignorado',
	'IGNORED_TERMS_EXPLAIN'	=> 'Las siguientes palabras en tu consulta fueron ignoradas porque son palabras demasiado comunes: <strong>%s</strong>',
	
	'JUMP_TO_POST'	=> 'Saltar al mensaje',
	
	'LOGIN_EXPLAIN_EGOSEARCH'	=> 'El foro requiere que estés registrado e identificado para ver tus propios mensajes.',
	'LOGIN_EXPLAIN_NEWPOSTS'	=> 'El foro requiere que estés registrado e identificado para ver nuevos mensajes desde tu última visita.',
	'LOGIN_EXPLAIN_UNREADSEARCH'=> 'El foro requiere que estés registrado e identificado para ver tus mensajes sin leer.',
    'MAX_NUM_SEARCH_KEYWORDS_REFINE'   => 'Especificaste demasiadas palabras a buscar. Por favor, no insertes más de %1$d palabras.',
	
	'NO_KEYWORDS'		=> 'Debes especificar al menos una palabra para buscar. Cada palabra debe tener al menos %d caracteres y no debe contener más de %d caracteres excluyendo los comodines.',
	'NO_RECENT_SEARCHES'=> 'No se han realizado búsquedas recientemente',
	'NO_SEARCH'			=> 'Disculpa, no te está permitido usar el sistema de búsqueda.',
	'NO_SEARCH_RESULTS'	=> 'No se encontraron coincidencias.',
	'NO_SEARCH_TIME'	=> 'Disculpa, no puede buscar en este momento. Por favor, intenta de nuevo en unos minutos.',
	'NO_SEARCH_UNREADS'		=> 'Disculpa, pero la búsqueda de mensajes no leídos ha sido deshabilitada en este foro.',
	'WORD_IN_NO_POST'	=> 'La palabra <strong>%s</strong> no se encuentra en ningún mensaje.',
	'WORDS_IN_NO_POST'	=> 'Las palabras <strong>%s</strong> no se encuentran en ningún mensaje.',
	
	'POST_CHARACTERS'	=> 'Caracteres del mensaje',
	
	'RECENT_SEARCHES'		=> 'Búsquedas recientes',
	'RESULT_DAYS'			=> 'Limitar resultados previos a',
	'RESULT_SORT'			=> 'Ordenar resultados por',
	'RETURN_FIRST'			=> 'Mostrar los primeros',
	'RETURN_TO_SEARCH_ADV'	=> 'Volver a búsqueda avanzada',

	'SEARCHED_FOR'				=> 'Término buscado',
	'SEARCHED_TOPIC'			=> 'Mensaje buscado',
	'SEARCHED_QUERY'			=> 'Consulta buscada',
	'SEARCH_ALL_TERMS'			=> 'Buscar todos los términos',
	'SEARCH_ANY_TERMS'			=> 'Buscar cualquier término',
	'SEARCH_AUTHOR'				=> 'Buscar autor',
	'SEARCH_AUTHOR_EXPLAIN'		=> 'Emplea * como comodín para coincidencias parciales.',
	'SEARCH_FIRST_POST'			=> 'Solo el primer mensaje de los temas',
	'SEARCH_FORUMS'				=> 'Buscar en Foros',
	'SEARCH_FORUMS_EXPLAIN'		=> 'Selecciona el Foro o Foros en los que deseas buscar. Para agilizar puedes buscar en los subforos seleccionando el Foro padre y habilitar la búsqueda en los subforos (en Opciones de búsqueda).',
	'SEARCH_IN_RESULTS'			=> 'Buscar en los resultados',
	'SEARCH_KEYWORDS_EXPLAIN'	=> 'Escribe <strong>+</strong> delante de una palabra a encontrar y <strong>-</strong> delante de la palabra para excluirla. Crea una lista de palabras separadas por <strong>|</strong> entre corchetes si solo una de ellas se quiere encontrar. Emplea <strong>*</strong> como comodín para coincidencias parciales.',
	'SEARCH_MSG_ONLY'			=> 'Solo el texto del mensaje',
	'SEARCH_OPTIONS'			=> 'Opciones de búsqueda',
	'SEARCH_QUERY'				=> 'Consulta',
	'SEARCH_SUBFORUMS'			=> 'Buscar en subforos',
	'SEARCH_TITLE_MSG'			=> 'Título y texto del mensaje',
	'SEARCH_TITLE_ONLY'			=> 'Solo títulos',
	'SEARCH_WITHIN'				=> 'Buscar en ',
	'SORT_ASCENDING'			=> 'Ascendente',
	'SORT_AUTHOR'				=> 'Autor',
	'SORT_DESCENDING'			=> 'Descendente',
	'SORT_FORUM'				=> 'Foro',
	'SORT_POST_SUBJECT'			=> 'Asunto del mensaje',
	'SORT_TIME'					=> 'Fecha',
	
	'TOO_FEW_AUTHOR_CHARS'		=> 'Debes especificar al menos %d caracteres del nombre del autor.',
));

?>