<?php
/**
*
* viewforum [French]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group, (c) Maël Soucaze
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
	'ACTIVE_TOPICS'			=> 'Sujets actifs',
	'ANNOUNCEMENTS'			=> 'Annonce(s)',

	'FORUM_PERMISSIONS'		=> 'Permissions du forum',

	'ICON_ANNOUNCEMENT'		=> 'Annonce',
	'ICON_STICKY'			=> 'Note',

	'LOGIN_NOTIFY_FORUM'	=> 'Vous avez reçu une notification concernant un message de ce forum. Veuillez vous connecter afin de pouvoir le consulter.',

	'MARK_TOPICS_READ'		=> 'Marquer les sujets comme lus',

	'NEW_POSTS_HOT'			=> 'Nouveaux messages [ Populaires ]',	// Not used anymore
	'NEW_POSTS_LOCKED'		=> 'Nouveaux messages [ Verrouillés ]',	// Not used anymore
	'NO_NEW_POSTS_HOT'		=> 'Aucun nouveau message [ Populaire ]',	// Not used anymore
	'NO_NEW_POSTS_LOCKED'	=> 'Aucun nouveau message [ Verrouillé ]',	// Not used anymore
	'NO_READ_ACCESS'		=> 'Vous n’êtes pas autorisé(e) à consulter les sujets de ce forum.',
	'NO_UNREAD_POSTS_HOT'		=> 'Aucun message non lu [ Populaire ]',
	'NO_UNREAD_POSTS_LOCKED'	=> 'Aucun message non lu [ Verrouillé ]',

	'POST_FORUM_LOCKED'		=> 'Le forum est verrouillé',

	'TOPICS_MARKED'			=> 'Les sujets de ce forum ont été marqués comme lus.',

	'UNREAD_POSTS_HOT'		=> 'Messages non lus [ Populaires ]',
	'UNREAD_POSTS_LOCKED'	=> 'Messages non lus [ Verrouillés ]',

	'VIEW_FORUM'			=> 'Consulter le forum',
	'VIEW_FORUM_TOPIC'		=> '1 sujet',
	'VIEW_FORUM_TOPICS'		=> '%d sujet(s)',
));

?>