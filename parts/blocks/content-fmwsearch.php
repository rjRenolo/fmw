<?php
/**
 * Block Name: FMW searhc form
 *
 */

// create id attribute for specific styling
$id = 'fmwsearch-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];
$availableTerms = get_terms(         array( 'taxonomy' => 'listing-category'     , 'hide_empty' => false));

// echo '<pre>';
// print_r($availableTerms);
// echo '</pre>';
// die();

?>

<div class="block-quicksearch <?=$class?>" >

    <div class="quick-search-box has-white-background-color ">
        <span>I'm Looking For </span>
        <select name="looking_for" id="<?=$id?>">
            <option value="">-- SELECT --</option>
            <?php
            // $availableTerms = apply_filters( 'get_all_listing_services', $id );
            
            
                        
            foreach($availableTerms as $item){?>

                <option class="looking" value="<?=$item->slug?>"><?=$item->name?></option>

            <?php } ?>
        </select>
    </div>
    <p class="textcenter"><a href="<?php echo get_the_permalink(get_field('subscribe_page','option'));?>" class="has-white-color underline">Are you a supplier or venue?</a></p>

</div>

<script>
jQuery(document).ready((e) => {
    jQuery('#<?=$id?>').change(function(){
        jQuery('#<?=$id?> option:selected').each(function(){
            var selectedVal = jQuery(this).val()
            //window.location.replace(`<?=get_site_url()?>/directory?lookingfor=${selectedVal}`);
            window.location.replace(`<?=get_site_url()?>/listing-category/${selectedVal}`);
        })
    })
})
</script>

	