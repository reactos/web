<?php

/**
 * @file
 * Node page callbacks for the visitors module.
 */

/**
 * Display node visitors report.
 *
 * @return
 *   string node visitors report html source
 */
function visitors_node() {
  if ($node = node_load(arg(1))) {
    $date_format    = variable_get('date_format_short_custom', 'Y-m-d H:i:s');
    $items_per_page = variable_get('visitors_lines_per_page', 10);

    $header = array(
      array('data' => t('#')),
      array('data' => t('ID'), 'field' => 'visitors_id', 'sort' => 'desc'),
      array('data' => t('Date'), 'field' => 'visitors_date_time'),
      array('data' => t('Referer'), 'field' => 'visitors_referer'),
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
        'visitors_uid',
        'visitors_id',
        'visitors_date_time',
        'visitors_referer'
      )
    );
    $query->fields('u', array('name', 'uid'));
    $query->condition(
      'v.visitors_path', 'node/' . (int)$node->nid . '%',
      'LIKE'
    );
    visitors_date_filter_sql_condition($query);
    $query->orderByHeader($header);
    $query->limit($items_per_page);

    $results = $query->execute();
    $rows = array();
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    $i = 0 + ($page  * $items_per_page);
    foreach ($results as $data) {
      $user = user_load($data->visitors_uid);
      $user_page = theme('username', array('account' => $user));
      $rows[] = array(
        ++$i,
        $data->visitors_id,
        format_date($data->visitors_date_time, 'custom', $date_format),
        l($data->visitors_referer, $data->visitors_referer),
        $user_page,
        l(t('details'), 'visitors/hits/' . $data->visitors_id)
      );
    }

    $output  = visitors_date_filter();
    $output .= theme('table', array('header' => $header, 'rows' => $rows));
    $output .= theme('pager', array('quantity' => $items_per_page));

    return $output;
  }
}

