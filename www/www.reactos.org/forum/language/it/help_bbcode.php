<?php
/**
*
* help_bbcode [Italian]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group
* @copyright (c) 2010 phpBB.it - translated on 2010-03-01
* @copyright (c) 2011 phpBBItalia.net - translated on 2011-06-15
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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
		1 => 'Introduzione'
	),
	array(
		0 => 'Cos’è il BBCode?',
		1 => 'Il BBCode è un ampliamento speciale del codice HTML. L’uso del BBCode nei tuoi messaggi è determinato dall’amministratore. Inoltre puoi disabilitare il BBCode in ogni messaggio attraverso il modulo di invio. Il BBCode ha uno stile simile all’HTML; i tag sono racchiusi in parentesi quadre [ e ] piuttosto che in &lt; e &gt; e offre grande controllo su cosa e come vogliamo mostrare il messaggio. La facilità di utilizzo del BBCode nei tuoi messaggi dipende dal modello che stai utilizzando. Per ogni problema puoi far riferimento a questa guida.'
	),
	array(
		0 => '--',
		1 => 'Formattazione del testo'
	),
	array(
		0 => 'Come creare il testo in grassetto, sottolineato o corsivo',
		1 => 'Il BBCode include dei tag per permetterti di cambiare velocemente lo stile di base del tuo testo. Questo avviene nel seguente modo: <ul><li>Per il testo in grassetto usa <strong>[b][/b]</strong>, es.: <br /><br /><strong>[b]</strong>Ciao<strong>[/b]</strong><br /><br />diventerà <strong>Ciao</strong></li><li>Per il testo sottolineato usa <strong>[u][/u]</strong>, es.:<br /><br /><strong>[u]</strong>Buon giorno<strong>[/u]</strong><br /><br />diventa <span style="text-decoration: underline">Buon giorno</span></li><li>Per il testo in corsivo usa <strong>[i][/i]</strong>, es.: <br /><br />Questo è <strong>[i]</strong>Grandioso!<strong>[/i]</strong><br /><br />diventa Questo è <i>Grandioso!</i></li></ul>'
	),
	array(
		0 => 'Come cambiare colore o grandezza al testo',
		1 => 'Per modificare il colore o la grandezza del testo puoi usare i seguenti tag. Tieni a mente che il risultato di come apparirà dipende dal browser e dal sistema di chi lo vede: <ul><li>Cambiare il colore al testo è possibile inserendolo in <strong>[color=][/color]</strong>. Puoi specificare sia un nome di colore riconosciuto (esempio: red, blue, yellow, ecc.) o l’alternativa esadecimale, come #FFFFFF, #000000. Ad esempio, per creare del testo rosso puoi usare:<br /><br /><strong>[color=red]</strong>Ciao!<strong>[/color]</strong><br /><br />oppure<br /><br /><strong>[color=#FF0000]</strong>Ciao!<strong>[/color]</strong><br /><br /> tutti e due daranno come risultato <span style="color:red">Ciao!</span></li><li>Cambiare la dimensione del testo è possibile in modo similare, usando <strong>[size=][/size]</strong>. Questo tag è influenzato dallo stile che l’utente ha selezionato ma il formato raccomandato è un valore numerico rappresentante la dimensione del testo in percentuale, da 20 fino a 200 (molto grande) come default. Per esempio:<br /><br /><strong>[size=30]</strong>Piccolo<strong>[/size]</strong><br /><br />diventa <span style="font-size:30%;">Piccolo</span><br /><br />mentre:<br /><br /><strong>[size=200]</strong>Enorme!<strong>[/size]</strong><br /><br />diventa <span style="font-size:200%;">Enorme!</span></li></ul>'
	),
	array(
		0 => 'Posso combinare più tag?',
		1 => 'Certo che puoi, ad esempio per attirare l’attenzione di qualcuno puoi scrivere:<br /><br /><strong>[size=150][color=red][b]</strong>Guardami!<strong>[/b][/color][/size]</strong><br /><br />questo genera <span style="color:red;font-size:250%;"><strong>Guardami!</strong></span><br /><br />Non ti consigliamo comunque di esagerare e scrivere molto testo in questo modo. Ricordati inoltre che è compito tuo assicurarti che i tag siano chiusi correttamente. Ad esempio, quello che segue non è corretto:<br /><br /><strong>[b][u]</strong>Questo è sbagliato<strong>[/b][/u]</strong>'
	),
	array(
		0 => '--',
		1 => 'Citazioni e testo a larghezza fissa'
	),
	array(
		0 => 'Citazioni di testo nelle risposte',
		1 => 'Ci sono due modi per fare una citazione, con un referente o senza.<ul><li>Quando utilizzi la funzione Citazione per rispondere ad un messaggio sul forum devi notare che il testo del messaggio viene incluso nella finestra del messaggio tra <strong>[quote=&quot;&quot;][/quote]</strong>. Questo metodo ti permette di fare una citazione riferendoti ad una persona o qualsiasi altra cosa che hai deciso di inserire! Per esempio, per citare un pezzo di testo di Mr. Blobby devi inserire:<br /><br /><strong>[quote=&quot;Mr. Blobby&quot;]</strong>Il testo di Mr. Blobby andrà qui<strong>[/quote]</strong><br /><br />Nel messaggio verrà automaticamente aggiunto, Mr. Blobby ha scritto: prima del testo citato. Ricorda che tu <strong>devi</strong> includere le parentesi "" attorno al nome che stai citando, non sono opzionali.</li><li>Il secondo metodo ti permette di citare qualcosa senza referente. Per utilizzare questo metodo, racchiudi il testo tra i tag <strong>[quote][/quote]</strong>. Quando vedrai il messaggio comparirà semplicemente il testo dentro un riquadro di citazione.</li></ul>'
	),
	array(
		0 => 'Mostrare il codice o dati a larghezza fissa',
		1 => 'Se vuoi mostrare un pezzo di codice o qualcosa che ha bisogno di una larghezza fissa, come il carattere Courier, devi racchiudere il testo tra i tag <strong>[code][/code]</strong>, es.:<br /><br /><strong>[code]</strong>echo "Questo è un codice";<strong>[/code]</strong><br /><br />Tutta la formattazione utilizzata tra i tag <strong>[code][/code]</strong> viene mantenuta quando viene visualizzata in seguito. Per evidenziare la sintassi PHP usa i tag <strong>[code=php][/code]</strong>, che ne permettono una lettura migliore.'
	),
	array(
		0 => '--',
		1 => 'Creazione di liste'
	),
	array(
		0 => 'Creare una lista non ordinata',
		1 => 'Il BBCode supporta due tipi di liste, ordinate e non. Sono essenzialmente la stessa cosa del loro equivalente in HTML. Una lista non ordinata mostra ogni oggetto nella tua lista in modo sequenziale, uno dopo l’altro inserendo un punto per ogni riga. Per creare una lista non ordinata usa <strong>[list][/list]</strong> e definisci ogni oggetto nella lista usando <strong>[*]</strong>. Per esempio per fare una lista dei tuoi colori preferiti puoi usare:<br /><br /><strong>[list]</strong><br /><strong>[*]</strong>Rosso<br /><strong>[*]</strong>Blu<br /><strong>[*]</strong>Giallo<br /><strong>[/list]</strong><br /><br />Questo mostrerà questa lista:<ul><li>Rosso</li><li>Blu</li><li>Giallo</li></ul>'
	),
	array(
		0 => 'Creare una lista ordinata',
		1 => 'Una lista ordinata ti permette di controllare il modo in cui ogni oggetto della lista viene mostrato. Per creare una lista ordinata usa <strong>[list=1][/list]</strong> per creare una lista numerata o alternativamente <strong>[list=a][/list]</strong> per una lista alfabetica. Come per la lista non ordinata gli oggetti vengono specificati utilizzando <strong>[*]</strong>. Per esempio:<br /><br /><strong>[list=1]</strong><br /><strong>[*]</strong>Vai al negozio<br /><strong>[*]</strong>Compra un nuovo computer<br /><strong>[*]</strong>Impreca sul computer quando si blocca<br /><strong>[/list]</strong><br /><br />verrà mostrato così:<ol style="list-style-type: decimal;"><li>Vai al negozio</li><li>Compra un nuovo computer</li><li>Impreca sul computer quando si blocca</li></ol>mentre per una lista alfabetica devi usare:<br /><br /><strong>[list=a]</strong><br /><strong>[*]</strong>La prima risposta possibile<br /><strong>[*]</strong>La seconda risposta possibile<br /><strong>[*]</strong>La terza risposta possibile<br /><strong>[/list]</strong><br /><br />sarà<ol style="list-style-type: lower-alpha"><li>La prima risposta possibile</li><li>La seconda risposta possibile</li><li>La terza risposta possibile</li></ol>'
	),
	// This block will switch the FAQ-Questions to the second template column
	array(
		0 => '--',
		1 => '--'
	),
	array(
		0 => '--',
		1 => 'Creare collegamenti'
	),
	array(
		0 => 'Creare collegamenti a siti esterni',
		1 => 'Il BBCode del phpBB3 supporta diversi modi per creare URI, Uniform Resource Indicators meglio conosciuti come URL.<ul><li>Il primo di questi utilizza il tag <strong>[url=][/url]</strong>, qualunque cosa digiti dopo il segno = genererà il contenuto del tag che si comporterà come URL. Per esempio per linkarsi a phpBB.com devi usare:<br /><br /><strong>[url=http://www.phpbb.com/]</strong>Visita phpBB!<strong>[/url]</strong><br /><br />Questo genera il seguente link, <a href="http://www.phpbb.com/">Visita phpBB!</a> Come puoi vedere il link si apre in una nuova finestra così l’utente può continuare a navigare nei forum.</li><li>Se vuoi che l’URL stesso venga mostrato come link puoi fare questo semplicemente usando:<br /><br /><strong>[url]</strong>http://www.phpbb.com/<strong>[/url]</strong><br /><br />Questo genera il seguente link, <a href="http://www.phpbb.com/">http://www.phpbb.com/</a></li><li>Inoltre phpBB dispone di una funzione chiamata <i>Magic Links</i>, questo cambierà ogni URL sintatticamente corretto in un link senza la necessità di specificare nessun tag o http://. Per esempio digitando www.phpbb.com nel tuo messaggio automaticamente verrà cambiato in <a href="http://www.phpbb.com/">www.phpbb.com</a> e verrà mostrato nel messaggio finale.</li><li>La stessa cosa accade per gli indirizzi email, puoi specificare un indirizzo esplicitamente, per esempio:<br /><br /><strong>[email]</strong>no.one@domain.adr<strong>[/email]</strong><br /><br />che mostrerà <a href="mailto:no.one@domain.adr">no.one@domain.adr</a> oppure puoi digitare no.one@domain.adr che verrà automaticamente convertito all’interno del tuo messaggio.</li></ul>Come per tutti i tag del BBCode puoi includere URL in ogni altro tag come <strong>[img][/img]</strong> (guarda il punto successivo), <strong>[b][/b]</strong>, ecc. Come per i tag di formattazione dipende da te verificare che tutti i tag siano correttamente aperti e chiusi, per esempio:<br /><br /><strong>[url=http://www.google.com/][img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/url][/img]</strong><br /><br /><span style="text-decoration: underline">non</span> è corretto e potrebbe cancellare il tuo messaggio. Quindi presta attenzione.'
	),
	array(
		0 => '--',
		1 => 'Mostrare immagini nei messaggi'
	),
	array(
		0 => 'Aggiungere un’immagine al messaggio',
		1 => 'Il BBCode del phpBB3 incorpora un tag per l’inclusione di immagini nei tuoi messaggi. Ci sono due cose importanti da ricordare nell’usare questo tag: a molti utenti non piacciono molte immagini nei messaggi e in secondo luogo l’immagine deve essere già disponibile su internet (non può esistere solo sul tuo computer per esempio, a meno che tu non abbia un webserver!). Per mostrare delle immagini devi inserire l’URL che rimanda all’immagine con il tag <strong>[img][/img]</strong>. Per esempio:<br /><br /><strong>[img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img]</strong><br /><br />Puoi inserire un’immagine nel tag <strong>[url][/url]</strong> se vuoi, es.<br /><br /><strong>[url=http://www.google.com/][img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img][/url]</strong><br /><br />genera:<br /><br /><a href="http://www.google.com/"><img src="http://www.google.com/intl/en_ALL/images/logo.gif" alt="" /></a>'
	),
	array(
		0 => 'Aggiungere allegati nei messaggi',
		1 => 'Gli allegati possono essere inseriti in qualsiasi punto di un messaggio usando il BBCode <strong>[attachment=][/attachment]</strong>, se la funzionalità degli allegati è stata abilitata da un amministratore e se hai i permessi adeguati. All’interno della schermata di scrittura messaggi è presente un comando per inserire gli allegati all’interno del testo.'
	),
	array(
		0 => '--',
		1 => 'Altro'
	),
	array(
		0 => 'Posso aggiungere i miei tag personali?',
		1 => 'Se sei un amministratore di questa Board ed hai permessi adeguati, puoi aggiungere altri BBCode nella sezione BBCode personalizzati.'
	)
);

?>