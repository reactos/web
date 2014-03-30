<?php
/**
*
* acp_email [French]
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

// Email settings
$lang = array_merge($lang, array(
	'ACP_MASS_EMAIL_EXPLAIN'		=> 'Vous pouvez envoyer ici un courriel à la totalité des utilisateurs ou aux utilisateurs d’un groupe d’utilisateurs spécifique <strong>qui acceptent la réception de courriels de masse</strong>. Pour ce faire, un courriel sera envoyé à l’adresse de courrier électronique fournie par l’administrateur et une copie sera adressée à tous les destinataires. Le réglage par défaut est limité à 50 destinataires par courriel mais si ce nombre est dépassé, des courriels supplémentaires seront envoyés. Sachez également que plus les destinataires sont nombreux, plus le temps d’exécution est important. Il est normal que l’envoi d’un courriel de masse dure un certain temps, veillez à ne pas vous déplacer sur une autre page tant que l’opération n’est pas terminée.',
	'ALL_USERS'						=> 'Tous les utilisateurs',

	'COMPOSE'				=> 'Composer',

	'EMAIL_SEND_ERROR'		=> 'Une ou plusieurs erreurs sont survenues lors de l’envoi du courriel. Pour plus d’informations, veuillez consulter l’%shistorique des erreurs%s.',
	'EMAIL_SENT'			=> 'Ce message a été envoyé.',
	'EMAIL_SENT_QUEUE'		=> 'Ce message est en file d’attente et sera envoyé ultérieurement.',

	'LOG_SESSION'			=> 'Historique de la session de la messagerie électronique vers l’historique des erreurs critiques',

	'SEND_IMMEDIATELY'		=> 'Envoyer immédiatement ',
	'SEND_TO_GROUP'			=> 'Envoyer au groupe d’utilisateurs ',
	'SEND_TO_USERS'			=> 'Envoyer aux utilisateurs ',
	'SEND_TO_USERS_EXPLAIN'	=> 'Si vous saisissez ici des noms d’utilisateurs, ces derniers écraseront tous les groupes d’utilisateurs précédemment sélectionnés. Saisissez chaque nom d’utilisateur sur une nouvelle ligne.',

	'MAIL_BANNED'			=> 'Envoyer le courriel aux utilisateurs bannis ',
	'MAIL_BANNED_EXPLAIN'	=> 'Lorsque vous envoyez un courriel de masse à un groupe d’utilisateurs, vous pouvez décider d’également envoyer ce dernier aux utilisateurs bannis.',
	'MAIL_HIGH_PRIORITY'	=> 'Élevée',
	'MAIL_LOW_PRIORITY'		=> 'Faible',
	'MAIL_NORMAL_PRIORITY'	=> 'Normale',
	'MAIL_PRIORITY'			=> 'Priorité du courriel ',
	'MASS_MESSAGE'			=> 'Votre message ',
	'MASS_MESSAGE_EXPLAIN'	=> 'Veuillez noter que vous ne devez saisir que du texte brut. Toutes les balises seront automatiquement supprimées avant l’envoi.',

	'NO_EMAIL_MESSAGE'		=> 'Vous devez saisir un message.',
	'NO_EMAIL_SUBJECT'		=> 'Vous devez spécifier le sujet de votre message.',
));

?>