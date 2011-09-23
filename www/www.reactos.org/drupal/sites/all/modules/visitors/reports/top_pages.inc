<?php

/**
 * @file
 * Top pages report for the visitors module.
 */

/**
 * Display top pages report.
 *
 * @return
 *   string top pages report html source
 */
function visitors_top_pages() {
  $date_format = variable_get('date_format_short_custom', 'Y-m-d H:i:s');
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('URL'), 'field' => 'visitors_url'),
    array('data' => t('Count'), 'field' => 'count', 'sort' => 'desc'),
  );

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->addExpression('COUNT(visitors_id)', 'count');
  $query->addExpression('MIN(visitors_title)', 'visitors_title');
  $query->addExpression('MIN(visitors_url)', 'visitors_url');
  $query->fields('v', array('visitors_path'));
  visitors_date_filter_sql_condition($query);
  $query->groupBy('visitors_path');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(DISTINCT visitors_path)');
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $rows = array();

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  $i = 0 + ($page  * $items_per_page);

  foreach ($results as $data) {
    $rows[] = array(
      ++$i,
      check_plain($data->visitors_title) . '<br/>' .
      l($data->visitors_path, $data->visitors_url),
      $data->count,
    );
  }

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  return $output;
}

