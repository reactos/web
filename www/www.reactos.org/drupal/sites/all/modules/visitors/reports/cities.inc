<?php

/**
 * @file
 * Cities report for the visitors module.
 */

/**
 * Display cities report.
 *
 * @return
 *   string cities report html source
 */
function visitors_cities($country) {
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('City'), 'field' => 'visitors_city'),
    array('data' => t('Count'), 'field' => 'count', 'sort' => 'desc'),
  );

  $original_country =  ($country == '(none)') ? '' : $country;

  $query = db_select('visitors', 'v')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->addExpression('COUNT(visitors_city)', 'count');
  $query->fields('v', array('visitors_city'));
  $query->condition('v.visitors_country_name', $original_country);
  visitors_date_filter_sql_condition($query);
  $query->groupBy('visitors_city');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('visitors', 'v');
  $count_query->addExpression('COUNT(DISTINCT visitors_city)');
  $count_query->condition('v.visitors_country_name', $original_country);
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);
  $results = $query->execute();

  $rows = array();

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  $i = 0 + ($page  * $items_per_page);

  $error_404 = TRUE;
  foreach ($results as $data) {
    $error_404 = FALSE;
    if ($data->visitors_city == '') {
      $data->visitors_city = '(none)';
    }
    $rows[] = array(
      ++$i,
      l(
        $data->visitors_city,
        'visitors/countries/' . $country . '/' . $data->visitors_city
      ),
      $data->count
    );
  }

  if ($error_404) {
    return drupal_not_found();
  }

  drupal_set_title(t('Visitors from') . ' ' . t($country));

  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager');

  return $output;
}

