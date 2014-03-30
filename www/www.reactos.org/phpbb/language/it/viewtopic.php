<?php
/**
*
* viewtopic [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-03-01
* @copyright (c) 2011 phpBBItalia.net - translated on 2011-06-15
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
	'ATTACHMENT'						=> 'Allegato',
	'ATTACHMENT_FUNCTIONALITY_DISABLED'	=> 'La funzione allegati è disabilitata.',

	'BOOKMARK_ADDED'		=> 'Segnalibro argomento aggiunto.',
	'BOOKMARK_ERR'          => 'L’inserimento del segnalibro argomento non è riuscito. Riprova.',
	'BOOKMARK_REMOVED'		=> 'Segnalibro argomento rimosso.',
	'BOOKMARK_TOPIC'		=> 'Inserisci nei segnalibri',
	'BOOKMARK_TOPIC_REMOVE'	=> 'Rimuovi dai segnalibri',
	'BUMPED_BY'				=> 'Ultimo bump di %1$s effettuato il %2$s.',
	'BUMP_TOPIC'			=> 'Bump argomento',

	'CODE'					=> 'Codice',
	'COLLAPSE_QR'			=> 'Nascondi Risposta Rapida',

	'DELETE_TOPIC'			=> 'Cancella argomento',
	'DOWNLOAD_NOTICE'		=> 'Non hai i permessi necessari per visualizzare i file allegati in questo messaggio.',

	'EDITED_TIMES_TOTAL'	=> 'Ultima modifica di %1$s il %2$s, modificato %3$d volte in totale.',
	'EDITED_TIME_TOTAL'		=> 'Ultima modifica di %1$s il %2$s, modificato %3$d volta in totale.',
	'EMAIL_TOPIC'			=> 'E-mail ad amico',
	'ERROR_NO_ATTACHMENT'	=> 'L’allegato selezionato non è più presente.',

	'FILE_NOT_FOUND_404'	=> 'Il file <strong>%s</strong> non esiste.',
	'FORK_TOPIC'			=> 'Copia argomento',
	'FULL_EDITOR'			=> 'Editor completo',

	'LINKAGE_FORBIDDEN'		=> 'Non sei autorizzato a visualizzare, scaricare o inserire collegamenti da/a questo sito.',
	'LOGIN_NOTIFY_TOPIC'	=> 'Hai una notifica per questo argomento, accedi per vederlo.',
	'LOGIN_VIEWTOPIC'		=> 'Per poter visualizzare questo argomento devi essere un utente registrato ed autenticato.',

	'MAKE_ANNOUNCE'				=> 'Modifica in “Annuncio”',
	'MAKE_GLOBAL'				=> 'Modifica in “Annuncio globale”',
	'MAKE_NORMAL'				=> 'Modifica in “Argomento semplice”',
	'MAKE_STICKY'				=> 'Modifica in “Importante”',
	'MAX_OPTIONS_SELECT'		=> 'Puoi scegliere tra <strong>%d</strong> opzioni',
	'MAX_OPTION_SELECT'			=> 'Puoi usare <strong>1</strong> opzione',
	'MISSING_INLINE_ATTACHMENT'	=> 'L’allegato <strong>%s</strong> non è disponibile',
	'MOVE_TOPIC'				=> 'Sposta argomento',

	'NO_ATTACHMENT_SELECTED'=> 'Non hai selezionato nessun allegato da visualizzare o scaricare.',
	'NO_NEWER_TOPICS'		=> 'Non ci sono nuovi argomenti in questo forum.',
	'NO_OLDER_TOPICS'		=> 'Non ci sono vecchi argomenti in questo forum.',
	'NO_UNREAD_POSTS'		=> 'Non ci sono nuovi messaggi in questo argomento.',
	'NO_VOTE_OPTION'		=> 'Devi selezionare un’opzione per votare.',
	'NO_VOTES'				=> 'Nessun voto',

	'POLL_ENDED_AT'			=> 'Sondaggio concluso il %s',
	'POLL_RUN_TILL'			=> 'Il sondaggio termina il %s',
	'POLL_VOTED_OPTION'		=> 'Hai votato questa opzione',
	'PRINT_TOPIC'			=> 'Stampa pagina',

	'QUICK_MOD'				=> 'Strumenti di moderazione',
	'QUICKREPLY'			=> 'Risposta Rapida',
	'QUOTE'					=> 'Cita',

	'REPLY_TO_TOPIC'		=> 'Rispondi all’argomento',
	'RETURN_POST'			=> '%sRitorna al messaggio%s',

	'SHOW_QR'				=> 'Risposta Rapida',
	'SUBMIT_VOTE'			=> 'Invia voto',

	'TOTAL_VOTES'			=> 'Voti totali',

	'UNLOCK_TOPIC'			=> 'Sblocca argomento',

	'VIEW_INFO'				=> 'Leggi informazioni',
	'VIEW_NEXT_TOPIC'		=> 'Successivo',
	'VIEW_PREVIOUS_TOPIC'	=> 'Precedente',
	'VIEW_RESULTS'			=> 'Guarda risultati',
	'VIEW_TOPIC_POST'		=> '1 messaggio',
	'VIEW_TOPIC_POSTS'		=> '%d messaggi',
	'VIEW_UNREAD_POST'		=> 'Messaggi non letti',
	'VISIT_WEBSITE'			=> 'WWW',
	'VOTE_SUBMITTED'		=> 'Il tuo voto è stato registrato.',
	'VOTE_CONVERTED'		=> 'Non è supportato il cambio voto per sondaggi convertiti.',

));

?>