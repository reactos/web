<?php


/**
 * @file
 * Holds functions relating to the Mark Forum/All Read functionality.
 */

/**
 * Either fill a $links array or return a string version of the link to mark read.
 */
function advanced_forum_get_mark_read_link($tid = 0, &$links = array()) {
  if (advanced_forum_markasread_access() && !in_array($tid, variable_get('forum_containers', array()))) {
    if ($tid) {
      $links['mark-read']['title'] = t('Mark all topics read');
      $links['mark-read']['href'] = "forum/markasread/$tid";

      return l(t('Mark all topics read') . '<span class="image-replace"></span>', "forum/markasread/$tid", array('html' => TRUE));
    }
    else {
      $links['mark-read']['title'] = t('Mark all forums read');
      $links['mark-read']['href'] = "forum/markasread";

      return l(t('Mark all forums read') . '<span class="image-replace"></span>', "forum/markasread", array('html' => TRUE));
    }
  }
}

/**
 * Marks all posts in forums or in a given forum as read by the current user.
 */
function advanced_forum_markasread($current_forum_id = 0) {
  global $user;
  // See if we're on a forum or on the forum overview
  // Path will be /forum/markasread or /forum/markasread/tid
  if ($current_forum_id) {
    // Delete the current history entries so already visited nodes get updated.
    //
    // Can't write dynamic query here because D7 DeleteQuery (still) doesn't support joins
    $sql = "DELETE h
            FROM {history} AS h
              INNER JOIN {forum} AS f ON (h.nid = f.nid)
            WHERE h.uid = :uid AND f.tid = :tid";
    db_query($sql, array(':uid' => $user->uid, ':tid' => $current_forum_id));

    // Update the history table with all forum nodes newer than the cutoff.
    //
    // Can't write dynamic query here because D7 InsertQuery (still) doesn't support joins
    $sql = "INSERT INTO {history} (uid, nid, timestamp)
            SELECT DISTINCT :uid, n.nid, :req_time
            FROM {node} AS n
              INNER JOIN {forum} AS f ON (n.nid = f.nid)
              INNER JOIN {node_comment_statistics} AS ncs ON ncs.nid = n.nid
            WHERE (n.changed > :changed OR ncs.last_comment_timestamp > :timestamp) AND f.tid = :tid";

    db_query($sql, array(
      ':uid' => $user->uid,
      ':req_time' => REQUEST_TIME,
      ':changed' => NODE_NEW_LIMIT,
      ':timestamp' => NODE_NEW_LIMIT,
      ':tid' => $current_forum_id
    ));

    // Readpath integration
    if (module_exists('readpath')) {
      readpath_clear_readpath();
    }

    drupal_set_message(t('All content in this forum has been marked as read'));
    drupal_goto('forum/' . $current_forum_id);
  }

  // We are on the forum overview, requesting all forums be marked read
  $forum_vocabulary_id = variable_get('forum_nav_vocabulary', '');

  // Delete the current history entries so already visited nodes get updated.
  $sql = "DELETE h
          FROM {history} AS h
            INNER JOIN {forum} AS f ON (h.nid = f.nid)
            INNER JOIN {taxonomy_term_data} AS td ON (td.tid = f.tid)
          WHERE h.uid = :uid AND td.vid = :vid";

  db_query($sql, array(':uid' => $user->uid, ':vid' => $forum_vocabulary_id));

  // Update the history table with all forum nodes newer than the cutoff.
  $sql = "INSERT INTO {history} (uid, nid, timestamp)
            SELECT DISTINCT :uid, n.nid, :req_time
            FROM {node} AS n
              INNER JOIN {forum} AS f ON (n.nid = f.nid)
              INNER JOIN {node_comment_statistics} AS ncs ON ncs.nid = n.nid
              INNER JOIN {taxonomy_term_data} AS td ON f.tid = td.tid
            WHERE (n.changed > :changed OR ncs.last_comment_timestamp > :timestamp) AND td.vid = :vid";

   db_query($sql, array(
      ':uid' => $user->uid,
      ':req_time' => REQUEST_TIME,
      ':changed' => NODE_NEW_LIMIT,
      ':timestamp' => NODE_NEW_LIMIT,
      ':vid' => $forum_vocabulary_id
    ));

  drupal_set_message(t('All forum content been marked as read'));
  drupal_goto('forum');
}

/**
 * Access callback for menus and link display.
 *
 * @TODO: D7 check if needed
 *
 * This separate function is needed because the Drupal 6 menu system doesn't
 * run hook_menu() every time and the logged-in status of the user can get
 * cached and re-used for other users.
 */
function advanced_forum_markasread_access() {
  global $user;
  return user_access('access content') && $user->uid;
}

