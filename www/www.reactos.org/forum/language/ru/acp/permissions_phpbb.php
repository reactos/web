<?php
/**
* acp_permissions (phpBB Permission Set) [Russian]
*
* @package language
* @version $Id: permissions_phpbb.php 9686 2009-06-26 11:52:54Z rxu $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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

/**
*	MODDERS PLEASE NOTE
*
*	You are able to put your permission sets into a separate file too by
*	prefixing the new file with permissions_ and putting it into the acp
*	language folder.
*
*	An example of how the file could look like:
*
*	<code>
*
*	if (empty($lang) || !is_array($lang))
*	{
*		$lang = array();
*	}
*
*	// Adding new category
*	$lang['permission_cat']['bugs'] = 'Bugs';
*
*	// Adding new permission set
*	$lang['permission_type']['bug_'] = 'Bug Permissions';
*
*	// Adding the permissions
*	$lang = array_merge($lang, array(
*		'acl_bug_view'		=> array('lang' => 'Can view bug reports', 'cat' => 'bugs'),
*		'acl_bug_post'		=> array('lang' => 'Can post bugs', 'cat' => 'post'), // Using a phpBB category here
*	));
*
*	</code>
*/

// Define categories and permission types
$lang = array_merge($lang, array(
	'permission_cat'	=> array(
		'actions'		=> 'Действия',
		'content'		=> 'Содержимое',
		'forums'		=> 'Форумы',
		'misc'			=> 'Разное',
		'permissions'	=> 'Права доступа',
		'pm'			=> 'Личные сообщения',
		'polls'			=> 'Опросы',
		'post'			=> 'Размещение сообщений',
		'post_actions'	=> 'Действия с сообщениями',
		'posting'		=> 'Сообщения',
		'profile'		=> 'Профиль',
		'settings'		=> 'Установки',
		'topic_actions'	=> 'Действия с темами',
		'user_group'	=> 'Пользователи',
	),

	// With defining 'global' here we are able to specify what is printed out if the permission is within the global scope.
	'permission_type'	=> array(
		'u_'			=> 'Права доступа пользователя',
		'a_'			=> 'Права доступа администратора',
		'm_'			=> 'Права доступа модератора',
		'f_'			=> 'Права доступа для форума',
		'global'		=> array(
			'm_'			=> 'Глобальные права модератора',
		),
	),
));

