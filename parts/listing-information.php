<?php

global $current_user; 
// wp_get_current_user();
wp_get_current_user();
$userSubscriptionPackage = get_user_meta( $current_user->ID, 'subscription_type' , true );
$doneSteps = get_user_meta($current_user->ID, 'business_details_done_steps', true);
$listingPageId = get_user_meta($current_user->ID, 'user_page_id', true);

$listingLicense = wp_get_post_terms($listingPageId, 'listing-license');
$encodedDoneSteps = json_encode($doneSteps);



// get currents
// listing license type
$currentLicenseType = apply_filters( 'term_getter', $listingPageId, 'listing-license' );
echo "<script> theLicenseType = '$currentLicenseType' </script>";
$currentCategoryies = apply_filters( 'term_getter', $listingPageId, 'listing-category', 'array' );
$currentCounties = apply_filters( 'term_getter', $listingPageId, 'listing-location', 'array' );

$countyCount = 0;
if($currentCounties !== ""){

    $countyCount = count($currentCounties);
}
$currentAccommodation = apply_filters( 'term_getter', $listingPageId, 'listing-capacity');
$currentStyles = apply_filters( 'term_getter', $listingPageId, 'listing-style', 'array' );
$currentLicenseTypes = apply_filters( 'term_getter', $listingPageId, 'listing-license-type', 'array' );
$currentListingVenueDescs = apply_filters( 'term_getter', $listingPageId, 'listing-venue-type', 'array' );
$currentListingVenueFeatures = apply_filters( 'term_getter', $listingPageId, 'listing-features', 'array' );

// echo '<pre>';
// var_dump($currentListingVenueFeatures);
// echo '</pre>';
// die();


// get all terms
// listing license type
$listingLicenseTypes = get_terms(       array( 'taxonomy' => 'listing-license'      , 'hide_empty' => false));
$listingCounties = get_terms(           array( 'taxonomy' => 'listing-location'     , 'hide_empty' => false));
$listingCategories = get_terms(         array( 'taxonomy' => 'listing-category'     , 'hide_empty' => false));
$listingAccommodations = get_terms(     array( 'taxonomy' => 'listing-capacity'     , 'hide_empty' => false, 'orderby' => 'id', 'order'=>'DESC'));
$listingStyles = get_terms(             array( 'taxonomy' => 'listing-style'        , 'hide_empty' => false));
$listingLicenseTypes = get_terms(       array( 'taxonomy' => 'listing-license-type' , 'hide_empty' => false));
$listingVenueDescriptions = get_terms(  array( 'taxonomy' => 'listing-venue-type'   , 'hide_empty' => false));
$listingVenueFeatures = get_terms(      array( 'taxonomy' => 'listing-features'     , 'hide_empty' => false));


