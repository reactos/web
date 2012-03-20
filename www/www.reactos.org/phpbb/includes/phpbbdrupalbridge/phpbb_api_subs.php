<?php
// $Id: phpbb_api_subs.php,v 1.9 2010/02/20 11:01:26 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

if (!defined('IN_PHPBB')) {
  die('Hacking attempt...');
}

////////////////////////////////////////////////////////////////////

function phpbb_save($in_error = false) {
  global $_site_context_saved, $phpbb_user, $site_user, $user, $_site_error_handler;
  if (!$_site_context_saved) {
    $site_user = $user;
    $user = $phpbb_user;
    $_site_context_saved = true;
  }
}

function phpbb_load($in_error = false) {
  global $_site_context_saved, $phpbb_user, $site_user, $user, $_site_error_handler;
  if ($_site_context_saved) {
    $phpbb_user  = $user;
    $user = $site_user;
    $_site_context_saved = false;
  }
}

////////////////////////////////////////////////////////////////////

function phpbb_api_utf8($str) {
  global $phpbb_config;

  //if ($phpbb_config['lang_encoding'] !== 'utf-8' && function_exists('iconv'))
  //	$str = iconv($phpbb_config['lang_encoding'], 'UTF-8', $str);
  return $str;
}

function phpbb_api_charset($str) {
  global $phpbb_config;

  //if ($phpbb_config['lang_encoding'] !== 'utf-8' && function_exists('iconv'))
  //	$str = iconv('UTF-8', $phpbb_config['lang_encoding'], $str);
  return $str;
}

////////////////////////////////////////////////////////////////////

/**
 * Truncate a UTF-8-encoded string safely to a number of bytes.
 *
 * If the end position is in the middle of a UTF-8 sequence, it scans backwards
 * until the beginning of the byte sequence.
 *
 * Use this function whenever you want to chop off a string at an unsure
 * location. On the other hand, if you're sure that you're splitting on a
 * character boundary (e.g. after using strpos() or similar), you can safely use
 * substr() instead.
 *
 * @param $string
 *   The string to truncate.
 * @param $len
 *   An upper limit on the returned string length.
 * @param $wordsafe
 *   Flag to truncate at nearest space. Defaults to FALSE.
 * @return
 *   The truncated string.
 */
function phpbb_truncate_utf8($string, $len, $wordsafe = FALSE, $dots = FALSE) {

  $slen = utf8_strlen($string);

  // It was already short enough!
  if ($slen <= $len) {
    return $string;
  }

  if ($wordsafe) {
    $end = $len;
    while (($string[--$len] != ' ') && ($len > 0)) {
    }
    if ($len == 0) {
      $len = $end;
    }
  }
  if ((ord($string[$len]) < 0x80) || (ord($string[$len]) >= 0xC0)) {
    return utf8_substr($string, 0, $len) . ($dots ? '...' : '');
  }
  while (--$len >= 0 && ord($string[$len]) >= 0x80 && ord($string[$len]) < 0xC0) {
  }
  return utf8_substr($string, 0, $len) . ($dots ? '...' : '');
}

// Shorten a subject
function phpbb_shorten_subject($subject, $len) {
  return phpbb_truncate_utf8($subject, $len, false, true);
}

/**
 * Generate board url (example: http://www.example.com/phpBB)
 * @param bool $without_script_path if set to true the script path gets not appended (example: http://www.example.com)
 * @param bool $without_port if set to true the port gets not appended
 */
function phpbb_generate_board_url($without_script_path = false, $without_port = false) {
  global $config, $user;

  $server_name = $user->host;
  $server_port = (!empty($_SERVER['SERVER_PORT'])) ? (int) $_SERVER['SERVER_PORT'] : (int) getenv('SERVER_PORT');

  // Forcing server vars is the only way to specify/override the protocol
  if ($config['force_server_vars'] || !$server_name) {
    $server_protocol = ($config['server_protocol']) ? $config['server_protocol'] : (($config['cookie_secure']) ? 'https://' : 'http://');
    $server_name = $config['server_name'];
    $server_port = (int) $config['server_port'];
    $script_path = $config['script_path'];

    $url = $server_protocol . $server_name;
  }
  else {
    // Do not rely on cookie_secure, users seem to think that it means a secured cookie instead of an encrypted connection
    $cookie_secure = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 1 : 0;
    $url = (($cookie_secure) ? 'https://' : 'http://') . $server_name;

    $script_path = $user->page['root_script_path'];
  }

  if ($server_port && (($config['cookie_secure'] && $server_port <> 443) || (!$config['cookie_secure'] && $server_port <> 80))) {
    // HTTP HOST can carry a port number...
    if (!$without_port && strpos($server_name, ':') === false) {
      $url .= ':' . $server_port;
    }
  }

  if (!$without_script_path) {
    $url .= $script_path;
  }

  // Strip / from the end
  if (substr($url, -1, 1) == '/') {
    $url = substr($url, 0, -1);
  }

  return $url;
}