// User Permissions
$lang = array_merge($lang, array(
	'acl_u_viewprofile'	=> array('lang' => 'Может просматривать профили, список пользователей и страницу «Кто сейчас на конференции»', 'cat' => 'profile'),
	'acl_u_chgname'		=> array('lang' => 'Может менять имя', 'cat' => 'profile'),
	'acl_u_chgpasswd'	=> array('lang' => 'Может менять пароль', 'cat' => 'profile'),
	'acl_u_chgemail'	=> array('lang' => 'Может менять email-адрес', 'cat' => 'profile'),
	'acl_u_chgavatar'	=> array('lang' => 'Может менять аватару', 'cat' => 'profile'),
	'acl_u_chggrp'		=> array('lang' => 'Может менять группу по умолчанию', 'cat' => 'profile'),

	'acl_u_attach'		=> array('lang' => 'Может прикреплять вложения', 'cat' => 'post'),
	'acl_u_download'	=> array('lang' => 'Может скачивать файлы', 'cat' => 'post'),
	'acl_u_savedrafts'	=> array('lang' => 'Может сохранять черновики', 'cat' => 'post'),
	'acl_u_chgcensors'	=> array('lang' => 'Может отключать автоцензора', 'cat' => 'post'),
	'acl_u_sig'			=> array('lang' => 'Может использовать подпись', 'cat' => 'post'),

	'acl_u_sendpm'		=> array('lang' => 'Может посылать ЛС', 'cat' => 'pm'),
	'acl_u_masspm'		=> array('lang' => 'Может рассылать ЛС нескольким пользователям', 'cat' => 'pm'),
	'acl_u_masspm_group'=> array('lang' => 'Может рассылать ЛС группам пользователей', 'cat' => 'pm'),
	'acl_u_readpm'		=> array('lang' => 'Может читать ЛС', 'cat' => 'pm'),
	'acl_u_pm_edit'		=> array('lang' => 'Может редактировать собственные ЛС', 'cat' => 'pm'),
	'acl_u_pm_delete'	=> array('lang' => 'Может удалять ЛС из своих папок', 'cat' => 'pm'),
	'acl_u_pm_forward'	=> array('lang' => 'Может пересылать ЛС', 'cat' => 'pm'),
	'acl_u_pm_emailpm'	=> array('lang' => 'Может отправлять ЛС по email', 'cat' => 'pm'),
	'acl_u_pm_printpm'	=> array('lang' => 'Может распечатывать ЛС', 'cat' => 'pm'),
	'acl_u_pm_attach'	=> array('lang' => 'Может прикреплять вложения в ЛС', 'cat' => 'pm'),
	'acl_u_pm_download'	=> array('lang' => 'Может скачивать файлы из ЛС', 'cat' => 'pm'),
	'acl_u_pm_bbcode'	=> array('lang' => 'Может использовать BBCode в ЛС', 'cat' => 'pm'),
	'acl_u_pm_smilies'	=> array('lang' => 'Может использовать смайлики в ЛС', 'cat' => 'pm'),
	'acl_u_pm_img'		=> array('lang' => 'Может использовать тег [img] в ЛС', 'cat' => 'pm'),
	'acl_u_pm_flash'	=> array('lang' => 'Может использовать тег [flash] в ЛС', 'cat' => 'pm'),

	'acl_u_sendemail'	=> array('lang' => 'Может посылать email-сообщения', 'cat' => 'misc'),
	'acl_u_sendim'		=> array('lang' => 'Может использовать систему мгновенных сообщений', 'cat' => 'misc'),
	'acl_u_ignoreflood'	=> array('lang' => 'Может игнорировать флуд-контроль', 'cat' => 'misc'),
	'acl_u_hideonline'	=> array('lang' => 'Может прятать статус присутствия', 'cat' => 'misc'),
	'acl_u_viewonline'	=> array('lang' => 'Может видеть статус присутствия', 'cat' => 'misc'),
	'acl_u_search'		=> array('lang' => 'Может использовать поиск', 'cat' => 'misc'),
));

