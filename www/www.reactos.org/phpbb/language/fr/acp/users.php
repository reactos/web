<?php
/**
*
* acp_users [French]
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
	'ADMIN_SIG_PREVIEW'		=> 'Prévisualiser la signature',
	'AT_LEAST_ONE_FOUNDER'	=> 'Vous ne pouvez pas modifier ce fondateur en utilisateur normal. Il est nécessaire d’avoir au moins un fondateur sur le forum. Si vous souhaitez modifier le statut de ce fondateur, vous devez tout d’abord promouvoir un autre utilisateur en fondateur.',

	'BAN_ALREADY_ENTERED'	=> 'Le bannissement a déjà été effectué. La liste des bannissements n’a pas été mise à jour.',
	'BAN_SUCCESSFUL'		=> 'Le bannissement a été effectué.',

	'CANNOT_BAN_ANONYMOUS'			=> 'Vous n’êtes pas autorisé(e) à bannir les comptes d’anonymes. Les permissions agissant sur les utilisateurs anonymes peuvent être réglées sous l’onglet Permissions.',
	'CANNOT_BAN_FOUNDER'			=> 'Vous n’êtes pas autorisé(e) à bannir les comptes des fondateurs.',
	'CANNOT_BAN_YOURSELF'			=> 'Vous n’êtes pas autorisé(e) à bannir votre propre compte.',
	'CANNOT_DEACTIVATE_BOT'			=> 'Vous n’êtes pas autorisé(e) à désactiver les comptes des robots. Veuillez plutôt désactiver le robot à partir de la page des robots.',
	'CANNOT_DEACTIVATE_FOUNDER'		=> 'Vous n’êtes pas autorisé(e) à désactiver les comptes des fondateurs.',
	'CANNOT_DEACTIVATE_YOURSELF'	=> 'Vous n’êtes pas autorisé(e) à désactiver votre propre compte.',
	'CANNOT_FORCE_REACT_BOT'		=> 'Vous n’êtes pas autorisé(e) à forcer la réactivation des comptes des robots. Veuillez plutôt réactiver le robot à partir de la page des robots.',
	'CANNOT_FORCE_REACT_FOUNDER'	=> 'Vous n’êtes pas autorisé(e) à forcer la réactivation des comptes des fondateurs.',
	'CANNOT_FORCE_REACT_YOURSELF'	=> 'Vous n’êtes pas autorisé(e) à forcer la réactivation de votre propre compte.',
	'CANNOT_REMOVE_ANONYMOUS'		=> 'Vous n’êtes pas autorisé(e) à supprimer le compte d’un invité.',
	'CANNOT_REMOVE_YOURSELF'		=> 'Vous n’êtes pas autorisé(e) à supprimer votre propre compte.',
	'CANNOT_SET_FOUNDER_IGNORED'	=> 'Vous n’êtes pas autorisé(e) à promouvoir des utilisateurs ignorés en fondateurs.',
	'CANNOT_SET_FOUNDER_INACTIVE'	=> 'Vous devez activer les utilisateurs avant de les promouvoir en fondateurs. Seuls des utilisateurs activés peuvent être promus.',
	'CONFIRM_EMAIL_EXPLAIN'			=> 'Vous n’avez besoin de spécifier cela que si vous modifiez les adresses de courrier électronique des utilisateurs.',

	'DELETE_POSTS'			=> 'Supprimer les messages',
	'DELETE_USER'			=> 'Supprimer l’utilisateur ',
	'DELETE_USER_EXPLAIN'	=> 'Veuillez noter que la suppression d’un utilisateur est irréversible, sa restauration est impossible. Les messages non lus envoyés par cet utilisateur seront supprimés et les destinataires ne pourront pas les consulter.',

	'FORCE_REACTIVATION_SUCCESS'	=> 'La réactivation a été forcée.',
	'FOUNDER'						=> 'Fondateur ',
	'FOUNDER_EXPLAIN'				=> 'Les fondateurs détiennent toutes les permissions des administrateurs et ne peuvent pas être bannis, supprimés ou modifiés par des membres qui ne sont pas eux-mêmes des fondateurs.',

	'GROUP_APPROVE'					=> 'Approuver le membre',
	'GROUP_DEFAULT'					=> 'Définir comme le groupe par défaut du membre',
	'GROUP_DELETE'					=> 'Supprimer le membre du groupe',
	'GROUP_DEMOTE'					=> 'Rétrograder le responsable du groupe',
	'GROUP_PROMOTE'					=> 'Promouvoir en responsable du groupe',

	'IP_WHOIS_FOR'			=> 'À qui appartient l’IP pour %s',

	'LAST_ACTIVE'			=> 'Dernière visite ',

	'MOVE_POSTS_EXPLAIN'	=> 'Veuillez sélectionner le forum dans lequel vous souhaitez déplacer tous les messages de cet utilisateur.',

	'NO_SPECIAL_RANK'		=> 'Aucun rang spécial n’a été spécifié',
	'NO_WARNINGS'			=> 'Aucun avertissement.',
	'NOT_MANAGE_FOUNDER'	=> 'Vous avez essayé de modifier un utilisateur qui détient le statut de fondateur. Seuls les fondateurs sont autorisés à gérer les autres fondateurs.',

	'QUICK_TOOLS'			=> 'Outils rapides ',

	'REGISTERED'			=> 'Inscription ',
	'REGISTERED_IP'			=> 'Adresse IP lors de l’inscription ',
	'RETAIN_POSTS'			=> 'Conserver ses messages',

	'SELECT_FORM'			=> 'Sélectionner un formulaire ',
	'SELECT_USER'			=> 'Sélectionner un utilisateur ',

	'USER_ADMIN'					=> 'Administration de l’utilisateur',
	'USER_ADMIN_ACTIVATE'			=> 'Activer le compte',
	'USER_ADMIN_ACTIVATED'			=> 'L’utilisateur a été activé.',
	'USER_ADMIN_AVATAR_REMOVED'		=> 'L’avatar associé au compte de l’utilisateur a été supprimé.',
	'USER_ADMIN_BAN_EMAIL'			=> 'Bannir par adresse de courrier électronique',
	'USER_ADMIN_BAN_EMAIL_REASON'	=> 'Adresse de courrier électronique bannie par l’intermédiaire de la gestion des utilisateurs',
	'USER_ADMIN_BAN_IP'				=> 'Bannir par adresse IP',
	'USER_ADMIN_BAN_IP_REASON'		=> 'Adresse IP bannie par l’intermédiaire de la gestion des utilisateurs',
	'USER_ADMIN_BAN_NAME_REASON'	=> 'Nom d’utilisateur banni par l’intermédiaire de la gestion des utilisateurs',
	'USER_ADMIN_BAN_USER'			=> 'Bannir par nom d’utilisateur',
	'USER_ADMIN_DEACTIVATE'			=> 'Désactiver le compte',
	'USER_ADMIN_DEACTIVED'			=> 'L’utilisateur a été désactivé.',
	'USER_ADMIN_DEL_ATTACH'			=> 'Supprimer toutes les pièces jointes',
	'USER_ADMIN_DEL_AVATAR'			=> 'Supprimer l’avatar',
	'USER_ADMIN_DEL_OUTBOX'			=> 'Vider la boîte d’envoi des MP',
	'USER_ADMIN_DEL_POSTS'			=> 'Supprimer tous les messages',
	'USER_ADMIN_DEL_SIG'			=> 'Supprimer la signature',
	'USER_ADMIN_EXPLAIN'			=> 'Vous pouvez modifier ici les informations de vos utilisateurs et certaines options spécifiques à ces derniers.',
	'USER_ADMIN_FORCE'				=> 'Forcer la réactivation',
	'USER_ADMIN_LEAVE_NR'			=> 'Supprimer des inscrits récemment',
	'USER_ADMIN_MOVE_POSTS'			=> 'Déplacer tous les messages',
	'USER_ADMIN_SIG_REMOVED'		=> 'La signature associée au compte de l’utilisateur a été supprimée.',
	'USER_ATTACHMENTS_REMOVED'		=> 'La totalité des pièces jointes insérées par cet utilisateur a été supprimée.',
	'USER_AVATAR_NOT_ALLOWED'		=> 'L’avatar ne peut pas être affiché car les avatars ne sont pas autorisés.',
	'USER_AVATAR_UPDATED'			=> 'Les informations liées aux avatars de l’utilisateur ont été mises à jour.',
	'USER_AVATAR_TYPE_NOT_ALLOWED'	=> 'L’avatar actuel ne peut pas être affiché car son type n’est pas autorisé.',
	'USER_CUSTOM_PROFILE_FIELDS'	=> 'Champs de profil personnalisés',
	'USER_DELETED'					=> 'L’utilisateur a été supprimé.',
	'USER_GROUP_ADD'				=> 'Ajouter l’utilisateur au groupe ',
	'USER_GROUP_NORMAL'				=> 'L’utilisateur est membre des groupes normaux',
	'USER_GROUP_PENDING'			=> 'L’utilisateur est en attente d’adhésion aux groupes',
	'USER_GROUP_SPECIAL'			=> 'L’utilisateur est membre des groupes prédéfinis',
	'USER_LIFTED_NR'				=> 'Le statut d’utilisateur inscrit récemment a été supprimé.',
	'USER_NO_ATTACHMENTS'			=> 'Il n’y a aucune pièce jointe à afficher.',
	'USER_NO_POSTS_TO_DELETE'			=> 'L’utilisateur n’a aucun message à conserver ou à supprimer.',
	'USER_OUTBOX_EMPTIED'			=> 'La boîte d’envoi des messages privés de l’utilisateur a été vidée.',
	'USER_OUTBOX_EMPTY'				=> 'La boîte d’envoi des messages privés de l’utilisateur est déjà vide.',
	'USER_OVERVIEW_UPDATED'			=> 'Les informations de l’utilisateur ont été mises à jour.',
	'USER_POSTS_DELETED'			=> 'La totalité des messages publiés par cet utilisateur a été supprimée.',
	'USER_POSTS_MOVED'				=> 'Les messages des utilisateurs ont été déplacés dans le forum que vous avez spécifié.',
	'USER_PREFS_UPDATED'			=> 'Les préférences de l’utilisateur ont été mises à jour.',
	'USER_PROFILE'					=> 'Profil de l’utilisateur',
	'USER_PROFILE_UPDATED'			=> 'Le profil de l’utilisateur a été mis à jour.',
	'USER_RANK'						=> 'Rang de l’utilisateur ',
	'USER_RANK_UPDATED'				=> 'Le rang de l’utilisateur a été mis à jour.',
	'USER_SIG_UPDATED'				=> 'La signature de l’utilisateur a été mise à jour.',
	'USER_WARNING_LOG_DELETED'		=> 'Aucune information n’est disponible. Il est possible que l’historique d’entrée ait été supprimé.',
	'USER_TOOLS'					=> 'Outils basiques',
));

?>