<?php
/**
 * VBridge
 * Class library for developing integration software.
 * Copyright (C) 2008 Vadim G.B. (http://vgb.org.ru)
 *
 * This file is part of VBridge.
 *
 * VBridge is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * VBridge is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with VBridge.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    VBridge
 * @category   VBridge
 * @subpackage VBridge
 * @copyright  Copyright (C) 2008 Vadim G.B. (http://vgb.org.ru)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html  GNU Lesser General Public License, version 2.1
 * @version    $Id: VBridge.php,v 1.2 2009/03/15 13:49:36 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridgeException.php');
require_once(dirname(__FILE__) . '/VBridgeApp.php');

class VBridge {
  const VBRIDGE_CLASS_PREFIX = 'VBridge';

  public $vbridge_root_path;

  private $_name = 'VBridge';
  private $_app = array();
  private $_bridgeData = array();
  private $_observers = array();

  private $_status = 0;

  public function __toString() {
    return $this->_name;
  }

  public function getApp($id = 1) {
    if ($id < 0 || $id >= count($this->_app)) {
      return null;
    }
    return $this->_app[$id];
  }

  public function setApp($id, $val) {
    if ($id < 0) {
      return null;
    }
    $this->_app[$id] = $val;
  }

  public function __construct($bridgeData, $appData = array()) {
    //global $vbridge_root_path;
    $this->_bridgeData = $bridgeData;
    $this->vbridge_root_path = $bridgeData['#path']; //$vbridge_root_path;
    $this->_name = $bridgeData['#name'];

    $this->create($appData);
  }

  public function __destruct() { }

  protected function createApp($id, $appData) {
    //if (empty($appDataClass))
//  $appDataClass = $appDataName . $appDataType;
    /*
     $appData['#name']
     $appData['#type']
     $appData['#class']
     $appData['#dir']
     $appData['#path']
     $appData['#url']
     $appData['#config']
     */
    //$appClass = VBridgeApp::VBRIDGE_APP_CLASS_PREFIX . $appData['#class'];
    $appClass = $appData['#class'] . VBridgeApp::VBRIDGE_APP_CLASS_PREFIX;
    $appClassFileName = $appClass . '.php';
    $appClassFile = $appData['#dir'] . '/' . $appClassFileName;

    //if (VBRIDGE_DEBUG) {
    //drupal_set_message('AppData='. print_r($appData, true));
    //drupal_set_message('appClass='. $appClass .' appClassFile='. $appClassFile);
    //}

    if (file_exists($appClassFile)) {
      require_once($appClassFile);
      //if (VBRIDGE_DEBUG) {
      //drupal_set_message('Creating app='. $appClass);
      //}
      $this->_bridgeData['#bridgeInstance'] = $this;

      $this->_app[$id] = new $appClass($id, $this->_bridgeData, $appData, $appData['#config']);
    }

  }

  protected function create($appData) {

    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__);
    //if (VBRIDGE_DEBUG)
    //drupal_set_message('AppData='. print_r($appData, true));

    foreach ($appData as $id => $data) {
      if ($id >= 0) {
        $this->createApp($id, $data);
      }
    }

    if (self::getStatus()) {
      return false;
    }
    //if (VBRIDGE_DEBUG)
    //drupal_set_message('App='. print_r($this->_app, true));
    return true;
  }

  public function getStatus() {
    return $this->_status;
  }

  public function setStatus($val) {
    $this->_status = $val;
  }

  public function init($options = array()) {
    foreach ($this->_app as $app) {
      if (isset($app)) {
        $app->init($options);
      }
    }

    return true;
  }

  public function run() {
    foreach ($this->_app as $app) {
      if (isset($app)) {
        $app->run();
      }
    }

  }

  public function notifyObservers($observable, $obj, $type, $event, $val) {
    foreach ($this->_observers as $observer) {
      $observer->notify($this, $observable, $type, $event, $val);
    }
  }

  public function registerObserver($observer, $obj, $type, $event) {
    if ($observer instanceof VBridgeObserverInterface) {
      if ($observer instanceof VBridgeApp) {
        $id = $observer->getId();
        $this->_observers[$id] = $observer;
        $this->_observers[$id]['obj'] = $obj;
        $this->_observers[$id]['type'] = $type;
        $this->_observers[$id]['type']['event'] = $event;
      }
      else {
        $this->_observers[] = $observer;
        //$this->_observers[] = $obj;
      }
    }
  }

  public function authenticateUserExternal() {
    $authenticated = authenticate();
  }

  public function authenticateUser() {
    //$authenticated = authenticate();
  }

  public function authenticate() {

  }

  public function toInternalEncoding($str, $id = 0) {
    if (!empty($str)) {
      $input_charset = $this->getApp($id)->getCharset();
      $internal_charset = $this->getApp()->getCharset();
      if ($internal_charset != $input_charset && function_exists('iconv')) {
        $str = iconv($input_charset, $internal_charset, $str);
      }
    }
    return $str;
  }

  public function toExternalEncoding($str, $id = 0) {
    if (!empty($str)) {
      $external_charset = $this->getApp($id)->getCharset();
      $internal_charset = $this->getApp()->getCharset();
      if ($internal_charset != $external_charset && function_exists('iconv')) {
        $str = iconv($internal_charset, $external_charset, $str);
      }
    }
    return $str;
  }

  /*
   public function convertCharset($str)
   {
   $charset = getApp(1)->getCharset();
   if ($charset != 'UTF-8' && function_exists('iconv'))
   $str = iconv('UTF-8', $charset, $str);
   return $str;
   }
   */

  /**
   * Encode special characters in a plain-text string for display as HTML.
   *
   */
  public static function check_plain($text) {
    return VBridge::validate_utf8($text) ? htmlspecialchars($text, ENT_QUOTES) : '';
  }
  /**
   * Checks whether a string is valid UTF-8.
   */
  public static function validate_utf8($text) {
    if (strlen($text) == 0) {
      return TRUE;
    }
    return (preg_match('/^./us', $text) == 1);
  }
  /*
   public static function not_null($value) {
   if (is_array($value)) {
   if (sizeof($value) > 0) {
   return true;
   } else {
   return false;
   }
   } else {
   if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
   return true;
   } else {
   return false;
   }
   }
   }
   */
}
