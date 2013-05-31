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
 * @version    $Id: VBridgeApp.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridgeObserverInterface.php');
require_once(dirname(__FILE__) . '/VBridge.php');

class VBridgeApp implements VBridgeObserverInterface {
  const VBRIDGE_APP_CLASS_PREFIX = 'VBridgeApp';

  public $vbridge_root_path;

  public $db_name;
  public $db_user;
  public $db_password;
  public $db_prefix;
  public $db_charset = 'UTF-8';

  private $_id;
  private $_name;
  private $_type;
  private $_path;
  private $_url;
  private $_class;
  private $_config;
  private $_bridgeData = array();
  private $_objclass = array();
  protected $_bridge;

  private $_db;
  private $_user;
  private $_auth;
  private $_authmethod = array();
  private $_authstorage = array();
  private $_session;
  private $_qookie;
  private $_pass;


  private $_status = 0;

  protected $_charset = 'UTF-8';
  protected $_language = 'en';

  public function __toString() {
    return $this->_name;
  }

  public function getId() {
    return $this->_id;
  }

  public function setId($id) {
    $this->_id = $id;
  }

  public function getUser() {
    return $this->_user;
  }

  public function getName() {
    return $this->_name;
  }
  public function setName($val) {
    $this->_name = $val;
  }

  public function getType() {
    return $this->_type;
  }
  public function setType($val) {
    $this->_type = $val;
  }

  public function getPath() {
    return $this->_path;
  }
  public function setPath($val) {
    $this->_path = $val;
  }

  public function getUrl() {
    return $this->_url;
  }
  public function setUrl($val) {
    $this->_url = $val;
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
  }

  public function getClass() {
    return $this->_class;
  }
  public function setClass($val) {
    $this->_class = $val;
  }

  public function getCharset() {
    return $this->_charset;
  }
  public function setCharset($val) {
    $this->_charset = $val;
  }

  public function getLanguage() {
    return $this->_language;
  }
  public function setLanguage($val) {
    $this->_language = $val;
  }

  public function getDb() {
    return $this->_db;
  }
  public function setDb($val) {
    $this->_db;
  }

  public function getConnnection() {
    return $this->getDb()->getConnnection();
  }
  public function setConnnection($val) {
    $this->getDb()->setConnnection($val);
  }

  public function getDbPrefix() {
    return $this->db_prefix;
  }
  public function setDbPrefix($val) {
    $this->db_prefix($val);
  }

  public function getStatus() {
    return $this->_status;
  }

  public function setStatus($val) {
    $this->_status = $val;
  }

  public function getSession() {
    return $this->_session;
  }

  public function setSession($val) {
    $this->_session = $val;
  }

  public function getQookie() {
    return $this->_qookie;
  }
  public function setQookie($val) {
    $this->_qookie = $val;
  }

  public function getPass() {
    return $this->_pass;
  }
  public function setPass($val) {
    $this->_pass = $val;
  }

  public function getAuth() {
    return $this->_auth;
  }

  public function setAuth($val) {
    $this->_auth = $val;
  }

  public function getAuthStorage($storage = array()) {
    $auth = $this->getAuth();
    if (is_object($auth)) {
      return $auth->getStorage($storage);
    }
    return null;
  }

  public function setAuthStorage($storage, $obj = null) {
    $auth = $this->getAuth();
    if (is_object($auth)) {
      $auth->setStorage($storage, $obj);
    }
  }

  public function getAuthMethod($method = array()) {
    $auth = $this->getAuth();
    if (is_object($auth)) {
      return $auth->getMethod($method);
    }
    return null;
  }

  public function setAuthMethod($method, $obj = null) {
    $auth = $this->getAuth();
    if (is_object($auth)) {
      $auth->setMethod($method, $obj);
    }
    //return $this;
  }