////////////////////////////////////////////////////////////////////

function phpbb_api_check_ban($user_id = false, $user_ips = false, $user_email = false) {
  phpbb_api_session_begin();
  global $phpbb_connection, $phpbb_config, $phpbb_user, $user, $auth;

  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();

  $is_banned = $user->check_ban($user_id, $user_ips, $user_email, true);

  phpbb_load();

  return $is_banned;
}


function phpbb_is_banned($user_id = false) {
  return phpbb_api_check_ban($user_id);
}

function phpbb_is_banned_email($email) {
  if (empty($email) || trim($email) == '' || strchr($email, '@') === false) {
    return false;
  }

  return phpbb_api_check_ban(false, false, $email);
}

////////////////////////////////////////////////////////////////////

// This function allows to register a new user.
function phpbb_register($username, $password, $email, $extra_data = array()) {
  global $phpbb_connection, $phpbb_db_prefix, $phpbb_config, $phpbb_user;
  global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;

  if (!$phpbb_connection) {
    return false;
  }

  include_once($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);

  $cp = new custom_profile();

  $error = $cp_data = $cp_error = array();

  // Try to manually determine the timezone and adjust the dst if the server date/time complies with the default setting +/- 1
  $timezone = date('Z') / 3600;
  $is_dst = date('I');

  if ($config['board_timezone'] == $timezone || $config['board_timezone'] == ($timezone - 1)) {
    $timezone = ($is_dst) ? $timezone - 1 : $timezone;

    if (!isset($user->lang['tz_zones'][(string) $timezone])) {
      $timezone = $config['board_timezone'];
    }
  }
  else {
    $is_dst = $config['board_dst'];
    $timezone = $config['board_timezone'];
  }

  $data = array(
    'username' => $username,
    'new_password' => $password,
    //'password_confirm'	=> $password,
    'email' => $email,
    //'email_confirm'		=> $email,
    //'confirm_code'		=> '',
    'lang' => basename($config['default_lang']),
    'tz' => (float) $timezone,
  );

  // Check and initialize some variables if needed
  $error = validate_data($data, array(
    'username' => array(
      array('string', false, $config['min_name_chars'], $config['max_name_chars']),
      array('username', ''),
    ),
    'new_password' => array(
      array('string', false, $config['min_pass_chars'], $config['max_pass_chars']),
      array('password'),
    ),
    //'password_confirm'	=> array('string', false, $config['min_pass_chars'], $config['max_pass_chars']),
    'email' => array(
      array('string', false, 6, 60),
      array('email'),
    ),
    //'email_confirm'		=> array('string', false, 6, 60),
    //'confirm_code'		=> array('string', !$config['enable_confirm'], 5, 8),
    'tz' => array('num', false, -14, 14),
    'lang' => array('match', false, '#^[a-z_\-]{2,}$#i'),
  ));


  // Replace "error" strings with their real, localised form
  $error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);

  //if (PHPBB_API_DEBUG)
  //drupal_set_message('phpBB user='.$username .' error: '. print_r($error, true));

  // DNSBL check
  if ($config['check_dnsbl']) {
    if (($dnsbl = $user->check_dnsbl('register')) !== false) {
      $error[] = sprintf($user->lang['IP_BLACKLISTED'], $user->ip, $dnsbl[1]);
    }
  }

  // validate custom profile fields
  $cp->submit_cp_field('register', $user->get_iso_lang_id(), $cp_data, $error);

  if (!sizeof($error)) {
    /*
     if ($data['new_password'] != $data['password_confirm'])
     {
     $error[] = $user->lang['NEW_PASSWORD_ERROR'];
     }

     if ($data['email'] != $data['email_confirm'])
     {
     $error[] = $user->lang['NEW_EMAIL_ERROR'];
     }
     */
    $phpbb_config['error_msg'] = "";
  }

  $user_id = 0;

  if (!sizeof($error)) {
    $server_url = generate_board_url();
    $phpbb_url = $phpbb_config['forum_url'];

    if (isset($extra_data['group_id'])) {
      $group_id = $extra_data['group_id'];
    }
    else {
      $group_id = 0;
    }

    if ($group_id == 0) {
      if (isset($extra_data['group_name'])) {
        $group_name = $extra_data['group_name'];
      }
      else {
        $group_name = 'REGISTERED';
      }

      $sql = 'SELECT group_id
        FROM ' . GROUPS_TABLE . "
        WHERE group_name = '" . $db->sql_escape($group_name) . "'
          AND group_type = " . GROUP_SPECIAL;
      $result = $db->sql_query($sql);
      $row = $db->sql_fetchrow($result);
      $db->sql_freeresult($result);

      if (!$row) {
        if ($group_name == 'REGISTERED') {
          //trigger_error('NO_GROUP');
          return false;
        }
        $group_name = 'REGISTERED';
        $sql = 'SELECT group_id
          FROM ' . GROUPS_TABLE . "
          WHERE group_name = '" . $db->sql_escape($group_name) . "'
            AND group_type = " . GROUP_SPECIAL;
        $result = $db->sql_query($sql);
        $row = $db->sql_fetchrow($result);
        $db->sql_freeresult($result);
        if (!$row) {
          //trigger_error('NO_GROUP');
          return false;
        }
      }

      $group_id = $row['group_id'];
    }
    /*
     if ((
     $config['require_activation'] == USER_ACTIVATION_SELF ||
     $config['require_activation'] == USER_ACTIVATION_ADMIN) && $config['email_enable'])
     {
     $user_actkey = gen_rand_string(10);
     $key_len = 54 - (strlen($server_url));
     $key_len = ($key_len < 6) ? 6 : $key_len;
     $user_actkey = substr($user_actkey, 0, $key_len);

     $user_type = USER_INACTIVE;
     $user_inactive_reason = INACTIVE_REGISTER;
     $user_inactive_time = time();
     }
     else
     {
     */
    $user_type = USER_NORMAL;
    $user_actkey = '';
    $user_inactive_reason = 0;
    $user_inactive_time = 0;
    //		}

    $user_row = array(
      'username' => $data['username'],
      'user_password' => md5($data['new_password']),
      'user_email' => $data['email'],
      'group_id' => (int) $group_id,
      'user_timezone' => (float) $data['tz'],
      'user_dst' => $is_dst,
      'user_lang' => $data['lang'],
      'user_type' => $user_type,
      'user_actkey' => $user_actkey,
      'user_ip' => $user->ip,
      'user_regdate' => time(),
      'user_inactive_reason' => $user_inactive_reason,
      'user_inactive_time' => $user_inactive_time,
    );

    // Register user...
    $user_id = user_add($user_row, $cp_data);

    // This should not happen, because the required variables are listed above...
    if ($user_id === false) {
      //$data = $extra_data + $data;

      //trigger_error('NO_USER', E_USER_ERROR);
      return false;
    }
  }

  if (!empty($user_id)) {
    $phpbb_config['new_user'] = array(
      'user_id' => $user_id,
      'username' => $phpbb_user->data['username'],
    );
  }

  $phpbb_user->data['user_id'] = $user_id;

  return !empty($user_id);
}

