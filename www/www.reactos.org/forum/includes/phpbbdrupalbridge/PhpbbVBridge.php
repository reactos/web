<?php
// $Id: PhpbbVBridge.php,v 1.3 2009/03/20 19:08:52 vb Exp $
/**
 * class PhpbbVBridge
 * @package PhpbbVBridge
 */

interface VBridgeForumInterface {
  public function load();
  public function save();
  public function delete();
}

require_once(dirname(__FILE__) . '/VBridge/VBridge.php');
require_once(dirname(__FILE__) . '/PhpbbVBridgeException.php');

class PhpbbVBridge extends VBridge {
  const VERSION = '1.x-dev';

  static private $_bridge;


  public function getVersion() {
    return self::VERSION;
  }

  public function __construct($bridgeData, $appData = array()) {
    if (!self::$_bridge) {
      self::$_bridge = $this;
    }

    parent::__construct($bridgeData, $appData);

    return self::$_bridge;
  }

  static function getInstance($bridgeData, $appData = array()) {
    if (!self::$_bridge) {
      $c = __CLASS__;
      self::$_bridge = new $c($bridgeData, $appData);
    }

    return self::$_bridge;
  }

  private function __clone() { }

  public function __destruct() {
    parent::__destruct();
  }

  protected function createApp($id, $appData) {
    parent::createApp($id, $appData);

  }

  protected function create($appData) {
    //if (VBRIDGE_DEBUG)
    //drupal_set_message(__CLASS__ .'::'.'create');
    parent::create($appData);

    if ($this->getStatus()) {
      return false;
    }

    return true;
  }

  public function getStatus() {
    return parent::getStatus();
  }

  public function setStatus($val) {
    parent::setStatus($val);
  }

  public function init($options = array()) {
    parent::init($options);

    //$this->setStatus($this->getStatus());

    if ($this->getStatus()) {
      return false;
    }

    //$this->smf_connection = parent::getApp()->getConnection();

    return true;
  }

  public function run() { }

  //////////////////////

  public function login($username, $password, $options = array()) {
    if (empty($username) || empty($password)) {
      return false;
    }
    //$username = $this->toInternalEncoding($username);
    //$password = $this->toInternalEncoding($password);
    return $this->getApp()->login($username, $password, $options);
  }

  public function logout() {
    return $this->getApp()->logout();
  }

  public function authenticateUserExternal() {
    $authenticated = false;
    return $authenticated;
  }

  public function authenticateUser() {
    /*
     $auth = $this->getApp()->getAuth();
     $auth->clear()
     ->setPasswordType(VBridgeAuth::PASSWORD_TYPE_ENCRYPTED)
     ->setPasswordValidate(VBridgeAuth::PASSWORD_NO_VALIDATE)
     ->setStoreAuth(false);
     $authenticated = $auth->authenticate('qookie');
     if ($authenticated)
     {
     $authenticated = $this->loadUserById($auth->getUserId());
     if ($authenticated) {
     $user = $this->getUser();
     $auth->setPasswordSalt($user->getPasswordSalt());
     $authenticated = $auth->validate($user->getPassword());
     }
     }

     return $authenticated;
     */
    return $this->getApp()->authenticateUser();
  }

  public function authenticate() {
    $id = 0;
    $password = '';

    $authenticated = $this->getQookie()->getUserQookie($id, $password);
    if ($authenticated) {
      $this->getApp()->loadUser($id, $password);
    }

    return $authenticated;
  }


  public function getAppUser($id, $password = '') {
    if (empty($id)) {
      return false;
    }
    //if (!is_integer($id))
    //$id = $this->toInternalEncoding($id);
    //$password = $this->toInternalEncoding($password);
    return $this->getApp()->getAppUser($id, $password);
  }