  public function setAuthMethods() {
    $auth = $this->getAuth();
    $auth->setPass($this->getPass());

    foreach ($this->_authmethod as $method => $obj) {
      if (is_object($obj) && $obj instanceof VBridgeAuthInterface) {
        $auth->setMethod($method, $obj);
        $obj->setPass($this->getPass());
        // set Auth Storage
        //if (VBRIDGE_DEBUG)
        //drupal_set_message(__CLASS__ .'::'. $obj->getName() .', *method='.$method);
        //$storage = $method . 'qookie';
        $storage = 'qookiestorage';
        if (isset($this->_authstorage[$storage])) {
          $objstorage = $this->_authstorage[$storage];
          if (is_object($objstorage) && $objstorage instanceof VBridgeAuthStorageInterface) {
            $obj->setStorage($objstorage);
            $objstorage->setQookie($this->getQookie());
            $objstorage->setSession($this->getSession());
            //if (VBRIDGE_DEBUG)
            //drupal_set_message(__CLASS__ .'::'. $obj->getName() .', *storage method='.$storage);
          }
        }
      }
    }
  }

  public function setAuthStorages() {
    $auth = $this->getAuth();

    foreach ($this->_authstorage as $storage => $objstorage) {
      if (is_object($objstorage) && $objstorage instanceof VBridgeAuthStorageInterface) {
        $auth->setStorage($storage, $objstorage);
        $objstorage->setPass($this->getPass());
        //$objstorage->setQookie($this->getQookie());
        //$objstorage->setSession($this->getSession());
        //if (VBRIDGE_DEBUG)
        //drupal_set_message(__CLASS__ .'::'. ', **storage='.$storage);
      }
    }
  }

  public function getBridge() {
    return $this->_bridge;
  }

  public function __construct($id, $bridgeData, $appData, $appDataConfig = array()) {
    //global $vbridge_root_path;
    $this->_id = $id;
    $this->_bridgeData = $bridgeData;
    $this->_bridge = $bridgeData['#bridgeInstance'];
    $this->_objclass = $bridgeData['#objclass'];
    $this->vbridge_root_path = $bridgeData['#path']; //$vbridge_root_path;
    /*
     $appData['#name']
     $appData['#type']
     $appData['#class']
     $appData['#dir']
     $appData['#path']
     $appData['#url']
     $appData['#config']
     */

    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__.$this->getId());

