<?php
// $Id: phpbb_api_theme.php,v 1.6 2010/02/20 11:01:26 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

function theme_phpbb_api_whos_online($output, $options) {
  global $phpbb_config, $phpbb_user;

  if (empty($output)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no whos online';
    }
    return '';
  }
  extract($options, EXTR_SKIP);
  extract($output, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  $phpbb_site_img_path = $phpbb_url . '/styles/' . $phpbb_user->theme['theme_path'] . '/theme/images/';
  $phpbb_site_img_file = $phpbb_site_img_path . 'icon_members.gif';

  $strreturn = '';
  $str = '<a href="' . $phpbb_url . '/viewonline.php"><img src="' . $phpbb_site_img_file . '" alt="' . $phpbb_user->lang['WHO_IS_ONLINE'] . '" title="' . $phpbb_user->lang['WHO_IS_ONLINE'] . '" /></a>';
  $strreturn = $str . ' ';
  $strreturn .= $l_online_users;
  $strreturn .= '<br />';
  $strreturn .= $online_userlist;

  if ($output_method == 'echo') {
    echo $strreturn;
  }

  return $strreturn;
}

function theme_phpbb_api_recent_posts($posts, $options) {
  global $phpbb_config, $phpbb_user;

  if (empty($posts)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no posts';
    }
    return '';
  }

  extract($options, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  //$output_tag = "<ul>" "<div>" "<pre>"
  $output_tag = strtolower($output_tag);
  $output_end_tag = "";
  $output_tag2 = "";
  $output_end_tag2 = "";
  if (substr($output_tag, 0, 3) == "<ul" || substr($output_tag, 0, 3) == "<ol") {
    $output_end_tag = "</" . substr($output_tag, 1, 2) . ">";
    $output_tag2 = "<li>";
    $output_end_tag2 = "</li>";
  }
  elseif (substr($output_tag, 0, 4) == "<div") {
    $output_end_tag = "</div>";
  }
  elseif (substr($output_tag, 0, 4) == "<pre") {
    $output_end_tag = "</pre>";
  }
  elseif (substr($output_tag, 0, 2) == "<p") {
    $output_end_tag = "</p>";
  }

  $strposts = $str = '';
  //$str = '<a href="'. $phpbb_url .'"><img src="' . $.gif" alt="' . $phpbb_ . '" /></a>';
  //$strposts = $str . ' ';
  //$str = '<a href="' . $phpbb_url .'">' .$phpbb_ . '</a>';
  //$strposts .= $str;

  $strposts .= $output_tag;
  foreach ($posts as $post) {
    //$strnew = $post['new'] ? '' : '<a href="' . $phpbb_url . '?topic=' . $post['topic'] . '.msg' . $post['new_from'] . ';topicseen#new"><img src="' . $phpbb_config['theme']['images_url'] . '/' . $phpbb_user['language'] . '/new.gif" alt="' . $phpbb_txt[302] . '" /></a>';
    //$strnew .= ' ';

    // POST_SUBJECT
    if (!empty($post['POST_SUBJECT'])) {
      $shorten_subject = phpbb_shorten_subject($post['POST_SUBJECT'], 45);
    }
    else {
      $shorten_subject = phpbb_shorten_subject($post['TOPIC_TITLE'], 45);
    }

    $strnew = '<span class="phpbbforum_recent_subject">';
    $strimg = '<a href="' . $post['U_NEWEST_POST'] . '"><img src="' . $post['U_NEWEST_POST_IMG'] . '" alt="' . $post['NEWEST_POST_IMG_ALT'] . '" title="' . $post['NEWEST_POST_IMG_ALT'] . '" /></a>';
    $strimgicon = '';
    if ($post['TOPIC_ICON_IMG'] != '') {
      $strimgicon = '<a href="' . $post['U_VIEW_POST'] . '"><img src="' . $phpbb_url . '/images/icons/' . $post['TOPIC_ICON_IMG'];
      if (!empty($shorten_subject)) {
        $strimgicon .= '" alt="' . $shorten_subject . '" title="' . $shorten_subject;
      }
      $strimgicon .= '" /></a>';
      $strimgicon .= '&nbsp;';
    }
    if (!empty($shorten_subject)) {
      $str = 	'<a href="' . $post['U_VIEW_POST'] . '">' . $shorten_subject . '</a>';
    }
    else {
      $str = '';
    }
    //$strposts .= $str . $output_br;
    if ($display_topic_new_icon_pos == 0) {
      $strposts .= $output_tag2 . $strnew . $strimgicon . $strimg . '&nbsp;' . $str . '</span>';
    }
    else {
      $strposts .= $output_tag2 . $strnew . $strimgicon . $str . '&nbsp;' . $strimg . '</span>';
    }

    if ($display_mode != 1) {
      if (!empty($shorten_subject)) {
        $strposts .= $output_br;
      }
      // POST_AUTHOR_FULL
      $strnew = '<span class="phpbbforum_recent_author">';
      $posterlink = $post['POST_AUTHOR_FULL'];
      $strimg = '<a href="' . $post['U_VIEW_POST'] . '"><img src="' . $post['U_LAST_POST_IMG'] . '" alt="' . $post['LAST_POST_IMG_ALT'] . '" title="' . $post['LAST_POST_IMG_ALT'] . '" /></a>';
      $str = $strnew . $posterlink . '&nbsp;' . $strimg . '</span>';

      $strposts .= $str . $output_br;
      // POST_DATE
      $strnew = '<span class="phpbbforum_recent_date">';
      $str = $strnew . $post['POST_DATE'] . '</span>';
      $strposts .= $str . $output_br;
      // FORUM_TITLE
      $strnew = '<span class="phpbbforum_recent_title">';
      $str = 	'<a href="' . $post['U_VIEW_FORUM'] . '">' . phpbb_shorten_subject($post['FORUM_TITLE'], 45) . '</a>';
      $strposts .= $strnew . $str . '</span>';
    }
    $strposts .= $output_end_tag2;
  }
  $strposts .= $output_end_tag;

  if ($output_method == 'echo') {
    echo $strposts;
  }

  return $strposts;
}

