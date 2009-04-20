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
	echo "<h2>".$result_page['comp_name'] ." [". "ReactOS ".@show_osversion($result_page['comp_osversion']) ."]</h2>"; 
	
	
	
?>
<p align="center">The following pictures are owned by whoever posted them. We are not responsible for them in any way. </p>
<p align="center"><strong><a href="<?php echo $RSDB_intern_link_submit_comp_screenshot; ?>add">Submit Screenshot</a></strong> (image file)</p>
<?php

// Voting - update DB
if (isset($_GET['vote']) && $_GET['vote'] != '' && isset($_GET['vote2']) && $_GET['vote2'] != '') {
	Star::addVote($_GET['vote'], $_GET['vote2'], CDBT_ATTACHMENTS, "media");
}
	
if (isset($_GET['entry']) && ($_GET['entry'] == '' || $_GET['entry'] == 0)) {

?>

<table width="100%"  border="0" cellpadding="3" cellspacing="1">
<?php
	$roscms_TEMP_counter = 0;
	
	$stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_ATTACHMENTS." WHERE entry_id = :group_id");
  $stmt->bindParam('group_id',$result_page['comp_media'],PDO::PARAM_STR);
  $stmt->execute();
	while($result_screenshots= $stmt->fetch(PDO::FETCH_ASSOC)) {
		$roscms_TEMP_counter++;
		if ($roscms_TEMP_counter == 1) {
			echo "<tr>";
		}
		echo '<td width="33%" valign="top">';

		echo '<p align="center"><br /><a href="'.$RSDB_intern_link_item_item2.'screens&amp;entry='.$result_screenshots["id"].'"><img src="media/files/'.$result_screenshots["type"].'/'.urlencode($result_screenshots["file"]).'" width="250" height="188" border="0" alt="';
		echo 'Description: '.htmlentities($result_screenshots["description"])."\nUser: ".usrfunc_GetUsername($result_screenshots["user_id"])."\nDate: ".$result_screenshots["creation"];
		echo '"></a><br /><i>'.htmlentities($result_screenshots["description"]).'</i><br />';
		echo '<br /><font size="1">';
				
		echo '</font><br /><br /></p>';

		echo "</td>";
		if ($roscms_TEMP_counter == 3) {
			echo "</tr>";
			$roscms_TEMP_counter = 0;
		}
	}
	
	if ($roscms_TEMP_counter == 1) {
		echo '<td width="33%" valign="top">&nbsp;</td>';
		echo '<td width="33%" valign="top">&nbsp;</td></tr>';
	}
	if ($roscms_TEMP_counter == 2) {
		echo '<td width="33%" valign="top">&nbsp;</td></tr>';
	}

echo "</table>";

}
else {
	// Show one picture in max resolution:
  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_ATTACHMENTS." WHERE id = :media_id LIMIT 1") ;
  $stmt->bindParam('media_id',@$_GET['entry'],PDO::PARAM_STR);
  $stmt->execute();
	$result_screenshots= $stmt->fetch(PDO::FETCH_ASSOC);
	echo '<p align="center"><b><a href="'.$RSDB_intern_link_item_item2.'screens">Show all screenshots</a></b></p>';
	echo '<h5>'.htmlentities($result_screenshots["description"]).'&nbsp;</h5>';
	echo '<p><img src="media/files/'.$result_screenshots["type"].'/'.urlencode($result_screenshots["file"]).'" border="0" alt="';
	echo ''.$result_screenshots["description"].'"></a></p>';
	echo '<p><b>Description:</b> '.htmlentities($result_screenshots["description"]).'<br />';
	echo '<b>User:</b> '.usrfunc_GetUsername($result_screenshots["user_id"]).'<br />';
	echo '<b>Date:</b> '.$result_screenshots["creation"].'</p>';
	echo '<p align="center"><b><a href="'.$RSDB_intern_link_item_item2.'screens">Show all screenshots</a></b></p>';
}
}
  } // end of member function body
}
?>
