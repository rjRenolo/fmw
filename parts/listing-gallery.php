<?php 
$rows = get_field('image_gallery');
$videoURLs = get_field('video_urls');

// echo '<pre>';
// print_r($rows);
// print_r(acf_image_output_url($rows[0]['image'], 'large'));
// echo '</pre>';
// die();
?>


<?php

if(count($rows) === 1){ ?>

    <div class="gallery-container">
        <div class="image-container large-image" style="background: url(<?= acf_image_output_url($rows[0]['image'], 'large');?>); ">
        </div>
    </div>

<?php }elseif(count($rows) === 2){ ?>

<div class="gallery-container row">
    <div class="image-container g_grid_6 large-image" style="background: url(<?= acf_image_output_url($rows[0]['image'], 'large')?>)">
    </div>
    <div class="image-container g_grid_6 large-image" style="background: url(<?= acf_image_output_url($rows[1]['image'], 'large')?>);">
    </div>
</div>

<?php }elseif(count($rows) === 3){ ?>

    <div class="gallery-container row">
        <div class="image-container g_grid_8 large-image" style="background: url(<?= acf_image_output_url($rows[0]['image'], 'large')?>);">
        </div>
        <div class="g_grid_4">

            <div class="image-container med-image med-image-lead" style="background: url(<?= acf_image_output_url($rows[1]['image'], 'large')?>);">
            </div>
            <div class="image-container med-image" style="background: url(<?= acf_image_output_url($rows[2]['image'], 'large')?>);">
            </div>
        </div>
    </div>

<?php }elseif(count($rows) > 3){ ?>

    <?php if(count($videoURLs) > 0 ){?>

        <div class="gallery-container vid-gallery-container row">
            <div class="image-container g_grid_8 large-image" style="background: url(<?= acf_image_output_url($rows[0]['image'], 'large')?>);  ">
            </div>
            <div class="g_grid_4">
                <div class="image-container med-image med-image-lead" style="background: url(<?= acf_image_output_url($rows[1]['image'], 'large')?>);">
                </div>
                <div class="image-container med-image" style="background: url(<?= acf_image_output_url($rows[2]['image'], 'large')?>); display:flex;">
                    <div class="video-btn">
                        <span class="has-white-color"><?=count($videoURLs);?> videos</span>
                    </div>
                </div>
            </div>
            <button id="viewImageGallery" class="primary-btn viewGalleryBtn">
                View Photo Gallery
            </button>
        </div>

    <?php }else{ ?>

        <div class="gallery-container vid-gallery-container row">
            <div class="image-container g_grid_8 large-image" style="background: url(<?= acf_image_output_url($rows[0]['image'], 'large')?>);">
            </div>
            <div class="g_grid_4">

                <div class="image-container med-image med-image-lead" style="background: url(<?= acf_image_output_url($rows[1]['image'], 'large')?>); ">
                </div>
                <div class="image-container med-image" style="background: url(<?= acf_image_output_url($rows[2]['image'], 'large')?>);">
                </div>
            </div>
            <button id="viewImageGallery" class="primary-btn viewGalleryBtn">
                View Photo Gallery
            </button>
        </div>

    <?php } ?>
    
<?php }else{ ?>
    
<?php } ?>


<script>

    jQuery(document).ready(() => {
        jQuery('.video-btn').on('click', (e) => {
            console.log('here')
        })

        jQuery(".videosModal").hide();
        jQuery(".video-btn").click(function(){
            jQuery(".videosModal").fadeToggle();
        });
        jQuery(".Close").click(function(){
            jQuery(".videosModal").fadeOut();
        });
    })

</script>


