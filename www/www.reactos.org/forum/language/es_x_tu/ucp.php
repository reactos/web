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
* ucp.php [Spanish [Es]]
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

// Privacy policy and T&C
$lang = array_merge($lang, array(
	'TERMS_OF_USE_CONTENT'	=> 'Al ingresar en "%1$s" (de aquí en adelante "nosotros", "nos", "nuestro", "%1$s", "%2$s"), <strong>acuerda</strong> estar legalmente sometido a los siguientes términos. En caso contrario por favor no te registres y/o uses "%1$s". Podemos cambiar estos términos en cualquier momento e intentaríamos avisarte, sin embargo sería prudente que los revisases por su cuenta periódicamente. Seguir registrado a "%1$s" después de esos cambios significa que <strong>acuerdas</strong> estar legalmente sometido a esos nuevos términos tal como fueron actualizados y/o reformados.<br />
	<br />
	Nuestros foros están desarrollados por phpBB (de aquí en adelante "ellos", "sus", "software phpBB", "www.phpbb.com", "phpBB Group", "phpBB Teams") el cual es una solución de tablón de anuncios liberada bajo la "<a href="http://opensource.org/licenses/gpl-license.php">Licencia Pública General (General Public License en inglés)</a>" (de aquí en adelante "GPL") y puede ser descargada de <a href="https://www.phpbb.com/">www.phpbb.com</a>. El software phpBB solamente facilita discusiones basadas en Internet y la GPL estrictamente los excluye de lo que aprobamos y/o desaprobamos como conductas y/o contenido permisible. Para más información sobre phpBB, por favor visite: <a href="https://www.phpbb.com/">https://www.phpbb.com/</a>.<br />
	<br />
	<strong>Acuerdas</strong> no enviar ningun contenido abusivo, obsceno, vulgar, difamatorio, indecente, amenazante, sexual o cualquier otro material que pueda violar cualquier ley de tu país, el país donde "%1$s" está instalado o Leyes Internacionales. Hacer eso provocará que seas inmediata y permanentemente expulsado y, si lo creemos oportuno, con notificación a tu Proveedor de Servicios de Internet. Las direcciones IP de todos los envíos son registradas como ayuda para reforzar estas condiciones. <strong>Acuerdas</strong> que "%1$s" tiene derecho a eliminar, editar, mover o cerrar cualquier tema en cualquier momento que lo creamos conveniente. Como usuario <strong>acuerdas</strong> que cualquier información que hayas ingresado será almacenada en una base de datos. Dado que esta información no será compartida con ninguna tercera parte sin tu consentimiento, ni "%1$s" ni phpBB podrán considerarse responsables por cualquier intento de hacking que conlleve a que los datos sean comprometidos.
	',
	
	'PRIVACY_POLICY'	=> 'Esta política explica con detalle cómo "%1$s" junto con sus empresas asociadas (de aquí en adelante "nosotros", "nos", "nuestro", "%1$s", "%2$s") y phpBB (de aquí en adelante "ellos", "sus", "software phpBB", "www.phpbb.com", "phpBB Group", "phpBB Teams") emplean cualquier información obtenida durante cualquier sesión de uso por ti (de aquí en adelante "su información").<br />
	<br />
	Tu información es obtenida por dos vías. Primeramente, navegar por "%1$s" hará al software phpBB crear un número de cookies, las cuales son un pequeño archivo de texto que se descargan en los archivos temporales del navegador de tu PC. Las primeras dos cookies sólo contienen un identificador de usuario (de aquí en adelante "user-id") y un identificador de sesión anónima (de aquí en adelante "session-id"), automáticamente asignada a ti por el software phpBB. Una tercera cookie se creará una vez que haya navegado por temas en "%1$s" y se emplea para registrar cuales han sido leídos, con objeto de optimizar tu experiencia de usuario.<br />
	<br />
	Además podemos crear cookies externas al software phpBB mientras navega por "%1$s", las cuales exceden el alcance de este documento que solamente se refiere a las páginas creadas por el software phpBB. La segunda vía mediante la que obtenemos tu información es mediante lo que tu envías. Esto puede ser, y no limitado a: envíos como usuario anónimo (de aquí en adelante "envíos anónimos"), su registro en "%1$s" (de aquí en adelante "tu cuenta") y mensajes enviados por ti después de registrarte y mientras te hayas identificado (de aquí en adelante "tus mensajes").<br />
	<br />
	Tu cuenta como mínimo constará de un nombre único de identificación (de aquí en adelante "Tu nombre de usuario"), una contraseña personal empleada para la identificación (de aquí en adelante "tu contraseña") y una dirección de email personal válida (de aquí en adelante "tu email"). La información de tu cuenta en "%1$s" está protegida por las leyes de protección de datos aplicables en el país en el que estamos instalados. Cualquier información más allá de tu nombre de usuario, tu contraseña y tu dirección de e-mail requerida por "%1$s" durante el proceso de registro será obligatoria u opcional, según el criterio de “%1$s”. En cualquier caso, tienes la opción de qué información en su cuenta será públicamente exhibida. Además, en tu cuenta, tienes la opción de activar o desactivar los emails generados automáticamente por el software phpBB.<br />
	<br />
	Tu contraseña está encriptada (cifrado de una vía) por lo tanto está segura. Sin embargo, se recomienda que no emplees la misma contraseña en diferentes websites. Tu contraseña garantiza el acceso a tu cuenta en "%1$s", por favor guárdala cuidadosamente y bajo ninguna circunstancia ningún miembro "%1$s", phpBB u otra tercera parte, legítimamente te preguntará tu contraseña. Si olvidaste la contraseña de tu cuenta, puedes usar el servicio "Olvidé mi contraseña" provisto por el software phpBB. Este proceso te solicitará ingresar tu nombre de usuario y tu email, luego el software phpBB generará una nueva contraseña para recuperar tu cuenta.<br />
	',
));

