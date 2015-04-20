<?php
/**
 * VBridge
 * Class library for developing integration software.
 * Copyright (C) 2009 Vadim G.B. (http://vgb.org.ru)
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
 * @copyright  Copyright (C) 2009 Vadim G.B. (http://vgb.org.ru)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html  GNU Lesser General Public License, version 2.1
 * @version    $Id: PhpbbVBridgeException.php,v 1.1 2009/03/15 13:49:36 vb Exp $
 */

require_once(dirname(__FILE__) . '/VBridge/VBridgeException.php');

class PhpbbVBridgeException extends VBridgeException {
  public function __construct($message, $code = 0) {
    parent::__construct($message, $code);
  }
  /*
   public function customFunction() {
   return "Custom function";
   }
   */
}
