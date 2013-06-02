<?php
/**
 * @file
 * ReactOS theme's implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['bottom']: Items to appear at the bottom of the page below the footer.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see zen_preprocess_page()
 * @see template_process()
 */
?>
<!-- fb { -->
<script type="text/javascript">
(function ($, undefined) {
	$.fn.socialSharePrivacy.settings.order = ['facebook', 'gplus', 'twitter', 'tumblr', 'reddit'];
	$.fn.socialSharePrivacy.settings.path_prefix = '/sites/all/themes/zen_reactos/ssp/';
	$.fn.socialSharePrivacy.settings.services['tumblr'].status = false;
	$.fn.socialSharePrivacy.settings.services['buffer'].status = false;
	$.fn.socialSharePrivacy.settings.services['reddit'].status = false;
	$.fn.socialSharePrivacy.settings.services['mail'].status = false;
	$.fn.socialSharePrivacy.settings.services['pinterest'].status = false;
	$.fn.socialSharePrivacy.settings.services['xing'].status = false;
	$.fn.socialSharePrivacy.settings.services['stumbleupon'].status = false;
	$.fn.socialSharePrivacy.settings.services['delicious'].status = false;
	$.fn.socialSharePrivacy.settings.services['disqus'].status = false;
	$.fn.socialSharePrivacy.settings.services['hackernews'].status = false;

	$(document).ready(function () {
		$('.share').socialSharePrivacy();
		$('#share_ros').hide();
		$('#share_ros').socialSharePrivacy({uri: 'http://www.reactos.org/'});
		$('#share_ros').show();
	});
}(jQuery));
</script>
<!-- } fb -->

<div id="page-wrapper"><div id="page">

  <div id="header">
    <?php if ($logo): ?>
      <a href="<?php print $front_page ?>">
      <img id="logo" src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>

    <?php if ($main_menu): ?>
      <div id="topMenu">
        <div id="main-menu">
          <?php
            /* Render the main menu links */
            $html = '';
            foreach ($main_menu as $link) {
              if(strpos($link["href"], "http://") !== false)
                 $html .= '<a href="'. $link["href"] . '">';
              else
                 $html .= '<a href="'. $base_path . $link["href"] . '">';
              $html .= $link["title"] . '</a>' . ' | ';
            }
            /* Remove the extra separator */
            $html = substr($html, 0, -3);
            echo $html;
          ?>
        </div>
      </div><!-- /#topMenu -->
    <?php endif; ?>
  </div><!-- /#header -->

  <!-- main area -->
  <div id="main-wrapper" class="dtable"><div id="main" class="dtrow">

    <!-- left sidebar -->
    <div class="dtcell dtcell-vtop">
      <?php print render($page['sidebar_first']); ?>
    </div>

    <div id="content" class="column dtcell dtcell-vtop"><div class="section">
      <?php print render($page['highlighted']); ?>
      <?php print $breadcrumb; ?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="title" id="page-title"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if ($tabs = render($tabs)): ?>
        <div class="tabs"><?php print $tabs; ?></div>
      <?php endif; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div></div><!-- /.section, /#content -->

    <?php if ($is_front): ?>
      <!-- right sidebar -->
      <div class="dtcell dtcell-vtop">
        <?php print render($page['sidebar_second']); ?>
      </div>
    <?php endif; ?>

    </div></div><!-- /#main, /#main-wrapper -->

  <div id="footer">
    <p><?php print t("ReactOS is a registered trademark or a trademark of ReactOS Foundation in the United States and other countries."); ?></p>
  </div><!-- /#footer -->

</div></div><!-- /#page, /#page-wrapper -->

<?php print render($page['bottom']); ?>
