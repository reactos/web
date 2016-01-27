<div class="body">
  <header id="header">
    <div class="container">

      <?php if (isset($page['branding'])) : ?>
	      <?php print render($page['branding']); ?>
	    <?php endif; ?>
    
      <?php if ($logo): ?>
      <h1 class="logo">
	      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
	        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" height="<?php print theme_get_setting('logo_height'); ?>" data-sticky-height="<?php print theme_get_setting('sticky_logo_height'); ?>" />
	      </a>
      </h1>
	    <?php endif; ?>
	    
	    <?php if ($site_name || $site_slogan): ?>
      <div id="name-and-slogan"<?php if ($disable_site_name && $disable_site_slogan) { print ' class="hidden"'; } ?>>

        <?php if ($site_name): ?>
          <?php if ($title): ?>
            <div id="site-name"<?php if ($disable_site_name) { print ' class="hidden"'; } ?>>
	            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
	          </div>
          <?php else: /* Use h1 when the content title is empty */ ?>
	          <h1 id="site-name"<?php if ($disable_site_name) { print ' class="hidden"'; } ?>>
	            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
	          </h1>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($site_slogan): ?>
          <div id="site-slogan"<?php if ( ($disable_site_slogan ) ) { print ' class="hidden"'; } if ( (!$disable_site_slogan ) AND ($disable_site_name) ) { print ' class="slogan-no-name"'; } ?>>
            <?php print $site_slogan; ?>
          </div>
        <?php endif; ?>

      </div> <!-- /#name-and-slogan -->
	    <?php endif; ?>
	    
	    <?php if (isset($page['header_search'])) : ?>
	    <div class="search">
	      <?php print render($page['header_search']); ?>
	    </div>
	    <?php endif; ?>
      
      <!-- /branding --> 
      <div id="header-top">
        <?php print render($page['header_top']); ?>
      </div>
      
	    <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
				<i class="icon icon-bars"></i>
			</button>
      
    </div>
    
    <div class="navbar-collapse nav-main-collapse collapse">
		  <div class="container">  
      
        <?php print render($page['header_icons']); ?>
        
        <nav class="nav-main">
        <?php print render($page['header_menu']); ?>
        </nav>
        
		  </div> 
    </div>  
    
	</header>
	<!-- end header --> 
