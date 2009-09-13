<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2009 Danny Götte <dangerground@web.de>

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


class HTML_Administration extends HTML
{


  public function __construct( )
  {
    global $RSDB_intern_user_id;

    // check if user is logged in
    $RSDB_intern_user_id = Subsystem::in(Login::REQUIRED, $_SERVER["REQUEST_URI"]);

    parent::__construct();
  }



  protected function body()
  {
    if (!Setting::hasRight('admin_interface')) {
      return false;
    }

    $target = (isset($_GET['for']) ? $_GET['for'] : '');
  
    if ($target == 'version') {
      $this->bodyVersions();
    }
    elseif ($target == 'category') {
      $this->bodyCategories();
    }
    elseif ($target == 'user') {
      $this->bodyUsers();
    }
    else {
      echo '
        <h1>Compatability Database &gt; Administration</h1>
        <ul>';
      
      if (Setting::hasRight('versions')) {
        echo '<li><a href="?show=administration&amp;for=version">Versions</a></li>';
      }
      if (Setting::hasRight('categories')) {
        echo '<li><a href="?show=administration&amp;for=category">Categories</a></li>';
      }

      if (Setting::hasRight('grant')) {
        echo '<li><a href="?show=administration&amp;for=user">User</a></li>';
      }
      echo '
        </ul>';
    }
  
  } // end of member function body
  
  
  private function bodyVersions()
  {
  
    if (!Setting::hasRight('versions')) {
      return false;
    }
  
    if (!empty($_POST['name']) && !empty($_POST['revision'])) {
      $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_VERTAGS." (revision, name, visible) VALUES (:revision, :name, :visible)");
      $stmt->bindParam('revision',$_POST['revision'],PDO::PARAM_INT);
      $stmt->bindParam('name',$_POST['name'],PDO::PARAM_STR);
      $stmt->bindParam('visible',$_POST['visible'],PDO::PARAM_BOOL);
      if ($stmt->execute()) {
        echo "New <strong>ReactOS Version</strong> was created successful.<br />";
      }
    }
    
    $stmt=CDBConnection::getInstance()->prepare("SELECT name FROM ".CDBT_VERTAGS." ORDER BY revision DESC");
    $stmt->execute();
    $latest_version = $stmt->fetchColumn();

    $last_num = preg_replace('/^.+\.([1-9][0-9]*)$/','$1',$latest_version);
    $not_last_num = preg_replace('/^(.+)\.[1-9][0-9]*$/','$1.',$latest_version);
    $next = $not_last_num.($last_num+1);
  
    echo '
      <form action="?show=administration&amp;for=version" method="post">
        <fieldset>
          <legend>New</legend>
          <ul>
            <li>
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" value="'.$next.'" />
            </li>
            <li>
              <label for="name">Revision:</label>
              <input type="text" name="revision" id="revision" value="" />
            </li>
            <li>
              <label for="visible">visible for public</label>
              <input type="checkbox" name="visible" id="visible" checked="checked" value="1" />
            </li>
            <li><button type="submit">create</button></li>
        </fieldset>
      </form>
      
