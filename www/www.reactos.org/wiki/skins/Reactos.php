<?php
/**
* Reactos skin for Mediawiki >= 1.15
*
* @file
* @ingroup Skins
*/

if (!defined('MEDIAWIKI'))
die(-1);

/**
* Inherit main code from SkinTemplate, set the CSS and template filter.
*
* @ingroup Skins
*/
class SkinReactos extends SkinTemplate {
	var $useHeadElement = true;
	
	function initPage(OutputPage $out)
	{
		parent::initPage($out);
		$this->skinname = 'reactos';
		$this->stylename = 'reactos';
		$this->template = 'ReactosTemplate';
	}
	function setupSkinUserCss(OutputPage $out)
	{
		global $wgHandheldStyle;
		parent::setupSkinUserCss($out);
		// Append to the default screen common & print styles...
		$out->addStyle('reactos/main.css', 'screen');
	}
}

/**
*

* @ingroup Skins
*/
class ReactosTemplate extends QuickTemplate {
	/**
	* Template filter callback for this skin.
	* Takes an associative array of data set from a SkinTemplate-based
	* class, and a wrapper for MediaWiki's localization database, and
	* outputs a formatted page.
	*/
	public function execute()
	{
		global $wgRequest;
		
		$skin = $this->data['skin'];
		// suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();
		
		$this->html('headelement');
		
		?>
		
		<!-- heading -->
		<div id="mw_header"></div>
		<div id="reactos_bar">

		<a href="http://www.reactos.org/?page=index">Home</a> <span style="color: #ffffff">|</span>
		<a href="http://www.reactos.org/?page=about">Info</a> <span style="color: #ffffff">|</span>
		
		<a href="http://www.reactos.org/?page=community">Community</a> <span style="color: #ffffff">|</span>
		<a href="http://www.reactos.org/?page=dev">Development</a> <span style="color: #ffffff">|</span>

		<a href="http://www.reactos.org/roscms/?page=user">myReactOS</a> <span style="color: #ffffff">|</span>
		<a href="http://www.reactos.org/?page=contact">Contact Us</a>
	
		</div>
		<div id="mw_main">
		
		<div id="mw_contentwrapper">
		<!-- navigation portlet -->

		
		<div id="p-cactions" class="portlet">
		<h5><?php $this->msg('views'); ?></h5> 
        
		<div class="pBody">
		<ul><?php
	
		foreach($this->data['content_actions'] as $key => $tab) {
		
			echo '<li id="ca-'. $key .'"';
			
			if (!empty($tab['class'])) {
				echo ' class="'. htmlspecialchars($tab['class']). '"';
			}
			
			echo '><a href="'. htmlspecialchars($tab['href']). '">';
			
			echo htmlspecialchars($tab['text']);
			
			echo '</li>';
		}  
        

		?>

		</ul>
		</div>
		</div> <!-- content -->
		<div id="mw_content">
		<!-- contentholder does nothing by default, but it allows users to style the text inside
		the content area without affecting the meaning of 'em' in #mw_content, which is used
		for the margins -->
		<div id="mw_contentholder">
		
		
		<div id="contentSub"<?php $this->html('userlangattributes') ?>>

		<h1 id="firstHeading"><?php $this->html('title') ?></h1>
		<?php $this->html('subtitle') ?></div>
		
		<?php if ($this->data['undelete']) {
		?><div id="contentSub2"><?php $this->html('undelete') ?></div><?php }
		?>

		<?php if ($this->data['showjumplinks']) {
		?><div id="jump-to-nav"><?php $this->msg('jumpto') ?> <a href="#mw_portlets"><?php $this->msg('jumptonavigation') ?></a>, <a href="#searchInput"><?php $this->msg('jumptosearch') ?></a></div><?php }
		?>
		
		<?php $this->html('bodytext') ?>

		<div class='mw_clear'></div>
		<?php if ($this->data['catlinks']) {
			$this->html('catlinks');
		}
		?>
		<?php $this->html ('dataAfterContent') ?>
		</div><!-- mw_contentholder -->
		</div><!-- mw_content -->

		</div><!-- mw_contentwrapper -->
		
		<div id="mw_portlets"<?php $this->html("userlangattributes") ?>>
		
		<!-- portlets -->
		
		<?php foreach($this->data['sidebar'] as $bar => $cont) {
			?>
			<div class='portlet' id='p-<?php echo Sanitizer::escapeId($bar) ?>'<?php echo $skin->tooltip('p-' . $bar) ?>>
			<?if(!empty($cont)) echo "<h5>". wfMsg($bar) ."</h5>"; else continue;?>
			<div class='pBody'>

			<ul>
			<?php foreach($cont as $key => $val) {
				?>
				<li id="<?php echo Sanitizer::escapeId($val['id']) ?>"<?php
				if ($val['active']) {
				?> class="active" <?php }

				?>><a href="<?php echo htmlspecialchars($val['href']) ?>"><?php echo htmlspecialchars($val['text']) ?></a></li>
			<?php }
			?>

			</ul>
			</div>
			</div>
		<?php }
		?>
		<!-- search -->
		<div id="p-search" class="portlet">
		<h5><label for="searchInput"><?php $this->msg('search') ?></label></h5>

		<div id="searchBody" class="pBody">
		<form action="<?php $this->text('searchaction') ?>" id="searchform"><div>
		<input id="searchInput" name="search" type="text"
		<?if (isset($this->data['search'])) {
			
		?> value="<?php $this->text('search') ?>"<?php }
		?> />

		<input type='submit' name="go" class="searchButton" id="searchGoButton" value="<?php $this->msg('searcharticle'); ?>" />&nbsp;
		<input type='submit' name="fulltext" class="searchButton" id="mw-searchButton" value="<?php $this->msg('searchbutton'); ?>" />

		</div></form>
		</div>
		</div>&nbsp;</div>
		
		<!-- mw_portlets -->
		
		  <div class="portlet" id="p-tb">
                <h5><?php $this->msg('toolbox') ?></h5>
                <div class="pBody">
                        <ul>
<?php
                if( $this->data['notspecialpage'] ) { ?>
                                <li id="t-whatlinkshere"><a href="<?php
                                echo htmlspecialchars($this->data['nav_urls']['whatlinkshere']['href'])
                                ?>"><?php $this->msg('whatlinkshere') ?></a></li>
<?php
                        if( $this->data['nav_urls']['recentchangeslinked'] ) { ?>
                                <li id="t-recentchangeslinked"><a href="<?php
                                echo htmlspecialchars($this->data['nav_urls']['recentchangeslinked']['href'])
                                ?>"><?php $this->msg('recentchangeslinked') ?></a></li>
<?php               }
                }
                if( isset( $this->data['nav_urls']['trackbacklink'] ) ) { ?>
                        <li id="t-trackbacklink"><a href="<?php
                                echo htmlspecialchars($this->data['nav_urls']['trackbacklink']['href'])
                                ?>"><?php $this->msg('trackbacklink') ?></a></li>
<?php       }
                if( $this->data['feeds'] ) { ?>
                        <li id="feedlinks"><?php foreach($this->data['feeds'] as $key => $feed) {
                                        ?><span id="feed-<?php echo Sanitizer::escapeId($key) ?>"><a href="<?php
                                        echo htmlspecialchars($feed['href']) ?>"><?php echo htmlspecialchars($feed['text'])?></a>&nbsp;</span>
                                        <?php } ?></li><?php
                }
 
                foreach( array( 'contributions', 'blockip', 'emailuser', 'upload', 'specialpages' ) as $special ) {
 
                        if( $this->data['nav_urls'][$special] ) {
                                ?><li id="t-<?php echo $special ?>"><a href="<?php echo htmlspecialchars($this->data['nav_urls'][$special]['href'])
                                ?>"><?php $this->msg($special) ?></a></li>
            <?php               }
                }
 
                if( !empty( $this->data['nav_urls']['print']['href'] ) ) { ?>
                                <li id="t-print"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['print']['href'])
                                ?>"><?php $this->msg('printableversion') ?></a></li><?php
                }
 
