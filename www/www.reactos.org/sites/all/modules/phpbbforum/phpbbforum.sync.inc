<?php
// $Id: phpbbforum.a_sync.inc,v 1.1 2009/02/27 21:10:26 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_update_user($op, $sync, &$account, $name, $pass, $mail, $edit = array()) {
  global $phpbb_config, $phpbb_user, $user;

  $update = false;

  $has_profile = module_exists('profile');
  //$has_profile2 = false;//module_exists('profile2');
  $has_profile2 = module_exists('profile2');
  //$has_content_profile = true;
  //if (!$has_profile2) {
  //  $content_profile = $account;
  //}

  $syncto = $sync;
  if ($sync == PHPBB_SYNC_TO_MASTER) {
    $phpbb_master = variable_get('phpbbforum_master', 1);
    if ($phpbb_master) {
      $syncto = PHPBB_SYNC_TO_DRUPAL;
    }
    else {
      $syncto = PHPBB_SYNC_TO_PHPBB;
    }
  }

  $data = array();
  //$data = _phpbbforum_set_user_data($op, $syncto, $account, $name, $pass, $mail, $edit);
  if ($op == 'insert') {
    $data = _phpbbforum_set_user_data('update', $syncto, $account, $name, $pass, $mail, $edit);
  }  
  else {
    $data = _phpbbforum_set_user_data($op, $syncto, $account, $name, $pass, $mail, $edit);
  }  

  if (empty($pass) || $syncto == PHPBB_SYNC_TO_DRUPAL || count($edit) != 0) {

    $profile_data = array();
    if ($has_profile) {
      $profile_data = _phpbbforum_set_user_profile_data($op, $syncto, $account, $profile_data);
    }
    else {
      $profile_data = _phpbbforum_set_user_profile2_data($op, $syncto, $account, $profile_data);
    }
    if ($has_profile2) {
      $profile_data2 = array();
      foreach (profile2_get_types() as $type => $profile_type) {
        if (($profile = profile2_load_by_user($account, $type))) {
          $content_profile_changed = false;
          $profile_data2 = _phpbbforum_set_user_profile2_data($op, $syncto, $profile, $profile_data2, $has_profile2);
          $content_profile_changed = $profile_data2['content_profile'];
          unset($profile_data2['content_profile']);
          if ($content_profile_changed) {
            if ($syncto == PHPBB_SYNC_TO_DRUPAL) {
              profile2_save($profile);
            }
            else {
              $profile_data += $profile_data2;
            }
          }
        }
      }
    }

    if ($syncto == PHPBB_SYNC_TO_DRUPAL && count($profile_data) != 0) {
      //if (PHPBB_MODULE_DEBUG)
      //drupal_set_message('PHPBB_user before update profile data'. print_r($profile_data, true));
      if ($has_profile) {
        _phpbbforum_profile_save_profile_data0($profile_data, $account);
      }
      /*elseif ($has_profile2) {
        foreach (profile2_get_types() as $type => $profile_type) {
          if (($profile = profile2_load_by_user($account, $type))) {
            profile2_save($profile);
          }
        }

      }*/
    }

    $data += $profile_data;
  }

  // Update data
  //if (PHPBB_MODULE_DEBUG)
  //drupal_set_message('phpBB user id='.$phpbb_user->data['user_id'] .' before update data'. print_r($data, true));

  if (count($data) != 0 || !empty($pass)) {
    if ($syncto == PHPBB_SYNC_TO_PHPBB) {
      $update = phpbb_api_update_user($phpbb_user->data['user_id'], $name, $pass, $mail, $data);
    }
    else {
      if ($op == 'login2' || (($op == 'view' || $op == 'categories') && $user->name != $account->name)) {
        user_save($account, $data, 'login');
      }
      else {
        $user = user_save($account, $data, 'login');
      }
      $update = true;
    }
    if (variable_get("phpbbforum_set_msg", 0)) {
      _phpbbforum_msg('update', $update, '', $syncto, $account, $data);
    }
  }

  return $update;
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_update_user_profile($op, $sync, &$account, $data = array(), $content_profile = null) {
  global $phpbb_config, $phpbb_user, $user;

  $update = false;

  $has_profile = module_exists('profile');
  //$has_profile2 = false;//module_exists('profile2');
  $has_profile2 = module_exists('profile2');
  //$has_content_profile = true;
  //if (!$has_profile2) {
  //  $content_profile = $account;
  //}

/*
  if (!$has_profile && !$has_profile2 && !$has_content_profile) {
    return $update;
  }
*/
  $syncto = $sync;
  if ($sync == PHPBB_SYNC_TO_MASTER) {
    $phpbb_master = variable_get('phpbbforum_master', 1);
    if ($phpbb_master) {
      $syncto = PHPBB_SYNC_TO_DRUPAL;
    }
    else {
      $syncto = PHPBB_SYNC_TO_PHPBB;
    }
  }

  /*
  if ($has_content_profile) {
    if ($syncto == PHPBB_SYNC_TO_PHPBB) {
      if (is_object($content_profile)) {
        $has_profile = false;
      }
      else {
        $has_content_profile = false;
      }
    }
    else {
      foreach (profile2_get_types() as $type => $type_name) {
        $content_profile = content_profile_load($type, $account->uid);
        if (!is_object($content_profile)) {
          continue;
        }
        $content_profile_changed = false;
        $data = array();
        $data = _phpbbforum_set_user_profile_data($op, $syncto, $account, $data, $has_profile, $has_content_profile, $content_profile);
        if (count($data) != 0) {
          if ($syncto == PHPBB_SYNC_TO_PHPBB) {
            $update = phpbb_api_update_user($phpbb_user->data['user_id'], '', '', '', $data);
          }
          else {
            $content_profile_changed = $data['content_profile'];
            unset($data['content_profile']);
            if (count($data) != 0) {
              if ($op == 'login2' || (($op == 'view' || $op == 'categories') && $user->name != $account->name)) {
                user_save($account, $data, 'login');
              }
              else {
                $user = user_save($account, $data, 'login');
              }
              $update = true;
              if (variable_get("phpbbforum_set_msg", 0)) {
                _phpbbforum_msg('update', $update, 'profile', $syncto, $account, $data);
              }
            }

            if ($content_profile_changed) {
              node_save($content_profile);
              $update = true;
              if (variable_get("phpbbforum_set_msg", 0)) {
                _phpbbforum_msg('update', $update, 'content_profile', $syncto, $account, $data);
              }
            }
          }

        }
      }
      return $update;
    }

  }

  $content_profile_changed = false;
  if ($has_profile2) {
      foreach (profile2_get_types() as $type => $profile_type) {
        if (($profile = profile2_load_by_user($account, $type))) {
          $content_profile_changed = false;
          $profile_data = _phpbbforum_set_user_profile2_data($op, $syncto, $profile, $profile_data, $has_profile2);
          $content_profile_changed = $profile_data['content_profile'];
          unset($profile_data['content_profile']);
          if ($content_profile_changed) {
            profile2_save($profile);
          }
        }
      }
    }
  */

  $profile_data = array();
  if ($has_profile) {
    $profile_data = _phpbbforum_set_user_profile_data($op, $syncto, $account, $profile_data);
  }
  else {
    $profile_data = _phpbbforum_set_user_profile2_data($op, $syncto, $account, $profile_data);
  }
  if ($has_profile2) {
    $profile_data2 = array();
    foreach (profile2_get_types() as $type => $profile_type) {
      if (($profile = profile2_load_by_user($account, $type))) {
        $content_profile_changed = false;
        $profile_data2 = _phpbbforum_set_user_profile2_data($op, $syncto, $profile, $profile_data2, $has_profile2);
        $content_profile_changed = $profile_data2['content_profile'];
        unset($profile_data2['content_profile']);
        if ($content_profile_changed) {
          if ($syncto == PHPBB_SYNC_TO_DRUPAL) {
            profile2_save($profile);
          }
          else {
            $profile_data += $profile_data2;
          }
        }
      }
    }
  }
  if (count($profile_data) != 0) {
    if ($syncto == PHPBB_SYNC_TO_PHPBB) {
      $update = phpbb_api_update_user($phpbb_user->data['user_id'], '', '', '', $profile_data);
    }
    else {
      if ($op == 'login2' || (($op == 'view' || $op == 'categories') && $user->name != $account->name)) {
        user_save($account, $profile_data, 'login');
      }
      else {
        $user = user_save($account, $profile_data, 'login');
      }
      $update = true;
    }
    if (variable_get("phpbbforum_set_msg", 0)) {
      _phpbbforum_msg('update', $update, 'profile', $syncto, $account, $profile_data);
    }
  }

  return $update;
}

