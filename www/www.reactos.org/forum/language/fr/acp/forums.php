<?php
/**
*
* acp_forums [French]
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

// Forum Admin
$lang = array_merge($lang, array(
	'AUTO_PRUNE_DAYS'			=> 'Durée du délestage automatique selon la publication ',
	'AUTO_PRUNE_DAYS_EXPLAIN'	=> 'Nombre de jours entre la publication du dernier message d’un sujet et la suppression de ce même sujet.',
	'AUTO_PRUNE_FREQ'			=> 'Fréquence du délestage automatique ',
	'AUTO_PRUNE_FREQ_EXPLAIN'	=> 'Nombre de jours entre les délestages automatiques.',
	'AUTO_PRUNE_VIEWED'			=> 'Durée du délestage automatique selon la consultation ',
	'AUTO_PRUNE_VIEWED_EXPLAIN'	=> 'Nombre de jours entre la dernière consultation d’un sujet et la suppression de ce même sujet.',

	'CONTINUE'						=> 'Continuer',
	'COPY_PERMISSIONS'				=> 'Copier les permissions de ',
	'COPY_PERMISSIONS_EXPLAIN'		=> 'Pour faciliter la configuration des permissions de votre nouveau forum, vous pouvez copier les permissions d’un forum déjà existant.',
	'COPY_PERMISSIONS_ADD_EXPLAIN'	=> 'Une fois créé, le forum détiendra les mêmes permissions que celles du forum que vous avez sélectionné ici. Si vous ne sélectionnez aucun forum, le forum nouvellement créé ne sera pas visible jusqu’à que ses permissions soient réglées.',
	'COPY_PERMISSIONS_EDIT_EXPLAIN'	=> 'Si vous souhaitez copier des permissions, sachez que le forum détiendra les mêmes permissions que celles du forum que vous avez sélectionné ici. Cela écrasera toutes les permissions réglées antérieurement afin de les remplacer par celles du forum que vous avez sélectionné. Si vous ne sélectionnez aucun forum, les permissions actuelles seront conservées.',
	'COPY_TO_ACL'					=> 'Si vous le souhaitez, vous pouvez également %sconfigurer les nouvelles permissions%s de ce forum.',
	'CREATE_FORUM'					=> 'Créer un nouveau forum',

	'DECIDE_MOVE_DELETE_CONTENT'		=> 'Supprimer le contenu ou déplacer ce dernier vers un forum ',
	'DECIDE_MOVE_DELETE_SUBFORUMS'		=> 'Supprimer les sous-forums ou déplacer ces derniers vers un forum ',
	'DEFAULT_STYLE'						=> 'Style par défaut',
	'DELETE_ALL_POSTS'					=> 'Supprimer les messages',
	'DELETE_SUBFORUMS'					=> 'Supprimer les sous-forums et les messages',
	'DISPLAY_ACTIVE_TOPICS'				=> 'Activer les sujets actifs ',
	'DISPLAY_ACTIVE_TOPICS_EXPLAIN'		=> 'Si cette option est activée, les sujets actifs du sous-forum que vous avez sélectionné seront affichés sous cette catégorie.',

	'EDIT_FORUM'					=> 'Éditer le forum',
	'ENABLE_INDEXING'				=> 'Activer l’indexation de la recherche ',
	'ENABLE_INDEXING_EXPLAIN'		=> 'Si cette option est activée, les messages publiés dans ce forum seront indexés afin qu’ils puissent être pris en compte lors des recherches.',
	'ENABLE_POST_REVIEW'			=> 'Activer la revue des messages ',
	'ENABLE_POST_REVIEW_EXPLAIN'	=> 'Si cette option est activée, les utilisateurs pourront éditer leurs messages malgré que d’autres utilisateurs aient publiés des réponses dans le même sujet. Il n’est pas conseillé d’activer cette option sur les forums de discussions.',
	'ENABLE_QUICK_REPLY'			=> 'Activer la réponse rapide ',
	'ENABLE_QUICK_REPLY_EXPLAIN'	=> 'Active l’utilisation de la réponse rapide dans ce forum. Ce réglage n’est pas pris en compte si la réponse rapide a été désactivée sur tout le forum. Le champ de la réponse rapide ne sera visible qu’aux utilisateurs autorisés à publier dans ce forum.',
	'ENABLE_RECENT'					=> 'Afficher les sujets actifs ',
	'ENABLE_RECENT_EXPLAIN'			=> 'Si cette option est activée, les sujets publiés dans ce forum seront affichés dans la liste des sujets actifs.',
	'ENABLE_TOPIC_ICONS'			=> 'Activer les icônes de sujet ',

	'FORUM_ADMIN'						=> 'Administration du forum',
	'FORUM_ADMIN_EXPLAIN'				=> 'Dans phpBB3, tout est basé sur la notion de forum. Les catégories ne correspondent qu’à un type spécial de forum. Chaque forum peut contenir un nombre illimité de sous-forums et vous pouvez déterminer s’ils peuvent contenir ou non des messages (comme c’était le cas avec les anciennes catégories). Vous pouvez ajouter, éditer, supprimer, verrouiller ou déverrouiller ici de manière individuelle des forums et régler certains contrôles additionnels. Si certains de vos messages et de vos sujets ne sont plus synchronisés, vous pouvez également resynchroniser un forum. <strong>Vous devez copier ou régler les permissions de chaque forum nouvellement créé afin que ces derniers puissent être visibles publiquement.</strong>',
	'FORUM_AUTO_PRUNE'					=> 'Activer le délestage automatique ',
	'FORUM_AUTO_PRUNE_EXPLAIN'			=> 'Déleste les sujets du forum par rapport aux réglages de la fréquence et de la durée qui sont spécifiés ci-dessous.',
	'FORUM_CREATED'						=> 'Le forum a été créé.',
	'FORUM_DATA_NEGATIVE'				=> 'Les paramètres de délestage ne peuvent pas être négatifs.',
	'FORUM_DESC_TOO_LONG'				=> 'La description du forum est trop longue, elle doit être inférieure à 4000 caractères.',
	'FORUM_DELETE'						=> 'Supprimer un forum',
	'FORUM_DELETE_EXPLAIN'				=> 'Le formulaire ci-dessous vous permet de supprimer un forum. Si le forum contient des sous-forums, des sujets ou des messages, vous pouvez sélectionner l’emplacement où vous souhaitez déplacer ces derniers.',
	'FORUM_DELETED'						=> 'Le forum a été supprimé.',
	'FORUM_DESC'						=> 'Description ',
	'FORUM_DESC_EXPLAIN'				=> 'Tout code HTML qui est saisi ici sera affiché comme tel.',
	'FORUM_EDIT_EXPLAIN'				=> 'Le formulaire ci-dessous vous permet de personnaliser ce forum. Veuillez noter que la modération et les paramètres de contrôle du compteur de messages sont réglés par l’intermédiaire des permissions du forum de chaque utilisateur ou groupe d’utilisateurs.',
	'FORUM_IMAGE'						=> 'Image du forum ',
	'FORUM_IMAGE_EXPLAIN'				=> 'Image additionnelle à associer à ce forum dont l’emplacement est relatif à la racine du répertoire de phpBB.',
	'FORUM_IMAGE_NO_EXIST'				=> 'L’image du forum que vous avez spécifiée n’existe pas',
	'FORUM_LINK_EXPLAIN'				=> 'Lien complet (en incluant le protocole <samp>http://</samp>) qui redirigera les utilisateurs vers la destination spécifiée, comme <samp>http://www.phpbb.fr/</samp>.',
	'FORUM_LINK_TRACK'					=> 'Afficher le nombre de redirections ',
	'FORUM_LINK_TRACK_EXPLAIN'			=> 'Enregistre et affiche le nombre de visites vers le lien.',
	'FORUM_NAME'						=> 'Nom du forum ',
	'FORUM_NAME_EMPTY'					=> 'Vous devez saisir le nom de ce forum.',
	'FORUM_PARENT'						=> 'Forum parent ',
	'FORUM_PASSWORD'					=> 'Mot de passe du forum ',
	'FORUM_PASSWORD_CONFIRM'			=> 'Confirmer le mot de passe du forum ',
	'FORUM_PASSWORD_CONFIRM_EXPLAIN'	=> 'Ne complétez ce champ que si un mot de passe a déjà été spécifié concernant ce forum.',
	'FORUM_PASSWORD_EXPLAIN'			=> 'Met en place un mot de passe sur ce forum. Utilisez de préférence le système de permissions.',
	'FORUM_PASSWORD_UNSET'				=> 'Supprimer le mot de passe du forum ',
	'FORUM_PASSWORD_UNSET_EXPLAIN'		=> 'Ne cochez cette case que si vous souhaitez supprimer le mot de passe du forum.',
	'FORUM_PASSWORD_OLD'				=> 'Le mot de passe du forum utilise une méthode de hachage obsolète qu’il est préférable de modifier.',
	'FORUM_PASSWORD_MISMATCH'			=> 'Les mots de passe que vous avez saisis ne concordent pas.',
	'FORUM_PRUNE_SETTINGS'				=> 'Réglages du délestage de forum',
	'FORUM_RESYNCED'					=> 'Le forum « %s » a été resynchronisé',
	'FORUM_RULES_EXPLAIN'				=> 'Les règles du forum sont affichées sur toutes les pages de ce forum.',
	'FORUM_RULES_LINK'					=> 'Lien vers les règles du forum ',
	'FORUM_RULES_LINK_EXPLAIN'			=> 'Vous pouvez saisir ici le lien vers la page ou vers le message contenant les règles de votre forum. Ce réglage écrasera les règles du forum qui ont été antérieurement saisies sous forme textuelle.',
	'FORUM_RULES_PREVIEW'				=> 'Prévisualisation des règles du forum ',
	'FORUM_RULES_TOO_LONG'				=> 'Les règles du forum doivent être inférieures à 4000 caractères.',
	'FORUM_SETTINGS'					=> 'Réglages du forum',
	'FORUM_STATUS'						=> 'Statut du forum ',
	'FORUM_STYLE'						=> 'Style du forum ',
	'FORUM_TOPICS_PAGE'					=> 'Nombre de sujets par page ',
	'FORUM_TOPICS_PAGE_EXPLAIN'			=> 'Si cette valeur est autre que 0, elle écrasera le réglage par défaut du nombre de sujets par page.',
	'FORUM_TYPE'						=> 'Type de forum ',
	'FORUM_UPDATED'						=> 'Les informations du forum ont été mises à jour.',

	'FORUM_WITH_SUBFORUMS_NOT_TO_LINK'		=> 'Vous souhaitez modifier un forum contenant des sous-forums dans lesquels vous pouvez rédiger des messages en un forum-lien. Avant de procéder à cette opération, veuillez déplacer tous les sous-forums hors de ce forum, car une fois que le forum sera modifié en forum-lien, vous ne pourrez plus consulter ses sous-forums.',

	'GENERAL_FORUM_SETTINGS'	=> 'Réglages généraux du forum',

	'LINK'						=> 'Lien',
	'LIST_INDEX'				=> 'Lister les sous-forums dans la légende du forum parent ',
	'LIST_INDEX_EXPLAIN'		=> 'Affiche les sous-forums de ce forum sur l’index et sur différents endroits comme lien dans la légende de son forum parent si l’option « Lister les sous-forums dans la légende » est activée.',
	'LIST_SUBFORUMS'			=> 'Lister les sous-forums dans la légende ',
	'LIST_SUBFORUMS_EXPLAIN'	=> 'Affiche les sous-forums de ce forum sur l’index et sur différents endroits comme lien dans la légende de son forum parent si l’option « Lister les sous-forums dans la légende du forum parent » est activée.',
	'LOCKED'					=> 'Verrouillé',

	'MOVE_POSTS_NO_POSTABLE_FORUM'	=> 'Le forum que vous avez sélectionné afin d’y déplacer du contenu n’est pas approprié. Veuillez sélectionner un forum dans lequel il est possible de publier des messages.',
	'MOVE_POSTS_TO'					=> 'Déplacer les messages dans',
	'MOVE_SUBFORUMS_TO'				=> 'Déplacer les sous-forums dans',

	'NO_DESTINATION_FORUM'			=> 'Vous n’avez spécifié aucun forum afin d’y déplacer du contenu.',
	'NO_FORUM_ACTION'				=> 'Aucune action n’a été spécifiée afin de connaître ce qui doit se produire avec le contenu du forum.',
	'NO_PARENT'						=> 'Aucun parent',
	'NO_PERMISSIONS'				=> 'Ne pas copier les permissions',
	'NO_PERMISSION_FORUM_ADD'		=> 'Vous n’avez pas les permissions nécessaires afin d’ajouter des forums.',
	'NO_PERMISSION_FORUM_DELETE'	=> 'Vous n’avez pas les permissions nécessaires afin de supprimer des forums.',

	'PARENT_IS_LINK_FORUM'		=> 'Le forum parent que vous avez sélectionné est un forum-lien. Les forums-liens ne peuvent pas contenir d’autres forums, veuillez spécifier une catégorie ou un forum comme forum parent.',
	'PARENT_NOT_EXIST'			=> 'Le parent n’existe pas.',
	'PRUNE_ANNOUNCEMENTS'		=> 'Délester les annonces ',
	'PRUNE_STICKY'				=> 'Délester les notes ',
	'PRUNE_OLD_POLLS'			=> 'Délester les sondages obsolètes ',
	'PRUNE_OLD_POLLS_EXPLAIN'	=> 'Supprime les sujets contenant des sondages qui n’ont obtenu aucun vote durant le nombre de jours spécifié.',

	'REDIRECT_ACL'	=> 'Vous pouvez à présent %srégler les permissions%s de ce forum.',

	'SYNC_IN_PROGRESS'			=> 'Synchronisation du forum',
	'SYNC_IN_PROGRESS_EXPLAIN'	=> 'Resynchronisation des sujets %1$d/%2$d en cours.',

	'TYPE_CAT'			=> 'Catégorie',
	'TYPE_FORUM'		=> 'Forum',
	'TYPE_LINK'			=> 'Lien',

	'UNLOCKED'			=> 'Déverrouillé',
));

?>