// echo '<pre>';
// print_r($listingVenueFeatures);
// echo '</pre>';
// die();
?>
<div class="listing-information-question-container">

    <div class="listing-venue-type-question">
        <form id="listing-venue-type">
            <h3>Select which of the following applies to you:</h3>

            <?php foreach($listingLicenseTypes as $lLicenseType){ ?>
                <?php if($currentLicenseTypes){ ?>
                    
                    <?php
                        $currentLicenseTypesHaystack = [];
                        foreach($currentLicenseTypes as $cLicenseType){
                            $currentLicenseTypesHaystack[] = $cLicenseType->name;
                        }
                    ?>


                    <?php if(in_array($lLicenseType->name, $currentLicenseTypesHaystack)){ ?>

                        <input checked class="cb__listing_venue_type" type="checkbox" name="listing_venue_type" id="listing_venue_type__<?=$lLicenseType->slug?>" value="<?=$lLicenseType->name?>">
                        <label for="listing_venue_type__<?=$lLicenseType->slug?>"><?=$lLicenseType->name?></label><br>

                    <?php }else{ ?>

                        <input class="cb__listing_venue_type" type="checkbox" name="listing_venue_type" id="listing_venue_type__<?=$lLicenseType->slug?>" value="<?=$lLicenseType->name?>">
                        <label for="listing_venue_type__<?=$lLicenseType->slug?>"><?=$lLicenseType->name?></label><br>

                    <?php } ?>

                <?php }else{ ?>
                        <input class="cb__listing_venue_type" type="checkbox" name="listing_venue_type" id="listing_venue_type__<?=$lLicenseType->slug?>" value="<?=$lLicenseType->name?>">
                        <label for="listing_venue_type__<?=$lLicenseType->slug?>"><?=$lLicenseType->name?></label><br>
                <?php } ?>
                

            <?php } ?>

            <input type="submit" value="Save">
        </form>
    </div>


    <div class="county-located-question" style="display:none;">
        <form id="county-located">
            <h3 id="county_question">Which of these counties do you provide your service in?</h3>

            <?php if($userSubscriptionPackage == 'basic') { ?>
                <p>Your basic package includes up to one county. Click <a href="<?php echo get_bloginfo('url');?>/subscribe-again">HERE</a> to upgrade</p>
            <?php } ?>

            <?php if($userSubscriptionPackage == 'better') { ?>
                <p>Your better package includes up to two counties. Click <a href="<?php echo get_bloginfo('url');?>/subscribe-again">HERE</a> to upgrade</p>
            <?php } ?>

            <?php foreach($listingCounties as $listingC){ ?>
                <?php if($currentCounties){ ?>
                    

                    <?php 
                        $currentCountiesHaystack = [];
                        foreach($currentCounties as $cCounties){
                            $currentCountiesHaystack[] = $cCounties->name;
                        }
                    ?>


                    <?php if(in_array($listingC->name, $currentCountiesHaystack)){ ?>
                        <input checked class="cb__county" type="checkbox" name="county" id="county_<?=$listingC->slug?>" value="<?=$listingC->name?>">
                        <label for="county_<?=$listingC->slug?>"><?=$listingC->name?></label><br>
                        
                    <?php }else{ ?>
                        <input class="cb__county" type="checkbox" name="county" id="county_<?=$listingC->slug?>" value="<?=$listingC->name?>">
                        <label for="county_<?=$listingC->slug?>"><?=$listingC->name?></label><br>
                    <?php } ?>

                <?php }else{ ?>
                    <input class="cb__county" type="checkbox" name="county" id="county_<?=$listingC->slug?>" value="<?=$listingC->name?>">
                    <label for="county_<?=$listingC->slug?>"><?=$listingC->name?></label><br>
                <?php } ?>

            <?php } ?>


            <input type="submit" value="Save">

        </form>
    </div>


    <div class="accommodation-question" style="display:none;">
        <form id="accommodation">
            <h3>How many guests can you accommodate?</h3>

            <?php foreach($listingAccommodations as $lAccommodation){ ?>
                <?php if($currentAccommodation === $lAccommodation->name){ ?>

                    <input checked class="rd__accommodation" type="radio" name="accommodation" id="accommodation_<?=$lAccommodation->slug?>" value="<?=$lAccommodation->name?>">
                    <label for="accommodation_<?=$lAccommodation->slug?>"><?=$lAccommodation->name?></label><br>

                <?php }else{ ?>

                    <input class="rd__accommodation" type="radio" name="accommodation" id="accommodation_<?=$lAccommodation->slug?>" value="<?=$lAccommodation->name?>">
                    <label for="accommodation_<?=$lAccommodation->slug?>"><?=$lAccommodation->name?></label><br>

                <?php } ?>

            <?php } ?>


            <input type="submit" value="Save">
        
        </form>
    </div>


    <div class="style-question" style="display:none;">
        <form id="style">
            <h3>How would you describe your service style?</h3>
                <p><small>Tick as many as relevant.</small></p>

            <?php foreach($listingStyles as $lStyle){ ?>
                <?php if($currentStyles){ ?>

                    <?php 
                        $currentStylesHaystack = [];
                        foreach($currentStyles as $cStyles){
                            $currentStylesHaystack[] = $cStyles->name;
                        }
                    ?>

                    <?php if(in_array($lStyle->name, $currentStylesHaystack)){ ?>

                        <input checked class="cb__style" type="checkbox" name="style" id="style_<?=$lStyle->slug?>" value="<?=$lStyle->name?>">
                        <label for="style_<?=$lStyle->slug?>"><?=$lStyle->name?></label><br>

                    <?php }else{ ?>

                        <input class="cb__style" type="checkbox" name="style" id="style_<?=$lStyle->slug?>" value="<?=$lStyle->name?>">
                        <label for="style_<?=$lStyle->slug?>"><?=$lStyle->name?></label><br>

                    <?php } ?>
                <?php }else{ ?>
                    <input class="cb__style" type="checkbox" name="style" id="style_<?=$lStyle->slug?>" value="<?=$lStyle->name?>">
                    <label for="style_<?=$lStyle->slug?>"><?=$lStyle->name?></label><br>
                <?php } ?>
                
                
            <?php } ?>

            <input type="submit" value="Save">
        
        </form>
    </div>


    <?php if($currentLicenseType == "Supplier"){ ?>
        <div class="service-description-question" style="display:none;">
            <form id="service-description">
                <h3>Which category best describes your service?</h3>

                <?php if($userSubscriptionPackage == 'basic') { ?>
                    <p>Your basic package includes up to one category. Click <a href="<?php echo get_bloginfo('url');?>/subscribe-again">HERE</a> to upgrade</p>
                <?php } ?>

                <?php if($userSubscriptionPackage == 'better') { ?>
                    <p>Your better package includes up to two categories. Click <a href="<?php echo get_bloginfo('url');?>/subscribe-again">HERE</a> to upgrade</p>
                <?php } ?>
    
                <?php foreach($listingCategories as $lCategories){ ?>
                    <?php if($currentCategoryies){ ?>
    
                        <?php 
                            $currentCategoryiesHaystack = [];
                            foreach($currentCategoryies as $cCategories){
                                $currentCategoryiesHaystack[] = $cCategories->name;
                            }
                        ?>
                        <?php if(in_array($lCategories->name, $currentCategoryiesHaystack)){ ?>
                            <input checked class="rd__service_description" type="radio" name="service_description" id="service_description_<?=$lCategories->slug?>" value="<?=$lCategories->name?>">
                            <label for="service_description_<?=$lCategories->slug?>"><?=$lCategories->name?></label><br>
                        <?php }else{ ?>
                            
                            <input class="rd__service_description" type="radio" name="service_description" id="service_description_<?=$lCategories->slug?>" value="<?=$lCategories->name?>">
                            <label for="service_description_<?=$lCategories->slug?>"><?=$lCategories->name?></label><br>
    
                        <?php } ?>
    
                    <?php }else{ ?>
    
                            <input class="rd__service_description" type="radio" name="service_description" id="service_description_<?=$lCategories->slug?>" value="<?=$lCategories->name?>">
                            <label for="service_description_<?=$lCategories->slug?>"><?=$lCategories->name?></label><br>
    
                    <?php } ?>
    
    
                <?php } ?>
    
    
                <input type="submit" value="Save">
    
            </form>
        </div>
    <?php } ?>


    <div class="venue-description-question" style="display:none;">
        <form id="venue-description">
            <h3>How would you describe your venue?</h3>

            <?php foreach($listingVenueDescriptions as $lVenueDesc) { ?>
                
                <?php if($currentListingVenueDescs){ ?>
                    
                    <?php 

                        $currentListingVenueDescHaystack = [];
                        foreach($currentListingVenueDescs as $cVenueDesc){
                            $currentListingVenueDescHaystack[] = $cVenueDesc->name;
                        }

                    ?>

                    <?php if(in_array($lVenueDesc->name, $currentListingVenueDescHaystack)){ ?>

                        <input checked class="cb__venue_description" type="checkbox" name="venue_description" id="venue_description_<?=$lVenueDesc->slug?>" value="<?=$lVenueDesc->name?>">
                        <label for="venue_description_<?=$lVenueDesc->slug?>"><?=$lVenueDesc->name?></label><br>    

                    <?php }else{ ?>

                        <input class="cb__venue_description" type="checkbox" name="venue_description" id="venue_description_<?=$lVenueDesc->slug?>" value="<?=$lVenueDesc->name?>">
                        <label for="venue_description_<?=$lVenueDesc->slug?>"><?=$lVenueDesc->name?></label><br>    

                    <?php } ?>

                <?php }else{ ?>

                    <input class="cb__venue_description" type="checkbox" name="venue_description" id="venue_description_<?=$lVenueDesc->slug?>" value="<?=$lVenueDesc->name?>">
                    <label for="venue_description_<?=$lVenueDesc->slug?>"><?=$lVenueDesc->name?></label><br>    

                <?php } ?>


            <?php } ?>

            

            <input type="submit" value="Save">

        </form>
    </div>


    <div class="venue-features-question" style="display:none;">
        <form id="venue-features">

            <h3>Which of the following features is true of your venue:</h3>


            <?php foreach($listingVenueFeatures as $lVenueFeat){ ?>
                <?php if($currentListingVenueFeatures){?>
                    <?php 
                        $currentListingVenueFeaturesHaystack = [];    
                        foreach($currentListingVenueFeatures as $cListingVenueFeat){
                            $currentListingVenueFeaturesHaystack[] = $cListingVenueFeat->name;
                        }
                    ?>
                    <?php if(in_array($lVenueFeat->name, $currentListingVenueFeaturesHaystack)){ ?>
                        <input checked class="cb__venue_features" type="checkbox" name="venue_features" id="venue_features<?=$lVenueFeat->slug?>" value="<?=$lVenueFeat->name?>">
                        <label for="venue_features<?=$lVenueFeat->slug?>"><?=$lVenueFeat->name?></label><br>

                    <?php }else{ ?>
                        <input class="cb__venue_features" type="checkbox" name="venue_features" id="venue_features<?=$lVenueFeat->slug?>" value="<?=$lVenueFeat->name?>">
                        <label for="venue_features<?=$lVenueFeat->slug?>"><?=$lVenueFeat->name?></label><br>

                    <?php  } ?>
                    <!-- < ?php foreach($currentListingVenueFeatures as $cListingVenueFeat){ ?>
                    < ?php } ?> -->
                <?php }else{ ?>
                    <input class="cb__venue_features" type="checkbox" name="venue_features" id="venue_features<?=$lVenueFeat->slug?>" value="<?=$lVenueFeat->name?>">
                    <label for="venue_features<?=$lVenueFeat->slug?>"><?=$lVenueFeat->name?></label><br>

                <?php } ?>
                
            <?php } ?>

            <input type="submit" value="Save">


        </form>
    </div>
