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

class HTML_Group extends HTML
{


  protected function body()
  {


	
    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id AND grpentr_comp = '1' ORDER BY grpentr_name ASC") ;
    $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
    $stmt->execute();
		$result_page = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($result_page['grpentr_type'] == "default") {
		// Update the ViewCounter:
		if ($RSDB_SET_group != "" || $RSDB_SET_group != "0") {
      $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_groups SET grpentr_viewcounter = grpentr_viewcounter + 1 WHERE grpentr_id = '" . $RSDB_SET_group . "'");
      $stmt->execute();
		}
	
	?>
	
	<style type="text/css">
	<!--
	/* tab colors */
	.tab                { background-color : #ffffff; }
	.tab_s              { background-color : #5984C3; }
	.tab_u              { background-color : #A0B7C9; }
	
	/* tab link colors */
	a.tabLink           { text-decoration : none; }
	a.tabLink:link      { text-decoration : none; }
	a.tabLink:visited   { text-decoration : none; }
	a.tabLink:hover     { text-decoration : underline; }
	a.tabLink:active    { text-decoration : underline; }
	
	/* tab link size */
	p.tabLink_s         { color: navy; font-size : 10pt; font-weight : bold; padding : 0 8px 1px 2px; margin : 0; }
	p.tabLink_u         { color: black; font-size : 10pt; padding : 0 8px 1px 2px; margin : 0; }
	
	/* text styles */
	.strike 	       { text-decoration: line-through; }
	.bold              { font-weight: bold; }
	.newstitle         { font-weight: bold; color: purple; }
	.title_group       { font-size: 16px; font-weight: bold; color: #5984C3; text-decoration: none; }
	.bluetitle:visited { color: #323fa2; text-decoration: none; }
	
	.Stil1 {font-size: xx-small}
	.Stil2 {font-size: x-small}
	.Stil3 {color: #FFFFFF}
	.Stil4 {font-size: xx-small; color: #FFFFFF; }
	
	-->
	</style>
	<script src="<?php echo $RSDB_intern_path_server.$RSDB_intern_path; ?>rsdb.js"></script>
		<h2><?php echo $result_page['grpentr_name']; ?></h2>
	
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tr align="left" valign="top">
			<!-- title -->
			<td valign="bottom" width="100%">
			  <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
				  <td class="title_group" nowrap="nowrap"><?php 
				  
				  if (isset($_GET['group2']) && ($_GET['group2'] == "overview" || $_GET['group2'] == "")) { 
				  	echo "Overview";
				  }
				  else { 
						$stmt=CDBConnection::getInstance()->prepare("SELECT comp_name, comp_appversion FROM rsdb_item_comp  WHERE comp_visible = '1' AND comp_groupid = :group_id AND comp_appversion = :version LIMIT 1");
            $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
            $stmt->bindParam('version',@$_GET['group2'],PDO::PARAM_STR);
            $stmt->execute();
						$result_entry_appname = $stmt->fetch(PDO::FETCH_ASSOC);
						echo $result_entry_appname['comp_name'];
				  }
			  
				  
				  ?></td>
				</tr>
				<tr valign="bottom">
				  <td class="tab_s"><img src="images/white_pixel.gif" alt="" height="1" width="1"></td>
				</tr>
			</table></td>

          <!-- start tab -->
          <td nowrap="nowrap">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr align="left" valign="top">
                  <td width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="4"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab_s"; } else { echo "tab_u"; } ?>"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr align="left" valign="top">
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/white_pixel.gif" alt="" height="4" width="1"></td>
                  <td width="4"><img src="images/tab_corner_<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "active"; } else { echo "inactive"; } ?>.gif" alt="" height="4" width="4"></td>
                  <td><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr valign="middle">
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="4"><img src="images/blank.gif" alt="" height="1" width="4"></td>
                  <td nowrap="nowrap"><p class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tabLink_s"; } else { echo "tabLink_u"; } ?>"><a href="<?php echo $RSDB_intern_link_group_group2; ?>overview" class="tabLink">Overview</a></p></td>
                  <td class="<?php if (v) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr valign="bottom">
                  <td class="tab_s" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab"; } else { echo "tab_s"; } ?>" width="4"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && ($_GET['group2'] == 'overview' || $_GET['group2'] == '')) { echo "tab"; } else { echo "tab_s"; } ?>"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="tab_s" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="tab_s" width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
          </table></td>
          <!-- end tab -->

<?php

    $stmt=CDBConnection::getInstance()->prepare("SELECT DISTINCT (comp_appversion), comp_osversion, comp_id, comp_name FROM rsdb_item_comp WHERE comp_visible = '1' AND comp_groupid = :group_id GROUP BY comp_appversion ORDER BY comp_appversion ASC LIMIT 15");
    $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
		while($result_entry_appver = $stmt->fetch()) {
?>
          <!-- start tab -->
          <td nowrap="nowrap">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr align="left" valign="top">
                  <td width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="4"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr align="left" valign="top">
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/white_pixel.gif" alt="" height="4" width="1"></td>
                  <td width="4"><img src="images/tab_corner_<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "active"; } else { echo "inactive"; } ?>.gif" alt="" height="4" width="4"></td>
                  <td><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr valign="middle">
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="4"><img src="images/blank.gif" alt="" height="1" width="4"></td>
                  <td nowrap="nowrap"><p class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tabLink_s"; } else { echo "tabLink_u"; } ?>"><?php echo "<a href=\"".$RSDB_intern_link_group_group2.$result_entry_appver['comp_appversion']."\" class=\"tabLink\">".$result_entry_appver['comp_name']."</a>"; ?></p></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab_s"; } else { echo "tab_u"; } ?>" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
                <tr valign="bottom">
                  <td class="tab_s" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab"; } else { echo "tab_s"; } ?>" width="4"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="<?php if (isset($_GET['group2']) && $_GET['group2'] == $result_entry_appver['comp_appversion']) { echo "tab"; } else { echo "tab_s"; } ?>"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="tab_s" width="1"><img src="images/blank.gif" alt="" height="1" width="1"></td>
                  <td class="tab_s" width="2"><img src="images/blank.gif" alt="" height="1" width="2"></td>
                </tr>
          </table></td>
          <!-- end tab -->
<?php
		}
?>

			<!-- fill the remaining space -->
			<td valign="bottom" width="10">
			  <table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr valign="bottom">
				  <td class="tab_s"><img src="images/white_pixel.gif" alt="" height="1" width="10"></td>
				</tr>
			</table></td>
		  </tr>
		</table>
	<?php
				$counter_stars_install_sum = 0;
				$counter_stars_function_sum = 0;
				$counter_stars_user_sum = 0;
				$counter_awards_best = 0;
				
				$counter_items = 0;
	
				if (isset($_GET['group2']) && ($_GET['group2'] == '' || $_GET['group2'] == 'overview')) {
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_groupid = :group_id AND comp_visible = '1' ORDER BY comp_groupid DESC");
          $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
          $stmt->execute();
				}
				else {
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_groupid = :group_id AND comp_visible = '1' AND `comp_appversion` = :version ORDER BY comp_groupid DESC");
          $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
          $stmt->bindParam('version',@$_GET['group2'],PDO::PARAM_STR);
          $stmt->execute();
				}
				while($result_group_sum_items = $stmt->fetch(PDO::FETCH_ASSOC)) { 
					$counter_items++;
					if ($counter_awards_best < $result_group_sum_items['comp_award']) {
						$counter_awards_best = $result_group_sum_items['comp_award'];
					}
          $stmt_sub=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp_testresults WHERE test_visible = '1' AND test_comp_id = :comp_id ORDER BY test_comp_id ASC");
          $stmt_sub->bindParam('comp_id',$result_group_sum_items['comp_id'],PDO::PARAM_STR);
          $stmt_sub->execute();
					while($result_count_stars_sum = $stmt_sub->fetch(PDO::FETCH_ASSOC)) {
						$counter_stars_install_sum += $result_count_stars_sum['test_result_install'];
						$counter_stars_function_sum += $result_count_stars_sum['test_result_function'];
						$counter_stars_user_sum++;
					}
				}
	
        $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_vendor WHERE vendor_id = :vendor_id AND vendor_visible = '1'");
        $stmt->bindParam('vendor_id',$result_page['grpentr_vendor'],PDO::PARAM_STR);
        $stmt->execute();
				$result_entry_vendor = $stmt->fetch(PDO::FETCH_ASSOC);
	

	
  $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_item_comp WHERE comp_groupid = :group_id AND comp_visible = '1'");
  $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
  $stmt->execute();
	$result_item_entry_records = $stmt->fetch(PDO::FETCH_NUM);
	
	if ($result_item_entry_records[0] == 0) {
	
    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_vendor WHERE vendor_id = :vendor_id AND vendor_visible = '1'");
    $stmt->bindParam('vendor_id',$result_page['grpentr_vendor'],PDO::PARAM_STR);
    $stmt->execute();
		$result_vend = $stmt->fetch(PDO::FETCH_ASSOC);
?>
		<p>&nbsp;</p>
		<p><b>Vendor:</b> <?php echo '<a href="'.$RSDB_intern_link_vendor_sec.$result_vend['vendor_id'].'">'.$result_vend['vendor_name'].'</a>'; ?></p>
		<p>&nbsp;</p>
		<p>No application or driver version stored.</p>
		<p>&nbsp;</p>
		<p><a href="<?php echo $RSDB_intern_link_submit_appver; ?>"><strong><font size="4">Submit new &quot;<?php echo $result_page['grpentr_name']; ?>&quot; version</font></strong></a></p>
		<p>&nbsp;</p>
<?php
	}
	else {
	?>
<br />
		<div id="moreinfo" style="display: none">	
			<div id="textversions" align="center"></div>
			<script language="JavaScript1.2">
				function show_Versions(lblVersions) {
					document.getElementById("textversions").innerHTML ='<b><a title=\"All Application and ReactOS versions\" href=\"javascript:showhideVersions()\">' + lblVersions + '</a></b>' ;
				}
			</script>
		</div>	
		<div id="versions" style="display: block">	
		<?php
		// Count the comp entries
		$stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_item_comp WHERE comp_groupid = :group_id");
    $stmt->bindParam('group_id',$result_page["grpentr_id"],PDO::PARAM_STR);
    $stmt->execute();
		$result_count_comp = $stmt->fetch(PDO::FETCH_NUM);
		
		if ($result_count_comp[0]) {
	
	?>
		<a name="ver"></a>
		<h3>All Versions</h3>
		<?php
				include("inc/comp/data/group_item_list.php");
		?>
		<div id="group_version_list"></div>
		<br />
	<?php
		}
	?>
	</div>
		<table width="100%" border="0" cellpadding="1" cellspacing="5">
		  <tr>
			<td width="40%" valign="top">
	
			<?php
				if (isset($_GET['group2']) && ($_GET['group2'] == '' || $_GET['group2'] == 'overview')) {
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_groupid = :group_id  AND comp_visible = '1' ORDER BY comp_award DESC, comp_appversion DESC, comp_osversion DESC LIMIT 1");
				}
				else {
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_groupid = :group_id AND comp_visible = '1' AND comp_appversion = :version ORDER BY comp_award DESC, comp_osversion DESC LIMIT 1");
          $stmt->bindParam('version',@$_GET['group2'],PDO::PARAM_STR);

				}
        $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
				$stmt->execute();
				$result_version_newest = $stmt->fetch(PDO::FETCH_ASSOC);;
				
				echo "<h3 align=\"center\"><font size=\"2\">".$result_entry_vendor['vendor_name']."</font> ".$result_version_newest['comp_name']."</h3>";
			?>
		  <p><font size="2">Most compatible entry.</font></p>
		  <span class="simple"><strong>Application</strong></span>
			<ul class=simple>
			  <li><strong>Name:</strong> <?php echo $result_version_newest['comp_name']; ?></li>
			  <li><strong>Version:</strong> <?php echo $result_version_newest['comp_appversion']; ?></li>
			  <li><strong>Vendor:</strong> <font size="2" face="Arial, Helvetica, sans-serif">
				<?php
			
				echo '<a href="'.$RSDB_intern_link_vendor_sec.$result_entry_vendor['vendor_id'].'">'.$result_entry_vendor['vendor_name'].'</a>';
	
			  ?>
			  </font></li>
			  <li><strong>Description:</strong> <?php echo $result_version_newest['comp_description']; ?></li>
			  </ul>
			<span class="simple"><strong>ReactOS</strong></span>		<ul class=simple>
			  <li><strong>Version:</strong> <?php 
			  
			  echo "ReactOS ". @show_osversion($result_version_newest['comp_osversion']); ?></li>
			  <li><strong>Other tested versions:</strong><ul class=simple>
			  <?php
		
      $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_name = :name AND comp_visible = '1' AND `comp_groupid` = :group_id ORDER BY `comp_osversion` DESC");
      $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
      $stmt->bindParam('name',$result_version_newest['comp_name'],PDO::PARAM_STR);
      $stmt->execute();
			while($result_entry_osver = $stmt->fetch(PDO::FETCH_ASSOC)) {
				if ($result_entry_osver['comp_osversion'] != $result_version_newest['comp_osversion']) {
					echo "<li><a href=\"".$RSDB_intern_link_item.$result_entry_osver['comp_id']."\">"."ReactOS ". @show_osversion($result_entry_osver['comp_osversion'])."</a></li>";
				}
			}
		
		?>			  </ul></li>
			 
			  </ul>
			<span class="simple"><strong>Compatibility</strong></span>
			<ul class=simple>
			  <li><strong>Award:</strong> <font size="2"><img src="media/icons/awards/<?php echo Award::icon($result_version_newest['comp_award']); ?>.gif" alt="<?php echo Award::name($result_version_newest['comp_award']); ?>" width="16" height="16" /> <?php echo Award::name($result_version_newest['comp_award']); ?></font></li>
			  <li><strong>Function:</strong>
				  <?php 
				  
				$counter_stars_install = 0;
				$counter_stars_function = 0;
				$counter_stars_user = 0;
				
        $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp_testresults WHERE test_visible = '1' AND test_comp_id = :comp_id ORDER BY test_comp_id ASC");
        $stmt->bindParam('comp_id',$result_version_newest['comp_id'],PDO::PARAM_STR);
        $stmt->execute();
				while($result_count_stars = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$counter_stars_install += $result_count_stars['test_result_install'];
					$counter_stars_function += $result_count_stars['test_result_function'];
					$counter_stars_user++;
				}
				
				echo Star::drawNormal($counter_stars_function, $counter_stars_user, 5, "tests");
	
				
				?>
			  </li>
			  <li><strong>Install:</strong> <?php echo Star::drawNormal($counter_stars_install, $counter_stars_user, 5, "tests"); ?></li>
			</ul>
			<span class="simple"><strong>Further Information</strong></span>
			<ul class=simple>
			  <li><a href="<?php echo $RSDB_intern_link_item.$result_version_newest['comp_id']."&amp;item2="; ?>details">Details</a></li>
<?php
        $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_item_comp_testresults WHERE test_comp_id = :comp_id AND test_visible = '1'");
        $stmt->bindParam('comp_id',$result_version_newest['comp_id'],PDO::PARAM_STR);
        $stmt->execute();
					$result_count_testentries = $stmt->fetch(PDO::FETCH_NUM);
					
					echo '<b><li><a href="'. $RSDB_intern_link_item.$result_version_newest['comp_id'] .'&amp;item2=tests">Compatibility Tests</b>';
					
					if ($result_count_testentries[0] > 0) {
						echo " (". $result_count_testentries[0] .")</a></li>";
					}
					else {
						echo "</a></li>";
					}
?>
<?php
          $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_item_comp_forum WHERE fmsg_comp_id = :comp_id AND fmsg_visible = '1' ;");
          $stmt->bindParam('comp_id',$result_version_newest['comp_id'],PDO::PARAM_STR);
          $stmt->execute();
					$result_count_forumentries = $stmt->fetch(PDO::FETCH_NUM);
					
					if ($result_count_forumentries[0] > 0) {
						echo "<b>";
					}
			  		
					echo '<li><a href="'. $RSDB_intern_link_item.$result_version_newest['comp_id'] .'&amp;item2=forum">Forum';
					
					if ($result_count_forumentries[0] > 0) {
						echo "</b> (". $result_count_forumentries[0] .")</a></li>";
					}
					else {
						echo "</a></li>";
					}
?>
<?php
          $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_object_media WHERE media_groupid = :group_id AND media_visible = '1'");
          $stmt->bindParam('group_id',$result_version_newest['comp_media'],PDO::PARAM_STR);
          $stmt->execute();
					$result_count_screenshots = $stmt->fetch(PDO::FETCH_NUM);
					
					if ($result_count_screenshots[0] > 0) {
						echo "<b>";
					}
			  		
					echo '<li><a href="'. $RSDB_intern_link_item.$result_version_newest['comp_id'] .'&amp;item2=screens">Screenshots';
					
					if ($result_count_screenshots[0] > 0) {
						echo "</b> (". $result_count_screenshots[0] .")</a></li>";
					}
					else {
						echo "</a></li>";
					}
?>
			  <li><a href="<?php echo "http://www.reactos.org/bugzilla/buglist.cgi?bug_status=UNCONFIRMED&bug_status=NEW&bug_status=ASSIGNED&bug_status=REOPENED&field0-0-0=product&type0-0-0=substring&value0-0-0=".$result_version_newest['comp_name']."&field0-0-1=component&type0-0-1=substring&value0-0-1=".$result_version_newest['comp_name']."&field0-0-2=short_desc&type0-0-2=substring&value0-0-2=".$result_version_newest['comp_name']."&field0-0-3=status_whiteboard&type0-0-3=substring&value0-0-3=".$result_version_newest['comp_name']; ?>" target="_blank">Bugs</a></li>
			</ul>
		<br />
        <?php 
      $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_group_bundles WHERE bundle_groupid = :group_id");
      $stmt->bindParam('group_id',$result_page["grpentr_id"],PDO::PARAM_STR);
			$result_count_bundle = $stmt->fetch(PDO::FETCH_NUM);

			if (isset($_GET['group2']) && $_GET['group2'] != "" && $_GET['group2'] != "overview" || $result_count_bundle[0] != 0) {
				$temp_pic = mt_rand(1,$result_count_screenshots[0]);
        $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_object_media WHERE media_groupid = :group_id AND media_order = :order AND (( media_useful_vote_value / media_useful_vote_user) > 2 OR  media_useful_vote_user < 5) ORDER BY media_useful_vote_value DESC LIMIT 1");
        $stmt->bindParam('group_id',$result_version_newest['comp_media'],PDO::PARAM_STR);
        $stmt->bindParam('order',$temp_pic,PDO::PARAM_STR);
        $stmt->execute();
				$result_screenshots= $stmt->fetch($result_version_newest['comp_media']);
		
				if ($result_screenshots['media_thumbnail']=="") {
					echo '<img src="media/screenshots/comp_default.jpg" width="250" height="188" border="0" />';
				}
				else {
					echo '<a href="'.$RSDB_intern_link_item.$result_version_newest['comp_id'].'&amp;item2=screens"><img src="media/files/picture/'.urlencode($result_screenshots['media_thumbnail']).'" width="250" height="188" border="0" alt="'.htmlentities($result_screenshots['media_description']).'" /></a>';
				}
			}
		?>
</td>
			<td width="10%" align="center" valign="top"></td>
			<td width="40%" valign="top">
<?php 
	if (isset($_GET['group2']) && ($_GET['group2'] == '' || $_GET['group2'] == 'overview')) {
?>
			  <h3 align="center">All Versions <font size="2">- Overview</font></h3>
			  <p><font size="2">A sum up of all tested versions.</font></p>
			  <span class="simple"><strong>Application</strong></span>
			  <ul class=simple>
				<li><strong>Name:</strong> <?php echo $result_page['grpentr_name']; ?></li>
				<li><strong>Vendor:</strong> <font size="2" face="Arial, Helvetica, sans-serif">
				  <?php
			
				echo '<a href="'.$RSDB_intern_link_vendor_sec.$result_entry_vendor['vendor_id'].'">'.$result_entry_vendor['vendor_name'].'</a>';
	
			  ?>
				</font></li>
				<li><strong>Description:</strong> <?php echo htmlentities($result_page['grpentr_description']); ?></li>
			  </ul>
			  <span class="simple"><strong>Compatibility</strong></span>
              <strong>&Oslash;</strong>              <ul class=simple>
				<li><strong>Award (best):</strong> <font size="2"><img src="media/icons/awards/<?php echo Award::icon($counter_awards_best); ?>.gif" alt="<?php echo Award::name($counter_awards_best); ?>" width="16" height="16" /> <?php echo Award::name($counter_awards_best); ?></font></li>
				<li><strong>Function &Oslash;:</strong>
					<?php 
				
				echo Star::drawNormal($counter_stars_function_sum, $counter_stars_user_sum, 5, "tests");
				
				?>
				</li>
				<li><strong>Install &Oslash;:</strong> <?php echo Star::drawNormal($counter_stars_install_sum, $counter_stars_user_sum, 5, "tests"); ?></li>
		      </ul>
			  <span class="simple"><strong>Application versions</strong></span>
              <ul class=simple>
		<?php
		
      $stmt=CDBConnection::getInstance()->prepare("SELECT DISTINCT(comp_appversion), comp_osversion, comp_id, comp_name FROM rsdb_item_comp WHERE comp_visible = '1' AND comp_groupid = :group_id GROUP BY comp_appversion ORDER BY comp_appversion ASC LIMIT 15") ;
      $stmt->bindParam('group_id',$result_page['grpentr_id'],PDO::PARAM_STR);
      $stmt->execute();
			while($result_entry_appver = $stmt->fetch(PDO::FETCH_ASSOC)) {
				echo "<li><b><a href=\"".$RSDB_intern_link_group_group2.$result_entry_appver['comp_appversion']."\">".$result_entry_appver['comp_name']."</a></b></li>";
			}
		
		?>
              </ul> 
		<?php 
		
			
			if ($result_count_bundle[0] != 0) {
			
		?>
			<span class="simple"><strong>Bundles</strong></span>
			<blockquote>
	            <?php  
		// Query Bundles	
		$stmt=CDBConnections::getInstance()->prepare("SELECT * FROM rsdb_group_bundles WHERE bundle_groupid = :group_id") ;
    $stmt->bindParam('group_id',$result_page["grpentr_id"],PDO::PARAM_STR);
    $stmt->execute();
		while($result_bundlelist = $stmt->fetch(PDO::FETCH_ASSOC)) {
			// Count the bundle entries for the current bundle
      $stmt_sub=CDBConnection::getInstance()->prepare("SELECT COUNT('bundle_id') FROM rsdb_group_bundles WHERE bundle_id = :bundle_id");
      $stmt_sub->bindParam('bundle_id',$result_bundlelist["bundle_id"],PDO::PARAM_STR);
      $stmt_sub->execute();
			$result_count_bundle = $stmt_sub->fetch();

			if ($result_count_bundle[0]) {

				$farbe1="#E2E2E2";
				$farbe2="#EEEEEE";
				$zaehler="0";
				echo "<table width='100%' border='0'>";
				echo "  <tr bgcolor='#5984C3'>";
				echo "	<td width='30%'><div align='center'><font color='#FFFFFF' size='2' face='Arial, Helvetica, sans-serif'><b>Name</b></font></div></td>";
				echo "	<td width='70%'><div align='center'><font color='#FFFFFF' size='2' face='Arial, Helvetica, sans-serif'><b>Description</b></font></div></td>";
				echo "  </tr>";
        $stmt_bundle=CDBConnnection::getInstance()->prepare("SELECT * FROM rsdb_group_bundles WHERE bundle_id = :bundle_id ORDER BY bundle_groupid ASC");
        $stmt_bundle->bindParam('bundle_id',$result_bundlelist["bundle_id"],PDO::PARAM_STR);
        $stmt_bundle->execute();
				while($result_bundlelist_groupitem = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $stmt_sub=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_groups WHERE grpentr_id = :group_id ORDER BY grpentr_name ASC");
          $stmt_sub->bindParam('group_id',$result_bundlelist_groupitem["bundle_groupid"],PDO::PARAM_STR);
          $stmt_sub->execute();
					$result_bundlelist_item = $stmt_sub->fetch(PDO::FETCH_ASSOC);
					echo "  <tr bgcolor='";
						$zaehler++;
						if ($zaehler == "1") {
							echo $farbe1;
							$farbe = $farbe1;
						}
						elseif ($zaehler == "2") {
							$zaehler="0";
							echo $farbe2;
							$farbe = $farbe2;
						}
					echo "'>";
					echo "	<td width='30%'><font size='2' face='Arial, Helvetica, sans-serif'>&nbsp;<b><a href='". $RSDB_intern_link_group.$result_bundlelist_item['grpentr_id'] ."'>". $result_bundlelist_item["grpentr_name"] ."</b></font></td>";
					echo "	<td width='70%'><font size='2' face='Arial, Helvetica, sans-serif'>". $result_bundlelist_item["grpentr_description"] ."</font></td>";
					echo "  </tr>";
				}
				echo "</table>";
			}
		}
	?>			
			  </blockquote>
	<?php
		}
		else {
	?>
			  <br />
	          <p>
	            <?php
					$temp_pic = mt_rand(1,$result_count_screenshots[0]);
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_object_media WHERE media_groupid = :group_id AND media_order = :order AND (( media_useful_vote_value / media_useful_vote_user) > 2 OR  media_useful_vote_user < 5) ORDER BY media_useful_vote_value DESC LIMIT 1");
          $stmt->bindParam('group_id',$result_version_newest['comp_media'],PDO::PARAM_STR);
          $stmt->bindParam('order',$temp_pic,PDO::PARAM_STR);
          $stmt->execute();
					$result_screenshots= $stmt->fetch(PDO::FETCH_ASSOC);
			
					if ($result_screenshots['media_thumbnail']=="") {
						echo '<img src="media/screenshots/comp_default.jpg" width="250" height="188">';
					}
					else {
						echo '<a href="'.$RSDB_intern_link_item.$result_version_newest['comp_id'].'&amp;item2=screens"><img src="media/files/picture/'.urlencode($result_screenshots['media_thumbnail']).'" width="250" height="188" border="0" alt="'.htmlentities($result_screenshots['media_description']).'" /></a>';
					}
			?>
	  </p>
<?php
		}
	}
	else {
		echo "<h3 align=\"center\">".$result_entry_appname['comp_name']." <font size=\"2\">- Overview</font></h3>";
?>
			<p><font size="2">A sum up of <?php echo $result_entry_appname['comp_name']; ?> tested with several ReactOS versions.</font></p>
			<span class="simple"><strong>Application</strong></span>
			<ul class=simple>
			  <li><strong>Name:</strong> <font size="2"><?php echo $result_entry_appname['comp_name']; ?></font></li>
			  <li><strong>Vendor:</strong> <font size="2" face="Arial, Helvetica, sans-serif">
				<?php
						
							echo '<a href="'.$RSDB_intern_link_vendor_sec.$result_entry_vendor['vendor_id'].'">'.$result_entry_vendor['vendor_name'].'</a>';
				
						  ?>
			  </font></li>
			  <li><strong>Description:</strong> <?php echo htmlentities($result_page['grpentr_description']); ?></li>
			</ul>
			<span class="simple"><strong>Compatibility &Oslash;</strong></span>
			<ul class=simple>
			  <li><strong>Award (best):</strong> <font size="2"><img src="media/icons/awards/<?php echo Award::icon($counter_awards_best); ?>.gif" alt="<?php echo Award::name($counter_awards_best); ?>" width="16" height="16" /> <?php echo Award::name($counter_awards_best); ?></font></li>
			  <li><strong>Function &Oslash;:</strong>
				  <?php 
							
							echo Star::drawNormal($counter_stars_function_sum, $counter_stars_user_sum, 5, "tests");
							
							?>
			  </li>
			  <li><strong>Install &Oslash;:</strong> <?php echo Star::drawNormal($counter_stars_install_sum, $counter_stars_user_sum, 5, "tests"); ?></li>
			</ul>
			  <table width="100%">
                <tr bgcolor="#5984C3">
                  <td colspan="4">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="40%"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif" size="2"><strong>&nbsp;
                                <?php
									
						echo $result_entry_appname['comp_name'];
						
					 ?>
                        </strong></font></td>
                        <td width="20%"><div align="center" class="Stil4">Medal</div></td>
                        <td width="20%"><div align="center" class="Stil4">Function</div></td>
                        <td width="20%"><div align="center" class="Stil4">Install</div></td>
                      </tr>
                    </table>
                </tr>
                <?php  
			// Table line
			$farbe1="#E2E2E2";
			$farbe2="#EEEEEE";
			$zaehler="0";
      $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp WHERE comp_groupid = :group_id AND comp_appversion = :version AND comp_visible = '1' ORDER BY comp_osversion DESC");
      $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
      $stmt->bindParam('version',$result_entry_appname['comp_appversion'],PDO::PARAM_STR);
      $stmt->execute();
			while($result_sortby_b = $stmt->fetch(PDO::FETCH_ASSOC)) { 
?>
                <tr bgcolor="<?php
									$zaehler++;
									if ($zaehler == "1") {
										echo $farbe1;
										$farbe = $farbe1;
									}
									elseif ($zaehler == "2") {
										$zaehler="0";
										echo $farbe2;
										$farbe = $farbe2;
									}
								 ?>">
                  <td width="40%" bgcolor="<?php echo $farbe; ?>">&nbsp;<?php
					
		  
					echo '<b><a href="';
					echo $RSDB_intern_link_item.$result_sortby_b['comp_id'].'">';
					
					echo "ReactOS ".show_osversion($result_sortby_b['comp_osversion']);

					echo '</a></b>';

				 ?></td>
                  <td width="20%" bgcolor="<?php echo $farbe; ?>"><font size="1">&nbsp;<img src="media/icons/awards/<?php echo Award::icon($result_sortby_b['comp_award']); ?>.gif" alt="<?php echo Award::name($result_sortby_b['comp_award']); ?>" width="16" height="16" /> <?php echo Award::name($result_sortby_b['comp_award']); ?></font></td>
                  <?php
			
				$counter_stars_install = 0;
				$counter_stars_function = 0;
				$counter_stars_user = 0;
				
				$stmt_sub=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_comp_testresults WHERE test_visible = '1' AND test_comp_id = :comp_id ORDER BY test_comp_id ASC");
        $stmt_sub->bindParam('comp_id',$result_sortby_b['comp_id'],PDO::PARAM_STR);
        $stmt_sub->execute();
				while($result_count_stars = $stmt_sub->fetch(PDO::FETCH_ASSOC)) {
					$counter_stars_install += $result_count_stars['test_result_install'];
					$counter_stars_function += $result_count_stars['test_result_function'];
					$counter_stars_user++;
				}
							
			?>
                  <td width="20%" bgcolor="<?php echo $farbe; ?>"><font size="1"><?php echo Star::drawNormal($counter_stars_function, $counter_stars_user, 5, "tests"); ?></font></td>
                  <td width="20%" bgcolor="<?php echo $farbe; ?>"><font size="1"><?php echo Star::drawNormal($counter_stars_install, $counter_stars_user, 5, "tests"); ?></font></td>
                </tr>
                <?php
			}
?>
              </table>	
<?php 
	}
?>
</td>
		  </tr>
		</table>
		<br />
		<ul>
		  <li><a href="<?php echo $RSDB_intern_link_submit_appver; ?>"><strong><font size="3">Submit new &quot;<?php echo $result_page['grpentr_name']; ?>&quot; version</font></strong></a><br />
		  Use this function to add an application and ReactOS version entry. Then you will be able to submit a compatibility test report.</li>
	    </ul>
		<p>&nbsp;</p>

	<script type="text/javascript">
	<!--
	
		function setCursor(mode) {
		  var docBody = document.getElementsByTagName("body")[0];
		  docBody.style.cursor = mode;
		}	
	
	
		var xmlhttp=false;
		/* IE 5+ only: */
		/*@cc_on @*/
			/*@if (@_jscript_version >= 5)
				try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}
		@end @*/
		
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			xmlhttp = new XMLHttpRequest();
		}
		
		function ajat_LoadText(serverPage, objID) {
			var obj = document.getElementById(objID);
			xmlhttp.open("GET", serverPage);
			xmlhttp.onreadystatechange = function() {
				setCursor('wait');
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					setCursor('auto');
					obj.innerHTML = xmlhttp.responseText;
				}
			}
			xmlhttp.send(null);
		}
		
	//-->
	</script>

	<script language="JavaScript1.2">
	 	document.getElementById('moreinfo').style.display = "block";
	  
	  
		show_Versions('<?php if (isset($_GET['sort']) && $_GET['sort'] != '') { echo "Hide"; } else { echo "Show"; } ?> all Versions <?php if (isset($_GET['sort']) && $_GET['sort'] != '') { echo "&lt;&lt;"; } else { echo "&gt;&gt;"; } ?>');
		document.getElementById('versions').style.display = '<?php if (isset($_GET['sort']) && $_GET['sort'] != '') { echo "block"; } else { echo "none"; } ?>';
		var TOCstate1 = '<?php if (isset($_GET['sort']) && $_GET['sort'] != '') { echo "block"; } else { echo "none"; } ?>';
	

	
	
		function showhideVersions()
		{
			TOCstate1 = (TOCstate1 == 'none') ? 'block' : 'none';
			document.getElementById('versions').style.display = TOCstate1;
			if(TOCstate1 == 'none') {
				show_Versions('Show all Versions &gt;&gt;');
			}
			else {
				show_Versions('Hide all Versions &lt;&lt;');
			}
		}
	</script>
	
<?php
		} // end if {$result_page['grpentr_type'] == "default"}
	}
	if (usrfunc_IsModerator($RSDB_intern_user_id)) {
	
    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_groups WHERE grpentr_visible = '1' AND grpentr_id = :group_id AND grpentr_comp = '1'") ;
    $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
    $stmt->execute();
		$result_maintainer_group =$stmt->fetchOnce(PDO::FETCH_ASSOC);

    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_categories WHERE cat_id = :cat_id AND cat_visible = '1' AND cat_comp = '1'") ;
    $stmt->bindParam('cat_id',$result_maintainer_group['grpentr_category'],PDO::PARAM_STR);
    $stmt->execute();
		$result_maintainer_group_category = $stmt->fetchOnce(PDO::FETCH_ASSOC);

    $stmt=CDBConnection::getInstance("SELECT * FROM rsdb_item_vendor WHERE vendor_id = :vendor_id AND vendor_visible = '1'");
    $stmt->bindParam('vendor_id',$result_maintainer_group['grpentr_vendor'],PDO::PARAM_STR);
    $stmt->execute();
		$result_maintainer_group_vendor = $stmt->fetchOnce(PDO::FETCH_ASSOC);


		$RSDB_referrer="";
		$RSDB_usragent="";
		$RSDB_ipaddr="";
		if (array_key_exists('HTTP_REFERER', $_SERVER)) $RSDB_referrer=htmlspecialchars($_SERVER['HTTP_REFERER']);
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) $RSDB_usragent=htmlspecialchars($_SERVER['HTTP_USER_AGENT']);
		if (array_key_exists('REMOTE_ADDR', $_SERVER)) $RSDB_ipaddr=htmlspecialchars($_SERVER['REMOTE_ADDR']);

		$RSDB_TEMP_pmod = "";
		$RSDB_TEMP_txtreq1 = "";
		$RSDB_TEMP_txtreq2 = "";
		$RSDB_TEMP_txtspam = "";
		$RSDB_TEMP_verified = "";
		$RSDB_TEMP_appgroup = "";
		$RSDB_TEMP_description = "";
		$RSDB_TEMP_category = "";
		$RSDB_TEMP_vendor = "";
		if (array_key_exists("pmod", $_POST)) $RSDB_TEMP_pmod=htmlspecialchars($_POST["pmod"]);
		if (array_key_exists("txtreq1", $_POST)) $RSDB_TEMP_txtreq1=htmlspecialchars($_POST["txtreq1"]);
		if (array_key_exists("txtreq2", $_POST)) $RSDB_TEMP_txtreq2=htmlspecialchars($_POST["txtreq2"]);
		if (array_key_exists("txtspam", $_POST)) $RSDB_TEMP_txtspam=htmlspecialchars($_POST["txtspam"]);
		if (array_key_exists("verified", $_POST)) $RSDB_TEMP_verified=htmlspecialchars($_POST["verified"]);
		if (array_key_exists("appgroup", $_POST)) $RSDB_TEMP_appgroup=htmlspecialchars($_POST["appgroup"]);
		if (array_key_exists("description", $_POST)) $RSDB_TEMP_description=htmlspecialchars($_POST["description"]);
		if (array_key_exists("category", $_POST)) $RSDB_TEMP_category=htmlspecialchars($_POST["category"]);
		if (array_key_exists("vendor", $_POST)) $RSDB_TEMP_vendor=htmlspecialchars($_POST["vendor"]);


		// Edit application group data:
		if ($RSDB_TEMP_pmod == "ok" && $RSDB_SET_group != "" && $RSDB_TEMP_appgroup != "" && $RSDB_TEMP_description != "" && $RSDB_TEMP_category != "" && $RSDB_TEMP_vendor != "" && usrfunc_IsModerator($RSDB_intern_user_id)) {
			// Update group entry:
      $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_groups SET grpentr_name = :new_name, grpentr_category = :new_category, grpentr_vendor = :new_vendor, grpentr_description = :new_description WHERE grpentr_id = :group_id");
      $stmt->bindParam('new_name',$RSDB_TEMP_appgroup,PDO::PARAM_STR);
      $stmt->bindParam('new_category',$RSDB_TEMP_category,PDO::PARAM_STR);
      $stmt->bindParam('new_vendor',$RSDB_TEMP_vendor,PDO::PARAM_STR);
      $stmt->bindParam('new_description',$RSDB_TEMP_description,PDO::PARAM_STR);
      $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
      $stmt->execute();

			// Update related item entries:
      $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_item_comp SET comp_name = :new_name WHERE comp_groupid=:group_id");
      $stmt->bindValue('new_name',$RSDB_TEMP_appgroup.substr($result_group_update['comp_name'], strlen($result_maintainer_group['grpentr_name']) ),PDO::PARAM_STR);
      $stmt->bindParam('group_id',$result_maintainer_group['grpentr_id'],PDO::PARAM_STR);
      $stmt->execute();

			CLog::add("low", "comp_group", "edit", "[App Group] Edit entry", @usrfunc_GetUsername($RSDB_intern_user_id)." changed the group data from: \n\nName: ".htmlentities($result_maintainer_group['grpentr_name'])." \n\nDescription: ".htmlentities($result_maintainer_group['grpentr_description'])." \n\nCategory: ".$result_maintainer_group_category['cat_name']."\n\nVendor: ".$result_maintainer_group_vendor['vendor_name']." \n\n\nTo: \n\nName: ".htmlentities($RSDB_TEMP_appgroup)."\n\nDesc: ".htmlentities($RSDB_TEMP_description)." \n\nCategory: ".htmlentities($RSDB_TEMP_category)." \n\nVendor: ".htmlentities($RSDB_TEMP_vendor), "0");
			?>
			<script language="JavaScript">
				window.setTimeout('window.location.href="<?php echo $RSDB_intern_link_group_group2_both_javascript; ?>"','500')
			</script>
			<?php
		}

		// Special request:
		if ($RSDB_TEMP_pmod == "ok" && $RSDB_TEMP_txtreq1 != "" && $RSDB_TEMP_txtreq2 != "" && usrfunc_IsModerator($RSDB_intern_user_id)) {
			$stmt=CDBConnection::getInstance()->prepare("INSERT INTO rsdb_logs ( log_id, log_date, log_usrid, log_usrip, log_level, log_action, log_title, log_description, log_category, log_badusr, log_referrer, log_browseragent, log_read, log_taskdone_usr) VALUES ('', NOW(), :user_id, :ip, 'low', 'request', :title, :description, 'user_moderator', '0', :referrer, :user_agent, ';', '0')");
      $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_STR);
      $stmt->bindParam('ip',$RSDB_ipaddr,PDO::PARAM_STR);
      $stmt->bindParam('title',$RSDB_TEMP_txtreq1,PDO::PARAM_STR);
      $stmt->bindParam('description',$RSDB_TEMP_txtreq2,PDO::PARAM_STR);
      $stmt->bindParam('referrer',$RSDB_referrer,PDO::PARAM_STR);
      $stmt->bindParam('user_agent',$RSDB_usragent,PDO::PARAM_STR);
      $stmt->execute();
		}
		// Report spam:
		if ($RSDB_TEMP_pmod == "ok" && $RSDB_TEMP_txtspam != "" && usrfunc_IsModerator($RSDB_intern_user_id)) {
      $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_groups SET grpentr_visible = '3' WHERE grpentr_id = :group_id");
      $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
      $stmt->execute();
			CLog::add("low", "comp_group", "report_spam", "[App Group] Spam/ads report", @usrfunc_GetUsername($RSDB_intern_user_id)." wrote: \n".htmlentities($RSDB_TEMP_txtspam)." \n\n\n\nUser: ".@usrfunc_GetUsername($result_maintainer_group['grpentr_usrid'])." - ".$result_maintainer_group['grpentr_usrid']."\n\nAppName: ".htmlentities($result_maintainer_group['grpentr_name'])." - ".$result_maintainer_group['grpentr_id']."\n\nDesc: ".htmlentities($result_maintainer_group['grpentr_description'])." \n\nCategory: ".$result_maintainer_group_category['cat_name']." \n\nVendor: ".$result_maintainer_group_vendor['vendor_name'], $result_maintainer_group['grpentr_usrid']);
		
		}
		// Verified:
		if ($result_maintainer_group['grpentr_checked'] == "no") {
			$temp_verified = "1";
		}
		else if ($result_maintainer_group['grpentr_checked'] == "1") {
			$temp_verified = "yes";
		}
		if ($result_maintainer_group['grpentr_checked'] == "1" || $result_maintainer_group['grpentr_checked'] == "no") {
			if ($RSDB_TEMP_pmod == "ok" && $RSDB_TEMP_verified == "done" && usrfunc_IsModerator($RSDB_intern_user_id)) {
				$stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_groups SET grpentr_checked = :checked WHERE grpentr_id = :group_id");
        $stmt->bindParam('checked',$temp_verified,PDO::PARAM_STR);
        $stmt->bindParam('group_id',$RSDB_SET_group,PDO::PARAM_STR);
				$stmt->execute();
				CLog::add("low", "comp_group", "verified", "[App Group] Verified", @usrfunc_GetUsername($RSDB_intern_user_id)." has verified the following app group: \n\n\n\nUser: ".@usrfunc_GetUsername($result_maintainer_group['grpentr_usrid'])." - ".$result_maintainer_group['grpentr_usrid']."\n\nAppName: ".htmlentities($result_maintainer_group['grpentr_name'])." - ".$result_maintainer_group['grpentr_id']."\n\nDesc: ".htmlentities($result_maintainer_group['grpentr_description'])." \n\nCategory: ".$result_maintainer_group_category['cat_name']." \n\nVendor: ".$result_maintainer_group_vendor['vendor_name'], "0");
			}
		}
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="maintainer">
	  <tbody>
		<tr>
		  <td><p><b><a name="maintainerbar"></a>Maintainer: </b>
			  <?php if ($result_maintainer_group['grpentr_checked'] != "yes") { ?><a href="javascript:Show_verify()">Verify entry</a> | <?php  } ?><?php /*<strike><a href="javascript:Show_medal()">Change award symbol</a></strike> | */ ?><a href="javascript:Show_groupentry()">Edit application data</a> | <a href="javascript:Show_spam()">Report spam/ads</a> | <a href="<?php echo $RSDB_intern_link_submit_appver; ?>">Add Version</a> | <a href="javascript:Show_addbundle()">Add to Bundle</a> | <a href="javascript:Show_requests()">Special requests</a></p>
		    <div id="groupentry" style="display: block">
			<fieldset><legend>Edit application data</legend>
				<div align="left">
				  <form name="form1" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#maintainerbar"; ?>">
				      <font size="2">Application group name: 
				      <input name="appgroup" type="text" id="appgroup" value="<?php echo $result_maintainer_group['grpentr_name']; ?>" size="40" maxlength="100">
				      (changing this field will affect all version entries too!) <br>
				      <br>
				      Application description:
                      <input name="description" type="text" id="description" value="<?php echo $result_maintainer_group['grpentr_description']; ?>" size="70" maxlength="255">
				      (max. 255 chars) <br>
				      <br>
				      Category: 
						<select name="category" id="category">
					      <option value="0">Please select a category</option>
					      <?php 
						  $RSDB_intern_selected = $result_maintainer_group['grpentr_category'];
						  $stmt=CDBConnection::getInstance()->prepare("SELECT COUNT(*) FROM rsdb_categories WHERE cat_visible = '1' AND cat_path = '0' AND cat_comp = '1'");
$stmt->execute();
$result_count_cat = $stmt->fetchOnce(PDO::FETCH_ASSOC);

// Update the ViewCounter:
if (!empty($_GET['cat'])) {
  $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_categories SET cat_viewcounter = (cat_viewcounter + 1) WHERE cat_id = :cat_id");
  $stmt->bindParam('cat_id',@$_GET['cat'],PDO::PARAM_STR);
  $stmt->execute();
}

if ($result_count_cat[0]) {


	

    $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_categories WHERE cat_visible = '1' AND cat_path = :cat_path AND cat_comp = '1' ORDER BY cat_name ASC");
    $stmt->bindParam('cat_path',@$_GET['cat'],PDO::PARAM_STR);
    $stmt->execute();
		
		
			$cellcolor1="#E2E2E2";
			$cellcolor2="#EEEEEE";
			$cellcolorcounter="0";
			
		while($result_treeview = $stmt->fetch(PDO::FETCH_ASSOC)) { // TreeView
			echo "<option value=\"". $result_treeview['cat_id']. "\"";
			if ($RSDB_intern_selected != "" && $RSDB_intern_selected == $result_treeview['cat_id']) {
				echo " selected "; 
			}		
			echo ">+ ". $result_treeview['cat_name'] ."</option>\n\n";
	
			$RSDB_TEMP_cat_path = $result_treeview['cat_path'];
			$RSDB_TEMP_cat_id = $result_treeview['cat_id'];
			$RSDB_TEMP_cat_level=0;
			
			$RSDB_TEMP_cat_current_id_guess=$RSDB_TEMP_cat_id;
	
			Category::showTree($RSDB_TEMP_cat_path, $RSDB_TEMP_cat_id, $RSDB_TEMP_cat_level, $RSDB_TEMP_cat_level, true);
	
		}	// end while
} ?>
					  </select>
						<font size="1">				        [<?php echo $result_maintainer_group_category['cat_name']; ?>]</font><br>
				        <br>
				      Vendor:
						<select name="vendor" id="vendor">
						    <option value="0">Please select a vendor</option>
						<?php
						$RSDB_intern_selected = $result_maintainer_group['grpentr_vendor'];
						
  $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_item_vendor ORDER BY `vendor_name` ASC");
  $stmt->execute();

	$zaehler="0";
	
	
	
	while($result_page = $stmt->fetch(PDO::FETCH_ASSOC)) { // Pages
		echo "<option value=\"". $result_page['vendor_id'] ."\"";
		if ($RSDB_intern_selected != "" && $RSDB_intern_selected == $result_page['vendor_id']) {
			echo " selected "; 
		}		
		echo ">". $result_page['vendor_name']."</option>"; 
	}	// end while ?>
					  </select>
						<font size="1">						[<?php echo $result_maintainer_group_vendor['vendor_name']; ?>]</font>
						<input name="pmod" type="hidden" id="pmod" value="ok">
					  </font>
				      <p><font size="2"><em>All fields are requiered!</em></font></p>
				      <font size="2">
				      <input type="submit" name="Submit" value="Save">	
			          </font>				  
				  </form>
				</div>
			</fieldset>
		</div>
		<div id="medal" style="display: block">
			<fieldset><legend>Change award symbol</legend>
				<div align="left">
				  <p><font size="2">Please read the <a href="<?php echo $RSDB_intern_link_db_sec; ?>help#sym" target="_blank">FAQ &amp; Help page</a> about the award/medal symbols before you change something!</font></p>
				  <p>
				  <form name="form3" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#maintainerbar"; ?>">
				    <p>
				      <font size="2">
				      <select name="medal" id="medal">
				          <option value="10">Platinum</option>
				          <option value="9">Gold</option>
				          <option value="8">Silver</option>
				          <option value="7">Bronze</option>
				          <option value="5">Honorable Mention</option>
				          <option value="0">Untested</option>
				          <option value="2">Known not to work</option>
	                  </select>
                      </font> </p>
				    <p>
				      <input type="submit" name="Submit3" value="Save">
	                </p>
				  </form>
				 </p>
				</div>
			</fieldset>
		</div>
		<div id="verify" style="display: block">
			<fieldset><legend>Verify entry</legend>
				<div align="left">
				  <p><font size="2">User &quot;<?php echo @usrfunc_GetUsername($result_maintainer_group['grpentr_usrid']); ?>&quot; has submitted this application group on &quot;<?php echo $result_maintainer_group['grpentr_date']; ?>&quot;. </font></p>
				  <p><font size="2"><strong>Application group name:</strong> <?php echo htmlentities($result_maintainer_group['grpentr_name']); ?><br>
		          <br>
			        <strong>Description:</strong>			      <?php if ($result_maintainer_group['grpentr_description']) { echo htmlentities($result_maintainer_group['grpentr_description']); } else { echo '""'; } ?>
			      <br>
		          <br>
			        <strong>Category:</strong>			      <?php 
					
						echo htmlentities($result_maintainer_group_category['cat_name']);
					
					 ?>
		          <br>
		          <br>
			        <strong>Vendor:</strong>			      <?php 
					
						echo htmlentities($result_maintainer_group_vendor['vendor_name']);
					
					 ?>
				  </font></p>
				  <p><font size="2">			        Please verify the data and choose one of the three available options below:</font></p>
				  <form name="form2" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#maintainerbar"; ?>">
				  <ul>
				    <li><font size="2"><a href="javascript:Show_spam()"><strong>Report spam/ads</strong></a></font></li>
				  </ul>
				  <ul>
				    <li><font size="2"><a href="javascript:Show_groupentry()"><strong>Correct/edit data</strong></a></font></li>
				  </ul>
				  <ul>
			        <li>
			            <font size="2">
			            <input type="submit" name="Submit2" value="I have verified the data and everything is okay!">
						<input name="pmod" type="hidden" id="pmod" value="ok">
                        <input name="verified" type="hidden" id="verified" value="done">
						</font> </li>
				  </ul>
	              </form> 
				</div>
			</fieldset>
		</div>
		<div id="spam" style="display: block">
			<fieldset>
			<legend>Report spam/ads</legend>
				<div align="left">
				  <form name="form4" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#maintainerbar"; ?>">
				    <p><font size="2">Please write a useful description:<br> 
			          <textarea name="txtspam" cols="70" rows="5" id="txtspam"></textarea>
</font><font size="2" face="Arial, Helvetica, sans-serif">
<input name="pmod" type="hidden" id="pmod" value="ok">
</font><font size="2">                    </font></p>
				    <p><font size="2"><strong>Note:</strong><br>
			        When you click on the submit button, the application group will get immediately invisible, and the user who submitted this entry a bad mark. If a user has some bad marks, he will not be able to submit anything for a certain periode.<br>
			        Only administrators can revert this task, so if you made a mistake use the <a href="javascript:Show_requests()">Special requests</a> function.</font></p>
				    <p>
				      <input type="submit" name="Submit4" value="Submit">
	                </p>
				  </form>
				</div>
			</fieldset>
		</div>
		<div id="addbundle" style="display: block">
			<fieldset><legend>Add to bundle</legend>
				<div align="left">
				  <p><font size="2">This interface is currently not available!</font></p>
				  <p><font size="2">Ask a admin to do that task for the meanwhile: <a href="javascript:Show_requests()">Special requests</a></font></p>
				</div>
			</fieldset>
		</div>
		<div id="requests" style="display: block">
			<fieldset><legend>Special requests</legend>
				<div align="left">
				  <form name="form4" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#maintainerbar"; ?>">
				    <p><font size="2">Message title:<br> 
		            <input name="txtreq1" type="text" id="txtreq1" size="40" maxlength="100">
				    </font></p>
				    <p><font size="2">Text:<br> 
		              <textarea name="txtreq2" cols="70" rows="5" id="txtreq2"></textarea>
</font><font size="2" face="Arial, Helvetica, sans-serif">
<input name="pmod" type="hidden" id="pmod" value="ok">
</font><font size="2">                    </font></p>
				    <p><font size="2"><strong>Note:</strong><br>
			        Please do NOT misuse this function. All administrators will be able to see your message and one of them may contact you per forum private message, email or just do the task you suggested/requested.</font></p>
				    <p><font size="2">If you want to ask something, or the task needs (in all the circumstances) a feedback,  use the website forum, the #reactos-web IRC channel, the mailing list or the forum private message system instead. </font></p>
				    <p><font size="2">This form is not a bug tracking tool nor a feature request function! Use <a href="http://www.reactos.org/bugzilla/">bugzilla</a> for such things instead!</font></p>
				    <p><font size="2"><strong>A sample usage for this form:</strong><br>
			        If you need a new category which doesn't exist, then write a request and one of the admins will read it and may add the missing category. Then you will be able to move this application group to the right category (if you have placed the application somewhere else temporary).</font></p>
				    <p>
				      <font size="2">
				      <input type="submit" name="Submit4" value="Submit">
                      </font> </p>
				  </form>
				</div>
			</fieldset>
		</div>
		  </td>
		</tr>
	  </tbody>
	</table>
	<script language="JavaScript1.2">

		document.getElementById('groupentry').style.display = 'none';
		document.getElementById('medal').style.display = 'none';
		document.getElementById('verify').style.display = 'none';
		document.getElementById('spam').style.display = 'none';
		document.getElementById('addbundle').style.display = 'none';
		document.getElementById('requests').style.display = 'none';
	
		function Show_groupentry()
		{
			document.getElementById('groupentry').style.display = (document.getElementById('groupentry').style.display == 'none') ? 'block' : 'none';
			document.getElementById('medal').style.display = 'none';
			document.getElementById('verify').style.display = 'none';
			document.getElementById('spam').style.display = 'none';
			document.getElementById('addbundle').style.display = 'none';
			document.getElementById('requests').style.display = 'none';
		}
		
		function Show_medal()
		{
			document.getElementById('groupentry').style.display = 'none';
			document.getElementById('medal').style.display = (document.getElementById('medal').style.display == 'none') ? 'block' : 'none';
			document.getElementById('verify').style.display = 'none';
			document.getElementById('spam').style.display = 'none';
			document.getElementById('addbundle').style.display = 'none';
			document.getElementById('requests').style.display = 'none';
		}
		
		function Show_verify()
		{
			document.getElementById('groupentry').style.display = 'none';
			document.getElementById('medal').style.display = 'none';
			document.getElementById('verify').style.display = (document.getElementById('verify').style.display == 'none') ? 'block' : 'none';
			document.getElementById('spam').style.display = 'none';
			document.getElementById('addbundle').style.display = 'none';
			document.getElementById('requests').style.display = 'none';
		}

		function Show_spam()
		{
			document.getElementById('groupentry').style.display = 'none';
			document.getElementById('medal').style.display = 'none';
			document.getElementById('verify').style.display = 'none';
			document.getElementById('spam').style.display = (document.getElementById('spam').style.display == 'none') ? 'block' : 'none';
			document.getElementById('addbundle').style.display = 'none';
			document.getElementById('requests').style.display = 'none';
		}
		
		function Show_addbundle()
		{
			document.getElementById('groupentry').style.display = 'none';
			document.getElementById('medal').style.display = 'none';
			document.getElementById('verify').style.display = 'none';
			document.getElementById('spam').style.display = 'none';
			document.getElementById('addbundle').style.display = (document.getElementById('addbundle').style.display == 'none') ? 'block' : 'none';
			document.getElementById('requests').style.display = 'none';
		}


		function Show_requests()
		{
			document.getElementById('groupentry').style.display = 'none';
			document.getElementById('medal').style.display = 'none';
			document.getElementById('verify').style.display = 'none';
			document.getElementById('spam').style.display = 'none';
			document.getElementById('addbundle').style.display = 'none';
			document.getElementById('requests').style.display = (document.getElementById('requests').style.display == 'none') ? 'block' : 'none';
		}

	</script>
<?php
	}
?>

<br />

<?php
	if (usrfunc_IsAdmin($RSDB_intern_user_id)) {
	
		$RSDB_TEMP_padmin = "";
		$RSDB_TEMP_done = "";
		if (array_key_exists("padmin", $_POST)) $RSDB_TEMP_padmin=htmlspecialchars($_POST["padmin"]);
		if (array_key_exists("done", $_POST)) $RSDB_TEMP_done=htmlspecialchars($_POST["done"]);
		
		if ($RSDB_TEMP_padmin == "ok" && $RSDB_TEMP_done != "" && usrfunc_IsAdmin($RSDB_intern_user_id)) {
      $stmt=CDBConnection::getInstance()->prepare("UPDATE rsdb_logs SET log_taskdone_usr = :user_id WHERE log_id = :log_id");
      $stmt->bindParam('user_id',$RSDB_intern_user_id,PDO::PARAM_STR);
      $stmt->bindParam('log_id',$RSDB_TEMP_done,PDO::PARAM_STR);
      $stmt->execute();
		}
		
?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="admin">
	  <tr>
		<td><b><a name="adminbar"></a>Admin: </b><a href="javascript:Show_readrequests()">Read special requests</a> | <font size="1">all other functions are under construction ...
        </font>
		<div id="readrequests" style="display: block">
			<fieldset><legend>Read special requests</legend>

 <table width="100%" border="1">  
    <tr><td width="10%"><div align="center"><font color="#000000"><strong><font size="2" face="Arial, Helvetica, sans-serif">Date</font></strong></font></div></td> 
    <td width="10%"><div align="center"><font color="#000000"><strong><font size="2" face="Arial, Helvetica, sans-serif">User</font></strong></font></div></td> 
    <td width="25%"><div align="center"><font color="#000000"><strong><font size="2" face="Arial, Helvetica, sans-serif">Title</font></strong></font></div></td> 
    <td width="45%"><div align="center"><font color="#000000"><strong><font size="2" face="Arial, Helvetica, sans-serif">Request</font></strong></font></div></td> 
    <td width="10%"><div align="center"><font color="#000000"><strong><font size="2" face="Arial, Helvetica, sans-serif">Done?</font></strong></font></div></td>
    </tr> <?php
					$cellcolor1="#E2E2E2";
					$cellcolor2="#EEEEEE";
					$cellcolorcounter="0";
          $stmt=CDBConnection::getInstance()->prepare("SELECT * FROM rsdb_logs WHERE log_level LIKE 'low' AND log_action LIKE 'request' AND log_category LIKE 'user_moderator' ORDER BY log_date DESC LIMIT 30") ;
          $stmt->execute();
					while($result_entry_sprequest = $stmt->fetch()) {
				?> 
  <tr valign="top" bgcolor="<?php
					$cellcolorcounter++;
					if ($cellcolorcounter == "1") {
						echo $cellcolor1;
						$color = $cellcolor1;
					}
					elseif ($cellcolorcounter == "2") {
						$cellcolorcounter="0";
						echo $cellcolor2;
						$color = $cellcolor2;
					}
				 ?>"> 
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "<strike>"; } echo $result_entry_sprequest['log_date'];  if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "</strike>"; } ?></font></div></td> 
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "<strike>"; } echo @usrfunc_GetUsername($result_entry_sprequest['log_usrid']); if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "</strike>"; } ?></font></div></td> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "<strike>"; } echo htmlentities($result_entry_sprequest['log_title']); if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "</strike>"; } ?></font></td> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "<strike>"; } echo wordwrap(nl2br(htmlentities($result_entry_sprequest['log_description'], ENT_QUOTES))); if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo "</strike>"; } ?></font></td> 
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($result_entry_sprequest['log_taskdone_usr'] != 0) { echo @usrfunc_GetUsername($result_entry_sprequest['log_taskdone_usr']); } 
		
		else {
	?>
        <form name="form5" method="post" action="<?php echo $RSDB_intern_link_group_group2_both."#adminbar"; ?>">
          <input type="submit" name="Submit5" value="Done!">
          <input name="padmin" type="hidden" id="padmin" value="ok">
          <font size="2" face="Arial, Helvetica, sans-serif">
          <input name="done" type="hidden" id="done" value="<?php echo $result_entry_sprequest['log_id']; ?>">
          </font>
        </form>
    <?php
		}
	
	 ?>
        </font></div></td>
  </tr> 
	<?php
		}
	?> 
</table>

			</fieldset>
		</div>		</td>
	  </tr>
	</table>
	<script language="JavaScript1.2">

		document.getElementById('readrequests').style.display = 'none';
	
		function Show_readrequests()
		{
			document.getElementById('readrequests').style.display = (document.getElementById('readrequests').style.display == 'none') ? 'block' : 'none';
		}
	</script>
<?php
	}
  } // end of member function body

}
?>
		
