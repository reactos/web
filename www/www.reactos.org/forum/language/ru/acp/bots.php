<?php
/**
*
* acp_bots [Russian]
*
* @package language
* @version $Id: bots.php,v 1.12 2007/10/04 15:07:24 acydburn Exp $
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

// Bot settings
$lang = array_merge($lang, array(
	'BOTS'				=> 'Управление поисковыми роботами (ботами)',
	'BOTS_EXPLAIN'		=> '«Боты», «пауки» или «ползуны»  — это автоматические агенты, обычно используемые поисковыми системами для обновления своих баз данных. Поскольку они редко должным образом работают с сессиями, они могут исказить счётчики посещений, увеличить нагрузку на сервер и иногда неправильно проиндексировать сайт. Здесь вы можете создать пользователей особого типа в целях предотвращения подобных проблем.',
	'BOT_ACTIVATE'		=> 'Включить',
	'BOT_ACTIVE'		=> 'Бот активен',
	'BOT_ADD'			=> 'Добавить бота',
	'BOT_ADDED'			=> 'Новый бот успешно добавлен.',
	'BOT_AGENT'			=> 'Соответствие агенту',
	'BOT_AGENT_EXPLAIN'	=> 'Строка, полностью или частично совпадающая с агентом (User-Agent) бота.',
	'BOT_DEACTIVATE'	=> 'Отключить',
	'BOT_DELETED'		=> 'Бот успешно удалён.',
	'BOT_EDIT'			=> 'Настройка бота',
	'BOT_EDIT_EXPLAIN'	=> 'С помощью этой страницы вы можете добавить нового или изменить настройки имеющегося бота. Вы можете указать строку агента бота и ввести один или несколько IP-адресов (или диапазон адресов) для его идентификации. Будьте внимательны при указании строки агента или адресов. Также здесь можно указать стиль и язык конференции, которые будет использовать бот. Это поможет снизить использование трафика путём установки облегчённого стиля для ботов. Не забудьте настроить подходящие права доступа для специальной группы «Боты».',
	'BOT_LANG'			=> 'Язык для бота',
	'BOT_LANG_EXPLAIN'	=> 'Язык конференции, используемый ботом при посещении.',
	'BOT_LAST_VISIT'	=> 'Посещение',
	'BOT_IP'			=> 'IP-адрес бота',
	'BOT_IP_EXPLAIN'	=> 'Разрешены частичные соответствия. Отделяйте адреса запятыми.',
	'BOT_NAME'			=> 'Название бота',
	'BOT_NAME_EXPLAIN'	=> 'Используется исключительно для вашего сведения.',
	'BOT_NAME_TAKEN'	=> 'Указанное имя уже используется на конференции и не может использоваться для бота.',
	'BOT_NEVER'			=> 'Никогда',
	'BOT_STYLE'			=> 'Стиль для бота',
	'BOT_STYLE_EXPLAIN'	=> 'Стиль конференции, используемый ботом при посещении.',
	'BOT_UPDATED'		=> 'Настройки бота успешно обновлены.',

	'ERR_BOT_AGENT_MATCHES_UA'	=> 'Введённый вами агент бота уже используется.',
	'ERR_BOT_NO_IP'				=> 'Введённые вами IP-адреса недопустимы или не удаётся разрешить имя хоста.',
	'ERR_BOT_NO_MATCHES'		=> 'Необходимо указать не менее одного агента или IP-адреса для идентификации этого бота.',

	'NO_BOT'		=> 'Бот с указанным идентификатором не найден.',
	'NO_BOT_GROUP'	=> 'Специальная группа «Боты» не найдена.',
));

?>