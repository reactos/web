<?php

/**
 * @file
 * Days of week report for the visitors module.
 */

/**
 * Create days of week array, using date_first_day parameter,
 * using keys as day of week.
 *
 * @return array
 */
function visitors_get_days_of_week() {
  $days           = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
  $date_first_day = (int) variable_get('date_first_day', 0);
  $sort_days      = array();
  $n              = 1;

  for ($i = $date_first_day; $i < 7; $i++) {
    $sort_days[$days[$i]] = $n++;
  }

  for ($i = 0; $i < $date_first_day; $i++) {
    $sort_days[$days[$i]] = $n++;
  }

  return $sort_days;
}

/**
 * Get data for days of week report order the query based on a header array.
 *
 * @param header
 *   Table header array. If header is NULL - data is not sorted.
 *
 * @return
 *   hours data array
 */
function visitors_days_of_week_data() {
  $query = db_select('visitors', 'v');
  $query->addExpression('COUNT(*)', 'count');
  $query->addExpression(
    visitors_date_format_sql('visitors_date_time', '%a'),
    'd'
  );
  $query->addExpression(
    visitors_date_format_sql('MIN(visitors_date_time)', '%w'),
    'n'
  );
  visitors_date_filter_sql_condition($query);
  $query->groupBy('d');
  $query->orderBy('n');

  return $query->execute();
}

/**
 * Display days of week report.
 *
 * @return
 *   string days of week report html source
 */
function visitors_days_of_week() {
  $header = array(t('#'), t('Day'), t('Pages'));

  $results = visitors_days_of_week_data();
  $tmp_rows = array();
  $count = 0;

  foreach ($results as $data) {
    $tmp_rows[$data->n] = array(
      $data->d,
      $data->count,
      $data->n
    );

    $count += $data->count;
  }
  $rows = array();
  $sort_days = visitors_get_days_of_week();

  foreach ($sort_days as $day => $value) {
    $rows[$value] = array($value, t($day), 0);
  }

  foreach ($tmp_rows as $tmp_item) {
    $day_of_week = drupal_ucfirst(drupal_strtolower($tmp_item[0]));
    $rows[$sort_days[$day_of_week]][2] = $tmp_item[1];
  }

  $output  = visitors_date_filter();

  if ($count > 0) {
    $output .= sprintf(
      '<img src="%s" alt="%s" width="%d" height="%d">',
      url('visitors/days_of_week/chart'),
      t('Days of week'),
      visitors_get_chart_width(),
      visitors_get_chart_height()
    );

  }
  $output .= theme('table', array('header' => $header, 'rows' => $rows));

  return $output;
}

/**
 * Display days of week chart report.
 */
function chart_visitors_days_of_week() {
  $results = visitors_days_of_week_data();
  $tmp_rows = array();

  foreach ($results as $data) {
    $tmp_rows[$data->n] = array(
      $data->d,
      $data->count,
      $data->n
    );
  }

  $rows = array();
  for ($i = 0; $i < 7; $i++) {
    $rows[$i] = 0;
  }

  $sort_days = visitors_get_days_of_week();
  foreach ($tmp_rows as $key => $tmp_item) {
    $day_of_week = drupal_ucfirst(drupal_strtolower($tmp_item[0]));
    $rows[$sort_days[$day_of_week] - 1] = (int) $tmp_item[1];
  }

 // build dates series
  $dates = array();
  foreach ($sort_days as $day => $value) {
      $dates[] = t($day);
  }

  visitors_chart($rows, $dates);
}

