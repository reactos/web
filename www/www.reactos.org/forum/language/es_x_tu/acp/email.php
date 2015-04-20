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
* acp_email.php [Spanish [Es]]
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
	'ACP_MASS_EMAIL_EXPLAIN'	=> 'Aquí puedes enviar un email a todos los usuarios, o a los usuarios de un grupo específico. Para esto se enviará un email a la dirección administrativa proporcionada, con copia oculta a todos los receptores. Si el grupo de personas es muy grande, por favor se paciente después de pulsar en "Enviar" y no detengas el proceso por la mitad. Es normal que enviar un email masivo lleve algún tiempo, serás notificado cuando se complete el proceso',
	'ALL_USERS'					=> 'Todos los usuarios',

	'COMPOSE'					=> 'Escribir',

	'EMAIL_SEND_ERROR'			=> 'Hubo uno o más errores mientras enviabas el email. Por favor verifica el %1$sLog de Errores%2$s para más detalles.',
	'EMAIL_SENT'				=> 'El mensaje ha sido enviado.',
	'EMAIL_SENT_QUEUE'			=> 'El mensaje ha sido aceptado para tu envio.',

	'LOG_SESSION'				=> 'Registrar sesión de email en Registro de errores',

	'SEND_IMMEDIATELY'			=> 'Enviar de inmediato',
	'SEND_TO_GROUP'				=> 'Enviar a grupo',
	'SEND_TO_USERS'				=> 'Enviar a usuarios',
	'SEND_TO_USERS_EXPLAIN'		=> 'Introducir nombres aquí invalida cualquier grupo seleccionado arriba. Introduce cada nombre de usuario en una nueva línea.',

	'MAIL_BANNED'			=> 'Email a usuarios excluidos',
	'MAIL_BANNED_EXPLAIN'	=> 'Cuando se envía un correo electrónico masivo a un grupo se puede elegir si los usuarios excluidos recibirán el email.',
	'MAIL_HIGH_PRIORITY'		=> 'Alta',
	'MAIL_LOW_PRIORITY'			=> 'Baja',
	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
	'MAIL_PRIORITY'				=> 'Prioridad',
	'MASS_MESSAGE'				=> 'Tu mensaje',
	'MASS_MESSAGE_EXPLAIN'		=> 'Por favor ten en cuenta que solo puede insertarse texto plano. Se eliminará cualquier código antes de enviar.',

	'NO_EMAIL_MESSAGE'			=> 'Tienes que introducir un mensaje.',
	'NO_EMAIL_SUBJECT'			=> 'Tienes que especificar un tema para tu mensaje.',
));

?>