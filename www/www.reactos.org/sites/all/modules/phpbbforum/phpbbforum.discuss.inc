<?php
// $Id$
/**
 * @file
 * Drupal 7 compatible functions
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

/**
 * Create a new discussion forum topic for the given nid
 */
function phpbbforum_discuss_new($nid) {
  if (!_phpbbforum_settings() || !user_access('access phpBB forum') || !user_access('create phpBB forum topics') ||
      !variable_get('phpbbforum_submission', false)
      ) {
    drupal_access_denied();
    return;
  }
  _phpbbforum_discuss_goto_topic_if_exists($nid);
  drupal_goto('phpbbforum/discuss/create/' . $nid);
}

function _phpbbforum_discuss_goto_topic_if_exists($nid) {
  $postInformation = _phpbbforum_get_post_information($nid);
  if (!empty($postInformation['forum_id']) && is_numeric($postInformation['forum_id'])) {
    global $phpbb_config, $site_forum_url, $_phpbb_integration_mode, $phpbb_root_path, $phpEx;
    $phpbb_url = $phpbb_config['forum_url'];
    if ($_phpbb_integration_mode == 1 || $_phpbb_integration_mode == 2) {
      $phpbb_url = $site_forum_url;
    }
    $href = html_entity_decode(append_sid("{$phpbb_url}/viewtopic.$phpEx", "f=" . $postInformation['forum_id'] . "&t=" . $postInformation['topic_id'] . "#p" . $postInformation['post_id']));
    // go to the topic
    drupal_goto($href);
  }
}

/**
 */
