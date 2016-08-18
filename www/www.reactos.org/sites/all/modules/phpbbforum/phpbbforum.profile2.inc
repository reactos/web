<?php
// $Id$
/**
 * @file
 * Drupal 7 profile module compatible functions
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */


function _phpbbforum_set_user_profile2_data($op, $sync, &$account, $data = array(), $has_content_profile = false) {
  global $phpbb_config, $phpbb_user;
  //$profile->entityType == 'profile2'
  if ($phpbb_config['allow_birthdays']) {
    $var = variable_get('phpbbforum_map_user_birthday', 'field_birthday');
    if (isset($account->{$var})) {
      $val = $account->{$var}['und'][0]['value'];
      $val2 = $phpbb_user->data['user_birthday'];
      // extract date. Expected format DD-MM-YYYY
      $yymmdd = explode('-', $val2);
      $year2 = (int) $yymmdd[2];
      $month2 = (int) $yymmdd[1];
      $day2 =  (int) $yymmdd[0];
      $val2 = sprintf('%02d-%02d-%04d', $day2, $month2, $year2);
      if (empty($year2) || $year2 == 1) {
        $date2zero = true;
      }
      else {
        $date2zero = false;
      }
      $date1zero = false;
      if (is_array($val)) {
        $dateform = true;
        // extract drupal date
        extract($val);
        $compare = ($day != $day2 || $month != $month2 || $year != $year2);
      }
      else {
        $dateform = false;
        if (module_exists('date')) {
          // extract date. Expected format YYYY-MM-DDT00:00:00
          $date_time = explode('T', $val);
          $yymmdd = explode('-', $date_time[0]);
        }
        else {
          $yymmdd = explode('-', $val);
        }
        $year = (int) $yymmdd[0];
        $month = (int) $yymmdd[1];
        $day =  (int) $yymmdd[2];
        if (empty($year) || $year == 1) {
          $date1zero = true;
        }
        else {
          $date1zero = false;
        }
        $val = sprintf('%02d-%02d-%04d', $day, $month, $year);
        
        $compare = ($val != $val2);
      }
      if ($compare) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          if (!$date1zero) {
            if ($dateform) {
              $val = sprintf('%02d-%02d-%04d', $day, $month, $year);
            }
            $data += array('user_birthday' => $val);
          }
        }
        elseif (!empty($val2) && !$date2zero) {
          if ($dateform) {
            $date2 = array(
              'day' => $day2,
              'month' => $month2,
              'year' => $year2,
            );
            $data += array($var => $date2);
          }
          else {
            if (module_exists('date')) {
              $val2 = sprintf('%04d-%02d-%02d', $year2, $month2, $day2) . 'T' . $date_time[1];
            }
            else {
              $val2 = sprintf('%04d-%02d-%02d', $year2, $month2, $day2);
            }
            $data[$var]['und'][0]['value'] = $val2;
            if ($has_content_profile) {
              $account->{$var}['und'][0]['value'] = $val2;
              $data['content_profile'] = true;
            }
          }
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_occ', 'field_occ');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_occ'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_occ' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_interests', 'field_interests');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_interests'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_interests' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_from', 'field_from');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_from'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_from' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_icq', 'field_icq');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_icq'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_icq' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_aim', 'field_aim');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_aim'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_aim' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_yim', 'field_yim');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_yim'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_yim' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_msnm', 'field_msnm');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_msnm'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_msnm' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_jabber', 'field_jabber');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    $val2 = $phpbb_user->data['user_jabber'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_jabber' => $val);
      }
      elseif (!empty($val2)) {
        $data[$var]['und'][0]['value'] = $val2;
        if ($has_content_profile) {
          $account->{$var}['und'][0]['value'] = $val2;
          $data['content_profile'] = true;
        }
      }
    }
  }
  
  $var = variable_get('phpbbforum_map_user_website', 'field_website');
  if (isset($account->{$var})) {
    if (module_exists('link')) {
      $val = $account->{$var}['und'][0]['url'];
    }
    else {
      $val = $account->{$var}['und'][0]['value'];
    }
    $val2 = $phpbb_user->data['user_website'];
    if ($val != $val2) {
      if ($sync == PHPBB_SYNC_TO_PHPBB) {
        $data += array('user_website' => $val);
      }
      elseif (!empty($val2)) {
        if (module_exists('link')) {
          $data[$var]['und'][0]['url'] = $val2;
          $data[$var]['und'][0]['title'] = $val2;
          if ($has_content_profile) {
            $account->{$var}['und'][0]['url'] = $val2;
            $account->{$var}['und'][0]['title'] = $val2;
            $data['content_profile'] = true;
          }
        }
        else {
          $data[$var]['und'][0]['value'] = $val2;
          if ($has_content_profile) {
            $account->{$var}['und'][0]['value'] = $val2;
            $data['content_profile'] = true;
          }
        }
        //$data['content_profile'] = true;
      }
    }
  }

  $var = variable_get('phpbbforum_map_user_gender', 'field_gender');
  if (isset($account->{$var})) {
    $val = $account->{$var}['und'][0]['value'];
    if (isset($phpbb_user->data['user_gender'])) {
      if ($val == t('Male')) {
        $val = '1';
      }
      elseif ($val == t('Female')) {
        $val = '2';
      }
      else {
        $val = '';
      }
      $val2 = $phpbb_user->data['user_gender'];
      if ($val != $val2) {
        if ($sync == PHPBB_SYNC_TO_PHPBB) {
          if ($val == '1' || $val == '2' || $val == '') {
            $data += array('user_gender' => $val);
          }
        }
        elseif (!empty($val2)) {
          if ($val2 == '1') {
            $val2 = t('Male');
          }
          elseif ($val2 == '2') {
            $val2 = t('Female');
          }
          else {
            $val2 = '';
          }
          $data[$var]['und'][0]['value'] = $val2;
          if ($has_content_profile) {
            $account->{$var}['und'][0]['value'] = $val2;
            $data['content_profile'] = true;
          }
        }
      }
    }
    else {
      $phpbb_user->get_profile_fields($phpbb_user->data['user_id']);
      if (isset($phpbb_user->profile_fields['pf_gender'])) {
        if ($val == t('Male')) {
          $val = '2';
        }
        elseif ($val == t('Female')) {
          $val = '3';
        }
        else {
          $val = '1';
        }
        $val2 = $phpbb_user->profile_fields['pf_gender'];
        if ($val != $val2) {
          if ($sync == PHPBB_SYNC_TO_PHPBB) {
            if ($val == '1' || $val == '2' || $val == '3') {
              $data += array('pf_gender' => $val);
              $phpbb_user->profile_fields['pf_gender'] = $val;
            }
          }
          else { //if (!empty($val2)) {
            if ($val2 == '2') {
              $val2 = t('Male');
            }
            elseif ($val2 == '3') {
              $val2 = t('Female');
            }
            else {
              $val2 = '';
            }
            $data[$var]['und'][0]['value'] = $val2;
            if ($has_content_profile) {
              $account->{$var}['und'][0]['value'] = $val2;
              $data['content_profile'] = true;
            }
          }
        }
      }
    }
  }

  // custom profile fields
  $phpbb_user->get_profile_fields($phpbb_user->data['user_id']);
  foreach ($phpbb_user->profile_fields as $pf_name => $val2) {
    if ($pf_name != 'user_id' && $pf_name != 'pf_gender') {
      $name = substr($pf_name, 3);
      $var = variable_get('phpbbforum_map_' . $name, 'profile_' . $name);
      if (isset($account->{$var})) {
        $val = $account->{$var}['und'][0]['value'];
        if ($val != $val2) {
          if ($sync == PHPBB_SYNC_TO_PHPBB) {
            $data += array($pf_name => $val);
            $phpbb_user->profile_fields[$pf_name] = $val;
          }
          elseif (!empty($val2)) {
            $data[$var]['und'][0]['value'] = $val2;
            if ($has_content_profile) {
              $account->{$var}['und'][0]['value'] = $val2;
              $data['content_profile'] = true;
            }
          }
        }
      }
    }
  }

  return $data;
}
