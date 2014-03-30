<?php
/**
*
* acp_database [Russian]
*
* @package language
* @version $Id: database.php 9765 2009-07-17 10:11:10Z bantu $
* @copyright (c) 2005 phpBB Group
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
	'ACP_BACKUP_EXPLAIN'	=> 'Здесь вы можете создать резервную копию всех данных конференции. Вы можете сохранить конечный архив на сервере в папке <samp>store/</samp> или скачать его. В зависимости от конфигурации сервера может быть доступно сжатие файла резервной копии в нескольких форматах.',
	'ACP_RESTORE_EXPLAIN'	=> 'Будет произведено полное восстановление всех таблиц phpBB из сохранённого файла. Если сервер поддерживает такую возможность, вы можете использовать сжатые файлы gzip или bzip2, которые будут автоматически разархивированы. <strong>Внимание:</strong> все существующие данные будут уничтожены. Восстановление может занять длительное время, поэтому не уходите с этой страницы до полного завершения процесса. Резервные копии, предположительно созданные средствами phpBB, сохранены в папке <samp>store/</samp>. Восстановление из резервных копий, созданных не с использованием встроенной системы, может потерпеть неудачу.',

	'BACKUP_DELETE'		=> 'Файл резервной копии успешно удалён.',
	'BACKUP_INVALID'	=> 'Выбран недопустимый файл резервной копии.',
	'BACKUP_OPTIONS'	=> 'Параметры резервного копирования',
	'BACKUP_SUCCESS'	=> 'Файл резервной копии успешно создан.',
	'BACKUP_TYPE'		=> 'Тип копии',

	'DATABASE'			=> 'Управление БД',
	'DATA_ONLY'			=> 'Только данные',
	'DELETE_BACKUP'		=> 'Удалить резервную копию',
	'DELETE_SELECTED_BACKUP'	=> 'Вы действительно хотите удалить выбранную копию?',
	'DESELECT_ALL'		=> 'Снять выделение',
	'DOWNLOAD_BACKUP'	=> 'Скачать резервную копию',

	'FILE_TYPE'			=> 'Тип файла',
	'FILE_WRITE_FAIL'	=> 'Не удалось сохранить файл в папке «store».',
	'FULL_BACKUP'		=> 'Полная',

	'RESTORE_FAILURE'		=> 'Возможно, файл с резервной копией повреждён.',
	'RESTORE_OPTIONS'		=> 'Параметры восстановления',
	'RESTORE_SELECTED_BACKUP'	=> 'Вы уверены, что хотите восстановить данные из выбранной резервной копии?',
	'RESTORE_SUCCESS'		=> 'База данных успешно восстановлена.<br /><br />Конференция восстановлена к состоянию на момент создания резервной копии.',

	'SELECT_ALL'			=> 'Выделить все',
	'SELECT_FILE'			=> 'Выберите файл',
	'START_BACKUP'			=> 'Начать резервное копирование',
	'START_RESTORE'			=> 'Начать восстановление',
	'STORE_AND_DOWNLOAD'	=> 'Сохранить на сервере и скачать',
	'STORE_LOCAL'			=> 'Сохранить на сервере',
	'STRUCTURE_ONLY'		=> 'Только структура',

	'TABLE_SELECT'		=> 'Выбор таблиц',
	'TABLE_SELECT_ERROR'=> 'Необходимо выбрать хотя бы одну таблицу.',
));

?>