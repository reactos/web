<?php
/**
*
* acp_ban [Russian]
*
* @package language
* @version $Id: ban.php 9727 2009-07-07 13:33:53Z nickvergessen $
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

// Banning
$lang = array_merge($lang, array(
	'1_HOUR'		=> '1 час',
	'30_MINS'		=> '30 минут',
	'6_HOURS'		=> '6 часов',

	'ACP_BAN_EXPLAIN'	=> 'Здесь вы можете заблокировать доступ пользователей по именам, email или IP-адресам. Эти методы не позволят пользователям попасть ни в один из разделов конференции. При желании вы можете оставить короткую надпись (до 3000 символов) с описанием причины блокировки, которая будет отображаться в логе администратора. Также можно указать её продолжительность. Если вы хотите, чтобы блокировка закончилась в определённый день, а не через установленный промежуток времени, то введите дату в формате <kbd>ГГГГ-ММ-ДД</kbd> под списком «Продолжительность блокировки», предварительно выбрав в этом списке опцию <span style="text-decoration: underline;">До даты</span>.',

	'BAN_EXCLUDE'			=> 'Добавить в белый список',
	'BAN_LENGTH'			=> 'Продолжительность блокировки',
	'BAN_REASON'			=> 'Причина блокировки доступа',
	'BAN_GIVE_REASON'		=> 'Причина, показываемая пользователю',
	'BAN_UPDATE_SUCCESSFUL'	=> 'Чёрный список успешно обновлён.',
	'BANNED_UNTIL_DATE'		=> 'до %s', // Example: "until Mon 13.Jul.2009, 14:44"
	'BANNED_UNTIL_DURATION'	=> '%1$s (до %2$s)', // Example: "7 days (until Tue 14.Jul.2009, 14:44)"

	'EMAIL_BAN'					=> 'Заблокировать один или несколько адресов email',
	'EMAIL_BAN_EXCLUDE_EXPLAIN'	=> 'Исключить введённые адреса email из чёрного списка.',
	'EMAIL_BAN_EXPLAIN'			=> 'Вводите каждый адрес на новой строке. Используйте звёздочку (*) в качестве подстановочного знака для блокировки группы однотипных адресов. Например, <samp>*@mail.ru</samp>, <samp>*@*.domain.tld</samp> и т. д.',
	'EMAIL_NO_BANNED'			=> 'Чёрный список адресов email пуст',
	'EMAIL_UNBAN'				=> 'Вновь разрешить адреса email или удалить адреса из белого списка',
	'EMAIL_UNBAN_EXPLAIN'		=> 'За один раз можно разблокировать (или удалить из белого списка) несколько адресов, выбрав их с помощью соответствующей комбинации мыши и клавиатуры вашего компьютера и браузера. Адреса из белого списка выделены особым цветом.',

	'IP_BAN'					=> 'Заблокировать доступ с одного или нескольких IP-адресов',
	'IP_BAN_EXCLUDE_EXPLAIN'	=> 'Исключить введённые IP-адреса из чёрного списка.',
	'IP_BAN_EXPLAIN'			=> 'Вводите каждый IP-адрес или имя узла на новой строке. Для указания диапазона IP-адресов отделите его начало и конец дефисом (-) или используйте звёздочку (*) в качестве подстановочного знака.',
	'IP_HOSTNAME'				=> 'IP-адреса или хосты',
	'IP_NO_BANNED'				=> 'Чёрный список IP-адресов пуст',
	'IP_UNBAN'					=> 'Разблокировать доступ с адресов IP или удалить адреса из белого списка',
	'IP_UNBAN_EXPLAIN'			=> 'За один раз можно разблокировать (или удалить из белого списка) несколько IP-адресов, выбрав их с помощью соответствующей комбинации мыши и клавиатуры вашего компьютера и браузера. Адреса из белого списка выделены особым цветом.',

	'LENGTH_BAN_INVALID'		=> 'Дата должна быть в формате <kbd>ГГГГ-ММ-ДД</kbd>.',

	'OPTIONS_BANNED'			=> 'Чёрный список',
	'OPTIONS_EXCLUDED'			=> 'Белый список',

	'PERMANENT'		=> 'Бессрочно',

	'UNTIL'						=> 'До даты',
	'USER_BAN'					=> 'Заблокировать доступ одному или нескольким пользователям',
	'USER_BAN_EXCLUDE_EXPLAIN'	=> 'Исключить введённых пользователей из чёрного списка.',
	'USER_BAN_EXPLAIN'			=> 'Вводите каждое имя на новой строке. Используйте ссылку <span style="text-decoration: underline;">Найти пользователя</span> для поиска и автоматического добавления пользователей.',
	'USER_NO_BANNED'			=> 'Чёрный список пользователей пуст',
	'USER_UNBAN'				=> 'Разблокировать доступ пользователям или удалить пользователей из белого списка',
	'USER_UNBAN_EXPLAIN'		=> 'За один раз можно разблокировать (или удалить из белого списка) несколько имён, выбрав их с помощью соответствующей комбинации мыши и клавиатуры вашего компьютера и браузера. Имена из белого списка выделены особым цветом.',
));

?>