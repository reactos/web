<?php
/**
*
* acp_database [French]
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

// Database Backup/Restore
$lang = array_merge($lang, array(
	'ACP_BACKUP_EXPLAIN'	=> 'Vous pouvez sauvegarder ici toutes les données relatives à votre forum. Vous pouvez stocker l’archive de sauvegarde dans votre répertoire <samp>store/</samp> ou la télécharger directement. Selon la configuration de votre serveur, vous pourrez compresser cette archive dans plusieurs formats.',
	'ACP_RESTORE_EXPLAIN'	=> 'Cela effectuera une restauration complète de toutes les tables de phpBB à partir d’un fichier de sauvegarde. Si votre serveur le supporte, vous pouvez utiliser un fichier texte compressé en GZip ou BZip2 qui sera automatiquement décompressé. <strong>ATTENTION :</strong> cela écrasera toutes les données existantes. La restauration est un processus qui peut durer un certain temps, veillez à ne pas vous déplacer sur une autre page tant que l’opération n’est pas terminée. Les sauvegardes sont stockées dans le répertoire <samp>store/</samp> et sont supposées être générées par l’outil de restauration présent par défaut dans le logiciel phpBB. Il est possible que la restauration des bases de données qui n’ont pas été sauvegardées avec cet outil ne fonctionnent pas.',

	'BACKUP_DELETE'		=> 'Le fichier de sauvegarde a été supprimé.',
	'BACKUP_INVALID'	=> 'Le fichier de sauvegarde que vous avez sélectionné est incorrect.',
	'BACKUP_OPTIONS'	=> 'Options de sauvegarde',
	'BACKUP_SUCCESS'	=> 'Le fichier de sauvegarde a été créé.',
	'BACKUP_TYPE'		=> 'Type de sauvegarde ',

	'DATABASE'			=> 'Utilitaires de la base de données',
	'DATA_ONLY'			=> 'Données uniquement',
	'DELETE_BACKUP'		=> 'Supprimer la sauvegarde',
	'DELETE_SELECTED_BACKUP'	=> 'Êtes-vous sûr(e) de vouloir supprimer la sauvegarde sélectionnée ?',
	'DESELECT_ALL'		=> 'Tout désélectionner',
	'DOWNLOAD_BACKUP'	=> 'Télécharger la sauvegarde',

	'FILE_TYPE'			=> 'Type de fichier ',
	'FILE_WRITE_FAIL'	=> 'Impossible d’écrire le fichier dans le répertoire de stockage.',
	'FULL_BACKUP'		=> 'Complète',

	'RESTORE_FAILURE'		=> 'Le fichier de sauvegarde semble corrompu.',
	'RESTORE_OPTIONS'		=> 'Options de restauration',
	'RESTORE_SELECTED_BACKUP'	=> 'Êtes-vous sûr(e) de vouloir restaurer la sauvegarde sélectionnée ?',
	'RESTORE_SUCCESS'		=> 'La base de données a été restaurée.<br /><br />Votre forum devrait être tel qu’il était lors de la dernière sauvegarde.',

	'SELECT_ALL'			=> 'Tout sélectionner',
	'SELECT_FILE'			=> 'Sélectionner un fichier ',
	'START_BACKUP'			=> 'Démarrer la sauvegarde',
	'START_RESTORE'			=> 'Démarrer la restauration',
	'STORE_AND_DOWNLOAD'	=> 'Stocker et télécharger',
	'STORE_LOCAL'			=> 'Stocker le fichier en local',
	'STRUCTURE_ONLY'		=> 'Structure uniquement',

	'TABLE_SELECT'		=> 'Sélection de(s) table(s) ',
	'TABLE_SELECT_ERROR'=> 'Vous devez sélectionner au moins une table.',
));

?>