function phpbbforum_discuss_create_form($form, $form_state, $nid) {
  if (!_phpbbforum_settings() || !user_access('access phpBB forum') || !user_access('create phpBB forum topics') ||
      !variable_get('phpbbforum_submission', false)
      ) {
    drupal_access_denied();
    return;
  }
  phpbb_api_session_begin();

  global $user, $phpbb_user;

  $node = node_load($nid);
  if (!is_object($node)) {
    return;
  }

  $op = $form_state['post']['op'];
  $is_ready = $op == t('Preview') || $op == t('Save');

  $defaults = _phpbbforum_get_defaults($node->nid, $node->type);

  $form['phpbbforum_discuss'] = array(
    '#type' => 'fieldset',
    '#title' => t('phpBBforum submission settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );

  $form['phpbbforum_discuss']['phpbbforum_forumid'] = array(
    '#type' => 'select',
    '#title' => t('Submit this node to'),
    '#default_value' => $defaults['forum'],
    '#description' => t('If you choose a forum, a phpbb topic with the node\'s content will be created in the specified forum.'),
    '#options' => _phpbbforum_get_forums($phpbb_user->data['user_id'],
        variable_get('phpbbforum_submission_forum_ids_list_' . $node->type, ''),
        variable_get('phpbbforum_submission_forum_ids_exclude_' . $node->type, 1)
      ),
  );

  $form['phpbbforum_discuss']['phpbbforum_submission_teaser'] = array(
    '#type' => 'radios',
    '#title' => t('Create a post from teaser or full node content'),
    '#default_value' => variable_get('phpbbforum_submission_teaser_' . $node->type, 1),
    '#options' => array(
      0 => t('Full node content'),
      1 => t('Teaser'),
      2 => t('No node content. Back link only, if enabled.'),
    ),
    '#description' => t('Create a post to the phpBB forum from teaser or full node content?'),
  );

  $form['phpbbforum_discuss']['nid'] = array(
    '#type' => 'value',
    '#value' => $nid,
  );

  $form['phpbbforum_discuss']['node'] = array(
    '#type' => 'value',
    '#value' => $node,
  );

  $form['buttons']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
    '#weight' => 50,
  );
  $form['buttons']['cancel'] = array(
    '#type' => 'submit',
    '#value' => t('Cancel'),
    '#submit' => array('phpbbforum_discuss_create_form_submit_cancel'),
    '#weight' => 51,
  );

  return $form;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_discuss_create_form_submit($form, &$form_state) {
  $node = $form_state['values']['node'];
  if (!$node || !is_numeric($node->nid)) {
    return;
  }
  _phpbbforum_discuss_goto_topic_if_exists($node->nid);

  $form_state['redirect'] = "node/$node->nid";

  if (!variable_get('phpbbforum_submission', true) || !variable_get('phpbbforum_submission_' . $node->type, false)) {
    return;
  }

  $phpbbforum_forumid = $form_state['values']['phpbbforum_forumid'];
  if ($phpbbforum_forumid == 0) {
    return;
  }
  $phpbbforum_commentlink = 1;
  $phpbbforum_submission_teaser = $form_state['values']['phpbbforum_submission_teaser'];
  
  $langcode = $node->language;
 
  if ($phpbbforum_submission_teaser != 2) {
    if ($phpbbforum_submission_teaser == 1 && !empty($node->body[$langcode][0]['summary'])) {
      //$nodetext = $node->body[$langcode][0]['summary'];
      $content = node_view($node, 'teaser', $langcode);
    }
    else {
      //$nodetext = $node->body[$langcode][0]['value'];
      $content = node_view($node, 'full', $langcode);
    }
    $nodetext = $content['body'][0]['#markup'];
    $nodetext = str_replace(array("\r\n", "\r", "\n"), '', $nodetext);
  }
  else {
    $nodetext = '';
  }

  global $phpbb_config, $phpbb_user, $base_url, $phpbb_root_path,
    $site_base_url, $site_phpbb_page, $site_forum_url, $_phpbb_integration_mode;

  if (variable_get('phpbbforum_backlink_default_' . $node->type, 1)) {
    $backlink = 'node/' . $node->nid;
    $title = variable_get('phpbbforum_topic_backlink_text_' . $node->type, variable_get('phpbbforum_topic_backlink_text', t('Read')));
    $a_backlink = l($title, $backlink, array('title' => $title, 'absolute' => true));
    $message = $nodetext . '<div class="topic-backlink"><p>' . $a_backlink . '</p></div>';
  }
  else {
    $message = $nodetext;
  }

  $data['forum_id'] = $phpbbforum_forumid;
  $data['topic_title'] = check_plain($node->title);
  $data['message'] = $message;
  $data['message_md5'] = md5($message);
  $approved = ($node->status == 1) ? 1 : 0;
  $data['topic_approved'] = $approved;
  $data['post_approved'] = $approved;
  $data['icon_id'] = 1;
  $data['enable_bbcode'] = 1;
  $data['enable_smilies'] = 1;
  $data['enable_urls'] = 1;
  $data['enable_sig'] = 1;
  $data['bbcode_bitfield'] = '';
  $data['bbcode_uid'] = '';
  $data['post_edit_locked'] = 0;
  $poll = array();

  $data['topic_id'] = 0;

  phpbb_api_submit_post('post', $node->title, $phpbb_user->data['username'], POST_NORMAL, $poll, $data);

  if (isset($data['topic_id']) && is_numeric($data['topic_id'])) {
    /* db_query('INSERT INTO {drupal2phpbb} (node_id, topic_id, linked) VALUES (%d, %d, %d)', $node->nid, $data['topic_id'], $phpbbforum_commentlink) */
    $id = db_insert('drupal2phpbb')
      ->fields(array(
          'node_id' => $node->nid,
          'topic_id' => $data['topic_id'],
          'linked' => $phpbbforum_commentlink,
        ))
      ->execute();

    _phpbbforum_variable_set('phpbbforum_forumid_default_' . $node->type, $phpbbforum_forumid);
    _phpbbforum_variable_set('phpbbforum_commentlink_default_' . $node->type, $phpbbforum_commentlink);
  }
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_discuss_create_form_submit_cancel($form, &$form_state) {
  $nid = $form_state['values']['nid'];
  $form_state['redirect'] = "node/$nid";
}

/**
 * Specifies the default parameters for the node.
 * Checks if the node was already submitted and gets the parameters used.
 *
 * @param integer $nid
 * @return array default: array ('forum' => 0, 'linked' => 0);
 */
function _phpbbforum_get_post_information($nid) {
  $result = db_query('SELECT topic_id, linked FROM {drupal2phpbb} WHERE node_id = :node_id', array(':node_id' => $nid));
  $topic = $result->fetchObject();
  $postInformation = array();
  $postInformation['forum_id'] = 0;
  if ($topic != false) {
    if (_phpbbforum_settings()) {
      //phpbb_api_session_begin();
      $postInformation = phpbb_api_get_post_information($topic->topic_id);
      $postInformation['linked'] = $topic->linked;
    }
  }
  return $postInformation;
}

/**
 * Specifies the default parameters for the node.
 * Checks if the node was already submitted and gets the parameters used.
 *
 * @param integer $node_id
 * @return array default: array ('forum' => 0, 'linked' => 0);
 */
function _phpbbforum_get_defaults($node_id, $node_type) {
  $defaults = array(
    'forum' => _phpbbforum_variable_get('phpbbforum_forumid_default_' . $node_type, 0),
    'linked' => _phpbbforum_variable_get('phpbbforum_commentlink_default_' . $node_type, 1),
  );
  if (!is_numeric($node_id)) {
    return $defaults;
  }
  $postInformation = _phpbbforum_get_post_information($node_id);
  if (!empty($postInformation['forum_id']) && is_numeric($postInformation['forum_id'])) {
    $defaults['forum'] = $postInformation['forum_id'];
    $defaults['linked'] = $postInformation['linked'];
  }
  return $defaults;
}

/**
 * Returns an array with the forums, in which the user can create a thread
 * and post messages.
 *
 * @param integer $user_id
 * @return array (forum_id => forum_name);
 */
function _phpbbforum_get_forums($user_id, $forum_ids = '', $exclude = 0) {
  if (_phpbbforum_settings()) {
    $forums = phpbb_api_get_forums($user_id, $forum_ids, $exclude);
  }
  $forums[0] = t('Don\'t submit this node');
  return $forums;
}

/**
 * Validates the given forum_id against the accessable forums of the current user.
 *
 * @param integer $forum_id
 * @return boolean false on error true otherwise
 */
function _phpbbforum_nodeapi_validate_forumid($forum_id) {
  $return = false;
  if (!is_numeric($forum_id)) {
    return $return;
  }
  phpbb_api_session_begin();

  global $phpbb_user;

  $forums = phpbb_api_get_forums($phpbb_user->data['user_id']);
  if (isset($forums[$forum_id])) {
    $return = true;
  }
  return $return;
}

/**
 * Implements phpbbforum_discuss_node_type_form_alter() in hook_form_alter().
 */
function phpbbforum_discuss_node_type_form_alter(&$form, $form_state, $form_id) {
  $node_type = $form['#node_type']->type;

  $form['phpbbforum'] = array(
    '#type' => 'fieldset',
    '#title' => t('phpBBforum submission settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'additional_settings',
  );

  $form['phpbbforum']['phpbbforum_submission'] = array(
    '#type' => 'radios',
    '#title' => t('Drupal to phpBB submission'),
    '#default_value' => variable_get('phpbbforum_submission_' . $node_type, 0),
    '#options' => array(
      0 => t('Disabled'),
      1 => t('Enabled'),
    ),
    '#description' => t('Should this node be able to submit a post to the phpBB forum?'),
  );

  $form['phpbbforum']['phpbbforum_submission_teaser'] = array(
    '#type' => 'radios',
    '#title' => t('Create a post from summary or full node content'),
    '#default_value' => variable_get('phpbbforum_submission_teaser_' . $node_type, 1),
    '#options' => array(
      0 => t('Full node content'),
      1 => t('Summary'),
      2 => t('No node content. Back link only, if enabled.'),
    ),
    '#description' => t('Create a post to the phpBB forum from summary or full node content?'),
  );

  $form['phpbbforum']['phpbbforum_backlink_default'] = array(
    '#type' => 'checkbox',
    '#title' => t("Add back link"),
    '#default_value' => variable_get('phpbbforum_backlink_default_' . $node_type, 1),
    '#description' => t("Default back link setting"),
  );

  $form['phpbbforum']['phpbbforum_commentlink_default'] = array(
    '#type' => 'checkbox',
    '#title' => t("Add comment link"),
    '#default_value' => variable_get('phpbbforum_commentlink_default_' . $node_type, 1),
    '#description' => t("Default comment link setting"),
  );

  $form['phpbbforum']['phpbbforum_commentlink_text_nocomments'] = array(
    '#type' => 'textfield',
    '#title' => t("Link text when no comments are posted"),
    '#default_value' => variable_get('phpbbforum_commentlink_text_nocomments_' . $node_type, variable_get('phpbbforum_commentlink_text_nocomments', t('Discuss'))),
  );

  $form['phpbbforum']['phpbbforum_commentlink_text_comments'] = array(
    '#type' => 'textfield',
    '#title' => t("Link text when one or more comments are posted"),
    '#default_value' => variable_get('phpbbforum_commentlink_text_comments_' . $node_type, variable_get('phpbbforum_commentlink_text_comments', t('Discuss'))),
  );

  $form['phpbbforum']['phpbbforum_topic_backlink_text'] = array(
    '#type' => 'textfield',
    '#title' => t("Drupal node backlink text in phpBB topic first post"),
    '#default_value' => variable_get('phpbbforum_topic_backlink_text_' . $node_type, variable_get('phpbbforum_topic_backlink_text', t('Read'))),
  );

  $form['phpbbforum']['phpbbforum_submission_forum_ids_exclude'] = array(
    '#type' => 'radios',
    '#title' => t('Include or exclude phpBB forum ids in the list'),
    '#default_value' => variable_get('phpbbforum_submission_forum_ids_exclude_' . $node_type, 1),
    '#options' => array(
      0 => t('Include'),
      1 => t('Exclude'),
    ),
    //'#description' => t('Include or exclude phpBB forum ids in the list'),
  );

  $form['phpbbforum']['phpbbforum_submission_forum_ids_list'] = array(
    '#type' => 'textfield',
    '#title' => t('phpBB forum id list'),
    '#default_value' => variable_get('phpbbforum_submission_forum_ids_list_' . $node_type, ''),
    '#description' => t('Enter phpBB forum id list, for example, 2,5,6,12'),
  );
/*
  $form['phpbbforum']['phpbbforum_comments'] = array(
    '#type' => 'fieldset',
    '#title' => t('Display phpBBforum comments'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['phpbbforum']['phpbbforum_comments']['phpbbforum_comment_location'] = array(
    '#type' => 'checkbox',
    '#title' => t("Display phpBB topic comments below the post"),
    '#default_value' => variable_get('phpbbforum_comment_location_' . $node_type, 0),
  );

  $form['phpbbforum']['phpbbforum_comments']['phpbbforum_comment_drupal'] = array(
    '#type' => 'checkbox',
    '#title' => t("Display both Drupal and phpBB comments"),
    '#default_value' => variable_get('phpbbforum_comment_drupal_' . $node_type, 0),
  );

  $form['phpbbforum']['phpbbforum_comments']['phpbbforum_submission_view_teaser'] = array(
    '#type' => 'checkbox',
    '#title' => t('View phpBB comments in summary'),
    '#default_value' => variable_get('phpbbforum_submission_view_teaser_' . $node_type, 0),
    //'#description' => t('View phpBB comments in summary or in full node content?'),
  );
  $form['phpbbforum']['phpbbforum_comments']['phpbbforum_submission_view_body'] = array(
    '#type' => 'checkbox',
    '#title' => t('View phpBB comments in full node'),
    '#default_value' => variable_get('phpbbforum_submission_view_body_' . $node_type, 1),
  );
  $form['phpbbforum']['phpbbforum_comments']['phpbbforum_submission_append_to_content'] = array(
    '#type' => 'checkbox',
    '#title' => t('Append phpBB comments to node'),
    '#default_value' => variable_get('phpbbforum_submission_append_to_content_' . $node_type, 0),
    '#description' => t('Advanced. Direct append of phpBB comments to node instead of using variable $phpbbforum_comments in') . ' node-' . $form['#node_type']->type . '.tpl.php',
  );
*/
  return $form;
}

/**
 * Implements phpbbforum_discuss_node_edit_form_alter() in hook_form_alter().
 */
function phpbbforum_discuss_node_edit_form_alter(&$form, $form_state, $form_id) {
  if (!_phpbbforum_settings()) {
    return;
  }
  phpbb_api_session_begin();

  global $phpbb_user;

  $node = $form['#node'];

  if (isset($node->nid)) {
    $nid = $node->nid;
  }
  else {
    $nid = 0;
  }
  
  $defaults = _phpbbforum_get_defaults($nid, $node->type);

  $form['phpbbforum'] = array(
    '#type' => 'fieldset',
    '#title' => t('phpBBforum submission settings'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#group' => 'additional_settings',
  );

  $form['phpbbforum']['phpbbforum_forumid'] = array(
    '#type' => 'select',
    '#title' => t('Submit this node to'),
    '#default_value' => $defaults['forum'],
    '#description' => t('If you choose a forum, a phpbb topic with the node\'s content will be created in the specified forum.'),
    '#options' => _phpbbforum_get_forums($phpbb_user->data['user_id'],
      variable_get('phpbbforum_submission_forum_ids_list_' . $node->type, ''),
      variable_get('phpbbforum_submission_forum_ids_exclude_' . $node->type, 1)
    ),
  );

  $form['phpbbforum']['phpbbforum_submission_teaser'] = array(
    '#type' => 'radios',
    '#title' => t('Create a post from summary or full node content'),
    '#default_value' => variable_get('phpbbforum_submission_teaser_' . $node->type, 1),
    '#options' => array(
      0 => t('Full node content'),
      1 => t('Summary'),
      2 => t('No node content. Back link only, if enabled.'),
    ),
    '#description' => t('Create a post to the phpBB forum from summary or full node content?'),
  );

  $form['phpbbforum']['phpbbforum_commentlink'] = array(
    '#type' => 'checkbox',
    '#title' => t('Add comment link'),
    '#default_value' => $defaults['linked'],
  );

  return $form;
}

/**
 * Preprocessing node template.
 */
/*
function phpbbforum_preprocess_node(&$vars) {
  $node = $vars['node'];

  if (variable_get('phpbbforum_submission', true) && variable_get('phpbbforum_submission_' . $node->type, false) && user_access('access phpBB comments')) {
    $enabled = variable_get('phpbbforum_comment_location_' . $node->type, 0);
    if ($enabled) {

      if (!_phpbbforum_settings()) {
        return;
      }

      $teaser = $vars['teaser'];

      $result = db_query("SELECT topic_id, linked FROM {drupal2phpbb} WHERE node_id = :node_id", array(':node_id' => $node->nid));
      $post = $result->fetchObject();
      if ($post !== false) {
        global $phpbb_config, $site_base_url, $site_forum_url, $_phpbb_integration_mode, $phpbb_root_path, $phpEx;
        global $_phpbbforum_comments_mode;

        $postInformation = phpbb_api_get_post_information($post->topic_id);

        $phpbb_url = $phpbb_config['forum_url'];
        if ($_phpbb_integration_mode == 1 || $_phpbb_integration_mode == 2) {
          $phpbb_url = $site_forum_url;
        }

        $href = html_entity_decode(append_sid("{$phpbb_url}/viewtopic.$phpEx", "f=" . $postInformation['forum_id'] . "&t=" . $postInformation['topic_id'] . "#p" . $postInformation['post_id']));

        $render = false;
        if ($_phpbb_integration_mode == 2) {
          if ($teaser) {
            $teaser_render = variable_get('phpbbforum_submission_view_teaser_' . $node->type, 0);
            if ($teaser_render) {
              $render = true;
            }
          }
          else {
            $body_render = variable_get('phpbbforum_submission_view_body_' . $node->type, 1);
            if ($body_render) {
              $render = true;
            }
          }
        }

        $query = array();

        $vars['phpbbforum_comments'] = _phpbbforum_comment_render($node, $href, $render, $query);

        if ($_phpbb_integration_mode == 2) {
          if (variable_get('phpbbforum_submission_append_to_content_' . $node->type, 0)) {
            if ($vars['phpbbforum_comments']) {
              $phpbbforum_comments_render = '<div id="phpbbforum-node-comments">';
              $phpbbforum_comments_render .= $vars['phpbbforum_comments'];
              $phpbbforum_comments_render .= '</div>';
              $vars['content'] .= $phpbbforum_comments_render;
              $vars['phpbbforum_comments'] = '';
            }
          }
        }

        if (!variable_get('phpbbforum_comment_drupal_' . $node->type, 0)) {
          $node->comment = null;
          if (!empty($node->links)) {
            $refresh = false;
            if (module_exists('comment')) {
              if (user_access('post phpBB comments')) {
                $node->links['comment_add']['title'] = t('Add new comment');
                $node->links['comment_add']['href'] = _phpbbforum_posting_destination($query);
                $node->links['comment_add']['fragment'] = null;
                $refresh = true;
              }
              if (isset($node->links['comment_forbidden'])) {
                unset($node->links['comment_forbidden']);
                $refresh = true;
              }
            }
            if ($refresh) {
              // refresh $links
              $vars['links'] = theme('links', array('links' => $node->links, 'attributes' => array('class' => 'links inline')));
            }
          }
        }
      }
    }
  }
}
*/
  
/**
 * Implements hook_node_validate().
 */
function phpbbforum_node_validate($node, $form, &$form_state) {
  if (variable_get('phpbbforum_submission_' . $node->type, false)) {
    if (!_phpbbforum_settings()) {
      return;
    }
    if (!empty($node->phpbbforum_forumid) && !_phpbbforum_nodeapi_validate_forumid($node->phpbbforum_forumid)) {
      form_set_error('phpbbforum_forumid', t('Cannot submit node to the selected forum. Please try again.'));
    }
  }
}

/**
 * Implements hook_node_insert().
 */
function phpbbforum_discuss_node_insert($node) {
  if (!_phpbbforum_settings()) {
    return;
  }
  phpbb_api_session_begin();

  global $phpbb_config, $phpbb_user, $base_url, $phpbb_root_path, $user,
        $site_base_url, $site_phpbb_page, $site_forum_url, $_phpbb_integration_mode;

  $phpbbforum_forumid = $node->phpbbforum_forumid;
  if ($node->phpbbforum_commentlink != 1) {
    $node->phpbbforum_commentlink = 0;
  }
  $phpbbforum_commentlink = $node->phpbbforum_commentlink;
  $phpbbforum_submission_teaser = $node->phpbbforum_submission_teaser;
  
  $langcode = $node->language;
 
  if ($phpbbforum_submission_teaser != 2) {
    if ($phpbbforum_submission_teaser == 1 && !empty($node->body[$langcode][0]['summary'])) {
      //$nodetext = $node->body[$langcode][0]['summary'];
      $content = node_view($node, 'teaser', $langcode);
    }
    else {
      //$nodetext = $node->body[$langcode][0]['value'];
      $content = node_view($node, 'full', $langcode);
    }
    $nodetext = $content['body'][0]['#markup'];
    $nodetext = str_replace(array("\r\n", "\r", "\n"), '', $nodetext);
  }
  else {
    $nodetext = '';
  }

  if (variable_get('phpbbforum_backlink_default_' . $node->type, 1)) {
    $backlink = 'node/' . $node->nid;
    $title = variable_get('phpbbforum_topic_backlink_text_' . $node->type, variable_get('phpbbforum_topic_backlink_text', t('Read')));
    $a_backlink = l($title, $backlink, array('title' => $title, 'absolute' => true));
    $message = $nodetext . '<div class="topic-backlink"><p>' . $a_backlink . '</p></div>';
  }
  else {
    $message = $nodetext;
  }

        
  $data['forum_id'] = $phpbbforum_forumid;
  $data['topic_title'] = check_plain($node->title);
  $data['message'] = $message;
  $data['message_md5'] = md5($message);
  $approved = ($node->status == 1) ? 1 : 0;
  $data['topic_approved'] = $approved;
  $data['post_approved'] = $approved;
  $data['icon_id'] = 1;
  $data['enable_bbcode'] = 1;
  $data['enable_smilies'] = 1;
  $data['enable_urls'] = 1;
  $data['enable_sig'] = 1;
  $data['bbcode_bitfield'] = '';
  $data['bbcode_uid'] = '';
  $data['post_edit_locked'] = 0;
  $poll = array();

  $result = db_query("SELECT topic_id FROM {drupal2phpbb} WHERE node_id = :node_id", array(':node_id' => $node->nid));
  $post = $result->fetchObject();
  if ($post !== false) {
    $postInformation = phpbb_api_get_post_information($post->topic_id);
    if ($postInformation['forum_id'] == 0) {
      /* db_query("DELETE FROM {drupal2phpbb} WHERE node_id = %d", $node->nid) */
      db_delete('drupal2phpbb')
        ->condition('node_id', $node->nid)
        ->execute();
      $post = false;
    }
  }
  if ($post === false) {
    $data['topic_id'] = 0;

    phpbb_api_submit_post('post', $node->title, $phpbb_user->data['username'], POST_NORMAL, $poll, $data);

    if (is_numeric($node->nid) && isset($data['topic_id']) && is_numeric($data['topic_id'])) {
      /* db_query('INSERT INTO {drupal2phpbb} (node_id, topic_id, linked) VALUES (%d, %d, %d)', $node->nid, $data['topic_id'], $node->phpbbforum_commentlink) */
      $id = db_insert('drupal2phpbb')
        ->fields(array(
              'node_id' => $node->nid,
              'topic_id' => $data['topic_id'],
              'linked' => $phpbbforum_commentlink,
            ))
        ->execute();
    }
  }
  else {
    $postInformation = phpbb_api_get_post_information($post->topic_id);

    $data['topic_id'] = $post->topic_id;
    $data['topic_replies_real'] = $postInformation['countPosts'];
    $data['topic_first_post_id'] = $postInformation['post_id'];
    $data['post_id'] = $postInformation['post_id'];
    $data['poster_id'] = (int) $phpbb_user->data['user_id'];
    $data['post_edit_reason'] = t('Edit');

    phpbb_api_submit_post('edit', $node->title, $phpbb_user->data['username'], POST_NORMAL, $poll, $data, TRUE);

    if (is_numeric($node->nid) && isset($data['topic_id']) && is_numeric($data['topic_id'])) {
      /* db_query('UPDATE {drupal2phpbb} SET topic_id = %d, linked = %d WHERE node_id = %d', $data['topic_id'], $node->phpbbforum_commentlink, $node->nid) */
      db_update('drupal2phpbb')
        ->fields(array(
              'topic_id' => $data['topic_id'],
              'linked' => $phpbbforum_commentlink,
            ))
        ->condition('node_id', $node->nid)
        ->execute();
    }
  }
  _phpbbforum_variable_set('phpbbforum_forumid_default_' . $node->type, $phpbbforum_forumid);
  _phpbbforum_variable_set('phpbbforum_commentlink_default_' . $node->type, $phpbbforum_commentlink);
}

/**
 * Implements hook_node_update().
 */
function phpbbforum_discuss_node_update($node) {
  phpbbforum_discuss_node_insert($node);
}

/**
 * Implements hook_node_view().
 */
function phpbbforum_discuss_node_view($node, $view_mode) {
  global $phpbb_config, $site_base_url, $site_forum_url, $_phpbb_integration_mode, $phpbb_root_path, $phpEx;

  $phpbb_url = $phpbb_config['forum_url'];
  if ($_phpbb_integration_mode == 1 || $_phpbb_integration_mode == 2) {
    $phpbb_url = $site_forum_url;
  }

  $links = array();

  $postInformation = _phpbbforum_get_post_information($node->nid);

  if (empty($postInformation['forum_id'])) {
    $title = t(variable_get('phpbbforum_commentlink_text_nocomments_' . $node->type, t('Discuss')));
    $href = 'phpbbforum/discuss/new/' . $node->nid;
    if (user_access('create phpBB forum topics')) {
      $links['phpbbforum_comment'] = array(
        'title' => $title,
        'href' => $href,
        'attributes' => array(
          'class' => 'phpbbforum-discuss-link',
          'title' => t('Start a discussion about this page'),
          'rel' => 'nofollow',
        ),
      );
    }
  }
  else {
    //if ($_phpbb_integration_mode != 2  || (user_access('access phpBB forum') && user_access('access phpBB comments'))) {
    if ($postInformation['countPosts'] === 0) {
      $title = t(variable_get('phpbbforum_commentlink_text_nocomments_' . $node->type, t('Discuss')) . ' (!comments)', array('!comments' => format_plural($postInformation['countPosts'], '1 comment', '@count comments')));
    }
    else {
      $title = t(variable_get('phpbbforum_commentlink_text_comments_' . $node->type, t('Discuss')) . ' (!comments)', array('!comments' => format_plural($postInformation['countPosts'], '1 comment', '@count comments')));
    }
    $href = html_entity_decode(append_sid("{$phpbb_url}/viewtopic.$phpEx", "f=" . $postInformation['forum_id'] . "&t=" . $postInformation['topic_id'] . "#p" . $postInformation['post_id']));
    $links['phpbbforum_comment'] = array(
      'title' => $title,
      'href' => $href,
      'attributes' => array(
        'class' => 'phpbbforum-discuss-link',
        'title' => t('Participate to the discussion about this page'),
        'rel' => 'nofollow',
      ),
    );
    //}
  }

  $node->content['links']['phpbbforum'] = array(
    '#theme' => 'links__node__comment',
    '#links' => $links,
    '#attributes' => array('class' => array('links', 'inline')),
  );
}

/**
 * Implements hook_node_view().
 */
function phpbbforum_node_view($node, $view_mode) {
  if (/*$node->comment != COMMENT_NODE_HIDDEN &&*/ ($view_mode == 'full' || $view_mode == 'teaser')) {
    if (!_phpbbforum_settings() || !user_access('access phpBB forum') || !user_access('access phpBB comments') ||
        !variable_get('phpbbforum_submission', false) || !variable_get('phpbbforum_submission_' . $node->type, false)) {
      return;
    }
    phpbbforum_discuss_node_view($node, $view_mode);
  }
}

/**
 * Implements hook_node_view().
 */
/*
function phpbbforum_node_view($node, $view_mode = 'full') {
  if (module_exists('content_profile') && is_content_profile($node)) {
    if (!_phpbbforum_settings()) {
      return;
    }

    global $user, $phpbb_user;
    phpbb_api_session_begin();
    // TODO Convert "user_load" to "user_load_multiple" if "$node->uid" is other than a uid.
    // To return a single user object, wrap "user_load_multiple" with "array_shift" or equivalent.
    // Example: array_shift(user_load_multiple(array(), $node->uid))
    $account = user_load($node->uid);
    $phpbb_user_data = $phpbb_user->data;
    if (phpbb_api_get_user($account->name, '')) {
      phpbbforum_update_user_profile($op, PHPBB_SYNC_TO_DRUPAL, $account, array(), $node);
      if ($user->name != $account->name) {
        $phpbb_user->data = $phpbb_user_data;
      }
    }
  }
}
*/
