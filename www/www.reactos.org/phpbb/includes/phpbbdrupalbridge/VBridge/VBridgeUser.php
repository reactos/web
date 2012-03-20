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
 * @version    $Id: VBridgeUser.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgeUser {
  public $data = array();
  public $group = array();

  protected $_locale = 'en_US';
  protected $_language = 'en';

  private $_session;
  private $_pass;

  private $_config;
  private $_status = 0;

  function __construct($config = array()) {
    $this->setConfig($config);

    $this->setLocale('en_US');
    $this->setLanguage('en');
  }

  public function getId() {
    return $this->data['id'];
  }

  public function setId($id) {
    $this->data['id'] = $id;
    $this->data['user_id'] = &$this->data['id'];
    return $this;
  }

  public function clear($data = array()) {
    $this->data = $data;
    $this->setId(0);
    return $this;
  }

  public function getData() {
    return $this->data;
  }

  public function setData($data = array()) {
    $this->data = $data;
    return $this;
  }

  public function getGroup() {
    return $this->group;
  }

  public function setGroup($group = array()) {
    $this->group = $group;
    return $this;
  }

  public function getStatus() {
    return $this->_status;
  }

  public function setStatus($val) {
    $this->_status = $val;
    return $this;
  }

  public function getSession() {
    return $this->_session;
  }

  public function setSession($val) {
    $this->_session = $val;
    return $this;
  }

  public function getPass() {
    return $this->_pass;
  }
  public function setPass($val) {
    $this->_pass = $val;
    return $this;
  }

  public function getPassword() {
    return $this->data['password'];
  }
  public function setPassword($val) {
    $this->data['password'] = $val;
    return $this;
  }

  public function getPasswordSalt() {
    return $this->data['password_salt'];
  }
  public function setPasswordSalt($val) {
    $this->data['password_salt'] = $val;
    return $this;
  }

  public function encryptPassword($password) {
    $password = $this->getPass()->encrypt($password, $this->getUserName());
    return $password;
  }

  public function validatePassword($password, $type = VBridgeAuth::PASSWORD_TYPE_PLAIN) {
    $valid = false;

    // SMF
    if ($type = VBridgeAuth::PASSWORD_TYPE_PLAIN) {
      $password = $this->encryptPassword($password);
    }

    if ($this->getPassword() == $password) {
      $valid = true;
    }

    /*
     //$this->getPass()->
     */

    return $valid;
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
    return $this;
  }

  /**
   * Magic toString method allows using this directly via echo
   */
  public function __toString() {
    return $this->getFullName();
  }

  public function __get($nm) {
    if (isset($this->data[$nm])) {
      return $this->data[$nm];
    }
  }
  public function __set($nm, $val) {
    if (isset($this->data[$nm])) {
      $this->data[$nm] = $val;
    }
    return $this;
  }

  public function __isset($nm) {
    return isset($this->data[$nm]);
  }

  public function __unset($nm) {
    unset($this->data[$nm]);
  }


  public function getLocale() {
    return $this->data['locale']; //$this->_locale;
  }
  public function setLocale($val) {
    //$this->_locale = $val;
    $this->data['locale'] = $val;
    return $this;
  }
  public function getLanguage() {
    return $this->data['language']; //$this->_language;
  }
  public function setLanguage($val) {
    //$this->_language = $val;
    $this->data['language'] = $val;
    return $this;
  }

  /**
   * Get the value for this element's username attribute.
   *
   * @see setUserName
   * @return string The requested attribute.
   */
  public function getUserName() {
    return $this->data['username'];
  }

  /**
   * Set the value for this element's username attribute. This
   * represents a user's name.
   *
   * @param string $value The desired value for this attribute.
   * @return $this
   */
  public function setUserName($val) {
    $this->data['username'] = $val;
    return $this;
  }

  /**
   * Get the value for this element's realname attribute.
   *
   * @see setRealName
   * @return string The requested attribute.
   */
  public function getRealName() {
    return $this->data['name'];
  }

  /**
   * Set the value for this element's realname attribute. This
   * represents a user's displayed name.
   *
   * @param string $value The desired value for this attribute.
   * @return $this
   */
  public function setRealName($val) {
    $this->data['name'] = $val;
    return $this;
  }

  /**
   * Get the value for this element's lastname attribute.
   *
   * @see setLastName
   * @return string The requested attribute.
   */
  public function getLastName() {
    return $this->data['lastname'];
  }

  /**
   * Set the value for this element's lastname attribute. This
   * represents a user's family name.
   *
   * @param string $value The desired value for this attribute.
   * @return $this
   */
  public function setLastName($val) {
    $this->data['lastname'] = $val;
    return $this;
  }

  /**
   * Get the value for this element's firstname attribute.
   *
   * @see FirstName
   * @return string The requested attribute.
   */
  public function getFirstName() {
    return $this->data['firstname'];
  }

  /**
   * Set the value for this element's firstname attribute. This
   * represents a user's given name.
   *
   * @param string $value The desired value for this attribute.
   * @return $this
   */
  public function setFirstName($val) {
    $this->data['firstname'] = $val;
    return $this;
  }

  public function getFullName() {
    $fullname = $this->getFirstName();
    $lastname = $this->getLastName();
    if (!empty($lastname)) {
      $fullname .= ' ' . $lastname;
    }
    return $fullname;
  }

  public function isOnline() {
    return $this->getOnline();
  }
  public function getOnline() {
    return $this->data['is_online'];
  }
  public function setOnline($val) {
    $this->data['is_online'] = $val;
    return $this;
  }

  public function isActive() {
    return $this->getActive();
  }
  public function getActive() {
    return $this->data['is_active'];
  }
  public function setActive($val) {
    $this->data['is_active'] = $val;
    return $this;
  }

  public function isBanned() {
    return $this->getBanned();
  }
  public function getBanned() {
    return $this->data['is_banned'];
  }
  public function setBanned($val) {
    $this->data['is_banned'] = $val;
    return $this;
  }

  public function isRegistered() {
    return $this->getRegistered();
  }
  public function getRegistered() {
    return $this->data['is_registered'];
  }
  public function setRegistered($val) {
    $this->data['is_registered'] = $val;
    return $this;
  }

  public function isGuest() {
    return $this->getGuest() || !$this->isOnline();
  }
  public function getGuest() {
    return $this->data['is_guest'];
  }
  public function setGuest($val) {
    $this->data['is_guest'] = $val;
    return $this;
  }

  public function isAdmin() {
    return $this->getAdmin();
  }
  public function getAdmin() {
    return $this->data['is_admin'];
  }
  public function setAdmin($val) {
    $this->data['is_admin'] = $val;
    return $this;
  }
  public function isBot() {
    return $this->getBot();
  }
  public function getBot() {
    return $this->data['is_bot'];
  }
  public function setBot($val) {
    $this->data['is_bot'] = $val;
    return $this;
  }

}
