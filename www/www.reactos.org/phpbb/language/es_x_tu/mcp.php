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
* mcp.php [Spanish [Es]]
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
	'ACTION'				=> 'Acción',
	'ACTION_NOTE'			=> 'Acción/Nota',
	'ADD_FEEDBACK'			=> 'Añadir feedback',
	'ADD_FEEDBACK_EXPLAIN'	=> 'Si quieres enviar un informe, por favor completa el siguiente formulario. Emplea solo texto plano; HTML, BBCode, etc. no está permitido.',
	'ADD_WARNING'			=> 'Añadir advertencia',
	'ADD_WARNING_EXPLAIN'	=> 'Para enviar una advertencia a estos usuarios por favor completa el siguiente formulario. Emplea solo texto plano; HTML, BBCode, etc. no está permitido.',
	'ALL_ENTRIES'			=> 'Todas las entradas',
	'ALL_NOTES_DELETED'		=> 'Todas las notas borradas correctamente',
	'ALL_REPORTS'			=> 'Todos los informes',
	'ALREADY_REPORTED'		=> 'Ya se ha informado este mensaje',
	'ALREADY_REPORTED_PM'	=> 'Este mensaje privado ya ha sido notificado.',
	'ALREADY_WARNED'		=> 'Ya se ha enviado una advertencia por este mensaje',
	'APPROVE'				=> 'Aprobar',
	'APPROVE_POST'			=> 'Aprobar mensaje',
	'APPROVE_POST_CONFIRM'	=> '¿Estás seguro de que quieres aprobar este mensaje?',
	'APPROVE_POSTS'			=> 'Aprobar mensajes',
	'APPROVE_POSTS_CONFIRM'	=> '¿Estás seguro de que quieres aprobar estos mensajes?',

	'CANNOT_MOVE_SAME_FORUM'	=> 'No puedes mover un tema al Foro en el que ya se encuentra',
	'CANNOT_WARN_ANONYMOUS'		=> 'No puedes advertir a un usuario no registrado',
	'CANNOT_WARN_SELF'			=> 'No puedes advertirte a ti mismo',
	'CAN_LEAVE_BLANK'			=> 'No puedes dejarlo en blanco.',
	'CHANGE_POSTER'				=> 'Cambiar autor',
	'CLOSE_PM_REPORT'		=> 'Cerrar informe de MP',
	'CLOSE_PM_REPORT_CONFIRM'	=> '¿Estás seguro de que quieres cerrar el informe de MP seleccionado?',
	'CLOSE_PM_REPORTS'		=> 'Cerrar informes de MP',
	'CLOSE_PM_REPORTS_CONFIRM'	=> '¿Estás seguro de que quieres cerrar los informes de MP seleccionados?',
	'CLOSE_REPORT'				=> 'Cerrar informe',
	'CLOSE_REPORT_CONFIRM'		=> '¿Estás seguro de que quieres cerrar el informe seleccionado?',
	'CLOSE_REPORTS'				=> 'Cerrar informes',
	'CLOSE_REPORTS_CONFIRM'		=> '¿Estás seguro de que quieres cerrar los informes seleccionados?',

	'DELETE_PM_REPORT'			=> 'Borrar informe de MP',
	'DELETE_PM_REPORT_CONFIRM'	=> '¿Estás seguro de que quieres borrar el informe de MP seleccionado?',
	'DELETE_PM_REPORTS'			=> 'Borrar informes de MP',
	'DELETE_PM_REPORTS_CONFIRM'	=> '¿Estás seguro de que quieres borrar los informes de MP seleccionados?',
	'DELETE_POSTS'				=> 'Borrar mensajes',
	'DELETE_POSTS_CONFIRM'		=> '¿Estás seguro de que quieres borrar estos mensajes?',
	'DELETE_POST_CONFIRM'		=> '¿Estás seguro de que quieres borrar este mensaje?',
	'DELETE_REPORT'				=> 'Borrar informe',
	'DELETE_REPORT_CONFIRM'		=> '¿Estás seguro de que quieres borrar el informe seleccionado?',
	'DELETE_REPORTS'			=> 'Borrar informes',
	'DELETE_REPORTS_CONFIRM'	=> '¿Estás seguro de que quieres borrar los informes seleccionados?',
	'DELETE_SHADOW_TOPIC'		=> 'Borrar tema sombreado',
	'DELETE_TOPICS'				=> 'Borrar temas',
	'DELETE_TOPICS_CONFIRM'		=> '¿Estás seguro de que quieres borrar estos temas?',
	'DELETE_TOPIC_CONFIRM'		=> '¿Estás seguro de que quieres borrar este tema?',
	'DISAPPROVE'				=> 'Rechazar',
	'DISAPPROVE_REASON'			=> 'Razón del rechazo',
	'DISAPPROVE_POST'			=> 'Rechazar mensaje',
	'DISAPPROVE_POST_CONFIRM'	=> '¿Estás seguro de que quieres rechazar este mensaje?',
	'DISAPPROVE_POSTS'			=> 'Rechazar mensajes',
	'DISAPPROVE_POSTS_CONFIRM'	=> '¿Estás seguro de que quieres rechazar los mensajes seleccionados?',
	'DISPLAY_LOG'				=> 'Mostrar entradas previas',
	'DISPLAY_OPTIONS'			=> 'Opciones de visualización',

	'EMPTY_REPORT'				=> 'Tienes que introducir una descripción cuando selecciones esta razón',
	'EMPTY_TOPICS_REMOVED_WARNING'	=> 'Por favor observa que uno o varios temas han sido eliminados de la base de datos porque estaban vacíos',

	'FEEDBACK'					=> 'Feedback',
	'FORK'						=> 'División',
	'FORK_TOPIC'				=> 'Dividir tema',
	'FORK_TOPIC_CONFIRM'		=> '¿Estás seguro de que quieres dividir el tema?',
	'FORK_TOPICS'				=> 'Dividir temas seleccionados',
	'FORK_TOPICS_CONFIRM'		=> '¿Estás seguro de que quieres dividir los temas seleccionados?',
	'FORUM_DESC'				=> 'Descripción',
	'FORUM_NAME'				=> 'Nombre del foro',
	'FORUM_NOT_EXIST'			=> 'El foro que seleccionaste no existe',
	'FORUM_NOT_POSTABLE'		=> 'No se puede enviar mensajes en el foro que seleccionaste',
	'FORUM_STATUS'				=> 'Estado del foro',
	'FORUM_STYLE'				=> 'Estilo del foro',

	'GLOBAL_ANNOUNCEMENT'		=> 'Anuncio global',

	'IP_INFO'					=> 'Información de la dirección IP',
	'IPS_POSTED_FROM'			=> 'Dirección IP desde dónde este usuario ha enviado el mensaje',

	'LATEST_LOGS'				=> 'Últimos 5 registros',
	'LATEST_REPORTED'			=> 'Últimos 5 informes',
	'LATEST_REPORTED_PMS'		=> 'Últimos 5 informes de MP',
	'LATEST_UNAPPROVED'			=> 'Últimos 5 mensajes esperando aprobación',
	'LATEST_WARNING_TIME'		=> 'Última advertencia enviada',
	'LATEST_WARNINGS'			=> 'Últimas 5 advertencias',
	'LEAVE_SHADOW'				=> 'Dejar tema sombreado aquí',
	'LIST_REPORT'				=> '1 informe',
	'LIST_REPORTS'				=> '%d informes',
	'LOCK'						=> 'Cerrado',
	'LOCK_POST_POST'			=> 'Bloquear mensaje',
	'LOCK_POST_POST_CONFIRM'	=> '¿Estás seguro de que quieres evitar que este mensaje se edite?',
	'LOCK_POST_POSTS'			=> 'Bloquear mensajes seleccionados',
	'LOCK_POST_POSTS_CONFIRM'	=> '¿Estás seguro de que quieres evitar que estos mensajes se editen?',
	'LOCK_TOPIC_CONFIRM'		=> '¿Estás seguro de que quieres bloquear este tema?',
	'LOCK_TOPICS'				=> 'Bloquear temas seleccionados',
	'LOCK_TOPICS_CONFIRM'		=> '¿Estás seguro de que quieres bloquear los temas seleccionados?',
	'LOGS_CURRENT_TOPIC'		=> 'Actualmente viendo registros de:',
	'LOGIN_EXPLAIN_MCP'			=> 'Para moderar este foro debes autenticarte.',
	'LOGVIEW_VIEWTOPIC'			=> 'Ver tema',
	'LOGVIEW_VIEWLOGS'			=> 'Ver registro del tema',
	'LOGVIEW_VIEWFORUM'			=> 'Ver foro',
	'LOOKUP_ALL'				=> 'Buscar todas las IPs',
	'LOOKUP_IP'					=> 'Buscar IP',

	'MARKED_NOTES_DELETED'		=> 'Notas marcadas borradas correctamente',

	'MCP_ADD'					=> 'Añadir una advertencia',

	'MCP_BAN'					=> 'Restringir el acceso',
	'MCP_BAN_EMAILS'			=> 'Excluir emails',
	'MCP_BAN_IPS'				=> 'Excluir IPs',
	'MCP_BAN_USERNAMES'			=> 'Excluir Usuario',

	'MCP_LOGS'					=> 'Registros del moderador',
	'MCP_LOGS_FRONT'			=> 'Página principal de registros',
	'MCP_LOGS_FORUM_VIEW'		=> 'Registros de Foros',
	'MCP_LOGS_TOPIC_VIEW'		=> 'Registros de Temas',

	'MCP_MAIN'							=> 'Principal',
	'MCP_MAIN_FORUM_VIEW'				=> 'Ver foro',
	'MCP_MAIN_FRONT'					=> 'Página principal',
	'MCP_MAIN_POST_DETAILS'				=> 'Detalles del mensaje',
	'MCP_MAIN_TOPIC_VIEW'				=> 'Ver tema',
	'MCP_MAKE_ANNOUNCEMENT'				=> 'Convertir en "Anuncio"',
	'MCP_MAKE_ANNOUNCEMENT_CONFIRM'		=> '¿Estás seguro de que quieres convertir este tema en un "Anuncio"?',
	'MCP_MAKE_ANNOUNCEMENTS'			=> 'Convertir en "Anuncios"',
	'MCP_MAKE_ANNOUNCEMENTS_CONFIRM'	=> '¿Estás seguro de que quieres convertir los temas seleccionados en "Anuncios"?',
	'MCP_MAKE_GLOBAL'					=> 'Convertir en "Anuncio global"',
	'MCP_MAKE_GLOBAL_CONFIRM'			=> '¿Estás seguro de que quieres convertir este tema en un "Anuncio global"?',
	'MCP_MAKE_GLOBALS'					=> 'Convertir en "Anuncios globales"',
	'MCP_MAKE_GLOBALS_CONFIRM'			=> '¿Estás seguro de que quieres convertir los temas seleccionados en "Anuncios globales?',
	'MCP_MAKE_STICKY'					=> 'Convertir en "Fijo"',
	'MCP_MAKE_STICKY_CONFIRM'			=> '¿Estás seguro de que quieres convertir este tema en "Fijo"?',
	'MCP_MAKE_STICKIES'					=> 'Convertir en "Fijos"',
	'MCP_MAKE_STICKIES_CONFIRM'			=> '¿Estás seguro de que quieres convertir los temas seleccionados en "Fijos"?',
	'MCP_MAKE_NORMAL'					=> 'Convertir en "Tema Normal"',
	'MCP_MAKE_NORMAL_CONFIRM'			=> '¿Estás seguro de que quieres convertir este tema en "Tema Normal"?',
	'MCP_MAKE_NORMALS'					=> 'Convertir en "Temas Normales"',
	'MCP_MAKE_NORMALS_CONFIRM'			=> '¿Estás seguro de que quieres convertir los temas seleccionados en "Temas Normales"?',

	'MCP_NOTES'			=> 'Notas',
	'MCP_NOTES_FRONT'	=> 'Página principal de notas',
	'MCP_NOTES_USER'	=> 'Detalles',

	'MCP_POST_REPORTS'	=> 'Informes hechos a este mensaje',

	'MCP_PM_REPORTS'				=> 'Mensajes privados (MP) informados',
	'MCP_PM_REPORT_DETAILS'			=> 'Detalles del Informe de MP',
	'MCP_PM_REPORTS_CLOSED'			=> 'Informes cerrados de MP',
	'MCP_PM_REPORTS_CLOSED_EXPLAIN'	=> 'Esta es una lista de todos los informes sobre mensajes privados que ya fueron resueltos.',
	'MCP_PM_REPORTS_OPEN'			=> 'Abrir informes de MP',
	'MCP_PM_REPORTS_OPEN_EXPLAIN'	=> 'Esta es una lista de todos los los mensajes privados informados que aún deben ser gestionados.',

	'MCP_REPORTS'					=> 'Mensajes informados',
	'MCP_REPORT_DETAILS'			=> 'Detalles del informe',
	'MCP_REPORTS_CLOSED'			=> 'Informes cerrados',
	'MCP_REPORTS_CLOSED_EXPLAIN'	=> 'Esta es una lista de los informes que han sido resueltos',
	'MCP_REPORTS_OPEN'				=> 'Informes abiertos',
	'MCP_REPORTS_OPEN_EXPLAIN'		=> 'Esta es una lista de los informes por resolver',

	'MCP_QUEUE'								=> 'Moderación pendiente',
	'MCP_QUEUE_APPROVE_DETAILS'				=> 'Detalles de aprobación',
	'MCP_QUEUE_UNAPPROVED_POSTS'			=> 'Mensajes esperando aprobación',
	'MCP_QUEUE_UNAPPROVED_POSTS_EXPLAIN'	=> 'Esta es una lista de los mensajes que requieren aprobación antes de que sean visibles a los usuarios',
	'MCP_QUEUE_UNAPPROVED_TOPICS'			=> 'Temas esperando aprobación',
	'MCP_QUEUE_UNAPPROVED_TOPICS_EXPLAIN'	=> 'Esta es una lista de los temas que requieren aprobación antes de que sean visibles a los usuarios',

	'MCP_VIEW_USER'							=> 'Ver advertencias de un usuario específico',

	'MCP_WARN'			=> 'Advertencias',
	'MCP_WARN_FRONT'	=> 'Página principal',
	'MCP_WARN_LIST'		=> 'Lista de advertencias',
	'MCP_WARN_POST'		=> 'Advertencias de un mensaje específico',
	'MCP_WARN_USER'		=> 'Advertir a usuario',

	'MERGE_POSTS_CONFIRM'	=> '¿Estás seguro de que deseas mover los mensajes seleccionados?',
	'MERGE_TOPIC_EXPLAIN'	=> 'Usando el siguiente formulario puedes mover los mensajes seleccionados a otro tema. Los mensajes se separarán de este tema y se unirán en el otro tema. Estos mensajes no serán reordenados y aparecerán como si los usuarios los hubiesen publicado en el nuevo tema.<br />Por favor ingresa el id del tema de destino o haz clic en el botón "Seleccionar" para buscar uno.',
	'MERGE_TOPIC_ID'		=> 'Número de identificación del tema de destino',
	'MERGE_TOPICS'			=> 'Unir temas',
	'MERGE_TOPICS_CONFIRM'	=> '¿Estás seguro de que quieres unir los temas seleccionados?',
	'MODERATE_FORUM'		=> 'Moderar foro',
	'MODERATE_TOPIC'		=> 'Moderar tema',
	'MODERATE_POST'			=> 'Moderar mensaje',
	'MOD_OPTIONS'			=> 'Opciones de moderador',
	'MORE_INFO'				=> 'Más información',
	'MOST_WARNINGS'			=> 'Usuarios con más advertencias',
	'MOVE_TOPIC_CONFIRM'	=> '¿Estás seguro de que quieres mover este tema a un nuevo foro?',
	'MOVE_TOPICS'			=> 'Mover temas seleccionados',
	'MOVE_TOPICS_CONFIRM'	=> '¿Estás seguro de que quieres mover los temas seleccionados a un nuevo foro?',

	'NOTIFY_POSTER_APPROVAL'		=> '¿Notificar aprobación al autor?',
	'NOTIFY_POSTER_DISAPPROVAL'		=> '¿Notificar rechazo al autor?',
	'NOTIFY_USER_WARN'				=> '¿Notificar advertencia al usuario?',
	'NOT_MODERATOR'					=> 'No eres moderador de este Foro',
	'NO_DESTINATION_FORUM'			=> 'Por favor selecciona un Foro de destino',
	'NO_DESTINATION_FORUM_FOUND'	=> 'No hay Foro de destino disponible.',
	'NO_ENTRIES'					=> 'No hay entradas de registro en este periodo',
	'NO_FEEDBACK'					=> 'No hay feedback de este usuario',
	'NO_FINAL_TOPIC_SELECTED'		=> 'No seleccionaste un tema de destino para mezclar los mensajes',
	'NO_MATCHES_FOUND'				=> 'No se encontraron coincidencias',
	'NO_POST'						=> 'Debes seleccionar un mensaje para advertir al usuario',
	'NO_POST_REPORT'				=> 'No se ha informado de este mensaje.',
	'NO_POST_SELECTED'				=> 'Debes seleccionar al menos un mensaje para efectuar esta acción',
	'NO_REASON_DISAPPROVAL'			=> 'Por favor proporciona una razón apropiada para rechazar',
	'NO_REPORT'						=> 'No se encontró informe',
	'NO_REPORTS'					=> 'No hay informes',
	'NO_REPORT_SELECTED'			=> 'Tienes que seleccionar al menos un informe para ejecutar esta acción.',
	'NO_TOPIC_ICON'					=> 'Ninguno',
	'NO_TOPIC_SELECTED'				=> 'Debes seleccionar al menos un tema para efectuar esta acción',
	'NO_TOPICS_QUEUE'				=> 'No hay temas.',

	'ONLY_TOPIC'					=> 'Solo tema "%s"',
	'OTHER_USERS'					=> 'Usuarios enviando mensajes desde esta IP',
	'PM_REPORT_CLOSED_SUCCESS'	=> 'El informe de MP seleccionado ha sido cerrado con éxito.',
	'PM_REPORT_DELETED_SUCCESS'	=> 'El informe de MP seleccionado ha sido eliminado con éxito.',
	'PM_REPORTED_SUCCESS'		=> 'Este mensaje privado ha sido informado con éxito.',
	'PM_REPORT_TOTAL'			=> 'En total hay <strong>1</strong> informe de MP para revisar.',
	'PM_REPORTS_CLOSED_SUCCESS'	=> 'Los informes de MP seleccionados han sido cerrados con éxito.',
	'PM_REPORTS_DELETED_SUCCESS'=> 'Los informes de MP seleccionados han sido eliminados con éxito.',
	'PM_REPORTS_TOTAL'			=> 'En total hay <strong>%d</strong> informes de MP para revisar.',
	'PM_REPORTS_ZERO_TOTAL'		=> 'No hay informes de MP para revisar.',
	'PM_REPORT_DETAILS'			=> 'Detalles del informe de Mensaje Privado',

	'POSTER'						=> 'Autor',
	'POSTS_APPROVED_SUCCESS'		=> 'Los mensajes seleccionados han sido aprobados',
	'POSTS_DELETED_SUCCESS'			=> 'Los mensajes seleccionados han sido eliminados de la base de datos correctamente',
	'POSTS_DISAPPROVED_SUCCESS'		=> 'Los mensajes seleccionados han sido rechazados',
	'POSTS_LOCKED_SUCCESS'			=> 'Los mensajes seleccionados han sido cerrados correctamente',
	'POSTS_MERGED_SUCCESS'			=> 'Los mensajes seleccionados han sido mezclados',
	'POSTS_UNLOCKED_SUCCESS'		=> 'Los mensajes seleccionados han sido reabiertos correctamente',
	'POSTS_PER_PAGE'				=> 'Mensajes por página',
	'POSTS_PER_PAGE_EXPLAIN'		=> '(Ponga 0 [cero] para ver todos los mensajes)',
	'POST_APPROVED_SUCCESS'			=> 'El mensaje seleccionado ha sido aprobado.',
	'POST_DELETED_SUCCESS'			=> 'El mensaje seleccionado ha sido eliminado correctamente de la base de datos.',
	'POST_DISAPPROVED_SUCCESS'		=> 'El mensaje seleccionado ha sido rechazado.',
	'POST_LOCKED_SUCCESS'			=> 'Mensaje cerrado correctamente.',
	'POST_NOT_EXIST'				=> 'Ese mensaje no existe',
	'POST_REPORTED_SUCCESS'			=> 'Se ha informado de este mensaje correctamente',
	'POST_UNLOCKED_SUCCESS'			=> 'Mensaje reabierto correctamente',

	'READ_USERNOTES'			=> 'Leer notas',
	'READ_WARNINGS'				=> 'Leer advertencias',
	'REPORTER'					=> 'Informante',
	'REPORTED'					=> 'Informado',
	'REPORTED_BY'				=> 'Informado por',
	'REPORTED_ON_DATE'			=> 'el',
	'REPORTS_CLOSED_SUCCESS'	=> 'Los informes seleccionados han sido cerrados correctamente.',
	'REPORTS_DELETED_SUCCESS'	=> 'Los informes seleccionados han sido borrados correctamente.',
	'REPORTS_TOTAL'				=> 'En total hay <strong>%d</strong> informes por revisar',
	'REPORTS_ZERO_TOTAL'		=> 'No hay informes por revisar',
	'REPORT_CLOSED'				=> 'Este informe ha sido cerrado previamente.',
	'REPORT_CLOSED_SUCCESS'		=> 'El informe seleccionado ha sido cerrado correctamente.',
	'REPORT_DELETED_SUCCESS'	=> 'El informe seleccionado ha sido borrado correctamente.',
	'REPORT_DETAILS'			=> 'Detalles del informe',
	'REPORT_MESSAGE'			=> 'Informar de este mensaje',
	'REPORT_MESSAGE_EXPLAIN'	=> 'Utiliza este formulario para informar sobre el mensaje privado seleccionado. En general debería informarse solo si el mensaje rompe las reglas del foro. <strong>Informar sobre un mensaje privado hará que su contenido sea visible a todos los moderadores.</strong>',
	'REPORT_NOTIFY'				=> 'Notificarme',
	'REPORT_NOTIFY_EXPLAIN'		=> 'Te informará cuando se lea tu informe',
	'REPORT_POST_EXPLAIN'		=> 'Utiliza este formulario para informar del mensaje seleccionado al moderador del foro y administradores del Sitio. En general debería informarse solo si el mensaje rompe las reglas del foro.',
	'REPORT_REASON'				=> 'Razón del informe',
	'REPORT_TIME'				=> 'Fecha del informe',
	'REPORT_TOTAL'				=> 'En total hay <strong>1</strong> informe para revisar',
	'RESYNC'					=> 'Sincronizar',
	'RETURN_MESSAGE'			=> '%sVolver al mensaje%s',
	'RETURN_NEW_FORUM'			=> '%sIr al nuevo foro%s',
	'RETURN_NEW_TOPIC'			=> '%sIr al nuevo tema%s',
	'RETURN_PM'					=> '%sVolver al mensaje privado%s',
	'RETURN_POST'				=> '%sVolver al nuevo mensaje%s',
	'RETURN_QUEUE'				=> '%sVolver a la lista%s',
	'RETURN_REPORTS'			=> '%sVolver a los informes%s',
	'RETURN_TOPIC_SIMPLE'		=> '%sVolver al tema%s',

	'SEARCH_POSTS_BY_USER'				=> 'Buscar mensajes por',
	'SELECT_ACTION'						=> 'Selecciona la acción deseada',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENT'	=> 'Por favor selecciona el foro en el que desea mostrar este anuncio global.',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENTS'	=> 'Uno o más de los temas seleccionados son anuncios globales. Por favor selecciona el foro en el que deseas mostrarlos.',
	'SELECT_MERGE'						=> 'Seleccionar para unir',
	'SELECT_TOPICS_FROM'				=> 'Seleccionar temas de',
	'SELECT_TOPIC'						=> 'Seleccionar tema',
	'SELECT_USER'						=> 'Seleccionar usuario',
	'SORT_ACTION'						=> 'Ordenar acción',
	'SORT_DATE'							=> 'Fecha',
	'SORT_IP'							=> 'Dirección IP',
	'SORT_WARNINGS'						=> 'Advertencias',
	'SPLIT_AFTER'						=> 'Dividir tema desde el mensaje seleccionado en adelante',
	'SPLIT_FORUM'						=> 'Foro para el nuevo tema',
	'SPLIT_POSTS'						=> 'Dividir mensajes seleccionados',
	'SPLIT_SUBJECT'						=> 'Título del nuevo tema',
	'SPLIT_TOPIC_ALL'					=> 'Dividir tema de los mensajes seleccionados',
	'SPLIT_TOPIC_ALL_CONFIRM'			=> '¿Estás seguro de que quieres dividir este tema?',
	'SPLIT_TOPIC_BEYOND'				=> 'Enviar tema al mensaje seleccionado',
	'SPLIT_TOPIC_BEYOND_CONFIRM'		=> '¿Estás seguro de que quieres enviar este tema al mensaje seleccionado?',
	'SPLIT_TOPIC_EXPLAIN'				=> 'Usando el formulario de debajo puedes dividir un tema en dos, bien seleccionando mensajes individuales o bien dividiendo el mensaje elegido',
	'THIS_PM_IP'				=> 'IP para este mensaje privado',

	'THIS_POST_IP'						=> 'IP de este mensaje',
	'TOPICS_APPROVED_SUCCESS'			=> 'Los temas seleccionados han sido aprobados',
	'TOPICS_DELETED_SUCCESS'			=> 'Los temas seleccionados han sido eliminados de la base de datos correctamente',
	'TOPICS_DISAPPROVED_SUCCESS'		=> 'Los temas seleccionados han sido rechazados',
	'TOPICS_FORKED_SUCCESS'				=> 'Los temas seleccionados han sido copiados correctamente',
	'TOPICS_LOCKED_SUCCESS'				=> 'Los temas seleccionados han sido cerrados',
	'TOPICS_MOVED_SUCCESS'				=> 'Los temas seleccionados han sido movidos correctamente',
	'TOPICS_RESYNC_SUCCESS'				=> 'Los temas seleccionados han sido resincronizados',
	'TOPICS_TYPE_CHANGED'				=> 'Tipo de temas cambiado correctamente.',
	'TOPICS_UNLOCKED_SUCCESS'			=> 'Los temas seleccionados han sido reabiertos',
	'TOPIC_APPROVED_SUCCESS'			=> 'El tema seleccionado ha sido aprobado',
	'TOPIC_DELETED_SUCCESS'				=> 'El tema seleccionado ha sido eliminado de la base de datos correctamente',
	'TOPIC_DISAPPROVED_SUCCESS'			=> 'El tema seleccionado ha sido rechazado',
	'TOPIC_FORKED_SUCCESS'				=> 'El tema seleccionado ha sido copiado correctamente',
	'TOPIC_LOCKED_SUCCESS'				=> 'El tema seleccionado ha sido cerrado',
	'TOPIC_MOVED_SUCCESS'				=> 'El tema seleccionado ha sido movido correctamente',
	'TOPIC_NOT_EXIST'					=> 'El tema seleccionado no existe',
	'TOPIC_RESYNC_SUCCESS'				=> 'El tema seleccionado ha sido resincronizado',
	'TOPIC_SPLIT_SUCCESS'				=> 'El tema seleccionado ha sido dividido correctamente',
	'TOPIC_TIME'						=> 'Fecha del tema',
	'TOPIC_TYPE_CHANGED'				=> 'Tipo de tema cambiado correctamente.',
	'TOPIC_UNLOCKED_SUCCESS'			=> 'El tema seleccionado ha sido reabierto',
	'TOTAL_WARNINGS'					=> 'Total de advertencias',

	'UNAPPROVED_POSTS_TOTAL'			=> 'En total hay <strong>%d</strong> mensajes esperando aprobación',
	'UNAPPROVED_POSTS_ZERO_TOTAL'		=> 'No hay mensajes esperando aprobación',
	'UNAPPROVED_POST_TOTAL'				=> 'En total hay <strong>1</strong> mensaje esperando aprobación',
	'UNLOCK'							=> 'Desbloquear',
	'UNLOCK_POST'						=> 'Desbloquear mensaje',
	'UNLOCK_POST_EXPLAIN'				=> 'Permitir edición',
	'UNLOCK_POST_POST'					=> 'Desbloquear mensaje',
	'UNLOCK_POST_POST_CONFIRM'			=> '¿Estás seguro de que quieres permitir la edición de este mensaje?',
	'UNLOCK_POST_POSTS'					=> 'Desbloquear mensajes',
	'UNLOCK_POST_POSTS_CONFIRM'			=> '¿Estás seguro de que quieres permitir la edición de estos mensajes?',
	'UNLOCK_TOPIC'						=> 'Desbloquear tema',
	'UNLOCK_TOPIC_CONFIRM'				=> '¿Estás seguro de que quieres desbloquear este tema?',
	'UNLOCK_TOPICS'						=> 'Desbloquear temas',
	'UNLOCK_TOPICS_CONFIRM'				=> '¿Está sequro que quiere desbloquear los temas seleccionados?',
	'USER_CANNOT_POST'					=> 'No puedes publicar en este foro',
	'USER_CANNOT_REPORT'				=> 'No puedes informar de mensajes en este foro',
	'USER_FEEDBACK_ADDED'				=> 'Feedback de usuario añadido correctamente.',
	'USER_WARNING_ADDED'				=> 'Usuario advertido correctamente.',

	'VIEW_DETAILS'				=> 'Ver detalles',
	'VIEW_PM'				=> 'Ver mensaje privado',
	'VIEW_POST'				=> 'Ver mensaje',

	'WARNED_USERS'				=> 'Usuarios advertidos',
	'WARNED_USERS_EXPLAIN'		=> 'Esta es una lista de usuarios con advertencias vigentes',
	'WARNING_PM_BODY'			=> 'La siguiente es una advertencia que te ha sido puesta por un/a administrador(a) o moderador(a) de este sitio.[quote]%s[/quote]',
	'WARNING_PM_SUBJECT'		=> 'Advertencia',
	'WARNING_POST_DEFAULT'		=> 'Esta es una advertencia al siguiente mensaje creado por ti: %s',
	'WARNINGS_ZERO_TOTAL'		=> 'No hay advertencias',

	'YOU_SELECTED_TOPIC'		=> 'Seleccionaste el tema número %d: %s',

	'report_reasons'	=> array(
		'TITLE'	=> array(
			'WAREZ'	=> 'Warez',
			'SPAM'	=> 'Spam',
			'OFF_TOPIC'	=> 'Off-topic',
			'OTHER'	=> 'Otros',
		),
		'DESCRIPTION'	=> array(
			'WAREZ'		=> 'El mensaje contiene enlaces a SoftWare ilegal o pirateado',
			'SPAM'		=> 'El mensaje reportado tiene el único propósito de publicitar un Sitio Web u otro producto',
			'OFF_TOPIC'	=> 'El mensaje reportado es off-topic',
			'OTHER'		=> 'El mensaje reportado no cuadra en ninguna categoría, por favor completa el campo Descripción',
		),
	),
));

?>