// Assumes the data has been slashed.
// update_user_data
function phpbb_update_user_data($user_id, $data) {
  global $phpbb_connection, $phpbb_db_prefix, $phpbb_config, $phpbb_user;
  global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;

  if (!$phpbb_connection || $user_id == 0) {
    return false;
  }

  $phpbb_url = $phpbb_config['forum_url'];

  $error = array();
  $s_hidden_fields = '';

  /*
   $datavars = array(
   'username',
   'user_email',
   );
   $data = array_intersect($data_vars, array_keys($data));
   */

  if (isset($data['username'])) {
    if ($auth->acl_get('u_chgname') && $config['allow_namechange']) {
      $check_data = array('username' => $data['username']);
      $check_ary['username'] = array(
        array('string', false, $config['min_name_chars'], $config['max_name_chars']),
        array('username'),
      );
      $error = validate_data($check_data, $check_ary);
      if (!sizeof($error)) {
        $data['username_clean'] = utf8_clean_string($data['username']);
      }
      else {
        unset($data['username']);
        unset($data['username_clean']);
      }
    }
    else {
      unset($data['username']);
      unset($data['username_clean']);
    }
  }

  if (isset($data['user_email'])) {
    if ($auth->acl_get('u_chgemail')) {
      $check_data = array('user_email' => $data['user_email']);
      $check_ary = array(
        'user_email' => array(
          array('string', false, 6, 60),
          array('email'),
        ),
      );
      $error = validate_data($check_data, $check_ary);
      if (!sizeof($error)) {
        $data['user_email_hash'] = crc32($data['user_email']) . strlen($data['user_email']);
      }
      else {
        unset($data['user_email']);
        unset($data['user_email_hash']);
      }
    }
    else {
      unset($data['user_email']);
      unset($data['user_email_hash']);
    }
  }

  if (isset($data['user_password'])) {
    if ($auth->acl_get('u_chgpasswd') || $user_id != 2) {
      $check_data = array('user_password' => $data['user_password']);
      $check_ary = array(
        'user_password' => array(
          array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
          array('password'),
        ),
      );
      $error = validate_data($check_data, $check_ary);
      if (!sizeof($error)) {
        //$data['user_password'] = md5($data['user_password']);
        $data['user_password'] = phpbb_hash($data['user_password']);
        $data['user_passchg'] = time();
      }
      else {
        unset($data['user_password']);
        unset($data['user_passchg']);
      }
    }
    else {
      unset($data['user_password']);
      unset($data['user_passchg']);
    }
  }

  // custom profile fields
  $cdata = array();
  foreach ($data as $pf_name => $val) {
    $pos = strpos($pf_name, 'pf_');
    if ($pos !== false && $pos == 0) {
      $cdata[$pf_name] = $val;
      $_REQUEST[$pf_name] = $val;
      unset($data[$pf_name]);
    }
  }

  /*
   if (PHPBB_API_DEBUG)
   drupal_set_message('phpBB user id='.$phpbb_user->data['user_id'] .' update data error: '. print_r($error, true));
   if (PHPBB_API_DEBUG)
   drupal_set_message('phpBB user id='.$phpbb_user->data['user_id'] .' update data: '. print_r($data, true));
   */
  $error = array();

  /*
   $data = array(
   'username'			=> utf8_normalize_nfc(request_var('username', $user->data['username'], true)),
   'email'				=> strtolower(request_var('email', $user->data['user_email'])),
   'email_confirm'		=> strtolower(request_var('email_confirm', '')),
   'new_password'		=> request_var('new_password', '', true),
   'cur_password'		=> request_var('cur_password', '', true),
   'password_confirm'	=> request_var('password_confirm', '', true),
   );
   // Do not check cur_password, it is the old one.
   $check_ary = array(
   'new_password'		=> array(
   array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
   array('password')),
   'password_confirm'	=> array('string', true, $config['min_pass_chars'], $config['max_pass_chars']),
   'email'				=> array(
   array('string', false, 6, 60),
   array('email')),
   'email_confirm'		=> array('string', true, 6, 60),
   );

   if ($auth->acl_get('u_chgname') && $config['allow_namechange'])
   {
   $check_ary['username'] = array(
   array('string', false, $config['min_name_chars'], $config['max_name_chars']),
   array('username'),
   );
   }

   $error = validate_data($data, $check_ary);

   if ($auth->acl_get('u_chgpasswd') && $data['new_password'] && $data['password_confirm'] != $data['new_password'])
   {
   $error[] = 'NEW_PASSWORD_ERROR';
   }

   if (($data['new_password'] || ($auth->acl_get('u_chgemail') && $data['email'] != $user->data['user_email']) || ($data['username'] != $user->data['username'] && $auth->acl_get('u_chgname') && $config['allow_namechange'])) && md5($data['cur_password']) != $user->data['user_password'])
   {
   $error[] = 'CUR_PASSWORD_ERROR';
   }

   // Only check the new password against the previous password if there have been no errors
   if (!sizeof($error) && $auth->acl_get('u_chgpasswd') && $data['new_password'] && md5($data['new_password']) == $user->data['user_password'])
   {
   $error[] = 'SAME_PASSWORD_ERROR';
   }

   if ($auth->acl_get('u_chgemail') && $data['email'] != $user->data['user_email'] && $data['email_confirm'] != $data['email'])
   {
   $error[] = 'NEW_EMAIL_ERROR';
   }

   if (!sizeof($error))
   {
   $sql_ary = array(
   'username'			=> ($auth->acl_get('u_chgname') && $config['allow_namechange']) ? $data['username'] : $user->data['username'],
   'username_clean'	=> ($auth->acl_get('u_chgname') && $config['allow_namechange']) ? utf8_clean_string($data['username']) : $user->data['username_clean'],
   'user_email'		=> ($auth->acl_get('u_chgemail')) ? $data['email'] : $user->data['user_email'],
   'user_email_hash'	=> ($auth->acl_get('u_chgemail')) ? crc32($data['email']) . strlen($data['email']) : $user->data['user_email_hash'],
   'user_password'		=> ($auth->acl_get('u_chgpasswd') && $data['new_password']) ? md5($data['new_password']) : $user->data['user_password'],
   'user_passchg'		=> ($auth->acl_get('u_chgpasswd') && $data['new_password']) ? time() : 0,
   );

   if ($auth->acl_get('u_chgname') && $config['allow_namechange'] && $data['username'] != $user->data['username'])
   {
   add_log('user', $user->data['user_id'], 'LOG_USER_UPDATE_NAME', $user->data['username'], $data['username']);
   }

   if ($auth->acl_get('u_chgpasswd') && $data['new_password'] && md5($data['new_password']) != $user->data['user_password'])
   {
   $user->reset_login_keys();
   add_log('user', $user->data['user_id'], 'LOG_USER_NEW_PASSWORD', $data['username']);
   }

   if ($auth->acl_get('u_chgemail') && $data['email'] != $user->data['user_email'])
   {
   add_log('user', $user->data['user_id'], 'LOG_USER_UPDATE_EMAIL', $data['username'], $user->data['user_email'], $data['email']);
   }

   if (sizeof($sql_ary))
   {
   $sql = 'UPDATE ' . USERS_TABLE . '
   SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
   WHERE user_id = ' . $user->data['user_id'];
   $db->sql_query($sql);
   }

   // Need to update config, forum, topic, posting, messages, etc.
   if ($data['username'] != $user->data['username'] && $auth->acl_get('u_chgname') && $config['allow_namechange'])
   {
   user_update_name($user->data['username'], $data['username']);
   }
   }
   */

  if (!sizeof($error)) {
    $sql_ary = $data;

    if (sizeof($sql_ary)) {
      $sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . $user_id;
      $db->sql_query($sql);
    }

    // Update Custom Fields
    if (sizeof($cdata)) {
      include_once($phpbb_root_path . 'includes/functions_profile_fields.' . $phpEx);

      $cp = new custom_profile();

      $cp_data = $cp_error = array();
      // validate custom profile fields
      $cp->submit_cp_field('profile', $user->get_iso_lang_id(), $cp_data, $cp_error);

      if (sizeof($cp_error)) {
        $error = array_merge($error, $cp_error);
      }
      // Update Custom Fields
      if (sizeof($cp_data)) {
        foreach ($cdata as $pf_name => $val) {
          $cdata[$pf_name] = $cp_data[$pf_name];
        }

        $sql = 'UPDATE ' . PROFILE_FIELDS_DATA_TABLE . '
          SET ' . $db->sql_build_array('UPDATE', $cdata) . '
          WHERE user_id = ' . $user_id;
        $db->sql_query($sql);

        if (!$db->sql_affectedrows()) {
          $cp_data['user_id'] = (int) $user_id;

          $db->sql_return_on_error(true);

          $sql = 'INSERT INTO ' . PROFILE_FIELDS_DATA_TABLE . ' ' . $db->sql_build_array('INSERT', $cp_data);
          $db->sql_query($sql);

          $db->sql_return_on_error(false);
        }
      }
    }
    // Need to update config, forum, topic, posting, messages, etc.
    if (isset($data['username']) && !empty($data['username']) && $data['username'] != $user->data['username'] && $auth->acl_get('u_chgname') && $config['allow_namechange']) {
      user_update_name($user->data['username'], $data['username']);
      // Because the user gets deactivated we log him out too, killing his session
      //$user->session_kill();
    }

  }
  return true;
}


