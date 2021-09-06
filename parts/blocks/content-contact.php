<?php
/**
 * Block Name: Contact form
 *
 */

// create id attribute for specific styling
$id = 'contact-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];
?>
<div class="block-contact <?php echo $class;?>">
	<form class="contactForm" id="<?php echo $id;?>">
    <div class="row">
      <div class="">
		    <input type="text" name="Name" placeholder="Name" class="required" required/>

        <input type="email" name="Email" placeholder="Email Address" class="required" required/>

        <input type="text" name="Telphone" placeholder="Telephone" class="required" required/>

        <input type="text" name="Subject" placeholder="Subject" class="required" required/>

		    <textarea name="Message" placeholder="Message"></textarea>
          <div class="row">
            <input type="hidden" name="eyes" />
            <input type="hidden" name="captcha" id="captcha" />
            <input type="submit" name="send" value="Send Message" id="contactformsubmit"/>
          </div>
        </div>
      </div>
      <div class="message"></div>
    </div>


		<div class="message"></div>
	</form>
</div>

<script>
        jQuery(document).ready(function() {
        	jQuery('input, textarea').focus(function(e) {
          	e.preventDefault();
          	if(jQuery(this).hasClass('error')) {
          		jQuery(this).removeClass('error').val('');
          	}
          })

          jQuery(document).on('submit', '#<?php echo $id;?>', function(e) {
              e.preventDefault();
              valid= 1;
              form = jQuery(this).serialize();
              errorMessage = "Please fill out this field";
              	jQuery('#<?php echo $id;?> input').each(function( index ) {
              		if(jQuery(this).hasClass('required')) {
	              		if (jQuery(this).val() == "" || jQuery(this).val() == errorMessage) {
		              		jQuery(this).addClass('error').val(errorMessage);
		              		valid = 0;
		              	}
		             }
              	});

                captcha = jQuery('#<?php echo $id;?> input#captcha').val();
                console.log(captcha);

              	if(valid == 1) {
              	  jQuery('.contactForm .message').addClass('sending').html('Sending...');

                  jQuery.ajax({
                      url:"<?php bloginfo('template_directory');?>/form-send.php",
                      type:"POST",
                      data:"send=contact&" + form,
                      cache: false,
                      success: function(response){
                     	jQuery('.contactForm .message').fadeIn().text('Thank you. We will get back to you.').removeClass('error').addClass('success').delay(3000).slideUp();
                        jQuery('#<?php echo $id;?>').trigger('reset');
                      }
                  });
              }
          });
        });
    </script>


	