<?php
/**
*
* acp_posting [French]
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

// BBCodes
// Note to translators: you can translate everything but what's between { and }
$lang = array_merge($lang, array(
	'ACP_BBCODES_EXPLAIN'		=> 'Le BBCode est une implémentation spéciale du HTML qui offre un meilleur contrôle sur la mise en forme. De cette page, vous pouvez ajouter, supprimer et éditer des BBCodes personnalisés.',
	'ADD_BBCODE'				=> 'Ajouter un nouveau BBCode',

	'BBCODE_DANGER'				=> 'Le BBCode que vous essayez d’ajouter semble utiliser une chaîne de symboles {TEXT} dans un attribut HTML. Cela peut présenter une éventuelle faille de sécurité XSS. Veuillez plutôt essayer d’utiliser un type plus restrictif, tel que {SIMPLETEXT} ou {INTTEXT}. Ne procédez à cette opération que si vous comprenez les risque encourus et que vous considérez que l’utilisation de {TEXT} est absolumement inévitable.',
	'BBCODE_DANGER_PROCEED'		=> 'Procéder', //'I understand the risk',

	'BBCODE_ADDED'				=> 'Le BBCode a été ajouté.',
	'BBCODE_EDITED'				=> 'Le BBCode a été édité.',
	'BBCODE_NOT_EXIST'			=> 'Le BBCode que vous avez sélectionné n’existe pas.',
	'BBCODE_HELPLINE'			=> 'Ligne d’aide',
	'BBCODE_HELPLINE_EXPLAIN'	=> 'Ce champ contient le texte qui sera affiché lors du passage de la souris sur le BBCode.',
	'BBCODE_HELPLINE_TEXT'		=> 'Texte de la ligne d’aide',
	'BBCODE_HELPLINE_TOO_LONG'	=> 'La ligne d’aide que vous avez saisie est trop longue.',

	'BBCODE_INVALID_TAG_NAME'	=> 'Le nom de la balise BBCode que vous avez saisi existe déjà.',
	'BBCODE_INVALID'			=> 'Votre BBCode est construit dans une architecture incorrecte.',
	'BBCODE_OPEN_ENDED_TAG'		=> 'Votre BBCode personnalisé doit contenir à la fois une balise d’ouverture et de fermeture.',
	'BBCODE_TAG'				=> 'Balise',
	'BBCODE_TAG_TOO_LONG'		=> 'Le nom de la balise que vous avez saisi est trop long.',
	'BBCODE_TAG_DEF_TOO_LONG'	=> 'La définition de la balise que vous avez saisie est trop longue, veuillez la raccourcir.',
	'BBCODE_USAGE'				=> 'Utilité du BBCode',
	'BBCODE_USAGE_EXAMPLE'		=> '[highlight={COLOR}]{TEXT}[/highlight]<br /><br />[font={SIMPLETEXT1}]{SIMPLETEXT2}[/font]',
	'BBCODE_USAGE_EXPLAIN'		=> 'Vous pouvez spécifier ici comment utiliser le BBCode. Remplacez les variables des éléments par les chaînes de symboles correspondantes (%svoir ci-dessous%s).',

	'EXAMPLE'						=> 'Exemple :',
	'EXAMPLES'						=> 'Exemples :',

	'HTML_REPLACEMENT'				=> 'Remplacement de l’HTML',
	'HTML_REPLACEMENT_EXAMPLE'		=> '&lt;span style="background-color: {COLOR};"&gt;{TEXT}&lt;/span&gt;<br /><br />&lt;span style="font-family: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;',
	'HTML_REPLACEMENT_EXPLAIN'		=> 'Vous pouvez spécifier ici le remplacement de l’HTML par défaut. N’oubliez pas de restaurer la chaîne de symboles de l’élément que vous avez utilisé ci-dessus !',

	'TOKEN'					=> 'Chaîne de symboles',
	'TOKENS'				=> 'Chaînes de symboles',
	'TOKENS_EXPLAIN'		=> 'Les chaînes de symboles sont des conteneurs pour les entrées des utilisateurs. Les entrées ne seront validées que si elles trouvent la définition correspondante. Si besoin, vous pouvez les numéroter en ajoutant un nombre entre des accolades comme dernier caractère, tel que {TEXT1}, {TEXT2}, etc.<br /><br />Dans le remplacement de l’HTML, vous pouvez également utiliser une chaîne de langue dans votre répertoire language/ tel que {L_<em>&lt;NOMDELACHAÎNE&gt;</em>} où <em>&lt;NOMDELACHAÎNE&gt;</em> est le nom de la chaîne traduite que vous souhaitez ajouter. Par exemple, {L_WROTE} sera affiché en tant que « a écrit » ou sa traduction selon la langue locale de l’utilisateur.<br /><br /><strong>Veuillez noter que seules les chaînes listées ci-dessous sont autorisées à être utilisées dans les BBCodes personnalisés.</strong>',
	'TOKEN_DEFINITION'		=> 'Qu’est-ce que c’est ?',
	'TOO_MANY_BBCODES'		=> 'Vous ne pouvez pas créer d’autres BBCodes. Veuillez supprimer un ou plusieurs BBCodes, puis réessayer.',

	'tokens'	=>	array(
		'TEXT'			=> 'Du texte, incluant les caractères étrangers, les chiffres, etc. Vous ne devriez pas utiliser cette chaîne de symboles dans les balises HTML. Essayez d’utiliser à la place IDENTIFIER, INTTEXT ou SIMPLETEXT.',
		'SIMPLETEXT'	=> 'Des caractères de l’alphabet latin (A-Z), des chiffres, des espaces, des virgules, des points, des tirets, des tirets bas et des signes plus et moins.',
		'INTTEXT'		=> 'Des lettres de caractères Unicode, des chiffres, des espaces, des virgules, des points, des tirets bas et des espaces insécables et des signes plus et moins.',
		'IDENTIFIER'	=> 'Des caractères de l’alphabet latin (A-Z), des chiffres, des tirets et des tirets bas.',
		'NUMBER'		=> 'Une série de chiffres.',
		'EMAIL'			=> 'Une adresse de courrier électronique valide.',
		'URL'			=> 'Une adresse universelle valide utilisant n’importe quel protocole (http, ftp, etc.) ne pouvant pas être utilisée pour des injections de Javascript. Si aucun protocole n’est fourni, « http:// » sera utilisé par défaut.',
		'LOCAL_URL'		=> 'Une adresse universelle locale. L’adresse doit être relative à la page du sujet et ne doit pas contenir de nom de serveur ou de protocole, tels que des liens qui sont précédés de « %s »',
		'RELATIVE_URL'	=> 'Une adresse universelle relative. Vous pouvez utiliser des résultats partiels d’une adresse universelle, mais soyez vigilant : une adresse universelle complète est une adresse universelle relative valide. Lorsque vous souhaitez utiliser les adresses universelles relatives de votre forum, utilisez la variable LOCAL_URL.',
		'COLOR'			=> 'Une couleur HTML qui peut être dans une forme hexadécimale <samp>#FF1234</samp> ou un <a href="http://www.w3.org/TR/CSS21/syndata.html#value-def-color">nom de couleur CSS</a>, tel que <samp>fuchsia</samp> ou <samp>InactiveBorder</samp>.'
	)
));

// Smilies and topic icons
$lang = array_merge($lang, array(
	'ACP_ICONS_EXPLAIN'		=> 'Vous pouvez ajouter, supprimer ou éditer ici les icônes que les utilisateurs peuvent insérer à leurs sujets et leurs messages. Ces icônes sont généralement affichées à côté des titres des sujets sur la liste des forums ou à côté des titres des messages sur la liste des sujets. Vous pouvez également installer et créer de nouvelles archives d’icônes.',
	'ACP_SMILIES_EXPLAIN'	=> 'Les émoticônes sont généralement de petites images, parfois animées, qui sont utilisées afin d’exprimer une émotion ou un sentiment. De cette page, vous pouvez ajouter, supprimer et éditer les émoticônes que les utilisateurs insèrent dans leurs messages et leurs messages privés. Vous pouvez également installer et créer de nouvelles archives d’émoticônes.',
	'ADD_SMILIES'			=> 'Ajouter plusieurs émoticônes',
	'ADD_SMILEY_CODE'		=> 'Ajouter un code d’émoticône additionnel',
	'ADD_ICONS'				=> 'Ajouter plusieurs icônes',
	'AFTER_ICONS'			=> 'Après %s',
	'AFTER_SMILIES'			=> 'Après %s',

	'CODE'						=> 'Code ',
	'CURRENT_ICONS'				=> 'Icônes actuelles',
	'CURRENT_ICONS_EXPLAIN'		=> 'Choisissez ce que vous souhaitez faire des icônes actuellement installées.',
	'CURRENT_SMILIES'			=> 'Émoticônes actuelles',
	'CURRENT_SMILIES_EXPLAIN'	=> 'Choisissez ce que vous souhaitez faire des émoticônes actuellement installées.',

	'DISPLAY_ON_POSTING'		=> 'Afficher sur la page de rédaction',
	'DISPLAY_POSTING'			=> 'Sur la page de rédaction',
	'DISPLAY_POSTING_NO'		=> 'Pas sur la page de rédaction',



	'EDIT_ICONS'				=> 'Éditer les icônes',
	'EDIT_SMILIES'				=> 'Éditer les émoticônes',
	'EMOTION'					=> 'Émotion',
	'EXPORT_ICONS'				=> 'Exporter et télécharger icons.pak',
	'EXPORT_ICONS_EXPLAIN'		=> '%sEn cliquant sur ce lien, la configuration des icônes que vous avez installées sera archivée dans <samp>icons.pak</samp> qui, une fois téléchargé, pourra être utilisé afin de créer un fichier <samp>.zip</samp> ou <samp>.tgz</samp> qui contiendra toutes vos icônes, ainsi que le fichier de configuration <samp>icons.pak</samp>%s.',
	'EXPORT_SMILIES'			=> 'Exporter et télécharger smilies.pak',
	'EXPORT_SMILIES_EXPLAIN'	=> '%sEn cliquant sur ce lien, la configuration des émoticônes que vous avez installées sera archivée dans <samp>smilies.pak</samp> qui, une fois téléchargé, pourra être utilisé afin de créer un fichier <samp>.zip</samp> ou <samp>.tgz</samp> qui contiendra toutes vos émoticônes, ainsi que le fichier de configuration <samp>smilies.pak</samp>%s.',

	'FIRST'			=> 'Premier',

	'ICONS_ADD'				=> 'Ajouter une nouvelle icône',
	'ICONS_NONE_ADDED'		=> 'Aucune icône n’a été ajoutée.',
	'ICONS_ONE_ADDED'		=> 'L’icône a été ajoutée.',
	'ICONS_ADDED'			=> 'Les icônes ont été ajoutées.',
	'ICONS_CONFIG'			=> 'Configuration de l’icône',
	'ICONS_DELETED'			=> 'L’icône a été supprimée.',
	'ICONS_EDIT'			=> 'Éditer l’icône',
	'ICONS_ONE_EDITED'		=> 'L’icône a été mise à jour.',
	'ICONS_NONE_EDITED'		=> 'Aucune icône n’a été mise à jour.',
	'ICONS_EDITED'			=> 'Les icônes ont été mises à jour.',
	'ICONS_HEIGHT'			=> 'Hauteur de l’icône',
	'ICONS_IMAGE'			=> 'Image de l’icône',
	'ICONS_IMPORTED'		=> 'L’archive d’icônes a été installée.',
	'ICONS_IMPORT_SUCCESS'	=> 'L’archive d’icônes a été importée.',
	'ICONS_LOCATION'		=> 'Emplacement de l’icône',
	'ICONS_NOT_DISPLAYED'	=> 'Les icônes suivantes ne sont pas affichées sur la page de rédaction',
	'ICONS_ORDER'			=> 'Position de l’icône',
	'ICONS_URL'				=> 'Image de l’icône',
	'ICONS_WIDTH'			=> 'Largeur de l’icône',
	'IMPORT_ICONS'			=> 'Installer une archive d’icônes',
	'IMPORT_SMILIES'		=> 'Installer une archive d’émoticônes',

	'KEEP_ALL'			=> 'Tout conserver',

	'MASS_ADD_SMILIES'	=> 'Ajouter plusieurs émoticônes',

	'NO_ICONS_ADD'		=> 'Impossible d’ajouter une icône car aucune icône n’est disponible.',
	'NO_ICONS_EDIT'		=> 'Impossible de modifier une icône car aucune icône n’est disponible.',
	'NO_ICONS_EXPORT'	=> 'Vous n’avez aucune icône permettant de créer une archive.',
	'NO_ICONS_PAK'		=> 'Aucune archive d’icônes n’a été trouvée.',
	'NO_SMILIES_ADD'	=> 'Impossible d’ajouter une émoticône car aucune émoticône n’est disponible.',
	'NO_SMILIES_EDIT'	=> 'Impossible de modifier une émoticône car aucune émoticône n’est disponible.',
	'NO_SMILIES_EXPORT'	=> 'Vous n’avez aucune émoticône permettant de créer une archive.',
	'NO_SMILIES_PAK'	=> 'Aucune archive d’émoticônes n’a été trouvée.',

	'PAK_FILE_NOT_READABLE'		=> 'Impossible de lire le fichier <samp>.pak</samp>.',

	'REPLACE_MATCHES'	=> 'Remplacer les résultats',

	'SELECT_PACKAGE'			=> 'Sélectionner une archive',
	'SMILIES_ADD'				=> 'Ajouter une nouvelle émoticône',
	'SMILIES_NONE_ADDED'		=> 'Aucune émoticône n’a été ajoutée.',
	'SMILIES_ONE_ADDED'			=> 'L’émoticône a été ajoutée.',
	'SMILIES_ADDED'				=> 'Les émoticônes ont été ajoutées.',
	'SMILIES_CODE'				=> 'Code de l’émoticône',
	'SMILIES_CONFIG'			=> 'Configuration de l’émoticône',
	'SMILIES_DELETED'			=> 'L’émoticône a été supprimée.',
	'SMILIES_EDIT'				=> 'Éditer l’émoticône',
	'SMILIE_NO_CODE'			=> 'L’émoticône « %s » a été ignorée car aucun code n’a été spécifié.',
	'SMILIE_NO_EMOTION'			=> 'L’émoticône « %s » a été ignorée car aucune émoticône n’a été spécifiée.',
	'SMILIE_NO_FILE'			=> 'L’émoticône « %s » a été ignorée car le fichier est manquant.',
	'SMILIES_NONE_EDITED'		=> 'Aucune émoticône n’a été mise à jour.',
	'SMILIES_ONE_EDITED'		=> 'L’émoticône a été mise à jour.',
	'SMILIES_EDITED'			=> 'Les émoticônes ont été mises à jour.',
	'SMILIES_EMOTION'			=> 'Émotion',
	'SMILIES_HEIGHT'			=> 'Hauteur de l’émoticône',
	'SMILIES_IMAGE'				=> 'Image de l’émoticône',
	'SMILIES_IMPORTED'			=> 'L’archive d’émoticônes a été installée.',
	'SMILIES_IMPORT_SUCCESS'	=> 'L’archive d’émoticônes a été importée.',
	'SMILIES_LOCATION'			=> 'Emplacement de l’émoticône',
	'SMILIES_NOT_DISPLAYED'		=> 'Les émoticônes suivantes ne sont pas affichées sur la page de rédaction',
	'SMILIES_ORDER'				=> 'Position de l’émoticône',
	'SMILIES_URL'				=> 'Image de l’émoticône',
	'SMILIES_WIDTH'				=> 'Largeur de l’émoticône',

	'TOO_MANY_SMILIES'			=> 'La limite de %d émoticône(s) a été atteinte.',

	'WRONG_PAK_TYPE'	=> 'L’archive spécifiée ne contient pas les données appropriées.',
));

// Word censors
$lang = array_merge($lang, array(
	'ACP_WORDS_EXPLAIN'		=> 'Vous pouvez ajouter, éditer et supprimer ici les mots qui seront automatiquement censurés sur votre forum. Les visiteurs pourront tout de même s’inscrire avec des noms d’utilisateurs contenant ces mots. Les jokers (*) sont acceptés dans les champs. Par exemple, *test* censurera détestable, test* censurera testament, *test censurera alcootest.',
	'ADD_WORD'				=> 'Ajouter un nouveau mot',

	'EDIT_WORD'		=> 'Éditer la censure de mot',
	'ENTER_WORD'	=> 'Vous devez saisir un mot et son remplacement.',

	'NO_WORD'	=> 'Aucun mot n’a été sélectionné afin d’être édité.',

	'REPLACEMENT'	=> 'Remplacement',

	'UPDATE_WORD'	=> 'Mettre à jour la censure de mot',

	'WORD'				=> 'Mot',
	'WORD_ADDED'		=> 'La censure de mot a été ajoutée.',
	'WORD_REMOVED'		=> 'La censure de mot que vous avez sélectionnée a été supprimée.',
	'WORD_UPDATED'		=> 'La censure de mot que vous avez sélectionnée a été mise à jour.',
));

// Ranks
$lang = array_merge($lang, array(
	'ACP_RANKS_EXPLAIN'		=> 'Vous pouvez ajouter, éditer, consulter et supprimer ici des rangs. Vous pouvez également créer des rangs personnalisés qui peuvent être mis en place sur certains de vos utilisateurs par l’intermédiaire de la page de gestion des utilisateurs.',
	'ADD_RANK'				=> 'Ajouter un nouveau rang',

	'MUST_SELECT_RANK'		=> 'Vous devez sélectionner un rang.',

	'NO_ASSIGNED_RANK'		=> 'Aucun rang spécial n’a été mis en place.',
	'NO_RANK_TITLE'			=> 'Vous n’avez pas spécifié le titre du rang.',
	'NO_UPDATE_RANKS'		=> 'Le rang a été supprimé. Cependant, les comptes des utilisateurs qui utilisent ce rang n’ont pas été mis à jour. Vous devrez réinitialiser manuellement le rang de ces comptes.',

	'RANK_ADDED'			=> 'Le rang a été ajouté.',
	'RANK_IMAGE'			=> 'Image du rang ',
	'RANK_IMAGE_EXPLAIN'	=> 'Utilisez ceci afin de définir une petite image à associer au rang. Le chemin est relatif à la racine du répertoire de phpBB.',
	'RANK_IMAGE_IN_USE'		=> '(En cours d’utilisation)',
	'RANK_MINIMUM'			=> 'Messages minimums ',
	'RANK_REMOVED'			=> 'Le rang a été supprimé.',
	'RANK_SPECIAL'			=> 'Définir comme rang spécial ',
	'RANK_TITLE'			=> 'Titre du rang ',
	'RANK_UPDATED'			=> 'Le rang a été mis à jour.',
));

// Disallow Usernames
$lang = array_merge($lang, array(
	'ACP_DISALLOW_EXPLAIN'	=> 'Vous pouvez contrôler ici les noms d’utilisateurs qui ne sont pas autorisés à être utilisés. Les noms d’utilisateurs interdits sont autorisés à contenir un joker « * ».',
	'ADD_DISALLOW_EXPLAIN'	=> 'Vous pouvez interdire un nom d’utilisateur en utilisant un joker « * » afin de remplacer n’importe quel caractère.',
	'ADD_DISALLOW_TITLE'	=> 'Ajouter un nom d’utilisateur interdit',

	'DELETE_DISALLOW_EXPLAIN'	=> 'Vous pouvez supprimer un nom d’utilisateur interdit en sélectionnant dans cette liste le nom d’utilisateur souhaité et en cliquant sur « Envoyer ».',
	'DELETE_DISALLOW_TITLE'		=> 'Supprimer un nom d’utilisateur interdit',
	'DISALLOWED_ALREADY'		=> 'Le nom d’utilisateur que vous avez saisi est déjà interdit.',
	'DISALLOWED_DELETED'		=> 'Le nom d’utilisateur interdit a été supprimé.',
	'DISALLOW_SUCCESSFUL'		=> 'Le nom d’utilisateur interdit a été ajouté.',

	'NO_DISALLOWED'				=> 'Aucun nom d’utilisateur interdit',
	'NO_USERNAME_SPECIFIED'		=> 'Vous n’avez sélectionné aucun nom d’utilisateur afin d’effectuer cette opération.',
));

// Reasons
$lang = array_merge($lang, array(
	'ACP_REASONS_EXPLAIN'	=> 'Vous pouvez gérer ici les raisons utilisées dans les rapports lors de la désapprobation de messages. Il y a une raison par défaut (marquée avec « * ») que vous ne pouvez pas supprimer car elle est réservée aux messages personnalisés lorsqu’aucune raison n’est spécifiée.',
	'ADD_NEW_REASON'		=> 'Ajouter une nouvelle raison',
	'AVAILABLE_TITLES'		=> 'Titres des raisons traduites disponibles',

	'IS_NOT_TRANSLATED'			=> 'La raison n’a <strong>pas</strong> été traduite.',
	'IS_NOT_TRANSLATED_EXPLAIN'	=> 'La raison n’a <strong>pas</strong> été traduite. Si vous souhaitez renseigner le formulaire, spécifiez la clé des fichiers de langue dans la section des raisons de rapports.',
	'IS_TRANSLATED'				=> 'La raison a été traduite.',
	'IS_TRANSLATED_EXPLAIN'		=> 'La raison a été traduite. Si le titre que vous avez saisi ici est spécifié dans les fichiers de langue situés dans la section des raisons de rapports, le formulaire du titre et de la description traduit sera utilisé.',

	'NO_REASON'					=> 'La raison est introuvable.',
	'NO_REASON_INFO'			=> 'Vous devez spécifier le titre et la description de cette raison.',
	'NO_REMOVE_DEFAULT_REASON'	=> 'Vous ne pouvez pas supprimer la raison par défaut « Divers ».',

	'REASON_ADD'				=> 'Ajouter une raison',
	'REASON_ADDED'				=> 'La raison a été ajoutée.',
	'REASON_ALREADY_EXIST'		=> 'Une raison portant ce titre existe déjà. Veuillez spécifier un autre titre.',
	'REASON_DESCRIPTION'		=> 'Description de la raison ',
	'REASON_DESC_TRANSLATED'	=> 'Description de la raison affichée',
	'REASON_EDIT'				=> 'Éditer la raison',
	'REASON_EDIT_EXPLAIN'		=> 'Vous pouvez ajouter ou éditer ici une raison. Si la raison est traduite, la traduction sera utilisée au lieu de la description qui a été spécifiée ici.',
	'REASON_REMOVED'			=> 'La raison a été supprimée.',
	'REASON_TITLE'				=> 'Titre de la raison ',
	'REASON_TITLE_TRANSLATED'	=> 'Titre de la raison affiché',
	'REASON_UPDATED'			=> 'La raison a été mise à jour.',

	'USED_IN_REPORTS'		=> 'Utilisé dans les rapports',
));

?>