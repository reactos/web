<?php
/**
*
* memberlist [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-03-01
* @copyright (c) 2012 phpBBItalia.net - translated on 2012-06-07
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
	'ABOUT_USER'			=> 'Profilo',
	'ACTIVE_IN_FORUM'		=> 'Più attivo nel forum',
	'ACTIVE_IN_TOPIC'		=> 'Più attivo nell’argomento',
	'ADD_FOE'				=> 'Aggiungi come ignorato',
	'ADD_FRIEND'			=> 'Aggiungi come amico',
	'AFTER'					=> 'Dopo',

	'ALL'					=> 'Tutti',

	'BEFORE'				=> 'Prima',

	'CC_EMAIL'				=> 'Invia copia a te stesso.',
	'CONTACT_USER'			=> 'Contatta',

	'DEST_LANG'				=> 'Lingua',
	'DEST_LANG_EXPLAIN'		=> 'Seleziona una lingua adatta (se presente) per il destinatario di questo messaggio.',

	'EMAIL_BODY_EXPLAIN'	=> 'Questo messaggio sarà spedito in testo semplice, non includere codice HTML o BBCode. L’indirizzo di risposta sarà il tuo indirizzo e-mail.',
	'EMAIL_DISABLED'		=> 'Spiacente ma tutte le funzioni e-mail sono disabilitate.',
	'EMAIL_SENT'			=> 'L’e-mail è stata spedita.',
	'EMAIL_TOPIC_EXPLAIN'	=> 'Questo messaggio sarà spedito in testo semplice, non includere codice HTML o BBCode. Tutte le informazioni riguardanti l’argomento sono già incluse nel messaggio. L’indirizzo di risposta sarà il tuo indirizzo e-mail.',
	'EMPTY_ADDRESS_EMAIL'	=> 'Devi inserire un indirizzo e-mail valido per il destinatario.',
	'EMPTY_MESSAGE_EMAIL'	=> 'Devi inserire un messaggio per l’e-mail.',
	'EMPTY_MESSAGE_IM'		=> 'Devi inserire un messaggio da inviare.',
	'EMPTY_NAME_EMAIL'		=> 'Devi inserire il nome del destinatario.',
	'EMPTY_SUBJECT_EMAIL'	=> 'Devi specificare un titolo per l’e-mail.',
	'EQUAL_TO'				=> 'Uguale a',

	'FIND_USERNAME_EXPLAIN'	=> 'Usa questo modulo per cercare gli utenti. Non è necessario compilare tutti i campi. Per ricerche parziali è permesso l’utilizzo del carattere *. Come formato della data utilizzare il seguente <kbd>AAAA-MM-GG</kbd>, es. <samp>2009-09-20</samp>. Selezionare uno o più nomi utenti e clicca sul pulsante di conferma per tornare al modulo precedente.',
	'FLOOD_EMAIL_LIMIT'		=> 'In questo momento non puoi inviare un’altra e-mail. Riprova più tardi.',

	'GROUP_LEADER'			=> 'Leader del gruppo',

	'HIDE_MEMBER_SEARCH'	=> 'Nascondi ricerca membri',

	'IM_ADD_CONTACT'		=> 'Aggiungi contatto',
	'IM_AIM'				=> 'Per utilizzare questa funzione devi avere installato AOL messenger.',
	'IM_AIM_EXPRESS'		=> 'AIM Express',
	'IM_DOWNLOAD_APP'		=> 'Scarica il programma',
	'IM_ICQ'				=> 'L’utente selezionato potrebbe aver scelto di non ricevere messaggi indesiderati.',
	'IM_JABBER'				=> 'L’utente selezionato potrebbe aver scelto di non ricevere messaggi indesiderati.',
	'IM_JABBER_SUBJECT'		=> 'Questo è un messaggio automatico, non rispondere! Messaggio inviato dall’utente %1$s a %2$s.',
	'IM_MESSAGE'			=> 'Il tuo messaggio',
	'IM_MSNM'				=> 'Per utilizzare questa funzione devi avere installato MSN.',
	'IM_MSNM_BROWSER'		=> 'Il tuo browser non supporta questa funzione.',
	'IM_MSNM_CONNECT'		=> 'MSN non è connesso. Devi connettere MSN per poter proseguire.',		
	'IM_NAME'				=> 'Il tuo nome',
	'IM_NO_DATA'			=> 'Non sono presenti informazioni adatte del contatto di questo utente.',
	'IM_NO_JABBER'			=> 'I messaggi diretti di Jabber non sono supportati da questa Board. Devi installare un client Jabber per poter contattare il seguente destinatario.',
	'IM_RECIPIENT'			=> 'Destinatario',
	'IM_SEND'				=> 'Invia messaggio',
	'IM_SEND_MESSAGE'		=> 'Invia messaggio',
	'IM_SENT_JABBER'		=> 'Il tuo messaggio per %1$s è stato inviato correttamente.',
	'IM_USER'				=> 'Invia un messaggio istantaneo',
	
	'LAST_ACTIVE'				=> 'Ultima azione',
	'LESS_THAN'					=> 'Meno di',
	'LIST_USER'					=> '1 utente',
	'LIST_USERS'				=> '%d utenti',
	'LOGIN_EXPLAIN_LEADERS'		=> 'L’amministratore richiede che tu sia iscritto e connesso per vedere i membri dello staff.',
	'LOGIN_EXPLAIN_MEMBERLIST'	=> 'L’amministratore richiede che tu sia iscritto e connesso per vedere la lista iscritti.',
	'LOGIN_EXPLAIN_SEARCHUSER'	=> 'L’amministratore richiede che tu sia iscritto e connesso per cercare un utente.',
	'LOGIN_EXPLAIN_VIEWPROFILE'	=> 'L’amministratore richiede che tu sia iscritto e connesso per vedere i profili utente.',

	'MORE_THAN'				=> 'Più di',

	'NO_EMAIL'				=> 'Non hai i permessi per inviare e-mail a questo utente.',
	'NO_VIEW_USERS'			=> 'Non sei autorizzato a vedere la lista o il profilo utenti.',

	'ORDER'					=> 'Ordina',
	'OTHER'					=> 'Altro',

	'POST_IP'				=> 'Inviato dall’IP/dominio',

 //	'RANK'					=> 'Livello', //
	'REAL_NAME'				=> 'Nome del destinatario',
	'RECIPIENT'				=> 'Destinatario',
	'REMOVE_FOE'			=> 'Rimuovi da ignorati',
	'REMOVE_FRIEND'			=> 'Rimuovi da amici',

 // 'SEARCH_USER_POSTS'		=> 'Cerca messaggi dell’utente', //
	'SELECT_MARKED'			=> 'Seleziona contrassegnati',
	'SELECT_SORT_METHOD'	=> 'Seleziona metodo di ordinamento',
	'SEND_AIM_MESSAGE'		=> 'Invia messaggio AIM',
	'SEND_ICQ_MESSAGE'		=> 'Invia messaggio ICQ',
	'SEND_IM'				=> 'Messaggio istantaneo',
	'SEND_JABBER_MESSAGE'	=> 'Invia messaggio Jabber',
	'SEND_MESSAGE'			=> 'Messaggio',
	'SEND_MSNM_MESSAGE'		=> 'Invia messaggio MSN/WLM',
	'SEND_YIM_MESSAGE'		=> 'Invia messaggio YIM',
	'SORT_EMAIL'			=> 'E-mail',
	'SORT_LAST_ACTIVE'		=> 'Ultima azione',
	'SORT_POST_COUNT'		=> 'Numero di messaggi',

	'USERNAME_BEGINS_WITH'	=> 'Nome utente inizia per',
	'USER_ADMIN'			=> 'Amministra utente',
	'USER_BAN'              => 'Effettua ban',
	'USER_FORUM'			=> 'Statistiche utente',
	'USER_LAST_REMINDED'	=> array(
		0		=> 'Nessun sollecito inviato in questo momento',
		1		=> '%1$d sollecito inviato<br />» %2$s',
	),
	'USER_ONLINE'			=> 'Online',
	'USER_PRESENCE'			=> 'Presente nel sistema',

	'VIEWING_PROFILE'		=> 'Stai guardando il profilo di %s',
	'VISITED'				=> 'Ultima visita',

	'WWW'					=> 'Sito Web',
));

?>