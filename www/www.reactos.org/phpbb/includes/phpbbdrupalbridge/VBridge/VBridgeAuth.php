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
 * @version    $Id: VBridgeAuth.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgeAuth {
  const USER_ID_TYPE_ID = 0;
  const USER_ID_TYPE_USERNAME = 1;
  const USER_ID_TYPE_NAME = 1;
  const USER_ID_TYPE_EMAIL = 2;
  const PASSWORD_TYPE_PLAIN = 0;
  const PASSWORD_TYPE_ENCRYPTED = 1;
  const PASSWORD_NO_VALIDATE = false;
  const PASSWORD_VALIDATE = true;

  private $_config;

  private $_session;
  private $_qookie;
  private $_pass;

  private $_method = array();
  private $_storage = array();
  private $_storeAuth = false;

  private $_result = array();

  private $_id;
  private $_idType;
  private $_username;
  private $_password;
  private $_password_salt;
  private $_passwordType;
  private $_validate = false;


  function __construct($config = array()) {
    $this->setConfig($config);
  }

  public function getMethod($method = array()) {
    if (empty($method) || is_array($method)) {
      return $this->_method;
    }
    elseif (isset($this->_method[$method])) {
      return $this->_method[$method];
    }
    return null;
  }

  public function setMethod($method, $obj = null) {
    if (is_array($method)) {
      $this->_method = $method;
    }
    elseif (is_object($obj)) {
      $this->_method[$method] = $obj;
    }
    return $this;
  }

  public function getStorage($storage = array()) {
    if (empty($storage) || is_array($storage)) {
      return $this->_storage;
    }
    elseif (isset($this->_storage[$storage])) {
      return $this->_storage[$storage];
    }
    return null;
  }

  public function setStorage($storage, $obj = null) {
    if (is_array($storage)) {
      $this->_storage = $storage;
    }
    elseif (is_object($obj)) {
      $this->_storage[$storage] = $obj;
    }
    return $this;
  }

  public function getStoreAuth() {
    return $this->_storeAuth;
  }

  public function setStoreAuth($val) {
    $this->_storeAuth = $val;
    return $this;
  }

  public function getResult() {
    return $this->_result;
  }

  public function setResult($val = null) {
    $this->_result = $val;
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

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
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


  /**
   * Returns true if and only if storage is empty
   * @return boolean
   */
  public function isEmptyStorage($storage) {
    if (!empty($storage) && isset($this->_storage[$storage])) {
      $obj = $this->_storage[$storage];
      return $obj->isEmpty();
    }
    return false;
  }

  /**
   * Returns the data of storage
   * @return mixed
   */
  public function readStorage($storage) {
    if (!empty($storage) && isset($this->_storage[$storage])) {
      $obj = $this->_storage[$storage];
      return $obj->read();
    }
    return null;
  }

  /**
   * Writes data to storage
   *
   * @param  mixed $data
   * @return void
   */
  public function writeStorage($data = null, $storage = array()) {
    if (empty($storage) || is_array($storage)) {
      foreach ($this->_storage as $obj) {
        $obj->setUserId($this->getUserId())
            ->setUserIdType($this->getUserIdType())
            ->setUserName($this->getUserName())
            ->setPassword($this->getPassword())
            ->setPasswordSalt($this->getPasswordSalt())
            ->setPasswordType($this->getPasswordType());
        $obj->write($data);
      }
    }
    elseif (isset($this->_storage[$storage])) {
      $obj = $this->_storage[$storage];
      $obj->setUserId($this->getUserId())
          ->setUserIdType($this->getUserIdType())
          ->setUserName($this->getUserName())
          ->setPassword($this->getPassword())
          ->setPasswordSalt($this->getPasswordSalt())
          ->setPasswordType($this->getPasswordType());
      $obj->write($data);
    }
    return $this;
  }

  /**
   * Clears data from storage
   *
   * @return void
   */
  public function clearStorage($storage = array()) {
    if (empty($storage) || is_array($storage)) {
      foreach ($this->_storage as $objstorage) {
        $obj->clear();
      }
    }
    elseif (isset($this->_storage[$storage])) {
      $obj = $this->_storage[$storage];
      $obj->clear();
    }
    return $this;
  }

  /**
   * Authenticate
   *
   * @return bool
   */
  public function authenticate($method = array()) {
    if (empty($method) || is_array($method)) {
      foreach ($this->_method as $obj) {
        $obj->setUserId($this->getUserId())
            ->setUserIdType($this->getUserIdType())
            ->setUserName($this->getUserName())
            ->setPassword($this->getPassword())
            ->setPasswordSalt($this->getPasswordSalt())
            ->setPasswordType($this->getPasswordType())
            ->setPasswordValidate($this->getPasswordValidate())
            ->setResult();
        $authenticated = $obj->authenticate();
        if ($authenticated) {
          $this->setUserId($obj->getUserId());
          $this->setUserName($obj->getUserName());
          $this->setPassword($obj->getPassword());
          $this->setResult($obj->getResult());
          if ($this->getStoreAuth() && ($this->getPasswordValidate() != VBridgeAuth::PASSWORD_NO_VALIDATE)) {
            $this->writeStorage();
          }
          return $authenticated;
        }
        $this->setResult($obj->getResult());
      }
    }
    elseif (isset($this->_method[$method])) {
      $obj = $this->_method[$method];
      $obj->setUserId($this->getUserId())
          ->setUserIdType($this->getUserIdType())
          ->setUserName($this->getUserName())
          ->setPassword($this->getPassword())
          ->setPasswordSalt($this->getPasswordSalt())
          ->setPasswordType($this->getPasswordType())
          ->setPasswordValidate($this->getPasswordValidate())
          ->setResult();
      $authenticated = $obj->authenticate();
      if ($authenticated) {
        $this->setUserId($obj->getUserId());
        $this->setUserName($obj->getUserName());
        $this->setPassword($obj->getPassword());
        if ($this->getStoreAuth() && ($this->getPasswordValidate() != VBridgeAuth::PASSWORD_NO_VALIDATE)) {
          $this->writeStorage();
        }
      }
      $this->setResult($obj->getResult());
      return $authenticated;
    }

    return false;
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
         ->setPasswordType(VBridgeAuth::PASSWORD_TYPE_PLAIN)
         ->setPasswordValidate(VBridgeAuth::PASSWORD_NO_VALIDATE)
         ->setStoreAuth(false)
         ->setResult();
    return $this;
  }
}
