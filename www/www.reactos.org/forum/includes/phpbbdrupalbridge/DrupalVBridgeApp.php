<?php
// $Id: DrupalVBridgeApp.php,v 1.1 2009/02/27 21:10:29 vb Exp $
/*
 * VBridgeAppDrupal
 */
require_once(dirname(__FILE__) . '/VBridge/VBridgeApp.php');

class DrupalVBridgeApp extends VBridgeApp {
  //static private $_app;

  public function __construct($id, $bridgeData, $appData, $appDataConfig = array()) {
    parent::__construct($id, $bridgeData, $appData, $appDataConfig);
  }

  public function __destruct() {
    parent::__destruct();
  }

  private function __clone() { }

  protected function createObj($path, $objclass, $subclass = '') {
    $ok = parent::createObj($path, $objclass, $subclass);

    return $ok;
  }

  protected function create() {
    //if (SMF_API_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.'create');
    parent::create();

    return true;
  }

  public function init($options = array()) {
    return true;
  }

  public function run() { }
  /*
   public function notify($obj, $observable, $type, $event, $val) {
   if ($obj instanceof VBridge) {
   if (SMF_API_DEBUG)
   drupal_set_message(__CLASS__ .'::'.'notify'. ' type='. $type. 'event='. $event. 'val='.  $val);
   }
   }
   */

}
