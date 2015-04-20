<?php
// $Id: phpbb_api.php,v 1.23 2010/11/24 20:53:34 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

define('IN_PHPBB', true);
define('PHPBB_API_EMBEDDED', true);
define('PHPBB_EMBEDDED', true);
define('PHPBB_API_DEBUG', 0);
define('VBRIDGE_DEBUG', 0);

//@define('PHPBB_DB_PCONNECT', true);
@define('PHPBB_DB_PCONNECT', false);
@define('PHPBB_DB_NEW_LINK', true);

define('PHPBB_BOARD_URL_WITHOUT_PORT', true);
//define('PHPBB_BOARD_URL_WITHOUT_PORT', false);
define('PHPBB_SEO_TOOLKIT', 0);
// Report all errors, except notices
//if (PHPBB_API_DEBUG)
//  error_reporting(E_ALL);
//else
//error_reporting(E_ALL ^ E_NOTICE);
// Report all errors, except notices and deprecation messages
if (!defined('E_DEPRECATED')) {
  define('E_DEPRECATED', 8192);
}
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

global $phpbb_config, $phpbb_user,
$user, $config, $cache, $auth, $template, $db, $module, $refresh, $submit, $preview,
$phpbb_root_path, $phpEx, $board_url,
$vbridge_root_path, $_vbridge,
$phpbb_db_type, $phpbb_db, $phpbb_connection, $phpbb_db_prefix, $table_prefix,
$site_base_url, $_drupal_base_path, $site_phpbb_page, $site_forum_url, $_phpbb_forum_url,
$_phpbb_integration_mode, $_phpbb_acp_integration_mode,
$_phpbb_result, $_phpbb_embed_mode,
$site_user, $_site_error_handler, $_site_context_saved,
$phpbb_hook, $phpbb_seo, $seo_meta;

if (!isset($phpbb_root_path) || empty($phpbb_root_path)) {
  $phpbb_root_path = dirname(__FILE__) . '/';
}

$phpEx = substr(strrchr(__FILE__, '.'), 1);

//exit

function getBridge() {
  global $_vbridge;
  return $_vbridge;
}

