<?php
/**
*
* acp_profile [French]
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

// Custom profile fields
$lang = array_merge($lang, array(
	'ADDED_PROFILE_FIELD'	=> 'Le champ de profil personnalisé a été ajouté.',
	'ALPHA_ONLY'			=> 'Lettres et chiffres uniquement',
	'ALPHA_SPACERS'			=> 'Lettres, chiffres et séparateurs',
	'ALWAYS_TODAY'			=> 'Toujours la date actuelle',

	'BOOL_ENTRIES_EXPLAIN'	=> 'Saisissez à présent vos options',
	'BOOL_TYPE_EXPLAIN'		=> 'Détermine le type, soit une case à cocher, soit un bouton radio. Les cases à cocher ne seront affichées que si cela est coché pour un utilisateur spécifique. Dans ce cas, la <strong>seconde</strong> option de langue sera utilisée. Les boutons radios seront affichés sans prendre en compte leur valeur.',

	'CHANGED_PROFILE_FIELD'		=> 'Le champ de profil a été modifié.',
	'CHARS_ANY'					=> 'N’importe quel caractère',
	'CHECKBOX'					=> 'Case à cocher',
	'COLUMNS'					=> 'Colonnes',
	'CP_LANG_DEFAULT_VALUE'		=> 'Valeur par défaut',
	'CP_LANG_EXPLAIN'			=> 'Description du champ',
	'CP_LANG_EXPLAIN_EXPLAIN'	=> 'La description de ce champ est affichée aux utilisateurs.',
	'CP_LANG_NAME'				=> 'Nom ou titre du champ affiché aux utilisateurs',
	'CP_LANG_OPTIONS'			=> 'Options',
	'CREATE_NEW_FIELD'			=> 'Créer un nouveau champ',
	'CUSTOM_FIELDS_NOT_TRANSLATED'	=> 'Au moins un champ de profil personnalisé n’a pas encore été traduit. Veuillez compléter l’information demandée en cliquant sur le lien « Traduire ».',

	'DEFAULT_ISO_LANGUAGE'			=> 'Langue par défaut [%s]',
	'DEFAULT_LANGUAGE_NOT_FILLED'	=> 'Les éléments de langue de la langue par défaut ne sont pas spécifiés concernant ce champ de profil.',
	'DEFAULT_VALUE'					=> 'Valeur par défaut ',
	'DELETE_PROFILE_FIELD'			=> 'Supprimer le champ de profil',
	'DELETE_PROFILE_FIELD_CONFIRM'	=> 'Êtes-vous sûr(e) de vouloir supprimer ce champ de profil ?',
	'DISPLAY_AT_PROFILE'			=> 'Afficher dans le panneau de contrôle de l’utilisateur ',
	'DISPLAY_AT_PROFILE_EXPLAIN'	=> 'L’utilisateur pourra modifier ce champ de profil depuis le panneau de contrôle de l’utilisateur.',
	'DISPLAY_AT_REGISTER'			=> 'Afficher lors de l’inscription ',
	'DISPLAY_AT_REGISTER_EXPLAIN'	=> 'Si cette option est activée, le champ sera affiché lors de l’inscription.',
	'DISPLAY_ON_VT'					=> 'Afficher sur la liste des sujets ',
	'DISPLAY_ON_VT_EXPLAIN'			=> 'Si cette option est activée, le champ sera affiché dans le mini-profil de l’écran des sujets.',
	'DISPLAY_PROFILE_FIELD'			=> 'Afficher publiquement le champ de profil ',
	'DISPLAY_PROFILE_FIELD_EXPLAIN'	=> 'Le champ de profil sera affiché dans tous les endroits autorisés par les réglages de la charge. Veuillez désactiver cette option si vous souhaitez masquer le champ sur les pages des sujets, les profils et de la liste des membres.',
	'DROPDOWN_ENTRIES_EXPLAIN'		=> 'Saisissez à présent vos options. Chaque option doit être saisie sur une nouvelle ligne.',

	'EDIT_DROPDOWN_LANG_EXPLAIN'	=> 'Veuillez noter que vous pourrez modifier les options du texte et ajouter de nouvelles options ultérieurement. Il n’est pas conseillé d’ajouter de nouvelles options entre des options déjà existantes car cela pourrait attribuer des options erronées à vos utilisateurs. Il en est de même si vous supprimez une option que des utilisateurs utilisent. Ces derniers seront alors redirigés vers l’élément par défaut.',
	'EMPTY_FIELD_IDENT'				=> 'Identification du champ vide',
	'EMPTY_USER_FIELD_NAME'			=> 'Veuillez saisir le nom ou le titre du champ',
	'ENTRIES'						=> 'Éléments ',
	'EVERYTHING_OK'					=> 'Tout est correct',

	'FIELD_BOOL'				=> 'Booléen (oui/non)',
	'FIELD_DATE'				=> 'Date',
	'FIELD_DESCRIPTION'			=> 'Description du champ ',
	'FIELD_DESCRIPTION_EXPLAIN'	=> 'La description de ce champ est affiché aux utilisateurs.',
	'FIELD_DROPDOWN'			=> 'Liste déroulante',
	'FIELD_IDENT'				=> 'Identification du champ ',
	'FIELD_IDENT_ALREADY_EXIST'	=> 'L’identification du champ que vous avez sélectionnée existe déjà. Veuillez en spécifier une autre.',
	'FIELD_IDENT_EXPLAIN'		=> 'L’identification du champ correspond au nom qui permet d’identifier le champ de profil dans la base de données et les templates.',
	'FIELD_INT'					=> 'Chiffres',
	'FIELD_LENGTH'				=> 'Largeur de la boîte de saisie',
	'FIELD_NOT_FOUND'			=> 'Le champ de profil est introuvable.',
	'FIELD_STRING'				=> 'Champ de texte simple',
	'FIELD_TEXT'				=> 'Zone de texte',
	'FIELD_TYPE'				=> 'Type de champ ',
	'FIELD_TYPE_EXPLAIN'		=> 'Vous ne pourrez plus modifier ultérieurement le type de champ.',
	'FIELD_VALIDATION'			=> 'Validation du champ',
	'FIRST_OPTION'				=> 'Première option',

	'HIDE_PROFILE_FIELD'			=> 'Masquer le champ de profil ',
	'HIDE_PROFILE_FIELD_EXPLAIN'	=> 'Limite l’affichage du champ de profil à un utilisateur. Le champ de profil sera masqué à tous les autres utilisateurs, mis à part aux administrateurs et aux modérateurs qui pourront toujours voir ce champ. Si l’affichage est désactivé dans le panneau de contrôle de l’utilisateur, l’utilisateur ne pourra pas voir ou modifier ce champ et ce dernier ne pourra être modifié que par un administrateur.',

	'INVALID_CHARS_FIELD_IDENT'	=> 'L’identification du champ ne peut contenir que des lettres minuscules situées entre A et E et des tirets bas',
	'INVALID_FIELD_IDENT_LEN'	=> 'L’identification du champ est limité à 17 caractères',
	'ISO_LANGUAGE'				=> 'Langue [%s]',

	'LANG_SPECIFIC_OPTIONS'		=> 'Options spécifiques à la langue [<strong>%s</strong>]',

	'MAX_FIELD_CHARS'		=> 'Nombre maximum de caractères',
	'MAX_FIELD_NUMBER'		=> 'Nombre le plus élevé autorisé',
	'MIN_FIELD_CHARS'		=> 'Nombre minimum de caractères',
	'MIN_FIELD_NUMBER'		=> 'Nombre le plus faible autorisé',

	'NO_FIELD_ENTRIES'			=> 'Aucun élément n’a été spécifié',
	'NO_FIELD_ID'				=> 'Aucune identification de champ n’a été spécifiée.',
	'NO_FIELD_TYPE'				=> 'Aucun type de champ n’a été spécifié.',
	'NO_VALUE_OPTION'			=> 'Option égale à la valeur de non-saisie',
	'NO_VALUE_OPTION_EXPLAIN'	=> 'Valeur de non-saisie. Si ce champ est obligatoire, l’utilisateur obtiendra une erreur s’il sélectionne l’option qui est spécifiée ici.',
	'NUMBERS_ONLY'				=> 'Chiffres uniquement (0-9)',

	'PROFILE_BASIC_OPTIONS'		=> 'Options basiques',
	'PROFILE_FIELD_ACTIVATED'	=> 'Le champ de profil a été activé.',
	'PROFILE_FIELD_DEACTIVATED'	=> 'Le champ de profil a été désactivé.',
	'PROFILE_LANG_OPTIONS'		=> 'Options spécifiques à la langue',
	'PROFILE_TYPE_OPTIONS'		=> 'Options spécifiques au type de profil',

	'RADIO_BUTTONS'				=> 'Boutons radios',
	'REMOVED_PROFILE_FIELD'		=> 'Le champ de profil a été supprimé.',
	'REQUIRED_FIELD'			=> 'Champ obligatoire ',
	'REQUIRED_FIELD_EXPLAIN'	=> 'Oblige aux utilisateurs de remplir ou de spécifier le champ de profil. Si l’affichage est désactivé sur la page d’inscription, le champ ne devra être obligatoirement renseigné que si les utilisateurs éditent leur profil.',
	'ROWS'						=> 'Lignes',

	'SAVE'							=> 'Enregistrer',
	'SECOND_OPTION'					=> 'Seconde option',
	'SHOW_NOVALUE_FIELD'			=> 'Afficher le champ si aucune valeur n’a été saisie',
	'SHOW_NOVALUE_FIELD_EXPLAIN'	=> 'Détermine si le champ de profil doit être affiché si aucune valeur n’a été saisie dans les champs optionnels ou si les champs obligatoires n’ont pas encore été remplis.',
	'STEP_1_EXPLAIN_CREATE'			=> 'Vous pouvez saisir ici le premier paramètre basique de votre nouveau champ de profil. Cette information est nécessaire afin de poursuivre à la seconde étape où vous pourrez définir les options restantes et où vous pourrez prévisualiser et améliorer votre champ de profil.',
	'STEP_1_EXPLAIN_EDIT'			=> 'Vous pouvez modifier ici les paramètres basiques de votre champ de profil. Les options correspondantes sont recalculées à la seconde étape.',
	'STEP_1_TITLE_CREATE'			=> 'Ajouter un champ de profil',
	'STEP_1_TITLE_EDIT'				=> 'Éditer le champ de profil',
	'STEP_2_EXPLAIN_CREATE'			=> 'Vous pouvez spécifier ici quelques options courantes que vous pourrez ajuster.',
	'STEP_2_EXPLAIN_EDIT'			=> 'Vous pouvez modifier ici quelques options courantes.<br /><strong>Veuillez noter que les modifications des champs de profil n’affecteront pas les champs de profil existants et complétés par vos utilisateurs.</strong>',
	'STEP_2_TITLE_CREATE'			=> 'Options spécifiques au type de profil',
	'STEP_2_TITLE_EDIT'				=> 'Options spécifiques au type de profil',
	'STEP_3_EXPLAIN_CREATE'			=> 'Étant donné que vous avez installé plusieurs langues sur votre forum, vous devez également remplir les éléments de langue. Le champ de profil fonctionnera avec la langue par défaut qui est activée, vous pourrez également compléter les éléments relatifs à la langue ultérieurement.',
	'STEP_3_EXPLAIN_EDIT'			=> 'Étant donné que vous avez installé plusieurs langues sur votre forum, vous pouvez également modifier ou ajouter les éléments de langue restants. Le champ de profil fonctionnera avec la langue par défaut qui est activée.',
	'STEP_3_TITLE_CREATE'			=> 'Définitions de langue restantes',
	'STEP_3_TITLE_EDIT'				=> 'Définitions de langue',
	'STRING_DEFAULT_VALUE_EXPLAIN'	=> 'Veuillez saisir une phrase ou une valeur qui sera affichée par défaut. Laissez cette option vide si vous souhaitez ne rien afficher.',

	'TEXT_DEFAULT_VALUE_EXPLAIN'	=> 'Veuillez saisir un texte ou une valeur qui sera affiché par défaut. Laissez cette option vide si vous souhaitez ne rien afficher.',
	'TRANSLATE'						=> 'Traduire',

	'USER_FIELD_NAME'	=> 'Nom ou titre du champ affiché aux utilisateurs ',

	'VISIBILITY_OPTION'				=> 'Options de visibilité',
));

?>