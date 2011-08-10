<?php

/**
 * Renders the content using the jQuery UI Tabs widget.
 */
class QuickUiTabs extends QuickRenderer {
  
  public function render() {
    $quickset = $this->quickset;

    $active_tab = $quickset->getActiveTab();
    $tabs = $this->build_tablinks($active_tab);
    $qt_name = $quickset->getName();
    $render_array = array(
      '#attached' => $this->add_attached(),
      'content' => array(
	'#theme' => 'qt_ui_tabs',
	'#options' => array('attributes' => array(
	  'id' => 'quicktabs-' . $qt_name,
	  'class' => 'quicktabs-wrapper',
	)),
	'tabs' => array('#theme' => 'qt_ui_tabs_tabset', '#options' => array('active' => $active_tab), 'tablinks' => $tabs),
	'divs' => array(),
      ),
    );
    foreach ($quickset->getContents() as $key => $tab) {
      if (!empty($tab)) {
	$attribs = array(
	  'id' => 'qt-'. $qt_name .'-ui-tabs' . ($key+1),
	);
	$render_array['content']['divs'][] = array(
	  '#prefix' => '<div '. drupal_attributes($attribs) .'>',
	  '#suffix' => '</div>',
	  'content' => $tab->render(),
	);
      }
    }
    return $render_array;
  }

  
  /**
   * Build the actual tab links, with appropriate href, title and attributes.
   * 
   * @param $active_tab The index of the active tab.
   */
  protected function build_tablinks($active_tab) {
    $tabs = array();
    $qt_name = $this->quickset->getName();
    foreach ($this->quickset->getContents() as $i => $tab) {
      if (!empty($tab)) {
	// If we use l() here or a render array of type 'link', the '#' symbol will
	// be escaped. Sad panda is sad.
	$href = '#qt-'. $qt_name .'-ui-tabs' . ($i+1);
	$tablink = array(
	  '#markup' => '<a href="'. $href .'">'. $tab->getTitle() .'</a>',
	);
	$tabs[$i] = $tablink;
      }
    }
    return $tabs;
  }

  /**
   * Add any necessary js, css and libraries for the render array.
   */
  protected function add_attached() {
    $active_tab = $this->quickset->getActiveTab();
    $attached = array(
      'js' => array(
	array(
	  'data' => "jQuery(function() { jQuery('.quicktabs-wrapper').tabs({selected: $active_tab})})",
	  'type' => 'inline',
	)
      ),
      'library' => array(
	array('system', 'ui.tabs'),
      ),
    );
    return $attached;
  }
}