// Remove avatar
function phpbb_remove_avatar($user_id, $filename, $clean_db = false) {
  phpbb_api_session_begin();
  global $phpbb_connection, $phpbb_user, $phpbb_root_path, $phpbb_config;

  if (!$phpbb_connection) {
    return false;
  }
  if ($user_id == 0) {
    return false;
  }

  // Check if the users avatar is actually *not* a group avatar
  if (strpos($filename, 'g') === 0 || (((int) $filename !== 0) && ((int) $filename !== (int) $user_id))) {
    return false;
  }

  if ($clean_db) {
    avatar_remove_db($filename);
  }
  $filename = get_avatar_filename($filename);
  $upload_filename = $phpbb_root_path . $phpbb_config['avatar_path'] . '/' . $filename;
  if (file_exists($upload_filename)) {
    @unlink($upload_filename);
    return true;
  }

  return false;
}

//
function phpbb_update_avatar($user_id, $user_avatar, $user_avatar_type, $user_avatar_width, $user_avatar_height, &$error, $custom_userdata = false) {
  phpbb_api_session_begin();
  global $phpbb_connection, $phpbb_config, $phpbb_user, $config, $phpbb_root_path, $auth, $user, $db;

  if (!$phpbb_connection) {
    return false;
  }
  if ($user_id == 0) {
    return false;
  }

  $data = array(
    'uploadurl' => $user_avatar,
    'remotelink' => $user_avatar,
    'width' => $user_avatar_width,
    'height' => $user_avatar_height,
  );

  $error = array();

  /*
   $error = validate_data($data, array(
   'uploadurl'		=> array('string', true, 5, 255),
   'remotelink'	=> array('string', true, 5, 255),
   'width'			=> array('string', true, 1, 3),
   'height'		=> array('string', true, 1, 3),
   ));

   if (sizeof($error))
   {
   return false;
   }
   */

  $sql_ary = array();

  $sql_ary['user_avatar'] = $user_avatar;
  $sql_ary['user_avatar_type'] = $user_avatar_type;
  $sql_ary['user_avatar_width'] = $user_avatar_width;
  $sql_ary['user_avatar_height'] = $user_avatar_height;

  phpbb_save();

  if ($custom_userdata === false) {
    $userdata = &$user->data;
  }
  else {
    $userdata = &$phpbb_user->data;
  }

  $data['user_id'] = $userdata['user_id'];
  $change_avatar = ($custom_userdata === false) ? $auth->acl_get('u_chgavatar') : true;
  $avatar_select = basename($user_avatar);

  // Can we upload?
  $can_upload = ($config['allow_avatar_upload'] && file_exists($phpbb_root_path . $config['avatar_path']) && @is_writable($phpbb_root_path . $config['avatar_path']) && $change_avatar && (@ini_get('file_uploads') || strtolower(@ini_get('file_uploads')) == 'on')) ? true : false;

  /*if ((!empty($_FILES['uploadfile']['name']) || $data['uploadurl']) && $can_upload)
   {
   list($sql_ary['user_avatar_type'], $sql_ary['user_avatar'], $sql_ary['user_avatar_width'], $sql_ary['user_avatar_height']) = avatar_upload($data, $error);
   }
   else if ($data['remotelink'] && $change_avatar && $config['allow_avatar_remote'])
   {
   list($sql_ary['user_avatar_type'], $sql_ary['user_avatar'], $sql_ary['user_avatar_width'], $sql_ary['user_avatar_height']) = avatar_remote($data, $error);
   }
   else if ($avatar_select && $change_avatar && $config['allow_avatar_local'])
   {
   $category = basename(request_var('category', ''));

   $sql_ary['user_avatar_type'] = AVATAR_GALLERY;
   $sql_ary['user_avatar'] = $avatar_select;

   // check avatar gallery
   if (!is_dir($phpbb_root_path . $config['avatar_gallery_path'] . '/' . $category))
   {
   $sql_ary['user_avatar'] = '';
   $sql_ary['user_avatar_type'] = $sql_ary['user_avatar_width'] = $sql_ary['user_avatar_height'] = 0;
   }
   else
   {
   list($sql_ary['user_avatar_width'], $sql_ary['user_avatar_height']) = getimagesize($phpbb_root_path . $config['avatar_gallery_path'] . '/' . $category . '/' . $sql_ary['user_avatar']);
   $sql_ary['user_avatar'] = $category . '/' . $sql_ary['user_avatar'];
   }
   }
   else
   */

  if ($user_avatar_type == 0 && $change_avatar) {
    $sql_ary['user_avatar'] = '';
    $sql_ary['user_avatar_type'] = $sql_ary['user_avatar_width'] = $sql_ary['user_avatar_height'] = 0;
  }
  else if (!empty($userdata['user_avatar'])) {
    // Only update the dimensions

    if (empty($data['width']) || empty($data['height'])) {
      if ($dims = avatar_get_dimensions($userdata['user_avatar'], $userdata['user_avatar_type'], $error, $data['width'], $data['height'])) {
        list($guessed_x, $guessed_y) = $dims;
        if (empty($data['width'])) {
          $data['width'] = $guessed_x;
        }
        if (empty($data['height'])) {
          $data['height'] = $guessed_y;
        }
      }
    }
    if (($config['avatar_max_width'] || $config['avatar_max_height']) &&
			(($data['width'] != $userdata['user_avatar_width']) || $data['height'] != $userdata['user_avatar_height'])) {
      if ($data['width'] > $config['avatar_max_width'] || $data['height'] > $config['avatar_max_height']) {
        $error[] = sprintf($user->lang['AVATAR_WRONG_SIZE'], $config['avatar_min_width'], $config['avatar_min_height'], $config['avatar_max_width'], $config['avatar_max_height'], $data['width'], $data['height']);
      }
    }

    if (!sizeof($error)) {
      if ($config['avatar_min_width'] || $config['avatar_min_height']) {
        if ($data['width'] < $config['avatar_min_width'] || $data['height'] < $config['avatar_min_height']) {
          $error[] = sprintf($user->lang['AVATAR_WRONG_SIZE'], $config['avatar_min_width'], $config['avatar_min_height'], $config['avatar_max_width'], $config['avatar_max_height'], $data['width'], $data['height']);
        }
      }
    }

    if (!sizeof($error)) {
      $sql_ary['user_avatar_width'] = $data['width'];
      $sql_ary['user_avatar_height'] = $data['height'];
    }
  }

  if (!sizeof($error)) {
    // Do we actually have any data to update?
    if (sizeof($sql_ary)) {
      $sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . (($custom_userdata === false) ? $user->data['user_id'] : $phpbb_user->data['user_id']);
      $db->sql_query($sql);

      if (isset($sql_ary['user_avatar'])) {
        $userdata = ($custom_userdata === false) ? $user->data : $phpbb_user->data;

        // Delete old avatar if present
        if ($user_avatar_type == 0 && $change_avatar && $userdata['user_avatar_type'] && $userdata['user_avatar_type'] != AVATAR_GALLERY
				 //   (!empty($userdata['user_avatar']) && empty($sql_ary['user_avatar']) && $userdata['user_avatar_type'] == AVATAR_UPLOAD)
				 //  || ( !empty($userdata['user_avatar']) && !empty($sql_ary['user_avatar']) && $userdata['user_avatar_type'] == AVATAR_UPLOAD && $sql_ary['user_avatar_type'] != AVATAR_UPLOAD)
				   ) {
          avatar_delete('user', $userdata);
        }
      }
    }
  }

  phpbb_load();
  return (sizeof($error)) ? false : true;

  /*
   $upload_filename = $phpbb_root_path . $phpbb_config['avatar_path'] . '/' . $filename;
   if (file_exists($upload_filename)) {
   list ($width, $height, $type) = @getimagesize($upload_filename);


   }
   return true;
   */
}

