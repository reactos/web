<?php
/**
*
* acp_attachments [French]
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
	'ACP_ATTACHMENT_SETTINGS_EXPLAIN'	=> 'Vous pouvez configurer ici les réglages principaux relatifs aux pièces jointes et les catégories spéciales associées.',
	'ACP_EXTENSION_GROUPS_EXPLAIN'		=> 'Vous pouvez ajouter, supprimer, modifier ou désactiver ici vos groupes d’extensions. Vous pouvez également leur attribuer des catégories spéciales, modifier le mécanisme de téléchargement et définir une icône de transfert qui sera affichée devant la pièce jointe appartenant au groupe.',
	'ACP_MANAGE_EXTENSIONS_EXPLAIN'		=> 'Vous pouvez gérer ici les extensions autorisées. Pour activer vos extensions, veuillez vous rendre sur le panneau de gestion des groupes d’extensions. Nous vous recommandons fortement de ne pas autoriser les extensions de langages de programmation (telles que <code>php</code>, <code>php3</code>, <code>php4</code>, <code>phtml</code>, <code>pl</code>, <code>cgi</code>, <code>py</code>, <code>rb</code>, <code>asp</code>, <code>aspx</code>, etc.).',
	'ACP_ORPHAN_ATTACHMENTS_EXPLAIN'	=> 'Vous pouvez consulter ici les fichiers orphelins. Ces fichiers se produisent la plupart du temps lorsque des utilisateurs insèrent des pièces jointes mais n’envoient pas le message. Vous pouvez supprimer ces fichiers ou les insérer à un des messages existants en spécifiant le numéro d’identification d’un message. La pièce jointe sera alors insérée au message que vous avez spécifié.',
	'ADD_EXTENSION'						=> 'Ajouter une extension',
	'ADD_EXTENSION_GROUP'				=> 'Ajouter un groupe d’extensions',
	'ADMIN_UPLOAD_ERROR'				=> 'Des erreurs sont survenues lors de l’insertion du fichier : « %s ».',
	'ALLOWED_FORUMS'					=> 'Forums autorisés ',
	'ALLOWED_FORUMS_EXPLAIN'			=> 'Permet d’insérer les extensions assignées dans les forums que vous avez sélectionnés.',
	'ALLOWED_IN_PM_POST'				=> 'Autorisé',
	'ALLOW_ATTACHMENTS'					=> 'Autoriser les pièces jointes',
	'ALLOW_ALL_FORUMS'					=> 'Autoriser dans tous les forums',
	'ALLOW_IN_PM'						=> 'Autorisé dans la messagerie privée ',
	'ALLOW_PM_ATTACHMENTS'				=> 'Autoriser les pièces jointes dans les messages privés',
	'ALLOW_SELECTED_FORUMS'				=> 'Uniquement dans les forums sélectionnés ci-dessous',
	'ASSIGNED_EXTENSIONS'				=> 'Extensions assignées ',
	'ASSIGNED_GROUP'					=> 'Groupe d’extensions assignées',
	'ATTACH_EXTENSIONS_URL'				=> 'Extensions',
	'ATTACH_EXT_GROUPS_URL'				=> 'Groupes d’extensions',
	'ATTACH_ID'							=> 'Identification ',
	'ATTACH_MAX_FILESIZE'				=> 'Taille maximale des fichiers',
	'ATTACH_MAX_FILESIZE_EXPLAIN'		=> 'Taille maximale de chaque fichier. Si cette valeur est réglée sur 0, la taille des fichiers transférable ne sera limitée que par votre configuration de PHP.',
	'ATTACH_MAX_PM_FILESIZE'			=> 'Taille maximale des fichiers dans les messages privés',
	'ATTACH_MAX_PM_FILESIZE_EXPLAIN'	=> 'Taille maximale de chaque fichier inséré à un message privé. Réglez cette valeur sur 0 afin de ne pas limiter la taille.',
	'ATTACH_ORPHAN_URL'					=> 'Pièces jointes orphelines',
	'ATTACH_POST_ID'					=> 'Identification du message',
	'ATTACH_QUOTA'						=> 'Quota maximum des pièces jointes',
	'ATTACH_QUOTA_EXPLAIN'				=> 'Espace de stockage maximum rendu disponible pour les pièces jointes dans la totalité du forum. Réglez cette valeur sur 0 afin de ne pas limiter l’espace de stockage.',
	'ATTACH_TO_POST'					=> 'Insérer une pièce jointe au message',

	'CAT_FLASH_FILES'			=> 'Fichiers Flash',
	'CAT_IMAGES'				=> 'Images',
	'CAT_QUICKTIME_FILES'		=> 'Fichiers QuickTime',
	'CAT_RM_FILES'				=> 'Fichiers RealMedia',
	'CAT_WM_FILES'				=> 'Fichiers Windows Media',
	'CHECK_CONTENT'				=> 'Vérifier les pièces jointes',
	'CHECK_CONTENT_EXPLAIN'		=> 'Certains navigateurs peuvent faire erreur en attribuant un type MIME incorrect aux fichiers transférés. Cette option permet de rejeter les fichiers qui présentent un risque de provoquer cette erreur.',
	'CREATE_GROUP'				=> 'Créer un nouveau groupe ',
	'CREATE_THUMBNAIL'			=> 'Générer des miniatures',
	'CREATE_THUMBNAIL_EXPLAIN'	=> 'Génère des miniatures dans toutes les situations possibles.',

	'DEFINE_ALLOWED_IPS'			=> 'Définir les adresses IP ou noms d’hôtes autorisés',
	'DEFINE_DISALLOWED_IPS'			=> 'Définir les adresses IP ou noms d’hôtes interdits',
	'DOWNLOAD_ADD_IPS_EXPLAIN'		=> 'Pour spécifier plusieurs adresses IP ou noms d’hôtes, saisissez chacun d’eux sur une nouvelle ligne. Pour spécifier une plage d’adresses IP, séparez le début et la fin par un tiret (-) et utilisez « * » comme joker.',
	'DOWNLOAD_REMOVE_IPS_EXPLAIN'	=> 'Vous pouvez supprimer ou ne plus exclure plusieurs adresses IP en une seule fois en utilisant la combinaison appropriée de la souris et du clavier de votre ordinateur et de votre navigateur. Les adresses IP exclues apparaissent sur fond bleu.',
	'DISPLAY_INLINED'				=> 'Afficher les images dans le message',
	'DISPLAY_INLINED_EXPLAIN'		=> 'Si cette option est désactivée, les images insérées en pièces jointes s’afficheront sous forme de lien.',
	'DISPLAY_ORDER'					=> 'Ordre d’affichage des pièces jointes',
	'DISPLAY_ORDER_EXPLAIN'			=> 'Affiche les pièces jointes triées par date croissante ou décroissante.',

	'EDIT_EXTENSION_GROUP'			=> 'Éditer le groupe d’extensions',
	'EXCLUDE_ENTERED_IP'			=> 'Activez cette option afin d’exclure l’adresse IP ou le nom d’hôte que vous avez sélectionné.',
	'EXCLUDE_FROM_ALLOWED_IP'		=> 'Exclure l’adresse IP des adresses IP ou des noms d’hôtes autorisés ',
	'EXCLUDE_FROM_DISALLOWED_IP'	=> 'Exclure l’adresse IP des adresses IP ou des noms d’hôtes interdits ',
	'EXTENSIONS_UPDATED'			=> 'Les extensions ont été mises à jour.',
	'EXTENSION_EXIST'				=> 'L’extension %s existe déjà.',
	'EXTENSION_GROUP'				=> 'Groupe d’extensions ',
	'EXTENSION_GROUPS'				=> 'Groupes d’extensions',
	'EXTENSION_GROUP_DELETED'		=> 'Le groupe d’extensions a été supprimé.',
	'EXTENSION_GROUP_EXIST'			=> 'Le groupe d’extensions %s existe déjà.',

	'EXT_GROUP_ARCHIVES'			=> 'Archives',
	'EXT_GROUP_DOCUMENTS'			=> 'Documents',
	'EXT_GROUP_DOWNLOADABLE_FILES'	=> 'Fichiers téléchargeables',
	'EXT_GROUP_FLASH_FILES'			=> 'Fichiers Flash',
	'EXT_GROUP_IMAGES'				=> 'Images',
	'EXT_GROUP_PLAIN_TEXT'			=> 'Texte brut',
	'EXT_GROUP_QUICKTIME_MEDIA'		=> 'QuickTime Media',
	'EXT_GROUP_REAL_MEDIA'			=> 'RealMedia',
	'EXT_GROUP_WINDOWS_MEDIA'		=> 'Windows Media',

	'GO_TO_EXTENSIONS'		=> 'Aller à l’écran de gestion des extensions',
	'GROUP_NAME'			=> 'Nom du groupe ',

	'IMAGE_LINK_SIZE'			=> 'Dimensions de l’image avant mise en lien',
	'IMAGE_LINK_SIZE_EXPLAIN'	=> 'Affiche les images insérées en pièces jointes sous forme de lien si elles dépassent les valeurs saisies ici. Réglez les valeurs sur 0 px par 0 px afin de désactiver ce comportement.',
	'IMAGICK_PATH'				=> 'Chemin d’Imagemagick',
	'IMAGICK_PATH_EXPLAIN'		=> 'Le chemin complet vers l’application de conversion Imagemagick, tel que <samp>/usr/bin/</samp>.',

	'MAX_ATTACHMENTS'				=> 'Nombre maximum de pièces jointes par message',
	'MAX_ATTACHMENTS_PM'			=> 'Nombre maximum de pièces jointes par message privé',
	'MAX_EXTGROUP_FILESIZE'			=> 'Taille maximale des fichiers ',
	'MAX_IMAGE_SIZE'				=> 'Dimensions maximales des images',
	'MAX_IMAGE_SIZE_EXPLAIN'		=> 'La taille maximale des images insérées en pièces jointes. Réglez ces deux valeurs sur 0 px par 0 px afin de désactiver la vérification des dimensions des images.',
	'MAX_THUMB_WIDTH'				=> 'Largeur maximale des miniatures',
	'MAX_THUMB_WIDTH_EXPLAIN'		=> 'Une miniature générée ne dépassera pas la largeur de la valeur spécifiée ici.',
	'MIN_THUMB_FILESIZE'			=> 'Taille minimale des miniatures',
	'MIN_THUMB_FILESIZE_EXPLAIN'	=> 'Ne génèrera pas de miniature si la taille des images est inférieure à cette valeur.',
	'MODE_INLINE'					=> 'Dans la ligne',
	'MODE_PHYSICAL'					=> 'Physique',

	'NOT_ALLOWED_IN_PM'			=> 'Uniquement autorisé dans les messages',
	'NOT_ALLOWED_IN_PM_POST'	=> 'Interdit',
	'NOT_ASSIGNED'				=> 'Non assigné',
	'NO_EXT_GROUP'				=> 'Aucun',
	'NO_EXT_GROUP_NAME'			=> 'Aucun nom de groupe n’a été saisi',
	'NO_EXT_GROUP_SPECIFIED'	=> 'Aucun groupe d’extensions n’a été spécifié.',
	'NO_FILE_CAT'				=> 'Aucune',
	'NO_IMAGE'					=> 'Aucune image',
	'NO_THUMBNAIL_SUPPORT'		=> 'Le support des miniatures a été désactivé. Pour que cette fonctionnalité fonctionne correctement, l’extension GD doit être disponible ou Imagemagick doit être installé. Les deux sont introuvables.',
	'NO_UPLOAD_DIR'				=> 'Le répertoire de transfert que vous avez spécifié n’existe pas.',
	'NO_WRITE_UPLOAD'			=> 'Le répertoire de transfert que vous avez spécifié n’est pas inscriptible. Veuillez modifier les permissions afin que le serveur internet puisse y écrire.',

	'ONLY_ALLOWED_IN_PM'	=> 'Uniquement autorisé dans les messages privés',
	'ORDER_ALLOW_DENY'		=> 'Autoriser',
	'ORDER_DENY_ALLOW'		=> 'Interdire',

	'REMOVE_ALLOWED_IPS'		=> 'Supprimer ou ne plus exclure des adresses IP ou des noms d’hôtes <em>autorisés</em>',
	'REMOVE_DISALLOWED_IPS'		=> 'Supprimer ou ne plus exclure des adresses IP ou des noms d’hôtes <em>interdits</em>',

	'SEARCH_IMAGICK'				=> 'Rechercher Imagemagick',
	'SECURE_ALLOW_DENY'				=> 'Mettre en place une liste d’autorisations ou d’interdictions',
	'SECURE_ALLOW_DENY_EXPLAIN'		=> 'Modifie le comportement par défaut lorsque les téléchargements sécurisés sont activés par la mise en place d’une liste d’autorisations ou la mise en place d’une liste d’interdictions sous forme de <strong>liste blanche</strong> ou de <strong>liste noire</strong>.',
	'SECURE_DOWNLOADS'				=> 'Activer les téléchargements sécurisés',
	'SECURE_DOWNLOADS_EXPLAIN'		=> 'Si cette option est activée, les téléchargements ne seront limités qu’aux adresses IP et aux noms d’hôtes que vous spécifiez.',
	'SECURE_DOWNLOAD_NOTICE'		=> 'Les téléchargements sécurisés ne sont pas activés. Les réglages ci-dessous ne seront appliqués qu’après avoir activé les téléchargements sécurisés.',
	'SECURE_DOWNLOAD_UPDATE_SUCCESS'=> 'La liste des adresses IP a été mise à jour.',
	'SECURE_EMPTY_REFERRER'			=> 'Autoriser les référants vides',
	'SECURE_EMPTY_REFERRER_EXPLAIN'	=> 'Les téléchargements sécurisés sont basés sur les référants. Souhaitez-vous autoriser les téléchargements à ceux qui omettent le référant ?',
	'SETTINGS_CAT_IMAGES'			=> 'Réglages des catégories d’images',
	'SPECIAL_CATEGORY'				=> 'Catégorie spéciale ',
	'SPECIAL_CATEGORY_EXPLAIN'		=> 'Les catégories spéciales modifient la présentation des messages.',
	'SUCCESSFULLY_UPLOADED'			=> 'Transféré avec succès.',
	'SUCCESS_EXTENSION_GROUP_ADD'	=> 'Le groupe d’extensions a été ajouté.',
	'SUCCESS_EXTENSION_GROUP_EDIT'	=> 'Les groupes d’extensions ont été mis à jour.',

	'UPLOADING_FILES'				=> 'Transfert de fichiers',
	'UPLOADING_FILE_TO'				=> 'Transfert du fichier « %1$s » au message numéro %2$d…',
	'UPLOAD_DENIED_FORUM'			=> 'Vous n’êtes pas autorisé(e) à transférer des fichiers vers le forum « %s ».',
	'UPLOAD_DIR'					=> 'Répertoire de transfert',
	'UPLOAD_DIR_EXPLAIN'			=> 'Chemin de stockage des pièces jointes. Veuillez noter que si vous modifiez ce répertoire, vous devrez copier manuellement toutes les pièces jointes existantes vers ce nouvel emplacement.',
	'UPLOAD_ICON'					=> 'Icône de transfert ',
	'UPLOAD_NOT_DIR'				=> 'Le répertoire de transfert que vous avez spécifié est incorrect.',
));

?>