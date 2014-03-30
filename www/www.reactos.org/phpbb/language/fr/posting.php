<?php
/**
*
* posting [French]
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
	'ADD_ATTACHMENT'			=> 'Transférer une pièce jointe',
	'ADD_ATTACHMENT_EXPLAIN'	=> 'Si vous souhaitez insérer un ou plusieurs fichiers, veuillez compléter les informations ci-dessous.',
	'ADD_FILE'					=> 'Ajouter le fichier',
	'ADD_POLL'					=> 'Création d’un sondage',
	'ADD_POLL_EXPLAIN'			=> 'Laissez ces champs vides si vous ne souhaitez pas ajouter de sondage à votre sujet.',
	'ALREADY_DELETED'			=> 'Ce message a déjà été supprimé.',
	'ATTACH_DISK_FULL'			=> 'Il n’y a pas assez d’espace disque de libre afin de publier cette pièce jointe.',
	'ATTACH_QUOTA_REACHED'		=> 'La limite du nombre de pièces jointes sur le forum a été atteinte.',
	'ATTACH_SIG'				=> 'Insérer une signature (modifiable depuis le panneau de contrôle de l’utilisateur)',

	'BBCODE_A_HELP'				=> 'Insérer une pièce jointe dans la ligne : [attachment=]nomdufichier.ext[/attachment]',
	'BBCODE_B_HELP'				=> 'Texte en gras : [b]texte[/b]',
	'BBCODE_C_HELP'				=> 'Afficher un code : [code]code[/code]',
	'BBCODE_D_HELP'				=> 'Flash : [flash=largeur,hauteur]http://lien[/flash]',
	'BBCODE_F_HELP'				=> 'Taille de la police de caractères : [size=85]texte de petite taille[/size]',
	'BBCODE_IS_OFF'				=> 'Le %sBBCode%s est <em>désactivé</em>',
	'BBCODE_IS_ON'				=> 'Le %sBBCode%s est <em>activé</em>',
	'BBCODE_I_HELP'				=> 'Texte en italique : [i]texte[/i]',
	'BBCODE_L_HELP'				=> 'Liste : [list][*]texte[/list]',
	'BBCODE_LISTITEM_HELP'		=> 'Objet d’une liste : [*]texte',
	'BBCODE_O_HELP'				=> 'Liste ordonnée : [list=1][*]Premier point[/list] ou [list=a][*]Point A[/list]',
	'BBCODE_P_HELP'				=> 'Insérer une image : [img]http://lien_de_l_image[/img]',
	'BBCODE_Q_HELP'				=> 'Citer un texte : [quote]texte[/quote]',
	'BBCODE_S_HELP'				=> 'Couleur de la police de caractères : [color=red]texte[/color] ou [color=#FF0000]texte[/color]',
	'BBCODE_U_HELP'				=> 'Souligner un texte : [u]texte[/u]',
	'BBCODE_W_HELP'				=> 'Insérer un lien : [url]http://lien[/url] ou [url=http://lien]texte du lien[/url]',
	'BBCODE_Y_HELP'				=> 'Liste : ajouter une liste d’objets',
	'BUMP_ERROR'				=> 'Vous ne pouvez pas remonter ce sujet aussitôt après en avoir publié un.',

	'CANNOT_DELETE_REPLIED'		=> 'Vous ne pouvez pas supprimer les messages qui comportent une ou plusieurs réponses.',
	'CANNOT_EDIT_POST_LOCKED'	=> 'Ce message a été verrouillé, vous ne pouvez désormais plus l’éditer.',
	'CANNOT_EDIT_TIME'			=> 'Vous ne pouvez désormais plus éditer ou supprimer ce message.',
	'CANNOT_POST_ANNOUNCE'		=> 'Vous n’êtes pas autorisé(e) à publier des annonces.',
	'CANNOT_POST_STICKY'		=> 'Vous n’êtes pas autorisé(e) à publier des notes.',
	'CHANGE_TOPIC_TO'			=> 'Modifier le type de sujet en',
	'CLOSE_TAGS'				=> 'Fermer les balises',
	'CURRENT_TOPIC'				=> 'Sujet actuel',

	'DELETE_FILE'				=> 'Supprimer le fichier',
	'DELETE_MESSAGE'			=> 'Supprimer le message',
	'DELETE_MESSAGE_CONFIRM'	=> 'Êtes-vous sûr(e) de vouloir supprimer ce message ?',
	'DELETE_OWN_POSTS'			=> 'Vous n’êtes autorisé(e) à supprimer que vos propres messages.',
	'DELETE_POST_CONFIRM'		=> 'Êtes-vous sûr(e) de vouloir supprimer ce message ?',
	'DELETE_POST_WARN'			=> 'Une fois supprimé, le message ne pourra pas être restauré',
	'DISABLE_BBCODE'			=> 'Désactiver le BBCode',
	'DISABLE_MAGIC_URL'			=> 'Ne pas analyser automatiquement la syntaxe des liens',
	'DISABLE_SMILIES'			=> 'Désactiver les émoticônes',
	'DISALLOWED_CONTENT'		=> 'Le transfert a été rejeté car le fichier transféré a été identifié comme un vecteur d’attaque possible.',
	'DISALLOWED_EXTENSION'		=> 'L’extension %s n’est pas autorisée.',
	'DRAFT_LOADED'				=> 'Le brouillon a été chargé dans la zone de rédaction, vous pouvez à présent finaliser votre message.<br />Votre brouillon sera supprimé après l’envoi de ce message.',
	'DRAFT_LOADED_PM'			=> 'Le brouillon a été chargé dans la zone de rédaction, vous pouvez à présent finaliser votre message privé.<br />Votre brouillon sera supprimé après l’envoi de ce message privé.',
	'DRAFT_SAVED'				=> 'Le brouillon a été sauvegardé.',
	'DRAFT_TITLE'				=> 'Titre du brouillon',

	'EDIT_REASON'				=> 'Raison de l’édition de ce message ',
	'EMPTY_FILEUPLOAD'			=> 'Le fichier transféré est vide.',
	'EMPTY_MESSAGE'				=> 'Vous devez saisir un message si vous souhaitez en publier un.',
	'EMPTY_REMOTE_DATA'			=> 'Le fichier n’a pas pu être transféré, veuillez essayer de le transférer manuellement.',

	'FLASH_IS_OFF'				=> 'La balise [flash] est <em>désactivée</em>',
	'FLASH_IS_ON'				=> 'La balise [flash] est <em>activée</em>',
	'FLOOD_ERROR'				=> 'Vous ne pouvez pas rédiger de message aussitôt après en avoir publié un.',
	'FONT_COLOR'				=> 'Couleur de la police ',
	'FONT_COLOR_HIDE'			=> 'Masquer la colorisation de la police',
	'FONT_HUGE'					=> 'Énorme',
	'FONT_LARGE'				=> 'Grande',
	'FONT_NORMAL'				=> 'Normale',
	'FONT_SIZE'					=> 'Taille de la police de caractères ',
	'FONT_SMALL'				=> 'Petite',
	'FONT_TINY'					=> 'Minuscule',

	'GENERAL_UPLOAD_ERROR'		=> 'Impossible de transférer la pièce jointe sur %s.',

	'IMAGES_ARE_OFF'			=> 'La balise [img] est <em>désactivée</em>',
	'IMAGES_ARE_ON'				=> 'La balise [img] est <em>activée</em>',
	'INVALID_FILENAME'			=> '%s est un nom de fichier incorrect.',

	'LOAD'						=> 'Charger',
	'LOAD_DRAFT'				=> 'Charger un brouillon',
	'LOAD_DRAFT_EXPLAIN'		=> 'Vous pouvez sélectionner ici le brouillon que vous souhaitez continuer à rédiger. Votre message actuel sera annulé et tout son contenu sera supprimé. Vous pouvez consulter, éditer et supprimer vos brouillons depuis le panneau de contrôle de l’utilisateur.',
	'LOGIN_EXPLAIN_BUMP'		=> 'Vous devez vous connecter afin de pouvoir remonter les sujets de ce forum.',
	'LOGIN_EXPLAIN_DELETE'		=> 'Vous devez vous connecter afin de pouvoir supprimer les sujets de ce forum.',
	'LOGIN_EXPLAIN_POST'		=> 'Vous devez vous connecter afin de pouvoir publier des messages dans ce forum.',
	'LOGIN_EXPLAIN_QUOTE'		=> 'Vous devez vous connecter afin de pouvoir citer des messages dans ce forum.',
	'LOGIN_EXPLAIN_REPLY'		=> 'Vous devez vous connecter afin de pouvoir répondre aux sujets de ce forum.',

	'MAX_FONT_SIZE_EXCEEDED'	=> 'Vous ne devez utiliser que les polices de caractères dont la taille est inférieure à %1$d.',
	'MAX_FLASH_HEIGHT_EXCEEDED'	=> 'Vos fichiers Flash ne doivent pas dépasser %1$d pixel(s) de haut.',
	'MAX_FLASH_WIDTH_EXCEEDED'	=> 'Vos fichiers Flash ne doivent pas dépasser %1$d pixel(s) de large.',
	'MAX_IMG_HEIGHT_EXCEEDED'	=> 'Vos images ne doivent pas dépasser %1$d pixel(s) de haut.',
	'MAX_IMG_WIDTH_EXCEEDED'	=> 'Vos images ne doivent pas dépasser %1$d pixel(s) de large.',

	'MESSAGE_BODY_EXPLAIN'		=> 'Saisissez votre message ici. Il ne doit contenir que <strong>%d</strong> caractère(s) au maximum.',
	'MESSAGE_DELETED'			=> 'Ce message a été supprimé.',
	'MORE_SMILIES'				=> 'Accéder à davantage d’émoticônes',

	'NOTIFY_REPLY'				=> 'M’envoyer une notification lorsqu’une réponse a été publiée',
	'NOT_UPLOADED'				=> 'Le fichier n’a pas pu être transféré.',
	'NO_DELETE_POLL_OPTIONS'	=> 'Vous ne pouvez pas supprimer les options déjà en place sur un sondage.',
	'NO_PM_ICON'				=> 'Aucune icône de MP',
	'NO_POLL_TITLE'				=> 'Vous devez saisir le titre du sondage.',
	'NO_POST'					=> 'Le message que vous souhaitez consulter n’existe pas.',
	'NO_POST_MODE'				=> 'Aucun mode de message n’a été spécifié.',

	'PARTIAL_UPLOAD'			=> 'Le fichier n’a été que partiellement transféré.',
	'PHP_SIZE_NA'				=> 'La taille de la pièce jointe est trop importante.<br />La taille maximale autorisée, située dans le fichier php.ini, n’a pas pu être déterminée.',
	'PHP_SIZE_OVERRUN'			=> 'La taille de la pièce jointe est trop importante, la taille maximale autorisée est de %1$d %2$s.<br />Veuillez noter que ce réglage est situé dans le fichier php.ini et qu’il ne peut pas être écrasé.',
	'PLACE_INLINE'				=> 'Insérer dans la ligne',
	'POLL_DELETE'				=> 'Supprimer le sondage ',
	'POLL_FOR'					=> 'Conserver le sondage pendant ',
	'POLL_FOR_EXPLAIN'			=> 'Saisissez « 0 » ou laissez vide afin de ne jamais terminer le sondage.',
	'POLL_MAX_OPTIONS'			=> 'Option(s) par utilisateur ',
	'POLL_MAX_OPTIONS_EXPLAIN'	=> 'Ceci est le nombre d’options que chaque utilisateur peut sélectionner lors de leur vote.',
	'POLL_OPTIONS'				=> 'Option(s) du sondage ',
	'POLL_OPTIONS_EXPLAIN'		=> 'Insérez chaque option sur une nouvelle ligne. Vous pouvez sélectionner jusqu’à <strong>%d</strong> option(s).',
	'POLL_OPTIONS_EDIT_EXPLAIN'	=> 'Insérez chaque option sur une nouvelle ligne. Vous pouvez sélectionner jusqu’à <strong>%d</strong> option(s). Si vous supprimez ou ajoutez une ou plusieurs options, tous les votes ayant été effectués seront réinitialisés.',
	'POLL_QUESTION'				=> 'Question du sondage ',
	'POLL_TITLE_TOO_LONG'		=> 'Le titre du sondage ne doit pas dépasser 100 caractères.',
	'POLL_TITLE_COMP_TOO_LONG'	=> 'La taille du titre de votre sondage est trop importante. Sachez que les BBCodes ou les émoticônes se sont pas pris en compte et qu’ils devraient par conséquent être supprimés.',
	'POLL_VOTE_CHANGE'			=> 'Autoriser les votes multiples ',
	'POLL_VOTE_CHANGE_EXPLAIN'	=> 'Si cette option est activée, les utilisateurs pourront modifier leurs votes.',
	'POSTED_ATTACHMENTS'		=> 'Pièces jointes publiées',
	'POST_APPROVAL_NOTIFY'		=> 'Une notification vous sera envoyé(e) lorsque votre message sera approuvé.',
	'POST_CONFIRMATION'			=> 'Confirmation du message',
	'POST_CONFIRM_EXPLAIN'		=> 'Pour éviter la publication de messages automatisés, vous devez saisir un code de confirmation. Le code est affiché dans l’image que vous devriez apercevoir ci-dessous. Si vous êtes visuellement déficient(e) ou que vous éprouvez des difficultés à lire ce code correctement, veuillez contacter l’%sadministrateur du forum%s.',
	'POST_DELETED'				=> 'Ce message a été supprimé.',
	'POST_EDITED'				=> 'Ce message a été édité.',
	'POST_EDITED_MOD'			=> 'Ce message a été édité mais il doit être approuvé par un modérateur afin d’être visible publiquement.',
	'POST_GLOBAL'				=> 'Annonce globale',
	'POST_ICON'					=> 'Icône de message',
	'POST_NORMAL'				=> 'Normal',
	'POST_REVIEW'				=> 'Prévisualisation du message',
	'POST_REVIEW_EDIT'			=> 'Prévisualisation du message',
	'POST_REVIEW_EDIT_EXPLAIN'	=> 'Ce message a été modifié par un autre utilisateur lorsque vous étiez en train de l’éditer. Si vous le souhaitez, vous pouvez prévisualiser la version actuelle de ce message et ajuster vos modifications.',
	'POST_REVIEW_EXPLAIN'		=> 'Au moins un nouveau message a été publié à partir de ce sujet. Si vous le souhaitez, vous pouvez consulter votre message qui apparaîtra en surbrillance.',
	'POST_STORED'				=> 'Ce message a été publié.',
	'POST_STORED_MOD'			=> 'Ce message a été envoyé mais il doit être approuvé par un modérateur afin d’être visible publiquement.',
	'POST_TOPIC_AS'				=> 'Publier le sujet en tant que',
	'PROGRESS_BAR'				=> 'Barre de progression',

	'QUOTE_DEPTH_EXCEEDED'		=> 'Vous ne pouvez insérer que %1$d citation(s) imbriquée(s).',

	'SAVE'						=> 'Sauvegarder',
	'SAVE_DATE'					=> 'Sauvegardé le',
	'SAVE_DRAFT'				=> 'Sauvegarder le brouillon',
	'SAVE_DRAFT_CONFIRM'		=> 'Veuillez noter que les brouillons sauvegardés n’incluent que le sujet et le message, tout autre élément sera supprimé. Souhaitez-vous sauvegarder votre brouillon dès à présent ?',
	'SMILIES'					=> 'Émoticônes',
	'SMILIES_ARE_OFF'			=> 'Les émoticônes sont <em>désactivées</em>',
	'SMILIES_ARE_ON'			=> 'Les émoticônes sont <em>activées</em>',
	'STICKY_ANNOUNCE_TIME_LIMIT'=> 'Durée limite de la note/annonce',
	'STICK_TOPIC_FOR'			=> 'Durée limite de la note ',
	'STICK_TOPIC_FOR_EXPLAIN'	=> 'Saisissez « 0 » ou laissez cette case vide afin de ne jamais terminer la note ou l’annonce. Veuillez noter que ce nombre est relatif à la date du message.',
	'STYLES_TIP'				=> 'Astuce : les mises en forme peuvent rapidement être appliquées en sélectionnant le texte.',

	'TOO_FEW_CHARS'				=> 'Votre message ne contient pas assez de caractères.',
	'TOO_FEW_CHARS_LIMIT'		=> 'Votre message contient %1$d caractère(s). Vous devez saisir au moins %2$d caractères.',
	'TOO_FEW_POLL_OPTIONS'		=> 'Vous devez saisir au moins deux options afin de créer le sondage.',
	'TOO_MANY_ATTACHMENTS'		=> 'Impossible d’ajouter une nouvelle pièce jointe, la limite maximale est de %d.',
	'TOO_MANY_CHARS'			=> 'Votre message contient trop de caractères.',
	'TOO_MANY_CHARS_POST'		=> 'Votre message contient %1$d caractère(s). Le nombre maximum de caractères autorisés est de %2$d.',
	'TOO_MANY_CHARS_SIG'		=> 'Votre signature contient %1$d caractère(s). Le nombre maximum de caractères autorisés est de %2$d.',
	'TOO_MANY_POLL_OPTIONS'		=> 'Vous avez essayé de voter pour un trop grand nombre d’options.',
	'TOO_MANY_SMILIES'			=> 'Votre message contient trop d’émoticônes. Le nombre maximum d’émoticônes autorisées est de %d.',
	'TOO_MANY_URLS'				=> 'Votre message contient trop de liens. Le nombre maximum de liens autorisés est de %d.',
	'TOO_MANY_USER_OPTIONS'		=> 'Vous ne pouvez pas spécifier autant d’options par utilisateur car le sondage en contient moins.',
	'TOPIC_BUMPED'				=> 'Le sujet a été remonté.',

	'UNAUTHORISED_BBCODE'		=> 'Vous ne pouvez pas utiliser certains BBCodes : %s.',
	'UNGLOBALISE_EXPLAIN'		=> 'Pour rétablir cette annonce globale en sujet standard, vous devez sélectionner le forum dans lequel vous souhaitez que ce sujet soit affiché.',
	'UPDATE_COMMENT'			=> 'Mettre à jour la description',
	'URL_INVALID'				=> 'Le lien que vous avez spécifié est incorrect.',
	'URL_NOT_FOUND'				=> 'Le fichier que vous avez spécifié est introuvable.',
	'URL_IS_OFF'				=> 'La balise [url] est <em>désactivée</em>',
	'URL_IS_ON'					=> 'La balise [url] est <em>activée</em>',
	'USER_CANNOT_BUMP'			=> 'Vous ne pouvez pas remonter les sujets de ce forum.',
	'USER_CANNOT_DELETE'		=> 'Vous ne pouvez pas supprimer les messages de ce forum.',
	'USER_CANNOT_EDIT'			=> 'Vous ne pouvez pas éditer les messages de ce forum.',
	'USER_CANNOT_REPLY'			=> 'Vous ne pouvez pas répondre aux messages de ce forum.',
	'USER_CANNOT_FORUM_POST'	=> 'Vous n’êtes pas autorisé(e) à publier des messages dans ce type de forum.',

	'VIEW_MESSAGE'				=> '%sConsulter le message que vous avez envoyé%s',
	'VIEW_PRIVATE_MESSAGE'		=> '%sConsulter le message privé que vous avez envoyé%s',

	'WRONG_FILESIZE'			=> 'Le fichier est trop lourd, la taille maximale autorisée est de %1d %2s.',
	'WRONG_SIZE'				=> 'La taille de l’image doit mesurer moins de %1$d pixel(s) de large et %2$d pixel(s) de haut et plus de %3$d pixel(s) de large et %4$d pixel(s) de haut. L’image que vous avez envoyée mesure %5$d pixel(s) de large et %6$d pixel(s) de haut.',
));

?>