      <form action="" method="post">
        <fieldset>
          <legend>Edit -doesn\'t work yet-</legend>
          <select name="version" id="version">
            <option value=""></option>';
    $stmt=CDBConnection::getInstance()->prepare("SELECT revision, name, visible FROM ".CDBT_VERTAGS." ORDER BY revision DESC");
    $stmt->execute();
    while ($version = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo '
        <option value="'.$version['revision'].'"'.($version['visible'] == false ? ' style="color: gray;"' : '').'>'.$version['name'].'</option>';
    }
    echo '
          </select>
          <button type="submit">edit</button>
        </fieldset>
      </form>';
  }  
  
  private function bodyCategories()
  {
    if (!Setting::hasRight('categories')) {
      return false;
    }

    // edit
    if (!empty($_POST['id'])) {
    
      // don't build circles
      $child_list = Category::getAllChildsAsList($_POST['id']);
      if (!preg_match('/(^|,)'.$_POST['parent'].'(,|$)/',$child_list)) {
        
        $stmt=CDBConnection::getInstance()->prepare("UPDATE ".CDBT_CATEGORIES." SET type=:type, name=:name, parent=:parent, description=:description WHERE id=:category_id");
        $stmt->bindParam('type',$_POST['type'],PDO::PARAM_STR);
        $stmt->bindParam('name',$_POST['name'],PDO::PARAM_STR);
        if ($_POST['parent'] == 0) {
          $stmt->bindValue('parent',null,PDO::PARAM_NULL);
        }
        else {
          $stmt->bindParam('parent',$_POST['parent'],PDO::PARAM_INT);
        }
        $stmt->bindParam('description',$_POST['description'],PDO::PARAM_STR);
        $stmt->bindParam('category_id',$_POST['id'],PDO::PARAM_INT);
        if ($stmt->execute()) {
          if (!empty($child_list)) {
            $stmt=CDBConnection::getInstance()->prepare("UPDATE ".CDBT_CATEGORIES." SET type=:type WHERE id IN (".$child_list.")");
            $stmt->bindParam('type',$_POST['type'],PDO::PARAM_STR);
            $stmt->execute();
          }
          echo 'Updated <strong>Category</strong> successful<br />';
        }
      }
      else {
        echo 'Update <em>stopped</em>, because you tried to set one of the categories childs as new parent.<br />';
      }
    }

    // new
    elseif (!empty($_POST['name']) && !empty($_POST['type']) && isset($_POST['parent']) && isset($_POST['description'])) {
    
      if ($_POST['parent'] > 0) {
        $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_CATEGORIES." (type, name, parent, description, visible) VALUES (:type, :name, :parent, :description, TRUE)");
        $stmt->bindParam('type',$_POST['type'],PDO::PARAM_STR);
        $stmt->bindParam('parent',$_POST['parent'],PDO::PARAM_STR);
      }
      else {
      
        // get type of parent, just to be sure
        $stmt=CDBConnection::getInstance()->prepare("SELECT type FROM ".CDBT_CATEGORIES." WHERE id=:category_id");
        $stmt->bindParam('category_id',$_POST['parent'],PDO::PARAM_INT);
        $stmt->execute();
        $type = $stmt->fetchColumn();

        // new category
        $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_CATEGORIES." (type, name, parent, description, visible) VALUES (:type, :name, NULL, :description, TRUE)");
        $stmt->bindParam('type',$_POST['type'],PDO::PARAM_STR);
      }
      $stmt->bindParam('name',$_POST['name'],PDO::PARAM_STR);
      $stmt->bindParam('description',$_POST['description'],PDO::PARAM_STR);
      if ($stmt->execute()) {
        echo "New <strong>Category</strong> was created successful.<br />";
      }
    }

    $category_buffer = Category::showTreeAsOption();
    
    if (isset($_POST['toedit']) && $_POST['toedit'] > 0) {
      
      $stmt=CDBConnection::getInstance()->prepare("SELECT id,type,name,parent,description FROM ".CDBT_CATEGORIES." WHERE id=:category_id");
      $stmt->bindParam('category_id',$_POST['toedit'],PDO::PARAM_INT);
      $stmt->execute();
      $category = $stmt->fetchOnce(PDO::FETCH_ASSOC);
    
      echo '
        <form action="?show=administration&amp;for=category" method="post">
          <fieldset>
            <legend>Edit</legend>
            <input type="hidden" name="id" id="id" value="'.$category['id'].'" />
            <ul>
              <li>
                <label for="type">Type:</label>
                <select name="type" id="type">
                  <option value="App"'.($category['type']=='App' ? 'selected="selected"' : '').'>Application</option>
                  <option value="DLL"'.($category['type']=='DLL' ? 'selected="selected"' : '').'>DLL-Library</option>
                  <option value="Drv"'.($category['type']=='Drv' ? 'selected="selected"' : '').'>Driver</option>
                  <option value="Oth"'.($category['type']=='Oth' ? 'selected="selected"' : '').'>Other</option>
                </select>
              </li>
              <li>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="'.htmlspecialchars($category['name']).'" />
              </li>
              <li>
                <label for="name">Parent:</label>
                <select name="parent" id="parent">
                  <option value="0"></option>
                  '.Category::showTreeAsOption($category['parent']).'
                </select>
              </li>
              <li>
                <label for="name">Description:</label>
                <input type="text" name="description" id="description" value="'.htmlspecialchars($category['description']).'" />
              </li>
              <li><button type="submit">update</button></li>
          </fieldset>
        </form>';
    }
    else {

      echo '
        <form action="?show=administration&amp;for=category" method="post">
          <fieldset>
            <legend>New</legend>
            <ul>
              <li>
                <label for="type">Type:</label>
                <select name="type" id="type">
                  <option value="app">Application</option>
                  <option value="dll">DLL-Library</option>
                  <option value="drv">Driver</option>
                  <option value="oth">Other</option>
                </select>
              </li>
              <li>
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="" />
              </li>
              <li>
                <label for="name">Parent:</label>
                <select name="parent" id="parent">
                  <option value="0"></option>
                  '.$category_buffer.'
                </select>
              </li>
              <li>
                <label for="name">Description:</label>
                <input type="text" name="description" id="description" value="" />
              </li>
              <li><button type="submit">create</button></li>
          </fieldset>
        </form>
        
        <form action="" method="post">
          <fieldset>
            <legend>Edit</legend>
            <select name="toedit" id="toedit">
              <option value=""></option>
              '.$category_buffer.'
            </select>
            <button type="submit">edit</button>
          </fieldset>
        </form>';
    }
  }
  
  
  private function bodyUsers()
  {
  
    if (!Setting::hasRight('grant')) {
      return false;
    }
  
    $users = array();

    // search for user name
    if (isset($_POST['user'])) {
      $users = CUser::getByName($_POST['user']);
    }

    // check if a user as selected
    if (count($users) === 1) {
      $user_id = $users[0]['id'];
    }
    elseif (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
      $user_id = $_GET['user_id'];
    }
    elseif (isset($_POST['user_id']) && $_POST['user_id'] > 0) {
      $user_id = $_POST['user_id'];
    }
    else {
      $user_id = 0;
    }

    if (isset($_POST['set']) && $user_id > 0) {
      Setting::setRight($user_id, 'delete_comments',isset($_POST['delete_comments']));
      Setting::setRight($user_id, 'delete_tests',isset($_POST['delete_tests']));
      Setting::setRight($user_id, 'checked_tests',isset($_POST['checked_tests']));
      Setting::setRight($user_id, 'admin_interface',isset($_POST['grant']) || isset($_POST['categories']) || isset($_POST['version']));
      Setting::setRight($user_id, 'grant',isset($_POST['grant']));
      Setting::setRight($user_id, 'categories',isset($_POST['categories']));
      Setting::setRight($user_id, 'versions',isset($_POST['versions']));
    }
    
    $delete_comments = Setting::hasRight('delete_comments',$user_id);
    $delete_tests = Setting::hasRight('delete_tests',$user_id);
    $grant = Setting::hasRight('grant',$user_id);
    $categories = Setting::hasRight('categories',$user_id);
    $versions = Setting::hasRight('versions',$user_id);
    $checked_tests = Setting::hasRight('checked_tests',$user_id);

    if ($user_id > 0) {
      echo '
        <form action="?show=administration&amp;for=user" method="post">
          <fieldset>
            <legend>'.CUser::getName($user_id).'</legend>
            <input type="hidden" name="set" id="set" value="1" />
            <input type="hidden" name="user_id" id="user_id" value="'.$user_id.'" />
            <ul>
              <li>
                <input type="checkbox" value="1" name="delete_comments" id="delete_comments"'.($delete_comments ? ' checked="checked"' : '').' />
                <label for="delete_comments">Delete comments</label>
              </li>
              <li>
                <input type="checkbox" value="1" name="delete_tests" id="delete_tests"'.($delete_tests ? ' checked="checked"' : '').' />
                <label for="delete_tests">Delete test reports</label>
              </li>
              <li>
                <input type="checkbox" value="1" name="checked_tests" id="checked_tests"'.($checked_tests ? ' checked="checked"' : '').' />
                <label for="checked_tests">Confirm tests (own test reports will be marked as confirmed)</label>
              </li>
              <li>
                <input type="checkbox" value="1" name="grant" id="grant"'.($grant ? ' checked="checked"' : '').' />
                <label for="grant">Grant user rights</label>
              </li>
              <li>
                <input type="checkbox" value="1" name="categories" id="categories"'.($categories ? ' checked="checked"' : '').' />
                <label for="categories">Administrate Categories</label>
              </li>
              <li>
                <input type="checkbox" value="1" name="versions" id="versions"'.($versions ? ' checked="checked"' : '').' />
                <label for="versions">Administrate ReactOS Versions</label>
              </li>
              <li><button type="submit">set rights</button></li>
            </ul>
          </fieldset>
        </form>';
    }
    else {
      echo '
      <form action="?show=administration&amp;for=user" method="post">
        <fieldset>
          <legend>username:</legend>
          <input type="text" name="user" id="user" value="'.(isset($_POST['user'])?$_POST['user']:'').'" />
          <button type="submit">search</button>
        </fieldset>
      </form>';
      
      if (count($users) > 1) {
        echo '<ul>';
        foreach ($users as $user) {
          echo '<li><a href="?show=administration&amp;for=user&amp;user_id='.$user['id'].'">'.htmlspecialchars($user['name']).'</a></li>';
        }
        echo '</ul>';
      }
    }
  }


} // end of HTML_Administration
?>
