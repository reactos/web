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

/*
 *	ReactOS Support Database System - RSDB
 *	
 *	(c) by Klemens Friedl <frik85>
 *	
 *	2005 - 2006 
 */


	// To prevent hacking activity:
	if ( !defined('RSDB') )
	{
		die(" ");
	}





// Voting - update DB
if (isset($_GET['vote']) && $_GET['vote'] != '' && isset($_GET['vote2']) && $_GET['vote2'] != '') {
	Star::addVote($_GET['vote'], $_GET['vote2'], CDBT_COMMENTS, "fmsg");
}
if ($RSDB_SET_order == "new") {
	$RSDB_TEMP_order = "DESC";
}
else {
	$RSDB_TEMP_order = "ASC";
}

$RSDB_TEMP_counter_replies = 0;
$RSDB_TEMP_counter_lastreply = 0;
		
if ($RSDB_SET_fstyle == "flat") {
	create_forum_flat();
}			
elseif ($RSDB_SET_fstyle == "nested") {			
	create_forum_nested("0");
}
elseif ($RSDB_SET_fstyle == "threaded") {			
	if ($RSDB_SET_msg == "") {
		create_forum_nested("0");
	}
	else {
		show_msg($RSDB_SET_msg);
		echo "<br />";
		create_forum_nested($RSDB_SET_msg);
		echo '<p><a href="'.$RSDB_intern_link_item_item2_forum_msg.'">Back to the list</a></p>';
	}
}
elseif ($RSDB_SET_fstyle == "fthreads") {
	if ($RSDB_SET_msg == "") {
    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND parent IS NULL ORDER BY creation " . $RSDB_TEMP_order . " LIMIT 1");
    $stmt->execute();
		$result_fmsg_newest = $stmt->fetchOnce(PDO::FETCH_ASSOC);
		$RSDB_TEMP_msg_highlight = $result_fmsg_newest['id'];
	}
	else {
		$RSDB_TEMP_msg_highlight = $RSDB_SET_msg;
	}
	
	echo "<ul>";
	create_forum_threaded(0);
	echo "</ul>";
	
	show_msg($RSDB_TEMP_msg_highlight);
}
elseif ($RSDB_SET_fstyle == "bboard") {
	if ($RSDB_SET_msg == "") {
		if ($RSDB_SET_filter2 == "") {
			$RSDB_SET_filter2 = 0;
			create_forum_bboard(0);
		}
	}
	else {
		show_msg($RSDB_SET_msg);
		echo "<br />";
		create_forum_nested($RSDB_SET_msg);
		echo '<p><a href="'.$RSDB_intern_link_item_item2_forum_msg.'">Back to the Thread list</a></p>';
	}
}