function theme_phpbb_api_recent_topics($posts, $options) {
  global $phpbb_config, $phpbb_user;

  if (empty($posts)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no posts';
    }
    return '';
  }

  extract($options, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  //$output_tag = "<ul>" "<div>" "<pre>"
  $output_tag = strtolower($output_tag);
  $output_end_tag = "";
  $output_tag2 = "";
  $output_end_tag2 = "";
  if (substr($output_tag, 0, 3) == "<ul" || substr($output_tag, 0, 3) == "<ol") {
    $output_end_tag = "</" . substr($output_tag, 1, 2) . ">";
    $output_tag2 = "<li>";
    $output_end_tag2 = "</li>";
  }
  elseif (substr($output_tag, 0, 4) == "<div") {
    $output_end_tag = "</div>";
  }
  elseif (substr($output_tag, 0, 4) == "<pre") {
    $output_end_tag = "</pre>";
  }
  elseif (substr($output_tag, 0, 2) == "<p") {
    $output_end_tag = "</p>";
  }

  $strposts = $str = '';

  //$strposts = $phpbb_config['error_msg'];

  //$str = '<a href="'. $phpbb_url . '"><img src="' . $.gif" alt="' . $phpbb_ . '" /></a>';
  //$strposts = $str . ' ';
  //$str = '<a href="' . $phpbb_url . '">' .$phpbb_ . '</a>';
  //$strposts .= $str;

  $strposts .= $output_tag;
  foreach ($posts as $post) {

    // POST_SUBJECT
    $shorten_subject = phpbb_shorten_subject($post['TOPIC_TITLE'], 45);

    $strnew = '<span class="phpbbforum_recent_subject">';
    $strimg = '<a href="' . $post['U_NEWEST_POST'] . '"><img src="' . $post['U_NEWEST_POST_IMG'] . '" alt="' . $post['NEWEST_POST_IMG_ALT'] . '" title="' . $post['NEWEST_POST_IMG_ALT'] . '" /></a>';
    $strimgicon = '';
    if ($post['TOPIC_ICON_IMG'] != '') {
      $strimgicon = '<a href="' . $post['U_VIEW_TOPIC'] . '"><img src="' . $phpbb_url . '/images/icons/' . $post['TOPIC_ICON_IMG'] . '" alt="' . $shorten_subject . '" title="' . $shorten_subject . '" /></a>';
      $strimgicon .= '&nbsp;';
    }
    $str = '<a href="' . $post['U_VIEW_TOPIC'] . '">' . $shorten_subject . '</a>';
    if ($display_topic_new_icon_pos == 0) {
      $strposts .= $output_tag2 . $strnew . $strimgicon . $strimg . '&nbsp;' . $str . '</span>';
    }
    else {
      $strposts .= $output_tag2 . $strnew . $strimgicon . $str . '&nbsp;' . $strimg . '</span>';
    }

    if ($display_mode != 1) {
      $strposts .= $output_br;
      // POST_AUTHOR_FULL
      $strnew = '<span class="phpbbforum_recent_author">';
      $posterlink = $post['LAST_POST_AUTHOR_FULL'];
      $strimg = '<a href="' . $post['U_LAST_POST'] . '"><img src="' . $post['U_LAST_POST_IMG'] . '" alt="' . $post['LAST_POST_IMG_ALT'] . '" title="' . $post['LAST_POST_IMG_ALT'] . '" /></a>';
      $str = $strnew . $posterlink . '&nbsp;' . $strimg . '</span>';

      $strposts .= $str . $output_br;
      // POST_DATE
      $strnew = '<span class="phpbbforum_recent_date">';
      $str = $strnew . $post['LAST_POST_TIME'] . '</span>';
      $strposts .= $str . $output_br;
      // FORUM_TITLE
      $strnew = '<span class="phpbbforum_recent_title">';
      $str = '<a href="' . $post['U_VIEW_FORUM'] . '">' . phpbb_shorten_subject($post['FORUM_TITLE'], 45) . '</a>';
      $strposts .= $strnew . $str . '</span>';
    }

    /*
     $strnew = '<a href="' . $post['U_NEWEST_POST'] . '"><img src="' . $post['U_NEWEST_POST_IMG'] . '" alt="' . $post['NEWEST_POST_IMG_ALT'] . '" title="' . $post['NEWEST_POST_IMG_ALT'] . '" /></a>';
     $strnew .= ' ';
     $str = '<a href="' . $post['U_VIEW_TOPIC'] . '">' . phpbb_shorten_subject($post['TOPIC_TITLE'], 45) . '</a>';
     //$strposts .= $str . $output_br; $post['U_LAST_POST'] LAST_POST_SUBJECT
     $strposts .= $output_tag2 . $strnew . $str;

     if ($display_mode == 0) {
     $strposts .= $output_br;
     $posterlink = //empty($post['POST_AUTHOR_FULL']) ? $post['POST_AUTHOR_FULL'] :
     $post['LAST_POST_AUTHOR_FULL'];
     //'<a href="' . $post['POST_AUTHOR_FULL'] . '">' . $post['POST_AUTHOR'] . '</a>';
     $strnew = '<a href="' . $post['U_LAST_POST'] . '"><img src="' . $post['U_LAST_POST_IMG'] . '" alt="' . $post['LAST_POST_IMG_ALT'] . '" title="' . $post['LAST_POST_IMG_ALT'] . '" /></a>';
     $str = 	$posterlink . ' ' . $strnew . '<br />' . $post['LAST_POST_TIME'];
     //$str = 	 . ' ' . $post['POST_AUTHOR_FULL'] . ' (' . $post['FORUM_TITLE'] . ')';
     $strposts .= $str . $output_br;
     //$str = 	$post['U_VIEW_FORUM'];
     $str = '<a href="' . $post['U_VIEW_FORUM'] . '">' . phpbb_shorten_subject($post['FORUM_TITLE'], 45) . '</a>';
     $strposts .= $str;
     }
     */
    $strposts .= $output_end_tag2;
  }
  $strposts .= $output_end_tag;

  if ($output_method == 'echo') {
    echo $strposts;
  }

  return $strposts;
}

