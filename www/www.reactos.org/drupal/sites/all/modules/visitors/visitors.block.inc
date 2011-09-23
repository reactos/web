<?php

/* vim: set filetype=php: */

/**
 * @file
 * Display current visitor block.
 */

/**
 * Implements of hook_block_info().
 */
function visitors_block_info() {
  $blocks = array();
  $blocks[0]['info'] = t('Current visitor');
  $blocks[0]['cache'] = DRUPAL_NO_CACHE;

  return $blocks;
}

/**
 * Implements of hook_block_view().
 */
function visitors_block_view($delta = '') {
  $data = array();
  $data['subject'] = t('Visitors');
  $data['content'] = theme('visitors_block_view');

  return $data;
}

/**
 * Implement a theme function for block output.
 */
function theme_visitors_block_view() {
  $list_items = array();

  visitors_block_show_total_visitors($list_items);
  visitors_block_show_unique_visitors($list_items);
  visitors_block_registered_user($list_items);
  visitors_block_last_registered_user($list_items);
  visitors_block_published_nodes($list_items);
  visitors_block_user_ip($list_items);
  visitors_block_since_date($list_items);

  return theme('item_list', array('items' => $list_items, 'type' => 'ul'));
}

/**
 * Display total visitors count to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_show_total_visitors(&$list_items) {
  if (variable_get('visitors_show_total_visitors', 1)) {
    $query = 'SELECT COUNT(*) FROM {visitors}';
    $count = db_query($query)->fetchField();
    $list_items[] = t('Total Visitors: %visitors',
      array('%visitors' => $count)
    );
  }
}

/**
 * Display unique visitors count to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_show_unique_visitors(&$list_items) {
  if (variable_get('visitors_show_unique_visitor', 1)) {
    $query = 'SELECT COUNT(DISTINCT visitors_ip) FROM {visitors}';
    $unique_visitors = db_query($query)->fetchField();
    $list_items[] = t('Unique Visitors: %unique_visitors',
      array('%unique_visitors' => $unique_visitors)
    );
  }
}

/**
 * Display registered users count to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_registered_user(&$list_items) {
  if (variable_get('visitors_registered_user', 1)) {
    $query = 'SELECT COUNT(*) FROM {users} WHERE uid <> 0';
    $registered_user = db_query($query)->fetchField();
    $list_items[] = t('Registered Users: %registered_user',
      array('%registered_user' => $registered_user)
    );
  }
}

/**
 * Display last registered user to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_last_registered_user(&$list_items) {
  if (variable_get('visitors_last_registered_user', 1)) {
    $last_user_uid = db_select('users', 'u')
      ->fields('u', array('uid'))
      ->orderBy('uid', 'DESC')
      ->range(0, 1)
      ->execute()
      ->fetchField();
    $user = user_load($last_user_uid, TRUE);
    $list_items[] = t('Last Registered User: !last_user',
      array('!last_user' => theme('username', array('account' => $user)))
    );
  }
}

/**
 * Display published nodes count to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_published_nodes(&$list_items) {
  if (variable_get('visitors_published_nodes', 1)) {
    $query = 'SELECT COUNT(*) FROM {node} WHERE status = 1';
    $nodes = db_query($query)->fetchField();
    $list_items[] = t('Published Nodes: %nodes',
      array('%nodes' => $nodes)
    );
  }
}

/**
 * Display user ip to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_user_ip(&$list_items) {
  if (variable_get('visitors_user_ip', 1)) {
    $list_items[] = t('Your IP: %user_ip',
      array('%user_ip' => visitors_get_ip())
    );
  }
}

/**
 * Display the start date statistics to visitors block.
 *
 * @param $list_items
 *   array associative array of variables, use for theme function
 */
function visitors_block_since_date(&$list_items) {
  if (variable_get('visitors_since_date', 1)) {
    $query = 'SELECT visitors_date_time
      FROM {visitors}
      ORDER BY visitors_date_time ASC';
    $since_date = db_query_range($query, 0, 1)->fetchField();
    $list_items[] = t('Since: %since_date',
      array('%since_date' => format_date($since_date, 'short'))
    );
  }
}