// Forum Permissions
$lang = array_merge($lang, array(
	'acl_f_list'		=> array('lang' => 'Может видеть форум', 'cat' => 'post'),
	'acl_f_read'		=> array('lang' => 'Может читать форум', 'cat' => 'post'),
	'acl_f_post'		=> array('lang' => 'Может создавать темы', 'cat' => 'post'),
	'acl_f_reply'		=> array('lang' => 'Может отвечать в темах', 'cat' => 'post'),
	'acl_f_icons'		=> array('lang' => 'Может использовать значки тем и сообщений', 'cat' => 'post'),
	'acl_f_announce'	=> array('lang' => 'Может создавать объявления', 'cat' => 'post'),
	'acl_f_sticky'		=> array('lang' => 'Может прилеплять темы', 'cat' => 'post'),

	'acl_f_poll'		=> array('lang' => 'Может создавать опросы', 'cat' => 'polls'),
	'acl_f_vote'		=> array('lang' => 'Может голосовать в опросах', 'cat' => 'polls'),
	'acl_f_votechg'		=> array('lang' => 'Может переголосовать', 'cat' => 'polls'),

	'acl_f_attach'		=> array('lang' => 'Может прикреплять вложения', 'cat' => 'content'),
	'acl_f_download'	=> array('lang' => 'Может скачивать файлы', 'cat' => 'content'),
	'acl_f_sigs'		=> array('lang' => 'Может использовать подпись', 'cat' => 'content'),
	'acl_f_bbcode'		=> array('lang' => 'Может использовать BBCode', 'cat' => 'content'),
	'acl_f_smilies'		=> array('lang' => 'Может использовать смайлики', 'cat' => 'content'),
	'acl_f_img'			=> array('lang' => 'Может использовать тег [img]', 'cat' => 'content'),
	'acl_f_flash'		=> array('lang' => 'Может использовать тег [flash]', 'cat' => 'content'),

	'acl_f_edit'		=> array('lang' => 'Может редактировать собственные сообщения', 'cat' => 'actions'),
	'acl_f_delete'		=> array('lang' => 'Может удалять собственные сообщения', 'cat' => 'actions'),
	'acl_f_user_lock'	=> array('lang' => 'Может закрывать свои темы', 'cat' => 'actions'),
	'acl_f_bump'		=> array('lang' => 'Может поднимать темы', 'cat' => 'actions'),
	'acl_f_report'		=> array('lang' => 'Может размещать жалобы', 'cat' => 'actions'),
	'acl_f_subscribe'	=> array('lang' => 'Может подписываться на форумы', 'cat' => 'actions'),
	'acl_f_print'		=> array('lang' => 'Может распечатывать темы', 'cat' => 'actions'),
	'acl_f_email'		=> array('lang' => 'Может сообщать (другу) по email о теме', 'cat' => 'actions'),

	'acl_f_search'		=> array('lang' => 'Может использовать поиск в форуме', 'cat' => 'misc'),
	'acl_f_ignoreflood' => array('lang' => 'Может игнорировать флуд-контроль', 'cat' => 'misc'),
	'acl_f_postcount'	=> array('lang' => 'Счётчик сообщений включён<br /><em>Учтите, что данная установка эффективна только при создании новых сообщений.</em>', 'cat' => 'misc'),
	'acl_f_noapprove'	=> array('lang' => 'Может размещать сообщения без одобрения', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
	'acl_m_edit'		=> array('lang' => 'Может редактировать сообщения', 'cat' => 'post_actions'),
	'acl_m_delete'		=> array('lang' => 'Может удалять сообщения', 'cat' => 'post_actions'),
	'acl_m_approve'		=> array('lang' => 'Может одобрять сообщения', 'cat' => 'post_actions'),
	'acl_m_report'		=> array('lang' => 'Может закрывать и удалять жалобы', 'cat' => 'post_actions'),
	'acl_m_chgposter'	=> array('lang' => 'Может менять автора сообщений', 'cat' => 'post_actions'),

	'acl_m_move'	=> array('lang' => 'Может перемещать темы', 'cat' => 'topic_actions'),
	'acl_m_lock'	=> array('lang' => 'Может закрывать темы', 'cat' => 'topic_actions'),
	'acl_m_split'	=> array('lang' => 'Может разделять темы', 'cat' => 'topic_actions'),
	'acl_m_merge'	=> array('lang' => 'Может объединять темы', 'cat' => 'topic_actions'),

	'acl_m_info'	=> array('lang' => 'Может просматривать подробности о сообщениях', 'cat' => 'misc'),
	'acl_m_warn'	=> array('lang' => 'Может объявлять предупреждения<br /><em>Это право может быть назначено только глобально, а не на уровне форумов.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
	'acl_m_ban'		=> array('lang' => 'Может управлять блокировкой<br /><em>Это право может быть назначено только глобально, а не на уровне форумов.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
));

// Admin Permissions
$lang = array_merge($lang, array(
	'acl_a_board'		=> array('lang' => 'Может изменять настройки конференции и проверять обновления', 'cat' => 'settings'),
	'acl_a_server'		=> array('lang' => 'Может изменять параметры настройки сервера', 'cat' => 'settings'),
	'acl_a_jabber'		=> array('lang' => 'Может изменять настройки Jabber', 'cat' => 'settings'),
	'acl_a_phpinfo'		=> array('lang' => 'Может просматривать сведения о php', 'cat' => 'settings'),

	'acl_a_forum'		=> array('lang' => 'Может управлять форумами', 'cat' => 'forums'),
	'acl_a_forumadd'	=> array('lang' => 'Может создавать форумы', 'cat' => 'forums'),
	'acl_a_forumdel'	=> array('lang' => 'Может удалять форумы', 'cat' => 'forums'),
	'acl_a_prune'		=> array('lang' => 'Может очищать форумы', 'cat' => 'forums'),

	'acl_a_icons'		=> array('lang' => 'Может изменять значки тем, сообщений и смайлики', 'cat' => 'posting'),
	'acl_a_words'		=> array('lang' => 'Может настраивать автоцензор', 'cat' => 'posting'),
	'acl_a_bbcode'		=> array('lang' => 'Может определять BBCode', 'cat' => 'posting'),
	'acl_a_attach'		=> array('lang' => 'Может изменять настройки вложений', 'cat' => 'posting'),

	'acl_a_user'		=> array('lang' => 'Может управлять пользователями<br /><em>Право также включает просмотр типа браузера пользователей в списке находящихся на конференции.</em>', 'cat' => 'user_group'),
	'acl_a_userdel'		=> array('lang' => 'Может удалять пользователей', 'cat' => 'user_group'),
	'acl_a_group'		=> array('lang' => 'Может управлять группами', 'cat' => 'user_group'),
	'acl_a_groupadd'	=> array('lang' => 'Может создавать группы', 'cat' => 'user_group'),
	'acl_a_groupdel'	=> array('lang' => 'Может удалять группы', 'cat' => 'user_group'),
	'acl_a_ranks'		=> array('lang' => 'Может управлять званиями', 'cat' => 'user_group'),
	'acl_a_profile'		=> array('lang' => 'Может управлять дополнительными полями профиля', 'cat' => 'user_group'),
	'acl_a_names'		=> array('lang' => 'Может управлять запрещёнными именами', 'cat' => 'user_group'),
	'acl_a_ban'			=> array('lang' => 'Может управлять блокировкой', 'cat' => 'user_group'),

	'acl_a_viewauth'	=> array('lang' => 'Может просматривать права доступа', 'cat' => 'permissions'),
	'acl_a_authgroups'	=> array('lang' => 'Может изменять права доступа для конкретной группы', 'cat' => 'permissions'),
	'acl_a_authusers'	=> array('lang' => 'Может изменять права доступа для конкретного пользователя', 'cat' => 'permissions'),
	'acl_a_fauth'		=> array('lang' => 'Может изменять права доступа в форумах', 'cat' => 'permissions'),
	'acl_a_mauth'		=> array('lang' => 'Может изменять права доступа для модераторов', 'cat' => 'permissions'),
	'acl_a_aauth'		=> array('lang' => 'Может изменять права доступа для администраторов', 'cat' => 'permissions'),
	'acl_a_uauth'		=> array('lang' => 'Может изменять права доступа для пользователей', 'cat' => 'permissions'),
	'acl_a_roles'		=> array('lang' => 'Может управлять ролями', 'cat' => 'permissions'),
	'acl_a_switchperm'	=> array('lang' => 'Может изменять другие права доступа', 'cat' => 'permissions'),

	'acl_a_styles'		=> array('lang' => 'Может управлять стилями', 'cat' => 'misc'),
	'acl_a_viewlogs'	=> array('lang' => 'Может просматривать логи', 'cat' => 'misc'),
	'acl_a_clearlogs'	=> array('lang' => 'Может очищать логи', 'cat' => 'misc'),
	'acl_a_modules'		=> array('lang' => 'Может управлять модулями', 'cat' => 'misc'),
	'acl_a_language'	=> array('lang' => 'Может управлять языковыми пакетами', 'cat' => 'misc'),
	'acl_a_email'		=> array('lang' => 'Может осуществлять массовую рассылку почты', 'cat' => 'misc'),
	'acl_a_bots'		=> array('lang' => 'Может управлять ботами', 'cat' => 'misc'),
	'acl_a_reasons'		=> array('lang' => 'Может управлять списком жалоб/причин', 'cat' => 'misc'),
	'acl_a_backup'		=> array('lang' => 'Может сохранять/восстанавливать базу данных', 'cat' => 'misc'),
	'acl_a_search'		=> array('lang' => 'Может управлять поисковыми индексами/установками поиска', 'cat' => 'misc'),
));

?>