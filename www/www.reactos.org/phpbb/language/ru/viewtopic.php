<?php
/**
*
* viewtopic [Russian]
*
* @package language
* @version $Id: viewtopic.php 9972 2009-08-14 08:42:46Z Kellanved $
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

$lang = array_merge($lang, array(
	'ATTACHMENT'						=> 'Вложение',
	'ATTACHMENT_FUNCTIONALITY_DISABLED'	=> 'Функция вложений отключена.',

	'BOOKMARK_ADDED'		=> 'Тема успешно добавлена в закладки.',
	'BOOKMARK_ERR'			=> 'Попытка поместить тему в закладки не удалась. Попробуйте ещё раз.',
	'BOOKMARK_REMOVED'		=> 'Тема успешно удалена из закладок.',
	'BOOKMARK_TOPIC'		=> 'В закладки',
	'BOOKMARK_TOPIC_REMOVE'	=> 'Удалить из закладок',
	'BUMPED_BY'				=> 'Тема поднималась пользователем %1$s %2$s.',
	'BUMP_TOPIC'			=> 'Поднять тему',

	'CODE'					=> 'Код',
	'COLLAPSE_QR'			=> 'Скрыть быстрый ответ',

	'DELETE_TOPIC'			=> 'Удалить тему',
	'DOWNLOAD_NOTICE'		=> 'У вас нет необходимых прав для просмотра вложений в этом сообщении.',

	'EDITED_TIMES_TOTAL'	=> 'Последний раз редактировалось %1$s %2$s, всего редактировалось %3$d раз(а).',
	'EDITED_TIME_TOTAL'		=> 'Последний раз редактировалось %1$s %2$s, всего редактировалось %3$d раз.',
	'EMAIL_TOPIC'			=> 'Сообщить другу',
	'ERROR_NO_ATTACHMENT'	=> 'Выбранного вложения больше не существует.',

	'FILE_NOT_FOUND_404'	=> 'Файл <strong>%s</strong> не существует.',
	'FORK_TOPIC'			=> 'Копировать тему',
	'FULL_EDITOR'			=> 'Стандартный ответ',

	'LINKAGE_FORBIDDEN'		=> 'Вы не авторизованы для просмотра или скачивания файлов.',
	'LOGIN_NOTIFY_TOPIC'	=> 'Вы получили уведомление о новом сообщении в теме. Авторизуйтесь для его просмотра.',
	'LOGIN_VIEWTOPIC'		=> 'Необходимо авторизоваться для просмотра этой темы.',

	'MAKE_ANNOUNCE'				=> 'Сделать объявлением',
	'MAKE_GLOBAL'				=> 'Сделать важной',
	'MAKE_NORMAL'				=> 'Сделать обычной',
	'MAKE_STICKY'				=> 'Сделать прилепленной',
	'MAX_OPTIONS_SELECT'		=> 'Можно выбрать до <strong>%d</strong> вариантов ответа',
	'MAX_OPTION_SELECT'			=> 'Можно выбрать только <strong>1</strong> вариант ответа',
	'MISSING_INLINE_ATTACHMENT'	=> 'Вложение <strong>%s</strong> больше недоступно',
	'MOVE_TOPIC'				=> 'Переместить тему',

	'NO_ATTACHMENT_SELECTED'=> 'Вы не выбрали вложение для скачивания или просмотра.',
	'NO_NEWER_TOPICS'		=> 'В этом форуме нет более новых тем.',
	'NO_OLDER_TOPICS'		=> 'В этом форуме нет более старых тем.',
	'NO_UNREAD_POSTS'		=> 'В этой теме нет новых непрочитанных сообщений.',
	'NO_VOTE_OPTION'		=> 'Необходимо указать вариант ответа при голосовании.',
	'NO_VOTES'				=> 'Голосов нет',

	'POLL_ENDED_AT'			=> 'Опрос закончился %s',
	'POLL_RUN_TILL'			=> 'Опрос проводится до %s',
	'POLL_VOTED_OPTION'		=> 'Вы голосовали за этот вариант',
	'PRINT_TOPIC'			=> 'Версия для печати',

	'QUICK_MOD'				=> 'Быстрые действия',
	'QUICKREPLY'			=> 'Быстрый ответ',
	'QUOTE'					=> 'Цитата',

	'REPLY_TO_TOPIC'		=> 'Ответить на тему',
	'RETURN_POST'			=> '%sВернуться к сообщению%s',

	'SHOW_QR'				=> 'Быстрый ответ',
	'SUBMIT_VOTE'			=> 'Проголосовать',

	'TOTAL_VOTES'			=> 'Всего голосов',

	'UNLOCK_TOPIC'			=> 'Открыть тему',

	'VIEW_INFO'				=> 'Информация о сообщении',
	'VIEW_NEXT_TOPIC'		=> 'След. тема',
	'VIEW_PREVIOUS_TOPIC'	=> 'Пред. тема',
	'VIEW_RESULTS'			=> 'Результаты голосования',
	'VIEW_TOPIC_POST'		=> '1 сообщение',
	'VIEW_TOPIC_POSTS'		=> 'Сообщений: %d',
	'VIEW_UNREAD_POST'		=> 'Первое новое сообщение',
	'VISIT_WEBSITE'			=> 'WWW',
	'VOTE_SUBMITTED'		=> 'Спасибо, ваш голос учтён.',
	'VOTE_CONVERTED'		=> 'Изменение голосов в сконвертированных опросах не поддерживается.',

));

?>