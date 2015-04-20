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
 * @version    $Id: VBridgeAuthQookie.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridgeAuthQookieStorage.php');
require_once(dirname(__FILE__) . '/VBridgeAuthInterface.php');

class VBridgeAuthQookie implements VBridgeAuthInterface {
  private $_config;
  private $_session;
  private $_qookie;
  private $_pass;

  private $_storage;

  private $_result = array();

  private $_id;
  private $_idType;
  private $_username;
  private $_password;
  private $_passwordType;
  private $_password_salt;
  private $_lifetime;
  private $_validate = false;

  function __construct($config = array()) {
    $this->setConfig($config);
  }

  public function init() {
    return true;
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
    return $this;
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

  public function getStorage() {
    return $this->_storage;
  }

  public function setStorage($val) {
    $this->_storage = $val;
    return $this;
  }

  public function getResult() {
    return $this->_result;
  }

  public function setResult($val = array()) {
    $this->_result = $val;
    return $this;
  }

  public function getUserId() {
    return $this->_id;
  }
  public function setUserId($val) {
    $this->_id = $val;
    return $this;
  }

  public function getUserIdType() {
    return $this->_idType;
  }
  public function setUserIdType($val = 0) {
    $this->_idType = $val;
    return $this;
  }

  public function getUserName() {
    return $this->_username;
  }
  public function setUserName($val) {
    $this->_username = $val;
    return $this;
  }

  public function getPassword() {
    return $this->_password;
  }

  public function setPassword($val) {
    $this->_password = $val;
    return $this;
  }

  public function getPasswordSalt() {
    return $this->_password_salt;
  }

  public function setPasswordSalt($val) {
    $this->_password_salt = $val;
    return $this;
  }

  public function getPasswordType() {
    return $this->_passwordType;
  }

  public function setPasswordType($val) {
    $this->_passwordType = $val;
    return $this;
  }

  public function getPasswordValidate() {
    return $this->_validate;
  }


  public function setPasswordValidate($val) {
    $this->_validate = $val;
    return $this;
  }

  public function getLifetime() {
    return $this->_lifetime;
  }
  public function setLifetime($val) {
    $this->_lifetime = $val;
    return $this;
  }

  public function getUserQookie() {
    $id = 0;
    $password = '';
    $lifetime = 0;

    $storage = $this->getStorage();

    $data = $storage->read();
    if (!empty($data)) {
      list($id, $password, $lifetime) = $storage->read();
      $id = !empty($id) ? (int) $id : 0;
      $lifetime = $lifeTime - time();
      if ($lifetime < 0) {
        $lifetime = 0;
      }
    }

    $this->setUserId($id);
    $this->setPassword($password);
    $this->setLifetime($lifetime);

    return $id != 0;
  }


  public function authenticate() {
    $authenticated = $this->getUserQookie();
    if ($authenticated) {
    }
    return $authenticated;
  }


  public function validate($password) {
    $valid = false;

    // SMF
    // SHA-1 passwords should be 40 characters long.
    $sha1_password = $this->getPassword();
    if (strlen($sha1_password) == 40) {
      $encrypted = $this->getStorage()->encrypt($password);
      if ($encrypted == $sha1_password) {
        $valid = true;
      }
    }
    return $valid;
  }

  /**
   * Clears obj data
   *
   * @return void
   */
  public function clear() {
    $this->setUserId(0)
         ->setUserIdType()
         ->setUserName('')
         ->setPassword('')
         ->setPasswordSalt('')
         ->setLifetime(0)
         ->setPasswordType(VBridgeAuth::PASSWORD_TYPE_PLAIN)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_NO_VALIDATE)
         ->setResult();
    return $this;
  }
}
