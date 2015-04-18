<div id="page-wrapper"><div id="page">

  <div id="rosweb_header">
    <?php if ($logo): ?>
      <a href="<?php print $front_page ?>">
      <img id="rosweb_logo" src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>
    <!-- KICKSTARTER -->
    <div id="rosweb_kickstarter"><br /><a href="http://community.reactos.org/"><img src="https://reactos.org/sites/default/files/evolution.png"/></a></div>
    <!-- /KICKSTARTER -->
    <?php if ($main_menu): ?>
      <div id="rosweb_topMenu">
        <div id="rosweb_main-menu">
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
      </div><!-- /#rosweb_topMenu -->
    <?php endif; ?>
  </div><!-- /#rosweb_header -->

  <!-- main area -->
  <div id="main-wrapper" class="dtable"><div id="main" class="dtrow">

