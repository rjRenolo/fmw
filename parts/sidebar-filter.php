 <!-- <form method="GET" id="refineform" action="< ?php echo get_the_permalink(get_field('supplier_directory_page','option'));?>"> -->
 <?php
 global $wp;
 $showsupplier = "";
 $venuesupplier = "";

 $refinedCounty = [];
 if(isset($_GET['county'])){
     foreach($_GET['county'] as $rCounty){
         $refinedCounty[] = $rCounty;
     }
 }

 $refinedStyle = [];
 if(isset($_GET['style'])){
    foreach($_GET['style'] as $rStyle){
        $refinedStyle[] = $rStyle;
    }
 }
 

 $refinedCapacity = [];
 if(isset($_GET['accommodation'])){
    foreach($_GET['accommodation'] as $rCapacity){
        $refinedCapacity[] = $rCapacity;
    }
}

$refinedFeatures = [];
if(isset($_GET['venue_features'])){
   foreach($_GET['venue_features'] as $rFeatures){
       $refinedFeatures[] = $rFeatures;
   }
}

$refinedTypes = [];
if(isset($_GET['venue_type'])){
   foreach($_GET['venue_type'] as $rType){
       $refinedTypes[] = $rType;
   }
}


$refinedCategories = [];
if(isset($_GET['venue_category'])){
    foreach($_GET['venue_category'] as $rCategs){
        $refinedCategories[] = $rCategs;
    }
}



 
 

 ?>
 <form method="GET" id="refineform" action="<?php echo home_url($wp->request);?>">
        <?php if(get_field('supplier_directory_page','option') == $post->ID) {
            $searchtype = "supplier";
            $showsupplier = "showing";
            $resetlink = get_the_permalink(get_field('supplier_directory_page','option'));
            $supplierbuttonlabel = 'Showing Suppliers';
            $venuebuttonlabel = 'Search Venues';
        } else {
            $searchtype = "venue";
            $venuesupplier = "showing";
            $resetlink = get_the_permalink(get_field('venue_directory_page','option'));
            $supplierbuttonlabel = 'Search Suppliers';
            $venuebuttonlabel = 'Showing Venues';
        } ?>
            
           

            <h3 class="refine-heading">Refine Results</h3>
            <p><a href="<?php echo $resetlink;?>" class="resetFilter">Reset filter &raquo;</a></p>

            <div class="filter-wrapper">
                <div class="location-filter filter-box">
                    <div class="filter-title">
                        <h3>Location </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>
                    <div id="location-filters" class="filter-options" <?php echo count($refinedCounty) > 0 ? "style='display:block;'" : ""?>>

                        <?php
                        $availableTerms = apply_filters( 'get_all_listing_counties', $id );         
                        foreach($availableTerms as $item){?>

                            <?php if(in_array($item['name'], $refinedCounty)){ ?>
                                <div class="cb-group">
                                    <input checked class="cb__county" type="checkbox" name="county[]" id="county_<?=$item['slug']?>" value="<?=$item['name']?>">
                                    <label for="county_<?=$item['slug']?>"><?=$item['name']?></label>
                                </div>
                            <?php }else{ ?>
                                <div class="cb-group">
                                    <input class="cb__county" type="checkbox" name="county[]" id="county_<?=$item['slug']?>" value="<?=$item['name']?>">
                                    <label for="county_<?=$item['slug']?>"><?=$item['name']?></label>
                                </div>
                            <?php } ?>


                        <?php } ?>
                                               
                    </div>
                </div> 

                <?php if($searchtype == 'supplier') { ?>
                
                    <div class="style-filter filter-box">
                        <div class="filter-title">
                            <h3>Category</h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div id="style-filters" class="filter-options" <?php echo count($refinedCategories) > 0 ? "style='display:block;'" : ""?>>

                            <?php
                            $availableTerms = apply_filters( 'get_all_listing_type', $id );         
                            foreach($availableTerms as $item){?>

                            <?php if( in_array( str_replace('&amp;', '&', $item['name']), $refinedCategories ) ) { ?>
                                <div class="cb-group">
                                    <input checked class="cb__venue_category" type="checkbox" name="venue_category[]" id="venue_category_<?=$item['slug']?>" value="<?=$item['name']?>">
                                    <label for="venue_category_<?=$item['slug']?>"><?=$item['name']?></label>
                                </div>
                            <?php }else{ ?>
                                <div class="cb-group">
                                    <input class="cb__venue_category" type="checkbox" name="venue_category[]" id="venue_category_<?=$item['slug']?>" value="<?=$item['name']?>">
                                    <label for="venue_category_<?=$item['slug']?>"><?=$item['name']?></label>
                                </div>
                            <?php } ?>


                            <?php } ?>
                            
                               
                        </div>  
                    </div>
                    <!-- Category -->
                <?php } ?>

                    <div class="capacity-filter filter-box">
                        <div class="filter-title">
                            <h3><?php echo ($searchtype == 'venue' ? 'Capacity' : 'Guest Numbers');?></h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div id="capacity-filters" class="filter-options" <?php echo count($refinedCapacity) > 0 ? "style='display:block;'" : ""?>>

                            <?php
                            $availableTerms = apply_filters( 'get_all_listing_capacity', $id );         
                            foreach($availableTerms as $item){?>

                                <?php if(in_array($item['name'], $refinedCapacity)){ ?>

                                    <div class="cb-group">
                                        <input checked class="cb__accommodation" type="checkbox" name="accommodation[]" id="accommodation_<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="accommodation_<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>

                                <?php }else{ ?>

                                    <div class="cb-group">
                                        <input class="cb__accommodation" type="checkbox" name="accommodation[]" id="accommodation_<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="accommodation_<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>

                                <?php }?>


                            <?php } ?>
                            
                              
                            
                        </div>  
                    </div><!-- Capacity -->


                <?php if($searchtype == 'venue') { ?>
                    <div class="venutype-filter filter-box">
                        <div class="filter-title">
                            <h3>Venue Type </h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div id="venutype-filters" class="filter-options" <?php echo count($refinedTypes) > 0 ? "style='display:block;'" : ""?>>
                            
                            <?php
                            $availableTerms = apply_filters( 'get_all_listing_type', $id );         
                            foreach($availableTerms as $item){?>
                                <?php if(in_array($item['name'], $refinedTypes)){ ?>
                                    <div class="cb-group">
                                        <input checked class="cb__venuetype" type="checkbox" name="venue_type[]" id="venue_type<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="venue_type<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php }else{ ?>
                                    <div class="cb-group">
                                        <input class="cb__venuetype" type="checkbox" name="venue_type[]" id="venue_type<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="venue_type<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        
                        </div>  
                    </div><!-- Venue Type -->
                <?php } ?>


                <?php if($searchtype == 'venue') { ?>
                    <div class="features-filter filter-box">
                        <div class="filter-title">
                            <h3>Features </h3>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div id="features-filters" class="filter-options" <?php echo count($refinedFeatures) > 0 ? "style='display:block;'" : ""?>>
                            
                            <?php
                            $availableTerms = apply_filters( 'get_all_listing_features', $id );         
                            foreach($availableTerms as $item){?>
                                <?php if(in_array($item['name'], $refinedFeatures)){ ?>
                                    <div class="cb-group">
                                        <input checked class="cb__accommodation" type="checkbox" name="venue_features[]" id="venue_features<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="venue_features<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php }else{ ?>
                                    <div class="cb-group">
                                        <input class="cb__accommodation" type="checkbox" name="venue_features[]" id="venue_features<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="venue_features<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        
                        </div>  
                    </div><!-- Features -->
                <?php } ?>


                


                <div class="category-filter filter-box">
                    <div class="filter-title">
                        <h3>Style </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>
                    <div id="category-filters" class="filter-options" <?php echo count($refinedStyle) > 0 ? "style='display:block;'" : ""?>>
                        
                        <?php
                        $availableTerms = apply_filters( 'get_all_listing_styles', $id );         
                        foreach($availableTerms as $item){?>

                            
                                <?php if(in_array(str_replace('&amp;', '&', $item['name']), $refinedStyle)){ ?>
                                    <div class="cb-group">
                                        <input checked class="cb__style" type="checkbox" name="style[]" id="style_<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="style_<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php }else{ ?>
                                    <div class="cb-group">
                                        <input class="cb__style" type="checkbox" name="style[]" id="style_<?=$item['slug']?>" value="<?=$item['name']?>">
                                        <label for="style_<?=$item['slug']?>"><?=$item['name']?></label>
                                    </div>
                                <?php } ?>


                        <?php } ?>
                        
                    </div>  
                </div><!-- Style -->


                

            </div>

            <input type="submit" class="primary-btn has-pink-background-color has-white-color filter-button" value="Update Results">
        </form>

        <script>
            jQuery(document).ready(function() {
                jQuery('.filter-title').on('click', (e) => {
                    if(jQuery(e.target).next('.filter-options').length > 0){
                        jQuery(e.target).next('.filter-options').slideToggle()
                    }else{
                        jQuery(e.target).parent().next('.filter-options').slideToggle()
                    }
                })
            })
        </script>