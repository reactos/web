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
* acp_modules.php [Spanish [Es]]
*
* @package language
* @copyright (c) 2010 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com).
* @author - ImagePack made by Xoom (webmaster of http://www.muchografico.com and colaborator of http://www.phpbb-es.com)
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License
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
//


$lang = array_merge($lang, array(
	'ACP_MODULE_MANAGEMENT_EXPLAIN'		=> 'Aquí puedes manejar toda clase de módulos. Por favor observa que el Panel de Administración (ACP) tiene una estructura de menú de tres niveles (Categoría -> SubCategoría -> Módulo) por lo cual los otros tienen una estructura de menú de dos niveles (Categoría -> Módulo) la cual debe ser respetada. Por favor date cuenta de que puedes bloquearte a ti mismo si deshabilitas o borras el módulo de administración de módulos.',
	'ADD_MODULE'						=> 'Añadir módulo',
	'ADD_MODULE_CONFIRM'				=> '¿Estás seguro de que quieres añadir el módulo seleccionado?',
	'ADD_MODULE_TITLE'					=> 'Añadir título',

	'CANNOT_REMOVE_MODULE'				=> 'No se puede eliminar el módulo, tiene hijos asignados. Por favor borra o mueve todos los hijos antes de realizar esta acción.',
	'CATEGORY'							=> 'Categoría',
	'CHOOSE_MODE'						=> 'Elegir modo',
	'CHOOSE_MODE_EXPLAIN'				=> 'Elegir en qué modo se usará el módulo.',
	'CHOOSE_MODULE'						=> 'Elegir módulo',
	'CHOOSE_MODULE_EXPLAIN'				=> 'Elegir el archivo asociado a este módulo.',
	'CREATE_MODULE'						=> 'Crear nuevo módulo',

	'DEACTIVATED_MODULE'				=> 'Módulo desactivado',
	'DELETE_MODULE'						=> 'Borrar módulo',
	'DELETE_MODULE_CONFIRM'				=> '¿Estás seguro de que quieres borrar este módulo?',

	'EDIT_MODULE'						=> 'Editar módulo',
	'EDIT_MODULE_EXPLAIN'				=> 'Aquí puedes introducir parámetros específicos del módulo',

	'HIDDEN_MODULE'					   	=> 'Módulo oculto',

	'MODULE'							=> 'Módulo',
	'MODULE_ADDED'						=> 'Módulo añadido correctamente.',
	'MODULE_DELETED'					=> 'Módulo eliminado correctamente.',
	'MODULE_DISPLAYED'					=> 'Módulo mostrado',
	'MODULE_DISPLAYED_EXPLAIN'			=> 'Si no quieres mostrar este módulo, pero quieres usarlo, selecciona No.',
	'MODULE_EDITED'						=> 'Módulo editado correctamente.',
	'MODULE_ENABLED'					=> 'Módulo habilitado',
	'MODULE_LANGNAME'					=> 'Idioma del módulo',
	'MODULE_LANGNAME_EXPLAIN'			=> 'Introduce el nombre del módulo. Usa constante de idioma si el nombre es tomado del archivo de idioma.',
	'MODULE_TYPE'						=> 'Tipo de módulo',

	'NO_CATEGORY_TO_MODULE'				=> 'Imposible convertir categoría en módulo. Por favor borra/mueve todos los hijos antes de realizar esta acción.',
	'NO_MODULE'							=> 'No hay módulos.',
	'NO_MODULE_ID'						=> 'No se especificó ID de módulo.',
	'NO_MODULE_LANGNAME'				=> 'No se especificó idioma del módulo.',
	'NO_PARENT'							=> 'Sin Padre',

	'PARENT'							=> 'Padre',
	'PARENT_NO_EXIST'					=> 'Padre no existe.',

	'SELECT_MODULE'						=> 'Selecciona un módulo',
));

?>