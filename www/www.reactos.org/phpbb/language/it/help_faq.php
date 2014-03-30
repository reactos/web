<?php
/**
*
* help_faq [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-11-17
* @copyright (c) 2013 phpBBItalia.net - translated on 2013-08-06
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

/**
*/
if (!defined('IN_PHPBB'))
{
	exit;
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

$help = array(
	array(
		0 => '--',
		1 => 'Connessione e registrazione'
	),
	array(
		0 => 'Perché non riesco a connettermi?',
		1 => 'Ci sono svariati motivi per cui questo succede. Per prima cosa controlla che nome utente e password siano corretti. Di solito il problema è questo, altrimenti contatta un amministratore: potresti essere stato bannato o potrebbe esserci un errore di configurazione.'
	),
	array(
		0 => 'Perché devo registrarmi?',
		1 => 'Potresti non averne bisogno: dipende dagli amministratori se è necessario registrarsi per inviare messaggi. Comunque, la registrazione ti darà accesso ad altre funzioni che non sono disponibili per gli utenti ospiti come l’uso di un’immagine personale definibile, messaggistica privata, la possibilità di inviare messaggi di posta direttamente dal forum, l’iscrizione a gruppi utenti, ecc. Ti bastano pochi secondi per registrarti e quindi ti raccomandiamo di farlo.'
	),
	array(
		0 => 'Perché vengo disconnesso automaticamente?',
		1 => 'Se non selezioni <em>Connessione automatica ad ogni visita</em> il sistema ti terrà connesso per un periodo prestabilito. Questo serve a evitare che qualcuno possa usare il tuo nome utente. Per rimanere connesso, seleziona l’opzione quando entri, ma ricorda che questo non è consigliato se ti colleghi da un PC usato anche da altri, ad es. in biblioteca, Internet point, università, ecc. Se non vedi il checkbox, significa che un amministratore ha disabilitato questa caratteristica.'
	),
	array(
		0 => 'Come posso evitare di apparire nella lista degli utenti in linea?',
		1 => 'Nel Pannello di Controllo Utente, sotto “Preferenze”, trovi l’opzione <em>Nascondi il tuo stato in linea</em>. Attivando questa opzione, apparirai solo agli amministratori e a te stesso. Verrai identificato come utente nascosto.'
	),
	array(
		0 => 'Ho perso la mia password!',
		1 => 'Niente panico! La tua password non può essere recuperata, ma può essere rigenerata. Per far questo vai nella pagina di ingresso e clicca su <em>Ho dimenticato la password</em>, segui le istruzioni e tornerai in linea in poco tempo.'
	),
	array(
		0 => 'Mi sono registrato ma non riesco a connettermi!',
		1 => 'Innanzitutto controlla di aver inserito nome utente e password esattamente. Se sono corretti, allora possono esser successe un paio di cose: se il supporto «registrazione minore» è abilitato e hai cliccato su <em>Ho meno di 13 anni</em> mentre ti stavi registrando, allora devi seguire le istruzioni che hai ricevuto. Se questo non è il tuo caso, forse devi attivare il tuo account. Alcune Board richiedono che tutte le nuove registrazioni vengano attivate dall’utente stesso o dagli amministratori, prima di poter accedere. Quando ti registri ti verrà indicato che tipo di attivazione è richiesta. Se ti è stato inviato un messaggio di posta, allora segui le istruzioni; se non hai ricevuto nessun messaggio... sei sicuro che il tuo indirizzo di posta sia valido? (L’attivazione via posta serve a ridurre la possibilità di avere utenti anonimi che abusano della Board.) Se sei sicuro che l’indirizzo di posta che hai usato sia corretto, allora prova a contattare un amministratore.'
	),
	array(
		0 => 'Mi sono registrato tempo fa, ma non riesco più a connettermi?!',
		1 => 'È possibile che un amministratore abbia cancellato o disattivato il tuo account per qualche ragione. Molti siti rimuovono periodicamente gli account degli utenti che non hanno mai inviato messaggi, per ridurre la grandezza del database. Se il motivo è quest’ultimo registrati nuovamente e cerca di farti coinvolgere maggiormente nelle discussioni.'
	),
	array(
		0 => 'Che cosa è COPPA?',
		1 => 'COPPA, o la Legge sulla privacy per la protezione dei minori del 1998, è una legge statunitense che richiede ai siti web di poter raccogliere le informazioni dei minori di età inferiore a 13 anni. Per avere tale consenso serve una richiesta scritta da parte del genitore o tutore legale, permettendo la registrazione delle informazioni scritte dal minore. Se hai dubbi o incertezze, mettiti in contatto con un consulente legale per assistenza. Nota bene che il phpBB Group non può fornire consigli legali e non è un punto di contatto per questioni legali, tranne come descritto.',
	),
	array(
		0 => 'Perché non riesco a registrarmi?',
		1 => 'È possibile che il gestore del sito abbia bannato il tuo indirizzo IP oppure vietato il nome utente che stai tentando di registrare. Può anche aver disabilitato le registrazioni per impedire ai nuovi visitatori di registrarsi. Contatta un amministratore per avere assistenza.',
	),
	array(
		0 => 'Che cosa provoca il comando “Cancella cookie”?',
		1 => 'La funzione “Cancella cookie” eliminerà tutti i cookie generati da phpBB che ti mantengono autenticato e connesso, oltre a permetterti ad esempio di tenere traccia di quello che hai letto, se l’amministrazione ha attivato la funzione. Se hai avuto problemi di accesso o di uscita dal sistema, la cancellazione dei cookie potrebbe risolvere tale disguido.',
	),
	array(
		0 => '--',
		1 => 'Impostazioni e preferenze utente'
	),
	array(
		0 => 'Come cambio le mie impostazioni?',
		1 => 'Se sei un utente registrato, tutte le tue impostazioni sono conservate nel database del sistema. Per modificarle vai sul tuo Pannello di Controllo Utente; generalmente sta in cima ad ogni pagina, ma questo potrebbe non essere sempre vero. Questo ti permetterà di cambiare tutte le tue impostazioni e le preferenze.'
	),
	array(
		0 => 'L’ora non è corretta!',
		1 => 'L’ora è quasi sicuramente corretta, comunque l’ora che stai vedendo potrebbe essere quella di un fuso orario differente dal tuo. Se così fosse, devi cambiare le impostazioni del tuo profilo per il fuso orario e farlo coincidere con la tua area, es. London, Paris, New York, Sydney, ecc. Nota che solo gli utenti registrati possono cambiare il fuso orario e molte impostazioni.'
	),
	array(
		0 => 'Ho cambiato il fuso orario ma l’ora è ancora sbagliata!',
		1 => 'Se sei sicuro di aver impostato il fuso orario corretto e l’ora è ancora sbagliata, il motivo può essere l’ora legale. Il forum non è programmato per calcolare le differenze di orario tra ora legale e ora solare; quindi durante il periodo dell’ora legale l’ora potrebbe essere diversa dall’ora locale. In tal caso, seleziona un fuso orario diverso per far coincidere l’ora mostrata colla tua.'
	),
	array(
		0 => 'La mia lingua non è nella lista!',
		1 => 'L’amministratore potrebbe non aver installato il pacchetto lingua oppure nessuno lo ha tradotto nella tua lingua. Prova a chiedere agli amministratori se è possibile installare la tua lingua. Se non esiste puoi fare tu una nuova traduzione. Puoi trovare altre informazioni al sito del phpBB Group (trovi il collegamento in fondo ad ogni pagina).'
	),
	array(
		0 => 'Come posso mostrare un’immagine sotto il mio nome utente?',
		1 => 'Ci possono essere due immagini sotto un nome utente quando si leggono i messaggi. La prima è l’immagine associata al tuo grado, generalmente ha la forma di stelle, blocchi o punti che indicano quanti interventi hai scritto o il tuo livello. Sotto può esserci un’immagine più grande nota come avatar, che in genere è unica e specifica per ogni utente. L’amministratore decide se abilitare o meno gli avatar e decide anche il modo in cui gli avatar sono messi a disposizione. Se non ti è concesso l’uso degli avatar, allora è una decisione dell’amministrazione, e devi chiedere a questa le ragioni.'
	),
	array(
		0 => 'Come cambio il mio livello?',
		1 => 'In genere, non puoi cambiare direttamente il nome del tuo livello (i gradi compaiono sotto al tuo nome utente nei messaggi e nel tuo profilo, a seconda dello stile che stai usando). Molti adottano i livelli per indicare il numero di interventi che hai scritto e per identificare certi utenti; ad es., moderatori e amministratori possono avere un grado specifico. Per favore non abusare inviando interventi non necessari solo per aumentare il tuo livello; se fai così, i moderatori o l’amministratore probabilmente abbasseranno il numero dei tuoi interventi.'
	),
	array(
		0 => 'Perché quando clicco sul collegamento all’indirizzo di posta di un utente mi chiede di accedere come utente registrato?',
		1 => 'Solo gli utenti registrati possono inviare messaggi di posta ad altri utenti usando il modulo di invio posta interno (ammesso, ovviamente, che gli amministratori abbiano abilitato questa funzione). Questo serve a prevenire un uso scorretto o malevolo del sistema di posta da parte di utenti anonimi.'
	),
	array(
		0 => '--',
		1 => 'Scrivere messaggi'
	),
	array(
		0 => 'Come apro un argomento o invio un messaggio in un forum?',
		1 => 'Facile, premi il pulsante “Nuovo argomento” presente nelle pagine dei forum o degli argomenti. Potresti avere bisogno di registrarti prima di poter inviare un messaggio: le tue funzioni disponibili sono elencate in fondo alla pagina del forum o dell’argomento (la lista <em>Puoi aprire nuovi argomenti</em>, <em>Puoi votare nei sondaggi</em>, ecc.).'
	),
	array(
		0 => 'Come modifico o cancello un messaggio?',
		1 => 'Puoi modificare o cancellare solo i tuoi messaggi, a meno che tu non sia un amministratore o un moderatore. Puoi cancellare un messaggio premendo il pulsante con la «X» nel messaggio che vuoi eliminare. Puoi modificare un messaggio (a volte solo per un limitato periodo di tempo dopo il suo inserimento) premendo il pulsante <em>modifica</em> nel messaggio in questione. Se qualcuno ha già risposto al tuo messaggio, quando effettui una modifica, potresti trovare del testo aggiunto dove viene indicato quante volte l’hai modificato. Un utente normale, generalmente, non può cancellare un messaggio dopo che qualcuno ha risposto.'
	),
	array(
		0 => 'Come aggiungo una firma ai miei messaggi?',
		1 => 'Per aggiungere una firma a un messaggio devi prima crearne una, cosa che puoi fare modificando il tuo profilo. Una volta creata la firma, quando scrivi un messaggio seleziona l’opzione <em>Aggiungi la firma</em> per aggiungerla. Puoi anche decidere di aggiungere sempre la firma a tutti i tuoi messaggi selezionando l’apposita opzione <em>Aggiungi sempre la mia firma</em> nel tuo profilo (puoi sempre evitare di aggiungere la firma deselezionando l’opzione quando scrivi un messaggio).'
	),
	array(
		0 => 'Come creo un sondaggio?',
		1 => 'Creare un sondaggio è facile: quando inizi un nuovo argomento (o quando modifichi il primo messaggio di un argomento, se ti è permesso) dovresti vedere, sotto lo spazio per l’inserimento del messaggio, un riquadro dal titolo <em>Aggiungi sondaggio</em> (se non lo vedi, probabilmente non hai il diritto di creare sondaggi). Basta inserire un titolo per il sondaggio e almeno due opzioni di risposta (per inserire un’opzione di risposta, scrivila nell’apposito spazio e clicca su <em>Aggiungi un’opzione</em>). Puoi anche stabilire i giorni di durata del sondaggio (0 per non porre limiti). C’è un limite al numero di opzioni di risposta che puoi aggiungere, stabilito dall’amministratore.'
	),
   array( 
      0 => 'Come modifico o cancello un sondaggio?', 
      1 => 'Come per i messaggi, i sondaggi possono essere modificati e cancellati solo dai rispettivi autori, dai moderatori e dall’amministratore. Per modificare un sondaggio, clicca sul pulsante <em>modifica</em> del primo messaggio (a cui è sempre associato il sondaggio). Se nessuno ha ancora votato, il sondaggio può essere modificato o cancellato, altrimenti solo i moderatori e l’amministratore possono farlo. Il limite per le opzioni del sondaggio è impostato dall’amministratore. Se vuoi aggiungere ulteriori opzioni, contatta l’amministratore.' 
   ), 
   array( 
      0 => 'Perché non riesco ad accedere a un forum?', 
      1 => 'Alcuni forum potrebbero essere riservati a determinati utenti o gruppi. Per leggere, scrivere, rispondere, ecc., potresti aver bisogno di autorizzazioni speciali, che solo i moderatori e l’amministratore possono concedere.' 
   ), 
   array( 
      0 => 'Perché non posso votare nei sondaggi?', 
      1 => 'Solo gli utenti registrati possono votare nei sondaggi (questo per evitare risultati fasulli). Se sei registrato e comunque non riesci a votare, probabilmente non hai i diritti d’accesso appropriati.' 
   ), 
   array( 
      0 => 'Perché non riesco ad aggiungere allegati?', 
      1 => 'La possibilità di aggiungere allegati può essere concessa per forum, per gruppi o per utenti specifici. L’amministratore potrebbe non aver permesso allegati per il forum in cui stai scrivendo, oppure solo il gruppo degli amministratori può aggiungere allegati. Chiedi all’amministratore se non sei sicuro del motivo per cui non riesci ad aggiungere allegati.' 
   ), 
   array( 
      0 => 'Perché ho ricevuto un richiamo?', 
      1 => 'Ciascun amministratore ha una propria serie di regole per la propria Board. Se pensa che tu ne abbia infranta una, può mandarti un richiamo. Ti preghiamo di notare che questa è una decisione dell’amministratore, e il phpBB Group non ha niente a che fare con questi richiami.' 
   ), 
   array( 
      0 => 'Come posso segnalare messaggi ai moderatori?', 
      1 => 'Se l’amministratore l’ha permesso, vai al messaggio che vuoi segnalare: dovresti vedere un pulsante che serve per fare la segnalazione dei messaggi. Cliccandolo sarai introdotto alla procedura necessaria per la segnalazione dei messaggi.' 
   ), 
   array( 
      0 => 'Che cos’è il pulsante di salvataggio nella finestra di invio dei messaggi?', 
      1 => 'La funzione ti permette di salvare bozze di messaggi da completare e inviare in seguito. Per utilizzarle vai nell’apposita sezione del Pannello di Controllo Utente.' 
   ), 
   array( 
      0 => 'Perché il mio messaggio deve essere approvato?', 
      1 => 'L’amministratore può decidere che in un forum i messaggi inseriti devono prima essere controllati. È inoltre possibile che l’amministratore ti abbia inserito in un gruppo di utenti i cui messaggi ritiene che vadano controllati prima di essere resi visibili. Contatta l’amministratore per maggiori informazioni.' 
   ), 
   array( 
      0 => 'Come faccio a spostare in cima un mio argomento?', 
      1 => 'Cliccando il collegamento “Bump argomento” mentre lo stai leggendo, puoi spostarlo in cima alla lista, nella prima pagina. Se non lo vedi, significa che questa opzione è disabilitata. È anche possibile spostare in cima gli argomenti semplicemente inserendovi un messaggio. Tuttavia, sii sicuro di rispettare le regole del forum in cui ti trovi.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Formattazione e tipi di argomenti' 
   ), 
   array( 
      0 => 'Cos’è il BBCode?', 
      1 => 'Il BBCode è una speciale implementazione dell’HTML; l’utilizzo è soggetto alla scelta dell’amministratore (puoi anche disabilitarlo di messaggio in messaggio tramite l’opzione nel modulo di invio messaggi). Il BBCode è simile all’HTML, i comandi sono racchiusi tra parentesi quadre [ e ] anziché tra &lt; e &gt; e offre un controllo maggiore su cosa e come viene mostrato nei messaggi. Per maggiori informazioni sul BBCode leggi la <a href="faq.php?mode=bbcode"><b>Guida al BBCode</b></a>. Puoi accedere alla stessa pagina, anche dall’area invio messaggi.' 
   ), 
   array( 
      0 => 'Posso usare l’HTML?', 
      1 => 'No. Non è possibile inserire del codice HTML e ottenere che sia interpretato come tale in questo forum. La maggior parte delle funzioni dell’HTML può essere sostituita dal BBCode.' 
   ), 
   array( 
      0 => 'Cosa sono le emoticon?', 
      1 => 'Le «emoticon» o «faccine» (in inglese, <em>emoticons</em> o <em>smileys</em>) sono piccole immagini che possono essere usate per esprimere una sensazione o un’emozione con pochi caratteri; ad es. :) significa felice, :( significa triste. Questo forum trasforma automaticamente queste serie di caratteri in immagini. La lista completa delle emoticon è visibile nella pagina di invio messaggi. Cerca di non esagerare nell’uso delle emoticon, possono facilmente rendere un messaggio illeggibile, e un moderatore potrebbe decidere di modificarlo o addirittura rimuoverlo.' 
   ), 
   array( 
      0 => 'Posso inserire delle immagini?', 
      1 => 'Puoi inserire delle immagini nei tuoi messaggi. Se l’amministratore permette gli allegati è possibile caricare delle immagini direttamente sulla Board, in alternativa devi fare un collegamento a un’immagine ospitata su un server di pubblico accesso, ad es. http://www.indirizzo-del-sito.com/immagine.gif. Non puoi inserire immagini che hai sul tuo PC (a meno che non abbia un server!) o immagini che si trovano dietro sistemi di autenticazione, come caselle di posta tipo yahoo o hotmail, siti protetti da codici di accesso, ecc. Per inserire l’immagine, puoi usare il comando BBCode [img].' 
   ), 
   array( 
      0 => 'Che cosa sono gli annunci globali?', 
      1 => 'Gli annunci globali sono annunci che contengono informazioni importanti e tu dovresti leggerli quanto prima. Gli annunci globali appaiono in cima a tutti i forum ed anche nel Pannello di Controllo Utente. La possibilità di scrivere su un annuncio globale dipende dai permessi concessi dall’amministratore.' 
   ), 
   array( 
      0 => 'Cosa sono gli annunci?', 
      1 => 'Gli annunci contengono spesso informazioni importanti e dovrebbero essere letti prima possibile. Gli annunci appaiono in cima a ogni pagina del forum in cui sono stati scritti. L’amministratore può decidere se un utente può scrivere annunci o meno.' 
   ), 
   array( 
      0 => 'Cosa sono gli argomenti importanti?', 
      1 => 'Gli argomenti importanti (in inglese, Sticky Topics) appaiono in cima alla prima pagina del forum in cui sono stati scritti (dopo eventuali annunci). Come si intuisce dal nome stesso, contengono informazioni importanti e dovrebbero essere lette sempre. Come per gli annunci, l’amministratore può decidere se un utente può scriverli o meno.' 
   ), 
   array( 
      0 => 'Cosa sono gli argomenti chiusi?', 
      1 => 'Gli argomenti possono venire chiusi dai moderatori o dall’amministratore. Non è possibile rispondere ad un argomento chiuso così come i sondaggi chiusi terminano automaticamente. Un argomento può venir chiuso per varie ragioni, ad es. se contravviene ai Termini di Utilizzo.' 
   ), 
   array( 
      0 => 'Che cosa sono le icone argomenti?', 
      1 => 'Le icone argomenti sono immagini che possono essere associate agli argomenti per indicare il loro contenuto. La possibilità di usarle dipende dai permessi impostati dall’amministratore.' 
	),
	// This block will switch the FAQ-Questions to the second template column
	array(
		0 => '--',
		1 => '--'
	),
	array( 
      0 => '--', 
      1 => 'Livelli e gruppi di utenti' 
   ), 
   array( 
      0 => 'Cosa sono gli amministratori?', 
      1 => 'Gli amministratori sono gli utenti che hanno il più alto grado di controllo sull’intera Board; possono controllare qualsiasi elemento, inclusi i permessi, la disabilitazione (o «ban») degli utenti, la creazione di moderatori e gruppi di utenti, ecc. Inoltre, possono moderare tutti i forum.' 
   ), 
   array( 
      0 => 'Cosa sono i moderatori?', 
      1 => 'I moderatori sono utenti (o gruppi di utenti) il cui compito è quello di tenere sotto controllo i forum giorno per giorno. Hanno il potere di modificare o cancellare qualsiasi messaggio e di chiudere, riaprire, spostare o rimuovere qualsiasi argomento del forum da loro moderato. Generalmente il compito dei moderatori è quello di evitare che gli utenti vadano «fuori tema» (in inglese, <em>off-topic</em>) o che scrivano messaggi oltraggiosi ed offensivi.' 
   ), 
   array( 
      0 => 'Cosa sono i gruppi di utenti?', 
      1 => 'I gruppi permettono agli amministratori di riunire gli utenti. Ogni utente può appartenere a più gruppi e a ogni gruppo possono venire assegnati diversi permessi. Questo facilita l’amministratore nelle operazioni di creazione di moderatori per un forum, o di concessione di permessi per un forum privato, ecc.' 
   ), 
   array( 
      0 => 'Dove trovo i gruppi e come posso far parte di uno di essi?', 
      1 => 'Trovi i gruppi nella sezione <em>Gruppi</em> nel Pannello di Controllo Utente. Se vuoi far parte di uno di questi procedi cliccando sul pulsante appropriato. Non sempre però i gruppi sono ad <em>accesso aperto</em>. Alcuni sono chiusi e altri hanno l’elenco dei membri nascosto. Se il gruppo è aperto, puoi chiedere l’ammissione cliccando sul pulsante apposito. Dovrai ottenere l’approvazione del moderatore del gruppo, che potrebbe chiederti perché vuoi unirti al gruppo. Se il leader di un gruppo non accetta la tua richiesta, sei pregato di non assillarlo: probabilmente ha le sue buone ragioni.' 
   ), 
   array( 
      0 => 'Come divento leader di un gruppo?', 
      1 => 'I gruppi vengono creati dall’amministratore, che ne stabilisce anche il leader. Se desideri creare un nuovo gruppo, contatta l’amministratore, via posta elettronica o con un messaggio privato.' 
   ), 
   array( 
      0 => 'Perché alcuni gruppi di utenti appaiono in colori differenti?', 
      1 => 'È possibile per l’amministratore del forum assegnare un colore ai membri di un gruppo per rendere più semplice identificarli.' 
   ), 
   array( 
      0 => 'Che cos’è un gruppo di utenti predefinito?', 
      1 => 'Se sei membro di più di un gruppo di utenti, quello impostato come predefinito determina il colore e quali permessi di gruppo sono attivi. L’amministratore può permetterti di modificare il tuo gruppo di utenti predefinito dal Pannello di Controllo Utente.' 
   ), 
   array( 
      0 => 'Che cos’è il collegamento “Staff”?', 
      1 => 'Questa pagina fornisce una lista degli amministratori e dei moderatori, dando dettagli sui forum che moderano.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Messaggi privati' 
   ), 
   array( 
      0 => 'Non riesco ad inviare messaggi privati!', 
      1 => 'Ci sono tre ragioni per cui questo può accadere: non sei registrato o non hai effettuato l’accesso, l’amministratore ha disabilitato i messaggi privati per tutto il forum, oppure li ha disabilitati solo a te. Se il tuo caso è l’ultimo, prova a chiederne il motivo all’amministratore.' 
   ), 
   array( 
      0 => 'Continuano ad arrivarmi messaggi privati indesiderati!', 
      1 => 'Se continui a ricevere messaggi indesiderati da qualcuno, prova a informare della cosa l’amministratore, che può interdire l’uso dei messaggi privati a un determinato utente.' 
   ), 
   array( 
      0 => 'Ho ricevuto un messaggio di posta indesiderata o spam da qualcuno in questa Board!', 
      1 => 'Ci dispiace. Il sistema di invio di posta elettronica di questa Board include un sistema di protezione per risalire a chi manda questi messaggi. Dovresti mandare una copia del messaggio in questione all’amministratore, includendo anche l’intestazione, in modo che possa intervenire.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Amici e ignorati' 
   ), 
   array( 
      0 => 'Che cos’è la mia lista amici e ignorati?', 
      1 => 'Puoi usare queste liste per gestire gli altri iscritti. Gli utenti aggiunti alla tua lista amici saranno elencati nel Pannello di Controllo Utente per poter rapidamente controllare se sono connessi e inviare loro messaggi privati. A seconda delle possibilità dello stile, i messaggi di questi utenti possono anche venir evidenziati. Se aggiungi un utente alla tua lista ignorati ogni suo messaggio sarà nascosto automaticamente.' 
   ), 
   array( 
      0 => 'Come faccio ad aggiungere o rimuovere un utente dalla mia lista amici o ignorati?', 
      1 => 'Puoi aggiungere un utente alla tua lista in due modi. All’interno del profilo di ciascun utente, c’è un collegamento per aggiungerlo alla tua lista amici o avversari. Altrimenti, dal tuo Pannello di Controllo Utente puoi aggiungere direttamente un utente inserendo il suo nome utente. Puoi anche rimuovere un utente dalla lista dalla stessa pagina.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Ricerche nella Board' 
   ), 
   array( 
      0 => 'Come si fanno le ricerche nella Board?', 
      1 => 'Scrivendo una parola chiave nel riquadro di ricerca visibile nell’Indice, nei forum e negli argomenti. Alla ricerca avanzata si può accedere premendo il collegamento “Cerca” visibile in tutte le pagine.' 
   ), 
   array( 
      0 => 'Perché la mia ricerca non dà risultati?', 
      1 => 'Probabilmente la tua ricerca è troppo vaga e include dei termini troppo comuni che non sono indicizzati da phpBB3. Sii più specifico e usa le opzioni disponibili nella ricerca avanzata.' 
   ), 
   array( 
      0 => 'Perché la mia ricerca dà come risultato una pagina vuota?', 
      1 => 'La tua ricerca ha dato troppi risultati per le capacità di calcolo del server. Usa la ricerca avanzata e sii più specifico nella tua scelta dei termini da ricercare e dei forum in cui cercare.' 
   ), 
   array( 
      0 => 'Come posso cercare un utente?', 
      1 => 'Vai nella pagina “Utenti” e clicca sul collegamento “trova utente”, dopodiché segui le istruzioni.' 
   ), 
   array( 
      0 => 'Come posso trovare i miei messaggi e i miei argomenti?', 
      1 => 'Puoi trovare i messaggi da te inseriti cliccando su “Mostra i tuoi argomenti” presente nel tuo Pannello di Controllo Utente, e su “Cerca i messaggi dell’utente” presente nella pagina del tuo profilo. Puoi cercare i tuoi argomenti, usando la pagina di ricerca avanzata, compilando i vari campi opportunamente. Puoi comunque trovare rapidamente i tuoi messaggi, cliccando sull’omonima funzione “I tuoi messaggi”, generalmente disponibile in ogni pagina della Board.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Sottoscrizioni e segnalibri' 
   ), 
   array( 
      0 => 'Qual è la differenza fra segnalibri e sottoscrizione?', 
      1 => 'I segnalibri di phpBB3 sono molto simili ai segnalibri del tuo browser (preferiti in Internet Explorer). Non vieni necessariamente avvisato quando c’è una risposta, ma hai modo di tornare facilmente all’argomento; al contrario, in seguito ad una sottoscrizione sarai avvisato di un aggiornamento nell’argomento o nel forum col metodo da te scelto.' 
   ), 
   array( 
      0 => 'Come faccio ad sottoscrivere un determinato argomento o forum?', 
      1 => 'Per sottoscriverti ad un forum, quando entri nel forum premi il collegamento "Sottoscrivi forum": con questo sottoscrivi un forum esattamente come faresti con un argomento. Per sottoscrivere un argomento, puoi sia inserirvi un messaggio e selezionare la casella relativa o premere – all’interno dell’argomento stesso – il collegamento che dice "Sottoscrivi argomento".' 
   ), 
   array( 
      0 => 'Come cancello le mie sottoscrizioni?', 
      1 => 'Per cancellare le tue sottoscrizioni, basta andare nel tuo Pannello di Controllo Utente e segui i collegamenti alle tue sottoscrizioni.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Allegati' 
   ), 
   array( 
      0 => 'Quali allegati sono ammessi in questa Board?', 
      1 => 'Ciascun amministratore può abilitare o meno certi tipi di allegati. Se non sei sicuro di quali siano permessi, contatta l’amministratore per avere assistenza.' 
   ), 
   array( 
      0 => 'Come faccio a trovare i miei allegati?', 
      1 => 'Per trovare la lista degli allegati da te caricati, vai nel tuo Pannello di Controllo Utente, e segui i collegamenti alla sezione degli allegati.' 
   ), 
   array( 
      0 => '--', 
      1 => 'Informazioni su phpBB 3' 
   ), 
   array( 
      0 => 'Chi ha scritto questo programma?', 
      1 => 'Questo programma (nella sua forma originale) è prodotto e rilasciato da <a href="https://www.phpbb.com/">phpBB Group</a>, che ne detiene anche il brevetto. È reso disponibile sotto la GNU General Public Licence e può essere liberamente distribuito; clicca sul collegamento per maggiori informazioni.' 
   ), 
   array( 
      0 => 'Perché la caratteristica X non è disponibile?', 
      1 => 'Questo programma è stato scritto da phpBB Group. Se credi che ci sia bisogno di aggiungere una nuova funzionalità, visita il sito <a href="https://area51.phpbb.com/">Area51</a>, dove potrai supportare idee esistenti o suggerire nuove funzionalità.' 
   ), 
   array( 
      0 => 'Chi devo contattare per segnalare abusi e/o per questioni d’ordine legale concernenti questa Board?', 
      1 => 'Devi contattare l’amministratore di questa Board. Se non riesci a trovarlo, prova a contattare uno dei moderatori e chiedi a chi puoi rivolgerti. Se ancora non ottieni risposta, puoi contattare il proprietario del dominio (fai una ricerca con <em>whois</em>) oppure, se la Board è ospitata da un servizio gratuito (ad es. yahoo, free.fr, f2s.com, ecc.), l’amministratore di tale servizio. Nota che il phpBB Group non ha assolutamente alcun controllo e non può essere ritenuto responsabile di come, dove e da chi viene utilizzata questa Board. È assolutamente inutile contattare il phpBB Group in relazione a qualsiasi questione legale non direttamente collegata al sito phpbb.com o al software phpBB stesso. I messaggi di posta elettronica inviati al phpBB Group riguardanti l’uso da parte di terzi di questo programma non riceveranno risposta.' 
   ) 
); 
?>