function _phpbbforum_set_user_data($op, $sync, &$account, $name, $pass, $mail, $edit) {
  global $phpbb_user, $phpbb_config, $base_url, $phpbb_root_path, $phpEx;

  $sync_to_admin = false;
  if ($sync == PHPBB_SYNC_TO_PHPBB) {
    if ($phpbb_user->data['user_id'] == variable_get('phpbbforum_admin_user_id', 2)) {
      $sync_to_admin = true;
    }
  }
  elseif ($account->uid == 1) {
    $sync_to_admin = true;
  }

  $data = array();

  if (!$sync_to_admin) {
    // not for admin
    $sync_data = true;
    if (!empty($name)) {
      if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
        if (isset($edit['name'])) {
          $val = $edit['name'];
        }
        else {
          $sync_data = false;
        }
      }
      else {
        $val = $account->name;
      }
      $val2 = $phpbb_user->data['username'];
      if ($sync_data && $val != $val2) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          $data += array('username' => $val);
        }
        elseif (!empty($val2)) {
          $data += array('name' => $val2);
        }
      }
    }

    if (!empty($pass)) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_password' => $pass);
      }
      else {
        $data += array('pass' => $pass);
      }
    }

    $sync_data = true;
    if (!empty($mail)) {
      if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
        if (isset($edit['mail'])) {
          $val = $edit['mail'];
        }
        else {
          $sync_data = false;
        }
      }
      else {
        $val = $account->mail;
      }

      if ($sync_data && $val != $phpbb_user->data['user_email']) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          $data += array('user_email' => $mail);
        }
        else {
          if (!empty($phpbb_user->data['user_email'])) {
            $data += array('mail' => $phpbb_user->data['user_email']);
          }
        }
      }
    }
  }

  //if ($sync == PHPBB_SYNC_TO_DRUPAL || count($edit) != 0) {
  // Group sync
  if (variable_get('phpbbforum_user_roles_sync', 0)) {
    $user_id = $phpbb_user->data['user_id'];

    $user_roles = user_roles(TRUE);
    unset($user_roles[DRUPAL_AUTHENTICATED_RID]);

    if (count($user_roles)) {
      $roles = array();
      $sync_data = true;
      $sync_edit_data = false;
      if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
        if (isset($edit['roles'])) {
          $roles = $edit['roles'];
          $sync_edit_data = true;
        }
        else {
          $sync_data = false;
        }
      }
      else {
        $roles = $account->roles;
      }

      //$old_roles = $account->roles;
      $old_roles = $account->original->roles;
      unset($old_roles[DRUPAL_AUTHENTICATED_RID]);
      unset($old_roles[DRUPAL_ANONYMOUS_RID]);

      unset($roles[DRUPAL_AUTHENTICATED_RID]);
      unset($roles[DRUPAL_ANONYMOUS_RID]);
      $new_roles = $roles;

      $roles_is_added = false;
      $roles_is_deleted = false;
      $roles_is_equal = false;

      $roles_added = array();
      $roles_deleted = array();

      if (count($new_roles) > count($old_roles)) {
        $roles_is_added = true;
        foreach ($new_roles as $rid => $rname) {
          if (empty($old_roles[$rid])) {
            $roles_added[$rid] = $user_roles[$rid];
          }
        }
        $roles_updated = $roles_added;
      }
      elseif (count($new_roles) < count($old_roles)) {
        $roles_is_deleted = true;
        foreach ($old_roles as $rid => $rname) {
          if (empty($new_roles[$rid])) {
            $roles_deleted[$rid] = $user_roles[$rid];
          }
        }
        $roles_updated = $roles_deleted;
      }
      else {
        $roles_is_equal = true;
        $roles_updated = $new_roles;
      }

      if ($sync_data && ($sync != PHPBB_SYNC_TO_PHPBB || !$roles_is_equal || $sync_edit_data)) {

        $group_roles = array();

        foreach ($roles_updated as $rid => $rname) {
          $group_ids = variable_get('phpbbforum_map_user_role_' . $rid, 0);
          if (!empty($group_ids)) {
            $group_id_ary = array();
            foreach ($group_ids as $group_id => $group_id_name) {
              if (!empty($group_id_name)) {
                $group_id_ary[$group_id] = $group_id_name;
              }
            }
            if (!empty($group_id_ary)) {
              $group_roles[$rid] = $group_id_ary;
            }
          }
        }

        $phpbb_group_id_ary = array();
        $phpbb_group_row = phpbb_api_group_memberships(false, $user_id);
        if (!empty($phpbb_group_row)) {
          foreach ($phpbb_group_row as $id => $row) {
            $group_id = $row['group_id'];
            $phpbb_group_id_ary[$group_id] = $group_id;
          }
        }

        if ($sync == PHPBB_SYNC_TO_PHPBB) {

          $group_id_default = phpbb_get_user_group_id('REGISTERED');

          if ($roles_is_deleted) {
            // Delete user from group
            $group_del = array();

            foreach ($group_roles as $rid => $group_id_ary) {
              foreach ($group_id_ary as $group_id => $group_id_name) {
                if (!empty($phpbb_group_id_ary[$group_id])) {
                  if ($group_id == $group_id_default || ($user_id == variable_get('phpbbforum_admin_user_id', 2) && ($group_id == 4 || $group_id == 5))) {
                    continue;
                  }
                  $group_del[$group_id] = $group_id;
                }
              }
            }
            foreach ($group_del as $group_id) {
              $error = phpbb_api_group_user_del($group_id, $user_id);
            }
          }
          else {
            // Add user to group
            $group_add = array();
            foreach ($group_roles as $rid => $group_id_ary) {
              foreach ($group_id_ary as $group_id => $group_id_name) {
                if (empty($phpbb_group_id_ary[$group_id])) {
                  $group_add[$group_id] = $group_id;
                }
              }
            }
            foreach ($group_add as $group_id) {
              $error = phpbb_api_group_user_add($group_id, $user_id);
            }
          }
        }
        else { //if ($sync == PHPBB_SYNC_TO_DRUPAL) {
          //$group_user_roles = array();
          $group_user_roles_add = array();

          foreach ($user_roles as $rid => $rname) {
            $group_ids = variable_get('phpbbforum_map_user_role_' . $rid, 0);
            if (!empty($group_ids)) {
              $group_id_ary = array();
              foreach ($group_ids as $group_id => $group_id_name) {
                if (!empty($group_id_name)) {
                  $group_id_ary[$group_id] = $group_id_name;
                  //$group_user_roles[$rid] = $group_id_ary;
                  if (!isset($new_roles[$rid])) {
                    $group_user_roles_add[$rid] = $group_id_ary;
                  }
                }
              }
            }
          }

          // Delete user from role
          foreach ($group_roles as $rid => $group_id_ary) {
            $delete = true;
            foreach ($group_id_ary as $group_id => $group_id_name) {
              if (!empty($phpbb_group_id_ary[$group_id])) {
                $delete = false;
                break;
              }
            }
            if ($delete) {
              unset($new_roles[$rid]);
            }
          }

          // Add user to role
          if (count($group_user_roles_add)) {
            foreach ($phpbb_group_id_ary as $group_id => $group_id_name) {
              foreach ($group_user_roles_add as $rid => $group_id_ary) {
                if (!empty($group_id_ary[$group_id])) {
                  $new_roles[$rid] = $user_roles[$rid];
                }
              }
            }
          }

          if ($new_roles != $roles) {
            if (count($new_roles) == 0) {
              $new_roles = null;
            }
            $data += array('roles' => $new_roles);
          }
        }
      }
    } //if (!empty($drupal_roles))
  } // if (variable_get('phpbbforum_user_roles_sync', 0)) {

  if (variable_get('phpbbforum_sync_timezone', 1)) {
    $sync_data = true;
    if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
      if (isset($edit['timezone'])) {
        $val = $edit['timezone'];
      }
      else {
        $sync_data = false;
      }
    }
    else {
      $val = $account->timezone;
    }
    $val2 = $phpbb_user->data['user_timezone'] * 60 * 60;
    if ($sync_data && $val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        if ($val) {
          $val = $val / 60 / 60;
        }
        $data += array('user_timezone' => (float) $val);
      }
      else {
        $data += array('timezone' => $val2);
      }
    }
  }

  if (variable_get('phpbbforum_sync_signature', 1)) {
    $sync_data = true;
    if (module_exists('signature_forum')) {
      $result = db_query('SELECT signature FROM {users_signature} WHERE uid = :uid', array(':uid' => $account->uid));
      $signature = $result->fetchField();
      if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
        if ($result) {
          $val = $signature;
          $aVal = _phpbbforum_convert_sig($val, '', 'phpbb');
        }
        else {
          $sync_data = false;
          $val = '';
        }
      }
      else {
        $val = $account->signature_forum;
      }

      $val2 = $phpbb_user->data['user_sig'];
      $val2_converted = _phpbbforum_convert_sig($val2, $phpbb_user->data['user_sig_bbcode_uid'], 'drupal');
      if ($val2_converted !== false) {
        $val2 = $val2_converted;
      }

      if ($sync_data && $val != $val2) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          if (is_array($aVal) && isset($aVal['user_sig'])) {
            $data += $aVal;
          }
          else {
            $data += array('user_sig' => $val);
          }
        }
        else {
          $account->signature_forum = $val2;
          if ($result) {
            /* db_query('UPDATE {users_signature} SET signature=\'%s\' WHERE uid=%d', $val2, $account->uid) */
            db_update('users_signature')
              ->fields(array(
                'signature' => $val2,
              ))
              ->condition('uid', $account->uid)
              ->execute();
          }
          else {
            /* db_query('INSERT INTO {users_signature} (uid, signature) VALUES (%d, \'%s\')', $account->uid, $val2) */
            $id = db_insert('users_signature')
              ->fields(array(
                'uid' => $account->uid,
                'signature' => $val2,
              ))
              ->execute();
          }
        }
      }
    }
    else {
      if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
        if (isset($edit['signature'])) {
          $val = $edit['signature'];
          $aVal = _phpbbforum_convert_sig($val, '', 'phpbb');
        }
        else {
          $sync_data = false;
        }
      }
      else {
        $val = $account->signature;
      }

      $val2 = $phpbb_user->data['user_sig'];
      $val2_converted = _phpbbforum_convert_sig($val2, $phpbb_user->data['user_sig_bbcode_uid'], 'drupal');
      if ($val2_converted !== false) {
        $val2 = $val2_converted;
      }

      if ($sync_data && $val != $val2) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          if (is_array($aVal) && isset($aVal['user_sig'])) {
            $data += $aVal;
          }
          else {
            $data += array('user_sig' => $val);
          }
        }
        else {
          $data += array('signature' => $val2);
        }
      }
    }

  }
  // avatars
  if (variable_get('user_pictures', 0) && variable_get('phpbbforum_sync_avatar', 1)) {
    $sync_data = true;
    entity_get_controller('user')->resetCache(array($account->uid));
    $account = user_load($account->uid);
    if ($op == 'update' && $sync == PHPBB_SYNC_TO_PHPBB) {
      if (!empty($edit['picture_delete'])) {
        $_SESSION['phpbbforum'][$account->uid]['picture_delete'] = TRUE;
      }
      if (!empty($edit['picture_upload'])) {
        //$drupal_filename = $val = drupal_realpath($edit['picture_upload']->uri);
        //$drupal_picture_url = file_create_url($edit['picture_upload']->uri);
        $_SESSION['phpbbforum'][$account->uid]['picture_upload'] = TRUE;
      }
      //return $data;
    }
    else {
       $drupal_filename = $val = drupal_realpath($account->picture->uri);
       $drupal_picture_url = file_create_url($account->picture->uri);
    }
      
    if (empty($_SESSION['phpbbforum'][$account->uid]['picture_upload']) && empty($_SESSION['phpbbforum'][$account->uid]['picture_delete'])) {
      return $data;
    }
    
    $sync = PHPBB_SYNC_TO_PHPBB;
    
    if (!empty($_SESSION['phpbbforum'][$account->uid]['picture_upload'])) {
      $drupal_filename = $val = drupal_realpath($account->picture->uri);
      $drupal_picture_url = file_create_url($account->picture->uri);
      unset($_SESSION['phpbbforum'][$account->uid]['picture_upload']);
    }
    elseif (!empty($_SESSION['phpbbforum'][$account->uid]['picture_delete'])) {
      $drupal_picture_url = $drupal_filename = $val = 0;
      unset($_SESSION['phpbbforum'][$account->uid]['picture_delete']);
    }
   
    $avatar_selection = false;
    $avatar_selection_val = false;
    $unique_avatar = false;
    
    if (module_exists('avatar_selection')) {
      $avatar_selection = true;
      $avatar_selection_path = 'avatar_selection';
    }
    else {
      $avatar_selection = false;
      $avatar_selection_path = '';
    }
    
    if (module_exists('unique_avatar')) {
      $unique_avatar = true;
    }
    else {
      $unique_avatar = false;
    }
    $avatar_selection_val = false;
    /*
    if (empty($val)) {
      $drupal_picture_url = $val;
    }
    else {
      if ($avatar_selection && strpos($val, $avatar_selection_path) !== false) {
        $avatar_selection_val = true;
      }
      $drupal_picture_url = $base_url . '/' . $val;
    }
    */
    //$can_upload = ($phpbb_config['allow_avatar_upload'] && file_exists($phpbb_root_path . $phpbb_config['avatar_path']) && @is_writable($phpbb_root_path . $phpbb_config['avatar_path']) && $auth->acl_get('u_chgavatar') && (@ini_get('file_uploads') || strtolower(@ini_get('file_uploads')) == 'on')) ? true : false;

    $val2 = $phpbb_user->data['user_avatar'];
    $phpbb_avatar_type = $phpbb_user->data['user_avatar_type'];
    $phpbb_avatar_width = $phpbb_user->data['user_avatar_width'];
    $phpbb_avatar_height = $phpbb_user->data['user_avatar_height'];
    $width = $height = 0;
    //define('AVATAR_UPLOAD', 1);
    //define('AVATAR_REMOTE', 2);
    //define('AVATAR_GALLERY', 3);
    //$phpbb_avatar_realpath = empty($phpbb_config['custom_avatar_enabled']) ? $phpbb_config['attachmentUploadDir'] : $phpbb_config['custom_avatar_dir'];
    $phpbb_avatar_realpath = "{$phpbb_root_path}{$phpbb_config['avatar_path']}/";
    $phpbb_avatar_gallery_realpath = "{$phpbb_root_path}{$phpbb_config['avatar_gallery_path']}/";
    //$phpbb_avatar_url = $phpbb_config['forum_url']  .'/'. $phpbb_avatar_path;
    $drupal_files_path = variable_get('file_public_path', conf_path() . '/files');
    $drupal_files_realpath = realpath($drupal_files_path);
 
    $drupal_base_realpath = realpath('.');
    $user_picture_path = variable_get('user_picture_path', 'pictures');
    $drupal_pictures_path = $drupal_files_path . '/' . $user_picture_path;
    $drupal_pictures_realpath = $drupal_files_realpath . '/' . $user_picture_path;

    $phpbb_id = $phpbb_user->data['user_id'];
    $uid = $account->uid;
    $phpbb_avatar_id = $phpbb_id . '_';
    $drupal_picture_id = 'picture-' . $uid;

    if (!empty($val2) && (strtolower(substr($val2, 0, 7)) == 'http://')) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        if (!empty($val)) {
          $extension = '.' . pathinfo($val, PATHINFO_EXTENSION);
          /*if ($avatar_selection_val) {
            $drupal_filename = $drupal_base_realpath . '/' . $val;
          }
          else {
            $drupal_picture_name = $drupal_picture_id . $extension;
            $drupal_filename = $drupal_pictures_realpath . '/' . $drupal_picture_name;
          }*/
          $phpbb_avatar_name = $phpbb_avatar_id . $extension;
          $phpbb_avatar_name = get_avatar_filename($phpbb_avatar_name);
          $phpbb_filename = $phpbb_avatar_realpath . $phpbb_avatar_name;
          if (($drupal_picture_url != strtolower($val2)) || !file_exists($phpbb_filename) || (filesize($phpbb_filename) != filesize($drupal_filename))) {
            // copy from drupal to phpbb
            if (file_exists($drupal_filename)) {
              list($width, $height, $type) = @getimagesize($drupal_filename);
              if (!@copy($drupal_filename, $phpbb_filename)) {
                _phpbbforum_set_message('The selected file %file could not be copied.', array('%file' => $drupal_filename), 'error');
                phpbb_update_avatar($phpbb_id, $drupal_picture_url, AVATAR_REMOTE, $width, $height, $error);
              }
              else {
                @chmod($phpbb_filename, 0664);
                $phpbb_avatar_name = $phpbb_avatar_id . REQUEST_TIME . $extension;
                phpbb_update_avatar($phpbb_id, $phpbb_avatar_name, AVATAR_UPLOAD, $width, $height, $error);
              }
            }
          }
        }
        else {
          // remove avatar;
          phpbb_update_avatar($phpbb_id, '', 0, 0, 0, $error);
        }
      }
      else {
        // cannot download to drupal from phpbb url
        if (strlen($val2) > 17) {
          _phpbbforum_set_message(t('Avatar could not be synced from phpBB to Drupal from url.'));
        }
      }
    }
    else {
      if ($sync == PHPBB_SYNC_TO_DRUPAL) {
        $extension = '.' . pathinfo($val2, PATHINFO_EXTENSION);
        $phpbb_avatar_name = $phpbb_avatar_id . $extension;
        $phpbb_file_found = false;
        if ($phpbb_avatar_type == AVATAR_GALLERY) {
          $phpbb_filename = $phpbb_avatar_gallery_realpath . $val2;
        }
        else {
          $phpbb_filename = $phpbb_avatar_realpath . get_avatar_filename($val2);
        }
        if (file_exists($phpbb_filename)) {
          $phpbb_file_found = true;
        }
        if ($avatar_selection_val) {
          $drupal_filename = $drupal_base_realpath . '/' . $val;
        }
        else {
          $drupal_picture_name = $drupal_picture_id . $extension;
          $drupal_filename = $drupal_pictures_realpath . '/' . $drupal_picture_name;
        }
        if ($phpbb_file_found) {
          if (!file_exists($drupal_filename) || empty($val) || (filesize($phpbb_filename) != filesize($drupal_filename))) {
            if (!empty($val) && !$avatar_selection_val) {
              if (substr($val, 0, strlen($drupal_files_path)) == $drupal_files_path) {
                $drupal_oldfilename = $drupal_files_realpath . substr($val, strlen($drupal_files_path));
              }
              else {
                $drupal_oldfilename = $drupal_files_realpath . '/' . $val;
              }
              if (file_exists($drupal_oldfilename)) {
                file_delete($drupal_oldfilename);
              }
            }
            // copy from phpbb
            if ($avatar_selection_val) {
              $drupal_picture_name = $drupal_picture_id . $extension;
              $drupal_filename = $drupal_pictures_realpath . '/' . $drupal_picture_name;
            }
            file_copy($phpbb_filename, $drupal_filename, FILE_EXISTS_REPLACE);
            $val2 = $drupal_pictures_path . '/' . $drupal_picture_name;
            $data += array('picture' => $val2);
          }
        }
        else {
          if (!empty($val)) {
            if (!$avatar_selection_val) {
              if (substr($val, 0, strlen($drupal_files_path)) == $drupal_files_path) {
                $drupal_oldfilename = $drupal_files_realpath . substr($val, strlen($drupal_files_path));
              }
              else {
                $drupal_oldfilename = $drupal_files_realpath . '/' . $val;
              }
              if (file_exists($drupal_oldfilename)) {
                file_delete($drupal_oldfilename);
              }
            }
            $val2 = '';
            $data += array('picture' => $val2);
          }
        }
      }
      else { // PHPBB_SYNC_TO_PHPBB
        if (!empty($val)) {
          $extension = '.' . pathinfo($val, PATHINFO_EXTENSION);
          /*if ($avatar_selection_val) {
            $drupal_filename = $drupal_base_realpath . '/' . $val;
          }
          else {
            $drupal_picture_name = $drupal_picture_id . $extension;
            $drupal_filename = $drupal_pictures_realpath . '/' . $drupal_picture_name;
          }*/
          $phpbb_avatar_name = $phpbb_avatar_id . $extension;
          $phpbb_avatar_name = get_avatar_filename($phpbb_avatar_name);
          $phpbb_filename = $phpbb_avatar_realpath . $phpbb_avatar_name;
          if (!empty($val2) || !file_exists($phpbb_filename) || filesize($phpbb_filename) != filesize($drupal_filename)) {
            // copy from drupal to phpbb
            if (file_exists($drupal_filename)) {
              list($width, $height, $type) = @getimagesize($drupal_filename);
              if (!@copy($drupal_filename, $phpbb_filename)) {
                _phpbbforum_set_message('The selected file %file could not be copied.', array('%file' => $drupal_filename), 'error');
                phpbb_update_avatar($phpbb_id, $drupal_picture_url, AVATAR_REMOTE, $width, $height, $error);
              }
              else {
                @chmod($phpbb_filename, 0664);
                $phpbb_avatar_name = $phpbb_avatar_id . REQUEST_TIME . $extension;
                phpbb_update_avatar($phpbb_id, $phpbb_avatar_name, AVATAR_UPLOAD, $width, $height, $error);
              }
            }
          }
        }
        else {
          // remove avatar
          phpbb_update_avatar($phpbb_id, '', 0, 0, 0, $error);
        }
      }
    }
  }
  //}

  return $data;
}

