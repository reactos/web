<?php
/**
*
* acp_search [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-11-16
* @copyright (c) 2013 phpBBItalia.net - translated on 2013-07-22
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
	'ACP_SEARCH_INDEX_EXPLAIN'				=> 'Qui puoi gestire gli Indici del motore di ricerca. Poiché normalmente si utilizza solo un motore di ricerca dovresti cancellare tutti gli Indici di cui non fai uso. Dopo aver modificato alcune delle impostazioni di ricerca (es. il numero minimo o massimo dei caratteri) potrebbe essere utile ricreare l’Indice in modo che rifletta quelle modifiche.',
	'ACP_SEARCH_SETTINGS_EXPLAIN'			=> 'Qui puoi definire quale motore di ricerca sarà utilizzato per l’indicizzazione dei messaggi e per le ricerche. Puoi impostare diverse opzioni che possono influire sull’elaborazione richiesta. Alcune di queste impostazioni sono le stesse per tutti i motori di ricerca.',

	'COMMON_WORD_THRESHOLD'					=> 'Soglia parola comune',
	'COMMON_WORD_THRESHOLD_EXPLAIN'			=> 'Le parole contenute nella maggior parte dei messaggi saranno considerate come parole comuni. Le parole comuni vengono ignorate nelle ricerche. Imposta zero per disabilitare. Questo ha effetto solo se ci sono più di 100 messaggi.',
	'CONFIRM_SEARCH_BACKEND'				=> 'Sei sicuro di voler passare ad un motore di ricerca diverso? Dopo avere modificato il motore di ricerca dovrai creare un Indice per il nuovo motore di ricerca. Se non vuoi tornare al vecchio motore di ricerca puoi anche cancellare l’Indice del vecchio motore di ricerca per liberare risorse di sistema.',
	'CONTINUE_DELETING_INDEX'				=> 'Continua il precedente processo di cancellazione indirizzo',
	'CONTINUE_DELETING_INDEX_EXPLAIN'		=> 'Avviato processo di cancellazione indirizzo. Per poter accedere nuovamente alla pagina dell’Indice di ricerca devi prima completarlo.',
	'CONTINUE_INDEXING'						=> 'Continua il precedente processo di indicizzazione',
	'CONTINUE_INDEXING_EXPLAIN'				=> 'Avviato processo di indicizzazione. Per poter accedere nuovamente alla pagina dell’Indice di ricerca devi prima completarlo.',
	'CREATE_INDEX'							=> 'Crea Indice',

	'DELETE_INDEX'							=> 'Cancella Indice',
	'DELETING_INDEX_IN_PROGRESS'			=> 'Eliminazione dell’Indice in corso',
	'DELETING_INDEX_IN_PROGRESS_EXPLAIN'	=> 'Il motore di ricerca sta pulendo il suo Indice. Questo può impiegare alcuni minuti.',

	'FULLTEXT_MYSQL_INCOMPATIBLE_VERSION'	=> 'Il backend di testo MySQL può essere utilizzato solo con MySQL4 o superiore.',
	'FULLTEXT_MYSQL_NOT_SUPPORTED'			=> 'Gli Indici di testo MySQL completi possono essere utilizzati solo con tabelle MyISAM o InnoDB. MySQL 5.6.4 o successivo è necessario per gli Indici di testo completi su tabelle InnoDB.',
	'FULLTEXT_MYSQL_TOTAL_POSTS'			=> 'Numero totale di messaggi indicizzati',
	'FULLTEXT_MYSQL_MBSTRING'				=> 'Supporto per caratteri non-latin UTF-8 che usano mbstring:',
	'FULLTEXT_MYSQL_PCRE'					=> 'Supporto per caratteri non-latin UTF-8 che usano PCRE:',
	'FULLTEXT_MYSQL_MBSTRING_EXPLAIN'		=> 'Se PCRE non avesse le proprietà di carattere unicode, il motore di ricerca cercherà di usare il motore delle espressioni regolari mbstring.',
	'FULLTEXT_MYSQL_PCRE_EXPLAIN'			=> 'Questo motore di ricerca necessita delle proprietà di carattere unicode PCRE, disponibili solo in PHP 4.4, 5.1 e superiori, se si vogliono cercare caratteri non-latin.',
	'FULLTEXT_MYSQL_MIN_SEARCH_CHARS_EXPLAIN'	=> 'Saranno indicizzate per la ricerca, solo le parole che hanno almeno un numero pari di caratteri rispetto a quello qui indicato. Tu o il tuo Host potete cambiare questa impostazione solo modificando la configurazione MySQL.',
	'FULLTEXT_MYSQL_MAX_SEARCH_CHARS_EXPLAIN'	=> 'Saranno indicizzate per la ricerca, solo le parole che hanno massimo un numero pari di caratteri rispetto a quello qui indicato. Tu o il tuo Host potete cambiare questa impostazione solo modificando la configurazione MySQL.',
	'GENERAL_SEARCH_SETTINGS'				=> 'Impostazioni generali di ricerca',
	'GO_TO_SEARCH_INDEX'					=> 'Vai alla pagina Indice di ricerca',

	'INDEX_STATS'							=> 'Indice statistiche',
	'INDEXING_IN_PROGRESS'					=> 'Indicizzazione in corso',
	'INDEXING_IN_PROGRESS_EXPLAIN'			=> 'Il motore di ricerca sta indicizzando tutti i messaggi del Forum. Questo può impiegare da alcuni minuti ad alcune ore; attendi.',

	'LIMIT_SEARCH_LOAD'						=> 'Limite di caricamento del sistema per ricerca pagina',
	'LIMIT_SEARCH_LOAD_EXPLAIN'				=> 'Se il limite di caricamento del sistema eccede di un minuto questo valore, la pagina andrà OffLine. 1.0 uguaglia l’utilizzo del ~100% di un processore. Questo funziona solo su server basati su UNIX.',

	'MAX_SEARCH_CHARS'						=> 'Valore massimo caratteri indicizzati dalla ricerca',
	'MAX_SEARCH_CHARS_EXPLAIN'				=> 'Le parole con non più di questo numero di caratteri saranno indicizzate per la ricerca.',
	'MAX_NUM_SEARCH_KEYWORDS'				=> 'Numero massimo di chiavi di ricerca consentite',
    'MAX_NUM_SEARCH_KEYWORDS_EXPLAIN'		=> 'Il numero massimo di parole che è possibile inserire per la ricerca. 0 = illimitato.',
	'MIN_SEARCH_CHARS'						=> 'Valore minimo caratteri indicizzati dalla ricerca',
	'MIN_SEARCH_CHARS_EXPLAIN'				=> 'Le parole con almeno questo numero minimo di caratteri saranno indicizzate per la ricerca.',
	'MIN_SEARCH_AUTHOR_CHARS'				=> 'Numero minimo di caratteri per il nome autore',
	'MIN_SEARCH_AUTHOR_CHARS_EXPLAIN'		=> 'Gli utenti devono immettere almeno questo numero minimo di caratteri quando eseguono una ricerca del nome con carattere jolly (es. di solito l’asterisco (*) si sostituisce come un carattere jolly). Se il nome utente è più breve di questo numero puoi ancora cercare i suoi messaggi inserendo il nome utente completo.',

	'PROGRESS_BAR'							=> 'Barra di progresso',

	'SEARCH_GUEST_INTERVAL'					=> 'Intervallo del flood di ricerca per gli ospiti',
	'SEARCH_GUEST_INTERVAL_EXPLAIN'			=> 'Numero di secondi che gli ospiti devono aspettare tra una ricerca e l’altra. Se un ospite fa una ricerca tutti gli altri devono aspettare fino a quando l’intervallo di tempo non è passato.',
	'SEARCH_INDEX_CREATE_REDIRECT'			=> 'Tutti gli argomenti fino al numero id %1$d sono stati indicizzati, dei quali %2$d facevano parte di questa fase.<br />La velocità di indicizzazione corrente è di approssimativamente %3$.1f argomenti al secondo.<br />Indicizzazione in corso...',
	'SEARCH_INDEX_DELETE_REDIRECT'			=> 'Tutti gli argomenti fino al numero id %1$d sono stati eliminati dall’Indice.<br />Eliminazione in corso...',
	'SEARCH_INDEX_CREATED'					=> 'Tutti i messaggi sono stati indicizzati correttamente nel database.',
	'SEARCH_INDEX_REMOVED'					=> 'L’Indice di ricerca per questo motore è stato cancellato.',
	'SEARCH_INTERVAL'						=> 'Intervallo del flood di ricerca per gli utenti',
	'SEARCH_INTERVAL_EXPLAIN'				=> 'Numero di secondi che gli utenti devono aspettare tra una ricerca e l’altra. Questo intervallo è controllato indipendentemente per ogni utente.',
	'SEARCH_STORE_RESULTS'					=> 'Risultato della ricerca per la lunghezza cache',
	'SEARCH_STORE_RESULTS_EXPLAIN'			=> 'I risultati della ricerca memorizzati nella cache scadranno dopo questo tempo, in secondi. Imposta 0 se vuoi disabilitare la ricerca cache.',
	'SEARCH_TYPE'							=> 'Cerca motore di ricerca',
	'SEARCH_TYPE_EXPLAIN'					=> 'phpBB ti permette di scegliere il motore utilizzato per la ricerca del testo nei contenuti dei messaggi. Di default, la ricerca avverrà tramite il sistema di ricerca testo di phpBB.',
	'SWITCHED_SEARCH_BACKEND'				=> 'Hai commutato il motore di ricerca. Per utilizzare il nuovo motore di ricerca dovresti assicurarti che ci sia un Indice per il motore che hai scelto.',

	'TOTAL_WORDS'							=> 'Numero totale di parole indicizzate',
	'TOTAL_MATCHES'							=> 'Numero totale di relazioni "parola - argomento" indicizzate',

	'YES_SEARCH'							=> 'Permetti le funzioni di ricerca',
	'YES_SEARCH_EXPLAIN'					=> 'Permette tra le funzionalità anche la ricerca utenti.',
	'YES_SEARCH_UPDATE'						=> 'Permetti aggiornamento di testo completo',
	'YES_SEARCH_UPDATE_EXPLAIN'				=> 'Aggiornamento degli Indici del testo completo quando si scrive un messaggio, annullato se la ricerca è disabilitata.',
));

?>