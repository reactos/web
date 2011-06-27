<?php


/**
 * @file
 * Holds the contents of a preprocess function moved into its own file
 * to ease memory requirements and having too much code in one file.
 */
function _template_preprocess_advanced_forum_topic_list_view(&$variables) {
  // Even though this isn't needed for the actual topic list view, the other
  // views use this same style and need the AF style files added.
  _advanced_forum_add_files();
  advanced_forum_add_template_suggestions("topic-list-view", $variables);

  $view = $variables['view'];

  // We need the raw data for this grouping, which is passed in as $variables['rows'].
  // However, the template also needs to use for the rendered fields.  We
  // therefore swap the raw data out to a new variable and reset $variables['rows']
  // so that it can get rebuilt.
  $result = $variables['rows'];
  $variables['rows'] = array();

  $options = $view->style_plugin->options;
  $handler = $view->style_plugin;

  $fields = &$view->field;
  $columns = $handler->sanitize_columns($options['columns'], $fields);

  $active = !empty($handler->active) ? $handler->active : '';
  $order = !empty($handler->order) ? $handler->order : 'asc';

  $query = tablesort_get_query_parameters();

  $forum = $view->style_plugin->get_forum_ids();

  // Fields must be rendered in order as of Views 2.3, so we will pre-render
  // everything.
  $renders = array();
  $keys = array_keys($view->field);
  $stickies_done = FALSE;
  $sticky_count = 0;

  foreach ($result as $count => $row) {

    foreach ($keys as $id) {
      $renders[$count][$id] = $view->field[$id]->theme($row);
    }

    // Grab the teaser so it can be used on the title of the td as a popup
    // preview. By default, the view provides the teaser as a popup on the
    // title link.

    $teaser = $renders[$count]['teaser'];
    $teaser = htmlentities($teaser);
    $teasers[$count] = $teaser;

    // Determine stickiness.
    if (!$stickies_done) {
      $sticky[$count] = !empty($row->topic_is_sticky);
      if ($sticky[$count]) {
        $sticky_count++;
        $variables['row_classes'][$count][] = 'sticky';
      } else {
        $stickies_done = TRUE;
        if ($sticky_count) {
          // This ends up appearing only if we have both sticky and non sticky posts.
          // Otherwise it will never show up.
          $variables['row_classes'][$count - 1][] = 'forum-last-sticky';
        }
      }
    }

    // Shadow (moved) topics.
    if ($forum && !in_array($row->topic_actual_forum, $forum)) {
      $term = taxonomy_term_load($row->topic_actual_forum);
      $variables['shadow'][$count] = theme('advanced_forum_shadow_topic', array(
        'title' => $row->node_title,
        'nid' => $row->nid,
        'new_forum' => $term->name
          ));
    } else {
      $variables['shadow'][$count] = FALSE;
    }
  }
  // Make the sticky variable available to the template.
  $variables['sticky'] = $sticky;
  $variables['teasers'] = $teasers;

  foreach ($columns as $field => $column) {
    // render the header labels
    if ($field == $column && empty($fields[$field]->options['exclude'])) {
      $label = check_plain(!empty($fields[$field]) ? $fields[$field]->label() : '');
      if (empty($options['info'][$field]['sortable']) || !$fields[$field]->click_sortable()) {
        $variables['header'][$field] = $label;
      } else {
        // @todo -- make this a setting
        $initial = 'asc';

        if ($active == $field && $order == 'asc') {
          $initial = 'desc';
        }

        $title = t('sort by @s', array('@s' => $label));
        if ($active == $field) {
          $label .= theme('tablesort_indicator', array('style' => $initial));
        }

        $link_options = array(
          'html' => TRUE,
          'attributes' => array('title' => $title),
          'query' => $query + array(
        'order' => urlencode($field),
        'sort' => $initial
          )
        );

        $variables['header'][$field] = l($label, $_GET['q'], $link_options);
      }
    }

    // Create a second variable so we can easily find what fields we have and what the
    // CSS classes should be.
    $variables['fields'][$field] = drupal_clean_css_identifier($field);
    if ($active == $field) {
      $variables['fields'][$field] .= ' active';
    }

    // Render each field into its appropriate column.
    foreach ($result as $num => $row) {
      if (!empty($fields[$field]) && empty($fields[$field]->options['exclude'])) {
        $field_output = $renders[$num][$field];

        if (!isset($variables['rows'][$num][$column])) {
          $variables['rows'][$num][$column] = '';
        }

        // Don't bother with separators and stuff if the field does not show up.
        if ($field_output === '') {
          continue;
        }

        // Place the field into the column, along with an optional separator.
        if ($variables['rows'][$num][$column] !== '') {
          if (!empty($options['info'][$column]['separator'])) {
            $variables['rows'][$num][$column] .= filter_xss_admin($options['info'][$column]['separator']);
          }
        }

        $variables['rows'][$num][$column] .= $field_output;
      }
    }
  }

  foreach ($variables['rows'] as $num => $row) {
    $variables['row_classes'][$num][] = ($num % 2 == 0) ? 'odd' : 'even';
  }

  $variables['classes'] = 'views-table';
  if (!empty($options['sticky'])) {
    drupal_add_js('misc/tableheader.js');
    $variables['classes'] .= " sticky-enabled";
  }
}
