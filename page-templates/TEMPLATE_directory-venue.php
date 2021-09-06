<?php 
/*
Template Name: Directory Venue
*/
?>
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>


<div class="fullwidth-container">

<?php


// echo '<pre>';
// print_r($_GET['county']);
// echo '</pre>';


?>

<?php
$lookingfor = '';
if(isset($_GET['lookingfor'])) {
    $lookingfor = $_GET['lookingfor'];
    $title = apply_filters('get_term_name_by_slug', $lookingfor);
} else {
    $title = get_the_title();
}

$coverImage = get_field('cover_image');
?>

    <div class="directory-cover directory-dim-overlay" style=" background-image: url('<?=$coverImage?>');">
        <div class="directory-cover-inner-wrapper">
            <p class="intro-script">Find my wedding</p>
            <h1 id="lookingfor"><?php echo $title; ?></h1>
            
            <?php Embers_Utilities::get_template_parts( array( 'parts/blocks/content-fmwsearchvenue' ) ); ?>

        </div>
    </div>


    <div class="container row">
        <div class="filter-container g_grid_3" >
            
            <?php Embers_Utilities::get_template_parts( array( 'parts/sidebar-filter' ) ); ?>

        </div>



        <div class="main-result-container g_grid_9">
            <?php 
            $my_postid = get_field('directory_page','option');
            $content_post = get_post($my_postid);
            $content = $content_post->post_content;
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);
            echo $content;?>

            <?php
                $refineCounty = [];
                $refineStyle = [];
                $refineAccommodation = [];
                $refineVenueFeatures = [];
                $venueDescription = [];
                $venueType = [];
                if(isset($_GET['county'])){
                    foreach($_GET['county'] as $rCounty){ $refineCounty[] = $rCounty; }
                }
                if(isset($_GET['style'])){
                    foreach($_GET['style'] as $rStyle){ $refineStyle[] = $rStyle; }
                }
                if(isset($_GET['accommodation'])){
                    foreach($_GET['accommodation'] as $rAccommodation){ $refineAccommodation[] = $rAccommodation; }
                }
                if(isset($_GET['venue_features'])){
                    foreach($_GET['venue_features'] as $rFeatures){ $refineVenueFeatures[] = $rFeatures; }
                }
                if(isset($_GET['venue_type'])){
                    foreach($_GET['venue_type'] as $rVType){ $venueType[] = $rVType; }
                }
                // if(isset($_GET['venueDescription'])){
                //     // $venueDescription = explode("fmw", $_GET['venueDescription']);
                //     foreach($_GET['style'] as $rStyle){ $refineStyle[] = $rStyle; }
                // }
                


                // $lookingForTax = apply_filters( 'service_venue_identifyer', $lookingfor );
                
                $taxQuery = array(
                    'relation' => 'AND',
                );

                $lookingTaxQuery = array(
                    'taxonomy' => 'listing-license',
                    'field' => 'slug', 
                    'terms' => 'venue',
                    'include_children' => true, 
                    'operator' => 'IN' 
                );
                array_push($taxQuery, $lookingTaxQuery);

                if(count($refineCounty) > 0 && $refineCounty[0] !== ""){ //location tax query
                    $locationTaxQuery = array(
                        'taxonomy' => 'listing-location',
                        'field' => 'name', 
                        'terms' => $refineCounty,
                        'include_children' => true, 
                        'operator' => 'IN' 
                    );
                    array_push($taxQuery, $locationTaxQuery);
                }

                if(count($refineStyle) > 0 && $refineStyle[0] !== ""){
                    $styleTaxQuery = array(
                        'taxonomy' => 'listing-style',
                        'field' => 'name', 
                        'terms' => $refineStyle,
                        'include_children' => true, 
                        'operator' => 'IN' 
                    );
                    array_push($taxQuery, $styleTaxQuery);
                }

                if(count($refineAccommodation) > 0 && $refineAccommodation[0] !== ""){
                    $accommodationTaxQuery = array(
                        'taxonomy' => 'listing-capacity',
                        'field' => 'name', 
                        'terms' => $refineAccommodation,
                        'include_children' => true, 
                        'operator' => 'IN' 
                    );
                    array_push($taxQuery, $accommodationTaxQuery);
                }

                if(count($refineVenueFeatures) > 0 && $refineVenueFeatures[0] !== ""){
                    $venueFeaturesTaxQuery = array(
                        'taxonomy' => 'listing-features',
                        'field' => 'name', 
                        'terms' => $refineVenueFeatures,
                        'include_children' => true, 
                        'operator' => 'IN' 
                    );
                    array_push($taxQuery, $venueFeaturesTaxQuery);
                }

                // if(count($venueDescription) > 0 && $venueDescription[0] !== ""){
                if(count($venueDescription) > 0 && $venueDescription[0] !== ""){
                    $venueDescTaxQuery = array(
                        'taxonomy' => 'listing-venue-type',
                        'field' => 'name', 
                        'terms' => $venueDescription,
                        'include_children' => true, 
                        'operator' => 'IN' 
                    );
                    array_push($taxQuery, $venueDescTaxQuery);
                }
                
                $args = array(
                    'post_type' => 'listing',
                    'paged' => get_query_var( 'paged', 1 ),
                    'posts_per_page' => 15,
                    'tax_query' => $taxQuery,
                    
                    'meta_key' => 'expiration_date',
                    'meta_value' => time(),
                    'meta_compare' => '>'
                );

                $the_query = new WP_Query( $args );

            ?>
            <div class="results">
                <span class="has-grey-color showingResults">Showing <?=$the_query->post_count?> of <?=$the_query->found_posts?> results</span>
                <div class="results-wrapper row">
                    <?php

                        if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : $the_query->the_post();
                        
                            get_template_part('parts/blocks/card', 'listing');

                        endwhile;
                        

                    ?>
                </div>
                <?php
                $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    // 'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    // 'format' => '?paged=%#%',
                    // 'current' => max( 1, get_query_var('paged') ),
                    'total' => $the_query->max_num_pages
                ) );
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>



    <!-- < ?php include THEME_DIR . '/parts/before-footer-promotion.php';?> -->

