<?php

/**
 * @file
 * Countries report for the visitors module.
 */

/**
 * Display countries report.
 *
 * @return
 *   string countries report html source
 */
function visitors_countries() {
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('Country'), 'field' => 'visitors_country_name'),
    array('data' => t('Count'), 'field' => 'count', 'sort' => 'desc'),
  );

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->addExpression('COUNT(visitors_country_name)', 'count');
  $query->fields('v', array('visitors_country_name'));
  visitors_date_filter_sql_condition($query);
  $query->groupBy('visitors_country_name');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(DISTINCT visitors_country_name)');
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $rows = array();

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  $i = 0 + ($page  * $items_per_page);

  foreach ($results as $data) {
    if ($data->visitors_country_name == '') {
        $data->visitors_country_name = '(none)';
    }
    $rows[] = array(
      ++$i,
      l(
        t($data->visitors_country_name),
        'visitors/countries/' . $data->visitors_country_name
      ),
      $data->count
    );
  }

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager');

  return $output;
}