// Common language entries
$lang = array_merge($lang, array(
	'ACCOUNT_ACTIVE'				=> 'Tu cuenta ha sido activada. Gracias por registrarte',
	'ACCOUNT_ACTIVE_ADMIN'			=> 'La cuenta ha sido activada',
	'ACCOUNT_ACTIVE_PROFILE'		=> 'Tu cuenta ha sido ahora reactivada correctamente.',
	'ACCOUNT_ADDED'					=> 'Gracias por registrarte, tu cuenta ha sido creada. Ahora puedes identificarse con tu nombre de usuario y tu contraseña',
	'ACCOUNT_COPPA'					=> 'Tu cuenta ha sido creada pero no aprobada, por favor revisa tu email para más detalles.',
	'ACCOUNT_EMAIL_CHANGED'			=> 'Tu cuenta ha sido actualizada. Sin embargo este foro requiere reactivación de cuenta por e-mail. Una clave de activación ha sido enviada a la nueva dirección de e-mail que has proporcionado. Por favor, comprueba tu e-mail para más información.',
	'ACCOUNT_EMAIL_CHANGED_ADMIN'	=> 'Tu cuenta ha sido actualizada. Sin embargo este foro requiere reactivación de cuenta por los administradores via e-mail. Un e-mail se ha enviado a ellos y se te informará cuándo será reactivada tu cuenta.',
	'ACCOUNT_INACTIVE'				=> 'Tu cuenta ha sido creada. Sin embargo, este foro requiere activación de cuenta, una contraseña de activación ha sido enviada a la dirección de email que introduciste. Por favor revisa tu email para más información',
	'ACCOUNT_INACTIVE_ADMIN'		=> 'Tu cuenta ha sido creada. Sin embargo, este foro requiere activación de cuenta por el administrador. Un email te ha sido enviado y se te informará cuando haya sido activada tu cuenta',
	'ACTIVATION_EMAIL_SENT'			=> 'El email de activación ha sido enviado a tu dirección de email',
	'ACTIVATION_EMAIL_SENT_ADMIN'	=> 'El email de activación ha sido enviado a las direcciones de correo de los administradores.',
	'ADD'							=> 'Añadir',
	'ADD_BCC'						=> 'Añadir [CCO]',
	'ADD_FOES'						=> 'Añadir nuevos ignorados',
	'ADD_FOES_EXPLAIN'				=> 'Puedes introducir varios nombres de usuario cada uno en una nueva línea',
	'ADD_FOLDER'					=> 'Añadir directorio',
	'ADD_FRIENDS'					=> 'Añadir nuevos amigos',
	'ADD_FRIENDS_EXPLAIN'			=> 'Puedes introducir varios nombres de usuario cada uno en una nueva línea',
	'ADD_NEW_RULE'					=> 'Añadir nueva regla',
	'ADD_RULE'						=> 'Añadir regla',
	'ADD_TO'						=> 'Añadir [Para]',
	'ADD_USERS_UCP_EXPLAIN'			=> 'Aquí puedes añadir nuevos usuarios al grupo. Puedes seleccionar si este grupo se convertirá en el nuevo grupo por defecto para los usuarios seleccionados. Por favor introduce cada nombre de usuario en una línea distinta.',
	'ADMIN_EMAIL'					=> 'Administradores pueden informarme por email',
	'AGREE'							=> 'Estoy de acuerdo con las reglas',
	'ALLOW_PM'						=> 'Permitir a los usuarios enviarte mensajes privados',
	'ALLOW_PM_EXPLAIN'				=> 'Ten en cuenta que administradores y moderadores siempre podrán enviarte mensajes.',
	'ALREADY_ACTIVATED'				=> 'Ya habías activado tu cuenta',
	'ATTACHMENTS_EXPLAIN'			=> 'Esta es un lista de adjuntos que has publicado en este foro.',
	'ATTACHMENTS_DELETED'			=> 'Adjuntos borrados correctamente.',
	'ATTACHMENT_DELETED'			=> 'Adjunto borrado correctamente.',
	'AVATAR_CATEGORY'				=> 'Categoría',
	'AVATAR_EXPLAIN'				=> 'Dimensiones máximas; ancho %1$d pixels, alto %2$d pixels, tamaño %3$.2f KiB.',
	'AVATAR_FEATURES_DISABLED'		=> 'La funcionalidad de avatar está actualmente desactivada.',
	'AVATAR_GALLERY'				=> 'Galería local',
	'AVATAR_GENERAL_UPLOAD_ERROR'	=> 'No se puede subir avatar a %s',
	'AVATAR_NOT_ALLOWED'			=> 'Tu avatar no puede ser mostrado porque los avatares han sido deshabilitados.',
	'AVATAR_PAGE'					=> 'Página',
	'AVATAR_TYPE_NOT_ALLOWED'		=> 'Tu avatar no puede ser mostrado porque el tipo de archivo ha sido deshabilitado.',

	'BACK_TO_DRAFTS'				=> 'Volver a borradores guardados',
	'BACK_TO_LOGIN'					=> 'Volver a identificarse',
	'BIRTHDAY'						=> 'Cumpleaños',
	'BIRTHDAY_EXPLAIN'				=> 'Introducir el año mostrará tu edad cuando sea tu cumpleaños.',
	'BOARD_DATE_FORMAT'				=> 'Mi formato de fecha',
	'BOARD_DATE_FORMAT_EXPLAIN'		=> 'La sintaxis usada es idéntica a la función <a href="http://www.php.net/date">date()</a> en PHP',
	'BOARD_DST'						=> 'Horario de Ahorro de Energía en uso',
	'BOARD_LANGUAGE'				=> 'Mi idioma',
	'BOARD_STYLE'					=> 'Mi estilo',
	'BOARD_TIMEZONE'				=> 'Mi zona horaria',
	'BOOKMARKS'						=> 'Favoritos',
	'BOOKMARKS_EXPLAIN'				=> 'Puedes añadir temas a Favoritos para futuras consultas. Selecciona el checkbox para el Favorito que quieras borrar, luego haz clic en el botón <em>Eliminar Favoritos marcados</em>.',
	'BOOKMARKS_DISABLED'			=> 'Añadir a Favoritos está deshabilitado en este Sitio',
	'BOOKMARKS_REMOVED'				=> 'Favoritos eliminados correctamente',

	'CANNOT_EDIT_MESSAGE_TIME'		=> 'Ya no puedes editar o borrar este mensaje',
	'CANNOT_MOVE_TO_SAME_FOLDER'	=> 'Los mensajes no pueden ser movidos al directorio que quieres borrar.',
	'CANNOT_MOVE_FROM_SPECIAL'		=> 'Los mensajes no pueden ser movidos desde la bandeja de salida.',
	'CANNOT_RENAME_FOLDER'			=> 'Este directorio no puede ser renombrado.',
	'CANNOT_REMOVE_FOLDER'			=> 'Este directorio no puede ser eliminado.',
	'CHANGE_DEFAULT_GROUP'			=> 'Cambiar grupo por defecto',
	'CHANGE_PASSWORD'				=> 'Cambiar contraseña',
	'CLICK_GOTO_FOLDER'			=> '%1$sIr a la carpeta “%3$s” %2$s',
	'CLICK_RETURN_FOLDER'			=> '%1$sVolver a tu  directorio de "%3$s" %2$s',
	'CONFIRMATION'					=> 'Confirmación de registro',
	'CONFIRM_CHANGES'				=> 'Confirmar cambios',
	'CONFIRM_EMAIL'					=> 'Confirmar dirección de email',
	'CONFIRM_EMAIL_EXPLAIN'			=> 'Necesitas especificar esto sólo si vas a cambiar su dirección de email.',
	'CONFIRM_EXPLAIN'				=> 'Para prevenir registros automáticos el administrador del Sitio requiere que introduzcas un código de confirmación. El código se muestra en la imagen que deberías ver debajo. Si estás visualmente impedido o no puedes ver el código, por favor contacte con el %sAdministrador del Sitio%s.',
    'VC_REFRESH'            => 'Refrescar código de confirmación',
    'VC_REFRESH_EXPLAIN'      => 'Si no puedes leer el código puedes pedir uno nuevo haciendo clic en el botón.',
	'CONFIRM_PASSWORD'				=> 'Confirmar contraseña',
	'CONFIRM_PASSWORD_EXPLAIN'		=> 'Necesitas confirmar tu contraseña sólo si la has cambiado arriba',
	'COPPA_BIRTHDAY'				=> 'Para continuar con el proceso de registro, por favor indica cuándo naciste.',
	'COPPA_COMPLIANCE'				=> 'APPCO (COPPA en inglés) compliance',
	'COPPA_EXPLAIN'					=> 'Por favor observe que al hacer clic en Enviar crearás tu cuenta. Sin embargo no podrá ser activada hasta que tu padre, madre o tutor(a) apruebe tu registro. Se te enviará una copia por email del formulario necesario con detalles de cómo enviarlo.',
	'CREATE_FOLDER'					=> 'Añadir directorio…',
	'CURRENT_IMAGE'					=> 'Imagen actual',
	'CURRENT_PASSWORD'				=> 'Contraseña actual',
	'CURRENT_PASSWORD_EXPLAIN'		=> 'Tienes que confirmar tu contraseña actual si quieres editar tu dirección de email o nombre de usuario.',
	'CURRENT_CHANGE_PASSWORD_EXPLAIN' => 'Para cambiar tu contraseña, tu dirección de correo electrónico o tu nombre de usuario, debes introducir tu contraseña actual.',
	'CUR_PASSWORD_EMPTY'	    	=> 'No has ingresado tu contraseña actual.',
	'CUR_PASSWORD_ERROR'			=> 'La contraseña actual que introdujiste es incorrecta.',
	'CUSTOM_DATEFORMAT'				=> 'Personalizar…',

	'DEFAULT_ACTION'				=> 'Acción por defecto',
	'DEFAULT_ACTION_EXPLAIN'		=> 'Esta acción se activará si ninguna de las anteriores es aplicable',
	'DEFAULT_ADD_SIG'				=> 'Insertar mi firma por defecto',
	'DEFAULT_BBCODE'				=> 'Habilitar BBCode por defecto',
	'DEFAULT_NOTIFY'				=> 'Notificarme respuestas por defecto',
	'DEFAULT_SMILIES'				=> 'Habilitar emoticonos por defecto',
	'DEFINED_RULES'					=> 'Reglas definidas',
	'DELETED_TOPIC'					=> 'El tema ha sido eliminado',
	'DELETE_ATTACHMENT'				=> 'Borrar adjunto',
	'DELETE_ATTACHMENTS'			=> 'Borrar adjuntos',
	'DELETE_ATTACHMENT_CONFIRM'		=> '¿Estás seguro de que quieres borrar este adjunto?',
	'DELETE_ATTACHMENTS_CONFIRM'	=> '¿Estás seguro de que quieres borrar estos adjuntos?',
	'DELETE_AVATAR'					=> 'Borrar imagen',
	'DELETE_COOKIES_CONFIRM'		=> '¿Estás seguro de que quieres borrar todas las cookies de este Sitio?',
	'DELETE_MARKED_PM'				=> 'Borrar mensajes marcados',
	'DELETE_MARKED_PM_CONFIRM'		=> '¿Estás seguro de que quieres borrar todos los mensajes marcados?',
	'DELETE_OLDEST_MESSAGES'		=> 'Borrar mensajes antiguos',
	'DELETE_MESSAGE'				=> 'Borrar mensaje',
	'DELETE_MESSAGE_CONFIRM'		=> '¿Estás seguro de que quieres borrar este mensaje privado?',
	'DELETE_MESSAGES_IN_FOLDER'		=> 'Borrar todos los mensajes en el directorio eliminado',
	'DELETE_RULE'					=> 'Borrar regla',
	'DELETE_RULE_CONFIRM'			=> '¿Estás seguro de que quieres borrar esta regla?',
	'DEMOTE_SELECTED'				=> 'Degradar Seleccionado',
	'DISABLE_CENSORS'				=> 'Habilitar palabras censuradas',
	'DISPLAY_GALLERY'				=> 'Mostrar galería',
	'DOMAIN_NO_MX_RECORD_EMAIL'		=> 'El dominio del email ingresado no tiene un registro MX válido.',
	'DOWNLOADS'						=> 'Descargas',
	'DRAFTS_DELETED'				=> 'Todos los borradores seleccionados fueron borrados correctamente.',
	'DRAFTS_EXPLAIN'				=> 'Aquí puedes ver, editar o borrar sus borradores guardados.',
	'DRAFT_UPDATED'					=> 'Borrador actualizado correctamente.',

	'EDIT_DRAFT_EXPLAIN'			=> 'Aquí podrás editar su borrador. Los borradores no contienen adjuntos ni encuestas.',
	'EMAIL_BANNED_EMAIL'			=> 'La dirección de email que introdujiste está excluida.',
	'EMAIL_REMIND'					=> 'Esta debe ser la dirección de email que introdujiste al registrarse.',
	'EMAIL_TAKEN_EMAIL'				=> 'La dirección de email introducida ya está en uso',
	'EMPTY_DRAFT'					=> 'Debes introducir un mensaje para enviar los cambios',
	'EMPTY_DRAFT_TITLE'				=> 'Debes introducir un título para el borrador',
	'EXPORT_AS_XML'					=> 'Exportar como XML',
	'EXPORT_AS_CSV'					=> 'Exportar como CSV',
	'EXPORT_AS_CSV_EXCEL'			=> 'Exportar como CSV (Excel)',
	'EXPORT_AS_TXT'					=> 'Exportar como TXT',
	'EXPORT_AS_MSG'					=> 'Exportar como MSG',
	'EXPORT_FOLDER'					=> 'Exportar directorio',

	'FIELD_REQUIRED'				=> 'Debes completar el campo "%s".',
	'FIELD_TOO_SHORT'				=> 'El campo "%1$s" es muy corto, se requiere un mínimo de %2$d caracteres.',
	'FIELD_TOO_LONG'				=> 'El campo "%1$s" es muy largo, se permite un máximo de %2$d caracteres.',
	'FIELD_TOO_SMALL'				=> 'El valor de "%1$s" es muy pequeño, se requiere un valor mínimo de %2$d.',
	'FIELD_TOO_LARGE'				=> 'El valor de "%1$s" es muy grande, se permite un valor máximo de %2$d.',
	'FIELD_INVALID_CHARS_NUMBERS_ONLY'	=> 'El campo "%s" tiene caracteres inválidos, se permiten sólo números.',
	'FIELD_INVALID_CHARS_ALPHA_ONLY'	=> 'El campo "%s" tiene caracteres inválidos, se permiten sólo caracteres alfanuméricos.',
	'FIELD_INVALID_CHARS_SPACERS_ONLY'	=> 'El campo "%s" tiene caracteres inválidos, se permiten sólo caracteres alfanuméricos, espacio ó -+_[].',
	'FIELD_INVALID_DATE'			=> 'El campo "%s" tiene una fecha no válida.',
	'FIELD_INVALID_VALUE'				=> 'El campo “%s” tiene un valor no válido.',

	'FOE_MESSAGE'					=> 'Mensaje de un Ignorado',
	'FOES_EXPLAIN'					=> 'Ignorados son usuarios que serán ignorados por defecto. Los mensajes de esos usuarios no serán visibles en su totalidad y no se permitirán mensajes personales. Por favor observa que no puedes ignorar moderadores o administradores.',
	'FOES_UPDATED'					=> 'Tu lista de Ignorados ha sido actualizada correctamente',
	'FOLDER_ADDED'					=> 'Directorio añadido correctamente',
	'FOLDER_MESSAGE_STATUS'			=> '%1$d de %2$d mensajes guardados',
	'FOLDER_NAME_EMPTY'			=> 'Debes introducir un nombre para este directorio.',
	'FOLDER_NAME_EXIST'				=> 'El directorio <strong>%s</strong> ya existe',
	'FOLDER_OPTIONS'				=> 'Opciones de directorio',
	'FOLDER_RENAMED'				=> 'Directorio renombrado correctamente',
	'FOLDER_REMOVED'				=> 'Directorio eliminado correctamente',
	'FOLDER_STATUS_MSG'				=> 'El directorio está %1$d%% lleno, con (%2$d de %3$d mensajes guardados)',
	'FORWARD_PM'					=> 'Reenviar MP',
	'FORCE_PASSWORD_EXPLAIN'		=> 'Antes de continuar navegando por el Sitio se requiere que cambies tu contraseña',
	'FRIEND_MESSAGE'				=> 'Mensaje de un amigo',
	'FRIENDS'						=> 'Amigos',
	'FRIENDS_EXPLAIN'				=> 'Amigos te permite un acceso rápido a usuarios con los que te comunicas frecuentemente. Si la plantilla lo soporta, los mensajes hechos por amigos serán resaltados.',
	'FRIENDS_OFFLINE'				=> 'Desconectados',
	'FRIENDS_ONLINE'				=> 'Conectados',
	'FRIENDS_UPDATED'				=> 'Tu lista de amigos ha sido actualizada correctamente',
	'FULL_FOLDER_OPTION_CHANGED'	=> 'La acción a tomar cuando un directorio lleno ha sido cambiada correctamente',
	'FWD_ORIGINAL_MESSAGE'			=> '-------- Mensaje Original --------',
	'FWD_SUBJECT'					=> 'Asunto: %s',
	'FWD_DATE'						=> 'Fecha: %s',
	'FWD_FROM'						=> 'De: %s',
	'FWD_TO'						=> 'Para: %s',

	'GLOBAL_ANNOUNCEMENT'			=> 'Anuncio global',

	'HIDE_ONLINE'					=> 'Ocultar mi estado de conexión',
	'HIDE_ONLINE_EXPLAIN'			=> 'Cambiar esta preferencia no será efectiva hasta tu próxima visita al foro.',
	'HOLD_NEW_MESSAGES'				=> 'No aceptar nuevos mensajes (Los mensajes nuevos aguardarán hasta que haya suficiente espacio disponible)',
	'HOLD_NEW_MESSAGES_SHORT'		=> 'Los mensajes nuevos deberán esperar',

	'IF_FOLDER_FULL'				=> 'Si el directorio está lleno',
	'IMPORTANT_NEWS'				=> 'Anuncios importantes',
	'INVALID_USER_BIRTHDAY'			=> 'La fecha de nacimiento insertada no es válida.',
	'INVALID_CHARS_USERNAME'		=> 'El nombre de usuario contiene caracteres prohibidos.',
	'INVALID_CHARS_NEW_PASSWORD'	=> 'La contraseña no contiene los caracteres requeridos.',
	'ITEMS_REQUIRED'				=> 'Los elementos marcados con * son campos requeridos del perfil y deben ser completados',

	'JOIN_SELECTED'					=> 'Introducir seleccionados',

	'LANGUAGE'						=> 'Idioma',
	'LINK_REMOTE_AVATAR'			=> 'Enlace externo',
	'LINK_REMOTE_AVATAR_EXPLAIN'	=> 'Introduce la URL del sitio que contiene la imagen del avatar que deseas enlazar.',
	'LINK_REMOTE_SIZE'				=> 'Dimensiones de avatar',
	'LINK_REMOTE_SIZE_EXPLAIN'		=> 'Especifica el ancho y alto del avatar, déjalo en blanco para intentar una verificación automática.',
	'LOGIN_EXPLAIN_UCP'				=> 'Por favor identifícate para acceder al Panel de Control de Usuario',
	'LOGIN_REDIRECT'				=> 'Te has identificado correctamente.',
	'LOGOUT_FAILED'					=> 'No has sido desconectado, la petición no coincide con tu sesión. Por favor contacta con el administrador del foro si continúas experimentando problemas.',
	'LOGOUT_REDIRECT'				=> 'Te has desconectado correctamente.',

	'MARK_IMPORTANT'				=> 'Marcar como importante',
	'MARKED_MESSAGE'				=> 'Mensaje marcado',
	'MAX_FOLDER_REACHED'			=> 'Alcanzado el número máximo permitido de directorios definidos por el usuario',
	'MESSAGE_BY_AUTHOR'				=> 'por',
	'MESSAGE_COLOURS'				=> 'Colores de mensaje',
	'MESSAGE_DELETED'				=> 'Mensaje borrado correctamente',
	'MESSAGE_EDITED'				=> 'Mensaje editado correctamente.',
	'MESSAGE_HISTORY'				=> 'Historial de mensajes',
	'MESSAGE_REMOVED_FROM_OUTBOX'	=> 'Este mensaje ha sido borrado por el autor.',
	'MESSAGE_SENT_ON'				=> 'en',
	'MESSAGE_STORED'				=> 'Este mensaje ha sido enviado correctamente',
	'MESSAGE_TO'					=> 'Para',
	'MESSAGES_DELETED'				=> 'Mensajes borrados correctamente',
	'MOVE_DELETED_MESSAGES_TO'		=> 'Mover mensajes del directorio eliminado a',
	'MOVE_DOWN'						=> 'Bajar',
	'MOVE_MARKED_TO_FOLDER'			=> 'Mover marcados a %s',
	'MOVE_PM_ERROR'					=> 'Ha ocurrido un error mientras movías los mensajes al nuevo directorio, sólo %1d de %2d mensajes fueron movidos.',
	'MOVE_TO_FOLDER'				=> 'Mover a directorio',
	'MOVE_UP'						=> 'Subir',
	'NEW_EMAIL_CONFIRM_EMPTY'		=> 'No has introducido la confirmación de dirección de correo.',

	'NEW_EMAIL_ERROR'				=> 'La dirección de email que introdujiste no coincide.',
	'NEW_FOLDER_NAME'				=> 'Nuevo nombre',
	'NEW_PASSWORD'					=> 'Nueva contraseña',
	'NEW_PASSWORD_CONFIRM_EMPTY'	=> 'No has ingresado la confirmación de contraseña.',    
	'NEW_PASSWORD_ERROR'			=> 'Las contraseñas introducidas no coinciden.',
	'NOTIFY_METHOD'					=> 'Método de notificación',
	'NOTIFY_METHOD_BOTH'			=> 'Ambos',
	'NOTIFY_METHOD_EMAIL'			=> 'Sólo email',
	'NOTIFY_METHOD_EXPLAIN'			=> 'Método para enviar mensajes empleado por este Sitio.',
	'NOTIFY_METHOD_IM'				=> 'Sólo Jabber',
	'NOTIFY_ON_PM'					=> 'Notificarme de nuevos mensajes privados',
	'NOT_ADDED_FRIENDS_ANONYMOUS'	=> 'No puedes añadir usuarios anónimos a tu lista de amigos.',
	'NOT_ADDED_FRIENDS_BOTS'		=> 'No puedes añadir bots a tu lista de amigos.',
	'NOT_ADDED_FRIENDS_FOES'		=> 'No puedes añadir usuarios a tu lista de amigos mientras estén en su lista de ignorados',
	'NOT_ADDED_FRIENDS_SELF'		=> 'No puedes añadir a tu lista de amigos',
	'NOT_ADDED_FOES_MOD_ADMIN'		=> 'No puedes añadir administradores y moderadores a tu lista de ignorados.',
	'NOT_ADDED_FOES_ANONYMOUS'		=> 'No puedes añadir usuarios anónimos a tu lista de ignorados.',
	'NOT_ADDED_FOES_BOTS'			=> 'No puedes añadir bots a tu lista de ignorados.',
	'NOT_ADDED_FOES_FRIENDS'		=> 'No puedes añadir usuarios a tu lista de ignorados mientras estén en tu lista de amigos.',
	'NOT_ADDED_FOES_SELF'			=> 'No puedes añadirte a tu lista de ignorados.',
	'NOT_AGREE'						=> 'No estoy de acuerdo',
	'NOT_ENOUGH_SPACE_FOLDER'		=> 'El directorio de destino "%s" parece estar lleno. La acción requerida no se ha realizado.',
	'NOT_MOVED_MESSAGE'				=> 'Tienes 1 mensaje privado actualmente en espera porque tu directorio está lleno.',
	'NOT_MOVED_MESSAGES'			=> 'Tienes %d mensajes privados actualmente en espera porque tu directorio está lleno.',
	'NO_ACTION_MODE'				=> 'No se especificó una acción.',
	'NO_AUTHOR'						=> 'No se definió un autor para este mensaje',
	'NO_AVATAR_CATEGORY'			=> 'Ninguno',

	'NO_AUTH_DELETE_MESSAGE'		=> 'No estás autorizado a borrar mensajes privados.',
	'NO_AUTH_EDIT_MESSAGE'			=> 'No estás autorizado a editar mensajes privados.',
	'NO_AUTH_FORWARD_MESSAGE'		=> 'No estás autorizado a reenviar mensajes privados.',
	'NO_AUTH_GROUP_MESSAGE'			=> 'No estás autorizado a enviar mensajes privados a grupos.',
	'NO_AUTH_PASSWORD_REMINDER'		=> 'No estás autorizado a pedir una nueva contraseña.',
	'NO_AUTH_READ_HOLD_MESSAGE'		=> 'No estás autorizado a leer mensajes privados que estén en espera.',
	'NO_AUTH_READ_MESSAGE'			=> 'No estás autorizado a leer mensajes privados.',
	'NO_AUTH_READ_REMOVED_MESSAGE'	=> 'No puedes leer este mensaje porque fue eliminado por el autor.',
	'NO_AUTH_SEND_MESSAGE'			=> 'No estás autorizado a enviar mensajes privados.',
	'NO_AUTH_SIGNATURE'				=> 'No estás autorizado a definir una firma',

	'NO_BCC_RECIPIENT'			=> 'Ninguno',
	'NO_BOOKMARKS'				=> 'No tienes Favoritos',
	'NO_BOOKMARKS_SELECTED'		=> 'No has seleccionado ningún Favorito',
	'NO_EDIT_READ_MESSAGE'		=> 'El mensaje privado no puede ser editado porque ya ha sido leído.',
	'NO_EMAIL_USER'				=> 'No se puede encontrar al email/usuario enviado',
	'NO_FOES'					=> 'No hay ignorados definidos actualmente',
	'NO_FRIENDS'				=> 'No hay amigos definidos actualmente',
	'NO_FRIENDS_OFFLINE'		=> 'No hay amigos desconectados',
	'NO_FRIENDS_ONLINE'			=> 'No hay amigos identificados',
	'NO_GROUP_SELECTED'			=> 'No se ha especificado un grupo',
	'NO_IMPORTANT_NEWS'			=> 'No hay anuncios importantes',
	'NO_MESSAGE'				=> 'No se puede encontrar un mensaje privado',
	'NO_NEW_FOLDER_NAME'		=> 'Debes especificar un nombre para el directorio',
	'NO_NEWER_PM'				=> 'No hay mensajes nuevos',
	'NO_OLDER_PM'				=> 'No hay mensajes viejos',
	'NO_PASSWORD_SUPPLIED'		=> 'No puedes conectarte sin una contraseña.',
	'NO_RECIPIENT'				=> 'No se definió un destinatario',
	'NO_RULES_DEFINED'			=> 'No se definieron reglas',
	'NO_SAVED_DRAFTS'			=> 'No se guardaron borradores',
	'NO_TO_RECIPIENT'			=> 'Ninguno',
	'NO_WATCHED_FORUMS'			=> 'No estás observando ningun Foro.',
	'NO_WATCHED_SELECTED'		=> 'No has seleccionado ningún tema o foro suscrito.',
	'NO_WATCHED_TOPICS'			=> 'No estás observando ningun tema.',

	'PASS_TYPE_ALPHA_EXPLAIN'	=> 'Las contraseñas deben tener entre %1$d y %2$d caracteres de longitud y deben ser alfanuméricos',
	'PASS_TYPE_ANY_EXPLAIN'		=> 'Debe tener entre %1$d y %2$d caracteres.',
	'PASS_TYPE_CASE_EXPLAIN'	=> 'Las contraseñas deben tener entre %1$d y %2$d caracteres de longitud y mezclar mayúsculas y minúsculas',
	'PASS_TYPE_SYMBOL_EXPLAIN'	=> 'Las contraseñas deben tener entre %1$d y %2$d caracteres de longitud y deben contener símbolos',
	'PASSWORD'					=> 'Contraseña',
	'PASSWORD_ACTIVATED'	=> 'Tu nueva contraseña ha sido activada',
	'PASSWORD_UPDATED'		=> 'Una nueva contraseña fue enviada a tu dirección de correo registrada.',
	'PERMISSIONS_RESTORED'	=> 'Permisos originales restaurados correctamente.',
	'PERMISSIONS_TRANSFERRED'=> 'Permisos de <strong>%s</strong> transferidos correctamente, ahora puedes navegar por el foro con los permisos de ese usuario.<br />Por favor ten en cuenta que los permisos administrativos no han sido transferidos. Puedes volver a tus permisos anteriores en cualquier momento.',
	'PM_DISABLED'			=> 'Los mensajes privados han sido deshabilitados en este Sitio',
	'PM_FROM'				=> 'De',
	'PM_FROM_REMOVED_AUTHOR'=> 'Este mensaje fue enviado por un usuario que ya no está registrado.',
	'PM_ICON'				=> 'Icono',
	'PM_INBOX'				=> 'Bandeja de entrada',
	'PM_NO_USERS'			=> 'Los usuarios solicitados para ser añadidos no existen.',
	'PM_OUTBOX'				=> 'Bandeja de salida',
	'PM_SENTBOX'			=> 'Mensajes enviados',
	'PM_SUBJECT'			=> 'Tema del mensaje',
	'PM_TO'					=> 'Enviado a',
	'PM_USERS_REMOVED_NO_PM'=> 'Algunos usuarios no se pueden añadir porque tienen desabilitada la bandeja de mensajes privados.',
	'POPUP_ON_PM'			=> 'Ver nuevos mensajes privados en una ventana emergente',
	'POST_EDIT_PM'			=> 'Editar mensaje privado',
	'POST_FORWARD_PM'		=> 'Reenviar mensaje privado',
	'POST_NEW_PM'			=> 'Enviar mensaje privado',
	'POST_PM_LOCKED'		=> 'El envío de MPs está cerrado.',
	'POST_PM_POST'			=> 'Citar mensaje privado',
	'POST_QUOTE_PM'			=> 'Citar mensaje privado',
	'POST_REPLY_PM'			=> 'Responder mensaje',
	'PRINT_PM'				=> 'Vista de impresión',
	'PREFERENCES_UPDATED'	=> 'Tus preferencias han sido actualizadas.',
	'PROFILE_INFO_NOTICE'	=> 'Por favor ten en cuenta que esta información será vista por otros usuarios. Se cuidadoso cuando incluyas detalles personales. Los campos marcados con * deben completarse obligatoriamente.',
	'PROFILE_UPDATED'		=> 'Tu perfil ha sido actualizado.',

	'RECIPIENT'				=> 'Destinatario',
	'RECIPIENTS'			=> 'Destinatarios',
	'REGISTRATION'			=> 'Registro',
	'RELEASE_MESSAGES'		=> '%sEnviar todos los mensajes en espera%s… serán reordenados en sus directorios correspondientes si hay suficiente espacio disponible.',
	'REMOVE_ADDRESS'		=> 'Eliminar dirección',
	'REMOVE_SELECTED_BOOKMARKS'	=> 'Eliminar Favoritos seleccionados',
	'REMOVE_SELECTED_BOOKMARKS_CONFIRM'	=> '¿Estás seguro de que quieres borrar todos los Favoritos seleccionados?',
	'REMOVE_BOOKMARK_MARKED'=> 'Eliminar Favoritos marcados',
	'REMOVE_FOLDER'			=> 'Eliminar directorio',
	'REMOVE_FOLDER_CONFIRM'	=> '¿Estás seguro de que quieres eliminar este directorio?',
	'RENAME'				=> 'Renombrar',
	'RENAME_FOLDER'			=> 'Renombrar directorio',
	'REPLIED_MESSAGE'		=> 'Mensaje respondido a',
	'REPLY_TO_ALL'		=> 'Responder a remitente y todos los destinatarios.',
	'REPORT_PM'			=> 'Informar el mensaje privado',
	'RESIGN_SELECTED'		=> 'Renunciar seleccionados',
	'RETURN_FOLDER'			=> '%1$sVolver a la carpeta anterior%2$s',
	'RETURN_UCP'			=> '%sVolver al Panel de Control del Usuario%s',
	'RULE_ADDED'			=> 'Regla añadida correctamente',
	'RULE_ALREADY_DEFINED'	=> 'Esta regla fue definida previamente',
	'RULE_DELETED'			=> 'Regla eliminada correctamente',
	'RULE_LIMIT_REACHED'				=> 'No se puede agregar más reglas de MP. Tu has alcanzado el número máximo de reglas.',    
	'RULE_NOT_DEFINED'		=> 'Regla no especificada correctamente',
	'RULE_REMOVED_MESSAGE'	=> 'Un mensaje privado ha sido eliminado debido a los filtros.',
	'RULE_REMOVED_MESSAGES'	=> '%d mensajes privados han sido eliminados debido a los filtros.',

	'SAME_PASSWORD_ERROR'	=> 'La nueva contraseña que has introducido es la misma que tu contraseña actual',
	'SEARCH_YOUR_POSTS'		=> 'Mostrar sus mensajes',
	'SEND_PASSWORD'			=> 'Enviar contraseña',
	'SENT_AT'				=> 'Enviado',			// Usado antes de la fecha en los mensajes privados
	'SHOW_EMAIL'			=> 'Los usuarios pueden contactarme por email',
	'SIGNATURE_EXPLAIN'		=> 'Este es un bloque de texto que puede añadirse a sus mensajes. Hay un límite de %d caracteres',
	'SIGNATURE_PREVIEW'		=> 'Tu firma se verá así',
	'SIGNATURE_TOO_LONG'	=> 'Tu firma es muy larga.',
	'SORT'					=> 'Ordenar',
	'SORT_COMMENT'			=> 'Comentario',
	'SORT_DOWNLOADS'		=> 'Descargas',
	'SORT_EXTENSION'		=> 'Extensión',
	'SORT_FILENAME'			=> 'Nombre',
	'SORT_POST_TIME'		=> 'Fecha',
	'SORT_SIZE'				=> 'Tamaño',

	'TIMEZONE'				=> 'Zona horaria',
	'TO'					=> 'Para',
	'TOO_MANY_RECIPIENTS'	=> 'Intentaste enviar un mensaje privado a demasiados destinatarios',
	'TOO_MANY_REGISTERS'	=> 'Has excedido el número máximo de intentos de registros para esta sesión. Por favor inténtalo más tarde.',

	'UCP'					=> 'Panel de Control de Usuario',
	'UCP_ACTIVATE'			=> 'Activar cuenta',
	'UCP_ADMIN_ACTIVATE'	=> 'Por favor observa que necesitas introducir una dirección de email válida antes de que tu cuenta sea activada. El administrador revisará tu cuenta y si la aprueba, recibirás un email en la direccion que introduciste.',
	'UCP_AIM'				=> 'AOL Instant Messenger',
	'UCP_ATTACHMENTS'		=> 'Adjuntos',
	'UCP_COPPA_BEFORE'		=> 'Antes %s',
	'UCP_COPPA_ON_AFTER'	=> 'O después %s',
	'UCP_EMAIL_ACTIVATE'	=> 'Por favor observa que necesitas ingresar una dirección de email válida para que tu cuenta sea activada. Recibirás un email en la dirección que introdujiste que contiene un enlace para la activación de la cuenta.',
	'UCP_ICQ'				=> 'Número de ICQ',
	'UCP_JABBER'			=> 'Dirección Jabber',

	'UCP_MAIN'				=> 'Vista General',
	'UCP_MAIN_ATTACHMENTS'	=> 'Organizar adjuntos',
	'UCP_MAIN_BOOKMARKS'	=> 'Organizar Favoritos',
	'UCP_MAIN_DRAFTS'		=> 'Organizar borradores',
	'UCP_MAIN_FRONT'		=> 'Página principal',
	'UCP_MAIN_SUBSCRIBED'	=> 'Organizar suscripciones',

	'UCP_MSNM'					=> 'WL/MSN Messenger',
	'UCP_NO_ATTACHMENTS'	=> 'No ha enviado adjuntos',

	'UCP_PREFS'				=> 'Preferencias de Foros',
	'UCP_PREFS_PERSONAL'	=> 'Editar preferencias personales',
	'UCP_PREFS_POST'		=> 'Editar preferencias de mensajes',
	'UCP_PREFS_VIEW'		=> 'Editar preferencias de visualización',

	'UCP_PM'				=> 'Mensajes privados',
	'UCP_PM_COMPOSE'		=> 'Escribir mensaje',
	'UCP_PM_DRAFTS'			=> 'Organizar borradores',
	'UCP_PM_OPTIONS'		=> 'Editar opciones',
	'UCP_PM_POPUP'			=> 'Mensajes privados',
	'UCP_PM_POPUP_TITLE'	=> 'Popup de mensajes privados',
	'UCP_PM_UNREAD'			=> 'Mensajes sin leer',
	'UCP_PM_VIEW'			=> 'Ver mensajes',

	'UCP_PROFILE'				=> 'Perfil',
	'UCP_PROFILE_AVATAR'		=> 'Editar avatar',
	'UCP_PROFILE_PROFILE_INFO'	=> 'Editar perfil',
	'UCP_PROFILE_REG_DETAILS'	=> 'Editar opciones de cuenta',
	'UCP_PROFILE_SIGNATURE'		=> 'Editar firma',

	'UCP_USERGROUPS'		=> 'Grupos de Usuarios',
	'UCP_USERGROUPS_MEMBER'	=> 'Editar usuarios',
	'UCP_USERGROUPS_MANAGE'	=> 'Administrar grupos',

	'UCP_REGISTER_DISABLE'	=> 'Crear una nueva cuenta no es posible actualmente.',
	'UCP_REMIND'	=> 'Enviar contraseña',
	'UCP_RESEND'	=> 'Enviar email de activación',
	'UCP_WELCOME'	=> 'Bienvenido al Panel de Control de Usuario. Desde aquí puedes observar y actualizar tu perfil, preferencias, suscripción a foros y temas. También puedes enviar mensajes a otros usuarios (si está permitido). Por favor lee todos los anuncios antes de continuar.',
	'UCP_YIM'	=> 'Yahoo Messenger',
	'UCP_ZEBRA'	=> 'Amigos e Ignorados',
	'UCP_ZEBRA_FOES'	=> 'Organizar Ignorados',
	'UCP_ZEBRA_FRIENDS'	=> 'Organizar amigos',
	'UNDISCLOSED_RECIPIENT'			=> 'Receptor no revelado',
	'UNKNOWN_FOLDER'	=> 'Directorio desconocido',
	'UNWATCH_MARKED'	=> 'No seguir marcados',
	'UPLOAD_AVATAR_FILE'	=> 'Subir desde tu PC',
	'UPLOAD_AVATAR_URL'	=> 'Subir desde una URL',
	'UPLOAD_AVATAR_URL_EXPLAIN'	=> 'Introduce la URL del sitio que tiene la imagen, será copiada a este sitio.',
	'USERNAME_ALPHA_ONLY_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente alfanuméricos',
	'USERNAME_ALPHA_SPACERS_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente alfanuméricos, espacio o -+_[].',
	'USERNAME_ASCII_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente ASCII, sin símbolos especiales',
	'USERNAME_LETTER_NUM_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente letras o números',
	'USERNAME_LETTER_NUM_SPACERS_EXPLAIN'	=> 'El nombre de usuario debe tener entre %1$d y %2$d caracteres de longitud y ser solamente letras, números, espacio o -+_[].',
	'USERNAME_CHARS_ANY_EXPLAIN'	=> 'La longitud debe ser entre %1$d y %2$d caracteres.',
	'USERNAME_TAKEN_USERNAME'	=> 'El nombre de usuario que introdujiste ya está en uso, por favor elige otro.',
	'USERNAME_DISALLOWED_USERNAME'	=> 'El nombre de usuario que introdujiste ha sido excluido.',
	'USER_NOT_FOUND_OR_INACTIVE'	=> 'No se puede encontrar a ese usuario, o aún no ha sido activado.',

	'VIEW_AVATARS'			=> 'Mostrar avatares',
	'VIEW_EDIT'				=> 'Ver/Editar',
	'VIEW_FLASH'			=> 'Mostrar animaciones Flash',
	'VIEW_IMAGES'			=> 'Mostrar imágenes en los mensajes',
	'VIEW_NEXT_HISTORY'		=> 'Siguiente MP en historial',
	'VIEW_NEXT_PM'			=> 'Siguiente MP',
	'VIEW_PM'				=> 'Ver mensaje',
	'VIEW_PM_INFO'			=> 'Detalles',
	'VIEW_PM_MESSAGE'		=> '1 mensaje',
	'VIEW_PM_MESSAGES'		=> '%d mensajes',
	'VIEW_PREVIOUS_HISTORY'	=> 'MP previo en historial',
	'VIEW_PREVIOUS_PM'		=> 'MP previo ',
	'VIEW_SIGS'				=> 'Mostrar firmas',
	'VIEW_SMILIES'			=> 'Mostrar emoticonos como imagenes',
	'VIEW_TOPICS_DAYS'		=> 'Mostrar temas de días previos',
	'VIEW_TOPICS_DIR'		=> 'Mostrar ordenamiento de temas',
	'VIEW_TOPICS_KEY'		=> 'Mostrar temas ordenados por',
	'VIEW_POSTS_DAYS'		=> 'Mostrar mensajes de días previos',
	'VIEW_POSTS_DIR'		=> 'Mostrar ordenamiento de mensajes',
	'VIEW_POSTS_KEY'		=> 'Mostrar mensajes ordenados por',

	'WATCHED_EXPLAIN'	=> 'Debajo está la lista de foros y temas a los que estás suscrito. Serás notificado de nuevos mensajes en ellos. Para cancelar la suscripción marca el foro o tema y luego haz clic en el botón <em>No seguir marcados</em>.',
	'WATCHED_FORUMS'	=> 'Foros suscritos',
	'WATCHED_TOPICS'	=> 'Temas suscritos',
	'WRONG_ACTIVATION'	=> 'La contraseña de activación proporcionada no coincide con ninguna en la base de datos',

	'YOUR_DETAILS'			=> 'Tu actividad',
	'YOUR_FOES'				=> 'Tus ignorados',
	'YOUR_FOES_EXPLAIN'		=> 'Para eliminar nombres de usuarios selecciónalos y luego haz clic en Enviar',
	'YOUR_FRIENDS'			=> 'Tus amigos',
	'YOUR_FRIENDS_EXPLAIN'	=> 'Para eliminar nombres de usuarios selecciónalos y luego haz clic en Enviar',
	'YOUR_WARNINGS'			=> 'Tus advertencias',

	'PM_ACTION'	=> array(
		'PLACE_INTO_FOLDER'	=> 'Poner en directorio',
		'MARK_AS_READ'		=> 'Marcar como leído',
		'MARK_AS_IMPORTANT'	=> 'Marcar mensaje',
		'DELETE_MESSAGE'	=> 'Borrar mensaje',
	),
	'PM_CHECK'	=> array(
		'SUBJECT'	=> 'Tema',
		'SENDER'	=> 'Remitente',
		'MESSAGE'	=> 'Mensaje',
		'STATUS'	=> 'Estado',
		'TO'	=> 'Enviar a',
	),
	'PM_RULE'	=> array(
		'IS_LIKE'		=> 'contiene',
		'IS_NOT_LIKE'	=> 'no contiene',
		'IS'			=> 'es',
		'IS_NOT'		=> 'no es',
		'BEGINS_WITH'	=> 'comienza con',
		'ENDS_WITH'		=> 'termina con',
		'IS_FRIEND'		=> 'es amigo',
		'IS_FOE'		=> 'es un Ignorado',
		'IS_USER'		=> 'es usuario',
		'IS_GROUP'		=> 'está en el grupo',
		'ANSWERED'		=> 'respondido',
		'FORWARDED'		=> 'reenviado',
		'TO_GROUP'		=> 'a mi grupo por defecto',
		'TO_ME'			=> 'a mi',
	),


	'GROUPS_EXPLAIN'	=> 'Los Grupos permiten a los administradores manejar mejor a los usuarios. Por defecto estará en un grupo específico, este es su grupo por defecto. Este grupo define como le ven los otros usuarios, por ejemplo color del nombre, avatar, rango, etc. Dependiendo de lo que el administrador permita podrás cambiar tu grupo por defecto. Tambien podrás ser situado o permitirte ingresar a otros grupos. Algunos grupos pueden otorgarte derechos extras para ver contenido o aumentar tus capacidades en otras áreas.',
	'GROUP_LEADER'		=> 'Líderes',
	'GROUP_MEMBER'		=> 'Usuarios',
	'GROUP_PENDING'		=> 'Membresías pendientes',
	'GROUP_NONMEMBER'	=> 'No-usuarios',
	'GROUP_DETAILS'		=> 'Detalles del Grupo',

	'NO_LEADER'		=> 'Sin líder',
	'NO_MEMBER'		=> 'Sin usuarios',
	'NO_PENDING'	=> 'Sin membresías pendientes',
	'NO_NONMEMBER'	=> 'Sin grupo de no-usuarios',
));

?>