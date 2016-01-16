<li>
  <div class="post-image">
    <?php if (render($content['field_thumbnail'])) :?>
    <div class="img-thumbnail">
        <a href="<?php print $node_url; ?>">
        <?php if (render($content['field_thumbnail'])): ?>  
            <img src="<?php echo file_create_url($node->field_thumbnail['und'][0]['uri']); ?>" alt="">
        <?php endif; ?>
        </a>
    </div>
    <?php endif; ?>
  </div>
  <div class="post-info">
    <a href="<?php print $node_url; ?>" class="tabbed-title"><?php echo $title; ?></a>
    <div class="post-meta"><?php print format_date($node->created, 'custom', 'M d, Y'); ?></div>
  </div>    
</li>  