<?php

/**
 * @file
 * Hours report for the visitors module.
 */

/**
 * Get data for hours report order the query based on a header array.
 *
 * @param header
 *   Table header array. If header is NULL - data is not sorted.
 *
 * @return
 *   hours data array
 */
function visitors_hours_data($header) {
  $query = db_select('visitors', 'v');
  $query->addExpression('COUNT(*)', 'count');
  $query->addExpression(
    visitors_date_format_sql('visitors_date_time', '%H'), 'hour'
  );
  visitors_date_filter_sql_condition($query);
  $query->groupBy('hour');

  if (!is_null($header)) {
    $query->extend('TableSort')->orderByHeader($header);
  }

  return $query->execute();
}

/**
 * Display hours report.
 *
 * @return
 *   string hours report html source
 */
function visitors_hours() {
  $header = array(
    array('data' => t('#')),
    array('data' => t('Hour'), 'field' => 'hour', 'sort' => 'asc'),
    array('data' => t('Pages'), 'field' => 'count'),
  );

  $results = visitors_hours_data($header);
  $rows = array();
  $i = 0;
  $count = 0;

  foreach ($results as $data) {
    $rows[] = array(
      ++$i,
      $data->hour,
      $data->count
    );
    $count += $data->count;
  }

  $output  = visitors_date_filter();

  if ($count > 0) {
    $output .= sprintf(
      '<img src="%s" alt="%s">',
      url('visitors/hours/chart'),
      t('Hours')
    );
  }

  $output .= theme('table', array('header' => $header, 'rows' => $rows));

  return $output;
}

/**
 * Display hours chart report.
 */
function chart_visitors_hours() {
  $results = visitors_hours_data(NULL);
  $tmp_rows = array();
  $rows = array();
  for ($i = 0; $i < 24; $i++) {
    $rows[$i] = 0;
  }

  foreach ($results as $data) {
    $rows[(int)$data->hour] = $data->count;
  }

  $hours = range(0, 23);

  visitors_chart($rows, $hours);
}

