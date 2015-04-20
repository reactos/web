<?php
/**
*
* acp_ban [French]
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

// Banning
$lang = array_merge($lang, array(
	'1_HOUR'		=> '1 heure',
	'30_MINS'		=> '30 minutes',
	'6_HOURS'		=> '6 heures',

	'ACP_BAN_EXPLAIN'	=> 'Vous pouvez contrôler ici le bannissement d’utilisateurs par nom, adresse IP ou adresse de courrier électronique. Ces différentes méthodes empêchent qu’un utilisateur indésirable puisse participer à l’ensemble des discussions de votre forum. Si vous le souhaitez, vous pouvez fournir une raison d’un maximum de 3000 caractères qui sera affichée à l’utilisateur banni. Cela sera affiché dans l’historique des administrateurs. La durée du bannissement peut également être spécifiée. Si vous souhaitez que le bannissement expire à une date spécifique plutôt qu’après avoir passé un certain délai, sélectionnez <span style="text-decoration: underline;">Jusqu’à -&gt;</span> concernant la durée du bannissement, puis saisissez une date au format <kbd>AAAA-MM-JJ</kbd>.',

	'BAN_EXCLUDE'			=> 'Exclure du bannissement ',
	'BAN_LENGTH'			=> 'Durée du bannissement ',
	'BAN_REASON'			=> 'Raison du bannissement ',
	'BAN_GIVE_REASON'		=> 'Raison affichée à l’utilisateur banni ',
	'BAN_UPDATE_SUCCESSFUL'	=> 'La liste des bannissements a été mise à jour.',
	'BANNED_UNTIL_DATE'		=> 'jusqu’au %s', // Example: "until Mon 13.Jul.2009, 14:44"
	'BANNED_UNTIL_DURATION'	=> '%1$s (jusqu’au %2$s)', // Example: "7 days (until Tue 14.Jul.2009, 14:44)"

	'EMAIL_BAN'					=> 'Bannir une ou plusieurs adresses de courrier électronique',
	'EMAIL_BAN_EXCLUDE_EXPLAIN'	=> 'Activez ceci afin d’exclure de tous les bannissements actuels les adresses de courrier électronique que vous avez spécifiées.',
	'EMAIL_BAN_EXPLAIN'			=> 'Vous pouvez bannir plusieurs adresses de courrier électronique en saisissant chacun d’elles sur une nouvelle ligne. Pour utiliser partiellement des adresses, utilisez * comme joker, comme par exemple <samp>*@hotmail.com</samp>, <samp>*@*.domaine.tld</samp>, etc.',
	'EMAIL_NO_BANNED'			=> 'Aucune adresse de courrier électronique n’a été bannie',
	'EMAIL_UNBAN'				=> 'Exclure du bannissement les adresses de courrier électronique',
	'EMAIL_UNBAN_EXPLAIN'		=> 'Vous pouvez exclure du bannissement plusieurs adresses de courrier électronique en une seule fois en utilisant la combinaison appropriée de la souris et du clavier de votre ordinateur et de votre navigateur. Les adresses de courrier électronique exclues apparaissent soulignées.',

	'IP_BAN'					=> 'Bannir une ou plusieurs adresses IP',
	'IP_BAN_EXCLUDE_EXPLAIN'	=> 'Activez ceci afin d’exclure de tous les bannissements actuels les adresses IP spécifiées.',
	'IP_BAN_EXPLAIN'			=> 'Vous pouvez bannir plusieurs adresses IP ou noms d’hôtes en saisissant chacun d’eux sur une nouvelle ligne. Pour spécifier une plage d’adresses IP, séparez le début et la fin par un tiret (-) et pour spécifier un joker, utilisez « * ».',
	'IP_HOSTNAME'				=> 'Adresse(s) IP ou nom(s) d’hôte(s) ',
	'IP_NO_BANNED'				=> 'Aucune adresse IP n’a été bannie',
	'IP_UNBAN'					=> 'Exclure du bannissement les adresses IP',
	'IP_UNBAN_EXPLAIN'			=> 'Vous pouvez exclure du bannissement plusieurs adresses IP en une seule fois en utilisant la combinaison appropriée de la souris et du clavier de votre ordinateur et de votre navigateur. Les adresses IP exclues apparaissent soulignées.',

	'LENGTH_BAN_INVALID'		=> 'La date doit être au format <kbd>AAAA-MM-JJ</kbd>.',

	'OPTIONS_BANNED'			=> 'Banni(e)',
	'OPTIONS_EXCLUDED'			=> 'Exclu(e)',

	'PERMANENT'		=> 'Permanent',

	'UNTIL'						=> 'Jusqu’à',
	'USER_BAN'					=> 'Bannir un ou plusieurs noms d’utilisateurs',
	'USER_BAN_EXCLUDE_EXPLAIN'	=> 'Activez ceci afin d’exclure de tous les bannissements actuels les utilisateurs spécifiés.',
	'USER_BAN_EXPLAIN'			=> 'Vous pouvez bannir plusieurs noms d’utilisateurs en saisissant chacun d’eux sur une nouvelle ligne. Utilisez la fonctionnalité <span style="text-decoration: underline;">Trouver un membre</span> afin de rechercher et d’ajouter automatiquement un ou plusieurs utilisateurs.',
	'USER_NO_BANNED'			=> 'Aucun nom d’utilisateur n’a été banni',
	'USER_UNBAN'				=> 'Exclure du bannissement les noms d’utilisateurs',
	'USER_UNBAN_EXPLAIN'		=> 'Vous pouvez exclure du bannissement plusieurs noms d’utilisateurs en une seule fois en utilisant la combinaison appropriée de la souris et du clavier de votre ordinateur et de votre navigateur. Les utilisateurs exclus apparaissent soulignés.',
));

?>