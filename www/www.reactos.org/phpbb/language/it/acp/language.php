<?php
/**
*
* acp_language [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-03-01
* @copyright (c) 2011 phpBBItalia.net - translated on 2011-11-22
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACP_FILES'						=> 'Amministra file di lingua',
	'ACP_LANGUAGE_PACKS_EXPLAIN'	=> 'Da qui puoi installare o rimuovere i pacchetti lingua. Il pacchetto lingua di default, è marcato con un asterisco (*).',

	'EMAIL_FILES'			=> 'Template delle e-mail',

	'FILE_CONTENTS'				=> 'Contenuto del file',
	'FILE_FROM_STORAGE'			=> 'File da cartella di salvataggio',

	'HELP_FILES'				=> 'File di aiuto',

	'INSTALLED_LANGUAGE_PACKS'	=> 'Pacchetti lingua installati',
	'INVALID_LANGUAGE_PACK'		=> 'Il pacchetto lingua selezionato non è valido. Verifica il pacchetto lingua e ricaricalo se necessario.',
	'INVALID_UPLOAD_METHOD'		=> 'Il metodo di upload selezionato non è valido, scegli un altro metodo.',

	'LANGUAGE_DETAILS_UPDATED'			=> 'Dettagli lingua caricati.',
	'LANGUAGE_ENTRIES'					=> 'Voci tradotte',
	'LANGUAGE_ENTRIES_EXPLAIN'			=> 'Da qui puoi modificare le voci tradotte già esistenti, o inserire quelle mancanti, nel tuo pacchetto lingua.<br /><strong>Nota:</strong> Modificando un file di lingua, il file contenente i cambiamenti effettuati sarà salvato in un cartella di salvataggio dalla quale potrai scaricarlo. I cambiamenti non saranno visibili ai tuoi utenti fino a quando non rimpiazzerai i file originali con quelli nuovi modificati (sul tuo spazio web).',
	'LANGUAGE_FILES'					=> 'File di lingua',
	'LANGUAGE_KEY'						=> 'Chiave di lingua',
	'LANGUAGE_PACK_ALREADY_INSTALLED'	=> 'Questo pacchetto lingua è già installato.',
	'LANGUAGE_PACK_DELETED'				=> 'Il pacchetto lingua <strong>%s</strong> è stato rimosso. Per tutti gli utenti che usavano questa lingua è stata ripristinata la lingua predefinita.',
	'LANGUAGE_PACK_DETAILS'				=> 'Dettagli pacchetto lingua',
	'LANGUAGE_PACK_INSTALLED'			=> 'Il pacchetto lingua <strong>%s</strong> è stato installato.',
	'LANGUAGE_PACK_CPF_UPDATE'			=> 'I campi profilo personalizzati, sono stati copiati dalla lingua predefinita. Se è necessario, modificali.',
	'LANGUAGE_PACK_ISO'					=> 'ISO',
	'LANGUAGE_PACK_LOCALNAME'			=> 'Nome locale',
	'LANGUAGE_PACK_NAME'				=> 'Nome',
	'LANGUAGE_PACK_NOT_EXIST'			=> 'Il pacchetto lingua selezionato non esiste.',
	'LANGUAGE_PACK_USED_BY'				=> 'Usato da (inclusi robots)',
	'LANGUAGE_VARIABLE'					=> 'Variabile di lingua',
	'LANG_AUTHOR'						=> 'Autori pacchetto lingua',
	'LANG_ENGLISH_NAME'					=> 'Nome inglese',
	'LANG_ISO_CODE'						=> 'Codice ISO',
	'LANG_LOCAL_NAME'					=> 'Nome locale',

	'MISSING_LANGUAGE_FILE'		=> 'File di lingua mancante: <strong style="color:red">%s</strong>',
	'MISSING_LANG_VARIABLES'	=> 'Variabile di lingua mancante',
	'MODS_FILES'				=> 'File lingua delle MOD',

	'NO_FILE_SELECTED'				=> 'Non hai specificato un file di lingua.',
	'NO_LANG_ID'					=> 'Non hai specificato un pacchetto lingua.',
	'NO_REMOVE_DEFAULT_LANG'		=> 'Non puoi rimuovere il pacchetto lingua predefinito.<br />Se vuoi rimuovere questo pacchetto lingua, cambia prima la lingua predefinita.',
	'NO_UNINSTALLED_LANGUAGE_PACKS'	=> 'Nessun pacchetto lingua disinstallato',

	'REMOVE_FROM_STORAGE_FOLDER'		=> 'Rimuovi dalla cartella temporanea',

	'SELECT_DOWNLOAD_FORMAT'	=> 'Seleziona il formato di download',
	'SUBMIT_AND_DOWNLOAD'		=> 'Invia e inizia download del file',
	'SUBMIT_AND_UPLOAD'			=> 'Invia e inizia upload del file',

	'THOSE_MISSING_LANG_FILES'			=> 'I seguenti file di lingua non sono stati trovati nella cartella di lingua %s',
	'THOSE_MISSING_LANG_VARIABLES'		=> 'Le seguenti variabili di lingua non sono presenti nel pacchetto lingua <strong>%s</strong>',

	'UNINSTALLED_LANGUAGE_PACKS'	=> 'Pacchetti lingua disinstallati',

	'UNABLE_TO_WRITE_FILE'		=> 'Il file non può essere scritto in %s.',
	'UPLOAD_COMPLETED'			=> 'Upload completato con successo.',
	'UPLOAD_FAILED'				=> 'L’upload è fallito per ragioni sconosciute. Potresti aver bisogno di trasferire i relativi file manualmente.',
	'UPLOAD_METHOD'				=> 'Metodo di upload',
	'UPLOAD_SETTINGS'			=> 'Impostazioni di upload',

	'WRONG_LANGUAGE_FILE'		=> 'Il file di lingua selezionato non è valido.',
));

?>