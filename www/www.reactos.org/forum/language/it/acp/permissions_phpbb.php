<?php
/**
* acp_permissions_phpbb (phpBB Permission Set) [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-03-01
* @copyright (c) 2011 phpBBItalia.net - translated on 2011-06-15
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
		'actions'		=> 'Azioni',
		'content'		=> 'Contenuti',
		'forums'		=> 'Forum',
		'misc'			=> 'Misti',
		'permissions'	=> 'Permessi',
		'pm'			=> 'Messaggi privati',
		'polls'			=> 'Sondaggi',
		'post'			=> 'Messaggio',
		'post_actions'	=> 'Azioni messaggio',
		'posting'		=> 'Inserire',
		'profile'		=> 'Profilo',
		'settings'		=> 'Impostazioni',
		'topic_actions'	=> 'Azioni argomento',
		'user_group'	=> 'Utenti &amp; Gruppi',
	),

	// With defining 'global' here we are able to specify what is printed out if the permission is within the global scope.
	'permission_type'	=> array(
		'u_'			=> 'Permessi utente',
		'a_'			=> 'Permessi di amministrazione',
		'm_'			=> 'Permessi moderatore',
		'f_'			=> 'Permessi forum',
		'global'		=> array(
 		'm_'			=> 'Permessi moderatore globale',
		),
	),
));

// User Permissions
$lang = array_merge($lang, array(
	'acl_u_viewprofile'	=> array('lang' => 'Può vedere profili, lista utenti e utenti online', 'cat' => 'profile'),
	'acl_u_chgname'		=> array('lang' => 'Può cambiare nome utente', 'cat' => 'profile'),
	'acl_u_chgpasswd'	=> array('lang' => 'Può cambiare password', 'cat' => 'profile'),
	'acl_u_chgemail'	=> array('lang' => 'Può cambiare indirizzo e-mail', 'cat' => 'profile'),
	'acl_u_chgavatar'	=> array('lang' => 'Può cambiare avatar', 'cat' => 'profile'),
	'acl_u_chggrp'		=> array('lang' => 'Può cambiare gruppo predefinito', 'cat' => 'profile'),

	'acl_u_attach'		=> array('lang' => 'Può inserire allegati', 'cat' => 'post'),
	'acl_u_download'	=> array('lang' => 'Può scaricare file', 'cat' => 'post'),
	'acl_u_savedrafts'	=> array('lang' => 'Può salvare bozze', 'cat' => 'post'),
	'acl_u_chgcensors'	=> array('lang' => 'Può disabilitare censura parole', 'cat' => 'post'),
	'acl_u_sig'			=> array('lang' => 'Può utilizzare firma', 'cat' => 'post'),

	'acl_u_sendpm'		=> array('lang' => 'Può inviare messaggi privati', 'cat' => 'pm'),
	'acl_u_masspm'		=> array('lang' => 'Può inviare messaggi multipli', 'cat' => 'pm'),
	'acl_u_masspm_group'=> array('lang' => 'Può inviare messaggi ai gruppi', 'cat' => 'pm'),
	'acl_u_readpm'		=> array('lang' => 'Può leggere messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_edit'		=> array('lang' => 'Può modificare i suoi messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_delete'	=> array('lang' => 'Può rimuovere i messaggi privati dalla casella', 'cat' => 'pm'),
	'acl_u_pm_forward'	=> array('lang' => 'Può inoltrare messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_emailpm'	=> array('lang' => 'Può inviare messaggi privati via e-mail', 'cat' => 'pm'),
	'acl_u_pm_printpm'	=> array('lang' => 'Può stampare messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_attach'	=> array('lang' => 'Può allegare file nei messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_download'	=> array('lang' => 'Può scaricare file nei messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_bbcode'	=> array('lang' => 'Può inserire BBCode nei messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_smilies'	=> array('lang' => 'Può inserire emoticon nei messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_img'		=> array('lang' => 'Può inserire immagini nei messaggi privati', 'cat' => 'pm'),
	'acl_u_pm_flash'	=> array('lang' => 'Può inserire file flash nei messaggi privati', 'cat' => 'pm'),
	'acl_u_sendemail'	=> array('lang' => 'Può spedire e-mail', 'cat' => 'misc'),
	'acl_u_sendim'		=> array('lang' => 'Può spedire messaggi istantanei', 'cat' => 'misc'),
	'acl_u_ignoreflood'	=> array('lang' => 'Può ignorare limite flood', 'cat' => 'misc'),
	'acl_u_hideonline'	=> array('lang' => 'Può nascondere stato in linea', 'cat' => 'misc'),
	'acl_u_viewonline'	=> array('lang' => 'Può vedere tutti in linea', 'cat' => 'misc'),
	'acl_u_search'		=> array('lang' => 'Può cercare nel forum', 'cat' => 'misc'),
));

// Forum Permissions
$lang = array_merge($lang, array(
	'acl_f_list'		=> array('lang' => 'Può vedere forum', 'cat' => 'post'),
	'acl_f_read'		=> array('lang' => 'Può leggere forum', 'cat' => 'post'),
	'acl_f_post'		=> array('lang' => 'Può inserire nuovi argomenti', 'cat' => 'post'),
	'acl_f_reply'		=> array('lang' => 'Può rispondere agli argomenti', 'cat' => 'post'),
	'acl_f_icons'		=> array('lang' => 'Può utilizzare icone argomento/messaggio', 'cat' => 'post'),
	'acl_f_announce'	=> array('lang' => 'Può inserire annunci', 'cat' => 'post'),
	'acl_f_sticky'		=> array('lang' => 'Può inserire argomenti importanti', 'cat' => 'post'),

	'acl_f_poll'		=> array('lang' => 'Può creare sondaggi', 'cat' => 'polls'),
	'acl_f_vote'		=> array('lang' => 'Può votare sondaggi', 'cat' => 'polls'),
	'acl_f_votechg'		=> array('lang' => 'Può cambiare voto esistente', 'cat' => 'polls'),

	'acl_f_attach'		=> array('lang' => 'Può allegare file', 'cat' => 'content'),
	'acl_f_download'	=> array('lang' => 'Può scaricare file', 'cat' => 'content'),
	'acl_f_sigs'		=> array('lang' => 'Può utilizzare firma', 'cat' => 'content'),
	'acl_f_bbcode'		=> array('lang' => 'Può inserire BBCode', 'cat' => 'content'),
	'acl_f_smilies'		=> array('lang' => 'Può inserire emoticon', 'cat' => 'content'),
	'acl_f_img'			=> array('lang' => 'Può inserire immagini', 'cat' => 'content'),
	'acl_f_flash'		=> array('lang' => 'Può inserire file flash', 'cat' => 'content'),

	'acl_f_edit'		=> array('lang' => 'Può modificare i messaggi', 'cat' => 'actions'),
	'acl_f_delete'		=> array('lang' => 'Può cancellare i messaggi', 'cat' => 'actions'),
	'acl_f_user_lock'	=> array('lang' => 'Può bloccare gli argomenti', 'cat' => 'actions'),
	'acl_f_bump'		=> array('lang' => 'Può effettuare bump argomenti', 'cat' => 'actions'),
	'acl_f_report'		=> array('lang' => 'Può effettuare segnalazione messaggi', 'cat' => 'actions'),
	'acl_f_subscribe'	=> array('lang' => 'Può controllare forum', 'cat' => 'actions'),
	'acl_f_print'		=> array('lang' => 'Può stampare argomenti', 'cat' => 'actions'),
	'acl_f_email'		=> array('lang' => 'Può spedire argomenti via e-mail', 'cat' => 'actions'),

	'acl_f_search'		=> array('lang' => 'Può cercare nel forum', 'cat' => 'misc'),
	'acl_f_ignoreflood' => array('lang' => 'Può ignorare limite flood', 'cat' => 'misc'),
	'acl_f_postcount'	=> array('lang' => 'Incrementa contatore messaggio<br /><em>Impostazione che riguarda solo i messaggi.</em>', 'cat' => 'misc'),
	'acl_f_noapprove'	=> array('lang' => 'Può inserire messaggi senza approvazione', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
	'acl_m_edit'		=> array('lang' => 'Può modificare messaggi', 'cat' => 'post_actions'),
	'acl_m_delete'		=> array('lang' => 'Può cancellare messaggi', 'cat' => 'post_actions'),
	'acl_m_approve'		=> array('lang' => 'Può approvare messaggi', 'cat' => 'post_actions'),
	'acl_m_report'		=> array('lang' => 'Può chiudere e cancellare segnalazioni', 'cat' => 'post_actions'),
	'acl_m_chgposter'	=> array('lang' => 'Può cambiare autore messaggio', 'cat' => 'post_actions'),

	'acl_m_move'	=> array('lang' => 'Può spostare argomenti', 'cat' => 'topic_actions'),
	'acl_m_lock'	=> array('lang' => 'Può bloccare argomenti', 'cat' => 'topic_actions'),
	'acl_m_split'	=> array('lang' => 'Può dividere argomenti', 'cat' => 'topic_actions'),
	'acl_m_merge'	=> array('lang' => 'Può unire argomenti', 'cat' => 'topic_actions'),

	'acl_m_info'	=> array('lang' => 'Può vedere dettagli messaggio', 'cat' => 'misc'),
	'acl_m_warn'	=> array('lang' => 'Può effettuare richiami<br /><em>Questa impostazione esiste solo come globale e non localmente su forum.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
	'acl_m_ban'		=> array('lang' => 'Può gestire ban<br /><em>Questa impostazione esiste solo come globale e non localmente su forum.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
));

// Admin Permissions
$lang = array_merge($lang, array(
	'acl_a_board'		=> array('lang' => 'Può modificare impostazioni forum/controllare aggiornamenti', 'cat' => 'settings'),
	'acl_a_server'		=> array('lang' => 'Può modificare impostazioni server/comunicazione', 'cat' => 'settings'),
	'acl_a_jabber'		=> array('lang' => 'Può modificare impostazioni Jabber', 'cat' => 'settings'),
	'acl_a_phpinfo'		=> array('lang' => 'Può vedere impostazioni php', 'cat' => 'settings'),

	'acl_a_forum'		=> array('lang' => 'Può gestire forum', 'cat' => 'forums'),
	'acl_a_forumadd'	=> array('lang' => 'Può aggiungere nuovi forum', 'cat' => 'forums'),
	'acl_a_forumdel'	=> array('lang' => 'Può cancellare forum', 'cat' => 'forums'),
	'acl_a_prune'		=> array('lang' => 'Può usare il prune forum', 'cat' => 'forums'),

	'acl_a_icons'		=> array('lang' => 'Può modificare icone argomenti/messaggi e emoticon', 'cat' => 'posting'),
	'acl_a_words'		=> array('lang' => 'Può modificare censura parole', 'cat' => 'posting'),
	'acl_a_bbcode'		=> array('lang' => 'Può definire tag BBCode', 'cat' => 'posting'),
	'acl_a_attach'		=> array('lang' => 'Può modificare impostazioni allegati', 'cat' => 'posting'),

	'acl_a_user'		=> array('lang' => 'Può gestire utenti<br /><em>Comprende anche la possibilità di vedere quale browser usa nella lista degli utenti online.</em>', 'cat' => 'user_group'),
	'acl_a_userdel'		=> array('lang' => 'Può cancellare/prune utenti', 'cat' => 'user_group'),
	'acl_a_group'		=> array('lang' => 'Può gestire gruppi', 'cat' => 'user_group'),
	'acl_a_groupadd'	=> array('lang' => 'Può aggiungere nuovi gruppi', 'cat' => 'user_group'),
	'acl_a_groupdel'	=> array('lang' => 'Può cancellare gruppi', 'cat' => 'user_group'),
	'acl_a_ranks'		=> array('lang' => 'Può gestire livelli', 'cat' => 'user_group'),
	'acl_a_profile'		=> array('lang' => 'Può gestire campi profilo personalizzati', 'cat' => 'user_group'),
	'acl_a_names'		=> array('lang' => 'Può gestire la disabilitazione nomi', 'cat' => 'user_group'),
	'acl_a_ban'			=> array('lang' => 'Può gestire ban', 'cat' => 'user_group'),

	'acl_a_viewauth'	=> array('lang' => 'Può vedere le maschere permessi', 'cat' => 'permissions'),
	'acl_a_authgroups'	=> array('lang' => 'Può modificare permessi gruppi individuali', 'cat' => 'permissions'),
	'acl_a_authusers'	=> array('lang' => 'Può modificare permessi utente individuali', 'cat' => 'permissions'),
	'acl_a_fauth'		=> array('lang' => 'Può modificare la classe permessi forum', 'cat' => 'permissions'),
	'acl_a_mauth'		=> array('lang' => 'Può modificare la classe permessi moderatori', 'cat' => 'permissions'),
	'acl_a_aauth'		=> array('lang' => 'Può modificare la classe permessi amministrazione', 'cat' => 'permissions'),
	'acl_a_uauth'		=> array('lang' => 'Può modificare la classe permessi utente', 'cat' => 'permissions'),
	'acl_a_roles'		=> array('lang' => 'Può gestire ruoli', 'cat' => 'permissions'),
	'acl_a_switchperm'	=> array('lang' => 'Può utilizzare altri permessi', 'cat' => 'permissions'),

	'acl_a_styles'		=> array('lang' => 'Può gestire stili', 'cat' => 'misc'),
	'acl_a_viewlogs'	=> array('lang' => 'Può vedere log', 'cat' => 'misc'),
	'acl_a_clearlogs'	=> array('lang' => 'Può cancellare log', 'cat' => 'misc'),
	'acl_a_modules'		=> array('lang' => 'Può gestire moduli', 'cat' => 'misc'),
	'acl_a_language'	=> array('lang' => 'Può gestire pacchetti lingua', 'cat' => 'misc'),
	'acl_a_email'		=> array('lang' => 'Può inviare e-mail generali', 'cat' => 'misc'),
	'acl_a_bots'		=> array('lang' => 'Può gestire Bot', 'cat' => 'misc'),
	'acl_a_reasons'		=> array('lang' => 'Può gestire segnalazioni e motivi rifiuti', 'cat' => 'misc'),
	'acl_a_backup'		=> array('lang' => 'Può effettuare il backup e il ripristino del database', 'cat' => 'misc'),
	'acl_a_search'		=> array('lang' => 'Può gestire ricerca e impostazioni', 'cat' => 'misc'),
));

?>