  public function getUserNameById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->getUserNameById($id, $password);
  }

  public function getUserRealNameById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->getUserRealNameById($id, $password);
  }

  public function getUserIdByUserName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->getUserIdByUserName($username, $password);
  }

  public function getUserIdByRealName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->getUserIdByRealName($username, $password);
  }

  public function getUserIdByEmail($email, $password = '') {
    if (empty($email) || strpos($email, "@") === false) {
      return false;
    }
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->getUserIdByEmail($email, $password);
  }

  public function loadUser($id, $password = '') {
    if (empty($id)) {
      return false;
    }
    if (!is_integer($id)) {
      $id = $this->toInternalEncoding($id);
    }
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->loadUser($id, $password);
  }

  public function loadUserById($id, $password = '') {
    if (empty($id) || !is_numeric($id)) {
      return false;
    }
    $id = (int) $id;
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->loadUserById($id, $password);
  }

  public function loadUserByUserName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->loadUserByUserName($username, $password);
  }

  public function loadUserByRealName($username, $password = '') {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->loadUserByRealName($username, $password);
  }

  public function loadUserByEmail($email, $password = '') {
    if (empty($email) || strpos($email, "@") === false) {
      return false;
    }
    $password = $this->toInternalEncoding($password);
    return $this->getApp()->loadUserByEmail($email, $password);
  }

  public function registerUser($username, $password, $email, $data = array()) {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);

    return $this->getApp()->registerUser($username, $password, $email, $data);
  }

  public function updateUser($id, $username = '', $password = '', $email = '', $data = array()) {
    if (!$id) {
      return false;
    }

    $username = $this->toInternalEncoding($username);
    $password = $this->toInternalEncoding($password);

    return $this->getApp()->updateUser($id, $username, $password, $email, $data);
  }

  public function deleteUser($id, $mode = 'retain', $post_username = false) {
    if (!$id) {
      return false;
    }

    return $this->getApp()->deleteUser($id, $mode, $post_username);
  }

  public function validateUserName($username) {
    if (empty($username)) {
      return false;
    }
    $username = $this->toInternalEncoding($username);
    return $this->getApp()->validateUserName($username);
  }

  public function validateUserPassword($password, $username = '') {
    if (empty($password)) {
      return false;
    }
    $password = $this->toInternalEncoding($password);
    //$username = $this->toInternalEncoding($username);
    return $this->getApp()->validateUserPassword($password, $username);
  }

  public function validateUserEmail($email, $username = '') {
    if (empty($email)) {
      return false;
    }
    //$username = $this->toInternalEncoding($username);
    return $this->getApp()->validateUserEmail($email, $username);
  }


  public function getRecentPosts($options = array('output_method' => '')) {
    $str = $this->getApp()->getRecentPosts($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function getRecentTopics($options = array('output_method' => '')) {
    $str = $this->getApp()->getRecentTopics($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function getTopPosters($options = array('output_method' => '')) {
    $str = $this->getApp()->getTopPosters($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function getPersonalMessages($options = array('output_method' => '')) {
    $str = $this->getApp()->getPersonalMessages($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function getWhosOnline($options = array('output_method' => '')) {
    $str = $this->getApp()->getWhosOnline($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function getStatistics($options = array('output_method' => '')) {
    $str = $this->getApp()->getStatistics($options);
    $str = $this->toExternalEncoding($str);
    return $str;
  }

  public function isUserOnline($id = 0) {
    return $this->getApp()->isUserOnline($id);
  }

  public function isUserActive($id = 0) {
    return $this->getApp()->isUserActive($id);
  }

  public function isUserBanned($id = 0) {
    return $this->getApp()->isUserBanned($id);
  }

  public function isUserBannedEmail($id = 0) {
    return $this->getApp()->isUserBannedEmail($id);
  }

  public function isUserRegistered($id = 0) {
    return $this->getApp()->isUserRegistered($id);
  }

  public function isUserGuest($id = 0) {
    return $this->getApp()->isUserGuest($id);
  }

  public function isUserBot($id = 0) {
    return $this->getApp()->isUserBot($id);
  }

  //////////////////////
  /*
   public function toInternalEncoding($str)
   {
   return $str;
   }

   public function toExternalEncoding($str)
   {
   return $str;
   }
   */

}
