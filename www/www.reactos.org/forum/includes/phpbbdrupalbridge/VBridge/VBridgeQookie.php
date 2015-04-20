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
 * @version    $Id: VBridgeQookie.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgeQookie {
  private $_config;
  private $_name = 'VBridge';

  function __construct($config = array()) {
    $this->setConfig($config);
  }

  public function init() {
    if (!isset($this->_config['cookie_lifetime'])) {
      $this->_config['cookie_lifetime'] = 1440 * 60;
    }
    if (!isset($this->_config['cookie_name'])) {
      $this->_config['cookie_name'] = $this->_name;
    }
    return true;
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
    return $this;
  }

  public function getName() {
    return $this->_config['cookie_name'];
  }
  public function setName($val) {
    $this->_config['cookie_name'] = $val;
    return $this;
  }

  public function getDomain() {
    return $this->_config['cookie_domain'];
  }
  public function setDomain($val) {
    $this->_config['cookie_domain'] = $val;
    return $this;
  }

  public function getPath() {
    return $this->_config['cookie_path'];
  }
  public function setPath($val) {
    $this->_config['cookie_path'] = $val;
    return $this;
  }

  public function getLifetime() {
    return $this->_config['cookie_lifetime'];
  }
  public function setLifetime($val) {
    $this->_config['cookie_lifetime'] = $val;
    return $this;
  }

  public function set($data, $lifeTime = 0, $cookieName = '') {
    if (empty($cookieName)) {
      $qookieName = $this->getName();
    }
    if (empty($lifeTime)) {
      $lifeTime = $this->getLifetime();
    }

    $this->delete($cookieName);

    // Set the cookie, $_COOKIE
    setcookie($cookieName, $data, time() + $lifeTime, $this->getPath(), $this->getDomain());
    $_COOKIE[$qookieName] = $data;

    return $this;
  }

  public function get($cookieName = '') {
    if (empty($cookieName)) {
      $qookieName = $this->getName();
    }
    if (isset($_COOKIE[$cookieName])) {
      return $_COOKIE[$cookieName];
    }
    else {
      return false;
    }
  }

  public function delete($cookieName = '') {
    if (empty($cookieName)) {
      $qookieName = $this->getName();
    }
    setcookie($cookieName, '', (time() - 3600) );

    return $this;
  }

  public function clear($cookieName = '') {
    return $this->delete($cookieName);
  }
}