/**
 * Get group name
 */
function phpbb_get_user_group_name($group_id) {
  phpbb_api_session_begin();
  global $phpbb_connection;
  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();

  $group_name = get_group_name($group_id);

  phpbb_load();

  return $group_name;
}

function phpbb_get_user_group_id($group_name = 'REGISTERED') {
  phpbb_api_session_begin();
  global $phpbb_connection, $db;
  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();

  $sql = 'SELECT group_id
    FROM ' . GROUPS_TABLE . "
    WHERE group_name = '" . $db->sql_escape($group_name) . "'
      AND group_type = " . GROUP_SPECIAL;
  $result = $db->sql_query($sql);
  $row = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);

  if ($row) {
    $group_id = $row['group_id'];
  }
  else {
    $group_id = 0;
  }

  phpbb_load();

  return $group_id;
}

function phpbb_get_user_all_groups($group_types = 0) {
  phpbb_api_session_begin();
  global $phpbb_connection, $user, $db;

  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();

  // Get us all the groups
  $sql = 'SELECT g.group_id, g.group_name, g.group_type
    FROM ' . GROUPS_TABLE . ' g
    ORDER BY g.group_type ASC, g.group_name';
  $result = $db->sql_query($sql);

  $lookup = $group_data = array();
  while ($row = $db->sql_fetchrow($result)) {
    $type = ($row['group_type'] == GROUP_SPECIAL) ? 'special' : 'normal';

    // used to determine what type a group is
    $lookup[$row['group_id']] = $type;

    // used for easy access to the data within a group
    $group_data[$type][$row['group_id']] = $row;
    $group_data[$type][$row['group_id']]['total_members'] = 0;
  }
  $db->sql_freeresult($result);

  // How many people are in which group?
  $sql = 'SELECT COUNT(ug.user_id) AS total_members, ug.group_id
    FROM ' . USER_GROUP_TABLE . ' ug
    WHERE ' . $db->sql_in_set('ug.group_id', array_keys($lookup)) . '
    GROUP BY ug.group_id';
  $result = $db->sql_query($sql);

  while ($row = $db->sql_fetchrow($result)) {
    $type = $lookup[$row['group_id']];
    $group_data[$type][$row['group_id']]['total_members'] = $row['total_members'];
  }
  $db->sql_freeresult($result);

  // The order is... normal, then special
  ksort($group_data);

  foreach ($group_data as $type => $row_ary) {
    if ($type == 'special') {
    }

    foreach ($row_ary as $group_id => $row) {
      $group_name = (!empty($user->lang['G_' . $row['group_name']])) ? $user->lang['G_' . $row['group_name']] : $row['group_name'];

      //($row['group_type'] == GROUP_SPECIAL) ? true : false,

      //$row['total_members'],
    }
  }

  phpbb_load();
  return $group_data;
}

