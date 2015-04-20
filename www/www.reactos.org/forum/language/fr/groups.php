<?php
/**
*
* groups [French]
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
	'ALREADY_DEFAULT_GROUP'		=> 'Le groupe que vous avez sélectionné est déjà votre groupe par défaut.',
	'ALREADY_IN_GROUP'			=> 'Vous êtes déjà membre du groupe que vous avez sélectionné.',
	'ALREADY_IN_GROUP_PENDING'	=> 'Vous avez déjà demandé à rejoindre le groupe que vous avez sélectionné.',

	'CANNOT_JOIN_GROUP'			=> 'Vous n’êtes pas autorisé(e) à rejoindre ce groupe. Vous ne pouvez rejoindre que les groupes libres et ouverts.',
	'CANNOT_RESIGN_GROUP'		=> 'Vous n’êtes pas autorisé(e) à vous retirer de ce groupe. Vous ne pouvez vous retirer que des groupes libres et ouverts.',
	'CHANGED_DEFAULT_GROUP'		=> 'Le groupe par défaut a été modifié.',

	'GROUP_AVATAR'						=> 'Avatar du groupe',
	'GROUP_CHANGE_DEFAULT'				=> 'Êtes-vous sûr(e) de vouloir modifier votre groupe par défaut par le groupe « %s » ?',
	'GROUP_CLOSED'						=> 'Fermé',
	'GROUP_DESC'						=> 'Description du groupe ',
	'GROUP_HIDDEN'						=> 'Invisible',
	'GROUP_INFORMATION'					=> 'Informations sur le groupe d’utilisateurs',
	'GROUP_IS_CLOSED'					=> 'Ceci est un groupe fermé, les nouveaux membres ne peuvent le rejoindre que sur invitation d’un responsable du groupe.',
	'GROUP_IS_FREE'						=> 'Ceci est un groupe libre et ouvert, tous les nouveaux membres y sont les bienvenus.',
	'GROUP_IS_HIDDEN'					=> 'Ceci est un groupe invisible, seuls les membres de ce groupe peuvent voir ses adhérents.',
	'GROUP_IS_OPEN'						=> 'Ceci est un groupe ouvert, les membres peuvent le rejoindre sur demande.',
	'GROUP_IS_SPECIAL'					=> 'Ceci est un groupe spécial, les groupes spéciaux ne sont gérés que par les administrateurs du forum.',
	'GROUP_JOIN'						=> 'Rejoindre le groupe',
	'GROUP_JOIN_CONFIRM'				=> 'Êtes-vous sûr(e) de vouloir rejoindre le groupe que vous avez sélectionné ?',
	'GROUP_JOIN_PENDING'				=> 'Demander à rejoindre le groupe',
	'GROUP_JOIN_PENDING_CONFIRM'		=> 'Êtes-vous sûr(e) de vouloir demander à rejoindre le groupe que vous avez sélectionné ?',
	'GROUP_JOINED'						=> 'Vous avez rejoint le groupe que vous avez sélectionné.',
	'GROUP_JOINED_PENDING'				=> 'Votre demande d’adhésion a bien été prise en compte. Veuillez patienter le temps qu’un responsable du groupe approuve votre adhésion.',
	'GROUP_LIST'						=> 'Gérer les utilisateurs',
	'GROUP_MEMBERS'						=> 'Membres du groupe',
	'GROUP_NAME'						=> 'Nom du groupe ',
	'GROUP_OPEN'						=> 'Ouvert',
	'GROUP_RANK'						=> 'Rang du groupe ',
	'GROUP_RESIGN_MEMBERSHIP'			=> 'Retirer mon adhésion du groupe',
	'GROUP_RESIGN_MEMBERSHIP_CONFIRM'	=> 'Êtes-vous sûr(e) de vouloir retirer votre adhésion du groupe que vous avez sélectionné ?',
	'GROUP_RESIGN_PENDING'				=> 'Retirer ma demande d’adhésion au groupe',
	'GROUP_RESIGN_PENDING_CONFIRM'		=> 'Êtes-vous sûr(e) de vouloir retirer votre demande d’adhésion au groupe que vous avez sélectionné ?',
	'GROUP_RESIGNED_MEMBERSHIP'			=> 'Vous avez été retiré(e) du groupe que vous avez sélectionné.',
	'GROUP_RESIGNED_PENDING'			=> 'Votre demande d’adhésion au groupe que vous avez sélectionné a été retirée.',
	'GROUP_TYPE'						=> 'Type de groupe ',
	'GROUP_UNDISCLOSED'					=> 'Groupe invisible',
	'FORUM_UNDISCLOSED'					=> 'Modération des forums invisibles',

	'LOGIN_EXPLAIN_GROUP'	=> 'Vous devez vous connecter afin de consulter les informations sur le groupe.',

	'NO_LEADERS'					=> 'Vous n’êtes le responsable d’aucun groupe.',
	'NOT_LEADER_OF_GROUP'			=> 'L’opération n’a pas pu être effectuée car vous n’êtes pas le responsable du groupe que vous avez sélectionné.',
	'NOT_MEMBER_OF_GROUP'			=> 'L’opération n’a pas pu être effectuée car vous n’êtes pas membre du groupe que vous avez sélectionné ou votre demande d’adhésion n’a pas encore été approuvée.',
	'NOT_RESIGN_FROM_DEFAULT_GROUP'	=> 'Vous n’êtes pas autorisé(e) à vous retirer de votre groupe par défaut.',
	
	'PRIMARY_GROUP'		=> 'Groupe primaire',

	'REMOVE_SELECTED'		=> 'Supprimer la sélection',

	'USER_GROUP_CHANGE'			=> 'De « %1$s » au groupe « %2$s »',
	'USER_GROUP_DEMOTE'			=> 'Abandonner le statut de responsable',
	'USER_GROUP_DEMOTE_CONFIRM'	=> 'Êtes-vous sûr(e) de vouloir abandonner votre statut de responsable du groupe que vous avez sélectionné ?',
	'USER_GROUP_DEMOTED'		=> 'Vous n’êtes à présent plus responsable du groupe que vous avez sélectionné.',
));

?>