<?php
/**
 * Block Name: FMW cover block
 *
 */

// create id attribute for specific styling
$id = 'fmwover-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];


$attachmentId = $block['data']['cover_image'];

?>

<div class="fullwidth-container <?=$class?>" id="<?=$id?>">
	<div class="directory-cover" style=" background-image: url('<?=wp_get_attachment_url($attachmentId);?>');">
        <div class="directory-cover-inner-wrapper">
            <p class="kristi-face">Find your wedding</p>
            <h2 id="lookingfor"><?=$block['data']['description']?></h2>
            <div class="quick-search-box has-white-background-color grid_4">
                <span>I'm Looking For </span>
                <select name="looking_for" id="looking_for">
                    <option value="">Something???</option>
                    <?php
                        $availableTerms = apply_filters( 'get_all_searchable_term', $id );
                        
                        foreach($availableTerms as $item){?>

                            <option class="looking" value="<?=$item['slug']?>"><?=$item['name']?></option>

                        <?php } ?>
                </select>
            </div>
            <a href="<?php echo get_field('subscribe_page', 'option');?>">Are you a supplier or venue?</a>
        </div>
    </div>
</div>

<script>
jQuery(document).ready((e) => {
    jQuery('#looking_for').change(function(){
        jQuery('#looking_for option:selected').each(function(){
            var selectedVal = jQuery(this).val()
            window.location.replace(`<?=get_site_url()?>/directory?lookingfor=${selectedVal}`);
        })
    })
})
</script>

	