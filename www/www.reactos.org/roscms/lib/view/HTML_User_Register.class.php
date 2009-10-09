<?php
    /*
    ReactOS DynamicFrontend (RDF)
    Copyright (C) 2008  Klemens Friedl <frik85@reactos.org>
                  2009  Colin Finck <colin@reactos.org>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
    */


/**
 * class HTML_User_Register
 * 
 * @package html
 * @subpackage user
 */
class HTML_User_Register extends HTML_User
{

  /**
   *
   *
   * @access public
   */
  public function __construct( )
  {
    session_start();
    parent::__construct('');
  }


  /**
   *
   *
   * @access protected
   */
  protected function body( )
  {
    $config = &RosCMS::getInstance();
    
    // Think positively and don't blame the user for not supplying valid registration information if he hasn't supplied them yet :-)
    $name_ok = true;
    $password_ok = true;
    $mail_ok = true;
    $captcha_ok = true;

    echo_strip('
      <h1>Register to ' . $config->siteName() . '</h1>
      <p>Become a member of the ' . $config->siteName() . ' Community, and have a single sign-on for all ' . $config->siteName() . ' web services.</p>
      <ul>
        <li>Already a member? <a href="' . $config->pathInstance() . '?page=login">Login now</a>! </li>
        <li><a href="' . $config->pathInstance() . '?page=login&amp;subpage=lost">Lost username or password?</a></li>
      </ul>

      <form action="' . $config->pathInstance() . '?page=register" method="post">
        <div class="bubble">
          <div class="corner_TL">
            <div class="corner_TR"></div>
          </div>');

    if (self::canRegister($name_ok, $password_ok, $mail_ok, $captcha_ok))
    {
      // user language (browser settings)
      $userlang = Language::validate($_SERVER['HTTP_ACCEPT_LANGUAGE']);

      // account activation code
      $code_characters = 'ABCEFHJKLMNPSTUVWXYZabcdefghijkmnopqrsuvwxyz123456789';
      $code_characters_ubound = strlen($code_characters) - 1;
      $code_length = rand(10, 15);
      $code = '';
      
      while(--$code_length >= 0)
        $code .= $code_characters{ rand(0, $code_characters_ubound) };

      // add new account
      $stmt=&DBConnection::getInstance()->prepare("INSERT INTO ".ROSCMST_USERS." ( name, password, created, activation, email, lang_id, modified ) VALUES ( :user_name, MD5( :password ), NOW(), :activation_code, :email, :lang, NOW() )");
      $stmt->bindValue('user_name',trim($_POST['username']),PDO::PARAM_STR);
      $stmt->bindParam('password',$_POST['userpwd1'],PDO::PARAM_STR);
      $stmt->bindParam('activation_code',$code,PDO::PARAM_STR);
      $stmt->bindParam('email',$_POST['useremail'],PDO::PARAM_STR);
      $stmt->bindParam('lang',$userlang,PDO::PARAM_INT);
      $stmt->execute();

      $stmt=&DBConnection::getInstance()->prepare("SELECT id FROM ".ROSCMST_USERS." WHERE LOWER(name) = LOWER(:user_name)");
      $stmt->bindParam('user_name',$_POST['username'],PDO::PARAM_INT);
      $stmt->execute();
      $user_id = $stmt->fetchColumn();

      // give a 'user' group membership
      $stmt=&DBConnection::getInstance()->prepare("INSERT INTO ".ROSCMST_MEMBERSHIPS." (user_id, group_id) SELECT :user_id, id FROM ".ROSCMST_GROUPS." WHERE name_short = 'user' LIMIT 1");
      $stmt->bindParam('user_id',$user_id,PDO::PARAM_INT);
      $stmt->execute();

      // add subsystem accounts
      ROSUser::syncSubsystems($user_id);

      // subject
      $subject = $config->siteName()." - Account Activation";

      // message
      $message = $config->siteName()." - Account Activation\n\n\nYou have registered an account on ".$config->siteName().". The next step in order to enable the account is to activate it by using the hyperlink below.\n\nYou haven't registered an account? Oops, then someone has tried to register an account with your email address. Just ignore this email, no one can use it anyway as it is not activated and the account will get deleted soon.\n\n\nUsername: ".$_POST['username']."\nPassword: ".$_POST['userpwd1']."\n\nActivation-Hyperlink: ".$config->siteURL()."/".$config->pathInstance()."?page=login&subpage=activate&code=".$code."\n\n\nBest regards,\nThe ".$config->siteName()." Team\n\n\n(please do not reply as this is an auto generated email!)";

      // send the mail
      if (Email::send($_POST['useremail'], $subject, $message))
      {
        echo_strip('
          <h2>Account registered</h2>
          <div>Check your email inbox (and spam folder) for the <strong>account activation email</strong> that contains the activation hyperlink.</div>');
      }
      else
      {
        echo 'Error while trying to send E-Mail';
      }

      unset($_SESSION['rdf_security_code']);
    } // end registration process
    else
    {
      echo_strip('
        <h2>Register Account</h2>
        <div class="field">
          <label for="username"' . ($name_ok ? '' : ' style="color: red;"') . '>Username</label>
          <input type="text" name="username" tabindex="1" id="username"' . (isset($_POST['username']) ? 'value="' . $_POST['username'] . '"' : '') . ' maxlength="' . $config->limitUsernameMax() . '" />
          <div class="detail">uppercase letters, lowercase letters, numbers, and symbols (ASCII characters)</div>');

      if (!$name_ok)
      {
        echo_strip('
          <br />
          <em>Please use a different username with ' . $config->limitUserNameMin() . ' to ' . $config->limitUserNameMax() . ' characters. Avoid leading and trailing spaces.</em>');
      }

      echo_strip('
        </div>
        <div class="field">
          <label for="userpwd1"' . ($password_ok ? '' : ' style="color: red;"') . '>Password</label>
          <input name="userpwd1" type="password" tabindex="2" id="userpwd1" maxlength="' . $config->limitPasswordMax() . '" />');

      if (!$password_ok)
      {
        echo_strip('
          <br />
          <em>Please use a password with ' . $config->limitPasswordMin() . ' to ' . $config->limitPasswordMax() . ' characters. Make sure that both entered passwords match.</em>');
      }

      echo_strip('
        </div>
        <div class="field">
          <label for="userpwd2"' . ($password_ok ? '' : ' style="color: red;"') . '>Re-type Password</label>
          <input name="userpwd2" type="password" tabindex="3" id="userpwd2" maxlength="' . $config->limitPasswordMax() . '" />
        </div>
        <div class="field">
          <label for="useremail"' . ($mail_ok ? '' : ' style="color: red;"') . '>E-Mail</label>
          <input name="useremail" type="text" class="input" tabindex="4" id="useremail"' . (isset($_POST['useremail']) ? 'value="' . $_POST['useremail'] . '"' : '') . ' />');

      if (!$mail_ok)
      {
        echo_strip('
          <br />
          <em>Please enter a valid E-Mail address, which is not yet registered with another account.</em>');
      }

      echo_strip('
        </div>
        <div class="field">
          <label for="usercaptcha"' . ($captcha_ok ? '' : ' style="color: red;"') . '>Type the code shown</label>
          <input name="usercaptcha" type="text" tabindex="7" id="usercaptcha" maxlength="6" />
          <script type="text/javascript">');echo "
          <!--
            
            var BypassCacheNumber = 0;

            function CaptchaReload()
            {
              ++BypassCacheNumber;
              document.getElementById('captcha').src = '".$config->pathInstance()."?page=captcha&nr=' + BypassCacheNumber;
            }

            document.write('<br /><span style=\"color:#817A71; \">If you cannot read this, try <a href=\"javascript:CaptchaReload()\">another one</a>.</span>');
          
          -->";echo_strip('
          </script>
          <img id="captcha" src="' . $config->pathInstance() . '?page=captcha" style="padding-top:10px;" alt="If you cannot read this, try another one or email ' . $config->emailSupport() . ' for help." title="Are you human?" />
          <br />');
      
      if (!$captcha_ok)
      {
        echo_strip('
          <br />
          <em>Please enter the shown code.<br />If you cannot read it, try another one.</em>');
      }

      echo_strip('
        </div>
        <div class="field">
          <input name="registerpost" type="hidden" id="registerpost" value="reg" />
          <button type="submit" name="submit">Register</button>
          <button type="button" onclick="window.location=\'' . $config->pathInstance() . '\';" style="color:#777777;">Cancel</button>
        </div>');
    } // end registration form

    echo '
        <div class="corner_BL">
          <div class="corner_BR"></div>
        </div>
      </div>
      </form>';
  } // end of member function body

  /**
   * Checks whether an account could be registered with the supplied data from $_POST
   *
   * @param name_ok
   * Reference to a variable, which will contain a boolean value whether the username is alright
   *
   * @param password_ok
   * Reference to a variable, which will contain a boolean value whether the password is alright
   *
   * @param mail_ok
   * Reference to a variable, which will contain a boolean value whether the E-Mail address is alright
   *
   * @param captcha_ok
   * Reference to a variable, which will contain a boolean value whether the Captcha code is alright
   *
   * @return
   * TRUE if the supplied data is alright and we could register a username with it, FALSE otherwise.
   *
   * @visible private
  **/
  private function canRegister(&$name_ok, &$password_ok, &$mail_ok, &$captcha_ok)
  {
    $config = &RosCMS::getInstance();
    
    // Did the user submit any registration request at all?
    // If he hasn't sent anything yet, don't blame him for that, so set all variable references to TRUE first.
    $name_ok = true;
    $password_ok = true;
    $mail_ok = true;
    $captcha_ok = true;
    
    if(!isset($_POST['registerpost']))
      return false;
    
    
    // USERNAME CHECKS
    // Ensure that the username only contains valid characters and no leading or trailing spaces
    $name_ok  = (isset($_POST['username']));
    $name_ok &= ($_POST['username'] == trim($_POST['username']));
    $name_ok &= (preg_match('/^[a-z0-9_\-[:space:]\.]{' . $config->limitUserNameMin() . ',' . $config->limitUsernameMax() . '}$/i', $_POST['username']));
    
    // Check if another account with the same username already exists
    $stmt = &DBConnection::getInstance()->prepare("SELECT 1 FROM ".ROSCMST_USERS." WHERE LOWER(REPLACE(name, '_', ' ')) = LOWER(REPLACE(:username, '_', ' ')) LIMIT 1");
    $stmt->bindParam('username', $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $name_ok &= ($stmt->fetchColumn() === false);
    
    // Check if the username is equal to a protected name
    $stmt = &DBConnection::getInstance()->prepare("SELECT 1 FROM ".ROSCMST_FORBIDDEN." WHERE name LIKE :forbidden LIMIT 1");
    $stmt->bindParam('forbidden', $_POST['username'], PDO::PARAM_STR);
    $stmt->execute();
    $name_ok &= ($stmt->fetchColumn() === false);
    
    // PASSWORD CHECKS
    // Ensure that both passwords are equal and valid
    $password_ok  = (isset($_POST['userpwd1']) && isset($_POST['userpwd2']));
    $password_ok &= ($_POST['userpwd1'] == $_POST['userpwd2']);
    $password_ok &= (strlen($_POST['userpwd1']) >= $config->limitPasswordMin() && strlen($_POST['userpwd1']) <= $config->limitPasswordMax());
    
    // E-MAIL ADDRESS CHECKS
    // Ensure that the E-Mail address only contains valid characters
    $mail_ok  = (isset($_POST['useremail']));
    $mail_ok &= (EMail::isValid($_POST['useremail']));
    
    // Check if another account with the same email address already exists
    $stmt = &DBConnection::getInstance()->prepare("SELECT 1 FROM ".ROSCMST_USERS." WHERE email = :email LIMIT 1");
    $stmt->bindParam('email', $_POST['useremail'], PDO::PARAM_STR);
    $stmt->execute();
    $mail_ok &= ($stmt->fetchColumn() === false);
    
    // CAPTCHA CHECKS
    // Ensure that the captcha is correct
    $captcha_ok  = (isset($_POST['usercaptcha']) && isset($_SESSION['rdf_security_code']));
    $captcha_ok &= (strtolower($_POST['usercaptcha']) == strtolower($_SESSION['rdf_security_code']));
    
    
    // Now we have all information together and can easily check whether an account could be registered.
    // Also the caller can get detailed information about _every_ incorrect field.
    return ($name_ok && $password_ok && $mail_ok && $captcha_ok);
  }


} // end of HTML_User_Register
?>
