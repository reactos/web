<?php
/**
*
* install [French]
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

$lang = array_merge($lang, array(
	'ADMIN_CONFIG'				=> 'Configuration de l’administrateur',
	'ADMIN_PASSWORD'			=> 'Mot de passe de l’administrateur',
	'ADMIN_PASSWORD_CONFIRM'	=> 'Confirmer le mot de passe de l’administrateur',
	'ADMIN_PASSWORD_EXPLAIN'	=> 'Veuillez saisir un mot de passe compris entre 6 et 30 caractères de long.',
	'ADMIN_TEST'				=> 'Vérification des réglages de l’administrateur',
	'ADMIN_USERNAME'			=> 'Nom d’utilisateur de l’administrateur',
	'ADMIN_USERNAME_EXPLAIN'	=> 'Veuillez saisir un nom d’utilisateur compris entre 3 et 20 caractères de long.',
	'APP_MAGICK'				=> 'Support d’Imagemagick [ Pièces jointes ]',
	'AUTHOR_NOTES'				=> 'Notes de l’auteur<br />» %s',
	'AVAILABLE'					=> 'Disponible',
	'AVAILABLE_CONVERTORS'		=> 'Convertisseurs disponibles',

	'BEGIN_CONVERT'					=> 'Démarrer la conversion',
	'BLANK_PREFIX_FOUND'			=> 'Une vérification de vos tables a détecté la présence d’une installation correcte n’utilisant pas de préfixe de table.',
	'BOARD_NOT_INSTALLED'			=> 'Aucune installation trouvée',
	'BOARD_NOT_INSTALLED_EXPLAIN'	=> 'Une installation de phpBB par défaut est obligatoire afin que l’outil de conversion puisse fonctionner. Veuillez <a href="%s">procéder à la première installation de phpBB3</a>.',
	'BACKUP_NOTICE'					=> 'Veuillez effectuer une sauvegarde de votre forum avant de procéder à sa mise à jour au cas où des erreurs se produiraient lors du processus de mise à jour.',

	'CATEGORY'					=> 'Catégorie',
	'CACHE_STORE'				=> 'Type de cache',
	'CACHE_STORE_EXPLAIN'		=> 'L’emplacement physique où les données sont mises en cache. Il est préférable de sélectionner le système par fichiers.',
	'CAT_CONVERT'				=> 'Convertir',
	'CAT_INSTALL'				=> 'Installer',
	'CAT_OVERVIEW'				=> 'Prévisualiser',
	'CAT_UPDATE'				=> 'Mettre à jour',
	'CHANGE'					=> 'Modifier',
	'CHECK_TABLE_PREFIX'		=> 'Veuillez vérifier votre préfixe de table, puis réessayer.',
	'CLEAN_VERIFY'				=> 'Nettoyage et vérification de la structure finale',
	'CLEANING_USERNAMES'		=> 'Nettoyage des noms d’utilisateurs',
	'COLLIDING_CLEAN_USERNAME'	=> '<strong>%s</strong> est le nom d’utilisateur nettoyé pour :',
	'COLLIDING_USERNAMES_FOUND'	=> 'Des noms d’utilisateurs similaires ont été trouvés sur votre ancien forum. Pour effectuer correctement la conversion, vous devez supprimer ou renommer ces utilisateurs de sorte que chaque nom d’utilisateur soit unique.',
	'COLLIDING_USER'			=> '» ID de l’utilisateur : <strong>%d</strong> nom d’utilisateur : <strong>%s</strong> (%d messages)',
	'CONFIG_CONVERT'			=> 'Conversion de la configuration',
	'CONFIG_FILE_UNABLE_WRITE'	=> 'Il n’a pas été possible d’écrire le fichier de configuration. Des méthodes alternatives concernant ce fichier sont affichées ci-dessous.',
	'CONFIG_FILE_WRITTEN'		=> 'Le fichier de configuration a été écrit. Vous pouvez à présent continuer vers la prochaine étape de l’installation.',
	'CONFIG_PHPBB_EMPTY'		=> 'La variable de configuration de phpBB3 concernant « %s » est vide.',
	'CONFIG_RETRY'				=> 'Réessayer',
	'CONTACT_EMAIL_CONFIRM'		=> 'Confirmer l’adresse de courrier électronique de contact',
	'CONTINUE_CONVERT'			=> 'Continuer la conversion',
	'CONTINUE_CONVERT_BODY'		=> 'Une tentative de conversion antérieure a été détectée. Vous pouvez à présent commencer une nouvelle conversion ou continuer celle en cours.',
	'CONTINUE_LAST'				=> 'Continuer les dernières instructions',
	'CONTINUE_OLD_CONVERSION'	=> 'Continuer la conversion antérieure',
	'CONVERT'					=> 'Convertir',
	'CONVERT_COMPLETE'			=> 'Conversion terminée',
	'CONVERT_COMPLETE_EXPLAIN'	=> 'Vous avez converti votre forum vers phpBB 3.0. Vous pouvez à présent vous connecter et <a href="../">accéder à votre forum</a>. Veuillez vous assurer que les réglages ont été correctement transférés avant d’activer votre forum en supprimant le répertoire d’installation. N’oubliez pas que de l’aide en ligne concernant l’utilisation de phpBB est disponible par l’intermédiaire de la <a href="https://www.phpbb.com/support/documentation/3.0/">documentation</a>, des <a href="https://www.phpbb.com/community/viewforum.php?f=46">forums de support officiels</a> ou encore du <a href="http://forum.phpbb.fr/">forum de support francophone</a>.',
	'CONVERT_INTRO'				=> 'Bienvenue sur l’outil de conversion de phpBB',
	'CONVERT_INTRO_BODY'		=> 'Vous pouvez importer ici des données venant d’autres systèmes de forums installés. La liste ci-dessous affiche tous les modules de conversion actuellement disponibles. Si aucun convertisseur n’est affiché dans cette liste correspondant au logiciel de forum que vous souhaitez convertir, veuillez vérifier sa présence sur notre site internet où des modules de conversion seront prochainement téléchargeables.',
	'CONVERT_NEW_CONVERSION'	=> 'Nouvelle conversion',
	'CONVERT_NOT_EXIST'			=> 'Le convertisseur que vous avez spécifié n’existe pas.',
	'CONVERT_OPTIONS'			=> 'Options',
	'CONVERT_SETTINGS_VERIFIED'	=> 'Les informations que vous avez saisies ont été vérifiées. Veuillez cliquer sur le bouton ci-dessous afin de commencer le processus de conversion.',
	'CONV_ERR_FATAL'			=> 'Erreur fatale de conversion',

	'CONV_ERROR_ATTACH_FTP_DIR'			=> 'Le transfert des pièces jointes par FTP est activé sur votre ancien forum. Veuillez désactiver cette option et vous assurer qu’un répertoire de téléchargement soit correctement spécifié, puis copiez toutes les pièces jointes vers ce nouveau répertoire qui doit être accessible depuis internet. Après avoir réalisé ceci, redémarrez le convertisseur.',
	'CONV_ERROR_CONFIG_EMPTY'			=> 'Aucune information de configuration n’est disponible concernant la conversion.',
	'CONV_ERROR_FORUM_ACCESS'			=> 'Impossible d’obtenir les informations d’accès au forum.',
	'CONV_ERROR_GET_CATEGORIES'			=> 'Impossible d’obtenir les catégories.',
	'CONV_ERROR_GET_CONFIG'				=> 'Impossible de récupérer la configuration de votre forum.',
	'CONV_ERROR_COULD_NOT_READ'			=> 'Impossible d’accéder et de consulter « %s ».',
	'CONV_ERROR_GROUP_ACCESS'			=> 'Impossible d’obtenir les informations d’authentification du groupe.',
	'CONV_ERROR_INCONSISTENT_GROUPS'	=> 'Une contradiction a été détectée dans la table des groupes add_bots(). Si vous souhaitez la corriger manuellement, n’oubliez pas d’ajouter tous les groupes spéciaux.',
	'CONV_ERROR_INSERT_BOT'				=> 'Impossible d’insérer le robot dans la table des utilisateurs.',
	'CONV_ERROR_INSERT_BOTGROUP'		=> 'Impossible d’insérer le robot dans la table des robots.',
	'CONV_ERROR_INSERT_USER_GROUP'		=> 'Impossible d’insérer l’utilisateur dans la table user_group.',
	'CONV_ERROR_MESSAGE_PARSER'			=> 'Une erreur est survenue lors de l’analyse du message',
	'CONV_ERROR_NO_AVATAR_PATH'			=> 'Note aux développeurs : vous devez spécifier $convertor[\'avatar_path\'] afin d’utiliser %s.',
	'CONV_ERROR_NO_FORUM_PATH'			=> 'Le chemin relatif vers le forum source n’a pas été spécifié.',
	'CONV_ERROR_NO_GALLERY_PATH'		=> 'Note aux développeurs : vous devez spécifier $convertor[\'avatar_gallery_path\'] afin d’utiliser %s.',
	'CONV_ERROR_NO_GROUP'				=> 'Le groupe « %1$s » est introuvable dans %2$s.',
	'CONV_ERROR_NO_RANKS_PATH'			=> 'Note aux développeurs : vous devez spécifier $convertor[\'ranks_path\'] afin d’utiliser %s.',
	'CONV_ERROR_NO_SMILIES_PATH'		=> 'Note aux développeurs : vous devez spécifier $convertor[\'smilies_path\'] afin d’utiliser %s.',
	'CONV_ERROR_NO_UPLOAD_DIR'			=> 'Note aux développeurs : vous devez spécifier $convertor[\'upload_path\'] afin d’utiliser %s.',
	'CONV_ERROR_PERM_SETTING'			=> 'Impossible d’insérer ou de mettre à jour le réglage de la permission.',
	'CONV_ERROR_PM_COUNT'				=> 'Impossible de sélectionner le compteur de dossiers des messages privés.',
	'CONV_ERROR_REPLACE_CATEGORY'		=> 'Impossible d’insérer le nouveau forum à la place de l’ancienne catégorie.',
	'CONV_ERROR_REPLACE_FORUM'			=> 'Impossible d’insérer le nouveau forum à la place de l’ancien forum.',
	'CONV_ERROR_USER_ACCESS'			=> 'Impossible d’obtenir les informations d’authentification sur l’utilisateur.',
	'CONV_ERROR_WRONG_GROUP'			=> 'Le groupe « %1$s » défini dans %2$s est incorrect.',
	'CONV_OPTIONS_BODY'					=> 'Cette page collecte les informations nécessaires à l’accès au forum source. Saisissez les informations sur la base de données de votre ancien forum ; le convertisseur ne modifiera rien dans la base de données que vous avez spécifiée ci-dessous. Il est recommandé de désactiver le forum source afin de garantir le bon fonctionnement de la conversion.',
	'CONV_SAVED_MESSAGES'				=> 'Messages sauvegardés',

	'COULD_NOT_COPY'			=> 'Impossible de copier le fichier <strong>%1$s</strong> vers <strong>%2$s</strong><br /><br />Veuillez vous assurer que le répertoire cible existe et qu’il puisse être écrit par le serveur internet.',
	'COULD_NOT_FIND_PATH'		=> 'Le chemin vers votre ancien forum est introuvable. Veuillez vérifier vos réglages, puis réessayer.<br />» %s était spécifié en tant que chemin source.',

	'DBMS'						=> 'Type de base de données',
	'DB_CONFIG'					=> 'Configuration de la base de données',
	'DB_CONNECTION'				=> 'Connexion à la base de données',
	'DB_ERR_INSERT'				=> 'Une erreur est survenue lors de l’exécution de la requête <code>INSERT</code>.',
	'DB_ERR_LAST'				=> 'Une erreur est survenue lors de l’exécution de <var>query_last</var>.',
	'DB_ERR_QUERY_FIRST'		=> 'Une erreur est survenue lors de l’exécution de <var>query_first</var>.',
	'DB_ERR_QUERY_FIRST_TABLE'	=> 'Une erreur est survenue lors de l’exécution de <var>query_first</var>, %s (« %s »).',
	'DB_ERR_SELECT'				=> 'Une erreur est survenue lors de l’exécution de la requête <code>SELECT</code>.',
	'DB_HOST'					=> 'Nom d’hôte du serveur de la base de données ou DSN',
	'DB_HOST_EXPLAIN'			=> 'Le DSN n’est approprié que pour les installations de type ODBC. Sur PostgreSQL, utilisez localhost afin de vous connecter sur le serveur local par l’intermédiaire du connecteur du domaine UNIX, et utilisez 127.0.0.1 afin de vous connecter par l’intermédiaire du TCP. Sur SQLite, saisissez le chemin complet vers votre fichier de base de données.',
	'DB_NAME'					=> 'Nom de la base de données',
	'DB_PASSWORD'				=> 'Mot de passe de la base de données',
	'DB_PORT'					=> 'Port du serveur de la base de données',
	'DB_PORT_EXPLAIN'			=> 'Laissez cette option vide sauf si le serveur utilise un port différent et que vous en avez connaissance.',
	'DB_UPDATE_NOT_SUPPORTED'	=> 'Ce script ne prend pas en charge la mise à jour des versions antérieures à la « %1$s ». La version actuellement installée est la « %2$s ». Veuillez mettre à jour phpBB vers une version antérieure avant d’exécuter ce script. Si vous rencontrez des difficultés lors de la mise à jour, n’hésitez pas à demander de l’aide sur les forums de support de phpBB.com ou de phpBB.fr.',
	'DB_USERNAME'				=> 'Nom de l’utilisateur de la base de données',
	'DB_TEST'					=> 'Test de connexion',
	'DEFAULT_LANG'				=> 'Langue du forum par défaut',
	'DEFAULT_PREFIX_IS'			=> 'Le convertisseur n’a pu trouver aucune table contenant le préfixe que vous avez spécifié. Veuillez vous assurer d’avoir correctement saisi toutes les informations relatives au forum que vous souhaitez convertir. Le préfixe de table par défaut concernant %1$s est <strong>%2$s</strong>.',
	'DEV_NO_TEST_FILE'			=> 'Aucune valeur n’a été spécifiée dans le convertisseur concernant la variable test_file. Si vous êtes un utilisateur de ce convertisseur, veuillez rapporter ce message à l’auteur du convertisseur car vous ne devriez pas avoir cette erreur. Si vous êtes l’auteur du convertisseur, vous devez saisir le nom du fichier qui existe dans le forum source afin de permettre le bon fonctionnement de la vérification du chemin.',
	'DIRECTORIES_AND_FILES'		=> 'Installation des répertoires et des fichiers',
	'DISABLE_KEYS'				=> 'Désactivation des clés',
	'DLL_FIREBIRD'				=> 'Firebird',
	'DLL_FTP'					=> 'Support FTP à distance [ Installation ]',
	'DLL_GD'					=> 'Support graphique GD [ Confirmation visuelle ]',
	'DLL_MBSTRING'				=> 'Support des caractères multi-octets',
	'DLL_MSSQL'					=> 'MSSQL Server 2000+',
	'DLL_MSSQL_ODBC'			=> 'MSSQL Server 2000+ via ODBC',
	'DLL_MSSQLNATIVE'			=> 'MSSQL Server 2005+ [ Natif ]',
	'DLL_MYSQL'					=> 'MySQL',
	'DLL_MYSQLI'				=> 'MySQL avec l’extension MySQLi',
	'DLL_ORACLE'				=> 'Oracle',
	'DLL_POSTGRES'				=> 'PostgreSQL',
	'DLL_SQLITE'				=> 'SQLite',
	'DLL_XML'					=> 'Support XML [ Jabber ]',
	'DLL_ZLIB'					=> 'Support de la compression zlib [ gz, .tar.gz, .zip ]',
	'DL_CONFIG'					=> 'Télécharger la configuration',
	'DL_CONFIG_EXPLAIN'			=> 'Vous pouvez directement télécharger le fichier config.php sur votre ordinateur. Vous devrez ensuite le transférer manuellement à la racine de votre répertoire phpBB 3.0 en écrasant le fichier déjà existant. N’oubliez pas de transférer le fichier dans le codage de caractères ASCII (consultez la documentation de votre application FTP si vous avez un doute sur la réalisation de cette opération). Une fois que le fichier de configuration a bien été transféré, veuillez cliquer sur « Réalisé » afin de continuer vers la prochaine étape.',
	'DL_DOWNLOAD'				=> 'Télécharger',
	'DONE'						=> 'Réalisé',

	'ENABLE_KEYS'				=> 'Réactivation des clés. Cette opération peut durer un certain temps.',

	'FILES_OPTIONAL'			=> 'Fichiers et répertoires facultatifs',
	'FILES_OPTIONAL_EXPLAIN'	=> '<strong>Facultatif</strong> - Ces fichiers, ces répertoires ou ces réglages de permissions ne sont pas obligatoires. Le système d’installation essaiera de les créer s’ils n’existent pas ou s’ils ne peuvent pas être écrits. Cependant, la présence de ces derniers accélérera l’installation.',
	'FILES_REQUIRED'			=> 'Fichiers et répertoires',
	'FILES_REQUIRED_EXPLAIN'	=> '<strong>Obligatoire</strong> - Pour fonctionner correctement, phpBB doit pouvoir accéder ou écrire sur certains fichiers et certains répertoires. Si « Introuvable » est affiché, vous devrez créer le fichier ou le répertoire approprié. Si « Écriture impossible » est affiché, vous devrez modifier les permissions du fichier ou du répertoire afin que phpBB puisse y écrire.',
	'FILLING_TABLE'				=> 'Remplissage de la table <strong>%s</strong>',
	'FILLING_TABLES'			=> 'Remplissage des tables',

	'FIREBIRD_DBMS_UPDATE_REQUIRED'		=> 'phpBB ne prend plus en charge les versions de Firebird/Interbase antérieures à la version 2.1. Veuillez mettre à jour votre installation de Firebird vers une version égale ou supérieure à la 2.1.0 avant de procéder à la mise à jour.',

	'FINAL_STEP'				=> 'Procéder à l’étape finale',
	'FORUM_ADDRESS'				=> 'Adresse du forum',
	'FORUM_ADDRESS_EXPLAIN'		=> 'Ceci est l’ancienne adresse de votre forum, telle que <samp>http://www.exemple.com/phpBB2/</samp>. Si vous remplissez ce champ, tous les liens pointant vers l’ancienne adresse de votre forum insérés dans vos messages, vos messages privés et vos signatures seront mis à jour avec la nouvelle adresse de votre forum.',
	'FORUM_PATH'				=> 'Chemin du forum',
	'FORUM_PATH_EXPLAIN'		=> 'Ceci est le chemin <strong>relatif</strong> sur le disque du serveur vers votre ancien forum depuis la <strong>racine de cette installation de phpBB3</strong>.',
	'FOUND'						=> 'Trouvé',
	'FTP_CONFIG'				=> 'Transférer la configuration par FTP',
	'FTP_CONFIG_EXPLAIN'		=> 'phpBB a détecté la présence du module FTP sur ce serveur. Si vous le souhaitez, vous pouvez essayer d’installer votre fichier config.php par l’intermédiaire de ce module. Vous devrez spécifier les informations listées ci-dessous. N’oubliez pas que votre nom d’utilisateur et votre mot de passe sont ceux de votre serveur (demandez-les à votre hébergeur si vous n’êtes pas certain(e) de les avoir à disposition) !',
	'FTP_PATH'					=> 'Chemin FTP',
	'FTP_PATH_EXPLAIN'			=> 'Ceci est le chemin depuis la racine de votre répertoire phpBB, tel que <samp>htdocs/phpBB3/</samp>.',
	'FTP_UPLOAD'				=> 'Transférer',

	'GPL'						=> 'Licence Publique Générale',

	'INITIAL_CONFIG'			=> 'Configuration basique',
	'INITIAL_CONFIG_EXPLAIN'	=> 'Maintenant que l’installation a déterminé que votre serveur peut correctement faire fonctionner phpBB, vous devez spécifier certaines informations spécifiques. Si vous ne savez pas comment vous connecter à votre base de données, contactez en premier lieu votre hébergeur ou utilisez les forums de support de phpBB. Lorsque vous saisissez des données, assurez-vous de les vérifier intégralement avant de continuer.',
	'INSTALL_CONGRATS'			=> 'Félicitations !',
	'INSTALL_CONGRATS_EXPLAIN'	=> '
		Vous avez correctement installé phpBB %1$s. Veuillez continuer en sélectionnant une des options suivantes :</p>
		<h2>Convertir un forum existant vers phpBB3</h2>
		<p>L’outil de conversion de phpBB permet de convertir phpBB 2.0.x, ou d’autres systèmes de forums, vers phpBB3. Si vous avez à disposition un forum existant et que vous souhaitez le convertir, veuillez <a href="%2$s">continuer en sélectionnant un convertisseur</a>.</p>
		<h2>Utiliser votre forum en ligne !</h2>
		<p>En cliquant sur le bouton ci-dessous, vous accéderez à un formulaire vous proposant d’envoyer des données statistiques à phpBB depuis votre panneau de contrôle d’administration (PCA). Nous vous serions reconnaissants de prendre le temps de nous aider en envoyant ces informations. Par la suite, vous pourrez prendre le temps de consulter toutes les options qui vous sont disponibles. N’oubliez pas que de l’aide en ligne est disponible par l’intermédiaire de la <a href="https://www.phpbb.com/support/documentation/3.0/">documentation</a>, du fichier <a href="%3$s">README</a>, des <a href="https://www.phpbb.com/community/viewforum.php?f=46">forums de support officiels</a> et du <a href="http://forum.phpbb.fr/">forum de support francophone</a>.</p><p><strong>Veuillez supprimer, déplacer ou renommer le répertoire d’installation avant d’utiliser votre forum. Tant que ce répertoire est présent, vous n’aurez accès qu’au panneau de contrôle d’administration (PCA).</strong>',
	'INSTALL_INTRO'				=> 'Bienvenue à l’installation',

	'INSTALL_INTRO_BODY'		=> 'Grâce à cette option, il est possible d’installer phpBB3 sur votre serveur.</p><p>Avant de continuer, vous allez avoir besoin de vous munir des réglages de votre base de données. Si vous ne les connaissez pas, veuillez les demander à votre hébergeur car vous ne pourrez pas continuer sans ces informations. Vous avez besoin du :</p>

	<ul>
		<li>Type de base de données - la base de données que vous allez utiliser.</li>
		<li>Nom d’hôte du serveur de la base de données ou DSN - l’adresse du serveur de la base de données.</li>
		<li>Port du serveur de la base de données - comme son nom l’indique (dans la plupart des cas, il n’est pas obligatoire).</li>
		<li>Nom de la base de données - le nom de la base de données sur le serveur.</li>
		<li>Nom d’utilisateur et mot de passe de la base de données - les informations de connexion afin d’accéder à la base de données.</li>
	</ul>

	<p><strong>Note :</strong> si vous procédez à une installation en utilisant SQLite, vous devrez saisir le chemin complet de votre fichier de base de données dans le champ DSN et laisser les champs du nom d’utilisateur et du mot de passe vides. Pour des raisons de sécurité, vous devriez vous assurer que le fichier de base de données ne soit pas stocké dans un endroit accessible en ligne.</p>

	<p>phpBB3 supporte les bases de données suivantes :</p>
	<ul>
		<li>MySQL 3.23 ou supérieur (MySQLi supporté)</li>
		<li>PostgreSQL 7.3+</li>
		<li>SQLite 2.8.2+</li>
		<li>Firebird 2.1+</li>
		<li>MS SQL Server 2000 ou supérieur (directement ou via ODBC)</li>
		<li>MS SQL Server 2005 ou supérieur (en natif)</li>
		<li>Oracle</li>
	</ul>

	<p>Seules les bases de données qui sont supportées sur votre serveur seront affichées.',
	'INSTALL_INTRO_NEXT'		=> 'Pour commencer l’installation, veuillez cliquer sur le bouton ci-dessous.',
	'INSTALL_LOGIN'				=> 'Connexion',
	'INSTALL_NEXT'				=> 'Étape suivante',
	'INSTALL_NEXT_FAIL'			=> 'Certains des tests ont échoués et vous devriez corriger ces problèmes avant de continuer vers l’étape suivante. Si vous ne le faites pas, votre installation pourrait s’avérer incomplète.',
	'INSTALL_NEXT_PASS'			=> 'Tous les tests basiques ont été effectués et vous pouvez à présent continuer vers l’étape suivante de l’installation. Dans le cas où vous avez modifié certains modules ou certaines permissions, sachez que vous pouvez de nouveau tester votre installation.',
	'INSTALL_PANEL'				=> 'Panneau d’installation',
	'INSTALL_SEND_CONFIG'		=> 'Malheureusement, les informations de configuration n’ont pas pu être écrites par phpBB dans votre fichier config.php. Il est possible que ce fichier n’existe pas ou qu’il ne soit pas inscriptible. Vous trouverez ci-dessous une liste d’options vous permettant d’effectuer correctement l’installation de ce fichier.',
	'INSTALL_START'				=> 'Commencer l’installation',
	'INSTALL_TEST'				=> 'Tester de nouveau',
	'INST_ERR'					=> 'Erreur d’installation',
	'INST_ERR_DB_CONNECT'		=> 'Impossible de se connecter à la base de données. Veuillez consulter le message d’erreur ci-dessous.',
	'INST_ERR_DB_FORUM_PATH'	=> 'Le fichier de la base de données est situé dans le répertoire racine de votre forum. Vous devriez déplacer ce fichier dans un environnement hors-ligne.',
	'INST_ERR_DB_INVALID_PREFIX'=> 'Le préfixe que vous avez spécifié est incorrect. Ce dernier doit commencer par une lettre et ne doit contenir que des lettres, des chiffres et des tirets bas.',
	'INST_ERR_DB_NO_ERROR'		=> 'Aucun message d’erreur.',
	'INST_ERR_DB_NO_MYSQLI'		=> 'La version de MySQL qui est installée sur votre serveur est incompatible avec l’option « MySQL avec l’extension MySQLi » que vous avez sélectionnée. Veuillez plutôt essayer de sélectionner l’option « MySQL ».',
	'INST_ERR_DB_NO_SQLITE'		=> 'La version de l’extension SQLite qui est installée sur votre serveur est obsolète, elle doit être mise à jour vers la version 2.8.2 ou supérieure.',
	'INST_ERR_DB_NO_ORACLE'		=> 'La version d’Oracle qui est installée sur votre serveur nécessite le réglage du paramètre <var>NLS_CHARACTERSET</var> sur <var>UTF8</var>. Veuillez mettre à jour votre version vers la 9.2+ ou modifier ce paramètre.',
	'INST_ERR_DB_NO_FIREBIRD'	=> 'La version de Firebird qui est installée sur votre serveur semble obsolète, elle doit être mise à jour vers la version 2.1 ou supérieure.',
	'INST_ERR_DB_NO_FIREBIRD_PS'=> 'La base de données que vous avez sélectionnée pour Firebird a une taille de pages inférieure à 8192. Veuillez augmenter cette taille.',
	'INST_ERR_DB_NO_POSTGRES'	=> 'La base de données que vous avez sélectionnée n’est pas encodée en <var>UNICODE</var> ou en <var>UTF8</var>. Veuillez sélectionner une base de données supportant un de ces encodages.',
	'INST_ERR_DB_NO_NAME'		=> 'Vous n’avez pas spécifié le nom de la base de données.',
	'INST_ERR_EMAIL_INVALID'	=> 'L’adresse de courrier électronique que vous avez saisie est incorrecte.',
	'INST_ERR_EMAIL_MISMATCH'	=> 'Les adresses de courrier électronique que vous avez saisies ne concordent pas.',
	'INST_ERR_FATAL'			=> 'Erreur fatale d’installation',
	'INST_ERR_FATAL_DB'			=> 'Une erreur fatale et irrécupérable est survenue dans la base de données. Il est possible que l’utilisateur spécifié ne détienne pas les permissions appropriées afin d’exécuter les requêtes <code>CREATE TABLES</code>, <code>INSERT</code>, etc. Veuillez contacter en premier lieu votre hébergeur ou demander de l’aide sur les forums de support.',
	'INST_ERR_FTP_PATH'			=> 'Impossible de modifier le répertoire que vous avez spécifié. Veuillez vérifier le chemin.',
	'INST_ERR_FTP_LOGIN'		=> 'Impossible de se connecter au serveur FTP. Veuillez vérifier votre nom d’utilisateur et votre mot de passe.',
	'INST_ERR_MISSING_DATA'		=> 'Vous devez remplir tous les champs de ce bloc.',
	'INST_ERR_NO_DB'			=> 'Impossible de charger le module PHP concernant le type de base de données que vous avez sélectionné.',
	'INST_ERR_PASSWORD_MISMATCH'	=> 'Les mots de passe que vous avez saisis ne concordent pas.',
	'INST_ERR_PASSWORD_TOO_LONG'	=> 'Le mot de passe que vous avez saisi est trop long. Vous ne pouvez saisir que 30 caractères au maximum.',
	'INST_ERR_PASSWORD_TOO_SHORT'	=> 'Le mot de passe que vous avez saisi est trop court. Vous devez saisir au moins 6 caractères.',
	'INST_ERR_PREFIX'			=> 'Le préfixe que vous avez spécifié est déjà utilisé dans ces tables. Veuillez en choisir un autre.',
	'INST_ERR_PREFIX_INVALID'	=> 'Le préfixe que vous avez saisi concernant votre base de données est incorrect. Veuillez en choisir un autre en supprimant les caractères spéciaux comme le tiret.',
	'INST_ERR_PREFIX_TOO_LONG'	=> 'Le préfixe de table que vous avez saisi est trop long. Vous ne pouvez saisir que %d caractères au maximum.',
	'INST_ERR_USER_TOO_LONG'	=> 'Le nom d’utilisateur que vous avez saisi est trop long. Vous ne pouvez saisir que 20 caractères au maximum.',
	'INST_ERR_USER_TOO_SHORT'	=> 'Le nom d’utilisateur que vous avez saisi est trop court. Vous devez saisir au moins 3 caractères.',
	'INVALID_PRIMARY_KEY'		=> 'Clé primaire incorrecte : %s',

	'LONG_SCRIPT_EXECUTION'		=> 'Ceci peut prendre un certain temps… Veuillez ne pas interrompre le script.',

	// mbstring
	'MBSTRING_CHECK'						=> 'Vérification de l’extension <samp>mbstring</samp>',
	'MBSTRING_CHECK_EXPLAIN'				=> '<strong>Obligatoire</strong> - <samp>mbstring</samp> est une extension PHP qui fournit des fonctions permettant l’encodage de caractères multi-octets. Certaines fonctionnalités de mbstring ne sont pas compatibles avec phpBB et doivent donc être désactivées.',
	'MBSTRING_FUNC_OVERLOAD'				=> 'Fonction de surcharge',
	'MBSTRING_FUNC_OVERLOAD_EXPLAIN'		=> '<var>mbstring.func_overload</var> doit être réglé sur 0 ou sur 4.',
	'MBSTRING_ENCODING_TRANSLATION'			=> 'Encodage des caractères invisibles',
	'MBSTRING_ENCODING_TRANSLATION_EXPLAIN'	=> '<var>mbstring.encoding_translation</var> doit être réglé sur 0.',
	'MBSTRING_HTTP_INPUT'					=> 'Conversion des caractères d’entrée HTTP',
	'MBSTRING_HTTP_INPUT_EXPLAIN'			=> '<var>mbstring.http_input</var> doit être réglé sur <samp>pass</samp>.',
	'MBSTRING_HTTP_OUTPUT'					=> 'Conversion des caractères de sortie HTTP',
	'MBSTRING_HTTP_OUTPUT_EXPLAIN'			=> '<var>mbstring.http_output</var> doit être réglé sur <samp>pass</samp>.',

	'MAKE_FOLDER_WRITABLE'		=> 'Veuillez vous assurer que ce répertoire existe et qu’il puisse être écrit par le serveur internet, puis réessayez :<br />»<strong>%s</strong>.',
	'MAKE_FOLDERS_WRITABLE'		=> 'Veuillez vous assurer que ces répertoires existent et qu’ils puissent être écrits par le serveur internet, puis réessayez :<br />»<strong>%s</strong>.',

	'MYSQL_SCHEMA_UPDATE_REQUIRED'	=> 'Le schéma de votre base de données MySQL est obsolète. phpBB a détecté un schéma pour MySQL 3.x/4.x, mais le serveur fonctionne avec MySQL %2$s.<br /><strong>Vous devez mettre à jour le schéma avant de procéder à la mise à jour.</strong><br /><br />Veuillez consulter l’<a href="https://www.phpbb.com/kb/article/doesnt-have-a-default-value-errors/">article de la base de connaissances à propos de la mise à jour du schéma MySQL</a>. Si vous rencontrez des difficultés lors de la mise à jour, veuillez demander de l’aide sur <a href="https://www.phpbb.com/community/viewforum.php?f=46">les forums de support officiels</a> ou sur <a href="http://forum.phpbb.fr/">le forum de support francophone</a>.',

	'NAMING_CONFLICT'			=> 'Conflit d’appellation : %s et %s sont tous les deux des alias<br /><br />%s',
	'NEXT_STEP'					=> 'Aller à l’étape suivante',
	'NOT_FOUND'					=> 'Introuvable',
	'NOT_UNDERSTAND'			=> 'Impossible d’interpréter %s #%d, table %s (« %s »)',
	'NO_CONVERTORS'				=> 'Aucun convertisseur n’est disponible.',
	'NO_CONVERT_SPECIFIED'		=> 'Aucun convertisseur n’a été spécifié.',
	'NO_LOCATION'				=> 'Emplacement introuvable. Si Imagemagick est installé, vous pourrez spécifier ultérieurement son emplacement depuis le panneau de contrôle d’administration.',
	'NO_TABLES_FOUND'			=> 'Aucune table n’a été trouvée.',

	'OVERVIEW_BODY'				=> 'Bienvenue sur phpBB3 !<br /><br />phpBB® est la solution de logiciel de forums libre et gratuite la plus utilisée dans le monde. phpBB3 est le fruit d’un long travail qui a débuté en l’an 2000. Tout comme ses prédécesseurs, phpBB3 est riche en fonctionnalités, facile d’accès et entièrement supporté par le phpBB Group. phpBB3 améliore considérablement ce qui a rendu phpBB2 populaire et ajoute des fonctionnalités populaires qui n’étaient pas présentes dans les précédentes versions. Nous espérons avoir répondu convenablement à vos attentes.<br /><br />Ce système d’installation vous guidera dans l’installation de phpBB3, dans la mise à jour des versions obsolètes vers la dernière version et bien évidemment dans la conversion de divers logiciels de forums (dont phpBB2) vers phpBB3. Pour plus d’informations, nous vous encourageons à consulter <a href="../docs/INSTALL.html">le guide d’installation</a>.<br /><br />Pour consulter la licence de phpBB3 ou en savoir plus sur l’obtention de support ainsi que notre position envers cela, veuillez sélectionner les options appropriées situées sur le menu latéral. Pour continuer, veuillez sélectionner l’onglet approprié situé ci-dessus.',

	'PCRE_UTF_SUPPORT'				=> 'Support UTF-8 PCRE',
	'PCRE_UTF_SUPPORT_EXPLAIN'		=> 'phpBB ne fonctionnera <strong>pas</strong> si votre installation PHP n’est pas compilée avec le support de l’UTF-8 dans l’extension PCRE.',
	'PHP_GETIMAGESIZE_SUPPORT'			=> 'La fonction PHP getimagesize() est disponible',
	'PHP_GETIMAGESIZE_SUPPORT_EXPLAIN'	=> '<strong>Obligatoire</strong> - pour que phpBB puisse fonctionner correctement, la fonction getimagesize doit être disponible.',
	'PHP_OPTIONAL_MODULE'			=> 'Modules facultatifs',
	'PHP_OPTIONAL_MODULE_EXPLAIN'	=> '<strong>Facultatif</strong> - ces modules ou applications sont facultatifs. Cependant, ils permettront d’activer des fonctionnalités supplémentaires s’ils sont disponibles.',
	'PHP_SUPPORTED_DB'				=> 'Bases de données supportées',
	'PHP_SUPPORTED_DB_EXPLAIN'		=> '<strong>Obligatoire</strong> - vous devez supporter au moins une base de données compatible avec PHP. Si aucun module de base de données n’est disponible, vous devriez vous renseigner en contactant votre hébergeur ou en consultant la documentation appropriée sur votre installation PHP.',
	'PHP_REGISTER_GLOBALS'			=> 'Le réglage PHP <var>register_globals</var> est désactivé',
	'PHP_REGISTER_GLOBALS_EXPLAIN'	=> 'phpBB fonctionnera même si ce réglage est activé mais il est recommandé de désactiver register_globals de votre installation PHP pour des raisons de sécurité.',
	'PHP_SAFE_MODE'					=> 'Mode sécurisé',
	'PHP_SETTINGS'					=> 'Réglages et version de PHP',
	'PHP_SETTINGS_EXPLAIN'			=> '<strong>Obligatoire</strong> - vous devez utiliser la version 4.3.3 ou supérieure de PHP afin de pouvoir installer phpBB. Si le <var>mode sécurisé</var> est affiché ci-dessous, cela signifie que votre installation PHP fonctionne sous ce mode. Cela imposera des limitations à l’administration à distance et à des fonctionnalités similaires.',
	'PHP_URL_FOPEN_SUPPORT'			=> 'Le réglage PHP <var>allow_url_fopen</var> est activé',
	'PHP_URL_FOPEN_SUPPORT_EXPLAIN'	=> '<strong>Facultatif</strong> - ce réglage est facultatif mais la fonctionnalité vous permettant d’insérer des avatars à partir de sites externes ne fonctionnera pas correctement sans celui-ci.',
	'PHP_VERSION_REQD'				=> 'Version de PHP >= 4.3.3',
	'POST_ID'						=> 'Identification du message',
	'PREFIX_FOUND'					=> 'Une vérification de vos tables a détecté une installation correcte utilisant <strong>%s</strong> comme préfixe de table.',
	'PREPROCESS_STEP'				=> 'Exécution des fonctions et des requêtes de pré-traitement',
	'PRE_CONVERT_COMPLETE'			=> 'Toutes les étapes de pré-conversion ont été achevées. Vous pouvez à présent commencer la procédure de conversion actuelle. Veuillez noter que vous devez le faire manuellement et ajuster plusieurs choses. Après la conversion, vérifiez tout particulièrement les permissions assignées, restructurez votre index de recherche s’il n’est pas converti et assurez-vous que les fichiers obtenus, comme les avatars et les émoticônes, ont été copiés correctement.',
	'PROCESS_LAST'					=> 'Traitement des dernières étapes',

	'REFRESH_PAGE'				=> 'Rafraîchir la page afin de continuer la conversion',
	'REFRESH_PAGE_EXPLAIN'		=> 'Si cette option est activée, le convertisseur rafraîchira la page afin de poursuivre la conversion après avoir terminé une étape. S’il s’agit de votre première conversion et que vous souhaitez effectuer des tests afin de détecter des erreurs à l’avance, nous vous suggérons de désactiver cette option.',
	'REQUIREMENTS_TITLE'		=> 'Compatibilité de l’installation',
	'REQUIREMENTS_EXPLAIN'		=> 'Avant de procéder à une installation complète, un ensemble de vérifications de la configuration et des fichiers de votre serveur va être effectué afin de s’assurer que vous pouvez installer et utiliser correctement phpBB. Veuillez vous assurer de consulter attentivement les résultats et de ne pas continuer tant que toutes les vérifications nécessaires ne soient pas terminées. Si vous souhaitez utiliser des fonctionnalités liées à des vérifications facultatives, vous devez également vous assurer que les vérifications en cours soient terminées.',
	'RETRY_WRITE'				=> 'Réessayer d’écrire la configuration',
	'RETRY_WRITE_EXPLAIN'		=> 'Si vous le souhaitez, vous pouvez modifier les permissions du fichier de configuration afin qu’il puisse être écrit par phpBB. Après cela, cliquez sur le bouton « Réessayer » ci-dessous. Pour des raisons de sécurité, vous devriez réinitialiser les permissions du fichier de configuration une fois l’installation de phpBB terminée.',

	'SCRIPT_PATH'				=> 'Chemin du script',
	'SCRIPT_PATH_EXPLAIN'		=> 'Le chemin où phpBB est situé par rapport au nom de domaine, tel que <samp>/phpBB3</samp>.',
	'SELECT_LANG'				=> 'Sélectionner une langue ',
	'SERVER_CONFIG'				=> 'Configuration du serveur',
	'SEARCH_INDEX_UNCONVERTED'	=> 'L’index de recherche n’a pas été converti',
	'SEARCH_INDEX_UNCONVERTED_EXPLAIN'	=> 'Votre ancien index de recherche n’a pas été converti. La recherche retournera systématiquement un résultat vide. Pour créer un nouvel index de recherche, rendez-vous sur le panneau de contrôle d’administration, cliquez sur « Maintenance », puis sélectionnez l’index de recherche à partir du sous-menu.',
	'SOFTWARE'					=> 'Logiciel de forum',
	'SPECIFY_OPTIONS'			=> 'Spécifier les options de conversion',
	'STAGE_ADMINISTRATOR'		=> 'Informations sur l’administrateur',
	'STAGE_ADVANCED'			=> 'Réglages avancés',
	'STAGE_ADVANCED_EXPLAIN'	=> 'Les réglages de cette page ne sont nécessaires que s’ils diffèrent des réglages par défaut. Si vous avez un doute, continuez vers l’étape suivante sans modifier ces réglages. Vous pourrez toujours les modifier ultérieurement depuis le panneau de contrôle d’administration.',
	'STAGE_CONFIG_FILE'			=> 'Fichier de configuration',
	'STAGE_CREATE_TABLE'		=> 'Créer les tables de la base de données',
	'STAGE_CREATE_TABLE_EXPLAIN'	=> 'Les tables de la base de données utilisées par phpBB 3.0 ont été créées et remplies avec quelques données initiales. Rendez-vous sur la page suivante afin de terminer l’installation de phpBB.',
	'STAGE_DATABASE'			=> 'Réglages de la base de données',
	'STAGE_FINAL'				=> 'Étape finale',
	'STAGE_INTRO'				=> 'Introduction',
	'STAGE_IN_PROGRESS'			=> 'Conversion en cours',
	'STAGE_REQUIREMENTS'		=> 'Prérequis',
	'STAGE_SETTINGS'			=> 'Réglages',
	'STARTING_CONVERT'			=> 'Démarrage du processus de conversion',
	'STEP_PERCENT_COMPLETED'	=> 'Étape <strong>%d</strong> sur <strong>%d</strong>',
	'SUB_INTRO'					=> 'Introduction',
	'SUB_LICENSE'				=> 'Licence',
	'SUB_SUPPORT'				=> 'Support',
	'SUCCESSFUL_CONNECT'		=> 'Connecté',
	'SUPPORT_BODY'				=> 'Un support complet et gratuit vous est offert pour la dernière version stable de phpBB3. Cela comprend :</p><ul><li>l’installation</li><li>la configuration</li><li>les questions d’ordre technique</li><li>les problèmes en relation avec des bogues potentiels dans le logiciel</li><li>la mise à jour d’une des versions Release Candidate (RC) vers la dernière version stable</li><li>la conversion de phpBB 2.0.x vers phpBB3</li><li>la conversion d’un des nombreux logiciels de forums de discussions vers phpBB3 (veuillez consulter le <a href="https://www.phpbb.com/community/viewforum.php?f=65">forum relatif aux convertisseurs</a>)</li></ul><p>Nous continuons à encourager les utilisateurs utilisant une des versions bêta de phpBB3 à remplacer celle-ci par une installation propre de la dernière version stable.</p><h2>MODs / Styles</h2><p>En ce qui concerne les problèmes relatifs aux MODs, veuillez publier vos demandes de support dans le <a href="https://www.phpbb.com/community/viewforum.php?f=81">forum relatif aux modifications</a>.<br />En ce qui concerne les problèmes relatifs aux styles, aux templates et aux ensembles d’images, veuillez publier vos demandes de support dans le <a href="https://www.phpbb.com/community/viewforum.php?f=80">forum relatif aux styles</a>.<br /><br />Si votre question est portée sur une archive spécifique, veuillez publier directement votre message dans le sujet dédié à cette archive.</p><h2>Obtention du support</h2><p><a href="https://www.phpbb.com/community/viewtopic.php?f=14&amp;t=571070">L’archive de bienvenue de phpBB</a><br /><a href="https://www.phpbb.com/support/">La section relative au support</a><br /><a href="https://www.phpbb.com/support/documentation/3.0/quickstart/">Le guide de démarrage rapide</a><br /><br />Si vous souhaitez vous assurer d’être tenu au courant des dernières nouveautés et des dernières sorties de nos logiciels, pourquoi ne pas <a href="https://www.phpbb.com/support/">vous inscrire à notre liste de diffusion</a> ?<br /><br />',
	'SYNC_FORUMS'				=> 'Démarrage de la synchronisation des forums',
	'SYNC_POST_COUNT'			=> 'Synchronisation de post_counts',
	'SYNC_POST_COUNT_ID'		=> 'Synchronisation de post_counts à partir de <var>entry</var> : %1$s sur %2$s.',
	'SYNC_TOPICS'				=> 'Démarrage de la synchronisation des sujets',
	'SYNC_TOPIC_ID'				=> 'Synchronisation des sujets à partir de <var>topic_id</var> : %1$s sur %2$s.',

	'TABLES_MISSING'			=> 'Ces tables sont introuvables<br />» <strong>%s</strong>.',
	'TABLE_PREFIX'				=> 'Préfixe des tables de la base de données',
	'TABLE_PREFIX_EXPLAIN'		=> 'Le préfixe doit commencer par une lettre et ne doit contenir que des lettres, des chiffres et des tirets bas.',
	'TABLE_PREFIX_SAME'			=> 'Le préfixe des tables doit être le même que celui que vous avez utilisé dans le logiciel que vous avez converti.<br />» Le préfixe des tables qui avait été spécifié était %s.',
	'TESTS_PASSED'				=> 'Tests réussis',
	'TESTS_FAILED'				=> 'Tests échoués',

	'UNABLE_WRITE_LOCK'			=> 'Impossible d’écrire sur un fichier verrouillé.',
	'UNAVAILABLE'				=> 'Indisponible',
	'UNWRITABLE'				=> 'Écriture impossible',
	'UPDATE_TOPICS_POSTED'		=> 'Production de l’information concernant les sujets publiés',
	'UPDATE_TOPICS_POSTED_ERR'	=> 'Une erreur est survenue lors de la production de l’information concernant les sujets publiés. Une fois la procédure de conversion terminée, vous pourrez recommencer cette étape depuis le panneau de contrôle d’administration.',
	'VERIFY_OPTIONS'			=> 'Vérification des options de conversion',
	'VERSION'					=> 'Version',

	'WELCOME_INSTALL'			=> 'Bienvenue à l’installation de phpBB3',
	'WRITABLE'					=> 'Écriture possible',
));

// Updater
$lang = array_merge($lang, array(
	'ALL_FILES_UP_TO_DATE'		=> 'Tous les fichiers sont à jour avec la dernière version de phpBB. Vous devriez à présent <a href="../ucp.php?mode=login">vous connecter à votre forum</a> et vérifier que tout fonctionne correctement. N’oubliez pas de supprimer, de renommer ou de déplacer votre répertoire d’installation ! Pensez à nous envoyer les informations de votre serveur et la configuration de votre forum à partir du module <a href="../ucp.php?mode=login&amp;redirect=adm/index.php%3Fi=send_statistics%26mode=send_statistics">Envoyer les statistiques</a> disponible depuis votre panneau de contrôle d’administration.',
	'ARCHIVE_FILE'				=> 'Fichier source dans l’archive',

	'BACK'				=> 'Retour',
	'BINARY_FILE'		=> 'Fichier binaire',
	'BOT'				=> 'Robot',

	'CHANGE_CLEAN_NAMES'			=> 'La méthode que vous utilisez pour vous assurer que chaque nom d’utilisateur ne soit pas utilisé par plusieurs utilisateurs a été modifiée. Cependant, certains utilisateurs utilisent le même nom d’utilisateur en les comparant avec la nouvelle méthode. Avant de continuer, vous devez supprimer ou renommer ces utilisateurs afin de vous assurer que chaque nom d’utilisateur soit unique.',
	'CHECK_FILES'					=> 'Vérifier les fichiers',
	'CHECK_FILES_AGAIN'				=> 'Vérifier de nouveau les fichiers',
	'CHECK_FILES_EXPLAIN'			=> 'Dans la prochaine étape, tous les fichiers seront comparés aux fichiers de mise à jour. S’il s’agit de votre première comparaison de fichiers, cela risque de durer un certain temps.',
	'CHECK_FILES_UP_TO_DATE'		=> 'Selon votre base de données, votre version est à jour. Cependant, vous pouvez effectuer une vérification de tous vos fichiers afin de vous assurer qu’ils soient bien à jour avec la dernière version de phpBB.',
	'CHECK_UPDATE_DATABASE'			=> 'Continuer le processus de mise à jour',
	'COLLECTED_INFORMATION'			=> 'Informations sur les fichiers',
	'COLLECTED_INFORMATION_EXPLAIN'	=> 'La liste ci-dessous vous affiche les informations sur les fichiers qui nécessitent une mise à jour. Veuillez consulter attentivement toutes ces informations afin de mieux comprendre leur signification et de connaître tout ce dont vous avez besoin afin d’exécuter correctement la mise à jour.',
	'COLLECTING_FILE_DIFFS'			=> 'Collecte des différences des fichiers',
	'COMPLETE_LOGIN_TO_BOARD'		=> 'Vous devriez à présent <a href="../ucp.php?mode=login">vous connecter à votre forum</a> et vérifier que tout fonctionne correctement. N’oubliez pas de supprimer, de renommer ou de déplacer votre répertoire d’installation !',
	'CONTINUE_UPDATE_NOW'			=> 'Continuer le processus de mise à jour',		// Shown within the database update script at the end if called from the updater
	'CONTINUE_UPDATE'				=> 'Continuer la mise à jour',					// Shown after file upload to indicate the update process is not yet finished
	'CURRENT_FILE'					=> 'Début du conflit - code du fichier original avant la mise à jour',
	'CURRENT_VERSION'				=> 'Version actuelle',

	'DATABASE_TYPE'						=> 'Type de base de données',
	'DATABASE_UPDATE_INFO_OLD'			=> 'Le fichier de mise à jour de la base de données, situé dans le répertoire d’installation, est obsolète. Veuillez vous assurer d’avoir transféré la dernière version de ce fichier.',
	'DELETE_USER_REMOVE'				=> 'Supprimer l’utilisateur et effacer ses messages',
	'DELETE_USER_RETAIN'				=> 'Supprimer l’utilisateur mais conserver ses messages',
	'DESTINATION'						=> 'Fichier de destination',
	'DIFF_INLINE'						=> 'Dans la ligne',
	'DIFF_RAW'							=> 'Comparaison unifiée brute',
	'DIFF_SEP_EXPLAIN'					=> 'Bloc de code utilisé dans le nouveau fichier mis à jour',
	'DIFF_SIDE_BY_SIDE'					=> 'Côte à côte',
	'DIFF_UNIFIED'						=> 'Comparaison unifiée',
	'DO_NOT_UPDATE'						=> 'Ne pas mettre à jour ce fichier',
	'DONE'								=> 'Réalisé',
	'DOWNLOAD'							=> 'Télécharger ',
	'DOWNLOAD_AS'						=> 'Télécharger sous ',
	'DOWNLOAD_UPDATE_METHOD_BUTTON'		=> 'Télécharger l’archive des fichiers modifiés (recommandé)',
	'DOWNLOAD_CONFLICTS'				=> 'Télécharger les conflits de ce fichier',
	'DOWNLOAD_CONFLICTS_EXPLAIN'		=> 'Rechercher &lt;&lt;&lt; afin de détecter les conflits',
	'DOWNLOAD_UPDATE_METHOD'			=> 'Télécharger l’archive des fichiers modifiés',
	'DOWNLOAD_UPDATE_METHOD_EXPLAIN'	=> 'Après avoir téléchargé cette archive, vous devez la décompresser. Elle comporte les fichiers modifiés que vous devez transférer dans le répertoire racine de phpBB. Veuillez vous assurer de transférer ces fichiers dans leurs emplacements respectifs, puis de les vérifier à nouveau en cliquant sur le bouton situé ci-dessous.',

	'ERROR'			=> 'Erreur',
	'EDIT_USERNAME'	=> 'Éditer le nom d’utilisateur',

	'FILE_ALREADY_UP_TO_DATE'		=> 'Le fichier est déjà à jour.',
	'FILE_DIFF_NOT_ALLOWED'			=> 'Le fichier ne peut pas être comparé.',
	'FILE_USED'						=> 'Informations utilisées depuis ',			// Single file
	'FILES_CONFLICT'				=> 'Fichiers conflictuels',
	'FILES_CONFLICT_EXPLAIN'		=> 'Les fichiers suivants ont été modifiés par rapport aux fichiers originaux présents dans l’ancienne version. Ils ne pourront pas être fusionnés sans provoquer de conflits. Veuillez vérifier ces fichiers afin de détecter et résoudre manuellement les conflits ou continuez le processus de mise à jour en sélectionnant la méthode de fusion que vous souhaitez. Si vous résolvez les conflits manuellement, vérifiez de nouveau les fichiers une fois que les modifications ont été apportées. Vous pouvez également sélectionner pour chaque fichier la méthode de fusion qui vous semble la plus adaptée. La première méthode produira un fichier où les lignes conflictuelles présentes dans votre ancien fichier seront perdues. La seconde méthode ignorera toutes les modifications qui ont été apportées au nouveau fichier.',
	'FILES_MODIFIED'				=> 'Fichiers modifiés',
	'FILES_MODIFIED_EXPLAIN'		=> 'Les fichiers suivants ont été modifiés par rapport aux fichiers originaux présents dans l’ancienne version. Le fichier mis à jour correspondra à une fusion de vos modifications et du nouveau fichier.',
	'FILES_NEW'						=> 'Nouveaux fichiers',
	'FILES_NEW_EXPLAIN'				=> 'Les fichiers suivants n’existent pas dans votre installation actuelle. Ils seront ajoutés à votre installation.',
	'FILES_NEW_CONFLICT'			=> 'Nouveaux fichiers conflictuels',
	'FILES_NEW_CONFLICT_EXPLAIN'	=> 'Les fichiers suivants sont nouveaux dans la dernière version, mais certains fichiers du même nom, situés dans le même emplacement, existent déjà. Ils seront écrasés par les nouveaux fichiers.',
	'FILES_NOT_MODIFIED'			=> 'Fichiers inchangés',
	'FILES_NOT_MODIFIED_EXPLAIN'	=> 'Les fichiers suivants n’ont pas été modifiés par rapport aux fichiers originaux de la version que vous souhaitez mettre à jour.',
	'FILES_UP_TO_DATE'				=> 'Fichiers déjà à jour',
	'FILES_UP_TO_DATE_EXPLAIN'		=> 'Les fichiers suivants sont déjà à jour et ne nécessitent pas d’être mis à jour.',
	'FTP_SETTINGS'					=> 'Réglages FTP',
	'FTP_UPDATE_METHOD'				=> 'Transfert par FTP',

	'INCOMPATIBLE_UPDATE_FILES'		=> 'Les fichiers de mise à jour sont incompatibles avec la version qui est actuellement installée. La version actuellement installée est la %1$s alors que les fichiers de mise à jour sont destinés à la mise à jour de phpBB %2$s vers phpBB %3$s.',
	'INCOMPLETE_UPDATE_FILES'		=> 'Les fichiers de mise à jour sont incomplets.',
	'INLINE_UPDATE_SUCCESSFUL'		=> 'La base de données a été mise à jour. Vous devez à présent continuer le processus de mise à jour.',

	'KEEP_OLD_NAME'		=> 'Conserver le nom d’utilisateur',

	'LATEST_VERSION'		=> 'Dernière version',
	'LINE'					=> 'Ligne',
	'LINE_ADDED'			=> 'Ajoutée',
	'LINE_MODIFIED'			=> 'Modifiée',
	'LINE_REMOVED'			=> 'Supprimée',
	'LINE_UNMODIFIED'		=> 'Inchangée',
	'LOGIN_UPDATE_EXPLAIN'	=> 'Vous devez vous connecter afin de pouvoir mettre à jour votre installation.',

	'MAPPING_FILE_STRUCTURE'	=> 'Pour faciliter le transfert, les emplacements des différents fichiers ont été cartographiés par rapport à votre installation.',

	'MERGE_MODIFICATIONS_OPTION'	=> 'Fusionner les modifications',

	'MERGE_NO_MERGE_NEW_OPTION'	=> 'Ne pas fusionner - utiliser le nouveau fichier',
	'MERGE_NO_MERGE_MOD_OPTION'	=> 'Ne pas fusionner - utiliser le fichier actuellement installé',
	'MERGE_MOD_FILE_OPTION'		=> 'Fusionner les modifications (supprime le nouveau code de phpBB dans le bloc conflictuel)',
	'MERGE_NEW_FILE_OPTION'		=> 'Fusionner les modifications (supprime le code modifié dans le bloc conflictuel)',
	'MERGE_SELECT_ERROR'		=> 'Les modes de fusion du fichier conflictuel ne sont pas correctement sélectionnés.',
	'MERGING_FILES'				=> 'Fusion des différences',
	'MERGING_FILES_EXPLAIN'		=> 'Collecte actuellement les modifications finales des fichiers.<br /><br />Veuillez patienter jusqu’à la fin de toutes les opérations.',

	'NEW_FILE'						=> 'Fin du conflit',
	'NEW_USERNAME'					=> 'Nouveau nom d’utilisateur',
	'NO_AUTH_UPDATE'				=> 'Vous n’êtes pas autorisé(e) à effectuer une mise à jour',
	'NO_ERRORS'						=> 'Aucune erreur',
	'NO_UPDATE_FILES'				=> 'Ne pas mettre à jour les fichiers suivants',
	'NO_UPDATE_FILES_EXPLAIN'		=> 'Les fichiers suivants sont nouveaux ou ont été modifiés mais leur emplacement est introuvable dans votre installation. Si cette liste contient des fichiers vers des répertoires autres que language/ ou styles/, votre structure de répertoire et la mise à jour pourrait s’avérer incomplète.',
	'NO_UPDATE_FILES_OUTDATED'		=> 'Aucun répertoire de mise à jour correct n’a été trouvé, veuillez vous assurer d’avoir correctement transféré les fichiers nécessaires.<br /><br />Votre installation ne semble <strong>pas</strong> à jour. Des mises à jour sont disponibles pour votre version de phpBB %1$s, veuillez vous rendre sur <a href="https://www.phpbb.com/downloads/" rel="external">https://www.phpbb.com/downloads/</a> afin d’obtenir une archive de mise à jour de votre version %2$s vers la version %3$s.',
	'NO_UPDATE_FILES_UP_TO_DATE'	=> 'Votre version est à jour. Il n’est donc pas nécessaire d’utiliser l’outil de mise à jour. Si vous souhaitez effectuer une vérification intégrale de vos fichiers, veuillez vous assurer d’avoir correctement transféré tous les fichiers de mise à jour.',
	'NO_UPDATE_INFO'				=> 'Les informations sur le fichier de mise à jour sont introuvables.',
	'NO_UPDATES_REQUIRED'			=> 'Aucune mise à jour n’est nécessaire',
	'NO_VISIBLE_CHANGES'			=> 'Aucune modification visible',
	'NOTICE'						=> 'Avertissement',
	'NUM_CONFLICTS'					=> 'Nombre de conflits ',
	'NUMBER_OF_FILES_COLLECTED'		=> 'Actuellement, %1$d des %2$d fichiers vérifiés comportent des différences.<br />Veuillez patienter jusqu’à ce que tous les fichiers soient vérifiés.',

	'OLD_UPDATE_FILES'		=> 'Les fichiers de mise à jour sont obsolètes. Les fichiers de mise à jour présents correspondent à la mise à jour de phpBB %1$s vers phpBB %2$s alors que la dernière version de phpBB est la %3$s.',

	'PACKAGE_UPDATES_TO'				=> 'Mise à jour de l’archive actuelle vers la version',
	'PERFORM_DATABASE_UPDATE'			=> 'Exécuter la mise à jour de la base de données',
	'PERFORM_DATABASE_UPDATE_EXPLAIN'	=> 'Vous trouverez ci-dessous un bouton vers l’outil de mise à jour de la base de données. La mise à jour de la base de données peut prendre un certain temps, veillez à ne pas arrêter son exécution même lorsque celle-ci semble bloquée. Une fois que la mise à jour de la base de données ait été effectuée, suivez les instructions affichées à l’écran afin de continuer le processus de mise à jour.',
	'PREVIOUS_VERSION'					=> 'Version antérieure',
	'PROGRESS'							=> 'En cours',

	'RESULT'					=> 'Résultat',
	'RUN_DATABASE_SCRIPT'		=> 'Mettre à jour ma base de données maintenant',

	'SELECT_DIFF_MODE'			=> 'Sélectionner le mode de comparaison ',
	'SELECT_DOWNLOAD_FORMAT'	=> 'Sélectionner le format de l’archive que vous téléchargerez',
	'SELECT_FTP_SETTINGS'		=> 'Sélectionner les réglages FTP',
	'SHOW_DIFF_CONFLICT'		=> 'Afficher les différences et les conflits',
	'SHOW_DIFF_FINAL'			=> 'Afficher le fichier résultant',
	'SHOW_DIFF_MODIFIED'		=> 'Afficher les différences fusionnées',
	'SHOW_DIFF_NEW'				=> 'Afficher le contenu du fichier',
	'SHOW_DIFF_NEW_CONFLICT'	=> 'Afficher les différences',
	'SHOW_DIFF_NOT_MODIFIED'	=> 'Afficher les différences',
	'SOME_QUERIES_FAILED'		=> 'Certaines requêtes ont échouées, les erreurs et les instructions sont listées ci-dessous.',
	'SQL'						=> 'SQL',
	'SQL_FAILURE_EXPLAIN'		=> 'Il n’y a probablement pas lieu de s’inquiéter, il est probable que la mise à jour continue. Si ce n’est pas le cas, nous vous conseillons de demander de l’aide sur nos forums de support. Pour plus d’informations, veuillez consulter le fichier <a href="../docs/README.html">README</a>.',
	'STAGE_FILE_CHECK'			=> 'Vérifier les fichiers',
	'STAGE_UPDATE_DB'			=> 'Mettre à jour la base de données',
	'STAGE_UPDATE_FILES'		=> 'Mettre à jour les fichiers',
	'STAGE_VERSION_CHECK'		=> 'Vérifier la version',
	'STATUS_CONFLICT'			=> 'Fichier modifié produisant des conflits',
	'STATUS_MODIFIED'			=> 'Fichier modifié',
	'STATUS_NEW'				=> 'Nouveau fichier',
	'STATUS_NEW_CONFLICT'		=> 'Nouveau fichier conflictuel',
	'STATUS_NOT_MODIFIED'		=> 'Fichier inchangé',
	'STATUS_UP_TO_DATE'			=> 'Fichier déjà à jour',

	'TOGGLE_DISPLAY'			=> 'Afficher ou masquer la liste des fichiers',
	'TRY_DOWNLOAD_METHOD'		=> 'Vous devriez essayer la méthode de téléchargement des fichiers modifiés.<br />Cette méthode vous permettra de mettre à jour votre forum en toute sérénité.',
	'TRY_DOWNLOAD_METHOD_BUTTON'=> 'Essayer maintenant cette méthode',

	'UPDATE_COMPLETED'				=> 'Mise à jour correctement effectuée',
	'UPDATE_DATABASE'				=> 'Mettre à jour la base de données',
	'UPDATE_DATABASE_EXPLAIN'		=> 'Dans la prochaine étape, la base de données sera mise à jour.',
	'UPDATE_DATABASE_SCHEMA'		=> 'Mise à jour du schéma de la base de données',
	'UPDATE_FILES'					=> 'Mettre à jour les fichiers',
	'UPDATE_FILES_NOTICE'			=> 'Veuillez vous assurer d’avoir également mis à jour tous les fichiers de votre forum car ce fichier ne met à jour que votre base de données.',
	'UPDATE_INSTALLATION'			=> 'Mettre à jour l’installation de phpBB',
	'UPDATE_INSTALLATION_EXPLAIN'	=> 'Grâce à cette option, il est possible de mettre à jour votre installation vers la dernière version.<br />Durant le processus, tous vos fichiers seront vérifiés dans leur intégralité. Vous pourrez prévisualiser toutes les différences et tous les fichiers avant d’exécuter la mise à jour.<br /><br />Le fichier de mise à jour peut se générer de deux manières différentes.</p><h2>Mise à jour manuelle</h2><p>Avec cette mise à jour, vous ne téléchargez que les réglages des fichiers modifiés afin de vous assurer de ne perdre aucune modification. Après avoir téléchargé cette archive, vous devez mettre à jour manuellement les fichiers à leur emplacement respectif, selon la racine de votre répertoire phpBB. Une fois la mise à jour terminée, vous pouvez recommencer l’étape de vérification des fichiers afin de vous assurer d’avoir déplacé les fichiers à leur emplacement respectif.</p><h2>Mise à jour automatique par FTP</h2><p>Cette méthode est similaire à la première, mais elle ne nécessite pas de télécharger et de transférer manuellement les fichiers modifiés, cela sera fait automatiquement. Pour utiliser cette méthode, vous devez connaître les informations concernant votre connexion FTP car cela vous sera demandé. Une fois la mise à jour terminée, vous serez redirigé(e) une fois de plus à la vérification des fichiers afin de vous assurer du bon déroulement de la mise à jour.<br /><br />',
	'UPDATE_INSTRUCTIONS'			=> '

		<h1>Annonce de sortie</h1>

		<p>Veuillez consulter <a href="%1$s" title="%1$s"><strong>l’annonce relative à la sortie de la dernière version</strong></a> avant de continuer le processus de mise à jour. Elle contient des informations importantes, plusieurs liens de téléchargement et l’historique des modifications apportées.</p>

		<br />

		<h1>Comment mettre à jour votre installation avec l’archive de mise à jour automatique ?</h1>

		<p>La méthode listée ici n’est valable que pour l’archive de mise à jour automatique. Vous pouvez également mettre à jour votre installation en utilisant les méthodes listées dans le document INSTALL.html. Les étapes de mise à jour automatique de phpBB3 sont :</p>

		<ul style="margin-left: 20px; font-size: 1.1em;">
			<li>Rendez-vous sur <a href="https://www.phpbb.com/downloads/" title="https://www.phpbb.com/downloads/">la page des téléchargements de phpBB.com</a> et téléchargez l’archive de mise à jour automatique.<br /><br /></li>
			<li>Décompressez l’archive.<br /><br /></li>
			<li>Transférez dans son intégralité le répertoire décompressé à la racine de votre installation, où se trouve le fichier config.php.<br /><br /></li>
		</ul>

		<p>Une fois le répertoire transféré, votre forum apparaîtra hors-ligne aux utilisateurs pour des raisons de sécurité.<br /><br />
		<strong><a href="%2$s" title="%2$s">Commencez dès à présent le processus de mise à jour en dirigeant votre navigateur vers le répertoire d’installation</a>.</strong><br />
		<br />
		Vous serez alors guidé(e) par le processus de mise à jour, qui vous informera lorsque la mise à jour sera terminée.
		</p>
	',
	'UPDATE_INSTRUCTIONS_INCOMPLETE'	=> '

		<h1>Mise à jour incomplète détectée</h1>

		<p>Une mise à jour automatique incomplète a été détectée. Veuillez vous assurer d’avoir correctement suivi chaque étape de l’outil de mise à jour automatique. Vous trouverez ci-dessous le lien afin de recommencer le processus, ou rendez-vous directement sur votre répertoire d’installation.</p>
	',
	'UPDATE_METHOD'					=> 'Méthode de mise à jour',
	'UPDATE_METHOD_EXPLAIN'			=> 'Veuillez à présent sélectionner la méthode de mise à jour que vous souhaitez utiliser. Si vous souhaitez utiliser le transfert par FTP, il vous sera demandé de saisir dans un formulaire les informations concernant votre compte FTP. Avec cette méthode, les fichiers seront déplacés automatiquement vers le nouvel emplacement et vos anciens fichiers seront sauvegardés avec l’extension .bak qui sera ajoutée à la fin du nom de chaque fichier. Si vous préférez télécharger les fichiers modifiés, vous devrez les décompresser et les transférer manuellement vers l’emplacement qui leur est spécifique.',
	'UPDATE_REQUIRES_FILE'			=> 'Le fichier suivant est nécessaire à l’outil de mise à jour : %s',
	'UPDATE_SUCCESS'				=> 'La mise à jour a été effectuée',
	'UPDATE_SUCCESS_EXPLAIN'		=> 'Tous les fichiers ont été mis à jour. La prochaine étape consiste à vérifier de nouveau tous les répertoires afin de vous assurer que les fichiers ont été mis à jour correctement.',
	'UPDATE_VERSION_OPTIMIZE'		=> 'Mise à jour de la version et optimisation des tables',
	'UPDATING_DATA'					=> 'Mise à jour des données',
	'UPDATING_TO_LATEST_STABLE'		=> 'Mise à jour de la base de données vers la dernière version stable',
	'UPDATED_VERSION'				=> 'Version mise à jour',
	'UPGRADE_INSTRUCTIONS'			=> 'Une nouvelle version (<strong>%1$s</strong>) est disponible. Veuillez consulter <a href="%2$s" title="%2$s"><strong>l’annonce de sortie</strong></a> afin de vous informer sur les nouvelles fonctionnalités et la méthode à suivre pour mettre à jour votre installation.',
	'UPLOAD_METHOD'					=> 'Méthode de transfert ',

	'UPDATE_DB_SUCCESS'				=> 'La mise à jour de la base de données a été correctement effectuée.',
	'USER_ACTIVE'					=> 'Utilisateur actif',
	'USER_INACTIVE'					=> 'Utilisateur inactif',

	'VERSION_CHECK'					=> 'Vérifier la version',
	'VERSION_CHECK_EXPLAIN'			=> 'Vous permet de vérifier si votre installation de phpBB est à jour.',
	'VERSION_NOT_UP_TO_DATE'		=> 'Votre installation de phpBB n’est pas à jour. Veuillez continuer le processus de mise à jour.',
	'VERSION_NOT_UP_TO_DATE_ACP'	=> 'Votre installation de phpBB n’est pas à jour.<br />Vous trouverez ci-dessous un lien vers l’annonce de sortie, qui contient de plus amples informations et les instructions de mise à jour.',
	'VERSION_NOT_UP_TO_DATE_TITLE'	=> 'Votre installation de phpBB n’est pas à jour.',
	'VERSION_UP_TO_DATE'			=> 'Votre installation de phpBB est à jour. Comme aucune mise à jour n’est disponible pour le moment, vous devriez continuer en procédant à une vérification de vos fichiers afin de vous assurer qu’ils soient corrects.',
	'VERSION_UP_TO_DATE_ACP'		=> 'Votre installation de phpBB est à jour. Aucune mise à jour n’est disponible pour le moment.',
	'VIEWING_FILE_CONTENTS'			=> 'Consultation du contenu des fichiers',
	'VIEWING_FILE_DIFF'				=> 'Consultation des différences des fichiers',

	'WRONG_INFO_FILE_FORMAT'	=> 'Le format du fichier d’information est incorrect',
));

// Default database schema entries...
$lang = array_merge($lang, array(
	'CONFIG_BOARD_EMAIL_SIG'		=> 'Cordialement, le responsable',
	'CONFIG_SITE_DESC'				=> 'Un résumé décrivant votre forum',
	'CONFIG_SITENAME'				=> 'votredomaine.com',

	'DEFAULT_INSTALL_POST'			=> 'Ceci est un exemple de message de votre installation de phpBB3. Tout semble fonctionner correctement. Si vous le souhaitez, vous pouvez supprimer ce message et continuer à configurer votre forum. Lors du processus d’installation, votre première catégorie et votre premier forum ont été assignés à un ensemble de permissions relatif aux groupes d’utilisateurs que sont les administrateurs, les robots, les modérateurs globaux, les invités, les utilisateurs inscrits et les utilisateurs COPPA inscrits. Si vous souhaitez également supprimer votre première catégorie et votre premier forum, n’oubliez pas d’assigner les permissions appropriées à tous les groupes d’utilisateurs sur chaques nouvelles catégories et nouveaux forums que vous créez. Il est recommandé de renommer votre première catégorie et votre premier forum et de copier leurs permissions sur chaque nouvelle catégorie et chaque nouveau forum lors de leur création. Profitez bien de votre forum !',

	'FORUMS_FIRST_CATEGORY'			=> 'Votre première catégorie',
	'FORUMS_TEST_FORUM_DESC'		=> 'Description de votre premier forum.',
	'FORUMS_TEST_FORUM_TITLE'		=> 'Votre premier forum',

	'RANKS_SITE_ADMIN_TITLE'		=> 'Administrateur',
	'REPORT_WAREZ'					=> 'Le message rapporté contient un ou plusieurs liens dirigeant vers des ressources illégales ou des logiciels piratés.',
	'REPORT_SPAM'					=> 'Le message rapporté contient de la publicité visant à promouvoir un site internet ou un produit.',
	'REPORT_OFF_TOPIC'				=> 'Le message rapporté est hors-sujet.',
	'REPORT_OTHER'					=> 'Le message rapporté ne correspond à aucune catégorie, veuillez utiliser le champ d’information complémentaire.',

	'SMILIES_ARROW'					=> 'Flèche',
	'SMILIES_CONFUSED'				=> 'Troublé',
	'SMILIES_COOL'					=> 'Décontracté',
	'SMILIES_CRYING'				=> 'En larmes',
	'SMILIES_EMARRASSED'			=> 'Embarrassé',
	'SMILIES_EVIL'					=> 'Diabolique et mécontent',
	'SMILIES_EXCLAMATION'			=> 'Exclamation',
	'SMILIES_GEEK'					=> 'Geek',
	'SMILIES_IDEA'					=> 'Idée',
	'SMILIES_LAUGHING'				=> 'Rieur',
	'SMILIES_MAD'					=> 'Mécontent',
	'SMILIES_MR_GREEN'				=> 'M. Vert',
	'SMILIES_NEUTRAL'				=> 'Neutre',
	'SMILIES_QUESTION'				=> 'Question',
	'SMILIES_RAZZ'					=> 'Tire la langue',
	'SMILIES_ROLLING_EYES'			=> 'Roule des yeux',
	'SMILIES_SAD'					=> 'Triste',
	'SMILIES_SHOCKED'				=> 'Scandalisé',
	'SMILIES_SMILE'					=> 'Souriant',
	'SMILIES_SURPRISED'				=> 'Étonné',
	'SMILIES_TWISTED_EVIL'			=> 'Diabolique et souriant',
	'SMILIES_UBER_GEEK'				=> 'Geek expérimenté',
	'SMILIES_VERY_HAPPY'			=> 'Heureux',
	'SMILIES_WINK'					=> 'Clin d’œil',

	'TOPICS_TOPIC_TITLE'			=> 'Bienvenue sur phpBB3',
));

?>