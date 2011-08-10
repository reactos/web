<?php

/**
 * Renders the content using the jQuery UI Accordion widget.
 */
class QuickAccordion extends QuickRenderer {
  
  public static function optionsForm($qt) {
    $form = array();
    $form['autoHeight'] = array(
      '#type' => 'checkbox',
      '#title' => 'Autoheight',
      '#default_value' => (isset($qt->renderer) && $qt->renderer == 'accordion' && isset($qt->options['autoHeight']) && $qt->options['autoHeight']),
    );
    return $form;
  }
  
  public function render() {
    $quickset = $this->quickset;

    // Build our render array...
    $render_array = array();
    $render_array['#attached'] = $this->add_attached();
    $render_array['content'] = array(
      '#theme' => 'qt_accordion',
      '#options' => array('attributes' => array(
        'id' => 'quickset-' . $quickset->getName(),
        'class' => array('quick-accordion'),
      )),
      'divs' => array(),
    );

    // Render all tab content.
    foreach ($quickset->getContents() as $key => $item) {
      if (!empty($item)) {
        $render_array['content']['divs'][] = array(
          '#prefix' => '<h3><a href= "#">'. $item->getTitle() .'</a></h3><div>',
          '#suffix' => '</div>',
          'content' => $item->render(),
        );
      }
    }
    return $render_array;
  }
  
  /**
   * Add any necessary js, css and libraries for the render array.
   */
  protected function add_attached() {
    $attached = array(
      'library' => array(
        array('system', 'ui.accordion'),
      ),
      'js' => array(
        array('data' => drupal_get_path('module', 'quicktabs') . '/js/qt_accordion.js'),
      ),
    );
    $javascript = drupal_add_js();
    foreach ($javascript['settings']['data'] as $key => $settings) {
      if (key($settings) == 'quicktabs') {
        $qtkey = $key;
        break;
      }
    }
    $name = $this->quickset->getName();
    $settings = $this->quickset->getSettings();
    $options = $settings['options'];
    if (!isset($qtkey) || !array_key_exists('qt_' . $name, $javascript['settings']['data'][$qtkey]['quicktabs'])) {
      $quicktabs_array = array('name' => $name, 'active_tab' => $this->quickset->getActiveTab(), 'options' => $options);
      $attached['js'][] = array('data' => array('quicktabs' => array('qt_'. $name => $quicktabs_array)), 'type' => 'setting');
    }
    return $attached;
  }

}