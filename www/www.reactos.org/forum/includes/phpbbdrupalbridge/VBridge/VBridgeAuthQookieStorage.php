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
 * @version    $Id: VBridgeAuthQookieStorage.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridgeAuthStorageInterface.php');

class VBridgeAuthQookieStorage implements VBridgeAuthStorageInterface {
  private $_config;
  private $_session;
  private $_qookie;
  private $_pass;

  private $_id;
  private $_idType;
  private $_username;
  private $_password;
  private $_password_salt;
  private $_passwordType;
  private $_lifetime;

  private $_data;

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

  public function getLifetime() {
    return $this->_lifetime;
  }
  public function setLifetime($val) {
    $this->_lifetime = $val;
    return $this;
  }

  public function encrypt($password = '') {
    if (empty($password)) {
      $password = $this->getPassword();
    }
    // SMF
    $password = sha1($password . $this->getPasswordSalt());
    return $password;
  }

  public function getData() {
    return $this->_data;
  }

  public function setData($data = null) {
    $this->_data = $data;
    return $this;
  }

  public function prepare($options = array()) {
    //if (isset($options('qookie_lifetime')) {
//  $lifeTime = $options('qookie_lifetime');
    //} else
    if ($this->getLifetime()) {
      $lifeTime = $this->getLifetime();
    }
    else {
      $lifeTime = $this->getQookie()->getLifetime();
    }
    $id = $this->getUserId();
    $this->_data = serialize(empty($id) ? array(0, '', 0) : array($id, $this->encrypt(), time() + $lifeTime));
  }


  /**
   * Returns true if and only if storage is empty
   * @return boolean
   */
  public function isEmpty() {
    return empty($this->_data);
  }

  /**
   * Returns the data of storage
   * @return mixed
   */
  public function read() {
    $qookieName = $this->getQookie()->getName();
    if (isset($_COOKIE[$qookieName])) {
      $_COOKIE[$qookieName] = stripslashes($_COOKIE[$qookieName]);
      $this->_data = @unserialize($_COOKIE[$qookieName]);
    }
    else {
      $this->_data = null;
    }
    return $this->_data;
  }

  /**
   * Writes data to storage
   *
   * @param  mixed $data
   * @return void
   */
  public function write($options = array()) {
    $this->prepare($options);
    $this->getQookie()->set($this->_data);
  }

  /**
   * Clears data from storage
   *
   * @return this
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
         ->setData(null);
    $this->getQookie()->clear();
    return $this;
  }

}
