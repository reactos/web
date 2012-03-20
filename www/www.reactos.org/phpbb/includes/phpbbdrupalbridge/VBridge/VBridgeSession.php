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
 * @version    $Id: VBridgeSession.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgeSession {

  private $_config;
  private $_qookie;
  private $_objname = 'session';
  private $_name = 'SESS';

  function __construct($config = array()) {
    $this->setConfig($config);
  }

  public function getConfig() {
    return $this->_config;
  }
  public function setConfig($val) {
    $this->_config = $val;
    return $this;
  }

  public function getName() {
    return $this->_name;
  }
  public function setName($val) {
    $this->_name = $val;
  }

  public function getObjName() {
    return $this->_objname;
  }
  public function setObjName($val) {
    $this->_objname = $val;
  }

  public function getQookie() {
    return $this->_qookie;
  }
  public function setQookie($val) {
    $this->_qookie = $val;
  }

  public function getId() {
    return session_id();
  }

  public function setId($id) {
    session_id($id);
    return $this;
  }
}
