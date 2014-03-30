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
* posting.php [Spanish [Es]]
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

$lang = array_merge($lang, array(
	'ADD_ATTACHMENT'			=> 'Subir adjunto',
	'ADD_ATTACHMENT_EXPLAIN'	=> 'Si quieres adjuntar uno o más archivos introduce los detalles debajo',
	'ADD_FILE'					=> 'Agregar archivo',
	'ADD_POLL'					=> 'Agregar encuesta',
	'ADD_POLL_EXPLAIN'			=> 'Si no quieres agregar una encuesta a su tema, deja los campos en blanco',
	'ALREADY_DELETED'			=> 'Disculpa, este mensaje ya ha sido borrado.',
	'ATTACH_DISK_FULL'			=> 'No hay suficiente espacio libre en el disco para publicar este adjunto.',    
	'ATTACH_QUOTA_REACHED'		=> 'Disculpa, la cuota de adjuntos del Sitio está a tope.',
	'ATTACH_SIG'				=> 'Adjuntar firma (las firmas se pueden modificar en el Panel de Control de Usuario)',

	'BBCODE_A_HELP'				=> 'Insertar adjunto: [attachment=]filename.ext[/attachment]',
	'BBCODE_B_HELP'				=> 'Texto en negrita: [b]texto[/b]  (alt+b)',
	'BBCODE_C_HELP'				=> 'Mostrar código: [code]código[/code]  (alt+c)',
	'BBCODE_D_HELP'				=> 'Flash: [flash=width,height]http://url[/flash]',
	'BBCODE_F_HELP'				=> 'Tamaño de fuente: [size=x-small]texto pequeño[/size]',
	'BBCODE_IS_OFF'				=> '%sBBCode%s está <em>deshabilitado</em>',
	'BBCODE_IS_ON'				=> '%sBBCode%s está <em>habilitado</em>',
	'BBCODE_I_HELP'				=> 'Texto Itálica: [i]texto[/i]  (alt+i)',
	'BBCODE_L_HELP'				=> 'Lista: [list]texto[/list]  (alt+l)',
	'BBCODE_LISTITEM_HELP'		=> 'Listar ítem: [*]text',
	'BBCODE_O_HELP'				=> 'Lista ordenada: Por ejemplo, [list=1][*]Primer punto[/list] o [list=a][*]Punto a[/list]',
	'BBCODE_P_HELP'				=> 'Inserta imagen: [img]http://imagen_url[/img]  (alt+p)',
	'BBCODE_Q_HELP'				=> 'Citar texto: [quote]texto[/quote]  (alt+q)',
	'BBCODE_S_HELP'				=> 'Color de fuente: [color=red]texto[/color]  Tip: puede usar código de color=#FF0000',
	'BBCODE_U_HELP'				=> 'Texto subrayado: [u]texto[/u]  (alt+u)',
	'BBCODE_W_HELP'				=> 'Insertar URL: [url]http://url[/url] ó [url=http://url]URL texto[/url]  (alt+w)',
	'BBCODE_Y_HELP'				=> 'Lista: Añadir elemento a la lista',
	'BUMP_ERROR'				=> 'No puedes activar este tema tan pronto.',

	'CANNOT_DELETE_REPLIED'		=> 'Disculpa, solamente puedes borrar mensajes que no hayan sido respondidos.',
	'CANNOT_EDIT_POST_LOCKED'	=> 'Este mensaje ha sido cerrado. Ya no puedes editar este mensaje.',
	'CANNOT_EDIT_TIME'			=> 'Ya no puedes editar o borrar este mensaje',
	'CANNOT_POST_ANNOUNCE'		=> 'Disculpa, no puedes publicar anuncios.',
	'CANNOT_POST_STICKY'		=> 'Disculpa, no puedes publicar temas fijos.',
	'CHANGE_TOPIC_TO'			=> 'Cambiar tipo de tema a',
	'CLOSE_TAGS'				=> 'Cerrar etiquetas',
	'CURRENT_TOPIC'				=> 'Tema actual',

	'DELETE_FILE'				=> 'Borrar archivo',
	'DELETE_MESSAGE'			=> 'Borrar mensaje',
	'DELETE_MESSAGE_CONFIRM'	=> '¿Estás seguro de que quieres borrar este mensaje?',
	'DELETE_OWN_POSTS'			=> 'Disculpa, solo puedes borrar tus propios mensajes.',
	'DELETE_POST_CONFIRM'		=> '¿Estás seguro de que quieres borrar este hilo de mensajes?',
	'DELETE_POST_WARN'			=> 'Una vez borrado, el hilo de mensajes no puedes recuperarse',
	'DISABLE_BBCODE'			=> 'Deshabilitar BBCode',
	'DISABLE_MAGIC_URL'			=> 'No convertir automáticamente las URLs',
	'DISABLE_SMILIES'			=> 'Deshabilitar emoticonos',
	'DISALLOWED_CONTENT'		=> 'La subida fue rechazada porque el archivo a subir fue identificado como un posible vector de ataque.',
	'DISALLOWED_EXTENSION'		=> 'La extensión %s no está permitida',
	'DRAFT_LOADED'				=> 'Borrador subido al área de envío. ¿Quieres terminar su mensaje ahora?<br />Tu borrador será eliminado después de enviar el mensaje.',
	'DRAFT_LOADED_PM'			=> 'Borrador subido en área de mensajes, puedes terminarlo ahora.<br />Tu borrador será borrado después de enviar este mensaje privado.',
	'DRAFT_SAVED'				=> 'Borrador guardado correctamente.',
	'DRAFT_TITLE'				=> 'Título del borrador',

	'EDIT_REASON'				=> 'Razón para editar este mensaje',
	'EMPTY_FILEUPLOAD'			=> 'El archivo subido está vacío',
	'EMPTY_MESSAGE'				=> 'Tienes que enviar un mensaje cuando publiques.',
	'EMPTY_REMOTE_DATA'			=> 'Imposible subir el archivo, por favor, intenta subirlo manualmente.',

	'FLASH_IS_OFF'				=> '[flash] está <em>deshabilitado</em>',
	'FLASH_IS_ON'				=> '[flash] está <em>habilitado</em>',
	'FLOOD_ERROR'				=> 'No puedes enviar otro mensaje tan pronto.',
	'FONT_COLOR'				=> 'Color de fuente',
	'FONT_COLOR_HIDE'			=> 'Ocultar color de fuente',
	'FONT_HUGE'					=> 'Enorme',
	'FONT_LARGE'				=> 'Grande',
	'FONT_NORMAL'				=> 'Normal',
	'FONT_SIZE'					=> 'Tamaño de fuente',
	'FONT_SMALL'				=> 'Pequeña',
	'FONT_TINY'					=> 'Diminuta',

	'GENERAL_UPLOAD_ERROR'		=> 'Imposible subir el adjunto a %s',

	'IMAGES_ARE_OFF'			=> '[img] está <em>deshabilitado</em>',
	'IMAGES_ARE_ON'				=> '[img] está <em>habilitado</em>',
	'INVALID_FILENAME'			=> '%s es un nombre de archivo no válido',

	'LOAD'						=> 'Cargar',
	'LOAD_DRAFT'				=> 'Cargar borrador',
	'LOAD_DRAFT_EXPLAIN'		=> 'Aquí puedes seleccionar el borrador que quieras continuar redactando. Tu mensaje actual será cancelado, el contenido será borrado. Puedes ver, borrar y editar borradores en su Panel de Control de Usuario.',
	'LOGIN_EXPLAIN_BUMP'		=> 'Necesitas identificarte para activar temas en este foro.',
	'LOGIN_EXPLAIN_DELETE'		=> 'Necesitas identificarte para borrar mensajes en este foro.',
	'LOGIN_EXPLAIN_POST'		=> 'Necesitas identificarte para enviar mensajes en este foro.',
	'LOGIN_EXPLAIN_QUOTE'		=> 'Necesitas identificarte para citar mensajes en este foro.',
	'LOGIN_EXPLAIN_REPLY'		=> 'Necesitas identificarte para responder temas en este foro.',

	'MAX_FONT_SIZE_EXCEEDED'	=> 'Solo puedes usar fuentes de un tamaño hasta %1$d.',
	'MAX_FLASH_HEIGHT_EXCEEDED'	=> 'Tus archivos flash solo pueden ser hasta %1$d pixeles de alto.',
	'MAX_FLASH_WIDTH_EXCEEDED'	=> 'Tus archivos flash solo pueden ser hasta %1$d pixeles de ancho.',
	'MAX_IMG_HEIGHT_EXCEEDED'	=> 'Tus imágenes solo pueden ser hasta %1$d pixeles de alto.',
	'MAX_IMG_WIDTH_EXCEEDED'	=> 'Tus imágenes solo pueden ser hasta %1$d pixeles de ancho.',

	'MESSAGE_BODY_EXPLAIN'		=> 'Introduce tu mensaje aquí, no puede tener más de <strong>%d</strong> caracteres.',
	'MESSAGE_DELETED'			=> 'Este mensaje ha sido borrado correctamente',
	'MORE_SMILIES'				=> 'Ver más emoticonos',

	'NOTIFY_REPLY'				=> 'Enviarme un email cuando un mensaje es respondido',
	'NOT_UPLOADED'				=> 'El archivo no se pudo subir.',
	'NO_DELETE_POLL_OPTIONS'	=> 'No puedes borrar las opciones existentes de la encuesta',
	'NO_PM_ICON'				=> 'Sin icono',
	'NO_POLL_TITLE'				=> 'Tienes que poner un título a la encuesta',
	'NO_POST'					=> 'El mensaje requerido no existe.',
	'NO_POST_MODE'				=> 'No se especificó el modo de mensaje',

	'PARTIAL_UPLOAD'			=> 'El archivo fue solo parcialmente subido',
	'PHP_SIZE_NA'				=> 'El tamaño del archivo adjunto es muy grande.<br />No se puede determinar el tamaño máximo definido por PHP en php.ini.',
	'PHP_SIZE_OVERRUN'			=> 'El tamaño del archivo adjunto es muy grande, el tamaño máximo de subida es %1$d %2$s.<br />Por favor ten en cuenta que está definido en php.ini y no puede ser cambiado.',
	'PLACE_INLINE'				=> 'Insertar en texto',
	'POLL_DELETE'				=> 'Borrar encuesta',
	'POLL_FOR'					=> 'Hacer encuesta para',
	'POLL_FOR_EXPLAIN'			=> 'Introduce 0 (cero) o deja en blanco para una encuesta sin límite de tiempo',
	'POLL_MAX_OPTIONS'			=> 'Opciones por usuario',
	'POLL_MAX_OPTIONS_EXPLAIN'	=> 'Éste es el número de opciones que cada usuario puede seleccionar cuando vota.',
	'POLL_OPTIONS'				=> 'Opciones de encuesta',
	'POLL_OPTIONS_EXPLAIN'		=> 'Coloca cada opción en una nueva línea. Puedes introducir hasta <strong>%d</strong> opciones',
	'POLL_OPTIONS_EDIT_EXPLAIN'	=> 'Coloca cada opción en una nueva línea. Puedes introducir hasta <strong>%d</strong> opciones. Si eliminas o añades opciones todos los votos previos se resetearán.',
	'POLL_QUESTION'				=> 'Pregunta de la encuesta',
	'POLL_TITLE_TOO_LONG'		=> 'El título de la encuesta debe tener menos de 100 caracteres.',
	'POLL_TITLE_COMP_TOO_LONG'	=> 'El título de la encuesta es demasiado largo, puedes eliminar BBcode o emoticonos.',
	'POLL_VOTE_CHANGE'			=> 'Permitir cambiar el voto',
	'POLL_VOTE_CHANGE_EXPLAIN'	=> 'Si está habilitado, los usuarios pueden cambiar su voto.',
	'POSTED_ATTACHMENTS'		=> 'Adjuntos publicados',
	'POST_APPROVAL_NOTIFY'		=> 'Se te notificará cuando su mensaje sea aprobado.',
	'POST_CONFIRMATION'			=> 'Confirmación del mensaje',
	'POST_CONFIRM_EXPLAIN'		=> 'Para prevenir creaciones automáticas de nuevos temas el administrador del Sitio requiere que introduzcas un código de confirmación. El código es mostrado en la imagen que deberías poder ver debajo. Si tienes problemas de visión, o de alguna manera no puedes leer el código por favor contacta con la %sAdministración del Foro%s.',
	'POST_DELETED'				=> 'Este mensaje ha sido borrado correctamente',
	'POST_EDITED'				=> 'Este mensaje ha sido editado correctamente',
	'POST_EDITED_MOD'			=> 'Este mensaje ha sido editado, pero requiere aprobación',
	'POST_GLOBAL'				=> 'Global',
	'POST_ICON'					=> 'Icono del mensaje',
	'POST_NORMAL'				=> 'Normal',
	'POST_REVIEW'				=> 'Revisar el mensaje',
	'POST_REVIEW_EDIT'			=> 'Revisión del mensaje',
	'POST_REVIEW_EDIT_EXPLAIN'	=> 'Este mensaje ha sido modificado por otro usuario mientras estabas editándolo. Puedes querer revisar la versión actual de este mensaje y ajustar sus modificaciones.',
	'POST_REVIEW_EXPLAIN'		=> 'Al menos una revisión ha sido hecha a este mensaje. Tal vez quieras volver a ver tu mensaje.',
	'POST_STORED'				=> 'Este mensaje ha sido publicado correctamente.',
	'POST_STORED_MOD'			=> 'El mensaje ha sido guardado pero requiere aprobación.',
	'POST_TOPIC_AS'				=> 'Tema como',
	'PROGRESS_BAR'				=> 'Barra de progreso',

	'QUOTE_DEPTH_EXCEEDED'		=> 'Puede anidar solo %1$d citas una dentro de otra.',

	'SAVE'						=> 'Guardar',
	'SAVE_DATE'					=> 'Guardado como',
	'SAVE_DRAFT'				=> 'Guardar borrador',
	'SAVE_DRAFT_CONFIRM'		=> 'Por favor ten en cuenta que los borradores guardados solo incluyen el tema y el mensaje, cualquier otro elemento será eliminado. ¿Quieres guardar su borrador ahora?',
	'SMILIES'					=> 'Emoticonos',
	'SMILIES_ARE_OFF'			=> 'Emoticonos están <em>deshabilitados</em>',
	'SMILIES_ARE_ON'			=> 'Emoticonos están <em>habilitados</em>',
	'STICKY_ANNOUNCE_TIME_LIMIT'=> 'Fecha límite para Fijo/Anuncio',
	'STICK_TOPIC_FOR'			=> 'Fijar tema para',
	'STICK_TOPIC_FOR_EXPLAIN'	=> 'Introduce 0 (cero) o deja en blanco para un Fijo/Anuncio sin límite de tiempo. Por favor ten en cuenta que este número está relacionado con la fecha de publicación del mensaje.',
	'STYLES_TIP'				=> 'Consejo: Pueden aplicarse estilos rápidamente al texto seleccionado',

	'TOO_FEW_CHARS'				=> 'Tu mensaje contiene muy pocos caracteres.',
	'TOO_FEW_CHARS_LIMIT'		=> 'Tu mensaje contiene %1$d caracteres. El número mínimo de caracteres que necesitas introducir es %2$d.',
	'TOO_FEW_POLL_OPTIONS'		=> 'Tienes que introducir al menos dos opciones para la encuesta',
	'TOO_MANY_ATTACHMENTS'		=> 'No puedes añadir otro adjunto, %d es el máximo.',
	'TOO_MANY_CHARS'			=> 'Tu mensaje contiene demasiados caracteres.',
	'TOO_MANY_CHARS_POST'		=> 'Tu mensaje contiene %1$d caracteres. El máximo número de caracteres permitidos es %2$d.',
	'TOO_MANY_CHARS_SIG'		=> 'Tu firma contiene %1$d caracteres. El máximo número de caracteres permitidos es %2$d.',
	'TOO_MANY_POLL_OPTIONS'		=> 'Intentas introducir demasiadas opciones para la encuesta',
	'TOO_MANY_SMILIES'			=> 'Tu mensaje contiene demasiados emoticonos. El número máximo de emoticonos permitidos es %d.',
	'TOO_MANY_URLS'				=> 'Tu mensaje contiene demasiadas URLs. El número máximo de URLs permitidas es %d.',
	'TOO_MANY_USER_OPTIONS'		=> 'No puedes especificar más opciones por usuario que la cantidad de opciones de la encuesta',
	'TOPIC_BUMPED'				=> 'El tema ha sido reactivado correctamente',

	'UNAUTHORISED_BBCODE'		=> 'No puedes usar ciertos BBCodes: %s',
	'UNGLOBALISE_EXPLAIN'		=> 'Para volver este tema de global a normal has de seleccionar el foro en el que quiere mostrarlo.',
	'UPDATE_COMMENT'			=> 'Actualizar comentario',
	'URL_INVALID'				=> 'La URL que especificaste no es válida.',
	'URL_NOT_FOUND'				=> 'No se puede encontrar el archivo especificado.',
	'URL_IS_OFF'				=> '[url] está <em>deshabilitado</em>',
	'URL_IS_ON'					=> '[url] está <em>habilitado</em>',
	'USER_CANNOT_BUMP'			=> 'No puedes activar temas en este Foro',
	'USER_CANNOT_DELETE'		=> 'No puedes borrar temas en este Foro',
	'USER_CANNOT_EDIT'			=> 'No puedes editar mensajes en este Foro',
	'USER_CANNOT_REPLY'			=> 'No puedes responder en este Foro',
	'USER_CANNOT_FORUM_POST'	=> 'No puedes realizar esa operación en este Foro debido a que el tipo de Foro no lo soporta.',

	'VIEW_MESSAGE'				=> '%1$sVer el mensaje enviado%2$s',
	'VIEW_PRIVATE_MESSAGE'		=> '%sVer tu mensaje privado enviado%s',

	'WRONG_FILESIZE'			=> 'El archivo es muy grande, el tamaño máximo permitido es %1d %2s',
	'WRONG_SIZE'				=> 'La imagen debe tener al menos %1$d pixeles de ancho, %2$d pixeles de alto y a lo sumo %3$d pixeles de ancho y %4$d pixeles de alto. La imagen enviada tiene %5$d pixeles de ancho y %6$d pixeles de alto.',
));

?>