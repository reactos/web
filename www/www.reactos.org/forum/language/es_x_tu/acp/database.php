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
* acp_database.php [Spanish [Es]]
*
* @package language
* @version $Id: $
* @copyright (c) 2010 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010 
* @author 2010-10-20 - Traducido por Huan Manwe junto con phpbb-es.com (http://www.phpbb-es.com).
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

// Database Backup/Restore
$lang = array_merge($lang, array(
	'ACP_BACKUP_EXPLAIN'	=> 'Aquí puedes hacer un copia de seguridad de toda la información relacionada con phpBB. Puedes guardar el archivo resultante en tu carpeta <samp>store/</samp> o descargarlo a tu PC. Dependiendo de la configuración del servidor puedes comprimir el archivo en varios formatos.',
	'ACP_RESTORE_EXPLAIN'	=> 'Esto efectuará una recuperación completa de todas las tablas de phpBB guardadas en el archivo. Si el servidor lo permite, puedes usar un archivo comprimido con gzip o bzip2 y será descomprimido automáticamente. <strong>ADVERTENCIA</strong> Esto sobreescribirá cualquier dato existente. La recuperación puede llevar algún tiempo, por favor no lo muevas de esta página hasta que se complete.',

	'BACKUP_DELETE'		=> 'El archivo de copia de seguridad ha sido borrado correctamente.',
	'BACKUP_INVALID'	=> 'El archivo seleccionado para hacer la copia de seguridad no es válido.',
	'BACKUP_OPTIONS'	=> 'Opciones de copia de seguridad',
	'BACKUP_SUCCESS'	=> 'El archivo de copia de seguridad ha sido creado correctamente.',
	'BACKUP_TYPE'		=> 'Tipo de copia de seguridad',

	'DATABASE'					=> 'Utilidades de base de datos',
	'DATA_ONLY'					=> 'Solo los datos',
	'DELETE_BACKUP'				=> 'Borrar copia de seguridad',
	'DELETE_SELECTED_BACKUP'	=> '¿Estás seguro de que quieres borrar la copia de seguridad seleccionada?',
	'DESELECT_ALL'				=> 'Desmarcar todo',
	'DOWNLOAD_BACKUP'			=> 'Descargar copia de seguridad',

	'FILE_TYPE'					=> 'Tipo de archivo',
	'FILE_WRITE_FAIL'       	=> 'Ha sido imposible escribir el archivo en el directorio contenedor.',
	'FULL_BACKUP'				=> 'Completo',

	'RESTORE_FAILURE'			=> 'El archivo de copia de seguridad puede estar corrupto.',
	'RESTORE_OPTIONS'			=> 'Restaurar opciones',
	'RESTORE_SELECTED_BACKUP'	=> '¿Está usted seguro de querer restaurar el backup seleccionado?',
	'RESTORE_SUCCESS'			=> 'La base de datos ha sido restaurada correctamente.<br /><br />El Sitio debería volver al estado en que se encontraba cuando se hizo la copia de seguridad.',

	'SELECT_ALL'				=> 'Seleccionar todo',
	'SELECT_FILE'				=> 'Seleccionar un archivo',
	'START_BACKUP'				=> 'Comenzar copia de seguridad',
	'START_RESTORE'				=> 'Comenzar restauración',
	'STORE_AND_DOWNLOAD'		=> 'Guardar y descargar',
	'STORE_LOCAL'				=> 'Guardar archivo localmente',
	'STRUCTURE_ONLY'			=> 'Solo la estructura',

	'TABLE_SELECT'			=> 'Seleccionar tabla/s',
	'TABLE_SELECT_ERROR'	=> 'Tienes que seleccionar al menos una tabla.',
));

?>