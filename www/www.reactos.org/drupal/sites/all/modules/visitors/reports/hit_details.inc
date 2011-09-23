<?php

/**
 * @file
 * Hit details report for the visitors module.
 */

/**
 * Menu callback; Displays recent page accesses.
 *
 * @param visitors_id
 *   int visitors id from visitors table
 *
 * @return
 *   string hit details report or 404 error if visitors_id not found
 */
function visitors_hit_details($visitors_id) {
  $query = db_select('visitors', 'v');
  $query->leftJoin('users', 'u', 'u.uid=v.visitors_uid');
  $query->fields(
    'v',
    array(
      'visitors_url',
      'visitors_title',
      'visitors_referer',
      'visitors_date_time',
      'visitors_ip',
      'visitors_user_agent',
      'visitors_country_name',
      'visitors_region',
      'visitors_city',
      'visitors_postal_code',
      'visitors_latitude',
      'visitors_longitude',
      'visitors_dma_code',
      'visitors_area_code'
    )
  );
  $query->fields('u', array('name', 'uid'));
  $query->condition('v.visitors_id', (int)$visitors_id);
  $hit_details = $query->execute()->fetch();

  if ($hit_details) {
    $url = urldecode($hit_details->visitors_url);
    $referer = $hit_details->visitors_referer;
    $date = format_date(
      $hit_details->visitors_date_time,
      'large',
      visitors_get_timezone()
    );
    $whois_enable = module_exists('whois');
    $attr = array(
      'attributes' => array(
        'target' => '_blank',
        'title' => t('Whois lookup')
      )
    );
    $ip = long2ip($hit_details->visitors_ip);

    $array = array(
      'URL'            => l($url, $url),
      'Title'          => check_plain($hit_details->visitors_title),
      'Referer'        => $referer ? l($referer, $referer) : '',
      'Date'           => $date,
      'User'           => theme('username', array('account' => $hit_details)),
      'IP'             => $whois_enable ? l($ip, 'whois/' . $ip, $attr) : $ip,
      'User Agent'     => check_plain($hit_details->visitors_user_agent),
      'Country'        => check_plain($hit_details->visitors_country_name),
      'Region'         => check_plain($hit_details->visitors_region),
      'City'           => check_plain($hit_details->visitors_city),
      'Postal Code'    => check_plain($hit_details->visitors_postal_code),
      'Latitude'       => check_plain($hit_details->visitors_latitude),
      'Longitude'      => check_plain($hit_details->visitors_longitude),
      'DMA Code'       => check_plain($hit_details->visitors_dma_code),
      'PSTN Area Code' => check_plain($hit_details->visitors_area_code),
    );

    $rows = array();
    foreach ($array as $key => $value) {
      $rows[] = array(array('data' => t($key), 'header' => TRUE), $value);
    }

    drupal_set_title(t('Details'));
    return theme('table', array('rows' => $rows));
  }

  drupal_not_found();
}

