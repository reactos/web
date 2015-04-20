<?php
/**
*
* acp_groups [French]
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
	'ACP_GROUPS_MANAGE_EXPLAIN'		=> 'Depuis ce panneau, vous pouvez administrer tous les groupes d’utilisateurs. Vous pouvez créer, éditer et supprimer les groupes d’utilisateurs, ou encore spécifier le statut (ouvert, fermé ou invisible), le nom et la description de ces derniers. De plus, vous pouvez nommer les responsables des différents groupes d’utilisateurs.',
	'ADD_USERS'						=> 'Ajouter des utilisateurs',
	'ADD_USERS_EXPLAIN'				=> 'Vous pouvez ajouter ici de nouveaux utilisateurs à un groupe d’utilisateurs. Vous pouvez également spécifier un groupe d’utilisateurs par défaut aux utilisateurs que vous avez sélectionnés. De plus, vous pouvez promouvoir certains membres d’un groupe d’utilisateurs comme responsables de ce dernier. Veuillez saisir chaque nom d’utilisateur sur une nouvelle ligne.',

	'COPY_PERMISSIONS'				=> 'Copier les permissions de ',
	'COPY_PERMISSIONS_EXPLAIN'		=> 'Une fois que ce groupe d’utilisateurs sera créé, ses permissions seront identiques à celles du groupe d’utilisateurs que vous avez sélectionné ici.',
	'CREATE_GROUP'					=> 'Créer un nouveau groupe d’utilisateurs ',

	'GROUPS_NO_MEMBERS'				=> 'Ce groupe d’utilisateurs n’a aucun membre',
	'GROUPS_NO_MODS'				=> 'Ce groupe d’utilisateurs n’a aucun responsable',

	'GROUP_APPROVE'					=> 'Approuver le membre',
	'GROUP_APPROVED'				=> 'Membres approuvés',
	'GROUP_AVATAR'					=> 'Avatar du groupe',
	'GROUP_AVATAR_EXPLAIN'			=> 'Cette image sera affichée dans le panneau de contrôle des groupes d’utilisateurs.',
	'GROUP_CLOSED'					=> 'Fermé',
	'GROUP_COLOR'					=> 'Couleur du groupe ',
	'GROUP_COLOR_EXPLAIN'			=> 'La couleur dans laquelle les noms d’utilisateurs des membres apparaîtront. Laissez ce champ vide si vous souhaitez conserver la couleur des membres par défaut.',
	'GROUP_CONFIRM_ADD_USER'		=> 'Êtes-vous sûr(e) de vouloir ajouter l’utilisateur %1$s au groupe d’utilisateurs ?',
	'GROUP_CONFIRM_ADD_USERS'		=> 'Êtes-vous sûr(e) de vouloir ajouter les utilisateurs %1$s au groupe d’utilisateurs ?',
	'GROUP_CREATED'					=> 'Le groupe d’utilisateurs a été créé.',
	'GROUP_DEFAULT'					=> 'Définir comme groupe d’utilisateurs par défaut pour les membres',
	'GROUP_DEFS_UPDATED'			=> 'Le groupe d’utilisateurs a été réglé comme groupe d’utilisateurs par défaut pour tous les membres sélectionnés.',
	'GROUP_DELETE'					=> 'Supprimer le membre du groupe',
	'GROUP_DELETED'					=> 'Le groupe d’utilisateurs a été supprimé et tous ses membres ont été transférés dans le groupe d’utilisateurs par défaut.',
	'GROUP_DEMOTE'					=> 'Rétrograder le responsable du groupe',
	'GROUP_DESC'					=> 'Description du groupe ',
	'GROUP_DETAILS'					=> 'Informations sur le groupe',
	'GROUP_EDIT_EXPLAIN'			=> 'Vous pouvez éditer ici un groupe d’utilisateurs déjà existant. Vous pouvez modifier son nom, sa description et son type (ouvert, fermé, etc.). Vous pouvez également spécifier certaines de ses options comme sa couleur, son rang, etc. Les modifications effectuées ici écraseront les réglages actuels des utilisateurs. Veuillez noter que si les permissions des utilisateurs le permettent, les membres d’un groupe d’utilisateurs pourront outrepasser le réglage de l’avatar de ce dernier en sélectionannt un avatar personnalisé.',
	'GROUP_ERR_USERS_EXIST'			=> 'Les utilisateurs que vous avez spécifiés sont déjà des membres de ce groupe d’utilisateurs.',
	'GROUP_FOUNDER_MANAGE'			=> 'Limiter la gestion aux fondateurs uniquement ',
	'GROUP_FOUNDER_MANAGE_EXPLAIN'	=> 'Limite la gestion de ce groupe d’utilisateurs aux fondateurs uniquement. Les membres du groupe d’utilisateurs peuvent consulter ce dernier.',
	'GROUP_HIDDEN'					=> 'Invisible',
	'GROUP_LANG'					=> 'Langue du groupe',
	'GROUP_LEAD'					=> 'Responsable(s) du groupe',
	'GROUP_LEADERS_ADDED'			=> 'Les nouveaux responsables du groupe d’utilisateurs ont été ajoutés.',
	'GROUP_LEGEND'					=> 'Afficher le groupe dans la légende ',
	'GROUP_LIST'					=> 'Membre(s) actuel(s)',
	'GROUP_LIST_EXPLAIN'			=> 'Ceci correspond à la liste complète de tous les membres actuels de ce groupe d’utilisateurs. Vous pouvez supprimer ses membres (excepté dans certains groupes spéciaux) ou en ajouter de nouveaux.',
	'GROUP_MEMBERS'					=> 'Membre(s) du groupe',
	'GROUP_MEMBERS_EXPLAIN'			=> 'Ceci correspond à la liste complète de tous les membres de ce groupe d’utilisateurs. Ces derniers sont divisés en trois sections, les responsables, les membres en attente et les membres déjà existants. Vous pouvez gérer ici tous les aspects des membres de ce groupe d’utilisateurs en définissant leurs rôles et leurs responsabilités. Pour supprimer un responsable tout en le conservant dans le groupe d’utilisateurs, utilisez la rétrogradation au lieu de le suppression. De même, si vous souhaitez promouvoir un membre en responsable, utilisez la promotion.',
	'GROUP_MESSAGE_LIMIT'			=> 'Limite de messages privés par dossier des membres du groupe ',
	'GROUP_MESSAGE_LIMIT_EXPLAIN'	=> 'Ce réglage écrasera la limite des messages privés par dossier des utilisateurs. Réglez cette valeur sur 0 afin de conserver cette limite.',
	'GROUP_MODS_ADDED'				=> 'Les nouveaux responsables du groupe ont été ajoutés.',
	'GROUP_MODS_DEMOTED'			=> 'Les responsables du groupe d’utilisateurs ont été rétrogradés.',
	'GROUP_MODS_PROMOTED'			=> 'Les membres du groupe d’utilisateurs ont été promus.',
	'GROUP_NAME'					=> 'Nom du groupe ',
	'GROUP_NAME_TAKEN'				=> 'Le nom du groupe que vous avez saisi est déjà utilisé. Veuillez saisir un nouveau nom.',
	'GROUP_OPEN'					=> 'Ouvert',
	'GROUP_PENDING'					=> 'Membre(s) en attente',
	'GROUP_MAX_RECIPIENTS'			=> 'Nombre maximum de destinataires autorisés dans un message privé ',
	'GROUP_MAX_RECIPIENTS_EXPLAIN'	=> 'Le nombre maximum de destinataires autorisés dans un message privé. Réglez cette valeur sur 0 afin d’utiliser le réglage global du forum.',
	'GROUP_OPTIONS_SAVE'			=> 'Options globales du groupe',
	'GROUP_PROMOTE'					=> 'Promouvoir en responsable du groupe',
	'GROUP_RANK'					=> 'Rang du groupe ',
	'GROUP_RECEIVE_PM'				=> 'Autoriser le groupe à recevoir des messages privés ',
	'GROUP_RECEIVE_PM_EXPLAIN'		=> 'Veuillez noter que les groupes invisibles ne sont pas autorisés à recevoir de messages privés, quelque que soit le réglage.',
	'GROUP_REQUEST'					=> 'Restreint',
	'GROUP_SETTINGS_SAVE'			=> 'Réglages globaux du groupe',
	'GROUP_SKIP_AUTH'				=> 'Exempter le responsable des permissions du groupe ',
	'GROUP_SKIP_AUTH_EXPLAIN'		=> 'Si cette option est activée, le responsable du groupe d’utilisateurs n’héritera pas des permissions de ce dernier.',
	'GROUP_TYPE'					=> 'Type de groupe ',
	'GROUP_TYPE_EXPLAIN'			=> 'Détermine quels sont les utilisateurs qui peuvent rejoindre ou consulter ce groupe.',
	'GROUP_UPDATED'					=> 'Les préférences du groupe ont été mises à jour.',

	'GROUP_USERS_ADDED'				=> 'Les nouveaux utilisateurs ont été ajoutés au groupe d’utilisateurs.',
	'GROUP_USERS_EXIST'				=> 'Les utilisateurs que vous avez sélectionnés sont déjà des membres de ce groupe d’utilisateurs.',
	'GROUP_USERS_REMOVE'			=> 'Les utilisateurs ont été supprimés de ce groupe d’utilisateurs. Ils ont été transférés dans le groupe d’utilisateurs par défaut.',

	'MAKE_DEFAULT_FOR_ALL'	=> 'Définir comme le groupe par défaut pour tous les membres',
	'MEMBERS'				=> 'Membre(s)',

	'NO_GROUP'					=> 'Aucun groupe n’a été spécifié.',
	'NO_GROUPS_CREATED'			=> 'Aucun groupe n’a été crée.',
	'NO_PERMISSIONS'			=> 'Ne copier aucune permission',
	'NO_USERS'					=> 'Aucun utilisateur n’a été spécifié.',
	'NO_USERS_ADDED'			=> 'Aucun utilisateur n’a été ajouté au groupe d’utilisateurs.',
	'NO_VALID_USERS'			=> 'Aucun utilisateur n’est éligible afin de réaliser cette action.',

	'SPECIAL_GROUPS'			=> 'Groupe(s) prédéfini(s)',
	'SPECIAL_GROUPS_EXPLAIN'	=> 'Les groupes prédéfinis sont des groupes spéciaux. Ils ne peuvent ni être supprimés, ni être directement modifiés. Cependant, vous pouvez gérer leurs adhésions et éditer certaines de leurs propriétés.',

	'TOTAL_MEMBERS'				=> 'Membre(s)',

	'USERS_APPROVED'				=> 'Les utilisateurs ont été approuvés.',
	'USER_DEFAULT'					=> 'Utilisateur par défaut',
	'USER_DEF_GROUPS'				=> 'Groupe(s) défini(s) par un administrateur',
	'USER_DEF_GROUPS_EXPLAIN'		=> 'Les groupes définis par un administrateur sont des groupes d’utilisateurs créés par vous-même ou par un autre administrateur du forum. Vous pouvez gérer leurs adhésions, éditer leurs propriétés ou encore les supprimer.',
	'USER_GROUP_DEFAULT'			=> 'Définir comme groupe par défaut ',
	'USER_GROUP_DEFAULT_EXPLAIN'	=> 'Si cette option est activée, ce groupe d’utilisateurs sera considéré comme le groupe d’utilisateurs par défaut de tous les utilisateurs.',
	'USER_GROUP_LEADER'				=> 'Promouvoir en responsable du groupe ',
));

?>