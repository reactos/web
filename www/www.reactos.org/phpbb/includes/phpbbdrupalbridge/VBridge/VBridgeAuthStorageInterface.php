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
 * @version    $Id: VBridgeAuthStorageInterface.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

interface VBridgeAuthStorageInterface {
  public function getPass();
  public function setPass($val);
  public function getUserId();
  public function setUserId($val);
  public function getUserIdType();
  public function setUserIdType($val = 0);
  public function getUserName();
  public function setUserName($val);
  public function getPassword();
  public function setPassword($val);
  public function getPasswordSalt();
  public function setPasswordSalt($val);
  public function getPasswordType();
  public function setPasswordType($val);
  public function getData();
  public function setData($data = null);
  public function encrypt($password = '');

  /**
   * Returns true if and only if storage is empty
   *
   * @return boolean
   */
  public function isEmpty();

  /**
   * Returns the data of storage
   *
   * @return mixed
   */
  public function read();

  /**
   * Prepares data to storage
   *
   * @param  mixed $data
   * @return void
   */
  public function prepare($options = array());

  /**
   * Writes data to storage
   *
   * @param  mixed $data
   * @return void
   */
  public function write($options = array());

  /**
   * Clears data from storage
   *
   * @return void
   */
  public function clear();
}