function theme_phpbb_api_board_stats($output, $options) {
  global $phpbb_config, $phpbb_user;

  if (empty($output)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no stats';
    }
    return '';
  }
  extract($options, EXTR_SKIP);
  extract($output, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  $phpbb_site_img_path = $phpbb_url . '/styles/' . $phpbb_user->theme['theme_path'] . '/theme/images/';
  $phpbb_site_img_file = $phpbb_site_img_path . 'icon_home.gif';
  $strreturn = '';
  $str = '<a href="' . $phpbb_url . '/index.php"><img src="' . $phpbb_site_img_file . '" alt="' . $phpbb_user->lang['HOME'] . '" title="' . $phpbb_user->lang['HOME'] . '" /></a>';
  $strreturn = $str . ' ';
  $strreturn .= $total_posts;
  $strreturn .= '<br />';
  $strreturn .= $total_topics;
  $strreturn .= '<br />';

  $phpbb_site_img_file = $phpbb_site_img_path . 'icon_members.gif';
  $str = '<a href="' . $phpbb_url . '/memberlist.php"><img src="' . $phpbb_site_img_file . '" alt="' . $phpbb_user->lang['MEMBERLIST'] . '" title="' . $phpbb_user->lang['MEMBERLIST_EXPLAIN'] . '" /></a>';
  $strreturn .= $str . ' ';

  $strreturn .= $total_users;
  $strreturn .= '<br />';
  $strreturn .= $newest_user;

  if ($output_method == 'echo') {
    echo $strreturn;
  }

  return $strreturn;
}

