<?php
/**
 * Block Name: pricing
 *
 */

// create id attribute for specific styling
$id = 'pricing-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];


?>
<div class="pricing-blocks ">
  
  <?php if( have_rows('pricing_blocks') ):
    while( have_rows('pricing_blocks') ) : the_row();?>

      <div class="pricing-block">
        <h2 class="has-beige-color"><?php echo get_sub_field('name');?></h2>
        <p class="pricing-subtitle"><?php echo get_sub_field('sub_title');?></p>

        <p class="pricing-price has-black-color">
          <span class="has-pink-color"><?php echo get_sub_field('price');?></span>
          <span class="pricing-month"> / MONTH</span>
        </p>
        <p ><strong>INCLUDES</strong></p>
        <?php if( have_rows('features') ):
          echo '<ul class="has-black-color">';
          while( have_rows('features') ) : the_row();?>

            <li><?php echo get_sub_field('feature');?></li>

          <?php endwhile;
          echo '</ul>';
        endif;?>

        <p><a href="#signup" class="has-pink-background-color has-white-color">JOIN NOW</a></p>

      </div>

    <?php endwhile;
  endif;?>

</div>