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
 * @version    $Id: DrupalVBridgePass.php,v 1.1 2009/02/27 21:10:29 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridge/VBridgePass.php');

class DrupalVBridgePass extends VBridgePass {
  private $_password;

  public function __construct($config = array()) {
    parent::__construct($config);
  }

  public function generate($length = 10) {
    // user_password
    $password = '';
    // This variable contains the list of allowable characters for the
    // password. Note that the number 0 and the letter 'O' have been
    // removed to avoid confusion between the two. The same is true
    // of 'I', 1, and 'l'.
    $allowable_characters = 'abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    // Zero-based count of characters in the allowable list:
    $len = strlen($allowable_characters) - 1;
    // Loop the number of times specified by $length.
    for ($i = 0; $i < $length; $i++) {
      // Each iteration, pick a random character from the
      // allowable string and append it to the password:
      $password .= $allowable_characters[mt_rand(0, $len)];
    }

    $this->setPassword($password);
    return $password;
    //return parent::generate($length);
  }

}
