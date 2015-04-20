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
* acp_profile.php [Spanish [Es]]
*
* @package language
* @version $Id: $
* @copyright (c) 2010 phpBB Group. Modified by Huan Manwe for phpbb-es.com in 2010
* @author 2010-10-20 - Traducido por Huan Manwe y jakk junto con phpbb-es.com (http://www.phpbb-es.com).
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

// Custom profile fields
$lang = array_merge($lang, array(
	'ADDED_PROFILE_FIELD'	=> 'Campo de perfil personalizado añadido correctamente.',
	'ALPHA_ONLY'			=> 'Alfanumérico solamente',
	'ALPHA_SPACERS'			=> 'Alfanumérico y espacios',
	'ALWAYS_TODAY'			=> 'Siempre la fecha actual',

	'BOOL_ENTRIES_EXPLAIN'			=> 'Introduce tus opciones ahora',
	'BOOL_TYPE_EXPLAIN'				=> 'Definir el tipo, un checkbox o radio buttons',

	'CHANGED_PROFILE_FIELD'			=> 'Campo personalizado cambiado correctamente.',
	'CHARS_ANY'						=> 'Cualquier caracter',
	'CHECKBOX'						=> 'Checkbox',
	'COLUMNS'						=> 'Columnas',
	'CP_LANG_DEFAULT_VALUE'			=> 'Valor por defecto',
	'CP_LANG_EXPLAIN'				=> 'Descripción del campo',
	'CP_LANG_EXPLAIN_EXPLAIN'		=> 'Explicación para este campo presentada al usuario',
	'CP_LANG_NAME'					=> 'Nombre/título para este campo presentado al usuario',
	'CP_LANG_OPTIONS'				=> 'Opciones',
	'CREATE_NEW_FIELD'				=> 'Crear nuevo campo',
	'CUSTOM_FIELDS_NOT_TRANSLATED'	=> 'Al menos un campo de perfil personalizado no ha sido traducido aún. Por favor inserta la información requerida haciendo clic en &quot;Traducir&quot;.',

	'DEFAULT_ISO_LANGUAGE'			=> 'Idioma por defecto [%1$s]',
	'DEFAULT_LANGUAGE_NOT_FILLED'	=> 'Las definiciones para el idioma por defecto no están completas para este campo de perfil.',
	'DEFAULT_VALUE'					=> 'Valor por defecto',
	'DELETE_PROFILE_FIELD'			=> 'Eliminar campo de perfil',
	'DELETE_PROFILE_FIELD_CONFIRM'	=> '¿Seguro que quieres borrar este campo de perfil?',
	'DISPLAY_AT_PROFILE'			=> 'Mostrar en Panel de Control del Usuario',
	'DISPLAY_AT_PROFILE_EXPLAIN'	=> 'El usuario es capaz de cambiar este campo de perfil desde el Panel de Control del Usuario.',
	'DISPLAY_AT_REGISTER'			=> 'Mostrar en la pantalla de registro',
	'DISPLAY_AT_REGISTER_EXPLAIN'	=> 'Si esta opción está habilitada el campo se mostrará en el formulario de registro.',
	'DISPLAY_ON_VT'					=> 'Mostrar en la pantalla del tema',
	'DISPLAY_ON_VT_EXPLAIN'			=> 'Si esta opción está habilitada el campo será mostrado en el mini-perfil en la pantalla del tema.',
	'DISPLAY_PROFILE_FIELD'			=> 'Mostrar campo de perfil públicamente',
	'DISPLAY_PROFILE_FIELD_EXPLAIN'	=> 'El campo de perfil se mostrará en todos los lugares disponibles dentro la configuración/parámetros de carga. Configurar esto como “no” ocultará el campo de las páginas de los temas, perfiles y lista de miembros.',
	'DROPDOWN_ENTRIES_EXPLAIN'		=> 'Introduce tus opciones ahora, cada opción en una línea aparte',

	'EDIT_DROPDOWN_LANG_EXPLAIN'	=> 'Por favor fíjate en que puedes cambiar tus opciones y también añadir nuevas opciones al final. No es recomendable agregar nuevas opciones _entre_ las existentes - esto podría causar una asignación incorrecta de las opciones a los usuarios. También podría ocurrir si borras opciones intermedias. Borrar las opciones desde la última significa que usuarios asignados a este ítem volverán a sus opciones por defecto.',
	'EMPTY_FIELD_IDENT'				=> 'Notificación de campo vacío',
	'EMPTY_USER_FIELD_NAME'			=> 'Por favor introduce un nombre/título para el campo',
	'ENTRIES'						=> 'Entradas',
	'EVERYTHING_OK'				=> 'Todo OK',

	'FIELD_BOOL'				=> 'Lógico (Sí/No)',
	'FIELD_DATE'				=> 'Fecha',
	'FIELD_DESCRIPTION'			=> 'Descripción del campo',
	'FIELD_DESCRIPTION_EXPLAIN'	=> 'La explicación para el campo presentada al usuario',
	'FIELD_DROPDOWN'			=> 'Selección desplegable',
	'FIELD_IDENT'				=> 'Identificación del campo',
	'FIELD_IDENT_ALREADY_EXIST'	=> 'La identificación elegida para el campo ya existe. Por favor elige otro nombre.',
	'FIELD_IDENT_EXPLAIN'		=> 'La identificación del campo es un nombre para identificar el campo de perfil en la base de datos y plantillas.',
	'FIELD_INT'					=> 'Números',
	'FIELD_LENGTH'				=> 'Longitud del campo',
	'FIELD_NOT_FOUND'			=> 'Campo de perfil no encontrado.',
	'FIELD_STRING'				=> 'Campo de texto simple',
	'FIELD_TEXT'				=> 'Área de texto',
	'FIELD_TYPE'				=> 'Tipo de campo',
	'FIELD_TYPE_EXPLAIN'		=> 'No podrás cambiar este tipo de campo más adelante.',
	'FIELD_VALIDATION'			=> 'Validación de campo',
	'FIRST_OPTION'				=> 'Primera opción',

	'HIDE_PROFILE_FIELD'			=> 'Ocultar campo de perfil',
	'HIDE_PROFILE_FIELD_EXPLAIN'	=> 'Oculta el campo del perfil a todos los demás usuarios menos al propio usuario, administradores y moderadores quienes aún podrán ver este campo. Si la opción de Mostrar en el panel de control de usuario está desactivada el usuario no podrá ni ver ni cambiar este campo y el campo solo podrá ser cambiado por la Administración.',

	'INVALID_CHARS_FIELD_IDENT'		=> 'El campo de identificación solamente puede contener minúsculas a-z y guión bajo _',
	'INVALID_FIELD_IDENT_LEN'		=> 'El campo de identificación solamente puede tener 17 caracteres de longitud',
	'ISO_LANGUAGE'					=> 'Idioma [%s]',

	'LANG_SPECIFIC_OPTIONS'	=> 'Opciones específicas de idioma [<strong>%1$s</strong>]',

	'MAX_FIELD_CHARS'		=> 'Número máximo de caracteres',
	'MAX_FIELD_NUMBER'		=> 'Número más alto permitido',
	'MIN_FIELD_CHARS'		=> 'Número mínimo de caracteres',
	'MIN_FIELD_NUMBER'		=> 'Número más bajo permitido',

	'NO_FIELD_ENTRIES'			=> 'No se definieron entradas',
	'NO_FIELD_ID'				=> 'No se especificó ID del campo.',
	'NO_FIELD_TYPE'				=> 'No se especificó tipo de campo.',
	'NO_VALUE_OPTION'			=> 'Opción "campo vacío"',
	'NO_VALUE_OPTION_EXPLAIN'	=> 'Valor para una no-entrada. Si el campo es obligatorio, el usuario recibe un error si elige la opción seleccionada aquí',
	'NUMBERS_ONLY'				=> 'Solo números (0-9)',

	'PROFILE_BASIC_OPTIONS'		=> 'Opciones básicas',
	'PROFILE_FIELD_ACTIVATED'	=> 'Campo de perfil activado con éxito.',
	'PROFILE_FIELD_DEACTIVATED'	=> 'Campo de perfil desactivado con éxito.',
	'PROFILE_LANG_OPTIONS'		=> 'Opciones específicas de idioma',
	'PROFILE_TYPE_OPTIONS'		=> 'Opciones específicas de tipo de perfil',

	'RADIO_BUTTONS'				=> 'Radio buttons',
	'REMOVED_PROFILE_FIELD'		=> 'Campo de perfil eliminado con éxito.',
	'REQUIRED_FIELD'			=> 'Campo obligatorio',
	'REQUIRED_FIELD_EXPLAIN'	=> 'Fuerza que el campo del perfil sea rellenado o especificado por el usuario o La Administración. Si la opción de Mostrar en la pantalla de registro está habilitada el campo solo será requerido cuando el usuario edite su perfil.',
	'ROWS'						=> 'Filas',

	'SAVE'					=> 'Guardar',
	'SECOND_OPTION'			=> 'Segunda opción',
	'SHOW_NOVALUE_FIELD'			=> 'Mostrar el campo si no fue seleccionado un valor',
	'SHOW_NOVALUE_FIELD_EXPLAIN'	=> 'Determina si el campo de perfil que se debe mostrar si no fue seleccionado un valor para los campos opcionales, o si no has seleccionado un valor aún para los campos obligatorios.',
	'STEP_1_EXPLAIN_CREATE'	=> 'Aquí puedes insertar los primeros parámetros básicos de su nuevo campo de perfil. Esta información es necesaria para el segundo paso donde pueden identificarse las opciones restantes y hacer una vista previa o más ajustes.',
	'STEP_1_EXPLAIN_EDIT'	=> 'Aquí puedes cambiar los parámetros básicos del campo de perfil. Las opciones relevantes son recalculadas en el segundo paso, donde puedes hacer una vista previa y probar los parámetros cambiados.',
	'STEP_1_TITLE_CREATE'	=> 'Crear campo de perfil',
	'STEP_1_TITLE_EDIT'		=> 'Editar título del campo',
	'STEP_2_EXPLAIN_CREATE'	=> 'Aquí puedes definir algunas opciones comunes. Más adelante puedes hacer una vista previa del campo, tal como lo vería el usuario. Ve probando hasta que quede como deseas.',
	'STEP_2_EXPLAIN_EDIT'	=> 'Aquí puede cambiar algunas opciones comunes. Más adelante puede hacer una vista previa de los cambios, tal como lo vería el usuario. Prueba hasta que quede como deseas.<br /><strong>Por favor obsérvese que estos cambios no afectarán a los perfiles existentes de los usuarios.</strong>',
	'STEP_2_TITLE_CREATE'	=> 'Opciones específicas del tipo de perfil',
	'STEP_2_TITLE_EDIT'		=> 'Opciones específicas del tipo de perfil',
	'STEP_3_EXPLAIN_CREATE'	=> 'Ya que tienes más de un idioma instalado para el Sitio, has de completar los ítems en los idiomas restantes. EL campo funcionará con el idioma por defecto, puedes completar los idiomas restantes después.',
	'STEP_3_EXPLAIN_EDIT'	=> 'Ya que tienes más de un idioma instalado para el Sitio, has de cambiar los ítems en los idiomas restantes. EL campo funcionará con el idioma por defecto.',
	'STEP_3_TITLE_CREATE'	=> 'Definiciones de idioma restantes',
	'STEP_3_TITLE_EDIT'		=> 'Definiciones de idioma',
	'STRING_DEFAULT_VALUE_EXPLAIN'	=> 'Introduce una palabra por defecto para mostrar, un valor por defecto. Déjalo vacío si quieres que se muestre vacío en primer término.',

	'TEXT_DEFAULT_VALUE_EXPLAIN'	=> 'Introduce un texto por defecto para mostrar, un valor por defecto. Déjalo vacío si quieres que se muestre vacío en primer término.',
	'TRANSLATE'						=> 'Traducir',

	'USER_FIELD_NAME'	=> 'Campo nombre/título mostrado al usuario',

	'VISIBILITY_OPTION'				=> 'Opciones de visibilidad',
));

?>