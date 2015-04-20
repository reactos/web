<?php
/**
*
* help_bbcode [French]
*
* @package language
* @version $Id$
* @copyright (c) 2005 phpBB Group, (c) Maël Soucaze
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
		1 => 'Introduction'
	),
	array(
		0 => 'Qu’est-ce que le BBCode ?',
		1 => 'Le BBCode est une implémentation spéciale de l’HTML. Vous pouvez insérer du BBCode dans vos messages sur le forum sous réserve que cette fonctionnalité ait été autorisée par un administrateur. De plus, vous pouvez désactiver le BBCode sur chacun de vos messages par l’intermédiaire du formulaire de rédaction. Le BBCode est similaire à l’architecture de l’HTML, les balises sont contenues entre des crochets [ et ] à la place de &lt; et &gt;, et il offre un meilleur contrôle sur la mise en forme. Selon le template que vous utilisez, vous pouvez trouver et insérer très facilement du BBCode dans vos messages par l’intermédiaire d’une interface cliquable située juste au-dessus du formulaire de rédaction. Si ces brèves explications ne vous conviennent pas, vous pouvez consulter le guide suivant qui s’avère très explicite.'
	),
	array(
		0 => '--',
		1 => 'Mise en forme du texte'
	),
	array(
		0 => 'Comment puis-je mettre du texte en gras, en italique et en souligné ?',
		1 => 'Le BBCode inclut des balises qui vous permettent de modifier rapidement le style de votre texte brut. Ceci peut être réalisé grâce aux méthodes suivantes : <ul><li>Pour mettre une partie d’un texte en gras, il faut l’enfermer entre les balises <strong>[b][/b]</strong>. Par exemple :<br /><br /><strong>[b]</strong>Salut<strong>[/b]</strong><br /><br />Deviendra : <strong>Salut</strong></li><li>Pour souligner une partie d’un texte, utilisez les balises <strong>[u][/u]</strong>. Par exemple :<br /><br /><strong>[u]</strong>Bonjour<strong>[/u]</strong><br /><br />Deviendra : <span style="text-decoration: underline">Bonjour</span></li><li>Pour mettre une partie d’un texte en italique, utilisez les balises <strong>[i][/i]</strong>. Par exemple :<br /><br />C’est <strong>[i]</strong>super !<strong>[/i]</strong><br /><br />Deviendra : C’est <i>super !</i></li></ul>'
	),
	array(
		0 => 'Comment puis-je modifier la taille ou la couleur du texte ?',
		1 => 'Pour modifier la taille ou la couleur du texte, vous pourrez utiliser les balises suivantes. Cependant, gardez à l’esprit que le rendu visuel final dépendra également du navigateur internet et du système d’exploitation de l’utilisateur : <ul><li>Pour insérer une couleur sur une partie d’un texte, il faut l’enfermer entre les balises <strong>[color=][/color]</strong>. Vous pouvez saisir le nom d’une couleur reconnue, comme par exemple red, blue ou yellow, ou saisir directement son code hexadécimal, comme #FFFFFF ou #000000. Par exemple, pour mettre une partie d’un texte en rouge, vous pouvez utiliser :<br /><br /><strong>[color=red]</strong>Salut !<strong>[/color]</strong><br /><br />Ou encore :<br /><br /><strong>[color=#FF0000]</strong>Salut !<strong>[/color]</strong><br /><br />Ce qui, dans les deux cas, deviendra : <span style="color:red">Salut !</span></li><li>Pour modifier la taille de la police de caractères d’une partie d’un texte, utilisez les balises <strong>[size=][/size]</strong>. es balises dépendent du style que l’utilisateur a sélectionné, mais le format recommandé est une valeur numérique représentant la taille du texte en pourcentage, commençant de 50 (minuscule) et allant jusqu’à 200 (énorme). Par exemple :<br /><br /><strong>[size=30]</strong>MINUSCULE<strong>[/size]</strong><br /><br />Deviendra : <span style="font-size:30%;">MINUSCULE</span><br /><br />Alors que :<br /><br /><strong>[size=200]</strong>ÉNORME !<strong>[/size]</strong><br /><br />Deviendra : <span style="font-size:200%;">ÉNORME !</span></li></ul>'
	),
	array(
		0 => 'Puis-je combiner des balises de mise en forme ?',
		1 => 'Bien sûr ! Par exemple, pour obtenir l’attention de tout le monde, vous pouvez écrire :<br /><br /><strong>[size=200][color=red][b]</strong>REGARDEZ-MOI !<strong>[/b][/color][/size]</strong><br /><br />Ce qui deviendra : <span style="color:red;font-size:200%;"><strong>REGARDEZ-MOI !</strong></span><br /><br />Cependant, nous vous déconseillons fortement d’utiliser fréquemment ce genre de mise en forme ! Gardez à l’esprit qu’il faut simplement fermer les balises correctement et dans le bon ordre. Par exemple, ce qui suit est incorrect :<br /><br /><strong>[b][u]</strong>Ceci est incorrect<strong>[/b][/u]</strong>'
	),
	array(
		0 => '--',
		1 => 'Citation et données de largeur fixe'
	),
	array(
		0 => 'Citation de texte dans les réponses',
		1 => 'Il y a deux manières de citer un texte, avec ou sans référence :<ul><li>Lorsque vous utilisez la fonction de citation afin de répondre à un message sur le forum, vous devriez noter que le texte qui est ajouté à la fenêtre du message est inséré entre les balises <strong>[quote=&quot;&quot;][/quote]</strong>. Cette méthode vous permet de citer, comme référence, une personne ou autre chose que vous choisissez de commenter ! Par exemple, pour citer une partie d’un texte rédigé par M. Blobby, vous devez saisir :<br /><br /><strong>[quote=&quot;M. Blobby&quot;]</strong>Le texte que M. Blobby a rédigé sera situé ici<strong>[/quote]</strong><br /><br />Le rendu final, &quot;M. Blobby a écrit :&quot;, sera ajouté automatiquement avant le texte actuel. Gardez à l’esprit que vous devez <strong>obligatoirement</strong> insérer les guillemets de citation &quot;&quot; autour du nom que vous citez, ils ne sont pas optionnels.</li><li>La seconde méthode vous permet de citer quelque chose de manière anonyme. Pour l’utiliser, enfermez le texte entre les balises <strong>[quote][/quote]</strong>. Lorsque vous consulterez le message ultérieurement, il affichera simplement le texte dans un bloc de citation.</li></ul>'
	),
	array(
		0 => 'Mise en forme de codes ou de données de largeur fixe',
		1 => 'Si vous souhaitez insérer un fragment de code ou quelque chose qui demande une largeur fixe, comme la police de caractères Courier, vous devez enfermer le texte entre les balises <strong>[code][/code]</strong>. Par exemple :<br /><br /><strong>[code]</strong>echo &quot;Ceci est un fragment de code&quot;;<strong>[/code]</strong><br /><br />Toutes les balises de mise en forme présentes entre les balises <strong>[code][/code]</strong> sont conservées telles quelles lorsque vous consulterez le message ultérieurement. La syntaxe PHP peut être mise en évidence en utilisant les balises <strong>[code=php][/code]</strong> et il est recommandé de publier de réels fragments de code PHP afin d’en améliorer la lisibilité.'
	),
	array(
		0 => '--',
		1 => 'Genèse de listes'
	),
	array(
		0 => 'Création d’une liste non-ordonnée',
		1 => 'Le BBCode supporte deux types de liste, la liste ordonnée et la liste non-ordonnée. Elles sont pratiquement identiques par rapport à leur équivalent en HTML. Une liste non-ordonnée publie chaque article l’un après l’autre, en utilisant le caractère étoile. Pour créer une liste non-ordonnée, vous devez utiliser les balises <strong>[list][/list]</strong> et définir chaque article dans la liste en utilisant les balises <strong>[*]</strong>. Par exemple, pour lister vos couleurs favorites, vous pouvez utiliser :<br /><br /><strong>[list]</strong><br /><strong>[*]</strong>Rouge<br /><strong>[*]</strong>Bleu<br /><strong>[*]</strong>Jaune<br /><strong>[/list]</strong><br /><br />Ce qui deviendra la liste :<ul><li>Rouge</li><li>Bleu</li><li>Jaune</li></ul>'
	),
	array(
		0 => 'Création d’une liste ordonnée',
		1 => 'Le second type de liste, la liste ordonnée, vous donne le contrôle sur ce qui est affiché devant chaque article. Vous devez utiliser les balises <strong>[list=1][/list]</strong> afin de créer une liste numérotée, ou bien encore les balises <strong>[list=a][/list]</strong> afin de créer une liste alphabétique. Comme pour la liste non-ordonnée, les articles doivent être définis en utilisant la balise <strong>[*]</strong>. Par exemple :<br /><br /><strong>[list=1]</strong><br /><strong>[*]</strong>Aller faire les boutiques<br /><strong>[*]</strong>Acheter un nouvel ordinateur<br /><strong>[*]</strong>Râler contre l’ordinateur lorsqu’il est bloqué<br /><strong>[/list]</strong><br /><br />Deviendra :<ol style="list-style-type: decimal;"><li>Aller faire les boutiques</li><li>Acheter un nouvel ordinateur</li><li>Râler contre l’ordinateur lorsqu’il est bloqué</li></ol>Pour créer une liste alphabétique, vous devez cependant utiliser :<br /><br /><strong>[list=a]</strong><br /><strong>[*]</strong>La première réponse possible<br /><strong>[*]</strong>La seconde réponse possible<br /><strong>[*]</strong>La troisième réponse possible<br /><strong>[/list]</strong><br /><br />Ce qui deviendra :<ol style="list-style-type: lower-alpha"><li>La première réponse possible</li><li>La seconde réponse possible</li><li>La troisième réponse possible</li></ol>'
	),
	// This block will switch the FAQ-Questions to the second template column
	array(
		0 => '--',
		1 => '--'
	),
	array(
		0 => '--',
		1 => 'Création de liens'
	),
	array(
		0 => 'Insérer un lien vers un site quelconque',
		1 => 'Le BBCode de phpBB propose plusieurs manières de créer des URI (Uniform Resource Indicators), plus connues sous le nom d’URL.<ul><li>La première emploie la balise <strong>[url=][/url]</strong>, où ce qui est inséré après le signe = fera agir le contenu de cette balise en tant que lien. Par exemple, pour insérer un lien vers phpBB.com, vous pouvez utiliser :<br /><br /><strong>[url=http://www.phpbb.com/]</strong>Visitez phpBB !<strong>[/url]</strong><br /><br />Ceci génèrera le lien suivant : <a href="http://www.phpbb.com/">Visitez phpBB !</a> Veuillez noter que le lien peut s’ouvrir dans la même fenêtre ou dans une nouvelle fenêtre, selon les préferences du navigateur des utilisateurs.</li><li>Si vous souhaitez que le lien soit affiché comme un lien basique, vous pouvez employer simplement ceci :<br /><br /><strong>[url]</strong>http://www.phpbb.com/<strong>[/url]</strong><br /><br />Ceci générera le lien suivant : <a href="http://www.phpbb.com/">http://www.phpbb.com/</a></li><li>De plus, une des fonctionnalités de phpBB permet d’insérer les <i>liens magiques</i>, ce qui transformera n’importe quel lien en lien syntaxiquement correct, sans que vous n’ayez besoin d’indiquer des balises ou même encore d’ajouter http://. Par exemple, en écrivant www.phpbb.com dans votre message, ceci se complètera automatiquement en <a href="http://www.phpbb.com/">www.phpbb.com</a> lorsque vous verrez votre message par la suite.</li><li>La même chose est valable pour les adresses de courrier électronique, vous pouvez cependant indiquer une adresse explicite, par exemple :<br /><br /><strong>[email]</strong>inconnu@domaine.adr<strong>[/email]</strong><br /><br />Ce qui deviendra : <a href="mailto:inconnu@domaine.adr">inconnu@domaine.adr</a>, ou vous pouvez simplement écrire inconnu@domaine.adr dans votre message et celui-ci sera automatiquement converti lors de la visualisation.</li></ul>Comme avec toutes les balises BBCode, vous pouvez insérer des liens autour d’autres balises comme <strong>[img][/img]</strong> (consultez la prochaine question), <strong>[b][/b]</strong>, etc. Comme pour les balises de mise en forme, il vous appartient d’en assurer l’usage correct d’ouverture et de fermeture des balises, et ceci dans le bon ordre, comme par exemple :<br /><br /><strong>[url=http://www.google.fr/][img]</strong>http://www.google.fr/intl/fr_fr/images/logo.gif<strong>[/url][/img]</strong><br /><br />N’est <span style="text-decoration: underline">pas</span> correct, ce qui peut mener à la suppression de votre message, soyez donc vigilant.'
	),
	array(
		0 => '--',
		1 => 'Affichage d’images dans les messages'
	),
	array(
		0 => 'Ajout d’une image dans un message',
		1 => 'Le BBCode de phpBB intègre une balise qui vous permet d’insérer des images dans vos messages. Les deux choses importantes à garder à l’esprit lors de l’utilisation des balises d’images sont que l’excès d’images dans les messages n’est pas apprécié par la plupart des d’utilisateurs et que l’image que vous souhaitez afficher doit être déjà disponible sur internet (elle ne peut pas exister seulement sur votre ordinateur, à moins que vous travailliez directement depuis un serveur internet !). Pour afficher une image, vous devez insérer entre les balises <strong>[img][/img]</strong> le lien pointant vers l’image. Par exemple :<br /><br /><strong>[img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img]</strong><br /><br />Comme noté précédemment dans la section des liens située ci-dessus, vous pouvez intégrer une image entre des balises <strong>[url][/url]</strong>. Par exemple :<br /><br /><strong>[url=http://www.google.com/][img]</strong>http://www.google.com/intl/en_ALL/images/logo.gif<strong>[/img][/url]</strong><br /><br />Deviendra :<br /><br /><a href="http://www.google.com/"><img src="http://www.google.com/intl/en_ALL/images/logo.gif" alt="" /></a>'
	),
	array(
		0 => 'Ajout de pièces jointes dans un message',
		1 => 'Les pièces jointes peuvent dès à présent être insérées dans les messages en utilisant le nouveau BBCode <strong>[attachment=][/attachment]</strong>, si cette fonctionnalité a été activée par l’administrateur du forum et si vous en avez les permissions appropriées. Pour insérer des pièces jointes en ligne, un onglet à cet effet est affiché en bas de l’écran de rédaction.'
	),
	array(
		0 => '--',
		1 => 'Divers'
	),
	array(
		0 => 'Puis-je ajouter mes propres balises ?',
		1 => 'Si vous êtes un administrateur de ce forum et que vous en avez les permissions appropriées, vous pouvez ajouter davantage de BBCodes dans la section « Personnaliser les BBCodes ».'
	)
);

?>