    $this->setName($appData['#name']);
    $this->setType($appData['#type']);
    $this->setPath($appData['#path']);
    $this->setUrl($appData['#url']);
    $this->setClass($appData['#class']);
    $this->setConfig($appDataConfig);

    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__.' _name='.$this->getName());

    $this->create();
  }

  public function __destruct() { }

  protected function createObj($path, $objclass, $subclass = '') {
    //$objClass = self::VBRIDGE_CLASS_PREFIX . $objclass . $subclass;
    $objClass = $subclass . VBridge::VBRIDGE_CLASS_PREFIX . $objclass;
    $objClassFileName = $objClass . '.php';
    $objClassFile = $path . '/' . $objClassFileName;

    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'. $objClass .', File='.$objClassFile);

    if (file_exists($objClassFile)) {
      require_once($objClassFile);

      $obj = new $objClass($this->getConfig());

      if (is_object($obj)) {

        if ((strlen($objclass) > 4) && (substr($objclass, 0, 4) == 'Auth')) {
          $authMethod = substr($objclass, 4);
          $authmethod = strtolower($authMethod);
          //$methodlen = strlen($authMethod);
          //if (VBRIDGE_DEBUG)
          //drupal_set_message(__CLASS__ .'::'. $objClass .' authMethod='. $authMethod.' len='.strlen($authmethod).', storage=='.substr($authMethod, -7));
          if ((strlen($authmethod) > 7) && (substr($authMethod, -7) == 'Storage')) {
            $authstorage = $authmethod;
            //$obj->setName($authmethod);
            $this->_authstorage[$authstorage] = $obj;
            if (VBRIDGE_DEBUG) {
              drupal_set_message(__CLASS__ . '::' . $objClass . ', storage=' . $authmethod);
            }
          }
          else {
            //$obj->setName($authmethod);
            $this->_authmethod[$authmethod] = $obj;
            if (VBRIDGE_DEBUG) {
              drupal_set_message(__CLASS__ . '::' . $objClass . ', method=' . $authmethod);
            }
          }

        }
        else {
          $_obj = '_' . strtolower($objclass);
          $this->$_obj = $obj;
          if (VBRIDGE_DEBUG) {
            drupal_set_message(__CLASS__ . '::' . $objClass . ', objclass=' . $_obj);
          }
        }
        return true;
      }
      else {
        self::setStatus(-1);
      }
    }
    return false;
  }

  protected function create() {

    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.__METHOD__);

    $path = $this->vbridge_root_path;
    $path_vbridge = $path . '/' . VBridge::VBRIDGE_CLASS_PREFIX;
    $subclass = $this->getClass();

    foreach ($this->_objclass as $objclass) {
      if (!$this->createObj($path, $objclass, $subclass)) {
        $this->createObj($path_vbridge, $objclass);
      }
    }

    if (self::getStatus()) {
      return false;
    }

    // Set User Session Qookie
    //$this->getUser()->setQookie($this->getQookie());
    // Set User Session
    $this->getUser()->setSession($this->getSession());
    $this->getSession()->setQookie($this->getQookie());
    //$this->getUser()->setAuth($this->getAuth());
    // Set User Pass
    $this->getUser()->setPass($this->getPass());

    // Set Auth
    $this->setAuthMethods();
    $this->setAuthStorages();

    //
    foreach ($this->getConfig() as $config) {

      if ($config['#type'] == '#class') {
        //createObj($config['#name'], $config['#type'], $config['#class'], $config['#path'], $appData['#config']);
      }
    }

    return true;
  }

  public function init($options = array()) {
    $this->initQookie($options);
    return true;
  }

  public function run() {

  }

  public function notify($obj, $observable, $type, $event, $val) {
    if ($obj instanceof VBridge) {
      if (VBRIDGE_DEBUG) {
        drupal_set_message(__CLASS__ . '::' . __METHOD__ . ' type=' . $type . 'event=' . $event . 'val=' .  $val);
      }
    }
  }

  public function getUserNameById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    return $this->getDb()->getUserNameById($id, $password);
  }

  public function getUserRealNameById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    return $this->getDb()->getUserRealNameById($id, $password);
  }

  public function getUserIdByUserName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    return $this->getDb()->getUserIdByUserName($username, $password);
  }

  public function getUserIdByRealName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    return $this->getDb()->getUserIdByRealName($username, $password);
  }

  public function getUserIdByEmail($email, $password = '') {
    if (empty($email) || strpos($email, "@") === false) {
      return false;
    }
    return $this->getDb()->getUserIdByEmail($email, $password);
  }

  public function loadUser($id, $password = '') {
    $this->getDb()->loadUser($id, $password);
  }

  public function loadUserById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    return $this->getDb()->loadUserById($id, $password);
  }

  public function loadUserByUserName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    return $this->getDb()->loadUserByUserName($username, $password);
  }

  public function loadUserByRealName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    return $this->getDb()->loadUserByRealName($username, $password);
  }

  public function loadUserByEmail($email, $password = '') {
    if (empty($email) || strpos($email, "@") === false) {
      return false;
    }
    return $this->getDb()->loadUserByEmail($email, $password);
  }

  public function saveUser() {
    return false;
  }

  public function deleteUser($id, $mode = 'retain', $post_username = false) {
    return false;
  }

  public function registerUser($username, $password, $email, $data = array()) {
    return false;
  }

  public function updateUser($id, $username = '', $password = '', $email = '', $data = array()) {
    if (!$id) {
      return false;
    }

    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);

    return $this->getApp()->updateUser($id, $username, $password, $email, $data);
  }

  public function login($username, $password, $options = array()) {
    if (empty($username) || empty($password)) {
      return false;
    }

    $auth = $this->getAuth();
    $auth->clear()
         //->setUserId(0)
         ->setUserIdType(VBridgeAuth::USER_ID_TYPE_USERNAME)
         ->setUserName($username)
         ->setPassword($password)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_VALIDATE)
         ->setStoreAuth(false);
    $authenticated = $auth->authenticate('db');
    if ($authenticated) {
      $authenticated = $this->loadUserById($auth->getUserId());
      if ($authenticated) {
        $user = $this->getUser();
        $auth->setPasswordSalt($user->getPasswordSalt());
        $authenticated = $auth->validate($user->getPassword());
      }
    }
    return $authenticated;
  }

  public function logout() {
    $auth = $this->getAuth();
    $auth->clearStorage()
         ->clear();
  }

  public function setUserQookie($id, $password = '', $encrypted = VBridgePass::PASSWORD_PLAIN) {
    if (empty($id)) {
      return false;
    }

    $user = $this->getUser();

    $user_id = $user->getUserId();
    if ($user_id == 0) {
      return false;
    }

    $username = $user->getUserName();
    $user_password = $user->getPassword();
    $user_password_salt = $user->getPasswordSalt();

    $auth = $this->getAuth();

    if (!$encrypted) {
      if (!empty($password)) {
        $pass = $this->getPass();

        if (empty($user_password_salt)) {
          $user_password_salt = $pass->generateSalt($user_password, VBridgePass::PASSWORD_ENCRYPTED);
        }

        $pass->setPassword($password)
              ->setPasswordSalt($user_password_salt)
              ->setUserName($username);

        $password = $pass->encrypt();

        $user->setPassword($password);
      }
    }

    $auth->clear()
         ->setUserId($id)
         ->setUserIdType(VBridgeAuth::USER_ID_TYPE_USERNAME)
         ->setUserName($username)
         ->setPassword($password)
         ->setPasswordType(VBridgePass::PASSWORD_ENCRYPTED)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_VALIDATE)
         ->setStoreAuth(false);

    $auth->writeStorage();

    return true;
  }

  //public function setUserAsAuthenticated($id, $username, $password = '', $encrypted = true)
  public function loginExternal($id, $username = '', $password = '') {
    //if (empty(id) == 0 || empty($username) /*|| empty($password)*/)
//  return false;

    return $this->setUserQookie($id, $password, VBridgePass::PASSWORD_PLAIN);

    $auth = $this->getAuth();
    $user = $this->getUser();

    $user_id = $user->getUserId();

    if (empty($id) || $user_id == 0) {
      return false;
    }

    if (!$encrypted) {
      if (!empty($password)) {
        //$password = tep_encrypt_password($password);
        $password = osc_encrypt_password($password, $oscommerce_user['password']);
        $oscommerce_user['password'] = $password;
      }
    }

    $auth->clear()
         ->setUserId($id)
         ->setUserIdType(VBridgeAuth::USER_ID_TYPE_USERNAME)
         ->setUserName($username)
         ->setPassword($password)
         ->setPasswordType($encrypted)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_VALIDATE)
         ->setStoreAuth(false);
    $authenticated = $auth->authenticate('db');
    if ($authenticated) {
      $authenticated = $this->loadUserById($auth->getUserId());
      if ($authenticated) {
        $user = $this->getUser();
        $auth->setPasswordSalt($user->getPasswordSalt());
        $authenticated = $auth->validate($user->getPassword());
      }
    }
    return $authenticated;
  }

  public function authenticateUserExternal() {
    $authenticated = false;
    return $authenticated;
  }

  public function authenticateUser() {
    $auth = $this->getAuth();
    $auth->clear()
         ->setPasswordType(VBridgeAuth::PASSWORD_TYPE_ENCRYPTED)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_NO_VALIDATE)
         ->setStoreAuth(false);
    $authenticated = $auth->authenticate('qookie');
    if ($authenticated) {
      $authenticated = $this->loadUserById($auth->getUserId());
      if ($authenticated) {
        $user = $this->getUser();
        $auth->setPasswordSalt($user->getPasswordSalt());
        $authenticated = $auth->validate($user->getPassword());
      }
    }
    return $authenticated;
  }

  public function getAppUser($id, $password = '') {
    if (empty($id)) {
      return false;
    }

    $email = $id;
    $username = $id;

    // authentication
    $authenticated = $this->authenticateUser();
    $user = $this->getUser();

    if ($authenticated &&
          ( /*! is_integer($id) &&*/ ($username == $user->getUserName() || $email == $user->getUserEmail())  )
        ) {
      return true;
    }

    $found = $this->loadUserByUserName($username, $password);
    if (!$found) {
      $found = $this->loadUserByEmail($email, $password);
      if (!$found) {
        $user->clear();
        return false;
      }
    }

    if (!empty($password)) {
      $valid = $user->validatePassword($password);
      if (!$valid) {
        $user->setPassword('')
             ->setPasswordSalt('');
        return false;
      }
    }
    else {
      $user->setPassword('')
           ->setPasswordSalt('');
    }

    $user->setGuest(true);

    return true;
  }


  public function authenticate() {
    $authenticated = false;

    $authMethods = $this->getAuth()->getMethod(array());
    foreach ($authMethods as $authMethod) {
      if (is_object($authMethod)) {
        $authenticated = $authMethod->authenticate($id, $password);
        if ($authenticated) {
          break;
        }
      }
    }
    return $authenticated;
  }

  public function getQookieName() {
    return $this->getQookie()->getName();
  }
  public function setQookieName($val) {
    return $this->getQookie()->setName($val);
  }

  public function getQookieDomain() {
    return $this->getQookie()->getDomain();
  }
  public function setQookieDomain($val) {
    return $this->getQookie()->setDomain($val);
  }

  public function getQookiePath() {
    return $this->getQookie()->getPath();
  }
  public function setQookiePath($val) {
    return $this->getQookie()->setPath($val);
  }

  public function getQookieLifetime() {
    return $this->getQookie()->getLifetime();
  }
  public function setQookieLifetime($val) {
    return $this->getQookie()->setLifetime($val);
  }

  public function isUserOnline($id = 0) {
    return $this->getUser()->isOnline();
  }

  public function isUserActive($id = 0) {
    return $this->getUser()->isActive();
  }

  public function isUserBanned($id = 0) {
    return $this->getUser()->isBanned();
  }

  public function isUserBannedEmail($id = 0) {
    return $this->getUser()->isBannedEmail();
  }

  public function isUserRegistered($id = 0) {
    return $this->getUser()->isRegistered();
  }

  public function isUserGuest($id = 0) {
    return $this->getUser()->isGuest();
  }

  public function isUserBot($id = 0) {
    return $this->getUser()->isBot();
  }

  public function initQookie($options = array()) {
    $cookie_domain = $this->_config['cookie_domain'];

    if (!empty($this->_url)) {
      $base_url = $this->getUrl();
      $parts = parse_url($base_url);
      if (!isset($parts['path'])) {
        $parts['path'] = '';
      }
      $base_path = $parts['path'] . '/';
      // Build $base_root (everything until first slash after "scheme://").
      $base_root = substr($base_url, 0, strlen($base_url) - strlen($parts['path']));
    }
    else {
      // Create base URL
      $base_root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

      // As $_SERVER['HTTP_HOST'] is user input, ensure it only contains
      // characters allowed in hostnames.
      $base_url = $base_root .= '://' . preg_replace('/[^a-z0-9-:._]/i', '', $_SERVER['HTTP_HOST']);

      // $_SERVER['SCRIPT_NAME'] can, in contrast to $_SERVER['PHP_SELF'], not
      // be modified by a visitor.
      if ($dir = trim(dirname($_SERVER['SCRIPT_NAME']), '\,/')) {
        $base_path = "/$dir";
        $base_url .= $base_path;
        $base_path .= '/';
      }
      else {
        $base_path = '/';
      }
    }

    $this->_config['cookie_path'] = $base_path;

    if (!empty($cookie_domain)) {
      // If the user specifies the cookie domain, also use it for session name.
      $session_name = $cookie_domain;
    }
    else {
      // Otherwise use $base_url as session name, without the protocol
      // to use the same session identifiers across http and https.
      list( , $session_name) = explode('://', $base_url, 2);
      // We escape the hostname because it can be modified by a visitor.
      if (!empty($_SERVER['HTTP_HOST'])) {
        $cookie_domain = VBridge::check_plain($_SERVER['HTTP_HOST']);
      }
    }
    // Strip leading periods, www., and port numbers from cookie domain.
    $cookie_domain = ltrim($cookie_domain, '.');
    if (strpos($cookie_domain, 'www.') === 0) {
      $cookie_domain = substr($cookie_domain, 4);
    }
    $cookie_domain = explode(':', $cookie_domain);
    $cookie_domain = '.' . $cookie_domain[0];
    // Per RFC 2109, cookie domains must contain at least one dot other than the
    // first. For hosts such as 'localhost' or IP Addresses we don't set a cookie domain.
    if (count(explode('.', $cookie_domain)) > 2 && !is_numeric(str_replace('.', '', $cookie_domain))) {
      //ini_set('session.cookie_domain', $cookie_domain);
      $this->_config['cookie_domain'] = $cookie_domain;
    }

    $this->_config['session_name'] = $session_name;
    //session_name('SESS'. md5($session_name));
  }

}