</div>

<div class="listing-show-information" style="display:none;">
    <div class="listing-venue-type-show listing-final">
        <h4>Select which of the following applies to you:</h4>
        <ul id="list-venue-type">
        </ul>
    </div>


    <div class="county-located-show listing-final">
        <h4 id="county_question">Which of these counties do you provide your service in?</h4>
        <ul id="list-county">
        </ul>
    </div>


    <div class="accommodation-show listing-final">
        <h4>How many guests can you accommodate?</h4>
        <p id="accommodation-count"></p>
    </div>


    <div class="style-show listing-final">
        <h4>How would you describe your service style?</h4>
        <ul id="list-of-style">
        </ul>
    </div>


    <?php if($currentLicenseType == "Supplier"){ ?>
        <div class="service-description-show listing-final">
            <h4>Which category best describes your service</h4>
            <ul id="list-of-category">
            </ul>
        </div>
    <?php } ?>


    <?php if($currentLicenseType == "Venue"){ ?>
        <div class="venue-description-show listing-final">
            <h4>How would you describe your venue?</h4>
            <ul id="list-venue-description">
            </ul>
        </div>
    <?php } ?>

    <?php if($currentLicenseType == "Venue"){ ?>
        <div class="venue-features-show listing-final">
            <h4>Which of the following features is true of your venue:</h4>
            <ul id="list-features">
            </ul>
        </div>
    <?php } ?>
