<?php
/**
 * @file
 * Porto's theme implementation to display a single Drupal page.
 */
?>

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
	
	<div role="main" class="main">
	
	  <?php if ( $title && $breadcrumb && !drupal_is_front_page() ): ?>
	  <section class="page-top breadcrumb-wrap">
		  <div class="container">
				<div class="row"> 
                    <div class="col-md-12">
                        <div class="reactos-blog"><em>The ReactOS Blog!</em></div>
                    </div>
				</div>
			</div>
		</section>
	  <?php endif; ?>
	  
	  <?php print render($page['before_content']); ?>
	  <div id="content" class="content full">
	    <div class="container">
	      <div class="row">
	      <?php print $messages; ?>
			    <?php if ( ($page['sidebar_left']) ) : ?>
				  <aside id="sidebar-left">
					  <div class="<?php if ($page['sidebar_right']) { echo "col-md-3";} else { echo "col-md-3"; } ?>">
					    <div id="sticky-sidebar">
					    <?php print render($page['sidebar_left']); ?>
					    </div>
					  </div>
				  </aside>
				  <?php endif; ?>
			
					<div class="<?php if ( ($page['sidebar_right']) AND ($page['sidebar_left']) ) { echo "col-md-6";} elseif ( ($page['sidebar_right']) OR ($page['sidebar_left']) ) {  echo "col-md-9"; }  else { echo "col-md-12"; } ?>">
					  
			     	<?php if ($tabs = render($tabs)): ?>
						  <div id="drupal_tabs" class="tabs ">
						    <?php print render($tabs); ?>
						  </div>
					  <?php endif; ?>
			      <?php print render($page['help']); ?>
			      <?php if ($action_links): ?>
			        <ul class="action-links">
			          <?php print render($action_links); ?>
			        </ul>
			      <?php endif; ?>
		
					  <?php if (isset($page['content'])) { print render($page['content']); } ?>
			      
					</div>
			  
				  <?php if ( ($page['sidebar_right']) ) : ?>
				  <div class="<?php if ($page['sidebar_left']) { echo "col-md-3";} else { echo "col-md-3"; } ?>">
				    <?php print render($page['sidebar_right']); ?>
				  </div>
				  <?php endif; ?>
			    
			  </div>
	    </div>  
	  </div>  
	  
	</div>

  <?php print render($page['after_content']); ?>
  
  <footer id="footer">
    <?php if (render($page['footer_1']) || render($page['footer_2']) || render($page['footer_3']) || render($page['footer_4'])) : ?>
	  <div class="container main-footer">
	    <div class="row">
	    
	      <?php if (theme_get_setting('ribbon') == '1'): ?>
				<div class="footer-ribbon">
					<span><?php echo t("%string", array('%string' => theme_get_setting('ribbon_text')) );?></span>
				</div>
	      <?php endif; ?>
			  
			  <?php if (render($page['footer_1'])) : ?>
		    <div class="col-md-3">
				  <?php print render($page['footer_1']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_2'])) : ?>
		    <div class="col-md-3">   
				  <?php print render($page['footer_2']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_3'])) : ?>
		    <div class="col-md-4">
				  <?php print render($page['footer_3']); ?>
		    </div>
		    <?php endif; ?>
		    
		    <?php if (render($page['footer_4'])) : ?>
		    <div class="col-md-2">
				  <?php print render($page['footer_4']); ?>
		    </div>
		    <?php endif; ?>
			    
			</div>  
	  </div>	
	  <?php endif; ?>
	  
	  <div class="footer-copyright">  
	    <div class="container">
	      <div class="row">
			    <div class="col-md-6">
			    
					  <?php if (isset($page['footer_bottom_left'])) : ?>
					    <?php print render($page['footer_bottom_left']); ?>
					  <?php endif; ?>
			  
			    </div>
			    <div class="col-md-6">
			    
					  <?php if (isset($page['footer_bottom_right'])) : ?>
					    <?php print render($page['footer_bottom_right']); ?>
					  <?php endif; ?>
			  
			    </div>
	      </div>  
	    </div>
	  </div>  
	</footer>
	
</div>	