function phpbb_api_session_begin() {
  global $phpbb_connection;
  if ($phpbb_connection) {
    //_phpbbforum_set_message('phpbb_api_session_begin(phpbb_connection)');
    return $phpbb_connection;
  }
  //_phpbbforum_set_message('phpbb_api_session_begin(start db)');
  global $phpbb_config, $phpbb_user,
  $user, $config, $cache, $auth, $template, $db, $module, $refresh, $submit, $preview,
  $phpbb_root_path, $phpEx, $board_url,
  $vbridge_root_path, $_vbridge,
  $phpbb_db_type, $phpbb_db, $phpbb_db_prefix, $table_prefix,
  $site_base_url, $_drupal_base_path, $site_phpbb_page, $site_forum_url, $_phpbb_forum_url,
  $_phpbb_integration_mode, $_phpbb_acp_integration_mode,
  $_phpbb_result, $_phpbb_embed_mode,
  $site_user, $_site_error_handler, $_site_context_saved,
  $phpbb_hook, $phpbb_seo, $seo_meta;

  // If we are on PHP >= 6.0.0 we do not need some code
  if (version_compare(PHP_VERSION, '5.4.0-dev', '>=')) {
    define('STRIP', false);
  }
  else {
    ini_set("magic_quotes_runtime", 0);
    define('STRIP', (get_magic_quotes_gpc()) ? true : false);
  }

  if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
    date_default_timezone_set(@date_default_timezone_get());
  }
  
  if (!file_exists($phpbb_root_path . 'config.' . $phpEx)) {
    die("<p>The config.$phpEx file could not be found.</p><p><a href=\"{$phpbb_root_path}install/index.$phpEx\">Click here to install phpBB</a></p>");
  }

  require_once($phpbb_root_path . 'config.' . $phpEx);

  // If PHPBB isn't defined, config.php is missing or corrupt
  if (!defined('PHPBB_INSTALLED')) {
    die("<p>The config.$phpEx file is not valid.</p><p><a href=\"{$phpbb_root_path}install/index.$phpEx\">Click here to install phpBB</a></p>");
  }

  $phpbb_db_type = $dbms;
  $phpbb_db_prefix = $table_prefix;
  //$phpbb_language_dir = $phpbb_root_path . 'language/';

  // Load Extensions
  if (!empty($load_extensions)) {
    $load_extensions = explode(',', $load_extensions);

    foreach ($load_extensions as $extension) {
      @dl(trim($extension));
    }
  }

  // Include files
  require_once($phpbb_root_path . 'includes/acm/acm_' . $acm_type . '.' . $phpEx);
  require_once($phpbb_root_path . 'includes/cache.' . $phpEx);
  require_once($phpbb_root_path . 'includes/template.' . $phpEx);
  require_once($phpbb_root_path . 'includes/session.' . $phpEx);
  require_once($phpbb_root_path . 'includes/auth.' . $phpEx);
  require_once($phpbb_root_path . 'includes/functions.' . $phpEx);
  require_once($phpbb_root_path . 'includes/functions_content.' . $phpEx);
  require_once($phpbb_root_path . 'includes/constants.' . $phpEx);
  require_once($phpbb_root_path . 'includes/db/' . $dbms . '.' . $phpEx);
  require_once($phpbb_root_path . 'includes/utf/utf_tools.' . $phpEx);
  require_once($phpbb_root_path . 'includes/hooks/index.' . $phpEx);
  require_once($phpbb_root_path . 'includes/functions_user.' . $phpEx);
  require_once($phpbb_root_path . 'includes/functions_posting.' . $phpEx);
  /////////////////////////////////////////

  if (!isset($vbridge_root_path) || empty($vbridge_root_path)) {
    $vbridge_root_path = dirname(__FILE__) /*. '/phpbbvbridge'*/;
  }

  require_once($vbridge_root_path . '/phpbb_api_subs.php');
  require_once($vbridge_root_path . '/phpbb_api_hooks.php');
  require_once($vbridge_root_path . '/phpbb_api_theme.php');

  /////////////////////////////////////////
  //
  /////////////////////////////////////////
  $bridgeData = array(
    '#name' => 'PhpBB+Drupal',
    '#class' => 'Phpbb',
    '#objclass' => array(
      'Db',
      'Pass',
      'Session',
      'Qookie',
      'Auth',
      'AuthQookie',
      'AuthQookieStorage',
      'User',
    ),
    '#path' => $vbridge_root_path,
    '#url' => $site_forum_url,
    '#config' => array(
      'name' => 'val',
      '#parms' => array(
        array(
          'name' => 'val',
        ),
      ),
    ),
  );

  $bridgeAppData = array(
    array(
      '#name' => 'Drupal',
      '#type' => 'cms',
      '#path' => $_drupal_base_path,
      '#url' => $site_base_url,
      '#class' => 'Drupal',
      '#dir' => $vbridge_root_path,
      '#config' => array(
        'name' => 'val',
        '#hooks' => array(
          array(
            'login' => '',
            'logout' => '',
          ),
        ),
        '#settings' => array(
          array(
            'name' => 'val',
          ),
        ),
      ),
    ),
    array(
      '#name' => 'PhpBB',
      '#type' => 'forum',
      '#path' => $vbridge_root_path,
      '#url' => $site_forum_url,
      '#class' => 'Phpbb',
      '#dir' => $vbridge_root_path,
      '#config' => array(
        'name' => 'val',
        '#hooks' => array(
          array(
            'login' => '',
            'logout' => '',
          ),
        ),
        '#settings' => array(
          array(
            'name' => 'val',
          ),
        ),
      ),
    ),
  );
  /////////////////////////////////////////

  // Load VBridge stuff.
  require_once($vbridge_root_path . '/PhpbbVBridge.php');

  $_vbridge = PhpbbVBridge::getInstance($bridgeData, $bridgeAppData);
  /*
   if (VBRIDGE_DEBUG) {
   $message = 'Vbridge '. $_vbridge .' v'. getBridge()->getVersion() .', Drupal App='. getBridge()->getApp(0) .', PhpBB App='. getBridge()->getApp(1);
   drupal_set_message($message);
   }
   */
  getBridge()->init();
  getBridge()->run();

  // Set PHP error handler to ours
  if (!defined('PHPBB_ERROR_HANDLER')) {
    //define('PHPBB_ERROR_HANDLER', 'phpbb_error_msg_handler');
    define('PHPBB_ERROR_HANDLER', 'msg_handler');
  }

  $site_user = $user;
  $_site_context_saved = true;

  $_site_error_handler = set_error_handler(PHPBB_ERROR_HANDLER);

  $user	= new user();
  $auth	= new auth();
  $template	= new template();
  $cache = new cache();

  if (!is_object($db)) {
    $db	= new $sql_db();
  }

  if (!$phpbb_connection) {
    // Connect to DB
    $db->sql_connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport,
      defined('PHPBB_DB_PCONNECT') ? PHPBB_DB_PCONNECT : false,
      defined('PHPBB_DB_NEW_LINK') ? PHPBB_DB_NEW_LINK : false);
    if ($db->db_connect_id) {
      $phpbb_connection = $db->db_connect_id;
    }
  }

  unset($dbpasswd);

  $config = $cache->obtain_config();
  $phpbb_config = $config;

  if (defined('PHPBB_SEO_TOOLKIT')) {
    // www.phpBB-SEO.com SEO TOOLKIT BEGIN
    if (!is_object($phpbb_seo)) {
      $seofile = $phpbb_root_path . 'phpbb_seo/phpbb_seo_class.' . $phpEx;
      if (file_exists($seofile)) {
        require_once($seofile);
        $phpbb_seo = new phpbb_seo();
        @define('PHPBB_USE_BOARD_URL_PATH', true);
      }
    }
    // www.phpBB-SEO.com SEO TOOLKIT END
    if (is_object($phpbb_seo)) {
      // www.phpBB-SEO.com SEO TOOLKIT BEGIN - META
      require_once($phpbb_root_path . 'phpbb_seo/phpbb_seo_meta.' . $phpEx);
      if (!is_object($seo_meta)) {
        $seo_meta = new seo_meta();
      }
    }
    // www.phpBB-SEO.com SEO TOOLKIT END - META
  }

  phpbb_hook_init();

  // Start session management
  $user->session_begin();
  $auth->acl($user->data);
  $user->setup();

  $phpbb_config['forum_url'] = $_phpbb_forum_url = phpbb_generate_board_url(false, defined('PHPBB_BOARD_URL_WITHOUT_PORT') ? PHPBB_BOARD_URL_WITHOUT_PORT : false);

  $phpbb_user	= $user;
  $user = $site_user;

  @restore_error_handler();
  $_site_context_saved = false;

  return $phpbb_connection;
}

