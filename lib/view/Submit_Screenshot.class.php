<?php
    /*
    RSDB - ReactOS Support Database
    Copyright (C) 2005-2006  Klemens Friedl <frik85@reactos.org>

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


class Item_Tips extends HTML_Item
{

  protected function body()
  {


$stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_visible = '1' AND comp_id = :comp_id ORDER BY comp_name ASC");
$stmt->bindParam('comp_id',@$_GET['item'],PDO::PARAM_STR);
$stmt->execute();

$result_page = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result_page['comp_id']) {

echo "<h2>".$result_page['comp_name'] ." [ReactOS ".  @show_osversion($result_page['comp_osversion']) ."]</h2>"; 

if ($RSDB_intern_user_id <= 0) {
	Message::loginRequired(); 
}
else {
	
	echo "<h3>Submit Screenshot</h3>";

	$RSDB_TEMP_SUBMIT_valid = "no";
	$RSDB_TEMP_picgrpnr = 0;
	$RSDB_TEMP_picorder = 0;

	$RSDB_TEMP_txtdesc = "";
	$rem_adr = "";
	
	if (array_key_exists("txtdesc", $_POST)) $RSDB_TEMP_txtdesc=htmlspecialchars($_POST["txtdesc"]);
	
	if (array_key_exists('REMOTE_ADDR', $_SERVER)) $rem_adr=htmlspecialchars($_SERVER['REMOTE_ADDR']);


	include('inc/tools/upload_picture.php');



	if ($RSDB_TEMP_SUBMIT_valid == "yes") {
	
		if ($result_page['comp_media'] == 0) {
		
      $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_ATTACHMENTS." ORDER BY entry_id DESC LIMIT 1");
      $stmt->execute();
			$result_media_entry = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$RSDB_TEMP_picgrpnr = $result_media_entry['entry_id'];
			$RSDB_TEMP_picgrpnr++;
			
			$stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_item_comp SET comp_media = :media WHERE comp_id = :comp_id");
      $stmt->bindParam('media',$RSDB_TEMP_picgrpnr,PDO::PARAM_STR);
      $stmt->bindParam('comp_id',$result_page['comp_id'],PDO::PARAM_STR);
      $stmt->execute();
			
			$RSDB_TEMP_picorder = 1;
		
		}
		else {
		
      $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_ATTACHMENTS." WHERE entry_id = :group_id AND visible IS TRUE LIMIT 1");
      $stmt->bindParam('group_id',$result_page['comp_media'],PDO::FETCH_ASSOC);
      $stmt->execute();
			$result_media_entry = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$RSDB_TEMP_picgrpnr = $result_page['comp_media'];
			$RSDB_TEMP_picorder = 0;//$result_media_entry['media_order'];
			$RSDB_TEMP_picorder++;
		
		}
				
    $stmt=CDBConnection::getInstance()->prepare("INSERT INTO ".CDBT_ATTACHMENTS." ( id, entry_id, visible, file, type, description, creation, user_id) VALUES ('', :group_id, TRUE, :file, 'picture', :decription, NOW(), :user_id)");
    $stmt->bindParam('group_id',$RSDB_TEMP_picgrpnr,PDO::PARAM_STR);
    $stmt->bindParam('file',$Tdbfile,PDO::PARAM_STR);
    $stmt->bindParam('description',$RSDB_TEMP_txtdesc,PDO::PARAM_STR);
    $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_STR);
    $stmt->execute();

		echo "<p><b>Your screenshot has been stored!</b></p>";
		echo "<p><b><a href=\"". $RSDB_intern_link_item_item2 ."screens\">View screenshots</a></b></p>";
		echo "<p><a href=\"". $RSDB_intern_link_submit_comp_screenshot ."add\">Submit new screenshot</a></p>";
		
		
	}
	else {
?>

<form name="RSDB_comp_screenshot" enctype="multipart/form-data" method="post" action="<?php echo $RSDB_intern_link_submit_comp_screenshot; ?>submit">
<p>Upload a screenshot of <b><?php echo $result_page['comp_name']; ?></b> running in <b>ReactOS <?php echo @show_osversion($result_page['comp_osversion']); ?></b>.</p>
<p>&nbsp;</p>
<p><strong>Screenshot image:</strong><br> 
    <input name="file" type="file" size="30" maxlength="255">
    <em><font size="1">(allowed formats: jpg, png, gif; max. filesize: 250 KB; 4:3)</font></em> </p>
<p>
  <strong>Description:</strong><br> 
  <input name="txtdesc" type="text" id="txtdesc" size="60" maxlength="255">
</p>
<p>&nbsp;</p>
<p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em>Please do <strong>not submit screenshots</strong> from <strong>other applications</strong> and/or <strong>operating systems</strong>! </em></font></p>
<p>&nbsp;</p>
<p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">By clicking &quot;Submit&quot; below you agree to be bound by the <a href="<?php echo $RSDB_intern_index_php; ?>?page=conditions" target="_blank">submit conditions</a>.</font></p>
<p>
	<input type="submit" name="Submit" value="Submit">
</p>
</form>
<?php
	}
	
}
}
  } // end of member function body
}
?>
