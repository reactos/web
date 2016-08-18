<?php
// $Id: phpbbforum.admin.inc,v 1.4 2010/11/24 20:53:34 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_admin_settings() { // 7.x
  global $phpbb_connection, $phpbb_root_path, $phpbb_user, $_phpbb_integration_mode, $_drupal_base_path;

  $form = array();

  $form['phpbbstatus'] = array(
    '#type' => 'fieldset',
    '#title' => t('phpBBforum status'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $phpbbapi_exists = false;
  $phpbbinc = "";

  $phpbbroot = variable_get('phpbbforum_root', $_drupal_base_path . PHPBB_PATH);
  if (empty($phpbbroot)) {
    $phpbbroot = $_drupal_base_path . PHPBB_PATH;
    variable_set('phpbbforum_root', $phpbbroot);
  }

  $phpbbsettings = $phpbbroot . 'config.php';
  $phpbbapifile = variable_get('phpbbforum_api_file', PHPBB_API_FILE);
  if (empty($phpbbapifile)) {
    $phpbbapifile = PHPBB_API_FILE;
    variable_set('phpbbforum_api_file', $phpbbapifile);
  }
  $phpbbapi = $phpbbroot . PHPBB_API_INCLUDE_PATH . $phpbbapifile;
  
  if (file_exists($phpbbsettings)) {
    $phpbbsettings_exists = true;
    $form['phpbbstatus']['info3'] = array(
      '#markup' => '<div class="ok">' . t('Successfully locating phpBB installation.') . '</div>',
    );

    $phpbb_root_path = $phpbbroot;
    $phpbbinc = variable_get('phpbbforum_inc', drupal_get_path('module', PHPBB_PAGE)  . '/' .  PHPBB_API_INCLUDE_PATH);
    if (empty($phpbbinc)) {
      $phpbbinc = drupal_get_path('module', PHPBB_PAGE)  . '/' .  PHPBB_API_INCLUDE_PATH;
      variable_set('phpbbforum_inc', $phpbbinc);
    }
    $phpbbapi = $phpbbinc . $phpbbapifile;
    if (file_exists($phpbbapi)) {
      $phpbbapi_exists = true;
      variable_set('phpbbforum_inc', $phpbbinc);
    }
    else {
      $phpbbapi = $phpbb_root_path . $phpbbapifile;
      if (file_exists($phpbbapi)) {
        $phpbbapi_exists = true;
        $phpbbinc = $phpbb_root_path;
      }
    }
  }
  else {    
    $phpbbsettings_exists = false;
    $form['phpbbstatus']['info4'] = array(
      '#markup' => '<div class="error">' . t('Error locating phpBB installation.') . ' ' . t('Please fix your settings!') . '</div>',
    );
  }

  if ($phpbbapi_exists) {
    $form['phpbbstatus']['info1'] = array(
      '#markup' => '<div class="ok">' . t('Successfully locating %api.', array('%api' => $phpbbapi)) . '</div>',
    );
  }
  else {    
    $form['phpbbstatus']['info2'] = array(
      '#markup' => '<div class="error">' . t('Error locating %api.', array('%api' => $phpbbapi)) . ' ' . t('Please fix your settings!') . '</div>',
    );
  }
 
  if (!$phpbb_connection && $phpbbsettings_exists && $phpbbapi_exists) {
    require_once $phpbbapi;
    phpbb_api_session_begin();
  }

  if ($phpbb_connection) {
    $form['phpbbstatus']['info5'] = array(
      '#markup' => '<div class="ok">' . t('Successfully connected to the phpBB database.') . '</div>',
    );
  }
  else {
    $form['phpbbstatus']['info6'] = array(
      '#markup' => '<div class="error">' . t('Unable to connect to the phpBB database.') . ' ' . t('Please fix your settings!') . '</div>',
    );
  }

  $form['phpbbsettings'] = array(
    '#type' => 'fieldset',
    '#title' => t('phpBB location settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['phpbbsettings']['phpbbforum_root'] = array(
    '#type' => 'textfield',
    '#title' => t('phpBB forum root path'),
    '#maxlength' => '128',
    '#size' => '60',
    '#default_value' => $phpbbroot,
    '#description' => t('Path to forum directory. Enter the full directory path with trailing slash where phpBB is installed.'),
  );

  if ($phpbbsettings_exists) {
    $form['phpbbsettings']['phpbbforum_inc'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to phpBB api file'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => $phpbbinc,
      '#description' => t('Enter the full directory path with trailing slash where phpBB api file %name is located.', array('%name' => $phpbbapifile)),
    );

    $form['phpbbsettings']['phpbbforum_api_file'] = array(
      '#type' => 'textfield',
      '#title' => t('phpBB api file name'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => $phpbbapifile,
      '#description' => t('Enter phpBB api file name.'),
    );
  }

  if ($phpbb_connection) {

    $form['drupalsettings'] = array(
      '#type' => 'fieldset',
      '#title' => t('phpBB/Drupal settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    $qookie_test = variable_get('phpbbforum_qookie_test', 0);

    $authenticated = phpbb_api_authenticate_user();
    if ($authenticated) {
      $form['phpbbstatus']['info7'] = array(
        '#markup' => '<div class="ok">' . t('Successfully authenticated phpBB user: %name.', array('%name' => $phpbb_user->data['username'])) . '</div>',
      );
      $qookie_test = 1;
      variable_set('phpbbforum_qookie_test', $qookie_test);
    }
    else {
      if ($qookie_test == 0 || $qookie_test == 2) {
        $form['phpbbstatus']['info8'] = array(
          //'#markup' => '<div class="error">' . t('phpBB user: %name.', array('%name' => $phpbb_user->data['username'])) . ' ' . t('You are not authenticated in phpBB now.') . ' ' . t('Please login to phpBB and test again.') . '</div>',
          '#markup' => '<div class="ok">' . t('phpBB user: %name.', array('%name' => $phpbb_user->data['username'])) . ' ' . t('You are not authenticated in phpBB now.') . ' ' . t('Please login to phpBB and test again.') . '</div>',
        );
        $qookie_test = 0;
      }
      else {
        $form['phpbbstatus']['info8'] = array(
          '#markup' => '<div class="ok">' . t('phpBB user: %name.', array('%name' => $phpbb_user->data['username'])) . ' ' . t('You are not authenticated in phpBB now.') . '</div>',
        );
      }
    }

    $form['drupalsettings']['phpbbforum_qookie_test'] = array(
      '#type' => 'radios',
      '#title' => t('phpBB authentication test'),
      '#default_value' => $qookie_test,
      '#options' => array(
        0 => t('Not passed'),
        1 => t('Passed'),
        2 => t('Test'),
      ),
    );

    $form['drupalsettings']['phpbbforum_master'] = array(
      '#type' => 'radios',
      '#title' => t('Select master registration system'),
      '#default_value' => variable_get('phpbbforum_master', 1),
      '#options' => array(
        0 => t('Drupal master'),
        1 => t('phpBB master'),
      ),
    );
    // I18n
    $form['drupalsettings']['phpbbforum_language'] = array(
      '#type' => 'radios',
      '#title' => t('Language negotiation'),
      '#default_value' => variable_get('phpbbforum_language', 0),
      '#options' => array(
        0 => t('None'),
        1 => t('Path prefix only'),
      ),
      '#description' => t('Select the mechanism used to determine your site\'s presentation language.'),
    );
    
    $form['drupalsettings']['phpbbforum_pm_display_mode'] = array(
      '#type' => 'radios',
      '#title' => t('Personal messages display mode'),
      '#default_value' => variable_get('phpbbforum_pm_display_mode', 0),
      '#options' => array(
        0 => t('Display all personal messages'),
        1 => t('Display private messages only'),
        2 => t('Display private messages and your posts'),
      ),
    );

    $form['drupalsettings']['phpbbforum_num_whos_online'] = array(
      '#type' => 'textfield',
      '#title' => t('Number of online forum users'),
      '#maxlength' => '4',
      '#size' => '4',
      '#default_value' => variable_get('phpbbforum_num_whos_online', PHPBB_NUM_WHOS_ONLINE),
      '#description' => t('Enter the number of online forum users.'),
    );

    $form['drupalsettings']['phpbbforum_num_recent_topics'] = array(
      '#type' => 'textfield',
      '#title' => t('Number of recent topics'),
      '#maxlength' => '2',
      '#size' => '2',
      '#default_value' => variable_get('phpbbforum_num_recent_topics', PHPBB_NUM_RECENT_TOPICS),
      '#description' => t('Enter the number of recent topics.'),
    );

    $form['drupalsettings']['phpbbforum_recent_topics_display_mode'] = array(
      '#type' => 'radios',
      '#title' => t('Recent topics display mode'),
      '#default_value' => variable_get('phpbbforum_recent_topics_display_mode', 0),
      '#options' => array(
        0 => t('Display all in the list'),
        1 => t('Display titles only'),
        2 => t('Display all in the table'),
      ),
    );

    $form['drupalsettings']['phpbbforum_recent_topics_br'] = array(
      '#type' => 'radios',
      '#title' => t('Recent topics word\'s delimiter'),
      '#default_value' => variable_get('phpbbforum_recent_topics_br', 1),
      '#options' => array(
        0 => t('Space'),
        1 => t('BR'),
      ),
      '#description' => t('Enter the recent topics word\'s delimiter.'),
    );

    $form['drupalsettings']['phpbbforum_num_recent_posts'] = array(
      '#type' => 'textfield',
      '#title' => t('Number of recent posts'),
      '#maxlength' => '2',
      '#size' => '2',
      '#default_value' => variable_get('phpbbforum_num_recent_posts', PHPBB_NUM_RECENT_POSTS),
      '#description' => t('Enter the number of recent posts.'),
    );

    $form['drupalsettings']['phpbbforum_recent_posts_display_mode'] = array(
      '#type' => 'radios',
      '#title' => t('Recent posts display mode'),
      '#default_value' => variable_get('phpbbforum_recent_posts_display_mode', 0),
      '#options' => array(
        0 => t('Display all in the list'),
        1 => t('Display titles only'),
        2 => t('Display all in the table'),
      ),
    );

    $form['drupalsettings']['phpbbforum_recent_posts_br'] = array(
      '#type' => 'radios',
      '#title' => t('Recent posts word\'s delimiter'),
      '#default_value' => variable_get('phpbbforum_recent_posts_br', 1),
      '#options' => array(
        0 => t('Space'),
        1 => t('BR'),
      ),
      '#description' => t('Enter the recent posts word\'s delimiter.'),
    );

    $form['drupalsettings']['phpbbforum_recent_display_topic_new_icon_pos'] = array(
      '#type' => 'radios',
      '#title' => t('Recent topic newest icon position'),
      '#default_value' => variable_get('phpbbforum_recent_display_topic_new_icon_pos', 0),
      '#options' => array(
        0 => t('Before the subject'),
        1 => t('After the subject'),
      ),
      '#description' => t('Enter the topic newest icon position.'),
    );

    if ($phpbb_user) {
      $limit_days = array(
        0 => t('All results')/*$phpbb_user->lang['ALL_RESULTS']*/,
        1 => $phpbb_user->lang['1_DAY'],
        7 => $phpbb_user->lang['7_DAYS'],
        14 => $phpbb_user->lang['2_WEEKS'],
        30 => $phpbb_user->lang['1_MONTH'],
        90 => $phpbb_user->lang['3_MONTHS'],
        180 => $phpbb_user->lang['6_MONTHS'],
        365 => $phpbb_user->lang['1_YEAR'],
      );
    }
    else {
      $limit_days = array(
        0 => t('All results'),
        1 => t('1 day'),
        7 => t('7 days'),
        14 => t('14 days'),
        30 => t('1 month'),
        90 => t('3 months'),
        180 => t('6 months'),
        365 => t('1 year'),
      );
    }
    //$sort_by_text	= array('a' => $phpbb_user->lang['SORT_AUTHOR'], 't' => $phpbb_user->lang['SORT_TIME'], 'f' => $phpbb_user->lang['SORT_FORUM'], 'i' => $phpbb_user->lang['SORT_TOPIC_TITLE'], 's' => $phpbb_user->lang['SORT_POST_SUBJECT']);

    $form['drupalsettings']['phpbbforum_num_recent_sort_days'] = array(
      '#type' => 'radios',
      '#title' => t('Number of recent sort days'),
      '#default_value' => variable_get('phpbbforum_num_recent_sort_days', 0),
      '#options' => $limit_days,
      '#description' => t('Enter the number of recent sort days.'),
    );
    $form['drupalsettings']['phpbbforum_num_recent_new_sort_days'] = array(
      '#type' => 'radios',
      '#title' => t('Number of recent new topics sort days'),
      '#default_value' => variable_get('phpbbforum_num_recent_new_sort_days', 0),
      '#options' => $limit_days,
      '#description' => t('Enter the number of recent new topics sort days.'),
    );

    $form['drupalsettings']['phpbbforum_user_ban'] = array(
      '#type' => 'radios',
      '#title' => t('phpBB user ban checking'),
      '#default_value' => variable_get('phpbbforum_user_ban', 0),
      '#options' => array(
        0 => t('No'),
        1 => t('Check phpBB bans'),
      ),
    );

    $form['drupalsettings']['phpbbforum_set_msg'] = array(
      '#type' => 'radios',
      '#title' => t('Display phpBBForum module messages'),
      '#default_value' => variable_get('phpbbforum_set_msg', 1),
      '#options' => array(
        0 => t('No'),
        1 => t('Yes'),
      ),
    );

    $form['drupalsettings']['phpbbforum_log_msg'] = array(
      '#type' => 'radios',
      '#title' => t('Log phpBBForum module messages'),
      '#default_value' => variable_get('phpbbforum_log_msg', 1),
      '#options' => array(
        0 => t('No'),
        1 => t('Yes'),
      ),
    );

    // Signatures
    $form['drupalsettings']['phpbbforum_sync_signature'] = array(
      '#type' => 'radios',
      '#title' => t('Signatures synchronisation'),
      '#default_value' => variable_get('phpbbforum_sync_signature', 1),
      '#options' => array(
        0 => t('Disable'),
        1 => t('Enable'),
      ),
      '#description' => t('Set signatures synchronisation support.'),
    );
    // Avatars
    $form['drupalsettings']['phpbbforum_sync_avatar'] = array(
      '#type' => 'radios',
      '#title' => t('Avatars synchronisation'),
      '#default_value' => variable_get('phpbbforum_sync_avatar', 1),
      '#options' => array(
        0 => t('Disable'),
        1 => t('Enable'),
      ),
      '#description' => t('Set avatars synchronisation support.'),
    );
    // Timezones
    $form['drupalsettings']['phpbbforum_sync_timezone'] = array(
      '#type' => 'radios',
      '#title' => t('Timezones synchronisation'),
      '#default_value' => variable_get('phpbbforum_sync_timezone', 1),
      '#options' => array(
        0 => t('Disable'),
        1 => t('Enable'),
      ),
      '#description' => t('Set timezones synchronisation support.'),
    );

    $form['profilemap'] = array(
      '#type' => 'fieldset',
      '#title' => t('Profile fields mapping'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );

    //if (module_exists('profile')) {

    //		$form['profilemap']['phpbbforum_map_username'] = array('#type' => 'textfield',
    //			'#title' => t('Name of `username` field'),  // 'realName'
    //			'#maxlength' => '128', '#size' => '60',
    //			'#default_value' => variable_get('phpbbforum_map_username', 'profile_username'),
    //			'#description' => t('Enter the name of phpBB `realName` field, as it configured in Drupal.'));

    $form['profilemap']['phpbbforum_map_user_gender'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_gender` field'), // 'user_gender'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_gender', 'field_gender'),
      '#description' => t('Enter the name of phpBB `user_gender` field, as it configured in Drupal.'),
    );


    $form['profilemap']['phpbbforum_map_user_birthday'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_birthday` field'), // 'user_birthday'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_birthday', 'field_birthday'),
      '#description' => t('Enter the name of phpBB `user_birthday` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_from'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_from` field'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_from', 'field_from'),
      '#description' => t('Enter the name of phpBB `user_from` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_icq'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_icq` field'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_icq', 'field_icq'),
      '#description' => t('Enter the name of phpBB `user_icq` field, as it configured in Drupal.'),
    );
    $form['profilemap']['phpbbforum_map_user_aim'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_aim` field'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_aim', 'field_aim'),
      '#description' => t('Enter the name of phpBB `user_aim` field, as it configured in Drupal.'),
    );
    $form['profilemap']['phpbbforum_map_user_yim'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_yim` field'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_yim', 'field_yim'),
      '#description' => t('Enter the name of phpBB `user_yim` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_msnm'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_msnm` field'),
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_msnm', 'field_msnm'),
      '#description' => t('Enter the name of phpBB `user_msnm` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_jabber'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_jabber` field'), // 'user_jabber'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_jabber', 'field_jabber'),
      '#description' => t('Enter the name of phpBB `user_jabber` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_website'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_website` field'), // 'user_website'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_website', 'field_website'),
      '#description' => t('Enter the name of phpBB `user_website` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_occ'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_occ` field'), // 'user_occ'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_occ', 'field_occ'),
      '#description' => t('Enter the name of phpBB `user_occ` field, as it configured in Drupal.'),
    );

    $form['profilemap']['phpbbforum_map_user_interests'] = array(
      '#type' => 'textfield',
      '#title' => t('Name of `user_interests` field'), // 'user_interests'
      '#maxlength' => '128',
      '#size' => '60',
      '#default_value' => variable_get('phpbbforum_map_user_interests', 'field_interests'),
      '#description' => t('Enter the name of phpBB `user_interests` field, as it configured in Drupal.'),
    );

    $form['cprofilemap'] = array(
      '#type' => 'fieldset',
      '#title' => t('Custom profile fields mapping'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );

    $phpbb_user->get_profile_fields($phpbb_user->data['user_id']);
    //$cp_data = $phpbb_user->profile_fields['pf_gender'];
    if (!module_exists('profile')) {
      foreach ($phpbb_user->profile_fields as $pf_name => $val) {
        if ($pf_name != 'user_id') {
          $name = substr($pf_name, 3);
          $form['cprofilemap']['phpbbforum_map_' . $name] = array(
            '#type' => 'textfield',
            '#title' => t('Name of `' . $name . '` custom profile field'),
            '#maxlength' => '128',
            '#size' => '60',
            '#default_value' => variable_get('phpbbforum_map_' . $name, 'field_' . $name),
            '#description' => t('Enter the name of phpBB `' . $name . '` field, as it configured in Drupal.'),
          );
        }
      }
    }
    else {
      ///////////////////////////
      //Vorapoap
      $dp_profile_fields = array('0' => '- - - [ Select ] - - -');
      $res = db_query("SELECT DISTINCT(fid) as fid, name, title FROM {profile_field} ORDER BY weight");
      foreach ($res as $row) {
        $dp_profile_fields[$row->name] = $row->title;
      }

      foreach ($phpbb_user->profile_fields as $pf_name => $val) {
        if ($pf_name != 'user_id') {
          $name = substr($pf_name, 3);
          $form['cprofilemap']['phpbbforum_map_' . $name] = array(
            '#type' => 'select',
            '#title' => t('Name of `' . $name . '` custom profile field'),
            '#default_value' => variable_get('phpbbforum_map_' . $name, 'profile_' . $name),
            '#options' => $dp_profile_fields,
          );

          /*
           $form['cprofilemap']['phpbbforum_map_'. $name] = array('#type' => 'textfield',
           '#title' => t('Name of `'. $name .'` custom profile field'),
           '#maxlength' => '128', '#size' => '60',
           '#default_value' => variable_get('phpbbforum_map_'. $name, 'profile_'. $name),
           '#description' => t('Enter the name of phpBB `'. $name .'` field, as it configured in Drupal.'));
           */
        }
      }
      //\Vorapoap
      ///////////////////////////
    }
    //} // end profile

    $form['drupalsettings']['phpbbforum_admin_user_id'] = array(
      '#type' => 'textfield',
      '#title' => t('phpBB3 admin user id'),
      '#maxlength' => '6',
      '#size' => '6',
      '#default_value' => variable_get('phpbbforum_admin_user_id', 2),
      '#description' => t('Enter the phpBB3 admin user id.'),
    );

    $form['groupmap'] = array(
      '#type' => 'fieldset',
      '#title' => t('Roles and groups'),
      //'#description' => t('The role attached to Drupal accounts created through the phpBB.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    /*
     $form['groupmap']['auto_active'] = array(
     '#type' => 'radios',
     '#title' => t('Automatic role assignment'),
     '#default_value' => variable_get('phpbbforum_', 1),
     '#description' => t('Automatic role assignment occurs when the user first
     logins to the account.  This happens without the users knowledge.  Set to
     Enabled to allow this functionality or Disabled to not allow.'),
     '#options' => array(1 => t('Enabled'), 0 => t('Disabled')),
     );
     */

    $roles = user_roles(TRUE);

    ksort($roles);


    $groups = array();
    $groups2 = array();

    $group_data = phpbb_get_user_all_groups();

    //$group_order = array('ADMINISTRATORS', 'GLOBAL_MODERATORS', 'REGISTERED_COPPA', 'REGISTERED', 'BOTS', 'GUESTS');

    foreach ($group_data as $type => $row_ary) {
      //if ($type == 'special') {
      //}

      foreach ($row_ary as $group_id => $row) {
        $group_name = $row['group_name'];

        if ($group_name != 'BOTS' && $group_name != 'GUESTS' &&
           (/*!$phpbb_config['coppa_enable'] ||*/ $group_name != 'REGISTERED_COPPA')) {
          if (!empty($phpbb_user->lang['G_' . $group_name])) {
            $groups[$group_id] = $phpbb_user->lang['G_' . $group_name];
          }
          else {
            $groups[$group_id] = $group_name;
          }
        }

        if ($group_name != 'BOTS' && $group_name != 'GUESTS' &&
            $group_name != 'ADMINISTRATORS' && $group_name != 'GLOBAL_MODERATORS' &&
           (/*!$phpbb_config['coppa_enable'] ||*/ $group_name != 'REGISTERED_COPPA')) {
          if (!empty($phpbb_user->lang['G_' . $group_name])) {
            $groups2[$group_id] = $phpbb_user->lang['G_' . $group_name];
          }
          else {
            $groups2[$group_id] = $group_name;
          }
        }
      }
    }

    $group_id_default = phpbb_get_user_group_id('REGISTERED');

    $form['groupmap']['phpbbforum_user_role'] = array(
      '#type' => 'select',
      '#title' => t('Drupal new user role'),
      '#default_value' => variable_get('phpbbforum_user_role', DRUPAL_AUTHENTICATED_RID),
      '#description' => t("Select the role for the new Drupal user created through the phpBB."),
      '#options' => $roles, //array_merge(array(0 => t('-- Please Select One --')), $roles),
    );

    $form['groupmap']['phpbbforum_user_group'] = array(
      '#type' => 'select',
      '#title' => t('phpBB new user group'),
      '#default_value' => variable_get('phpbbforum_user_group', $group_id_default),
      '#description' => t("Select the group for the new phpBB user created through the Drupal."),
      '#options' => $groups2,
    );

    $form['groupmap']['phpbbforum_user_roles_sync'] = array(
      '#type' => 'radios',
      '#title' => t('Roles and groups synchronization'),
      '#default_value' => variable_get('phpbbforum_user_roles_sync', 0),
      '#description' => t('Set to Enabled to allow this functionality or Disabled to not allow.'),
      '#options' => array(
        1 => t('Enabled'),
        0 => t('Disabled'),
      ),
    );

    //if (variable_get('phpbbforum_user_roles_sync', 0)) {
    $group_id_default_map = array();
    unset($groups[$group_id_default]);

    foreach ($roles as $rid => $rname) {
      if ($rid != DRUPAL_AUTHENTICATED_RID) {
        $group_map = variable_get('phpbbforum_map_user_role_' . $rid, $group_id_default_map);
        $form['groupmap']['phpbbforum_map_user_role_' . $rid] = array(
          '#type' => 'checkboxes',
          '#title' => t('User role') . ' "' . $rname . '" ' . t('synchronization'),
          '#default_value' => $group_map,
          '#description' => t("Select the phpBB group."),
          '#options' => $groups/*array_merge(array(0 => t('-- Not synced --')), $groups)*/,
        );
      }
    }
    //}
    /*
     $roles = user_roles(TRUE);
     // The disabled checkbox subelement for the 'authenticated user' role
     // must be generated separately and added to the checkboxes element,
     // because of a limitation in D6 FormAPI not supporting a single disabled
     // checkbox within a set of checkboxes.
     // TODO: This should be solved more elegantly. See issue #119038.
     $checkbox_authenticated = array(
     '#type' => 'checkbox',
     '#title' => $roles[DRUPAL_AUTHENTICATED_RID],
     '#default_value' => TRUE,
     '#disabled' => TRUE,
     );
     unset($roles[DRUPAL_AUTHENTICATED_RID]);

     if ($roles) {
     $form['groupmap']['auto_roles'] = array(
     '#type' => 'checkboxes',
     '#title' => t('Roles'),
     '#default_value' => _autoassignrole_settings('auto_roles'),
     '#description' => t('Check the specific Roles the user will automatically
     be assigned to when created by an administrator or through the new user
     registration process.  The Authenticated User role is automatically
     assigned by Drupal core and can not be edited.'),
     '#options' => $roles,
     DRUPAL_AUTHENTICATED_RID => $checkbox_authenticated,
     );
     }
     */

    ///////////////////////////

    // Frame
    $form['phpbbforum_page'] = array(
      '#type' => 'fieldset',
      '#title' => t('phpBB page settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    $form['phpbbforum_page']['phpbbforum_page_frame'] = array(
      '#type' => 'radios',
      '#title' => t('phpBB display way'),
      '#default_value' => variable_get("phpbbforum_page_frame", 0),
      '#options' => array(
        0 => t('In the window'),
        1 => t('In frame inside Drupal page'),
        2 => t('In the Drupal page') . '. (' . t('Except for ACP') . ')',
      ),
      //'#options' => array(0 => t('In the window'), 1 => t('In frame inside Drupal page'), 2 => t('In the Drupal page') .'. ('. t('Except for ACP') .')'),
      '#description' => t("Change the way phpBB is displayed in Drupal."),
    );

    $_phpbb_integration_mode = variable_get("phpbbforum_page_frame", 0);
    if ($_phpbb_integration_mode == 1) {
      $form['phpbbforum_page']['phpbbforum_page_width'] = array(
        '#type' => 'textfield',
        '#title' => t("phpBB frame width"),
        '#default_value' => variable_get("phpbbforum_page_width", "100%"),
        '#size' => '6',
        '#maxlength' => '6',
        '#description' => t("Set the width of the Frame."),
      );
      $form['phpbbforum_page']['phpbbforum_page_height'] = array(
        '#type' => 'textfield',
        '#title' => t("phpBB frame height"),
        '#default_value' => variable_get("phpbbforum_page_height", "1024"),
        '#size' => '6',
        '#maxlength' => '6',
        '#description' => t("Set the height of the Frame."),
      );

      $form['phpbbforum_page']['phpbbforum_page_scroll'] = array(
        '#type' => 'radios',
        '#title' => t('Scrolling phpBB frame'),
        '#default_value' => variable_get("phpbbforum_page_scroll", 0),
        '#options' => array(
          0 => t('No'),
          1 => t('Yes'),
          2 => t('Auto'),
        ),
        '#description' => t("Should scrollbars be displayed if phpBB is too large to fit in the frame."),
      );
      $form['phpbbforum_page']['phpbbforum_page_frame_acp'] = array(
        '#type' => 'radios',
        '#title' => t('phpBB ACP display way'),
        '#default_value' => variable_get("phpbbforum_page_frame_acp", 0),
        '#options' => array(
          0 => t('In the window'),
          1 => t('In frame inside Drupal page')/*, 2 => t('In the Drupal page') .'. ('. t('Except for ACP') .')'*/,
        ),
        '#description' => t("Change the way phpBB ACP is displayed in Drupal."),
      );
    }
    elseif ($_phpbb_integration_mode == 2) {
      $form['phpbbforum_page']['phpbbforum_page_frame_acp'] = array(
        '#type' => 'radios',
        '#title' => t('phpBB ACP display way'),
        '#default_value' => variable_get("phpbbforum_page_frame_acp", 0),
        '#options' => array(
          0 => t('In the window'),
          1 => t('In frame inside Drupal page')/*, 2 => t('In the Drupal page') .'. ('. t('Except for ACP') .')'*/,
        ),
        '#description' => t("Change the way phpBB ACP is displayed in Drupal."),
      );
      $form['phpbbforum_page']['phpbbforum_redirect'] = array(
        '#type' => 'radios',
        '#title' => t('phpBB redirects'),
        '#default_value' => variable_get('phpbbforum_redirect', 0),
        '#options' => array(
          0 => t('Using phpBB meta refresh'),
          1 => t('Immediate redirect'),
        ),
      );
    }

    $form['phpbbforum_topic'] = array(
      '#type' => 'fieldset',
      '#title' => t('phpBB topic submission settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );

    $form['phpbbforum_topic']['phpbbforum_submission'] = array(
      '#type' => 'radios',
      '#title' => t('Drupal to phpBB node submission'),
      '#default_value' => variable_get('phpbbforum_submission', true),
      '#options' => array(
        0 => t('Disabled'),
        1 => t('Enabled'),
      ),
      '#description' => t('Enable node submission to the phpBB forum. You should enable submission of appropriate content types in phpBBforum submission settings section.'),
    );
    /*
     $form['phpbbforum']['phpbbforum_commentlink_default'] = array(
     '#type' => 'checkbox',
     '#title' => t("Add comment link"),
     '#default_value' => variable_get('phpbbforum_commentlink_default_'.$form['#node_type']->type, 0),
     '#description' => t("Default setting")
     );
     */

    $form['phpbbforum_topic']['phpbbforum_commentlink_text_nocomments'] = array(
      '#type' => 'textfield',
      '#title' => t("Link text when no comments are posted"),
      '#default_value' => variable_get('phpbbforum_commentlink_text_nocomments', t('Discuss')),
    );

    $form['phpbbforum_topic']['phpbbforum_commentlink_text_comments'] = array(
      '#type' => 'textfield',
      '#title' => t("Link text when one or more comments are posted"),
      '#default_value' => variable_get('phpbbforum_commentlink_text_comments', t('Discuss')),
    );

    $form['phpbbforum_topic']['phpbbforum_topic_backlink_text'] = array(
      '#type' => 'textfield',
      '#title' => t("Drupal node backlink text in phpBB topic first post"),
      '#default_value' => variable_get('phpbbforum_topic_backlink_text', t('Read')),
    );

  }

  return system_settings_form($form);
}

