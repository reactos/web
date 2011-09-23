<?php

/**
 * @file
 * User activity report for the visitors module.
 */

/**
 * Display user activity report.
 *
 * @return
 *   string user activity report html source
 */
function visitors_user_activity() {
  $date_format    = variable_get('date_format_short_custom', 'Y-m-d H:i:s');
  $items_per_page = variable_get('visitors_lines_per_page', 10);

  $header = array(
    array('data' => t('#')),
    array('data' => t('User'), 'field' => 'name'),
    array('data' => t('Hits'), 'field' => 'hits', 'sort' => 'desc'),
    array('data' => t('Nodes'), 'field' => 'nodes'),
    array('data' => t('Comments'), 'field' => 'comments')
  );

  $from = visitors_get_from_timestamp();
  $to   = visitors_get_to_timestamp();

  $query = db_select('users', 'u')
    ->extend('PagerDefault')
    ->extend('TableSort');
  $query->leftJoin('visitors', 'v', 'u.uid=v.visitors_uid');
  $query->leftJoin('node', 'n', 'u.uid=n.uid');
  $query->leftJoin('comment', 'c', 'u.uid=c.uid');
  $query->fields('u', array('name', 'uid'));
  $query->addExpression('COUNT(DISTINCT v.visitors_id)', 'hits');
  $query->addExpression('COUNT(DISTINCT n.nid)', 'nodes');
  $query->addExpression('COUNT(DISTINCT c.cid)', 'comments');
  visitors_date_filter_sql_condition($query);
  $query->groupBy('u.name');
  $query->groupBy('u.uid');
  $query->groupBy('v.visitors_uid');
  $query->groupBy('n.uid');
  $query->groupBy('c.uid');
  $query->orderByHeader($header);
  $query->limit($items_per_page);

  $count_query = db_select('users', 'u');
  $count_query->leftJoin('visitors', 'v', 'u.uid=v.visitors_uid');
  $count_query->addExpression('COUNT(DISTINCT u.uid)');
  visitors_date_filter_sql_condition($count_query);
  $query->setCountQuery($count_query);

  $results = $query->execute();
  $rows = array();

  $page = isset($_GET['page']) ? (int) $_GET['page'] : '';
  $i = 0 + ($page  * $items_per_page);

  foreach ($results as $data) {
    $user = user_load($data->uid);
    $user_page = theme('username', array('account' => $user));

    $rows[] = array(
      ++$i,
      $user_page,
      $data->hits,
      $data->nodes,
      $data->comments
    );
  }
  $output  = visitors_date_filter();
  $output .= theme('table', array('header' => $header, 'rows' => $rows));
  $output .= theme('pager', array('quantity' => $items_per_page));

  return $output;
}

