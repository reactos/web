<?php
/**
*
* memberlist [Russian]
*
* @package language
* @version $Id: memberlist.php 9933 2009-08-06 09:12:21Z marshalrusty $
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
	'ABOUT_USER'			=> 'Профиль',
	'ACTIVE_IN_FORUM'		=> 'Наиболее активен в форуме',
	'ACTIVE_IN_TOPIC'		=> 'Наиболее активен в теме',
	'ADD_FOE'				=> 'Добавить в недруги',
	'ADD_FRIEND'			=> 'Добавить в друзья',
	'AFTER'					=> 'после',

	'ALL'					=> 'Все',

	'BEFORE'				=> 'до',

	'CC_EMAIL'				=> 'Выслать мне копию этого сообщения.',
	'CONTACT_USER'			=> 'Контактная информация',

	'DEST_LANG'				=> 'Язык',
	'DEST_LANG_EXPLAIN'		=> 'Выберите язык получателя сообщения (если доступен).',

	'EMAIL_BODY_EXPLAIN'	=> 'Сообщение будет отправлено в виде простого текста, не включайте в него HTML или BBCode. В качестве обратного адреса будет показываться ваш адрес email.',
	'EMAIL_DISABLED'		=> 'Извините, но все функции, связанные с отправкой email, были отключены.',
	'EMAIL_SENT'			=> 'Сообщение было отправлено.',
	'EMAIL_TOPIC_EXPLAIN'	=> 'Сообщение будет отправлено в виде простого текста, не включайте в него HTML или BBCode. Обратите внимание, что информация о теме уже включена в сообщение. В качестве обратного адреса будет показываться ваш адрес email.',
	'EMPTY_ADDRESS_EMAIL'	=> 'Вы должны указать правильный адрес email получателя.',
	'EMPTY_MESSAGE_EMAIL'	=> 'Вы должны ввести текст сообщения для отправки.',
	'EMPTY_MESSAGE_IM'		=> 'Вы должны ввести текст сообщения для отправки.',
	'EMPTY_NAME_EMAIL'		=> 'Вы должны ввести настоящее имя получателя.',
	'EMPTY_SUBJECT_EMAIL'	=> 'Вы должны указать тему сообщения.',
	'EQUAL_TO'				=> 'равно',

	'FIND_USERNAME_EXPLAIN'	=> 'Здесь вы можете осуществить поиск конкретных пользователей. Не обязательно заполнять все поля. Для поиска по шаблону используйте *. При вводе дат применяйте формат <kbd>ГГГГ-ММ-ДД</kbd>, например, <samp>2004-02-29</samp>. Отметьте галочкой одного или более пользователей (если предыдущая форма допускает множественный выбор) и нажмите кнопку «Выбрать отмеченных», чтобы вернуться назад.',
	'FLOOD_EMAIL_LIMIT'		=> 'Вы не можете отправить ещё один email сразу после предыдущего. Пожалуйста, попробуйте чуть позже.',

	'GROUP_LEADER'			=> 'Лидер группы',

	'HIDE_MEMBER_SEARCH'	=> 'Скрыть поиск пользователей',

	'IM_ADD_CONTACT'		=> 'Добавить в список контактов',
	'IM_AIM'				=> 'Учтите, что для этого вам необходима установленная программа AOL Instant Messenger.',
	'IM_AIM_EXPRESS'		=> 'AIM Express',
	'IM_DOWNLOAD_APP'		=> 'Скачать приложение',
	'IM_ICQ'				=> 'Учтите, что пользователь мог отключить приём мгновенных сообщений от неизвестных контактов.',
	'IM_JABBER'				=> 'Учтите, что пользователь мог отключить приём мгновенных сообщений от неизвестных контактов.',
	'IM_JABBER_SUBJECT'		=> 'Это автоматически сгенерированное сообщение, на него не надо отвечать! Сообщение от пользователя %1$s с %2$s.',
	'IM_MESSAGE'			=> 'Ваше сообщение',
	'IM_MSNM'				=> 'Учтите, что для этого вам необходима установленная программа Windows Messenger.',
	'IM_MSNM_BROWSER'		=> 'Ваш браузер не поддерживает эту функцию.',
	'IM_MSNM_CONNECT'		=> 'Клиент MSNM не отвечает.\nДля продолжения необходимо установить связь с клиентом.',
	'IM_NAME'				=> 'Ваше имя',
	'IM_NO_DATA'			=> 'Для этого пользователя отсутствует контактная информация.',
	'IM_NO_JABBER'			=> 'Извините, отправка напрямую сообщений пользователям Jabber не поддерживается конференцией. Чтобы связаться с этим пользователем, вам необходимо воспользоваться клиентом Jabber.',
	'IM_RECIPIENT'			=> 'Получатель',
	'IM_SEND'				=> 'Отправить сообщение',
	'IM_SEND_MESSAGE'		=> 'Отправить сообщение',
	'IM_SENT_JABBER'		=> 'Ваше сообщение для %1$s было успешно отправлено.',
	'IM_USER'				=> 'Отправить мгновенное сообщение',

	'LAST_ACTIVE'				=> 'Последнее посещение',
	'LESS_THAN'					=> 'меньше',
	'LIST_USER'					=> 'Пользователей: 1',
	'LIST_USERS'				=> 'Пользователей: %d',
	'LOGIN_EXPLAIN_LEADERS'		=> 'Для просмотра списка нашей команды вы должны быть авторизованы.',
	'LOGIN_EXPLAIN_MEMBERLIST'	=> 'Для просмотра списка пользователей вы должны быть авторизованы.',
	'LOGIN_EXPLAIN_SEARCHUSER'	=> 'Для поиска пользователей вы должны быть авторизованы.',
	'LOGIN_EXPLAIN_VIEWPROFILE'	=> 'Для просмотра профилей вы должны быть авторизованы.',

	'MORE_THAN'				=> 'больше',

	'NO_EMAIL'				=> 'Вам не разрешено посылать email этому пользователю.',
	'NO_VIEW_USERS'			=> 'У вас нет доступа к списку пользователей.',

	'ORDER'					=> 'Упорядочить',
	'OTHER'					=> 'Другая',

	'POST_IP'				=> 'IP/Хост',

	'REAL_NAME'				=> 'Имя получателя',
	'RECIPIENT'				=> 'Получатель',
	'REMOVE_FOE'			=> 'Убрать из недругов',
	'REMOVE_FRIEND'			=> 'Убрать из друзей',

	'SELECT_MARKED'			=> 'Выбрать отмеченных',
	'SELECT_SORT_METHOD'	=> 'Поле сортировки',
	'SEND_AIM_MESSAGE'		=> 'Отправить AIM-сообщение',
	'SEND_ICQ_MESSAGE'		=> 'Отправить ICQ-сообщение',
	'SEND_IM'				=> 'Отправить мгновенное сообщение',
	'SEND_JABBER_MESSAGE'	=> 'Отправить Jabber-сообщение',
	'SEND_MESSAGE'			=> 'Отправить',
	'SEND_MSNM_MESSAGE'		=> 'Отправить MSNM/WLM-сообщение',
	'SEND_YIM_MESSAGE'		=> 'Отправить YIM-сообщение',
	'SORT_EMAIL'			=> 'email',
	'SORT_LAST_ACTIVE'		=> 'Последнее посещение',
	'SORT_POST_COUNT'		=> 'Число сообщений',

	'USERNAME_BEGINS_WITH'	=> 'Имя пользователя начинается с',
	'USER_ADMIN'			=> 'Администрировать',
	'USER_BAN'				=> 'Блокировка',
	'USER_FORUM'			=> 'Статистика пользователя',
	'USER_LAST_REMINDED'	=> array(
		0		=> 'Нет напоминаний, отправленных в это время',
		1		=> 'Отправлено %1$d напоминание<br />» %2$s',
	),
	'USER_ONLINE'			=> 'В сети',
	'USER_PRESENCE'			=> 'Присутствие на конференции',

	'VIEWING_PROFILE'		=> 'Профиль пользователя %s',
	'VISITED'				=> 'Последнее посещение',

	'WWW'					=> 'Сайт',
));

?>