function phpbb_api_get_user_name($user_id) {
  phpbb_api_session_begin();
  global $phpbb_connection, $db;

  $username = "";
  if (!empty($user_id) && is_integer($user_id)) {
    if (!$phpbb_connection) {
      return $username;
    }

    $sql = 'SELECT username
  		FROM ' . USERS_TABLE . '
  		WHERE user_id = ' . $user_id;
    $result = $db->sql_query($sql);
    //list ($username) = $db->sql_fetchrow($result);
    $data = $db->sql_fetchrow($result);
    $username = $data['username'];
    $db->sql_freeresult($result);
  }
  return $username;
}

function phpbb_api_get_user_id($username) {
  phpbb_api_session_begin();
  global $phpbb_connection, $db;

  $user_id = 0;
  if (!empty($username)) {
    if (!$phpbb_connection) {
      return $user_id;
    }

    $sql = 'SELECT user_id
  		FROM ' . USERS_TABLE . "
  		WHERE username_clean = '" . $db->sql_escape(utf8_clean_string($username)) . "'";
    $result = $db->sql_query($sql);
    //list ($user_id) = $db->sql_fetchrow($result);
    $data = $db->sql_fetchrow($result);
    $user_id = $data['user_id'];
    $db->sql_freeresult($result);
  }
  return $user_id;
}

function phpbb_api_authenticate_user() {
  phpbb_api_session_begin();
  return getBridge()->authenticateUser();
}

function phpbb_api_get_user($username, $password) {
  phpbb_api_session_begin();
  return getBridge()->getAppUser($username, $password);
}

function phpbb_api_index($str) {
  phpbb_api_session_begin();
  global $phpbb_connection, $phpbb_config, $phpbb_user, $_phpbb_result, $_phpbb_embed_mode, $_phpbb_forum_url;
  global $user, $config, $cache, $auth, $template, $db, $module, $refresh, $submit, $preview,
  $phpbb_root_path, $phpEx, $board_url;

  if (!$phpbb_connection) {
    return false;
  }

  $_phpbb_result['output'] = "";

  phpbb_save();

  // Set PHP error handler to ours
  $_site_error_handler = set_error_handler(PHPBB_ERROR_HANDLER);
  //$_site_error_handler = set_error_handler('msg_handler');

  try {

    include_once($phpbb_root_path . $str);

  }
  catch (PhpbbVBridgeException $e) {

    $code = $e->getCode();
    switch ($code) {
      case VBridgeException::THROW_OUTPUT:
        break;
      default:
        //$msg = $e->getMessage();
        break;
    }
  }

  @restore_error_handler();

  phpbb_load();

  return $_phpbb_result['output'];
}

// Recent post list

function phpbb_api_recent_posts($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  global $vbridge_root_path;

  require_once($vbridge_root_path . '/phpbb_api_recent.php');

  return getBridge()->getRecentPosts($options);
}

// Recent topic list

function phpbb_api_recent_topics($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  global $vbridge_root_path;

  require_once($vbridge_root_path . '/phpbb_api_recent.php');

  return getBridge()->getRecentTopics($options);
}

// Show the top posters

