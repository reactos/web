<?php
// $Id: PhpbbVBridgeApp.php,v 1.11 2010/11/24 20:53:35 vb Exp $
/*
 * PhpbbVBridgeApp
 */
require_once(dirname(__FILE__) . '/VBridge/VBridgeApp.php');
require_once(dirname(__FILE__) . '/PhpbbVBridgeException.php');

class PhpbbVBridgeApp extends VBridgeApp {
  //static private $_app;

  public function __construct($id, $bridgeData, $appData, $appDataConfig = array()) {
    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__);
    parent::__construct($id, $bridgeData, $appData, $appDataConfig);
  }

  public function __destruct() {
    parent::__destruct();
  }

  private function __clone() { }

  protected function createObj($path, $objclass, $subclass = '') {
    $ok = parent::createObj($path, $objclass, $subclass);

    return $ok;
  }

  protected function create() {
    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__);
    parent::create();

    return true;
  }

  public function init($options = array()) {
    return true;
  }

  public function run() { }
  /*
   public function notify($obj, $observable, $type, $event, $val) {
   if ($obj instanceof VBridge) {
   if (VBRIDGE_DEBUG)
   drupal_set_message(__CLASS__ .'::'.__METHOD__. ' type='. $type. 'event='. $event. 'val='.  $val);
   }
   }
   */

  public function authenticateUserExternal() {
    //$authenticated = authenticate();
  }

  public function authenticateUser() {
    global $phpbb_user;
    global $db, $user, $template, $auth, $config;

    if ($this->getStatus()) {
      return false;
    }

    phpbb_save();

    // Start session management
    $user->session_begin();
    $auth->acl($user->data);
    $user->setup();

    $phpbb_user->data['is_registered'] = $user->data['is_registered'];
    $phpbb_user->data['is_bot'] = $user->data['is_bot'];

    phpbb_load();

    return ($phpbb_user->data['user_id'] != ANONYMOUS);
  }

  public function getAppUser($id, $password = '') {
    if (empty($id)) {
      return false;
    }

    $email = $id;
    $username = $id;

    $username_clean = utf8_clean_string($username);

    // authentication
    $authenticated = $this->authenticateUser();
    //$user = $this->getUser();

    /*
     if ($authenticated &&
     ( ($username == $user->getUserName() || $email == $user->getUserEmail())  )
     ) {
     return true;
     }
     */

    global $phpbb_config, $phpbb_user;

    // authentication!
    if ($authenticated &&
      !empty($username) && $username_clean == utf8_clean_string($phpbb_user->data['username'])) {

      $phpbb_config['user'] =	array(
        'status' => LOGIN_SUCCESS,
        'error_msg' => false,
      );
      return true;
    }

    if (empty($username)) {
      return false;
    }

    global $db, $config;

    $sql = 'SELECT *
      FROM ' . USERS_TABLE . "
      WHERE username_clean = '" . $db->sql_escape($username_clean) . "'";
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrow($result);
    $db->sql_freeresult($result);

    if (!$row) {
      $phpbb_config['user'] =	array(
        'status' => LOGIN_ERROR_USERNAME,
        'error_msg' => 'LOGIN_ERROR_USERNAME',
        'user_row' => array('user_id' => ANONYMOUS),
      );
      $phpbb_user->data['user_id'] = ANONYMOUS;
      return false;
    }

    // Check password ...
    if (!empty($password)) {
      if (/*!$row['user_pass_convert'] &&*/ phpbb_check_hash($password, $row['user_password'])/*md5($password) == $row['user_password']*/) {
        // Check for old password hash...
        /*
         if (strlen($row['user_password']) == 32)
         {
         $hash = phpbb_hash($password);

         // Update the password in the users table to the new format
         $sql = 'UPDATE ' . USERS_TABLE . "
         SET user_password = '" . $db->sql_escape($hash) . "',
         user_pass_convert = 0
         WHERE user_id = ' . (int) $row['user_id'] . '
         AND user_login_attempts < ' . LOGIN_ATTEMPTS_MAX;

         $db->sql_query($sql);

         $row['user_password'] = $hash;
         }
         */
        /*
         if ($row['user_login_attempts'] != 0)
         {
         // Successful, reset login attempts (the user passed all stages)
         $sql = 'UPDATE ' . USERS_TABLE . '
         SET user_login_attempts = 0
         WHERE user_id = ' . $row['user_id'];
         $db->sql_query($sql);
         }
         */
        // User inactive...
        if ($row['user_type'] == USER_INACTIVE || $row['user_type'] == USER_IGNORE) {
          $phpbb_config['user'] =	array(
            'status' => LOGIN_ERROR_ACTIVE,
            'error_msg' => 'ACTIVE_ERROR',
            'user_row' => $row,
          );
        }
        else {
          // Successful login... set user_login_attempts to zero...
          $phpbb_config['user'] =	array(
            'status' => LOGIN_SUCCESS,
            'error_msg' => false,
            'user_row' => $row,
          );
        }
        $phpbb_user->data = $row;
      }
      else {
        // Give status about wrong password...
        $phpbb_config['user'] =	array(
          'status' => LOGIN_ERROR_PASSWORD,
          'error_msg' => 'LOGIN_ERROR_PASSWORD',
          'user_row' => $row,
        );
        /*
         // Password incorrect - increase login attempts
         $sql = 'UPDATE ' . USERS_TABLE . '
         SET user_login_attempts = user_login_attempts + 1
         WHERE user_id = ' . (int) $row['user_id'] . '
         AND user_login_attempts < ' . LOGIN_ATTEMPTS_MAX;
         $db->sql_query($sql);
         */
        $phpbb_user->data = $row;
        return false;
      }
    }
    else {
      $phpbb_config['user'] =	array(
        'status' => LOGIN_ERROR_ACTIVE,
        'error_msg' => 'ACTIVE_ERROR',
        'user_row' => $row,
      );
      $phpbb_user->data = $row;
      $phpbb_user->data['user_password'] = "";
    }


    /*
     $found = $this->loadUserByUserName($username, $password);
     if (!$found) {
     $found = $this->loadUserByEmail($email, $password);
     if (!$found) {
     $user->clear();
     return false;
     }
     }

     if (!empty($password)) {
     $valid = $user->validatePassword($password);
     if (!$valid) {
     $user->setPassword('')
     ->setPasswordSalt('');
     return false;
     }
     } else {
     $user->setPassword('')
     ->setPasswordSalt('');
     }

     $user->setGuest(true);
     */
    return true;
  }

  public function authenticate(&$id, &$password) {

  }

  public function loadUser($id, $password = '') {
    if ($this->getStatus()) {
      return false;
    }
    if (empty($id)) {
      return false;
    }
    if (!is_integer($id)) {
      $email = $id;
      $username = $id;
    }
    else {
      $email = '';
    }
    return $this->getUser();
  }

  public function saveUser() {

  }

  public function login($username = '', $password = '', $options = array()) {
    global $phpbb_connection, $phpbb_config, $user;
    global $db, $user, $template, $auth, $phpEx, $phpbb_root_path, $config;

    if ($this->getStatus()) {
      return false;
    }

    phpbb_save();

    $err = '';

    $openid_login = !empty($options['openid_identifier']);

    $autologin = true;
    $viewonline = 1;
    $admin = false;

    if (!class_exists('phpbb_captcha_factory')) {
      include_once($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
    }
    // Make sure user->setup() has been called
    if (empty($user->lang)) {
      $user->setup();
    }

    // Print out error if user tries to authenticate as an administrator without having the privileges...
    if ($admin && !$auth->acl_get('a_')) {
      // Not authd
      // anonymous/inactive users are never able to go to the ACP even if they have the relevant permissions
      if ($user->data['is_registered']) {
        add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
      }
      //trigger_error('NO_AUTH_ADMIN');
      phpbb_load();
      return false;
    }

    if (!empty($username) && !empty($password)) {
      $viewonline = (!$viewonline) ? 0 : 1;
      $admin 		= ($admin) ? 1 : 0;
      $viewonline = ($admin) ? $user->data['session_viewonline'] : $viewonline;

      // Check if the supplied username is equal to the one stored within the database if re-authenticating
      if ($admin && utf8_clean_string($username) != utf8_clean_string($user->data['username'])) {
        // We log the attempt to use a different username...
        add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
        //trigger_error('NO_AUTH_ADMIN_USER_DIFFER');
        phpbb_load();
        return false;
      }

      // do not allow empty password
      //if (!$password)
      //{
      //	trigger_error('NO_PASSWORD_SUPPLIED');
      //}
      if (!$openid_login) {
        $result = $auth->login($username, $password, $autologin, $viewonline, $admin);
      }
      else {
        $result['status'] = '';
        // patch by sergey.gul-a-t-gmail.com to allow openid login
        // get user id
        $sql = 'SELECT user_id FROM ' . USERS_TABLE . '
          WHERE username = "' . $username . '"';
        $dbresult = $db->sql_query($sql);
        $row = $db->sql_fetchrow($dbresult);
        $db->sql_freeresult($dbresult);
        if ($row && isset($row['user_id'])) {
          $phpbb_user_id = $row['user_id'];
          $old_session_id = $user->session_id;

          if ($admin) {
            global $SID, $_SID;

            $cookie_expire = time() - 31536000;
            $user->set_cookie('u', '', $cookie_expire);
            $user->set_cookie('sid', '', $cookie_expire);
            unset($cookie_expire);

            $SID = '?sid=';
            $user->session_id = $_SID = '';
          }

          $create = $user->session_create($phpbb_user_id, $admin, $autologin, $viewonline);
          // Successful session creation
          if ($create === true) {
            $result['status'] = LOGIN_SUCCESS;
            // If admin re-authentication we remove the old session entry because a new one has been created...
            if ($admin) {
              // the login array is used because the user ids do not differ for re-authentication
              $sql = 'DELETE FROM ' . SESSIONS_TABLE . "
                WHERE session_id = '" . $db->sql_escape($old_session_id) . "'
                AND session_user_id = {$login['user_row']['user_id']}";
              $db->sql_query($sql);
            }
          }
        }
      }
      // If admin authentication and login, we will log if it was a success or not...
      // We also break the operation on the first non-success login - it could be argued that the user already knows
      if ($admin) {
        if ($result['status'] == LOGIN_SUCCESS) {
          add_log('admin', 'LOG_ADMIN_AUTH_SUCCESS');
        }
        else {
          // Only log the failed attempt if a real user tried to.
          // anonymous/inactive users are never able to go to the ACP even if they have the relevant permissions
          if ($user->data['is_registered']) {
            add_log('admin', 'LOG_ADMIN_AUTH_FAIL');
          }
        }
      }
      // Special cases... determine
      switch ($result['status']) {
        case LOGIN_SUCCESS:
          // Special case... the user is effectively banned, but we allow founders to login
          //if (defined('IN_CHECK_BAN') && $result['user_row']['user_type'] != USER_FOUNDER)
          //{
          //}

          break;

        case LOGIN_ERROR_ATTEMPTS:
          /*
           // Show confirm image
           $sql = 'DELETE FROM ' . CONFIRM_TABLE . "
           WHERE session_id = '" . $db->sql_escape($user->session_id) . "'
           AND confirm_type = " . CONFIRM_LOGIN;
           $db->sql_query($sql);

           // Generate code
           $code = gen_rand_string(mt_rand(5, 8));
           $confirm_id = md5(unique_id($user->ip));
           $seed = hexdec(substr(unique_id(), 4, 10));

           // compute $seed % 0x7fffffff
           $seed -= 0x7fffffff * floor($seed / 0x7fffffff);

           $sql = 'INSERT INTO ' . CONFIRM_TABLE . ' ' . $db->sql_build_array('INSERT', array(
           'confirm_id'	=> (string) $confirm_id,
           'session_id'	=> (string) $user->session_id,
           'confirm_type'	=> (int) CONFIRM_LOGIN,
           'code'			=> (string) $code,
           'seed'			=> (int) $seed)
           );
           $db->sql_query($sql);

           $template->assign_vars(array(
           'S_CONFIRM_CODE'			=> true,
           'CONFIRM_ID'				=> $confirm_id,
           'CONFIRM_IMAGE'				=> '<img src="' . append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=confirm&amp;id=' . $confirm_id . '&amp;type=' . CONFIRM_LOGIN) . '" alt="" title="" />',
           'L_LOGIN_CONFIRM_EXPLAIN'	=> sprintf($user->lang['LOGIN_CONFIRM_EXPLAIN'], '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">', '</a>'),
           ));
           */
          $err = $user->lang[$result['error_msg']];

          break;

        case LOGIN_ERROR_PASSWORD_CONVERT:
          $err = sprintf(
  					$user->lang[$result['error_msg']],
  					($config['email_enable']) ? '<a href="' . append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=sendpassword') . '">' : '',
  					($config['email_enable']) ? '</a>' : '',
  					($config['board_contact']) ? '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">' : '',
  					($config['board_contact']) ? '</a>' : ''
  				);
          break;

        case LOGIN_BREAK:
          //trigger_error($result['error_msg'], E_USER_ERROR);
          phpbb_load();
          return false;
          //break;

          // Username, password, etc...
        default:
          $err = $user->lang[$result['error_msg']];

          // Assign admin contact to some error messages
          if ($result['error_msg'] == 'LOGIN_ERROR_USERNAME' || $result['error_msg'] == 'LOGIN_ERROR_PASSWORD') {
            $err = (!$config['board_contact']) ? sprintf($user->lang[$result['error_msg']], '', '') : sprintf($user->lang[$result['error_msg']], '<a href="mailto:' . htmlspecialchars($config['board_contact']) . '">', '</a>');
          }

          break;
      }
    }
    else {
      $result = array(
        'status' => LOGIN_ERROR_USERNAME,
        'error_msg' => 'LOGIN_ERROR_USERNAME',
        'user_row' => array('user_id' => ANONYMOUS),
      );
      $phpbb_user->data['user_id'] = ANONYMOUS;
    }

    $phpbb_config['user'] =	$result;
    $phpbb_config['error_msg'] = $err;

    phpbb_load();

    return ($result['status'] == LOGIN_SUCCESS);
  }

  public function logout() {
    global $phpbb_config, $user, $auth;

    if ($this->getStatus()) {
      return false;
    }

    phpbb_save();

    if ($user->data['user_id'] != ANONYMOUS) {
      $user->session_kill();
      $user->session_begin();
      $auth->acl($user->data);
      $user->setup();
    }

    phpbb_load();
  }

  public function deleteUser($id, $mode = 'retain', $post_username = false) {
    global $phpbb_config, $user;

    $return = false;

    if ($this->getStatus() || !$id) {
      return $return;
    }

    phpbb_save();

    if ($user->data['user_id'] != ANONYMOUS && $user->data['user_id'] != 2 && !$user->data['is_bot'] && $user->data['user_type'] != USER_IGNORE) {
      $return = phpbb_user_delete($mode, $id, $post_username);
    }

    phpbb_load();

    return $return;
  }

  public function registerUser($username, $password, $email, $data = array()) {
    global $phpbb_config, $phpbb_user;

    if ($this->getStatus()) {
      return false;
    }

    if (empty($username) || strlen($username) > 128) {
      $phpbb_config['error_msg'] = "bad username";
      return false;
    }

    if (empty($email)) {
      $phpbb_config['error_msg'] = "empty email";
      return false;
    }
    if (empty($password)) {
      $phpbb_config['error_msg'] = "empty password";
      return false;
    }

    $email = strtolower($email);

    $username = utf8_normalize_nfc($username);

    phpbb_save();

    $rc = phpbb_register($username, $password, $email, $data);

    phpbb_load();

    return $rc;
  }

  public function updateUser($id, $username = '', $password = '', $email = '', $data = array()) {
    global $phpbb_config, $phpbb_user;

    $rc = false;

    if ($this->getStatus() ||
        empty($id) || empty($phpbb_user->data['user_id']) ||
        $id == ANONYMOUS || $phpbb_user->data['is_bot']) {
      return $rc;
    }

    if (!empty($username)) {
      $username = utf8_normalize_nfc($username);
      if (isset($data['username'])) {
        $data['username'] = $username;
      }
      else {
        $data += array('username' => $username);
      }
    }

    if (!empty($password)) {
      //$password = md5($password);

      if (isset($data['user_password'])) {
        $data['user_password'] = $password;
      }
      else {
        $data += array('user_password' => $password);
      }
    }

    if (!empty($email)) {
      $email = strtolower($email);

      if (isset($data['user_email'])) {
        $data['user_email'] = $email;
      }
      elseif ($phpbb_user->data['user_email'] != $email) {
        $data += array('user_email' => $email);
      }
    }

    if (!empty($data)) {
      phpbb_save();

      $rc = phpbb_update_user_data($id, $data);

      phpbb_load();
    }

    return $rc;
  }

  public function getRecentPosts($options = array('output_method' => '')) {
    $str = '';
    if ($this->getStatus()) {
      return $str;
    }

    //$this->authenticateUser();


    global $phpbb_config, $phpbb_user;

    //require_once(dirname(__FILE__) . '/phpbb_api_recent.php');

    // Get options
    extract($options, EXTR_SKIP);

    if ($num_recent < 0) {
      $num_recent = 0;
    }

    $show_results = 'posts';
    //$search_id = 'unanswered';
    //$search_id = 'egosearch';
    // $search_id = 'newposts';
    $topic_id = 0;
    $post_id = 0;

    // Call App function

    $posts = phpbb_api_search($num_recent, $show_results, $search_id, $topic_id, $post_id, $sort_days);

    if ($output_method == 'array') {
      return $posts;
    }

    return theme_phpbb_api_recent_posts($posts, $options);

  }

  public function getRecentTopics($options = array('output_method' => '')) {
    $str = '';
    if ($this->getStatus()) {
      return $str;
    }

    //$this->authenticateUser();

    global $phpbb_config, $phpbb_user;

    // Get options
    extract($options, EXTR_SKIP);

    if ($num_recent < 0) {
      $num_recent = 0;
    }

    $show_results = 'topics';
    //$search_id = 'unanswered';
    // $search_id = 'active_topics';
    //$search_id = 'newposts';
    $topic_id = 0;
    $post_id = 0;

    // Call App function

    $posts = phpbb_api_search($num_recent, $show_results, $search_id, $topic_id, $post_id, $sort_days);

    if ($output_method == 'array') {
      return $posts;
    }

    return theme_phpbb_api_recent_topics($posts, $options);
  }

  public function getTopPosters($options = array('output_method' => '')) {
    $strreturn = '';
    if ($this->getStatus()) {
      return $strreturn;
    }

    //$this->authenticateUser();

    global $phpbb_config, $phpbb_user;
    global $db, $config, $template, $user, $auth, $phpEx, $phpbb_root_path;

    // Get options
    extract($options, EXTR_SKIP);

    if ($num_top <= 0) {
      $num_top = 1;
    }

    phpbb_save();

    if (empty($user->session_id)) {
      // Start session management
      $user->session_begin();
      $auth->acl($user->data);
      $user->setup();
    }

    $phpbb_url = $phpbb_config['forum_url'];

    // Find the latest poster.
    $sql = 'SELECT user_id, username, user_posts, user_colour
  		FROM ' . USERS_TABLE . '
  		WHERE user_type <> 2
  		AND user_posts <> 0
  		ORDER BY user_posts DESC';

    $result = $db->sql_query_limit($sql, $num_top);

    if ($result === false) {
      phpbb_load();
      return $strreturn;
    }

    $posters = array();
    while ( ($row = $db->sql_fetchrow($result)) && ($row['username'] != '') ) {
      $posters[] = array(
        'user_id' => $row['user_id'],
        //'S_SEARCH_ACTION'=> append_sid("{$phpbb_url}/search.$phpEx", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
        'username' => $row['username'], //censor_text($row['username']),
        'USERNAME_COLOR' => ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '"' : '',
        //'U_USERNAME'	=> append_sid("{$phpbb_url}/memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']),
        'link' => '<a href="' . append_sid("{$phpbb_url}/memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']) . '">' . $row['username'] . '</a>',
        'user_posts' => $row['user_posts'],
      );
    }
    $db->sql_freeresult($result);

    phpbb_load();

    if ($output_method == 'array') {
      return $posters;
    }

    // Call App function
    return theme_phpbb_api_topposter($posters, $options);
  }

  public function getPersonalMessages($options = array('output_method' => '')) {

    global $phpbb_connection, $phpbb_config, $phpbb_user, $site_user, $phpbb_func, $phpbb_txt;
    global $db, $config, $template, $SID, $_SID, $user, $auth, $phpEx, $phpbb_root_path;

    $strreturn = '';
    if ($this->getStatus() || $user->uid == 0) {
      return $strreturn;
    }

    extract($options, EXTR_SKIP);

    phpbb_save();

    if (empty($user->session_id)) {
      // Start session management
      $user->session_begin();
      $auth->acl($user->data);
      $user->setup();
    }

    $name = $site_user->name;

    if ($user->data['user_id'] == ANONYMOUS ||
        !isset($user->data['is_registered']) || !$user->data['is_registered'] || $name != $user->data['username']) {
      phpbb_load();
      return $strreturn;
    }

    $phpbb_url = $phpbb_config['forum_url'];

    //include_once($phpbb_root_path . 'includes/functions_display.' . $phpEx);

    $l_privmsgs_text = $l_privmsgs_text_unread = $l_message_unread = '';
    $s_privmsg_new = false;

    // Obtain number of new private messages if user is logged in
    if ($user->data['user_new_privmsg']) {
      $l_message_new = ($user->data['user_new_privmsg'] == 1) ? $user->lang['NEW_PM'] : $user->lang['NEW_PMS'];
      $l_privmsgs_text = sprintf($l_message_new, $user->data['user_new_privmsg']);

      if (!$user->data['user_last_privmsg'] || $user->data['user_last_privmsg'] > $user->data['session_last_visit']) {
        $sql = 'UPDATE ' . USERS_TABLE . '
  				SET user_last_privmsg = ' . $user->data['session_last_visit'] . '
  				WHERE user_id = ' . $user->data['user_id'];
        $db->sql_query($sql);

        $s_privmsg_new = true;
      }
      else {
        $s_privmsg_new = false;
      }
    }
    else {
      $l_privmsgs_text = $user->lang['NO_NEW_PM'];
      $s_privmsg_new = false;
    }

    if ($user->data['user_unread_privmsg'] && $user->data['user_unread_privmsg'] != $user->data['user_new_privmsg']) {
      $l_message_unread = ($user->data['user_unread_privmsg'] == 1) ? $user->lang['UNREAD_PM'] : $user->lang['UNREAD_PMS'];
      $l_privmsgs_text_unread = sprintf($l_message_unread, $user->data['user_unread_privmsg']);
    }

    phpbb_load();

    $output['l_privmsgs_text'] = $l_privmsgs_text;
    $output['s_privmsg_new'] = $s_privmsg_new;
    $output['l_privmsgs_text_unread'] = $l_privmsgs_text_unread;
    $output['l_message_unread'] = $l_message_unread;

    if ($output_method == 'array') {
      return $output;
    }

    return theme_phpbb_api_pm($output, $options);

  }

  public function getWhosOnline($options = array('output_method' => '')) {
    $strreturn = '';
    if ($this->getStatus()) {
      return $strreturn;
    }
    //$this->authenticateUser();

    global $phpbb_config, $phpbb_user;
    global $db, $config, $template, $SID, $_SID, $user, $auth, $phpEx, $phpbb_root_path;

    extract($options, EXTR_SKIP);

    if ($num_top <= 0) {
      $num_top = 9999;
    }

    phpbb_save();

    $phpbb_url = $phpbb_config['forum_url'];

    if (empty($user->session_id)) {
      // Start session management
      $user->session_begin();
      $auth->acl($user->data);
      $user->setup();
    }

    /*
     // Generate logged in/logged out status
     if ($user->data['user_id'] != ANONYMOUS)
     {
     $u_login_logout = append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=logout', true, $user->session_id);
     $l_login_logout = sprintf($user->lang['LOGOUT_USER'], $user->data['username']);
     }
     else
     {
     $u_login_logout = append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=login');
     $l_login_logout = $user->lang['LOGIN'];
     }

     // Last visit date/time
     $s_last_visit = ($user->data['user_id'] != ANONYMOUS) ? $user->format_date($user->data['session_last_visit']) : '';
     */
    // Get users online list ... if required
    $l_online_users = $online_userlist = $l_online_record = '';

    if ($config['load_online'] && $config['load_online_time']/* && $display_online_list*/) {
      $logged_visible_online = $logged_hidden_online = $guests_online = $prev_user_id = 0;
      $prev_session_ip = $reading_sql = '';

      $f = 0;
      /*
       if (!empty($_REQUEST['f']))
       {
       $f = request_var('f', 0);
       //$f = 0;

       $reading_sql = ' AND s.session_page ' . $db->sql_like_expression("{$db->any_char}_f_={$f}x{$db->any_char}");
       }
       */
      // Get number of online guests
      if (!$config['load_online_guests']) {
        if ($db->sql_layer === 'sqlite') {
          $sql = 'SELECT COUNT(session_ip) as num_guests
  					FROM (
  						SELECT DISTINCT s.session_ip
  							FROM ' . SESSIONS_TABLE . ' s
  							WHERE s.session_user_id = ' . ANONYMOUS . '
  								AND s.session_time >= ' . (time() - ($config['load_online_time'] * 60)) .
  								$reading_sql .
  					')';
        }
        else {
          $sql = 'SELECT COUNT(DISTINCT s.session_ip) as num_guests
  					FROM ' . SESSIONS_TABLE . ' s
  					WHERE s.session_user_id = ' . ANONYMOUS . '
  						AND s.session_time >= ' . (time() - ($config['load_online_time'] * 60)) .
  					$reading_sql;
        }
        $result = $db->sql_query($sql);
        $guests_online = (int) $db->sql_fetchfield('num_guests');
        $db->sql_freeresult($result);
      }

      $sql = 'SELECT u.username, u.username_clean, u.user_id, u.user_type, u.user_allow_viewonline, u.user_colour, s.session_ip, s.session_viewonline
  			FROM ' . USERS_TABLE . ' u, ' . SESSIONS_TABLE . ' s
  			WHERE s.session_time >= ' . (time() - (intval($config['load_online_time']) * 60)) .
  				$reading_sql .
  				((!$config['load_online_guests']) ? ' AND s.session_user_id <> ' . ANONYMOUS : '') . '
  				AND u.user_id = s.session_user_id
  			ORDER BY u.username_clean ASC, s.session_ip ASC';

      //$result = $db->sql_query($sql);
      $result = $db->sql_query_limit($sql, $num_top);

      while ($row = $db->sql_fetchrow($result)) {
        // User is logged in and therefore not a guest
        if ($row['user_id'] != ANONYMOUS) {
          // Skip multiple sessions for one user
          if ($row['user_id'] != $prev_user_id) {
            if ($row['user_colour']) {
              $user_colour = ' style="color:#' . $row['user_colour'] . '"';
              $row['username'] = '<strong>' . $row['username'] . '</strong>';
            }
            else {
              $user_colour = '';
            }

            if ($row['session_viewonline']) {
              $user_online_link = $row['username'];
              $logged_visible_online++;
            }
            else {
              $user_online_link = '<em>' . $row['username'] . '</em>';
              $logged_hidden_online++;
            }

            if (($row['session_viewonline']) || $auth->acl_get('u_viewonline')) {
              if ($row['user_type'] <> USER_IGNORE) {
                $user_online_link = '<a href="' . append_sid("{$phpbb_url}/memberlist.$phpEx", 'mode=viewprofile&amp;u=' . $row['user_id']) . '"' . $user_colour . '>' . $user_online_link . '</a>';
              }
              else {
                $user_online_link = ($user_colour) ? '<span' . $user_colour . '>' . $user_online_link . '</span>' : $user_online_link;
              }

              $online_userlist .= ($online_userlist != '') ? ', ' . $user_online_link : $user_online_link;
            }
          }

          $prev_user_id = $row['user_id'];
        }
        else {
          // Skip multiple sessions for one user
          if ($row['session_ip'] != $prev_session_ip) {
            $guests_online++;
          }
        }

        $prev_session_ip = $row['session_ip'];
      }
      $db->sql_freeresult($result);

      if (!$online_userlist) {
        $online_userlist = $user->lang['NO_ONLINE_USERS'];
      }

      //if (empty($_REQUEST['f']))
      //if (empty($f))
      //{
      $online_userlist = $user->lang['REGISTERED_USERS'] . ' ' . $online_userlist;
      //}
      //else
      //{
      //$l_online = ($guests_online == 1) ? $user->lang['BROWSING_FORUM_GUEST'] : $user->lang['BROWSING_FORUM_GUESTS'];
      //$online_userlist = sprintf($l_online, $online_userlist, $guests_online);
      //}

      $total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;

      /*
       if ($total_online_users > $config['record_online_users'])
       {
       set_config('record_online_users', $total_online_users, true);
       set_config('record_online_date', time(), true);
       }
       */

      // Build online listing
      $vars_online = array(
        'ONLINE' => array('total_online_users', 'l_t_user_s'),
        'REG' => array('logged_visible_online', 'l_r_user_s'),
        'HIDDEN' => array('logged_hidden_online', 'l_h_user_s'),
        'GUEST' => array('guests_online', 'l_g_user_s'),
      );

      foreach ($vars_online as $l_prefix => $var_ary) {
        $l_suffix = '';
        if ($l_prefix == 'HIDDEN') {
          $l_suffix = '_AND';
        }
        switch (${$var_ary[0]}) {
          case 0:
            ${$var_ary[1]} = $user->lang[$l_prefix . '_USERS_ZERO_TOTAL' . $l_suffix];
            break;

          case 1:
            ${$var_ary[1]} = $user->lang[$l_prefix . '_USER_TOTAL' . $l_suffix];
            break;

          default:
            ${$var_ary[1]} = $user->lang[$l_prefix . '_USERS_TOTAL' . $l_suffix];
            break;
        }
      }
      unset($vars_online);

      $l_online_users = sprintf($l_t_user_s, $total_online_users);
      $l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
      $l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
      $l_online_users .= sprintf($l_g_user_s, $guests_online);

      $l_online_record = sprintf($user->lang['RECORD_ONLINE_USERS'], $config['record_online_users'], $user->format_date($config['record_online_date']));

      $l_online_time = ($config['load_online_time'] == 1) ? 'VIEW_ONLINE_TIME' : 'VIEW_ONLINE_TIMES';
      $l_online_time = sprintf($user->lang[$l_online_time], $config['load_online_time']);
    }
    else {
      $l_online_time = '';
    }

    phpbb_load();

    $output['l_online_users'] = $l_online_users;
    $output['online_userlist'] = $online_userlist;

    if ($output_method == 'array') {
      return $output;
    }

    return theme_phpbb_api_whos_online($output, $options);
  }

  public function getStatistics($options = array('output_method' => '')) {
    $strreturn = '';
    if ($this->getStatus()) {
      return $strreturn;
    }

    global $phpbb_config, $phpbb_user, $phpbb_func, $phpbb_txt;
    global $db, $config, $template, $SID, $_SID, $user, $auth, $phpEx, $phpbb_root_path;

    extract($options, EXTR_SKIP);

    phpbb_save();

    //$this->authenticateUser();

    if (empty($user->session_id)) {
      // Start session management
      $user->session_begin();
      $auth->acl($user->data);
      $user->setup();
    }

    // Generate logged in/logged out status
    /*
     if ($user->data['user_id'] == ANONYMOUS) {
     phpbb_load();
     return $strreturn;
     }
     */
    $phpbb_url = $phpbb_config['forum_url'];

    // Set some stats, get posts count from forums data if we... hum... retrieve all forums data
    $total_posts	= $config['num_posts'];
    $total_topics	= $config['num_topics'];
    $total_users	= $config['num_users'];

    $l_total_user_s = ($total_users == 0) ? 'TOTAL_USERS_ZERO' : 'TOTAL_USERS_OTHER';
    $l_total_post_s = ($total_posts == 0) ? 'TOTAL_POSTS_ZERO' : 'TOTAL_POSTS_OTHER';
    $l_total_topic_s = ($total_topics == 0) ? 'TOTAL_TOPICS_ZERO' : 'TOTAL_TOPICS_OTHER';

    $total_posts = sprintf($user->lang[$l_total_post_s], $total_posts);
    $total_topics	= sprintf($user->lang[$l_total_topic_s], $total_topics);
    $total_users = sprintf($user->lang[$l_total_user_s], $total_users);
    $newest_user = sprintf($user->lang['NEWEST_USER'], get_username_string('full', $config['newest_user_id'], $config['newest_username'], $config['newest_user_colour']));

    phpbb_load();

    $output['total_posts'] = $total_posts;
    $output['total_topics'] = $total_topics;
    $output['total_users'] = $total_users;
    $output['newest_user'] = $newest_user;

    if ($output_method == 'array') {
      return $output;
    }

    return theme_phpbb_api_board_stats($output, $options);
  }

  /*
   public function isUserOnline($id = 0)
   {
   return parent::isUserOnline($id);
   }

   public function isUserActive($id = 0)
   {
   return parent::isUserActive($id);
   }

   public function isUserBanned($id = 0)
   {
   return parent::isUserBanned($id);
   }

   public function isUserBannedEmail($id = 0)
   {
   return parent::isUserBannedEmail($id);
   }

   public function isUserRegistered($id = 0)
   {
   return parent::isUserRegistered($id);
   }

   public function isUserUserGuest($id = 0)
   {
   return parent::isUserGuest($id);
   }

   public function isUserBot($id = 0)
   {
   return parent::isUserBot($id);
   }
   */
  //////////////////////
  public function validateUserName($username) {
    if (empty($username)) {
      return false;
    }

    global $phpbb_config, $config;

    phpbb_save();

    $check_data = array('username' => $username);
    $check_ary['username'] = array(
      array('string', false, $config['min_name_chars'], $config['max_name_chars']),
      array('username'),
    );
    $error = validate_data($check_data, $check_ary);

    phpbb_load();

    return !sizeof($error);
  }

  public function validateUserPassword($password, $username = '') {
    //drupal_set_message('pass='.$password.' status='.$this->getStatus());
    if ($this->getStatus() || empty($password)) {
      return false;
    }

    global $phpbb_config, $config;

    phpbb_save();

    $check_data = array('user_password' => $password);
    $check_ary = array(
      'user_password' => array(
        array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
        array('password'),
      ),
    );
    $error = validate_data($check_data, $check_ary);

    phpbb_load();

    //if (VBRIDGE_DEBUG)
//  drupal_set_message('pass='.$password.' error='.sizeof($error));

    return !sizeof($error);
  }

  public function validateUserEmail($email, $username = '') {
    if ($this->getStatus() || empty($email)) {
      return false;
    }

    global $phpbb_config, $config;

    phpbb_save();

    $check_data = array('user_email' => $email);
    $check_ary = array(
      'user_email' => array(
        array('string', false, 6, 60),
        array('email'),
      ),
    );
    $error = validate_data($check_data, $check_ary);

    phpbb_load();

    return !sizeof($error);
  }

  public function isValidEmail($email) {
    return $this->validateUserEmail($email, '');
  }

  public function isEmailInUse($email, $username = '') {
    if ($this->getStatus() || empty($email)) {
      return false;
    }

    return false;
  }

  public function isReservedName($name) {
    if (!$this->getStatus() || empty($name)) {
      return true;
    }

    return false;
  }
}
