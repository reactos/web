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
* acp_styles.php [Spanish [Es]]
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

$lang = array_merge($lang, array(
	'ACP_IMAGESETS_EXPLAIN'	=> 'Los paquetes de imágenes incluyen todas las imágenes de botones, foros, carpetas, etc. y otras no específicas empleadas en el Sitio. Aquí puedes editar, exportar o borrar paquetes existentes y activar o importar nuevos.',
	'ACP_STYLES_EXPLAIN'	=> 'Aquí puedes administrar los estilos disponibles en tu Sitio. Un estilo consiste de una plantilla (template), tema y paquete de imágenes. Puedes alterar estilos existentes, borrar, desactivar, reactivar, crear o importar nuevos. También puedes ver como se vería un estilo usando la función Vista Previa. El estilo por defecto actual es señalado con un asterisco (*). También se muestra el total de usuarios por cada estilo, ten en cuenta que sustituir los estilos de usuario no se reflejará aquí.',
	'ACP_TEMPLATES_EXPLAIN'	=> 'Un paquete de plantillas incluye todas las páginas usadas para generar la apariencia de tu Sitio. Aquí puedes editar, borrar, exportar e importar, y hacer una vista previa de las plantillas. También puedes modificar el código empleado para generar BBCodes.',
	'ACP_THEMES_EXPLAIN'	=> 'Desde aquí puedes crear, instalar, editar, borrar y exportar temas. Un tema es la combinación de colores e imágenes que se aplica a las plantillas para definir el aspecto general de tu Sitio. El rango de opciones disponible depende de la configuración de tu servidor y la instalación de phpBB, lee el manual para más detalles. Por favor observa que cuando creas nuevos temas puedes usar uno existente como base.',
	'ADD_IMAGESET'			=> 'Crear paquete de imágenes',
	'ADD_IMAGESET_EXPLAIN'	=> 'Aquí puedes crear un nuevo paquete de imágenes. Dependiendo de la configuración del servidor y los permisos de archivo tendrás opciones adicionales. Por ejemplo podrías basar este paquete de imágenes en otro ya existente. También subir o importar (de la carpeta store) un paquete de imágenes. Si subes o importas un archivo, el nombre del paquete podría tomar por defecto el nombre del archivo (para hacer esto deja el nombre del paquete en blanco).',
	'ADD_STYLE'				=> 'Crear estilo',
	'ADD_STYLE_EXPLAIN'		=> 'Aquí puedes crear un nuevo estilo. Dependiendo de la configuración del servidor y los permisos de archivo tendrás opciones adicionales. Por ejemplo podrías basar este estilo en otro ya existente. También subir o importar (de la carpeta store) un estilo. Si subes o importas un archivo, el nombre del estilo podría tomar por defecto el nombre del archivo (para hacer esto deja el nombre del estilo en blanco).',
	'ADD_TEMPLATE'			=> 'Crear una plantilla',
	'ADD_TEMPLATE_EXPLAIN'	=> 'Aquí puedes crear una nueva plantilla. Dependiendo de la configuración del servidor y los permisos de archivo tendrás opciones adicionales. Por ejemplo podrías basar esta plantilla en otra ya existente. También subir o importar (de la carpeta store) una plantilla. Si subes o importas un archivo, el nombre de la plantilla podría tomar por defecto el nombre del archivo (para hacer esto deja el nombre de la plantilla en blanco).',
	'ADD_THEME'				=> 'Crear tema',
	'ADD_THEME_EXPLAIN'		=> 'Aquí puedes crear un nuevo tema. Dependiendo de la configuración del servidor y los permisos de archivo tendrás opciones adicionales. Por ejemplo podrías basar este tema en otro ya existente. También subir o importar (de la carpeta store) un tema. Si subes o importas un archivo, el nombre del tema podría tomar por defecto el nombre del archivo (para hacer esto deja el nombre del tema en blanco).',
	'ARCHIVE_FORMAT'		=> 'Tipo de archivo',
	'AUTOMATIC_EXPLAIN'		=> 'Dejar en blanco para intentar una detección automática.',
	
	'BACKGROUND'			=> 'Fondo',
	'BACKGROUND_COLOUR'		=> 'Color de fondo',
	'BACKGROUND_IMAGE'		=> 'Imagen de fondo',
	'BACKGROUND_REPEAT'		=> 'Repetición de fondo',
	'BOLD'					=> 'Negrita',
	
	'CACHE'							=> 'Caché',
	'CACHE_CACHED'					=> 'Cacheado',
	'CACHE_FILENAME'				=> 'Nombre',
	'CACHE_FILESIZE'				=> 'Tamaño',
	'CACHE_MODIFIED'				=> 'Modificado',
	'CONFIRM_IMAGESET_REFRESH'		=> '¿Estás seguro de que quieres actualizar los datos? Los configuración de configuración sobreescribirán todas las modificaciones que hayas hecho con el editor.',
	'CONFIRM_TEMPLATE_CLEAR_CACHE'	=> '¿Estás seguro de que quieres limpiar todas las versiones cacheadas de tus plantillas?',
	'CONFIRM_TEMPLATE_REFRESH'		=> '¿Estás seguro de que quieres sobreescribir las plantillas en la base de datos con el contenido de los archivos? Esto sobreescribirá todas las modificaciones que hayas hecho con el editor de plantillas.',
	'CONFIRM_THEME_REFRESH'			=> '¿Estás seguro de que quieres sobreescribir el tema en la base de datos con el contenido de los archivos? Esto sobreescribirá todas las modificaciones que hayas hecho con el editor de temas.',
	'COPYRIGHT'						=> 'Copyright',
	'CREATE_IMAGESET'				=> 'Crear nuevo paquete de imágenes',
	'CREATE_STYLE'					=> 'Crear nuevo estilo',
	'CREATE_TEMPLATE'				=> 'Crear nueva plantilla',
	'CREATE_THEME'					=> 'Crear nuevo tema',
	'CURRENT_IMAGE'					=> 'Imagen actual',
	
	'DEACTIVATE_DEFAULT'			=> 'No puedes desactivar el estilo por defecto.',
	'DELETE_FROM_FS'				=> 'Borrar del sistema',
	'DELETE_IMAGESET'				=> 'Borrar paquete de imágenes',
	'DELETE_IMAGESET_EXPLAIN'		=> 'Aquí puedes eliminar el paquete de imágenes seleccionado de la base de datos. Por favor ten en cuenta que esa acción no se puede deshacer. Es recomendable que primero lo exportes para usarlo en el futuro.',
	'DELETE_STYLE'					=> 'Borrar estilo',
	'DELETE_STYLE_EXPLAIN'		=> 'Aquí puedes eliminar el estilo seleccionado. Ten en cuenta que esa acción no se puede deshacer.',
	'DELETE_TEMPLATE'				=> 'Borrar plantilla',
	'DELETE_TEMPLATE_EXPLAIN'		=> 'Aquí puedes eliminar la plantilla seleccionada de la base de datos. Por favor ten en cuenta que esa acción no se puede deshacer. Es recomendable que primero lo exportes para usarlo en el futuro.',
	'DELETE_THEME'					=> 'Borrar tema',
	'DELETE_THEME_EXPLAIN'			=> 'Aquí puedes eliminar el tema seleccionado de la base de datos. Por favor ten en cuenta que esa acción no se puede deshacer. Es recomendable que primero lo exportes para usarlo en el futuro.',
	'DETAILS'						=> 'Detalles',
	'DIMENSIONS_EXPLAIN'			=> 'Seleccionar SÍ aquí incluirá parametros de ancho/alto.',
	
	'EDIT_DETAILS_IMAGESET'			=> 'Editar detalles del paquete de imágenes',
	'EDIT_DETAILS_IMAGESET_EXPLAIN'	=> 'Aquí puedes editar ciertos detalles del paquete como por ejemplo su nombre.',
	'EDIT_DETAILS_STYLE'			=> 'Editar plantilla',
	'EDIT_DETAILS_STYLE_EXPLAIN'	=> 'Usando el siguiente formulario puedes modificar esta plantilla. Puedes cambiar la combinación de plantilla, tema y paquete de imágenes lo cual define un estilo en si mismo. Podrás hacerlo también estilo por defecto.',
	'EDIT_DETAILS_TEMPLATE'			=> 'Editar detalles de plantilla',
	'EDIT_DETAILS_TEMPLATE_EXPLAIN'	=> 'Aquí puedes editar ciertos detalles de la plantilla como por ejemplo su nombre. También tienes la opción de elegir entre almacenar en el sistema a la base de datos y viceversa. Esta opción depende de la configuración de PHP y si tienes los permisos adecuados en el servidor.',
	'EDIT_DETAILS_THEME'			=> 'Editar detalles de plantilla',
	'EDIT_DETAILS_THEME_EXPLAIN'	=> 'Aquí puedes editar ciertos detalles del tema como por ejemplo su nombre. También tienes la opción de alternar entre almacenar en el sistema a la base de datos y viceversa. Esta opción depende de la configuración de PHP y si tienes los permisos adecuados en el servidor.',
	'EDIT_IMAGESET'					=> 'Editar paquete de imágenes',
	'EDIT_IMAGESET_EXPLAIN'			=> 'Aquí puedes editar las imágenes individuales que incluye el paquete. También podrás especificar las dimensiones de la imagen. Las dimensiones son opcionales, especificarlas puede acarrear dificultades de visualización con algunos navegadores. No especificarla reduce un poco el tamaño del registro en la base de datos.',
	'EDIT_TEMPLATE'					=> 'Editar plantilla',
	'EDIT_TEMPLATE_EXPLAIN'			=> 'Aquí puedes editar tu plantilla directamente. Por favor recuerda que esas ediciones son permanentes y no se pueden deshacer una vez enviadas. Si PHP puede escribir en tu carpeta de estilos cualquier cambio, aquí se guardará directamente en el sistema. Si PHP no puede escribir, serán copiados en la base de datos y los cambios se reflejarán solo allí. Por favor esté atento cuando edites tus plantillas y recuerda cerrar todos los reemplazos de variables {XXXX} e instrucciones condicionales (IF/ENDIF).',
	'EDIT_TEMPLATE_STORED_DB'		=> 'La plantilla no se pudo escribir, así que se guardará en la base de datos que contiene el archivo modificado.',
	'EDIT_THEME'					=> 'Editar plantilla',
	'EDIT_THEME_EXPLAIN'			=> 'Aquí puedes editar la plantilla seleccionada, cambiar colores, imágenes, etc.',
	'EDIT_THEME_STORED_DB'			=> 'No se puede escribir en el sistema, así que la plantilla se guardará en la base de datos.',
	'EDIT_THEME_STORE_PARSED'		=> 'La plantilla requiere que su estilo esté convertido. Esto solo es posible si está almacenado en la base de datos.',
	'EDITOR_DISABLED'					=> 'El editor de plantilla está deshabilitado.',
	'EXPORT'						=> 'Exportar',
	
	'FOREGROUND'			=> 'Frente',
	'FONT_COLOUR'			=> 'Color de fuente',
	'FONT_FACE'				=> 'Tipo de fuente',
	'FONT_FACE_EXPLAIN'		=> 'Puedes especificar múltiples fuentes separadas por comas. Si un usuario no tiene la primera fuente instalada, se usará la siguiente.',
	'FONT_SIZE'				=> 'Tamaño de fuente',
	
	'GLOBAL_IMAGES'			=> 'Global',
	
	'HIDE_CSS'				=> 'Ocultar codigo CSS',
	
	'IMAGE_WIDTH'				=> 'Ancho de imagen',
	'IMAGE_HEIGHT'				=> 'Alto de imagen',
	'IMAGE'						=> 'Imagen',
	'IMAGE_NAME'				=> 'Nombre de imagen',
	'IMAGE_PARAMETER'			=> 'Configuración',
	'IMAGE_VALUE'				=> 'Valor',
	'IMAGESET_ADDED'			=> 'Nuevo paquete de imágenes añadido al sistema.',
	'IMAGESET_ADDED_DB'			=> 'Nuevo paquete de imágenes añadido a la base de datos.',
	'IMAGESET_DELETED'			=> 'Paquete de imágenes borrado correctamente.',
	'IMAGESET_DELETED_FS'		=> 'Paquete de imágenes eliminado de la base de datos pero algunos archivos pueden permanecer en el sistema.',
	'IMAGESET_DETAILS_UPDATED'	=> 'Detalles de paquete de imágenes actualizados correctamente.',
	'IMAGESET_ERR_ARCHIVE'		=> 'Por favor seleccione un método.',
	'IMAGESET_ERR_COPY_LONG'	=> 'El copyright no puede superar los 50 caracteres.',
	'IMAGESET_ERR_NAME_CHARS'	=> 'El nombre del paquete de imágenes solo puede contener caracteres alfanuméricos, -, +, _ y espacio.',
	'IMAGESET_ERR_NAME_EXIST'	=> 'Ya existe un paquete de imágenes con ese nombre.',
	'IMAGESET_ERR_NAME_LONG'	=> 'El nombre del paquete de imágenes no puede superar los 30 caracteres.',
	'IMAGESET_ERR_NOT_IMAGESET'	=> 'El archivo que especificastes no contiene un paquete de imágenes válido.',
	'IMAGESET_ERR_STYLE_NAME'	=> 'Tienes que ponerle un nombre a este paquete de imágenes.',
	'IMAGESET_EXPORT'			=> 'Exportar paquete de imágenes',
	'IMAGESET_EXPORT_EXPLAIN'	=> 'Aquí puedes exportar un paquete de imágenes a un archivo. Este archivo contendrá todos los datos necesarios para instalar las imágenes en otro Sitio. Puedes seleccionar descargarlo directamente o ponerlo en la carpeta store para bajarlo después o vía FTP.',
	'IMAGESET_EXPORTED'			=> 'Paquete de imágenes exportado correctamente y almacenado en %s.',
	'IMAGESET_NAME'				=> 'Nombre del paquete de imágenes',
	'IMAGESET_REFRESHED'		=> 'Paquete de imágenes actualizado correctamente.',
	'IMAGESET_UPDATED'			=> 'Paquete de imágenes actualizado correctamente.',
	'ITALIC'					=> 'Cursiva',
	
	'IMG_CAT_BUTTONS'	=> 'Botones regionalizados',
	'IMG_CAT_CUSTOM'	=> 'Imágenes personalizadas',
	'IMG_CAT_FOLDERS'	=> 'Iconos de tema',
	'IMG_CAT_FORUMS'	=> 'Iconos de foro',
	'IMG_CAT_ICONS'		=> 'Iconos generales',
	'IMG_CAT_LOGOS'		=> 'Logos',
	'IMG_CAT_POLLS'		=> 'Imagenes de encuestas',
	'IMG_CAT_UI'		=> 'Elementos generales',
	'IMG_CAT_USER'		=> 'Imagenes adicionales',
	
	'IMG_SITE_LOGO'		=> 'Logo principal',
	'IMG_UPLOAD_BAR'	=> 'Barra de progreso',
	'IMG_POLL_LEFT'		=> 'Final izquierdo de encuesta',
	'IMG_POLL_CENTER'	=> 'Encuesta centro',
	'IMG_POLL_RIGHT'	=> 'Final derecho de encuesta',
	'IMG_ICON_FRIEND'	=> 'Añadir como amigo',
	'IMG_ICON_FOE'		=> 'Añadir como Ignorado',
	
	'IMG_FORUM_LINK'			=> 'Enlace de foro',
	'IMG_FORUM_READ'			=> 'Foro',
	'IMG_FORUM_READ_LOCKED'		=> 'Foro cerrado',
	'IMG_FORUM_READ_SUBFORUM'	=> 'Subforo',
	'IMG_FORUM_UNREAD'			=> 'Mensajes no leídos en el foro',
	'IMG_FORUM_UNREAD_LOCKED'	=> 'Mensajes no leídos cerrados',
	'IMG_FORUM_UNREAD_SUBFORUM'	=> 'Mensajes no leídos en el subforo',
	'IMG_SUBFORUM_READ'			=> 'Leyenda de subforo',
	'IMG_SUBFORUM_UNREAD'		=> 'Leyenda de mensajes no leídos en el subforo',
	
	'IMG_TOPIC_MOVED'			=> 'Tema movido',
	
	'IMG_TOPIC_READ'				=> 'Tema leído',
	'IMG_TOPIC_READ_MINE'			=> 'Tema leído (mío)',
	'IMG_TOPIC_READ_HOT'			=> 'Tema popular leído',
	'IMG_TOPIC_READ_HOT_MINE'		=> 'Tema popular leído (mío)',
	'IMG_TOPIC_READ_LOCKED'			=> 'Tema cerrado leído',
	'IMG_TOPIC_READ_LOCKED_MINE'	=> 'Tema cerrado leído (mío)',
	
	'IMG_TOPIC_UNREAD'				=> 'Tema con mensajes sin leer',
	'IMG_TOPIC_UNREAD_MINE'			=> 'Tema con mensajes sin leer (mío)',
	'IMG_TOPIC_UNREAD_HOT'			=> 'Tema popular con mensajes sin leer',
	'IMG_TOPIC_UNREAD_HOT_MINE'		=> 'Tema popular con mensajes sin leer (mío)',
	'IMG_TOPIC_UNREAD_LOCKED'		=> 'Tema bloquedo con mensajes sin leer',
	'IMG_TOPIC_UNREAD_LOCKED_MINE'	=> 'Tema bloqeado con mensajes sin leer (mío)',
	
	'IMG_STICKY_READ'				=> 'Tema fijo leído',
	'IMG_STICKY_READ_MINE'			=> 'Tema fijo sin leer (mío)',
	'IMG_STICKY_READ_LOCKED'		=> 'Tema fijo leído cerrado',
	'IMG_STICKY_READ_LOCKED_MINE'	=> 'Tema fijo leído cerrado (mío)',
	'IMG_STICKY_UNREAD'				=> 'Tema fijo sin leer',
	'IMG_STICKY_UNREAD_MINE'		=> 'Tema fijo sin leer (mío)',
	'IMG_STICKY_UNREAD_LOCKED'		=> 'Tema fijo sin leer cerrado',
	'IMG_STICKY_UNREAD_LOCKED_MINE'	=> 'Tema fijo sin leer cerrado (mío)',
	
	'IMG_ANNOUNCE_READ'					=> 'Anuncio leído',
	'IMG_ANNOUNCE_READ_MINE'			=> 'Anuncio leído (mío)',
	'IMG_ANNOUNCE_READ_LOCKED'			=> 'Anuncio leído cerrado',
	'IMG_ANNOUNCE_READ_LOCKED_MINE'		=> 'Anuncio leído cerrado (mío)',
	'IMG_ANNOUNCE_UNREAD'				=> 'Anuncio con mensajes sin leer',
	'IMG_ANNOUNCE_UNREAD_MINE'			=> 'Anuncio (mío) con mensajes sin leer',
	'IMG_ANNOUNCE_UNREAD_LOCKED'		=> 'Anuncio cerrado con mensajes sin leer',
	'IMG_ANNOUNCE_UNREAD_LOCKED_MINE'	=> 'Anuncio cerrado (mío) con mensajes sin leer',
	
	'IMG_GLOBAL_READ'				=> 'Global',
	'IMG_GLOBAL_READ_MINE'			=> 'Global leído (mío)',
	'IMG_GLOBAL_READ_LOCKED'		=> 'Global leído cerrado',
	'IMG_GLOBAL_READ_LOCKED_MINE'	=> 'Global leído cerrado (mío)',
	'IMG_GLOBAL_UNREAD'				=> 'Global con mensajes sin leer',
	'IMG_GLOBAL_UNREAD_MINE'		=> 'Global (mío) con mensajes sin leer',
	'IMG_GLOBAL_UNREAD_LOCKED'		=> 'Global cerrado con mensajes sin leer',
	'IMG_GLOBAL_UNREAD_LOCKED_MINE'	=> 'Global cerrado (mío) con mensajes sin leer',	
	'IMG_PM_READ'	=> 'Mensaje privado leído',
	'IMG_PM_UNREAD'	=> 'Mensaje privado sin leer',
	
	'IMG_ICON_BACK_TOP'	=> 'Arriba',
	
	'IMG_ICON_CONTACT_AIM'		=> 'AIM',
	'IMG_ICON_CONTACT_EMAIL'	=> 'Enviar e-mail',
	'IMG_ICON_CONTACT_ICQ'		=> 'ICQ',
	'IMG_ICON_CONTACT_JABBER'	=> 'Jabber',
	'IMG_ICON_CONTACT_MSNM'		=> 'MSNM',
	'IMG_ICON_CONTACT_PM'		=> 'Enviar mensaje',
	'IMG_ICON_CONTACT_YAHOO'	=> 'YIM',
	'IMG_ICON_CONTACT_WWW'		=> 'Sitio Web',
	
	'IMG_ICON_POST_DELETE'			=> 'Borrar mensaje',
	'IMG_ICON_POST_EDIT'			=> 'Editar mensaje',
	'IMG_ICON_POST_INFO'			=> 'Mostrar detalles del mensaje',
	'IMG_ICON_POST_QUOTE'			=> 'Citar mensaje',
	'IMG_ICON_POST_REPORT'			=> 'Informar del mensaje',
	'IMG_ICON_POST_TARGET'			=> 'Mensaje leído (mini)',
	'IMG_ICON_POST_TARGET_UNREAD'	=> 'Mensaje sin leer (mini)',
	
	
	'IMG_ICON_TOPIC_ATTACH'		=> 'Adjunto',
	'IMG_ICON_TOPIC_LATEST'		=> 'Último mensaje',
	'IMG_ICON_TOPIC_NEWEST'		=> 'Último mensaje sin leer',
	'IMG_ICON_TOPIC_REPORTED'	=> 'Mensaje informado',
	'IMG_ICON_TOPIC_UNAPPROVED'	=> 'Mensaje no aprobado',
	
	'IMG_ICON_USER_ONLINE'	=> 'Usuario identificado',
	'IMG_ICON_USER_OFFLINE'	=> 'Usuario desconectado',
	'IMG_ICON_USER_PROFILE'	=> 'Mostrar perfil',
	'IMG_ICON_USER_SEARCH'	=> 'Buscar mensajes',
	'IMG_ICON_USER_WARN'	=> 'Advertir usuario',
	
	'IMG_BUTTON_PM_FORWARD'		=> 'Reenviar mensaje privado',
	'IMG_BUTTON_PM_NEW'			=> 'Nuevo mensaje privado',
	'IMG_BUTTON_PM_REPLY'		=> 'Responder mensaje privado',
	'IMG_BUTTON_TOPIC_LOCKED'	=> 'Cerrar tema',
	'IMG_BUTTON_TOPIC_NEW'		=> 'Nuevo tema',
	'IMG_BUTTON_TOPIC_REPLY'	=> 'Responder tema',
	
	'IMG_USER_ICON1'	=> 'Definida por usuario 1',
	'IMG_USER_ICON2'	=> 'Definida por usuario 2',
	'IMG_USER_ICON3'	=> 'Definida por usuario 3',
	'IMG_USER_ICON4'	=> 'Definida por usuario 4',
	'IMG_USER_ICON5'	=> 'Definida por usuario 5',
	'IMG_USER_ICON6'	=> 'Definida por usuario 6',
	'IMG_USER_ICON7'	=> 'Definida por usuario 7',
	'IMG_USER_ICON8'	=> 'Definida por usuario 8',
	'IMG_USER_ICON9'	=> 'Definida por usuario 9',
	'IMG_USER_ICON10'	=> 'Definida por usuario 10',
	'INACTIVE_STYLES'			=> 'Estilos inactivos',    
	
	'INCLUDE_DIMENSIONS'		=> 'Incluir dimensiones',
	'INCLUDE_IMAGESET'			=> 'Incluir paquete de imágenes',
	'INCLUDE_TEMPLATE'			=> 'Incluir plantilla',
	'INCLUDE_THEME'				=> 'Incluir tema',
	'INHERITING_FROM'			=> 'Hereda de',
	'INSTALL_IMAGESET'			=> 'Instalar paquete de imágenes',
	'INSTALL_IMAGESET_EXPLAIN'	=> 'Aquí puedes instalar tu paquete de imágenes seleccionado. Puedes editar ciertos detalles si quieres, o usar la instalación por defecto.',
	'INSTALL_STYLE'				=> 'Instalar estilo',
	'INSTALL_STYLE_EXPLAIN'		=> 'Aquí puedes instalar un nuevo estilo y si es apropiado, sus distintos elementos. Si ya los tienes instalados, no se sobreescribirán. Algunos estilos requieren ciertos elementos para ser instalados. Si tratas de instalar un estilo y no tiene los elementos requeridos, será notificado.',
	'INSTALL_TEMPLATE'			=> 'Instalar plantilla',
	'INSTALL_TEMPLATE_EXPLAIN'	=> 'Aquí puedes instalar un nuevo juego de plantillas. Tendrás ciertas opciones según la configuración de tu servidor.',
	'INSTALL_THEME'				=> 'Instalar tema',
	'INSTALL_THEME_EXPLAIN'		=> 'Aquí puedes instalar el tema seleccionado. Puedes editar ciertos detalles si quieres, o usar la instalación por defecto.',
	'INSTALLED_IMAGESET'		=> 'Paquetes de imágenes instalados',
	'INSTALLED_STYLE'			=> 'Estilos instalados',
	'INSTALLED_TEMPLATE'		=> 'Plantillas instaladas',
	'INSTALLED_THEME'			=> 'Temas instalados',
	'KEEP_IMAGESET'				=> 'Mantener “%s” imágenes',
	'KEEP_TEMPLATE'				=> 'Mantener “%s” plantilla',
	'KEEP_THEME'				=> 'Mantener “%s” tema',
	
	'LINE_SPACING'		=> 'Espacio de línea',
	'LOCALISED_IMAGES'	=> 'Regionalizado',
	'LOCATION_DISABLED_EXPLAIN'	=> 'Esta configuración es heredada y no puede ser cambiada.',
	
	'NO_CLASS'					=> 'No se pudo encontrar clases en el estilo.',
	'NO_IMAGESET'				=> 'No se pudo encontrar paquete de imágenes en el sistema.',
	'NO_IMAGE'					=> 'No hay imágenes',
	'NO_IMAGE_ERROR'			=> 'No se pudo encontrar la imagen en el sistema.',
	'NO_STYLE'					=> 'No se pudo encontrar el estilo en el sistema.',
	'NO_TEMPLATE'				=> 'No se pudo encontrar la plantilla en el sistema.',
	'NO_THEME'					=> 'No se pudo encontrar el tema en el sistema.',
	'NO_UNINSTALLED_IMAGESET'	=> 'No se encontraron paquetes de imágenes desintalados.',
	'NO_UNINSTALLED_STYLE'		=> 'No se encontraron estilos desintalados.',
	'NO_UNINSTALLED_TEMPLATE'	=> 'No se encontraron plantillas desintaladas.',
	'NO_UNINSTALLED_THEME'		=> 'No se encontraron temas desintalados.',
	'NO_UNIT'					=> 'Ninguno',
	
	'ONLY_IMAGESET'				=> 'Éste es el último paquete de imágenes, no puedes borrarlo.',
	'ONLY_STYLE'				=> 'Éste es el último estilo, no puedes borrarlo.',
	'ONLY_TEMPLATE'				=> 'Éste es el último juego de plantillas que queda, no puedes borrarlo.',
	'ONLY_THEME'				=> 'Éste es el último tema que queda, no puedes borrarlo.',
	'OPTIONAL_BASIS'			=> 'Opcional',
	
	'REFRESH'					=> 'Actualizar',
	'REPEAT_NO'					=> 'Ninguna',
	'REPEAT_X'					=> 'Solo horizontalmente',
	'REPEAT_Y'					=> 'Solo verticalmente',
	'REPEAT_ALL'				=> 'Ambas direcciones',
	'REPLACE_IMAGESET'			=> 'Reemplazar paquete de imágenes con',
	'REPLACE_IMAGESET_EXPLAIN'	=> 'Este paquete de imágenes reemplazará al que estás borrando en cualquier estilo que lo emplees.',
	'REPLACE_STYLE'				=> 'Reemplazar estilo con',
	'REPLACE_STYLE_EXPLAIN'		=> 'Este estilo reemplazará al que estás borrando para los usuarios que lo empleen.',
	'REPLACE_TEMPLATE'			=> 'Reemplazar plantilla con',
	'REPLACE_TEMPLATE_EXPLAIN'	=> 'Esta plantilla reemplazará la que estás borrando en cualquier estilo que la utilices.',
	'REPLACE_THEME'				=> 'Reemplazar tema con',
	'REPLACE_THEME_EXPLAIN'		=> 'Esta tema reemplazará la que estás borrando en cualquier estilo que lo utilices.',
	'REPLACE_WITH_OPTION'		=> 'Reemplazar con “%s”',
	'REQUIRES_IMAGESET'			=> 'Este estilo requiere que el paquete de imágenes %s se encuentre instalado.',
	'REQUIRES_TEMPLATE'			=> 'Este estilo requiere que el juego de plantillas %s se encuentre instalado.',
	'REQUIRES_THEME'			=> 'Este estilo requiere que el tema %s se encuentre instalado.',
	
	'SELECT_IMAGE'				=> 'Seleccionar imagen',
	'SELECT_TEMPLATE'			=> 'Seleccionar plantilla',
	'SELECT_THEME'				=> 'Seleccionar tema',
	'SELECTED_IMAGE'			=> 'Imagen seleccionada',
	'SELECTED_IMAGESET'			=> 'Paquete de imágenes seleccionado',
	'SELECTED_TEMPLATE'			=> 'Plantilla seleccionada',
	'SELECTED_TEMPLATE_FILE'	=> 'Archivo seleccionado',
	'SELECTED_THEME'			=> 'Tema seleccionado',
	'SELECTED_THEME_FILE'		=> 'Archivo seleccionado',
	'STORE_DATABASE'			=> 'Base de datos',
	'STORE_FILESYSTEM'			=> 'Almacenar',
	'STYLE_ACTIVATE'			=> 'Activar',
	'STYLE_ACTIVE'				=> 'Activo',
	'STYLE_ADDED'				=> 'Estilo añadido correctamente.',
	'STYLE_DEACTIVATE'			=> 'Desactivar',
	'STYLE_DEFAULT'				=> 'Hacer estilo por defecto',
	'STYLE_DELETED'				=> 'Estilo borrado correctamente.',
	'STYLE_DETAILS_UPDATED'		=> 'Estilo editado correctamente.',
	'STYLE_ERR_ARCHIVE'			=> 'Por favor selecciona un metodo.',
	'STYLE_ERR_COPY_LONG'		=> 'El estilo no puede superar los 50 caracteres.',
	'STYLE_ERR_MORE_ELEMENTS'	=> 'Tienes que seleccionar al menos un elemento del estilo.',
	'STYLE_ERR_NAME_CHARS'		=> 'El nombre del estilo solo puede contener caracteres alfanuméricos, -, +, _ y espacio.',
	'STYLE_ERR_NAME_EXIST'		=> 'Ya existe un estilo con ese nombre.',
	'STYLE_ERR_NAME_LONG'		=> 'El nombre del estilo no puede superar los 30 caracteres.',
	'STYLE_ERR_NO_IDS'			=> 'Tienes que seleccionar una plantilla, tema y paquete de imágenes para este estilo.',
	'STYLE_ERR_NOT_STYLE'		=> 'El archivo subido o importado no contiene un estilo válido.',
	'STYLE_ERR_STYLE_NAME'		=> 'Tienes que proporcionar un nombre para este estilo.',
	'STYLE_EXPORT'				=> 'Exportar estilo',
	'STYLE_EXPORT_EXPLAIN'		=> 'Aquí puedes exportar un estilo en forma de archivo. Un estilo no necesita contener todos los elementos pero si contener al menos uno. Por ejemplo si creaste un nuevo tema y paquete de imágenes para una plantilla usada habitualmente podrías simplemente exportar el tema y el paquete de imágenes y omitir la plantilla. Tienes que seleccionar si descarga el archivo directamente o ponerlo en la carpeta store para descargarlo más tarde o vía FTP.',
	'STYLE_EXPORTED'			=> 'Estilo exportado correctamente y guardado en %s.',
	'STYLE_IMAGESET'			=> 'Paquete de imágenes',
	'STYLE_NAME'				=> 'Nombre del estilo',
	'STYLE_TEMPLATE'			=> 'Plantilla',
	'STYLE_THEME'				=> 'Tema',
	'STYLE_USED_BY'				=> 'Usado por (incluyendo robots)',
	
	'TEMPLATE_ADDED'			=> 'Juego de plantillas añadido y guardado en el sistema.',
	'TEMPLATE_ADDED_DB'			=> 'Juego de plantillas añadido y guardado en la base de datos.',
	'TEMPLATE_CACHE'			=> 'Caché de plantilla',
	'TEMPLATE_CACHE_EXPLAIN'	=> 'Por defecto phpBB cachea versiones precompliadas de las plantillas. Esto disminuye la carga del servidor cada vez que se visita una pagina y por lo tanto el tiempo de generacion de esa página. Aquí puedes ver el estado de cada archivo y borrarlos individualmente o el caché completo.',
	'TEMPLATE_CACHE_CLEARED'	=> 'Caché de plantillas vaciado correctamente.',
	'TEMPLATE_CACHE_EMPTY'		=> 'No hay plantillas cacheadas.',
	'TEMPLATE_DELETED'			=> 'Juego de plantillas borrado correctamente.',
	'TEMPLATE_DELETE_DEPENDENT'	=> 'El juego de plantillas no puede ser eliminado ya que hay uno o más juegos de plantillas que heredan de él:',
	'TEMPLATE_DELETED_FS'		=> 'Juego de plantillas eliminado de la base de datos, aunque algunos archivos pueden quedar en el sistema.',
	'TEMPLATE_DETAILS_UPDATED'	=> 'Detalles actualizados correctamente.',
	'TEMPLATE_EDITOR'			=> 'Editor de codigo HTML',
	'TEMPLATE_EDITOR_HEIGHT'	=> 'Alto del editor',
	'TEMPLATE_ERR_ARCHIVE'		=> 'Por favor selecciona un método.',
	'TEMPLATE_ERR_CACHE_READ'	=> 'No se puede abrir el directorio caché usado para guardar versiones cacheadas de las plantillas.',
	'TEMPLATE_ERR_COPY_LONG'	=> 'La plantilla no puede superar los 50 caracteres.',
	'TEMPLATE_ERR_NAME_CHARS'	=> 'El nombre de la plantilla solo puede contener caracteres alfanuméricos, -, +, _ y espacio.',
	'TEMPLATE_ERR_NAME_EXIST'	=> 'Ya existe una plantilla con ese nombre.',
	'TEMPLATE_ERR_NAME_LONG'	=> 'El nombre de la plantilla no puede superar los 30 caracteres.',
	'TEMPLATE_ERR_NOT_TEMPLATE'	=> 'El archivo que especificaste no tiene un juego de plantillas válido.',
	'TEMPLATE_ERR_REQUIRED_OR_INCOMPLETE' => 'El nuevo juego de plantillas requiere que la plantilla %s sea instalada y no herede de si misma.',
	'TEMPLATE_ERR_STYLE_NAME'	=> 'Tienes que proporcionar un nombre para esta plantilla.',
	'TEMPLATE_EXPORT'			=> 'Exportar plantilla',
	'TEMPLATE_EXPORT_EXPLAIN'	=> 'Aquí puedes exportar un juego de plantillas en forma de archivo. Contendrá todos los archivos necesarios para instalar el juego de plantillas en otro Sitio. Tienes que seleccionar si descarga el archivo directamente o ponerlo en la carpeta store para descargarlo más tarde o vía FTP.',
	'TEMPLATE_EXPORTED'			=> 'Plantilla exportada correctamente y guardada en %s.',
	'TEMPLATE_FILE'				=> 'Archivo',
	'TEMPLATE_FILE_UPDATED'		=> 'Archivo exportado correctamente.',
	'TEMPLATE_INHERITS'			=> 'Estos juegos de plantillas heredan de %s y por tanto no pueden tener una configuración de almacenamiento diferente que tu plantilla madre.',
	'TEMPLATE_LOCATION'			=> 'Guardar plantilla en',
	'TEMPLATE_LOCATION_EXPLAIN'	=> 'Las imágenes son siempre guardadas en el sistema.',
	'TEMPLATE_NAME'				=> 'Nombre de la plantilla',
	'TEMPLATE_FILE_NOT_WRITABLE'=> 'No se ha podido escribir en el fichero %s de la plantilla. Por favor comprueba los permisos del directorio y los ficheros.',
	'TEMPLATE_REFRESHED'		=> 'Tema actualizado correctamente.',
	
	'THEME_ADDED'				=> 'Nueva plantilla añadida al sistema.',
	'THEME_ADDED_DB'			=> 'Nueva plantilla añadida a la base de datos.',
	'THEME_CLASS_ADDED'			=> 'Clase personalizada añadida correctamente.',
	'THEME_DELETED'				=> 'Plantilla borrada correctamente.',
	'THEME_DELETED_FS'			=> 'Plantilla eliminada de la base de datos, aunque algunos archivos pueden quedar en el sistema.',
	'THEME_DETAILS_UPDATED'		=> 'Detalles de la plantilla actualizados correctamente.',
	'THEME_EDITOR'				=> 'Editor de plantillas',
	'THEME_EDITOR_HEIGHT'		=> 'Alto del editor',
	'THEME_ERR_ARCHIVE'			=> 'Por favor seleccione un método.',
	'THEME_ERR_CLASS_CHARS'		=> 'Solo caracteres alfanuméricos más ., :, -, _ y # son válidos en nombres de clases.',
	'THEME_ERR_COPY_LONG'		=> 'La plantilla no puede superar los 50 caracteres.',
	'THEME_ERR_NAME_CHARS'		=> 'El nombre de la plantilla solo puede contener caracteres alfanuméricos, -, +, _ y espacio.',
	'THEME_ERR_NAME_EXIST'		=> 'Ya existe una plantilla con ese nombre.',
	'THEME_ERR_NAME_LONG'		=> 'El nombre de la plantilla no puede superar los 30 caracteres.',
	'THEME_ERR_NOT_THEME'		=> 'El archivo que especificaste no tiene una plantilla válida.',
	'THEME_ERR_REFRESH_FS'		=> 'La plantilla está guardada en el sistema así que no hay necesidad de actualizarlo.',
	'THEME_ERR_STYLE_NAME'		=> 'Tiene que proporcionar un nombre para esta plantilla.',
	'THEME_FILE'				=> 'Archivo',
	'THEME_EXPORT'				=> 'Exporte plantilla',
	'THEME_EXPORT_EXPLAIN'		=> 'Aquí puedes exportar una plantilla en forma de archivo. Contendrá todos los archivos necesarios para instalar el juego de plantillas en otro Sitio. Tienes que seleccionar si descarga el archivo directamente o ponerlo en la carpeta store para descargarlo más tarde o vía FTP.',
	'THEME_EXPORTED'			=> 'Plantilla exportada correctamente y guardada en %s.',
	'THEME_LOCATION'			=> 'Guardar plantilla en',
	'THEME_LOCATION_EXPLAIN'	=> 'Las imágenes son guardadas siempre en el sistema.',
	'THEME_NAME'				=> 'Nombre de la plantilla',
	'THEME_REFRESHED'			=> 'Plantilla actualizada correctamente.',
	'THEME_UPDATED'				=> 'Plantilla actualizada correctamente.',
	
	'UNDERLINE'					=> 'Subrayado',
	'UNINSTALLED_IMAGESET'		=> 'Paquetes de imágenes desinstalado',
	'UNINSTALLED_STYLE'			=> 'Estilos desinstalados',
	'UNINSTALLED_TEMPLATE'		=> 'Plantillas desinstaladas',
	'UNINSTALLED_THEME'			=> 'Temas desinstalados',
	'UNSET'						=> 'Indefinido',
	
));

?>