                if( !empty( $this->data['nav_urls']['permalink']['href'] ) ) { ?>
                                <li id="t-permalink"><a href="<?php echo htmlspecialchars($this->data['nav_urls']['permalink']['href'])
                                ?>"><?php $this->msg('permalink') ?></a></li><?php
                } elseif( $this->data['nav_urls']['permalink']['href'] === '' ) { ?>
                                <li id="t-ispermalink"<?php echo $skin->tooltip('t-ispermalink') ?>><?php $this->msg('permalink') ?></li><?php
                }
 
                wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this ) );
                ?>
                        </ul>
                </div>
        </div>
		</div><!-- main -->
		
		<div class="mw_clear"></div>
		
		<!-- personal portlet -->

<div class="portlet" id="p-personal">
        <h5><?php $this->msg('personaltools') ?></h5> <!-- User Toolbar Label/Caption [optional] -->
        <div class="pBody">
                <ul>
<?php                   foreach( $this->data['personal_urls'] as $key => $item ) { ?>
                                <li id="pt-<?php echo $key ?>"<?php
                                        if ($item['active']) { ?> class="active"<?php } ?>>
                                <a href="<?php
                                echo htmlspecialchars( $item['href'] ) ?>"<?php
                                if( !empty( $item['class'] ) ) { ?> class="<?php
                                echo htmlspecialchars( $item['class'] ) ?>"<?php } ?>>
                                <?php
                                echo htmlspecialchars( $item['text'] ) ?></a></li>
<?php                       } ?>
                </ul>
        </div>
</div>
</div>
</div>
		
<div class="mw_clear"></div>	
		<!-- footer -->
<div id="footer">

      <?php if ( $this->data['copyrightico'] ) { ?>
        <div id="f-copyrightico" style="float: left;"><?php $this->html('copyrightico') ?></div>
<?php
        if ( $this->data['poweredbyico'] ) { ?>
        <div id="f-poweredbyico" style="float: right;"><?php $this->html('poweredbyico') ?></div>
<?php       }  ?>

<?php       }
        // generate additional footer links
        $footerlinks = array(
                'lastmod', 'viewcount', 'numberofwatchingusers', 'credits', 'copyright',
                'privacy', 'about', 'disclaimer', 'tagline',
        );
?><br />
        <ul id="f-list">
<?php
        foreach ( $footerlinks as $aLink ) {
                if ( isset( $this->data[$aLink] ) && $this->data[$aLink] ) {
?>          <li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php               }
        }
?>
        </ul>
</div>
		<div class='mw-topboxes'>

		<div id="mw-js-message" style="display:none;"<?php $this->html('userlangattributes')?>></div>
		<div class="mw-topbox" id="siteSub"><?php $this->msg('tagline') ?></div>
		<?php if ($this->data['newtalk']) {

			?><div class="usermessage mw-topbox"><?php $this->html('newtalk') ?></div>
		<?php }
		?>
		<?php if ($this->data['sitenotice']) {

			?><div class="mw-topbox" id="siteNotice"><?php $this->html('sitenotice') ?></div>

		<?php }
		?>
		</div>
	<!-- scripts and debugging information -->
<?php $this->html('bottomscripts'); /* JS call to runBodyOnloadHook */ ?>
<?php $this->html('reporttime') ?>
<?php if ( $this->data['debug'] ): ?>
<!-- Debug output:
<?php $this->text( 'debug' ); ?>
 
-->
<?php endif; ?>
</body>
</html>
<?php
        wfRestoreWarnings();
        } // end of execute() method
} // end of class