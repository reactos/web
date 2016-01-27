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