function create_forum_flat() {
	global $RSDB_TEMP_order;
	global $RSDB_intern_link_item_item2_forum_msg;
	global $RSDB_SET_fstyle;
	global $RSDB_intern_user_id;
	global $RSDB_intern_link_item_item2_vote;
	global $RSDB_SET_threshold;
	global $RSDB_intern_link_submit_forum_post;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id` = :item_id ORDER BY creation " . $RSDB_TEMP_order . "");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->execute();
					
	while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$number = 0;//$result_fmsgreports['fmsg_useful_vote_value'];
		$user = 0;//$result_fmsgreports['fmsg_useful_vote_user'];
		$result_stars = @($number / $user);
		$result_round_stars = round($result_stars, 0);
?>
	<table width="100%"  border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td bgcolor="#E2E2E2"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#5984C3">
            <tr>
              <td valign="top"><p><strong><font size="3"><?php echo htmlentities($result_fmsgreports['title'], ENT_QUOTES); ?></font></strong></p></td>
              <td width="270"><div align="left"><font size="1">

              </font></div></td>
            </tr>
            <tr>
              <td valign="top"><font size="2"><?php echo usrfunc_GetUsername($result_fmsgreports['user_id'])." on ".$result_fmsgreports['creation']; ?></font></td>
              <td><div align="left"><font size="1">
              </font></div></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#EEEEEE"><font size="2"><?php echo wordwrap(nl2br(htmlentities($result_fmsgreports['content'], ENT_QUOTES))); ?></font></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#E2E2E2"><font size="2"><a href="<?php echo $RSDB_intern_link_submit_forum_post.$result_fmsgreports['id']; ?>">Reply</a> | <a href="<?php echo $RSDB_intern_link_submit_forum_post."0"; ?>">New Thread</a></font></td>
      </tr>
</table>
<br />
<?php
}

	
function create_forum_nested($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_order;
	global $RSDB_intern_link_item_item2_forum_msg;
	global $RSDB_SET_fstyle;
	global $RSDB_intern_user_id;
	global $RSDB_intern_link_item_item2_vote;
	global $RSDB_SET_threshold;
	global $RSDB_intern_link_submit_forum_post;
	global $RSDB_setting_stars_threshold;

	if ($RSDB_SET_fstyle == "bboard") {
		$RSDB_TEMP_order  = "ASC";
	}

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent ORDER BY creation ".$RSDB_TEMP_order."");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();

	while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$number = 0;//$result_fmsgreports['fmsg_useful_vote_value'];
		$user = 0;//$result_fmsgreports['fmsg_useful_vote_user'];
		$result_stars = @($number / $user);
		$result_round_stars = round($result_stars, 0);
		
		if ($result_round_stars >= $RSDB_SET_threshold || $result_round_stars == 0) {
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="<?php 
			
		$RSDB_TEMP_cat_current_id_guess = $result_fmsgreports['id'];
		$RSDB_intern_catlevel = "0";
		
		// count the levels -> current reply level
		for ($guesslevel=1; ; $guesslevel++) {
//				echo $guesslevel."#";
        $stmt_msg=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE id = :msg_id AND visible IS TRUE");
        $stmt_msg->bindParam('msg_id',$RSDB_TEMP_cat_current_id_guess,PDO::PARAM_STR);
        $stmt_msg->execute();
				$result_category_tree_guesslevel=$stmt_msg->fetchOnce(PDO::FETCH_ASSOC);
				$RSDB_TEMP_cat_current_id_guess = $result_category_tree_guesslevel['parent'];
				
				if (!$result_category_tree_guesslevel['id']) {
//					echo "ENDE:".($guesslevel-1);
					$RSDB_intern_catlevel = ($guesslevel-1);
					break;
				}
		}
		
		if ($RSDB_TEMP_msgid != 0) {
			echo (20*($RSDB_intern_catlevel-1));
		}
			
	 ?>" bgcolor="#FFFFFF"></td>
    <td><table width="100%"  border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td bgcolor="#E2E2E2"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#5984C3">
            <tr>
              <td valign="top"><p><strong><font size="3"><?php echo htmlentities($result_fmsgreports['title'], ENT_QUOTES); ?></font></strong></p></td>
              <td width="270"><div align="left"><font size="1">
              </font></div></td>
            </tr>
            <tr>
              <td valign="top"><font size="2"><?php echo usrfunc_GetUsername($result_fmsgreports['user_id'])." on ".$result_fmsgreports['creation']; ?></font></td>
              <td><div align="left"><font size="1">
              </font></div></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="7" bgcolor="#EEEEEE"><font size="2"><?php echo wordwrap(nl2br(htmlentities($result_fmsgreports['content'], ENT_QUOTES))); ?></font></td>
      </tr>
      <tr>
        <td colspan="7" bgcolor="#E2E2E2"><font size="2"><a href="<?php echo $RSDB_intern_link_submit_forum_post.$result_fmsgreports['id']; ?>">Reply</a> | <a href="<?php echo $RSDB_intern_link_submit_forum_post."0"; ?>">New Thread</a></font></td>
      </tr>
    </table></td>
  </tr>
</table>	
<?php
		}
		else { ?>
			
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="<?php
		if ($RSDB_TEMP_msgid != 0) {
			echo (10*($RSDB_TEMP_msgid+1));
		}
		else {
			echo "0";
		}
	?>"></td>
    <td><font size="2"><?php 
		echo "<i>This message is beneath your threshold</i> - "; // : <strike>".$result_fmsgreports['fmsg_subject']."</i>, Anonymous on ".$result_fmsgreports['fmsg_date']."</strike> - ";

	?></font></td>
  </tr>
</table>
	
		<?php
		}

		echo "<br />";

    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent");
    $stmt->bindParam('parent',$result_fmsgreports['id'],PDO::PARAM_STR);
    $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
		$result_count_msgs = $stmt->fetchOnce(PDO::FETCH_NUM);
	
		if ($result_count_msgs[0] != "0" && $result_count_msgs[0] != "") {
			if ($RSDB_SET_fstyle == "nested" || $RSDB_SET_fstyle == "bboard") {			
				create_forum_nested($result_fmsgreports['id']);
			}
			elseif ($RSDB_SET_fstyle == "threaded") {		
				echo "<ul>";
				create_forum_threaded($result_fmsgreports['id']);
				echo "</ul>";
				echo "<br />\n";
			}
		}
	}
}

function create_forum_threaded($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_order;
	global $RSDB_intern_link_item_item2_forum_msg;
	global $RSDB_SET_fstyle;
	global $RSDB_intern_user_id;
	global $RSDB_intern_link_item_item2_vote;
	global $RSDB_TEMP_msg_highlight;
	global $RSDB_SET_threshold;
	global $RSDB_intern_link_submit_forum_post;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent ORDER BY creation ".$RSDB_TEMP_order."");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();

	while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$number = 0;//$result_fmsgreports['fmsg_useful_vote_value'];
		$user = 0;//$result_fmsgreports['fmsg_useful_vote_user'];
		$result_stars = @($number / $user);
		$result_round_stars = round($result_stars, 0);
		
		if ($result_round_stars >= $RSDB_SET_threshold || $result_round_stars == 0) {
			if ($RSDB_TEMP_msg_highlight == $result_fmsgreports['id']) {
				echo '<li><b><i><a href="'.$RSDB_intern_link_item_item2_forum_msg.$result_fmsgreports['id'].'">'.htmlentities($result_fmsgreports['title'], ENT_QUOTES).'</a></i></b>, '. usrfunc_GetUsername($result_fmsgreports['user_id']) .' on '.$result_fmsgreports['creation'].' - ';
			}
			else {
				echo '<li><i><a href="'.$RSDB_intern_link_item_item2_forum_msg.$result_fmsgreports['id'].'">'.htmlentities($result_fmsgreports['title'], ENT_QUOTES).'</a></i>, '. usrfunc_GetUsername($result_fmsgreports['user_id']) .' on '.$result_fmsgreports['creation'].' - ';
			}
		}
		else {
			echo "<li><i>This message is beneath your threshold - "; //: <strike>".$result_fmsgreports['fmsg_subject']."</i>, Anonymous on ".$result_fmsgreports['fmsg_date']."</strike> - ";
		}

    $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent");
    $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
    $stmt->bindParam('parent',$result_fmsgreports['id'],PDO::PARAM_STR);
    $stmt->execute();
		$result_count_msgs = $stmt->fetchOnce(PDO::FETCH_NUM);
	
		if ($result_count_msgs[0] != "0" && $result_count_msgs[0] != "") {
			echo "<ul>";
			create_forum_threaded($result_fmsgreports['id']);
			echo "</ul>\n";
		}

	}
}

function create_forum_bboard($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_order;
	global $RSDB_intern_link_item_item2_forum_msg;
	global $RSDB_SET_fstyle;
	global $RSDB_intern_user_id;
	global $RSDB_intern_link_item_item2_vote;
	global $RSDB_TEMP_msg_highlight;
	global $RSDB_TEMP_counter_replies;
	global $RSDB_SET_threshold;
	global $RSDB_intern_link_submit_forum_post;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent ORDER BY creation " . $RSDB_TEMP_order . "");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();
?>
		<table width="100%"  border="0" cellpadding="3" cellspacing="1">
		  <tr bgcolor="#5984C3">
		    <td colspan="2" bgcolor="#5984C3"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="3">Topics </font></strong></font></div></td>
			<td width="10%" bgcolor="#5984C3"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="3">Replies </font></strong></font></div></td>
			<td width="13%" bgcolor="#5984C3"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="3">Author </font></strong></font></div></td>
			<td width="12%" bgcolor="#5984C3"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="3">Stars</font></strong></font></div></td>
			<td width="15%"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="3">Last Post </font></strong></font></div></td>
		  </tr>
<?php
	while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$number = 0;//$result_fmsgreports['fmsg_useful_vote_value'];
		$user = 0;//$result_fmsgreports['fmsg_useful_vote_user'];
		$result_stars = @($number / $user);
		$result_round_stars = round($result_stars, 0);

?>
		  <tr>
		    <td width="25" bgcolor="#EEEEEE"><div align="center"><img src="media/icons/forum/folder.gif" width="19" height="18"></div></td>
			<td bgcolor="#EEEEEE"><font size="2"><?php
			
			if ($result_round_stars >= $RSDB_SET_threshold || $result_round_stars == 0) {

			?><a href="<?php echo $RSDB_intern_link_item_item2_forum_msg.$result_fmsgreports['id']; ?>"><?php echo htmlentities($result_fmsgreports['title'], ENT_QUOTES); ?></a><?php
			
			}
			else {
				echo "<i>This message is beneath your threshold</i>";
				//echo "Beneath your threshold: <strike>".$result_fmsgreports['fmsg_subject']."</strike>";
			}
			?></font></td>
			<td bgcolor="#E2E2E2"><div align="center"><font size="2"><?php 

				$RSDB_TEMP_counter_replies = 0;
				echo calc_replies($result_fmsgreports['id']);
				
			?></font></div></td>
			<td bgcolor="#EEEEEE"><div align="center"><font size="2"><?php echo usrfunc_GetUsername($result_fmsgreports['user_id']); ?></font></div></td>
			<td bgcolor="#E2E2E2"><div align="left"><font size="2">&nbsp;</font></div></td>
			<td bgcolor="#EEEEEE"><div align="center"><font size="2"><?php 

				$RSDB_TEMP_counter_lastreply = 0;
				$RSDB_TEMP_lastpost = query_lastreply($result_fmsgreports['id']);
				//echo $RSDB_TEMP_lastpost;
        $stmt_comp=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND id = :msg_id");
        $stmt_comp->bindParam('msg_id',$RSDB_TEMP_lastpost,PDO::PARAM_STR);
        $stmt_comp->execute();
				$result_fmsglastpost = $stmt_comp->fetchOnce(PDO::FETCH_ASSOC);
				if ($result_fmsglastpost['creation'] != "") {
					echo $result_fmsglastpost['creation']."<br />".$result_fmsglastpost['user_id'];
				}
				else {
					echo $result_fmsgreports['creation']."<br />".$result_fmsgreports['user_id'];
				}
			?>&nbsp;</font></div></td>
		  </tr>

<?php
		//echo "<li><b><i>".$result_fmsgreports['fmsg_subject']."</i></b>, Anonymous on ".$result_fmsgreports['fmsg_date']." - ";
		//echo Star::drawSmall($result_fmsgreports['fmsg_useful_vote_value'], $result_fmsgreports['fmsg_useful_vote_user'], 5, "") ."</li>";
	
	}
	
?>
		</table>
		<p><a href="<?php echo $RSDB_intern_link_submit_forum_post."0"; ?>">New Thread</a></p>
<?php
}

function show_msg($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_order;
	global $RSDB_intern_link_item_item2_forum_msg;
	global $RSDB_SET_fstyle;
	global $RSDB_intern_user_id;
	global $RSDB_intern_link_item_item2_vote;
	global $RSDB_SET_threshold;
	global $RSDB_intern_link_submit_forum_post;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND id = :msg_id");
  $stmt->bindParam('msg_id',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();

	$result_fmsgreports = $stmt->fetchOnce(PDO::FETCH_ASSOC);
		$number = 0;//$result_fmsgreports['fmsg_useful_vote_value'];
		$user = 0;//$result_fmsgreports['fmsg_useful_vote_user'];
		$result_stars = @($number / $user);
		$result_round_stars = round($result_stars, 0);

		if ($result_round_stars >= $RSDB_SET_threshold || $result_round_stars == 0) {

?>
	<table width="100%"  border="0" cellpadding="3" cellspacing="1">
      <tr>
        <td bgcolor="#E2E2E2"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#5984C3">
            <tr>
              <td valign="top"><p><strong><font size="3"><?php echo htmlentities($result_fmsgreports['title'], ENT_QUOTES); ?></font></strong></p></td>
              <td width="270"><div align="left"><font size="1">
              </font></div></td>
            </tr>
            <tr>
              <td valign="top"><font size="2"><?php echo usrfunc_GetUsername($result_fmsgreports['user_id'])." on ".$result_fmsgreports['creation']; ?></font></td>
              <td><div align="left"><font size="1">
              </font></div></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#EEEEEE"><font size="2"><?php echo wordwrap(nl2br(htmlentities($result_fmsgreports['content'], ENT_QUOTES))); ?></font></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#E2E2E2"><font size="2"><a href="<?php echo $RSDB_intern_link_submit_forum_post.$result_fmsgreports['id']; ?>">Reply</a> | <a href="<?php echo $RSDB_intern_link_submit_forum_post."0"; ?>">New Thread</a></font></td>
      </tr>
</table>
<?php
	}
	else {
		Message::show("<b>This message is beneath your threshold.</b>");
	}
}

function calc_replies($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_counter_replies;
	global $RSDB_TEMP_order;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();
	$result_count_msgs = $stmt->fetchOnce(PDO::FETCH_NUM);
	//echo $RSDB_TEMP_counter_replies;
			
	if ($result_count_msgs[0] != "0" && $result_count_msgs[0] != "") {
		$RSDB_TEMP_counter_replies++;
		
    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent ORDER BY creation " . $RSDB_TEMP_order . "");
    $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
    $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
    $stmt->execute();
		while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
			calc_replies($result_fmsgreports['id']);
		}
	}
	return $RSDB_TEMP_counter_replies;
}

function query_lastreply($RSDB_TEMP_msgid) {
	global $RSDB_TEMP_counter_lastreply;
	global $RSDB_TEMP_order;
	global $RSDB_setting_stars_threshold;

  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent ORDER BY creation DESC") ;
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$RSDB_TEMP_msgid,PDO::PARAM_STR);
  $stmt->execute();
	while($result_fmsgreports = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $stmt_count=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM ".CDBT_COMMENTS." WHERE visible IS TRUE AND entry_id = :item_id AND parent = :parent");
  $stmt->bindParam('item_id',@$_GET['item'],PDO::PARAM_STR);
  $stmt->bindParam('parent',$result_fmsgreports['id'],PDO::PARAM_STR);
  $stmt->execute();
		$result_count_msgs = $stmt->fetchOnce(PDO::FETCH_NUM);
			
		if ($RSDB_TEMP_counter_lastreply < $result_fmsgreports['id']) {
			$RSDB_TEMP_counter_lastreply = $result_fmsgreports['id'];
		}
			
		if ($result_count_msgs[0] != "0" && $result_count_msgs[0] != "") {
			query_lastreply($result_fmsgreports['id']);
		}
	}
	return $RSDB_TEMP_counter_lastreply;
}

?>