function phpbb_api_topposter($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  return getBridge()->getTopPosters($options);
}

// Shows a list of online users...

function phpbb_api_whos_online($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  return getBridge()->getWhosOnline($options);
}

// Show some basic stats

function phpbb_api_board_stats($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  return getBridge()->getStatistics($options);
}

// Show Personal Messages

function phpbb_api_pm($options = array('output_method' => '')) {
  phpbb_api_session_begin();
  return getBridge()->getPersonalMessages($options);
}


function phpbb_api_register($username, $password, $email, $data = array()) {
  phpbb_api_session_begin();
  return getBridge()->registerUser($username, $password, $email, $data);
}

function phpbb_api_update_user($id, $username = '', $password = '', $email = '', $data = array()) {
  phpbb_api_session_begin();
  return getBridge()->updateUser($id, $username, $password, $email, $data);
}

function phpbb_api_login($username = '', $password = '', $options = array()) {
  phpbb_api_session_begin();
  return getBridge()->login($username, $password, $options);
}

function phpbb_api_logout() {
  phpbb_api_session_begin();
  getBridge()->logout();
}

function phpbb_api_user_delete($id, $mode = 'retain', $post_username = false) {
  phpbb_api_session_begin();
  return getBridge()->deleteUser($id, $mode, $post_username);
}

function phpbb_api_user_name_validate($username) {
  phpbb_api_session_begin();
  return getBridge()->validateUserName($username);
}

function phpbb_api_user_password_validate($password) {
  phpbb_api_session_begin();
  return getBridge()->validateUserPassword($password);
}

function phpbb_api_user_email_validate($email) {
  phpbb_api_session_begin();
  return getBridge()->validateUserEmail($email);
}

////////////////////////////////////////////////////////////////////////////////

/**
 * Gets information of the given topic and returns an array
 *
 * 'countPosts' - how many posts
 * 'forum_id'   - which forumid
 * 'post_id'    - which is the first postid
 * 'topic_id'   - the topic id
 *
 * @param integer $topic_id
 * @return array
 */
function phpbb_api_get_post_information($topic_id) {

  if (!is_numeric($topic_id)) {
    return array();
  }

  phpbb_api_session_begin();

  global $db;

  phpbb_save();

  $countRows = 0;

  $sql = 'SELECT post_id, topic_id, forum_id FROM ' . POSTS_TABLE . ' AS p
   		WHERE topic_id = ' . $topic_id;

  $db->sql_query($sql);
  $post = $db->sql_fetchrow();
  $countRows = $db->sql_affectedrows() - 1;

  if ($countRows === false || $countRows < 0 || !is_numeric($countRows)) {
    $countRows = 0;
  }

  $postInformation = array(
    'forum_id' => $post['forum_id'],
    'topic_id' => $post['topic_id'],
    'post_id' => $post['post_id'],
    'countPosts' => $countRows,
  );

  phpbb_load();

  return $postInformation;

}

/**
 * Returns an array with the forums, in which the user can create a thread
 * and post messages.
 *
 * @param integer $user_id
 * @return array (forum_id => forum_name);
 */
function phpbb_api_get_forums($user_id, $forum_ids = '', $exclude = 0) {

  $forums = array();

  if (!is_numeric($user_id)) {
    return $forums;
  }

  phpbb_api_session_begin();

  global $auth, $db;

  phpbb_save();

  /**
   * Just get the forums
   * - which are no categories (forum_type)
   * - which are not closed (forum_status)
   */

  $sql = "SELECT forum_id, forum_name FROM " . FORUMS_TABLE . " WHERE forum_type != 0 AND forum_status != 1";
  if ($forum_ids != '') {
    $sql .= " AND forum_id ";
    if ($exclude) {
      $sql .= "NOT ";
    }
    $sql .= "IN ($forum_ids)";
  }
  $db->sql_query($sql);
  while ($forum = $db->sql_fetchrow()) {
    // Check if the current user can post in this forum
    if ($auth->acl_get("f_post", $forum['forum_id']) && $forum['forum_id'] !== 0) {
      $forums[$forum['forum_id']] = html_entity_decode($forum['forum_name']);
    }
  }

  phpbb_load();

  return $forums;

}


/**
 * phpbb_user_new_privmsg
 */
function phpbb_user_new_privmsg() {
  global $phpbb_user;

  $s_privmsg_new = false;

  if (!empty($phpbb_user->data['is_registered'])) {
    if ($phpbb_user->data['user_new_privmsg']) {
      if (!$phpbb_user->data['user_last_privmsg'] || $phpbb_user->data['user_last_privmsg'] > $phpbb_user->data['session_last_visit']) {
        $s_privmsg_new = true;
      }
    }
  }

  return $s_privmsg_new;
}
