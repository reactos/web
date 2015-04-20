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
* acp_attachments.php [Spanish [Es]]
*
* @package language
* @version $Id: attachments.php 8555 2008-07-11 19:07:11Z HuanManwe $
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
	'ACP_ATTACHMENT_SETTINGS_EXPLAIN'	=> 'Aquí puedes configurar los principales parámetros para archivos adjuntos y las categorías especiales asociadas.',
	'ACP_EXTENSION_GROUPS_EXPLAIN'		=> 'Aquí puedes añadir, borrar, modificar o deshabilitar los grupos de extensiones. Opciones adicionales incluyen su asignación a una categoría especial, cambiar el mecanismo de descarga y definir un icono que se mostrará delante del adjunto que pertenezca al grupo.',
	'ACP_MANAGE_EXTENSIONS_EXPLAIN'		=> 'Aquí puedes editar tus extensiones permitidas. Para activar tus extensiones, por favor dirígete al Panel de Administración (ACP) de extensiones de grupo. Te recomendamos encarecidamente no permitir extensiones de scripts (como <code>php</code>, <code>php3</code>, <code>php4</code>, <code>phtml</code>, <code>pl</code>, <code>cgi</code>, <code>py</code>, <code>rb</code>, <code>asp</code>, <code>aspx</code>, y similares).',
	'ACP_ORPHAN_ATTACHMENTS_EXPLAIN'	=> 'Aquí puedes ver qué archivos están en la carpeta de subidas sin ser asignados a ningún mensaje. Esto ocurre generalmente si el usuario adjunta un archivo pero no envía el mensaje. Puedes borrar estos archivos o asignarlos a un mensaje existente. Esto requiere de un ID de mensaje válido por lo que has de determinarlo por tu cuenta. Esta utilidad es principalmente para aquellas personas que quieren subir archivos (por lo general grandes) con otro programa (p.ej. con un cliente ftp) y asignarlos a un mensaje ya existente.',
	'ADD_EXTENSION'						=> 'Añadir extensión',
	'ADD_EXTENSION_GROUP'				=> 'Añadir grupo de extensiones',
	'ADMIN_UPLOAD_ERROR'				=> 'Se podrujo algún error mientras tratabas de adjuntar un archivo: %s',
	'ALLOWED_FORUMS'					=> 'Foros permitidos',
	'ALLOWED_FORUMS_EXPLAIN'			=> 'Habilitado enviar las extensiones asignadas al foro (o foros) seleccionado(s)',
	'ALLOWED_IN_PM_POST'				=> 'Permitido',
	'ALLOW_ATTACHMENTS'					=> 'Permitir adjuntos',
	'ALLOW_ALL_FORUMS'					=> 'Permitir todos los Foros',
	'ALLOW_IN_PM'						=> 'Permitir en Mensajes Privados',
	'ALLOW_PM_ATTACHMENTS'				=> 'Permitir adjuntos en Mensajes Privados',
	'ALLOW_SELECTED_FORUMS'				=> 'Solo los Foros seleccionados debajo',
	'ASSIGNED_EXTENSIONS'				=> 'Extensiones asignadas',
	'ASSIGNED_GROUP'					=> 'Grupo de extensiones asignado',
	'ATTACH_EXTENSIONS_URL'				=> 'Extensiones',
	'ATTACH_EXT_GROUPS_URL'				=> 'Grupos de extensiones',
	'ATTACH_ID'							=> 'ID',
	'ATTACH_MAX_FILESIZE'				=> 'Tamaño máximo',    
	'ATTACH_MAX_FILESIZE_EXPLAIN'		=> 'Tamaño máximo de cada archivo. Si este valor es 0, el tamaño del archivo para subir sólo estará limitado por la configuración de PHP.',
	'ATTACH_MAX_PM_FILESIZE'			=> 'Máximo por usuario',
	'ATTACH_MAX_PM_FILESIZE_EXPLAIN'	=> 'Tamaño máximo, 0 (cero) significa ilimitado, de un archivo adjuntado a un Mensaje Privado.',
	'ATTACH_ORPHAN_URL'					=> 'Adjuntos huérfanos',
	'ATTACH_POST_ID'					=> 'Mensaje ID',
	'ATTACH_QUOTA'						=> 'Máximo total para adjuntos',
	'ATTACH_QUOTA_EXPLAIN'				=> 'Máximo en disco disponible para adjuntos en todo el Sitio, 0 (cero) significa ilimitado.',
	'ATTACH_TO_POST'					=> 'Adjuntar archivo a mensaje',

	'CAT_FLASH_FILES'					=> 'Archivos Flash',
	'CAT_IMAGES'						=> 'Imágenes',
	'CAT_QUICKTIME_FILES'				=> 'Archivos Quicktime',
	'CAT_RM_FILES'						=> 'Archivos RealMedia',
	'CAT_WM_FILES'						=> 'Archivos Windows Media',
	'CHECK_CONTENT'				=> 'Comprobar archivos adjuntos',
	'CHECK_CONTENT_EXPLAIN'		=> 'Algunos navegadores pueden ser engañados para que asuman un mimetype de archivos subibles incorrecto. Esta opción previene que tales archivos, que puedan causar eso, sean rechazados.',
	'CREATE_GROUP'						=> 'Crear nuevo grupo',
	'CREATE_THUMBNAIL'					=> 'Crear vista en miniatura',
	'CREATE_THUMBNAIL_EXPLAIN'			=> 'Crear vista en miniatura siempre que sea posible.',

	'DEFINE_ALLOWED_IPS'				=> 'Definir IPs/hostnames permitidos',
	'DEFINE_DISALLOWED_IPS'				=> 'Definir IPs/hostnames no permitidos',
	'DOWNLOAD_ADD_IPS_EXPLAIN'			=> 'Para especificar varias IPs o hostnames diferentes, introduce cada una en una nueva línea. Para especificar un rango de direcciones IP separe el inicio y el final con un guión (-), para especificar un comodín use *',
	'DOWNLOAD_REMOVE_IPS_EXPLAIN'		=> 'Puedes eliminar (o des-excluir) múltiples direcciones IP al mismo tiempo usando la combinación apropiada de ratón y teclado para tu navegador (p.ej. Ctrl+Clic). Las IPs <em>excluidas</em> están en negrita.',
	'DISPLAY_INLINED'					=> 'Mostrar imagenes',
	'DISPLAY_INLINED_EXPLAIN'			=> 'Si eliges "Sin imagen", los adjuntos se mostrarán como un enlace.',
	'DISPLAY_ORDER'						=> 'Mostrar adjuntos ordenados',
	'DISPLAY_ORDER_EXPLAIN'				=> 'Muestra los adjuntos ordenados por fecha.',

	'EDIT_EXTENSION_GROUP'				=> 'Editar grupo de extensiones',
	'EXCLUDE_ENTERED_IP'				=> 'Habilítalo para excluir la IP/hostname ingresada.',
	'EXCLUDE_FROM_ALLOWED_IP'			=> 'Excluir IP de las IPs/hostnames permitidas',
	'EXCLUDE_FROM_DISALLOWED_IP'		=> 'Excluir IP de las IPs/hostnames no permitidas',
	'EXTENSIONS_UPDATED'				=> 'Extensiones actualizadas correctamente',
	'EXTENSION_EXIST'					=> 'La extensión %s ya existe',
	'EXTENSION_GROUP'					=> 'Grupo de extensiones',
	'EXTENSION_GROUPS'					=> 'Grupos de extensiones',
	'EXTENSION_GROUP_DELETED'			=> 'Grupo de extensiones borrado correctamente.',
	'EXTENSION_GROUP_EXIST'				=> 'El grupo de extensiones %s ya existe',
	'EXT_GROUP_ARCHIVES'  => 'Archivos',
	'EXT_GROUP_DOCUMENTS'  => 'Documentos',
	'EXT_GROUP_DOWNLOADABLE_FILES'   => 'Archivos descargables',
	'EXT_GROUP_FLASH_FILES'	  => 'Archivos flash',
	'EXT_GROUP_IMAGES'	  => 'Imágenes',
	'EXT_GROUP_PLAIN_TEXT'	  => 'Texto plano',
	'EXT_GROUP_QUICKTIME_MEDIA'   => 'Quicktime Media',
	'EXT_GROUP_REAL_MEDIA'	  => 'Real Media',
	'EXT_GROUP_WINDOWS_MEDIA'      => 'Windows Media',

	'GO_TO_EXTENSIONS'					=> 'Ir a la sección de administración de extensiones',
	'GROUP_NAME'						=> 'Nombre del Grupo',

	'IMAGE_LINK_SIZE'					=> 'Dimensiones de la imagen enlazada',
	'IMAGE_LINK_SIZE_EXPLAIN'			=> 'Mostrar la imagen adjunta como un enlace si es más grande. 0px por 0px significa ilimitado.',
	'IMAGICK_PATH'						=> 'Ruta a Imagemagick',
	'IMAGICK_PATH_EXPLAIN'				=> 'Ruta completa al programa imagemagick, p.ej. <samp>/usr/bin/</samp>',

	'MAX_ATTACHMENTS'					=> 'Número de adjuntos máximos por mensaje',
	'MAX_ATTACHMENTS_PM'				=> 'Número de adjuntos máximos por Mensaje Privado',
	'MAX_EXTGROUP_FILESIZE'				=> 'Tamaño máximo',
	'MAX_IMAGE_SIZE'					=> 'Dimensiones máximas',
	'MAX_IMAGE_SIZE_EXPLAIN'			=> 'Dimensiones máximas de la imagen adjunta. 0px por 0px significa ilimitado.',
	'MAX_THUMB_WIDTH'					=> 'Ancho máximo de la vista en miniatura en píxeles',
	'MAX_THUMB_WIDTH_EXPLAIN'			=> 'La mini-imagen generada no excederá este ancho',
	'MIN_THUMB_FILESIZE'				=> 'Tamaño mínimo para vista en miniatura',
	'MIN_THUMB_FILESIZE_EXPLAIN'		=> 'No crear vista en miniatura para imágenes más pequeñas que esto.',
	'MODE_INLINE'						=> 'Modo Inline',
	'MODE_PHYSICAL'						=> 'Modo Físico',

	'NOT_ALLOWED_IN_PM'					=> 'Solo permitido en Mensajes',
	'NOT_ALLOWED_IN_PM_POST'			=> 'No permitido',
	'NOT_ASSIGNED'						=> 'No asignado',
	'NO_EXT_GROUP'						=> 'Ninguno',
	'NO_EXT_GROUP_NAME'					=> 'No introdujiste el nombre del Grupo',
	'NO_EXT_GROUP_SPECIFIED'			=> 'No especificaste Grupo de Extensiones.',
	'NO_FILE_CAT'						=> 'Ninguno',
	'NO_IMAGE'							=> 'Sin imagen',
	'NO_THUMBNAIL_SUPPORT'				=> 'El soporte para vista en miniatura ha sido deshabilitado porque no se encontró la librería GD ni el programa imagemagick.',
	'NO_UPLOAD_DIR'						=> 'La carpeta de subidas que especificaste no existe.',
	'NO_WRITE_UPLOAD'					=> 'La carpeta de subidas que especificaste no se puede escribir. Por favor cambia los permisos en el servidor.',

	'ONLY_ALLOWED_IN_PM'				=> 'Solo permitido en Mensajes Privados',
	'ORDER_ALLOW_DENY'					=> 'Permitir',
	'ORDER_DENY_ALLOW'					=> 'Denegar',

	'REMOVE_ALLOWED_IPS'				=> 'Eliminar o des-excluir IPs/hostnames <em>permitidas</em>',
	'REMOVE_DISALLOWED_IPS'				=> 'Eliminar o des-excluir IPs/hostnames <em>no permitidas</em>',

	'SEARCH_IMAGICK'					=> 'Buscar Imagemagick',
	'SECURE_ALLOW_DENY'					=> 'Lista Permitidos/No permitidos',
	'SECURE_ALLOW_DENY_EXPLAIN'			=> 'Cuando está habilitada la Descarga Segura cambia el comportamiento por defecto de la Lista Permitidos/No permitidos de <strong>lista blanca</strong> (Permitido) a <strong>lista negra</strong> (No permitido)',
	'SECURE_DOWNLOADS'					=> 'Habilitar Descarga Segura',
	'SECURE_DOWNLOADS_EXPLAIN'			=> 'Con esta opción habilitada, las descargas se limitan a las IP’s/hostnames que definas.',
	'SECURE_DOWNLOAD_NOTICE'			=> 'Descarga Segura no está habilitada. Los configuración de debajo se aplicarán después de habilitarla.',
	'SECURE_DOWNLOAD_UPDATE_SUCCESS'	=> 'La lista de IP ha sido actualizada correctamente.',
	'SECURE_EMPTY_REFERRER'				=> 'Permitir referrer vacío',
	'SECURE_EMPTY_REFERRER_EXPLAIN'		=> 'Descarga Segura está basada en referrers. ¿Quieres permitir las descargas para aquellos que omitan sus referrers?',
	'SETTINGS_CAT_IMAGES'				=> 'Configuración de Categoría de Imagen',
	'SPECIAL_CATEGORY'					=> 'Categoría Especial',
	'SPECIAL_CATEGORY_EXPLAIN'			=> 'Las Categorías Especiales son diferentes formas de presentar los mensajes.',
	'SUCCESSFULLY_UPLOADED'				=> 'Subido correctamente',
	'SUCCESS_EXTENSION_GROUP_ADD'		=> 'Grupo de extensiones agregado con éxito',
	'SUCCESS_EXTENSION_GROUP_EDIT'		=> 'Grupo de extensiones actualizado con éxito',

	'UPLOADING_FILES'					=> 'Subiendo archivos',
	'UPLOADING_FILE_TO'					=> 'Subiendo archivo "%1$s" al mensaje número %2$d…',
	'UPLOAD_DENIED_FORUM'				=> 'No tienes permisos para subir archivos al foro "%s"',
	'UPLOAD_DIR'						=> 'Carpeta de subidas',
	'UPLOAD_DIR_EXPLAIN'				=> 'Ruta donde se guardan los adjuntos.',
	'UPLOAD_ICON'						=> 'Icono de subida',
	'UPLOAD_NOT_DIR'					=> 'La ubicación que especificaste no parece ser una carpeta.',
));

?>