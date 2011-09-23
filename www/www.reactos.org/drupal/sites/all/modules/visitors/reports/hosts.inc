<?php

/**
 * @file
 * Hours report and hits from host report for the visitors module.
 */

/**
 * Menu callback; presents the "hits from" page.
 *
 * @param ip
 *   A string containing an ip address.
 *
 * @return
 *   string hits from host report html source or 404 error if hits not found.
 */
function visitors_host_hits($ip) {
  if (!visitors_is_ip_valid($ip) && ($ip != '0.0.0.0')) {
    return drupal_not_found();
  }

  $date_format    = variable_get('date_format_short_custom', 'Y-m-d H:i:s');
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('ID'), 'field' => 'visitors_id', 'sort' => 'desc'),
    array('data' => t('Date'), 'field' => 'visitors_date_time'),
    array('data' => t('URL'), 'field' => 'visitors_url'),
    array('data' => t('User'), 'field' => 'u.name'),
    array('data' => t('Operations'))
  );

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->leftJoin('users', 'u', 'u.uid=v.visitors_uid');
  $query->fields(
    'v',
    array(
      'visitors_id',
      'visitors_ip',
      'visitors_uid',
      'visitors_date_time',
      'visitors_title',
      'visitors_path',
      'visitors_url'
    )
  );
  $query->fields('u', array('name', 'uid'));
  $query->condition('v.visitors_ip', sprintf('%u', ip2long($ip)), '=');
  visitors_date_filter_sql_condition($query);
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(*)');
  $count_query->condition('visitors_ip', sprintf('%u', ip2long($ip)));
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $count = $count_query->execute()->fetchField();
  if ($count == 0) {
    return drupal_not_found();
  }

  $rows = array();

  $page = isset($_GET['page']) ? (int) $_GET['page'] : '';
  $i = 0 + ($page  * $items_per_page);

  foreach ($results as $data) {
    $user = user_load($data->visitors_uid);
    $user_page = theme('username', array('account' => $user));
    $rows[] = array(
      ++$i,
      $data->visitors_id,
      format_date(
        $data->visitors_date_time,
        'custom',
        $date_format,
        visitors_get_timezone()
      ),
      check_plain($data->visitors_title) . '<br/>' .
        l($data->visitors_path, $data->visitors_url),
      $user_page,
      l(t('details'), 'visitors/hits/' . $data->visitors_id)
    );
  }

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  drupal_set_title(check_plain(t('Hits from') . ' ' . $ip));

  return $output;
}

/**
 * Menu callback; presents the "hosts" page.
 *
 * @return
 *   string hosts report html source.
 */
function visitors_hosts() {
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('Host'), 'field' => 'visitors_ip'),
    array('data' => t('Pages'), 'field' => 'count', 'sort' => 'desc'),
    array('data' => t('Operations'))
  );

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->addExpression('COUNT(*)', 'count');
  $query->fields('v', array('visitors_ip'));
  visitors_date_filter_sql_condition($query);
  $query->groupBy('visitors_ip');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(DISTINCT visitors_ip)');
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $rows = array();

  $page = isset($_GET['page']) ? (int) $_GET['page'] : '';
  $i = 0 + ($page * $items_per_page);
  $whois_enable = module_exists('whois');
  $attr = array('attributes' =>
    array('target' => '_blank', 'title' => t('Whois lookup'))
  );

  foreach ($results as $data) {
    $ip = long2ip($data->visitors_ip);
    $rows[] = array(
      ++$i,
      $whois_enable ? l($ip, 'whois/' . $ip, $attr) : check_plain($ip),
      $data->count,
      l(t('hits'), 'visitors/hosts/' . $ip)
    );
  }

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  return $output;
}

