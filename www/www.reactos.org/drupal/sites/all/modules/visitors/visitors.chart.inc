<?php

/* vim: set filetype=php: */

/**
 * @file
 * Draw chart for the visitors module.
 */

require_once VISITORS_MODULE_CHART_DIR . '/pData.inc';
require_once VISITORS_MODULE_CHART_DIR . '/pChart.inc';

/**
 * Get chart width.
 *
 * @return
 *   int chart width
 */
function visitors_get_chart_width() {
  $width = (int) variable_get('visitors_chart_width', 700);
  return (($width <= 0) ? 700 : $width);
}

/**
 * Get chart height.
 *
 * @return
 *   int chart height
 */
function visitors_get_chart_height() {
  $height = (int) variable_get('visitors_chart_height', 430);
  return (($height <= 0) ? 430 : $height);
}

/**
 * Draw chart.
 *
 * @values
 *   int array y-axis values
 * @x_array
 *   array x-axis params
 */
function visitors_chart($values, $x_array = NULL) {
  // Dataset definition
  $data_set = new pData;
  $data_set->AddPoint($values, 'Serie1');

  if ($x_array !== NULL) {
    $data_set->AddPoint($x_array, 'Serie2');
    $data_set->SetAbsciseLabelSerie('Serie2');
  }

  $data_set->AddSerie('Serie1');
  $data_set->SetSerieName('', 'Serie1');

  $data = $data_set->GetData();
  $data_description = $data_set->GetDataDescription();

  // Initialise the chart
  $width  = visitors_get_chart_width();
  $height = visitors_get_chart_height();

  $pchart = new pChart($width, $height);
  $pchart->setFontProperties(dirname(__FILE__) . '/fonts/tahoma.ttf', 8);
  $pchart->setGraphArea(50, 30, $width - 20, $height - 30);
  $pchart->drawFilledRoundedRectangle(7, 7, $width - 7, $height - 7,
    5, 240, 240, 240);
  $pchart->drawRoundedRectangle(5, 5, $width - 5, $height - 5,
    5, 230, 230, 230);
  $pchart->drawGraphArea(255, 255, 255, TRUE);
  $pchart->setFixedScale(0, 0, 0, 0, 0, 0, 0);
  $pchart->drawScale($data, $data_description,
    SCALE_ADDALLSTART0, 150, 150, 150, TRUE, 0, 0, TRUE
  );
  $pchart->drawGrid(4, TRUE, 230, 230, 230, 50);

  // Draw the 0 line
  $pchart->drawTreshold(0, 143, 55, 72, TRUE, TRUE);

  // Draw the bar chart
  $pchart->drawBarGraph($data, $data_description, TRUE);

  // Finish the chart
  $pchart->Stroke();
  exit();
}