/**
 * Implements hook_user_update().
 */
/*
function phpbbforum_entity_update($entity, $type) {
  if ($type == 'user') {
    $account = $entity;
    $account2 = user_load($account->uid);
  }
}
*/

// added by Melkon
function _phpbbforum_convert_sig($sSignature, $uid = '', $mode = 'phpbb') {
  global $phpbb_root_path, $phpEx;

  include_once $phpbb_root_path . "includes/message_parser.$phpEx";

  $message_parser = new parse_message($sSignature);

  switch ($mode) {
    case 'phpbb':
      // Allowing Quote BBCode
      $message_parser->parse(true, true, true);

      $error = array();
      if (sizeof($message_parser->warn_msg)) {
        $sWarning = implode('<br />', $message_parser->warn_msg);
        $error[] = $sWarning;
        if (PHPBB_MODULE_DEBUG) {
          _phpbbforum_set_message($sWarning);
        }
      }
      if (!sizeof($error)) {
        $aSigInfos = array(
          'user_sig' => (string) $message_parser->message,
          'user_sig_bbcode_uid' => (string) $message_parser->bbcode_uid,
          'user_sig_bbcode_bitfield' => $message_parser->bbcode_bitfield,
        );
        return $aSigInfos;
      }
      return false;

    case 'drupal':
      decode_message($sSignature, $uid);
      $sSignature = str_replace(array('&#58;', '&#46;'), array(':', '.'), $sSignature);
      return $sSignature;
  }
  return false;
}