</div>

<script>

    // listing-venue-type-question      venueSpecific
    // county-located-question          both
    // accommodation-question           both
    // style-question                   both
    // service-description-question     supplierSpecific / both
    // venue-description-question       venueSpecific
    // venue-features-question          venueSpecific
    // var selectedBusinessType;
    // var venueQuestionList = ['.service-description-question', '.listing-venue-type-question', '.county-located-question', '.accommodation-question', '.style-question ', '.venue-description-question', '.venue-features-question'];
    var venueQuestionList = ['.listing-venue-type-question', '.county-located-question', '.accommodation-question', '.style-question ', '.venue-description-question', '.venue-features-question'];

    var supplierQuestionList = ['.service-description-question', '.county-located-question', '.accommodation-question', '.style-question '];
    var toShowAll = ['.listing-type-question'];

    const questionSwitcher = (toHide) => {
        jQuery(toHide).hide();
        // if(selectedBusinessType === 'Supplier'){
        if(theLicenseType === 'Supplier'){
            
            var toShow = supplierQuestionList.shift()
            if(toShow !== undefined){
                jQuery(toShow).show();
                if(!toShowAll.includes(toShow)){
                    toShowAll.push(toShow)
                }
            }else{
                // toShowAll.map(item => {
                //     jQuery(item).show();
                // })
                // jQuery('input[type=submit]').each(function(){
                //     jQuery(this).hide();
                // })
                jQuery('.listing-show-information').show()
            }
            
        }else{

            var toShow = venueQuestionList.shift()
            if(toShow !== undefined){
                jQuery(toShow).show();
                if(!toShowAll.includes(toShow)){
                    toShowAll.push(toShow)
                }
            }else{
                // toShowAll.map(item => {
                //     console.log(item)
                //     jQuery(item).show();
                // })
                // jQuery('input[type=submit]').each(function(){
                //     jQuery(this).hide();
                // })
                jQuery('.listing-show-information').show()
            }
        }
    }

    jQuery(document).ready(() => {



        var userSubscriptionPackage = '<?=$userSubscriptionPackage?>'
        
        // county limiter based on subscription package
        // 1 for bronze
        // 3 for silver
        // 6 for gold
        // TODO
        // remove selected value if subscription downgraded
        var countyCounter = parseInt("<?=$countyCount?>");
        console.log('the package', userSubscriptionPackage)
        console.log('the county', countyCounter)
        switch(userSubscriptionPackage){
            case 'gold':
                if(countyCounter == 9999){
                    // disable all
                    jQuery(".cb__county:not(:checked)").attr("disabled", true);
                }
                break;
            case 'silver':
                if(countyCounter == 2){
                    // disable all
                    jQuery(".cb__county:not(:checked)").attr("disabled", true);
                }
                break;
            default:
                if(countyCounter == 1){
                    // disable all
                    jQuery(".cb__county:not(:checked)").attr("disabled", true);
                }
                break;
        }

        jQuery('.cb__county').on('change', (e) => {
            if(e.currentTarget.checked){
                countyCounter++
                switch(userSubscriptionPackage){
                    case 'best':
                        if(countyCounter == 9999){
                            // disable all
                            jQuery(".cb__county:not(:checked)").attr("disabled", true);
                        }
                        break;
                    case 'better':
                        if(countyCounter == 2){
                            // disable all
                            jQuery(".cb__county:not(:checked)").attr("disabled", true);
                        }
                        break;
                    default:
                        if(countyCounter == 1){
                            // disable all
                            jQuery(".cb__county:not(:checked)").attr("disabled", true);
                        }
                        break;
                }
            }else{
                countyCounter--
                switch(userSubscriptionPackage){
                    case 'best':
                        if(countyCounter < 99999){
                            // enable all
                            jQuery(".cb__county:not(:checked)").removeAttr("disabled");
                        }
                        break;
                    case 'better':
                        if(countyCounter < 3){
                            // enable all
                            jQuery(".cb__county:not(:checked)").removeAttr("disabled");
                        }
                        break;
                    default:
                        if(countyCounter < 1){
                            // enable all
                            jQuery(".cb__county:not(:checked)").removeAttr("disabled");
                        }
                        break;
                }
            }
        })


        jQuery('#listing-type').on('submit', (e) => {
            e.preventDefault()

            var listingTypeData = [];
            var i = 0;
            jQuery('.rd__listing_type:checked').each(function () {
                listingTypeData[i++] = jQuery(this).val();
            }); 
            selectedBusinessType = listingTypeData[0] === 'no' ? 'Supplier' : 'Venue';

            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: listingTypeData, type: 'listingType', done: '.listing-type-question'}},
                success: function(response){
                    console.log(response)
                    if(selectedBusinessType === 'Supplier'){
                        jQuery('#county_question').text('Which of these counties do you provide your service in?')
                    }else{
                        jQuery('#county_question').text('In which county are you located?')
                    }
                    questionSwitcher('.listing-type-question')
                },
                error: function(jqxhr, status, err){
                    console.log('therequest', jqxhr)
                    console.log('status', status)
                    console.log('err', err)
                }
            })
        })


        jQuery('#listing-venue-type').on('submit', (e) => {
            e.preventDefault();

            var listingVenueType = [];
            var i = 0;
            jQuery('.cb__listing_venue_type:checked').each(function () {
                listingVenueType[i++] = jQuery(this).val();
            }); 
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: listingVenueType, type: 'listingVenueType', done: '.listing-venue-type-question'}},
                success: function(response){
                    console.log(response)
                    listingVenueType.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-venue-type')
                    })
                    questionSwitcher('.listing-venue-type-question')
                }
            })
        })


        jQuery('#county-located').on('submit', (e) => {
            e.preventDefault();

            var countyList = [];
            var i = 0;
            jQuery('.cb__county:checked').each(function () {
                countyList[i++] = jQuery(this).val();
            }); 
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: countyList, type: 'county', done: '.county-located-question'}},
                success: function(response){
                    console.log(response)
                    countyList.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-county');
                    })
                    questionSwitcher('.county-located-question')
                }
            })
        })
        
        
        jQuery('#accommodation').on('submit', (e) => {
            e.preventDefault();

            var capacity = [];
            var i = 0;
            jQuery('.rd__accommodation:checked').each(function () {
                capacity[i++] = jQuery(this).val();
            }); 
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: capacity, type: 'accommodation', done: '.accommodation-question'}},
                success: function(response){
                    console.log(response)
                    jQuery('#accommodation-count').text(capacity[0])
                    questionSwitcher('.accommodation-question')
                }
            })
        })


        jQuery('#style').on('submit', (e) => {
            e.preventDefault();

            var styleList = [];
            var i = 0;
            jQuery('.cb__style:checked').each(function () {
                styleList[i++] = jQuery(this).val();
            }); 
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: styleList, type: 'style', done: '.style-question'}},
                success: function(response){
                    console.log(response)
                    styleList.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-of-style')
                    })
                    questionSwitcher('.style-question')
                }
            })
        })


        jQuery('#service-description').on('submit', (e) => {
            e.preventDefault();

            var serviceDescriptionList = [];
            var i = 0;
            jQuery('.rd__service_description:checked').each(function () {
                serviceDescriptionList[i++] = jQuery(this).val();
            }); 
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: serviceDescriptionList, type: 'serviceDescription', done: '.service-description-question'}},
                success: function(response){
                    console.log(response)
                    serviceDescriptionList.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-of-category');
                    })
                    questionSwitcher('.service-description-question')
                }
            })
        })


        jQuery('#venue-description').on('submit', (e) => {
            e.preventDefault();

            var venueDescriptionList = [];
            var i = 0;
            jQuery('.cb__venue_description:checked').each(function () {
                venueDescriptionList[i++] = jQuery(this).val();
                // if(jQuery(this).val() !== 'Other:'){
                // }else{
                //     venueDescriptionList[i++] = jQuery('#venue_description-input').val();
                // }
            });
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: venueDescriptionList, type: 'venueDescription', done: '.venue-description-question'}},
                success: function(response){
                    console.log(response)
                    venueDescriptionList.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-venue-description')
                    })
                    questionSwitcher('.venue-description-question')
                }
            })
        })


        jQuery('#venue-features').on('submit', (e) => {
            e.preventDefault();

            var venueFeatureList = [];
            var i = 0;
            jQuery('.cb__venue_features:checked').each(function () {
                venueFeatureList[i++] = jQuery(this).val();
            }); ;
            jQuery.ajax({
                url: fmw_ajax.ajaxurl,
                method: 'POST',
                data: {action: 'listingInfoUpdate', data: {value: venueFeatureList, type: 'venueFeature', done: '.venue-features-question'}},
                success: function(response){
                    console.log(response)
                    venueFeatureList.map(item => {
                        jQuery(`<li>${item}</li>`).appendTo('#list-features')
                    })
                    questionSwitcher('.venue-features-question')
                }
            })
        })




    })


</script>
