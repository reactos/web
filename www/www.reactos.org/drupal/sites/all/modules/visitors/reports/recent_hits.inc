<?php

/**
 * @file
 * Recent hits report for the visitors module.
 */

/**
 * Display recent hits report.
 *
 * @return
 *   string recent hits report html source
 */
function visitors_recent_hits() {
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
  $query->leftJoin('users', 'u', 'u.uid=v.visitors_id');
  $query->fields(
    'v',
    array(
      'visitors_id',
      'visitors_uid',
      'visitors_date_time',
      'visitors_title',
      'visitors_path',
      'visitors_url'
    )
  );
  $query->fields('u', array('name', 'uid'));
  visitors_date_filter_sql_condition($query);
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(*)');
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

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
      check_plain(
        $data->visitors_title) . '<br/>' . l($data->visitors_path,
        $data->visitors_url
      ),
      $user_page,
      l(t('details'), 'visitors/hits/' . $data->visitors_id)
    );
  }

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  return $output;
}