/**
 * phpbb_api_group_user_add
 */
function phpbb_api_group_user_add($group_id, $user_id_ary = false, $username_ary = false, $group_name = false, $default = false, $leader = 0, $pending = 0, $group_attributes = false) {
  phpbb_api_session_begin();
  global $phpbb_connection;
  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();
  $result = group_user_add($group_id, $user_id_ary, $username_ary, $group_name, $default, $leader, $pending, $group_attributes);
  phpbb_load();

  return $result;
}

/**
 * phpbb_api_group_user_del
 */
function phpbb_api_group_user_del($group_id, $user_id_ary = false, $username_ary = false, $group_name = false) {
  phpbb_api_session_begin();
  global $phpbb_connection;
  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();
  $result = group_user_del($group_id, $user_id_ary, $username_ary, $group_name);
  phpbb_load();

  return $result;
}

/**
 * phpbb_api_group_memberships
 */
function phpbb_api_group_memberships($group_id_ary = false, $user_id_ary = false, $return_bool = false) {
  phpbb_api_session_begin();
  global $phpbb_connection;
  if (!$phpbb_connection) {
    return false;
  }

  phpbb_save();
  $result = group_memberships($group_id_ary, $user_id_ary, $return_bool);
  phpbb_load();

  return $result;
}


/**
 * phpbb_api_submit_post
 */