function theme_phpbb_api_pm($output, $options) {
  global $phpbb_config, $phpbb_user, $phpbb_root_path, $phpEx, $auth;

  if (empty($output)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no stats';
    }
    return '';
  }
  extract($options, EXTR_SKIP);
  extract($output, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  //$tz = strval(doubleval($phpbb_user->data['user_timezone']));
  //$current_time = sprintf($phpbb_user->lang['CURRENT_TIME'], $phpbb_user->format_date(time(), false, true));

  $phpbb_site_img_path = $phpbb_url . '/styles/' . $phpbb_user->theme['theme_path'] . '/theme/images/';
  $phpbb_site_img_file = $phpbb_site_img_path . 'icon_ucp.gif';
  $strreturn = ' ';
  $str = '<a href="' . $phpbb_url . '/ucp.php"><img src="' . $phpbb_site_img_file . '" alt="' . $phpbb_user->lang['PROFILE'] . '" title="' . $phpbb_user->lang['PROFILE'] . '" /></a>';
  $strreturn = $str . ' ';
  $str = '<a href="' . $phpbb_url . '/ucp.php?i=pm&amp;folder=inbox">' . $l_privmsgs_text . '</a>';
  $strreturn .= $str;

  if ($phpbb_user->data['user_unread_privmsg'] && $phpbb_user->data['user_unread_privmsg'] != $phpbb_user->data['user_new_privmsg']) {
    $str = '<br />' . '<a href="' . $phpbb_url . '/ucp.php?i=pm&amp;folder=inbox">' . $l_privmsgs_text_unread . '</a>';
    $strreturn .= $str;
  }

  if ($display_mode != 1) {
    $str = "<br />";
    $str .= "&bull; ";
    // View your posts
    $l_pm_text = $phpbb_user->lang['SEARCH_SELF'];
    $str .= '<a href="' . $phpbb_url . '/search.php?search_id=egosearch">' . $l_pm_text . '</a>';
    $strreturn .= $str;

    if ($display_mode != 2) {
      $str = $output_br;
      $str .= "&bull; ";
      // View unanswered posts
      $l_pm_text = $phpbb_user->lang['SEARCH_UNANSWERED'];
      $str .= '<a href="' . $phpbb_url . '/search.php?search_id=unanswered">' . $l_pm_text . '</a>';
      $strreturn .= $str;

      $str = $output_br;
      $str .= "&bull; ";
      // View new posts
      $l_pm_text = $phpbb_user->lang['SEARCH_NEW'];
      $str .= '<a href="' . $phpbb_url . '/search.php?search_id=newposts">' . $l_pm_text . '</a>';
      $strreturn .= $str;

      $str = $output_br;
      $str .= "&bull; ";
      // View active topics
      $l_pm_text = $phpbb_user->lang['SEARCH_ACTIVE_TOPICS'];
      $str .= '<a href="' . $phpbb_url . '/search.php?search_id=active_topics">' . $l_pm_text . '</a>';
      $strreturn .= $str;

      //'U_RESTORE_PERMISSIONS'
      //<!-- IF U_RESTORE_PERMISSIONS --> &nbsp;<a href="{U_RESTORE_PERMISSIONS}"><img src="{T_THEME_PATH}/images/icon_mini_login.gif" width="12" height="13" alt="*" /> {L_RESTORE_PERMISSIONS}</a><!-- ENDIF -->
      $restore_url = ($phpbb_user->data['user_perm_from'] && $auth->acl_get('a_switchperm')) ? append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=restore_perm') : '';
      if ($restore_url != '') {
        $str = $output_br;
        $str .= "&bull; ";
        // Perm
        $l_pm_text = $phpbb_user->lang['RESTORE_PERMISSIONS'];
        $str .= '<a href="' . $restore_url . '">' . $l_pm_text . '</a>';
        $strreturn .= $str;
      }

      // 'U_MCP'				=> ($auth->acl_get('m_') || $auth->acl_getf_global('m_')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=main&amp;mode=front', true, $user->session_id) : '')
      //[ <a href="{U_MCP}">{L_MCP}</a> ]
      $mcp_url = ($auth->acl_get('m_') || $auth->acl_getf_global('m_')) ? append_sid("{$phpbb_root_path}mcp.$phpEx", 'i=main&amp;mode=front', true, $phpbb_user->session_id) : '';
      if ($mcp_url != '') {
        $str = $output_br;
        //$str .= "&bull; ";
        // MCP
        $l_pm_text = $phpbb_user->lang['MCP'];
        $str .= '[&nbsp;<a href="' . $mcp_url . '">' . $l_pm_text . '</a>&nbsp;]';
        $strreturn .= $str;
      }
    }
  }

  if ($output_method == 'echo') {
    echo $strreturn;
  }

  return $strreturn;
}

function theme_phpbb_api_topposter($posters, $options) {
  global $phpbb_config, $phpbb_user;

  if (empty($posters)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no posters';
    }
    return '';
  }

  extract($options, EXTR_SKIP);

  $poster_array = array();
  foreach ($posters as $poster) {
    $poster_array[] = $poster['link'] . ': ' . '<strong>' . $poster['user_posts'] . '</strong>';
  }

  $strreturn = implode(', ', $poster_array);

  return $strreturn;
}
