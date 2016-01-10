<form action="https://<?php echo variable_get('paypal_donations_service_url', 'www.sandbox.paypal.com'); ?>/cgi-bin/webscr" method="post" target="_blank" class="single-donation-form donation-form">
  <div class="inner_content">
   
    <input name="landing_page" type="hidden" value="billing" />
    <input name="cpp_cart_border_color" type="hidden" value="FF0000" />
    <?php
      if(!empty($variables['top_logo'])) {
    ?>
    <input name="cpp_header_image" type="hidden" value="<?php echo file_create_url($variables['top_logo']->uri, array('absolute' => TRUE))?>" />
    <?php
      }
    ?>    <input name="cpp_payflow_color" type="hidden" value="D20137" />
    <input name="business" type="hidden" value="<?php echo $variables['account_email']; ?>" />
    <input name="cmd" type="hidden" value="_donations" />
    <input type="hidden" name="notify_url" value="<?php echo $variables['notify_url']; ?>">
    <input type="hidden" name="return" value="<?php echo $variables['return_url']; ?>"/>
    <input name="item_name" type="hidden" value="<?php echo $variables['item_name']; ?>" />
    <div class="row column">
	<div class="col-md-8">
      <?php
      for($i = 0 ; $i < count($variables['predefined_amounts']) ; $i++) {
        echo '<input id="pre_single_' . $i . '" type="checkbox" class="donation-amount donation-single" value="' . $variables['predefined_amounts'][$i] . '" /> <label for="pre_single_' . $i . '"><span>' . $variables['currency_sign'] . $variables['predefined_amounts'][$i] . '</span></label>';
        }
      ?>
      <?php if( $variables['custom_amount_allowed'] == 1 ) { ?>
      <?php echo '<label class="dollar">' . $variables['currency_sign'] . '</label>'; ?><input name="other" size="4" type="text" value="" class="other" /></li>
      <?php } ?>
		</div>
		<div class="col-md-4"><button href="#" class="donation-submit-button btn-lg btn-primary"><?php echo t($variables['submit_value']); ?></button> <input type="hidden" value="" name="amount" class="amount-holder"/>
        </div>
    <input name="currency_code" type="hidden" value="<?php echo $variables['currency_code']; ?>" /><br />
  </div>
</form>
