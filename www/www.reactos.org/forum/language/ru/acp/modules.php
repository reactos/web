<?php
/**
*
* acp_modules [Russian]
*
* @package language
* @version $Id: modules.php,v 1.13 2007/10/04 15:07:24 acydburn Exp $
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

$lang = array_merge($lang, array(
	'ACP_MODULE_MANAGEMENT_EXPLAIN'	=> 'Здесь вы можете управлять всеми типами модулей. Обратите внимание на то, что администраторский раздел имеет трёхуровневую структуру меню (Категория → Категория → Модуль), в результате чего подразделы имеют двухуровневую структуру меню (Категория → Модуль), которая должна быть сохранена. Также учтите, что вы можете заблокировать доступ самому себе, если вы отключите или удалите модули, отвечающие за управление модулями.',
	'ADD_MODULE'					=> 'Добавить модуль',
	'ADD_MODULE_CONFIRM'			=> 'Вы действительно хотите добавить выбранный модуль с указанным методом использования?',
	'ADD_MODULE_TITLE'				=> 'Добавление модуля',

	'CANNOT_REMOVE_MODULE'	=> 'Не удалось удалить модуль, поскольку на него назначены дочерние модули. Удалите или переместите все дочерние модули перед выполнением этого действия.',
	'CATEGORY'				=> 'Категория',
	'CHOOSE_MODE'			=> 'Метод использования модуля',
	'CHOOSE_MODE_EXPLAIN'	=> 'Выберите метод использования модуля.',
	'CHOOSE_MODULE'			=> 'Выбор модуля',
	'CHOOSE_MODULE_EXPLAIN'	=> 'Выберите файл, вызываемый данным модулем.',
	'CREATE_MODULE'			=> 'Создать модуль',

	'DEACTIVATED_MODULE'	=> 'Отключённый модуль',
	'DELETE_MODULE'			=> 'Удалить модуль',
	'DELETE_MODULE_CONFIRM'	=> 'Вы действительно хотите удалить этот модуль?',

	'EDIT_MODULE'			=> 'Настройка модуля',
	'EDIT_MODULE_EXPLAIN'	=> 'С помощью этой страницы вы можете настроить модуль.',

	'HIDDEN_MODULE'			=> 'Скрытый модуль',

	'MODULE'					=> 'Модуль',
	'MODULE_ADDED'				=> 'Модуль успешно добавлен.',
	'MODULE_DELETED'			=> 'Модуль успешно удалён.',
	'MODULE_DISPLAYED'			=> 'Отображение модуля',
	'MODULE_DISPLAYED_EXPLAIN'	=> 'Если вы не хотите, чтобы модуль отображался в списке, но хотите использовать его, то установите переключатель в положение «Нет».',
	'MODULE_EDITED'				=> 'Настройки модуля успешно изменены.',
	'MODULE_ENABLED'			=> 'Модуль включён',
	'MODULE_LANGNAME'			=> 'Имя модуля',
	'MODULE_LANGNAME_EXPLAIN'	=> 'Введите отображаемое имя модуля. Используйте имя переменной, если имя модуля объявлено в языковом файле.',
	'MODULE_TYPE'				=> 'Тип модуля',

	'NO_CATEGORY_TO_MODULE'	=> 'Не удалось объявить категорию модулем. Удалите или переместите все дочерние модули перед выполнением этого действия.',
	'NO_MODULE'				=> 'Модуль не найден.',
	'NO_MODULE_ID'			=> 'Не указан ID модуля.',
	'NO_MODULE_LANGNAME'	=> 'Не указано имя модуля.',
	'NO_PARENT'				=> 'Нет родителя',

	'PARENT'				=> 'Родитель',
	'PARENT_NO_EXIST'		=> 'Родитель не существует.',

	'SELECT_MODULE'			=> 'Выберите модуль',
));

?>