function phpbb_api_submit_post($mode, $subject, $username, $topic_type, &$poll, &$data, $update_message = true) {
  phpbb_api_session_begin();
  phpbb_save();
  $url = submit_post($mode, $subject, $username, $topic_type, $poll, $data, $update_message);
  phpbb_load();

  return $url;
}

/**
 * _phpbb_get_style_table
 */
function _phpbb_get_style_table($mode) {
  switch ($mode) {
    case 'style':
      $sql_from = STYLES_TABLE;
      break;

    case 'template':
      $sql_from = STYLES_TEMPLATE_TABLE;
      break;

    case 'theme':
      $sql_from = STYLES_THEME_TABLE;
      break;

    case 'imageset':
      $sql_from = STYLES_IMAGESET_TABLE;
      break;

    default:
      $sql_from = STYLES_TABLE;
      break;
  }

  return $sql_from;
}

/**
 * phpbb_get_style_name
 */
function phpbb_get_style_name($mode, $style_id) {
  $sql_from = _phpbb_get_style_table($mode);

  phpbb_api_session_begin();
  global $db;

  $sql = "SELECT style_name
    FROM $sql_from
    WHERE {$mode}_id = $style_id";
  $result = $db->sql_query($sql);
  $style_row = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);

  if (!$style_row) {
    return '';
  }

  return $style_row['style_name'];
}

/**
 * phpbb_get_style_id
 */
function phpbb_get_style_id($mode, $style_name) {
  $sql_from = _phpbb_get_style_table($mode);

  phpbb_api_session_begin();
  global $db;

  $sql = "SELECT style_id
    FROM $sql_from
    WHERE {$mode}_name = \"$style_name\"";
  $result = $db->sql_query($sql);
  $style_row = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);

  if (!$style_row /* || $style_row['style_active'] == 0*/) {
    return 0;
  }

  return $style_row['style_id'];
}
