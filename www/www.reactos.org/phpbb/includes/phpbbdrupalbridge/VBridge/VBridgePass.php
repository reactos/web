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
 * @version    $Id: VBridgePass.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgePass {
  const PASSWORD_TYPE_PLAIN = 0;
  const PASSWORD_TYPE_ENCRYPTED = 1;

  private $_password;
  private $_password_salt;
  private $_username;
  private $_passwordType;

  private $_config;

  function __construct($config = array()) {
    $this->setConfig($config);
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
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

  public function sePasswordSalt($val) {
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

  public function getUserName() {
    return $this->_username;
  }
  public function setUserName($val) {
    $this->_username = $val;
    return $this;
  }

  public function hash($password, $salt = null) {
    return $password;
  }

  public function generate($length = 10) {
    $password = '';
    $this->setPassword($password);
    return $password;
  }

  public function validate($password, $hash = null) {
    return false;
  }

  public function encrypt($password) {
    $password = md5($password);
    return $password;
  }

  public function decrypt($password) {
    return $password;
  }

  public function generateSalt($password, $encrypted = VBridgePass::PASSWORD_PLAIN) {
    return '';
  }
}
