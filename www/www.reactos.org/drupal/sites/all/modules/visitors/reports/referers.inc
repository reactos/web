<?php

/**
 * @file
 * Referers report for the visitors module.
 */

/**
 * Display referers report.
 *
 * @return
 *   string referers report html source
 */
function visitors_referer_list() {
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('Referer'), 'field' => 'visitors_referer'),
    array('data' => t('Count'), 'field' => 'count', 'sort' => 'desc'),
  );

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->addExpression('COUNT(*)', 'count');
  $query->fields('v', array('visitors_referer'));
  visitors_date_filter_sql_condition($query);
  visitors_referers_condition($query);
  $query->groupBy('visitors_referer');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(DISTINCT visitors_referer)');
  visitors_date_filter_sql_condition($count_query);
  visitors_referers_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $rows = array();

  $page = isset($_GET['page']) ? (int) $_GET['page'] : '';
  $i = 0 + ($page * $items_per_page);
  foreach ($results as $data) {
    $rows[] = array(
      ++$i,
      l($data->visitors_referer, $data->visitors_referer),
      $data->count,
    );
  }

  $output  = visitors_referers();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  return $output;
}