</div>

<script>
    jQuery(document).ready((e) => {
        jQuery('#looking_for').on('change', (e) => {
            // jQuery('#lookingfor').text(jQuery('#looking_for').val())
            // jQuery('#lookingForResult').text(jQuery('#looking_for').val())
        })

        // jQuery('#refineform').submit((e) => {
        //     e.preventDefault()

        //     var selectedLookingFor = ""

        //     jQuery('#looking_for option:selected').each(function(){
        //         selectedLookingFor = jQuery(this).val()
        //     })


        //     var county = [];
        //     var encodedCounty;
        //     jQuery('input:checkbox[name=county]:checked').each(function(){
        //         county.push(encodeURIComponent(jQuery(this).val()))
        //     })
        //     encodedCounty = `county=${county.join('fmw')}`


        //     var style = [];
        //     var encodedStyle;
        //     jQuery('input:checkbox[name=style]:checked').each(function(){
        //         style.push(encodeURIComponent(jQuery(this).val()))
        //     })
        //     encodedStyle = `style=${style.join('fmw')}`

        //     var accommodation = [];
        //     var encodedAccommodation;
        //     jQuery('input:checkbox[name=accommodation]:checked').each(function(){
        //         accommodation.push(encodeURIComponent(jQuery(this).val()))
        //     })
        //     encodedAccommodation = `accommodation=${accommodation.join('fmw')}`

        //     var venue_features = [];
        //     var encodedVenueFeatures;
        //     jQuery('input:checkbox[name=venue_features]:checked').each(function(){
        //         venue_features.push(encodeURIComponent(jQuery(this).val()))
        //     })
        //     encodedVenueFeatures = `features=${venue_features.join('fmw')}`

        //     var venue_description = [];
        //     var encodedVenueDescription;
        //     jQuery('input:checkbox[name=venue_description]:checked').each(function(){
        //         venue_description.push(encodeURIComponent(jQuery(this).val()))
        //     })
        //     encodedVenueDescription = `venueDescription=${venue_description.join('fmw')}`

        //     refinedURLParams = `${selectedLookingFor}&${encodedCounty}&${encodedStyle}&${encodedAccommodation}&${encodedVenueFeatures}&${encodedVenueDescription}`

            
            

        //     window.location.replace(`<?=get_site_url()?>/directory?lookingfor=${refinedURLParams}`);

        // })



        jQuery('#looking_for').change(function(){
            jQuery('#looking_for option:selected').each(function(){
                var selectedVal = jQuery(this).val()
                jQuery('#lookingfor').text(jQuery(this).text())
                jQuery('#lookingForResult').text(jQuery(this).text())
                window.location.replace(`<?=get_site_url()?>/directory?lookingfor=${selectedVal}`);
            })
        })


    })
</script>


<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>