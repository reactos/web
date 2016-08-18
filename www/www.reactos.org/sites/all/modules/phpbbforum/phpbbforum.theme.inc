<?php
// $Id: phpbbforum.theme.inc,v 1.20 2010/11/24 20:53:34 vb Exp $
/**
 * @file
 * @copyright  Copyright (C) 2007-2011 Vadim G.B. (http://vgb.org.ru)
 */

/**
 * Implements hook_theme().
 */
function phpbbforum_theme() {
  return array(
    'phpbbforum_whos_online' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_recent_posts' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_recent_topics' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_board_stats' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_pm' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_topposter' => array(
      'variables' => array('output' => NULL, 'options' => NULL),
    ),
    'phpbbforum_style' => array(
      'variables' => array('style' => NULL, 'phpbb_theme_path' => NULL, 'output' => NULL),
    ),
  );
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_whos_online() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  $options = array(
    'num_top' => (int) variable_get('phpbbforum_num_whos_online', PHPBB_NUM_WHOS_ONLINE),
    'output_method' => 'array',
  );
  $output = phpbb_api_whos_online($options);
  $output = theme('phpbbforum_whos_online', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_links($output);
  }

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_recent_posts() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  if (variable_get('phpbbforum_recent_posts_br', 1)) {
    $delimeter = PHPBB_RECENT_DELIMITER_BR;
  }
  else {
    $delimeter = PHPBB_RECENT_DELIMITER_SPACE;
  }

  $options = array(
    'num_recent' => (int) variable_get('phpbbforum_num_recent_posts', PHPBB_NUM_RECENT_POSTS),
    'search_id' => 'newposts',
    'sort_days' => (int) variable_get('phpbbforum_num_recent_sort_days', 0),
    'output_tag' => '<ul class="menu">',
    'output_br' => $delimeter,
    'display_mode' => variable_get('phpbbforum_recent_posts_display_mode', 0),
    'display_topic_new_icon_pos' => variable_get('phpbbforum_recent_display_topic_new_icon_pos', 0),
    'output_method' => 'array',
  );
  $output = phpbb_api_recent_posts($options);
  $output = theme('phpbbforum_recent_posts', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_recent_topics() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  if (variable_get('phpbbforum_recent_topics_br', 1)) {
    $delimeter = PHPBB_RECENT_DELIMITER_BR;
  }
  else {
    $delimeter = PHPBB_RECENT_DELIMITER_SPACE;
  }

  $options = array(
    'num_recent' => (int) variable_get('phpbbforum_num_recent_topics', PHPBB_NUM_RECENT_TOPICS),
    'search_id' => 'active_topics',
    'sort_days' => (int) variable_get('phpbbforum_num_recent_sort_days', 0),
    'output_tag' => '<ul class="menu">',
    'output_br' => $delimeter,
    'display_mode' => variable_get('phpbbforum_recent_topics_display_mode', 0),
    'display_topic_new_icon_pos' => variable_get('phpbbforum_recent_display_topic_new_icon_pos', 0),
    'output_method' => 'array',
  );
  $output = phpbb_api_recent_topics($options);
  $output = theme('phpbbforum_recent_topics', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_recent_new_topics() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  if (variable_get('phpbbforum_recent_topics_br', 1)) {
    $delimeter = PHPBB_RECENT_DELIMITER_BR;
  }
  else {
    $delimeter = PHPBB_RECENT_DELIMITER_SPACE;
  }

  $options = array(
    'num_recent' => (int) variable_get('phpbbforum_num_recent_topics', PHPBB_NUM_RECENT_TOPICS),
    'search_id' => 'newtopics',
    'sort_days' => (int) variable_get('phpbbforum_num_recent_new_sort_days', 0),
    'output_tag' => '<ul class="menu">',
    'output_br' => $delimeter,
    'display_mode' => variable_get('phpbbforum_recent_topics_display_mode', 0),
    'display_topic_new_icon_pos' => variable_get('phpbbforum_recent_display_topic_new_icon_pos', 0),
    'output_method' => 'array',
  );
  $output = phpbb_api_recent_topics($options);
  $output = theme('phpbbforum_recent_topics', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_board_stats() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  $options = array(
    'output_method' => 'array',
  );
  $output = phpbb_api_board_stats($options);
  $output = theme('phpbbforum_board_stats', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_pm() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  if (variable_get('phpbbforum_pm_br', 1)) {
    $delimeter = PHPBB_RECENT_DELIMITER_BR;
  }
  else {
    $delimeter = PHPBB_RECENT_DELIMITER_SPACE;
  }
  $options = array(
    'output_br' => $delimeter,
    'display_mode' => variable_get('phpbbforum_pm_display_mode', 0),
    'output_method' => 'array',
  );
  $output = phpbb_api_pm($options);
  $output = theme('phpbbforum_pm', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function phpbbforum_topposter() {
  global $phpbb_config, $phpbb_user, $_phpbb_integration_mode;

  $options = array(
    'num_top' => (int) variable_get('phpbbforum_num_top_posters', PHPBB_NUM_TOP_POSTERS),
    'output_method' => 'array',
  );
  $output = phpbb_api_topposter($options);
  $output = theme('phpbbforum_topposter', array('output' => $output, 'options' => $options));
  if ($_phpbb_integration_mode != '0') {
    $output = _phpbbforum_replace_block_links($output);
  }

  return $output;
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_whos_online($variables) {
  $output = $variables['output'];
  $options = $variables['options'];
  return theme_phpbb_api_whos_online($output, $options);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_recent_posts($variables) {
  $posts = $variables['output'];
  $options = $variables['options'];
  if ($options['display_mode'] == 2) {
    return theme_phpbb_api_recent_posts_table($posts, $options);
  }
  else {
    return theme_phpbb_api_recent_posts($posts, $options);
  }
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbb_api_recent_posts_table($posts, $options) {
  // TODO: Should this theme phpbb_api_recent_posts_table be declared in hook_theme()?
  global $phpbb_config, $phpbb_user;

  if (empty($posts)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no posts';
    }
    return '';
  }

  extract($options, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  $output = $str = '';

  $rows = array();

  foreach ($posts as $post) {
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
      $str = '<a href="' . $post['U_VIEW_POST'] . '">' . $shorten_subject . '</a>';
    }
    else {
      $str = '';
    }

    if ($display_topic_new_icon_pos == 0) {
      $subject = $strnew . $strimgicon . $strimg . '&nbsp;' . $str . '</span>';
    }
    else {
      $subject = $strnew . $strimgicon . $str . '&nbsp;' . $strimg . '</span>';
    }

    $forum_title = '';
    $post_author = '';
    $post_date = '';

    if ($display_mode != 1) {
      // POST_AUTHOR_FULL
      $strnew = '<span class="phpbbforum_recent_author">';
      $posterlink = $post['POST_AUTHOR_FULL'];
      $strimg = '<a href="' . $post['U_VIEW_POST'] . '"><img src="' . $post['U_LAST_POST_IMG'] . '" alt="' . $post['LAST_POST_IMG_ALT'] . '" title="' . $post['LAST_POST_IMG_ALT'] . '" /></a>';
      $post_author = $strnew . $posterlink . '&nbsp;' . $strimg . '</span>';
      // POST_DATE
      $strnew = '<span class="phpbbforum_recent_date">';
      $post_date = $strnew . $post['POST_DATE'] . '</span>';
      // FORUM_TITLE
      $strnew = '<span class="phpbbforum_recent_title">';
      $str = '<a href="' . $post['U_VIEW_FORUM'] . '">' . phpbb_shorten_subject($post['FORUM_TITLE'], 45) . '</a>';
      $forum_title .= $strnew . $str . '</span>';
    }

    $rows[] = array(
      array('data' => $subject),
      array('data' => $forum_title),
      array(
        'data' => $post['TOPIC_REPLIES'],
        'align' => 'center',
      ),
      //array('data' => $author),
      array(
        'data' => $post['TOPIC_VIEWS'],
        'align' => 'center',
      ),
      array(
        'data' => $post_author . $output_br . $post_date,
        'align' => 'center',
      ),
    );

  }

  $header = theme_phpbb_api_recent_posts_header(); //theme('phpbb_api_recent_posts_header');
  $output = theme('table', array('header' => $header, 'rows' => $rows));

  return $output;
}

/*
 * Themes the header of the recent posts table
 *
 * @return
 *   An array suitable for use with tablesort_sql
 */
/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbb_api_recent_posts_header() {
  // TODO: Should this theme phpbb_api_recent_posts_header be declared in hook_theme()?
  return array(
    array('data' => t('Topic')),
    array('data' => t('Forum')),
    array('data' => t('Replies')),
    //array('data' => t('Author')),
    array('data' => t('Topic views')),
    array('data' => t('Last post')),
  );
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_recent_topics($variables) {
  $posts = $variables['output'];
  $options = $variables['options'];
  if ($options['display_mode'] == 2) {
    return theme_phpbb_api_recent_topics_table($posts, $options);
  }
  else {
    return theme_phpbb_api_recent_topics($posts, $options);
  }
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbb_api_recent_topics_table($posts, $options) {
  // TODO: Should this theme phpbb_api_recent_topics_table be declared in hook_theme()?
  global $phpbb_config, $phpbb_user;

  if (empty($posts)) {
    if (PHPBB_MODULE_DEBUG) {
      return 'no posts';
    }
    return '';
  }

  extract($options, EXTR_SKIP);

  $phpbb_url = $phpbb_config['forum_url'];

  $output = $str = '';

  $rows = array();

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
      $subject = $strnew . $strimgicon . $strimg . '&nbsp;' . $str . '</span>';
    }
    else {
      $subject = $strnew . $strimgicon . $str . '&nbsp;' . $strimg . '</span>';
    }

    $forum_title = '';
    $post_author = '';
    $post_date = '';

    if ($display_mode != 1) {
      // POST_AUTHOR_FULL
      $strnew = '<span class="phpbbforum_recent_author">';
      $posterlink = $post['LAST_POST_AUTHOR_FULL'];
      $strimg = '<a href="' . $post['U_LAST_POST'] . '"><img src="' . $post['U_LAST_POST_IMG'] . '" alt="' . $post['LAST_POST_IMG_ALT'] . '" title="' . $post['LAST_POST_IMG_ALT'] . '" /></a>';
      $post_author = $strnew . $posterlink . '&nbsp;' . $strimg . '</span>';
      // POST_DATE
      $strnew = '<span class="phpbbforum_recent_date">';
      $post_date = $strnew . $post['LAST_POST_TIME'] . '</span>';
      // FORUM_TITLE
      $strnew = '<span class="phpbbforum_recent_title">';
      $str = '<a href="' . $post['U_VIEW_FORUM'] . '">' . phpbb_shorten_subject($post['FORUM_TITLE'], 45) . '</a>';
      $forum_title .= $strnew . $str . '</span>';
    }

    $rows[] = array(
      array('data' => $subject),
      array('data' => $forum_title),
      array(
        'data' => $post['TOPIC_REPLIES'],
        'align' => 'center',
      ),
      //array('data' => $author),
      array(
        'data' => $post['TOPIC_VIEWS'],
        'align' => 'center',
      ),
      array(
        'data' => $post_author . $output_br . $post_date,
        'align' => 'center',
      ),
    );

  }

  $header = theme_phpbb_api_recent_topics_header(); //theme('phpbb_api_recent_topics_header');
  $output = theme('table', array('header' => $header, 'rows' => $rows));

  return $output;
}

/*
 * Themes the header of the recent topics table
 *
 * @return
 *   An array suitable for use with tablesort_sql
 */
/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbb_api_recent_topics_header() {
  // TODO: Should this theme phpbb_api_recent_topics_header be declared in hook_theme()?
  return array(
    array('data' => t('Topic')),
    array('data' => t('Forum')),
    array('data' => t('Replies')),
    //array('data' => t('Author')),
    array('data' => t('Topic views')),
    array('data' => t('Last post')),
  );
}


/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_board_stats($variables) {
  $output = $variables['output'];
  $options = $variables['options'];
  return theme_phpbb_api_board_stats($output, $options);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_pm($variables) {
  $output = $variables['output'];
  $options = $variables['options'];
  return theme_phpbb_api_pm($output, $options);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_topposter($variables) {
  $posters = $variables['output'];
  $options = $variables['options'];
  return theme_phpbb_api_topposter($posters, $options);
}

/**
 * @todo Please document this function.
 * @see http://drupal.org/node/1354
 */
function theme_phpbbforum_style($variables) {
  $style = $variables['style'];
  $phpbb_theme_path = $variables['phpbb_theme_path'];
  $output = $variables['output'];
  if (variable_get("phpbbforum_page_frame", 0) == '0') {
    return '';
  }
  return phpbbforum_style($style, $phpbb_theme_path, $output);
}

if (/*variable_get("phpbbforum_page_frame", 0) == '1' ||*/ variable_get("phpbbforum_page_frame", 0) == '2') {

  ////////////////////////////////////////////////////////////////////////////////

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_set_style($style, $phpbb_theme_path) {
    global $phpbb_config, $phpbb_user, $phpbb_root_path;
    $style = str_replace('-', '_', $style);
    $fn = 'phpbbforum_set_style_' . $style;
    if (function_exists($fn)) {
      $fn($phpbb_theme_path);
    }
    else {
      $styleclass = (stripos($style, 'prosilver') || substr($style, 0, 3) == 'pro');
      if ($styleclass !== false) {
        phpbbforum_set_style_prosilver($phpbb_theme_path);
      }
      else {
        phpbbforum_set_style_subsilver2($phpbb_theme_path);
      }
    }
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_style($style, $phpbb_theme_path, $output) {
    global $phpbb_config, $phpbb_user, $phpbb_root_path, $_phpbb_result;
    drupal_set_title($_phpbb_result['page_title']);
    if ($_phpbb_result['meta_refresh'] > 0 ) {
      $url = $_phpbb_result['destination'];
      $time = $_phpbb_result['meta_refresh'];
      $meta = '<meta http-equiv="refresh" content="' . $time . ';url=' . $url . '" />';
      $element = array(
        '#type' => 'markup',
        '#markup' => $meta,
      );
      drupal_add_html_head($element, 'phpbbforum_head_meta_refresh');
    }
    $type = 'theme';
    $options = array('type' => 'file', 'media' => 'screen', 'preprocess' => TRUE, 'every_page' => TRUE);
    drupal_add_css(drupal_get_path('module', 'phpbbforum') . '/css/phpbbforum.css', $options);
    $style = str_replace('-', '_', $style);
    $fn = 'phpbbforum_style_' . $style;
    if (function_exists($fn)) {
      $output = $fn($phpbb_theme_path, $output);
    }
    else {
      $styleclass = (stripos($style, 'prosilver') || substr($style, 0, 3) == 'pro');
      if ($styleclass !== false) {
        $output = phpbbforum_style_prosilver($phpbb_theme_path, $output);
      }
      else {
        $output = phpbbforum_style_subsilver2($phpbb_theme_path, $output);
      }
    }
    drupal_add_js(drupal_get_path('module', 'phpbbforum') . '/js/phpbbforum.js');
    $phpbb_url = $phpbb_config['forum_url'] . '/';
    $output = str_replace($phpbb_root_path, $phpbb_url, $output);
    $output = _phpbbforum_replace_links($output);
    $output = '<div id="phpbbforum-page">' . $output . '</div><!-- /phpbbforum-page -->';
    return $output;
  }

  function _phpbbforum_get_html_body($endpos, $output) {
    $startpos = strpos($output, '<body', $endpos);
    if ($startpos) {
      $startpos = strpos($output, '>', $startpos) + 1;
      $endpos = strpos($output, '</body>', $startpos);
      if ($endpos) {
        $output = substr($output, $startpos, ($endpos - $startpos));
      }
    }
    return $output;
  }

  function _phpbbforum_get_html_tag(&$endpos, $output, $tag, $endtag = '</div>', $mode = 0) {
    $startpos = strpos($output, $tag, $endpos);
    if ($startpos !== false) {
      $endpos2 = strpos($output, $endtag, $startpos);
      if ($endpos2 !== false) {
        $len = $endpos2 - $startpos;
        if ($mode == 0) {
          $len += strlen($endtag);
          $endpos2 += strlen($endtag);
        }
        elseif ($mode == 1) {
          $startpos += strlen($tag);
        }
        $output = substr($output, $startpos, $len);
        $endpos = $endpos2;
        return $output;
      }
    }
    return '';
  }

  function _phpbbforum_set_theme_css($phpbb_theme_path, $phpbb_theme) {
    global $language, $theme;
    $type = 'theme';
    $module_css = '/' . $theme . '-phpbbforum-' . $phpbb_theme . '.css';
    $theme_css_file = drupal_get_path('theme', $theme) . $module_css;
    if (!file_exists($theme_css_file)) {
      $theme_css_file = drupal_get_path('module', 'phpbbforum') . '/css' . $module_css;
      if (!file_exists($theme_css_file)) {
        $module_css = '/phpbbforum-' . $phpbb_theme . '.css';
        $theme_css_file = drupal_get_path('theme', $theme) . '/css' . $module_css;
        if (!file_exists($theme_css_file)) {
          $theme_css_file = drupal_get_path('module', 'phpbbforum') . '/css' . $module_css;
        }
      }
    }
    $options = array('type' => 'file', 'media' => 'screen', 'preprocess' => TRUE, 'every_page' => TRUE);
    drupal_add_css($theme_css_file, $options);
  }

  ////////////////////////////////////////////////////////////////////////////////

  /*
   * prosilver
   */

  function _phpbbforum_set_head_script_prosilver($endpos, $output) {
    global $_drupal_base_path, $base_path;
    $meta = _phpbbforum_get_html_tag($endpos, $output, '<meta http-equiv="X', '/>');
    $scripttag = '<script type="text/javascript">';
    $startpos = strpos($output, $scripttag, $endpos);
    if ($startpos !== false) {
      $toplinks = substr($output, $endpos, ($startpos - $endpos));
      $linkstag = '<link rel="';
      $linkspos = strpos($toplinks, $linkstag, 0);
      if ($linkspos !== false) {
        $linksfeed = substr($toplinks, $linkspos);
      }
      else {
        $linksfeed = '';
      }
      $endpos = strpos($output, '<link', $startpos + strlen($scripttag));
      if ($endpos) {
        $script = substr($output, $startpos, ($endpos - $startpos));
        if ($script != '') {
          $path = str_replace('\\', '/', $_drupal_base_path) . '/';
          $str = array($path, strtolower($path));
          $script = str_replace($str, $base_path, $script);
          $script = $linksfeed . $script;
          $script = _phpbbforum_replace_forum_url($script);
          $script = $meta . $script;
          $element = array(
            '#type' => 'markup',
            '#markup' => $script,
          );
          drupal_add_html_head($element, 'phpbbforum_head_script_prosilver');
        }
      }
    }
    return $endpos;
  }

  function _phpbbforum_set_head_links_prosilver($endpos, $output) {
    global $_drupal_base_path, $base_path;
    $linkstag = '<link href="';
    $startpos = strpos($output, $linkstag, $endpos);
    if ($startpos !== false) {
      $endpos = strpos($output, 'printonly', $startpos + 1);
      if ($endpos !== false) {
        $startpos = strpos($output, $linkstag, $endpos);
        if ($startpos !== false) {
          $endpos = strpos($output, '</head>', $startpos + 1);
          if ($endpos) {
            $links = substr($output, $startpos, ($endpos - $startpos));
            if ($links != '') {
              $path = str_replace('\\', '/', $_drupal_base_path) . '/';
              $str = array($path, strtolower($path));
              $links = str_replace($str, $base_path, $links);
              $element = array(
                '#type' => 'markup',
                '#markup' => $links,
              );
              drupal_add_html_head($element, 'phpbbforum_head_links_prosilver');
            }
          }
        }
      }
    }
    return $endpos;
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_set_style_prosilver($phpbb_theme_path) {
    _phpbbforum_set_theme_css($phpbb_theme_path, 'prosilver');
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_style_prosilver($phpbb_theme_path, $output) {
    phpbbforum_set_style_prosilver($phpbb_theme_path);
    $endpos = _phpbbforum_set_head_script_prosilver(0, $output);
    $endpos = _phpbbforum_set_head_links_prosilver($endpos, $output);
    $output = _phpbbforum_get_html_body($endpos, $output);
    return $output;
  }

  /*
   * prosilver_embed
   */

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_set_style_prosilver_embed($phpbb_theme_path) {
    phpbbforum_set_style_prosilver($phpbb_theme_path);
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_style_prosilver_embed($phpbb_theme_path, $output) {
    phpbbforum_set_style_prosilver_embed($phpbb_theme_path);
    $endpos = _phpbbforum_set_head_script_prosilver(0, $output);
    $endpos = _phpbbforum_set_head_links_prosilver($endpos, $output);
    $output = _phpbbforum_get_html_body($endpos, $output);

    //$endpos = 0;
    //$search_box = _phpbbforum_get_html_tag($endpos, $output, '<div id="search-box">');
    //$search_box = _phpbbforum_replace_forum_url($search_box);
    //global $search;
    //$search['search_theme_form'] = $search_box;
    return $output;
  }

  ////////////////////////////////////////////////////////////////////////////////

  /*
   * subsilver2
   */

  function _phpbbforum_set_head_links_subsilver2($endpos, $output) {

    global $_drupal_base_path;

    $meta = _phpbbforum_get_html_tag($endpos, $output, '<meta http-equiv="X', '/>');
    $element = array(
      '#type' => 'markup',
      '#markup' => $meta,
    );
    drupal_add_html_head($element, 'phpbbforum_head_meta_subsilver2');
    $linkstag = '<link';
    $startpos = strpos($output, $linkstag, $endpos);
    if ($startpos !== false) {
      $endpos = strpos($output, '<script', $startpos + 1);
      if ($endpos) {
        $links = substr($output, $startpos, ($endpos - $startpos));
        if ($links != '') {
          $path = str_replace('\\', '/', $_drupal_base_path);
          $str = array($path, strtolower($path));
          $links = str_replace($str, '', $links);
          $element = array(
            '#type' => 'markup',
            '#markup' => $links,
          );
          drupal_add_html_head($element, 'phpbbforum_head_links_subsilver2');
        }
      }
    }
    return $endpos;
  }

  function _phpbbforum_set_head_script_subsilver2($endpos, $output) {
    global $_drupal_base_path;
    $scripttag = '<script type="text/javascript">';
    $startpos = strpos($output, $scripttag, $endpos);
    if ($startpos !== false) {
      $endpos = strpos($output, '</head>', $startpos + strlen($scripttag));
      if ($endpos) {
        $script = substr($output, $startpos, ($endpos - $startpos));
        if ($script != '') {
          $script = _phpbbforum_replace_forum_url($script);
          $element = array(
            '#type' => 'markup',
            '#markup' => $script,
          );
          drupal_add_html_head($element, 'phpbbforum_head_script_subsilver2');
        }
      }
    }
    return $endpos;
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_set_style_subsilver2($phpbb_theme_path) {
    _phpbbforum_set_theme_css($phpbb_theme_path, 'subsilver2');
    $theme_js = $phpbb_theme_path . '/template/editor.js';
    drupal_add_js($theme_js);
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_style_subsilver2($phpbb_theme_path, $output) {
    phpbbforum_set_style_subsilver2($phpbb_theme_path);
    $endpos = _phpbbforum_set_head_links_subsilver2(0, $output);
    $endpos = _phpbbforum_set_head_script_subsilver2($endpos, $output);
    $output = _phpbbforum_get_html_body($endpos, $output);
    return $output;
  }

  /*
   * subsilver2_embed
   */
  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_set_style_subsilver2_embed($phpbb_theme_path) {
    phpbbforum_set_style_subsilver2($phpbb_theme_path);
  }

  /**
   * @todo Please document this function.
   * @see http://drupal.org/node/1354
   */
  function phpbbforum_style_subsilver2_embed($phpbb_theme_path, $output) {
    phpbbforum_set_style_subsilver2_embed($phpbb_theme_path);
    $endpos = _phpbbforum_set_head_links_subsilver2(0, $output);
    $endpos = _phpbbforum_set_head_script_subsilver2($endpos, $output);
    $output = _phpbbforum_get_html_body($endpos, $output);
    return $output;
  }

} // if (variable_get("phpbbforum_page_frame", 0) == '1' || variable_get("phpbbforum_page_frame", 0) == '2') {
