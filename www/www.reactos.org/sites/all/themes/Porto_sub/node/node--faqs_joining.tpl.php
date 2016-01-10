<?php

/**
 * @file node--faq.tpl.php
 * Porto's node template for the FAQ content type.
 */
?>

<section class="toggle <?php if ( render($content['field_active']) == 'active' ) { print render($content['field_active']); } ?>">
	<label><?php echo $title; ?></label>
	<p><?php print render($content['body']); ?></p>
</section>