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
 * @version    $Id: VBridgeDb.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

class VBridgeDb {
  private $_connection;
  private $_db;

  public function getConnection() {
    return $this->_connection;
  }
  public function setConnection($val) {
    $this->_connection = $val;
  }

  public function connect($dbhost, $dbuser, $dbpasswd, $dbname, $dbport, $dbpconnect, $dbnewlink) {
    return $this->_connection;
  }

  public function getDb() {
    return $this->_db;
  }
  public function setDb($val) {
    $this->_db = $val;
  }

  public function __construct() { }

  public function __destruct() { }

  public function select($sql) { }

  public function prepareSelectUser($id) {
    $this->select($sql);
  }

  public function loadUser($id) {
    $sql = $this->prepareSelectUser($id);
    $this->select($sql);
  }
}
