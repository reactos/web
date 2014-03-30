<?php
/**
*
* acp_email [Russian]
*
* @package language
* @version $Id: email.php,v 1.16 2007/10/04 15:07:24 acydburn Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

// Email settings
$lang = array_merge($lang, array(
	'ACP_MASS_EMAIL_EXPLAIN'		=> 'С помощью этой формы вы можете отправить электронное сообщение всем пользователям или пользователям определённой группы, <strong>имеющим включённую опцию получения электронных сообщений</strong>. Для достижения этого сообщение будет отправлено с электронного адреса администратора и будет снабжено скрытой копией для всех получателей. По умолчанию такое сообщение включает максимум 50 получателей. Если получателей больше, то будет отправлено несколько сообщений. Если вы отправляете сообщение большой группе людей, то это действие может занять некоторое время. Пожалуйста, будьте терпеливы и не останавливайте загрузку страницы после отправки сообщения. Вы будете уведомлены об успешном завершении отправки.',
	'ALL_USERS'						=> 'Всем пользователям',

	'COMPOSE'				=> 'Сообщение',

	'EMAIL_SEND_ERROR'		=> 'Произошли ошибки во время отправки сообщения. Посмотрите %sлог ошибок%s для получения более подробных сведений об ошибках.',
	'EMAIL_SENT'			=> 'Сообщение отправлено.',
	'EMAIL_SENT_QUEUE'		=> 'Сообщение поставлено в очередь для последующей отправки.',

	'LOG_SESSION'			=> 'Вести лог критических ошибок сеанса рассылки',

	'SEND_IMMEDIATELY'		=> 'Немедленная отправка',
	'SEND_TO_GROUP'			=> 'Отправить участникам группы',
	'SEND_TO_USERS'			=> 'Отправить пользователям',
	'SEND_TO_USERS_EXPLAIN'	=> 'Сообщение будет отправлено указанным пользователям вместо выбранной выше группы. Вводите каждое имя пользователя на новой строке.',

	'MAIL_BANNED'			=> 'Отправить заблокированным пользователям',
	'MAIL_BANNED_EXPLAIN'	=> 'При массовой рассылке группе данная настройка определяет, будут ли email-сообщения отправлены заблокированным пользователям.',
	'MAIL_HIGH_PRIORITY'	=> 'Высокий',
	'MAIL_LOW_PRIORITY'		=> 'Низкий',
	'MAIL_NORMAL_PRIORITY'	=> 'Обычный',
	'MAIL_PRIORITY'			=> 'Приоритет рассылки',
	'MASS_MESSAGE'			=> 'Текст сообщения',
	'MASS_MESSAGE_EXPLAIN'	=> 'Можно использовать только обычный текст. Вся разметка будет удалена перед отправкой.',

	'NO_EMAIL_MESSAGE'		=> 'Необходимо ввести текст сообщения',
	'NO_EMAIL_SUBJECT'		=> 'Необходимо указать заголовок сообщения',
));

?>