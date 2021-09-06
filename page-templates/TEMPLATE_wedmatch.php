<?php 
/*
Template Name: Wedmatch for couples
*/

if(is_user_logged_in() && current_user_can('business')) {
	header('Location: ' . get_the_permalink(get_field('listing_dashboard','option')));
}
if(is_user_logged_in() && current_user_can('couple')) {
	header('Location: ' . get_the_permalink(get_field('couples_dashboard','option')));
}


Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>


	<!-- <script src="< ?php echo get_bloginfo('template_directory');?>/js/angular.js"></script> -->
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo get_bloginfo('template_directory');?>/js/wedmatch.js"></script>

	<div ng-app="wedmatch" id="wedmatch">
		<div ng-controller="coupleController">
			
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
			<?php endwhile; ?>

			<div class="container">

				<div class="slide-card active" id="startWedmatch">
					<h2>OK let's start matching...</h2>

					<p>What are your names?</p>
					<div class="input-wrap">
						<input type="text" name="name1" ng-model="couple.name1" placeholder="Your name e.g. Emma or Dave" ng-value="name1"/>
					</div>
					<div class="input-wrap">
						<input type="text" name="name2" ng-model="couple.name2" placeholder="Your partners name e.g. Melinda or Steve"  ng-value="name2"/>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide2')" ng-disabled="couple.name1 == '' || couple.name2 == '' ">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide2">
					
					<h3>And who's who?</h3>
					<div class="input-wrap">
						<strong>{{couple.name1}}</strong> is a
						<select ng-model="couple.name1status">
							<option value="Bride">Bride</option>
							<option value="Groom">Groom</option>
						</select>
					</div>
					<div class="input-wrap">
						<strong>{{couple.name2}}</strong> is a
						<select ng-model="couple.name2status">
							<option value="Bride">Bride</option>
							<option value="Groom">Groom</option>
						</select>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide3')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide3">
					<h3>Which of the below describes you?</h3>

					<div class="box-select-wrap">
						<div class="box-select" ng-click="selectUserDescription('budgetPlanner')" ng-class="{active : userdescription == 'budgetPlanner'}">
							<img src="<?php echo get_bloginfo('template_directory');?>/images/global/budgetPlanner.png" alt="" />
							<p><strong>Budget Planner</strong></p>
							<p>I’m cutting any unnecessary costs to make sure my big day doesn’t end up quite literally breaking the bank.</p>
						</div>

						<div class="box-select" ng-click="selectUserDescription('meticulous')" ng-class="{active : userdescription == 'meticulous'}">
							<img src="<?php echo get_bloginfo('template_directory');?>/images/global/meticulous.png" alt="" />
							<p><strong>Mr or Miss Meticulous</strong></p>
							<p>I know what I want, down to the smallest detail &amp; I won’t accept anything less.</p>
						</div>

						<div class="box-select" ng-click="selectUserDescription('lastMinute')" ng-class="{active : userdescription == 'lastMinute'}">
							<img src="<?php echo get_bloginfo('template_directory');?>/images/global/lastMinute.png" alt="" />
							<p><strong>Last minute.com</strong></p>
							<p>I leave all the details to the last minute. I know I’m laidback, but I’m going to be exchanging vows with my significant other one way or another.</p>
						</div>

						<div class="box-select" ng-click="selectUserDescription('lifeSoul')" ng-class="{active : userdescription == 'lifeSoul'}">
							<img src="<?php echo get_bloginfo('template_directory');?>/images/global/budgetPlanner.png" alt="" />
							<p><strong>Life and soul</strong></p>
							<p>Forget the ceremony, I’m here for the party! I’m going to put more planning into the evening’s playlist than what flowers I’ll be carrying down the aisle.</p>
						</div>

						<div class="box-select" ng-click="selectUserDescription('hopelessRomantic')" ng-class="{active : userdescription == 'hopelessRomantic'}">
							<img src="<?php echo get_bloginfo('template_directory');?>/images/global/hopelessRomantic.png" alt="" />
							<p><strong>Hopeless romantic</strong></p>
							<p>I'm a walking, talking bridal stereotype &amp; I love it – I’ve had my wedding planned since I was 5 years old!</p>
						</div>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide4')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide4">
					
					<h3>What date is your wedding?</h3>
					<div class="input-wrap">
						<input type="text" id="datepicker" class="deliverydate" value="{{weddingDate}}" >
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide5')">Next &raquo</button>
					</div>

					<p class="skipQuestion" ng-click="goToSlide('slide5')">Skip this question &raquo;</p>

				</div>

				<div class="slide-card " id="slide5">
					<h3>Have you booked your ceremony?</h3>

					<div class="input-wrap">
						<select ng-model="ceremony.ceremonyBooked">
							<option value="Yes">Yes, it's booked</option>
							<option value="No">No, not yet</option>
						</select>
					</div>

					<?php $listingLicenseTypes = get_terms( array( 'taxonomy' => 'listing-license-type' , 'hide_empty' => false )); ?>

					<div class="input-wrap">
						<p  ng-hide="ceremony.ceremonyBooked == 'No'">We've booked a... </p>
						<p  ng-hide="ceremony.ceremonyBooked == 'Yes'">We're planning a... </p>
						<select ng-model="ceremony.ceremonyVenueType" ng-init="ceremony.ceremonyVenueType='<?php echo $listingLicenseTypes[0]->name;?>'">

							<?php 
							foreach($listingLicenseTypes as $lLicenseType){ ?>
								<option value="<?php echo $lLicenseType->name; ?>" ><?php echo $lLicenseType->name; ?></option>
							<?php } ?>

						</select>
					</div>

					<div class="input-wrap" ng-hide="ceremony.ceremonyBooked == 'No'">
						<p>Our ceremony is at</p>
						<input type="text" name="ceremonyBookedVenue" ng-model="ceremony.ceremonyBookedVenue" placeholder="e.g. St Davids Church, Swansea"  ng-value="ceremony.ceremonyBookedVenue"/>
					</div>

					
					<div class="input-wrap">
						<button ng-click="goToSlide('slide6')" ng-disabled="ceremony.ceremonyBooked == 'Yes' && ceremony.ceremonyBookedVenue == ''">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card " id="slide6">
					<h3>How many guests will be at your ceremony?</h3>

					<div class="input-wrap">
						<select ng-model="ceremony.ceremonyNumberGuests">
							<option value="0">Not sure yet</option>

							<?php $listingAccommodations = get_terms(     array( 'taxonomy' => 'listing-capacity'     , 'hide_empty' => false, 'orderby' => 'id', 'order'=>'DESC'));?>

							<?php foreach($listingAccommodations as $listingAccommodation){ ?>
								<option value="<?php echo $listingAccommodation->name;?>"><?php echo $listingAccommodation->name;?></option>
							<?php } ?>

						</select>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide7')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide7">
					<h3>Have you booked your wedding reception?</h3>

					<div class="input-wrap">
						<select ng-model="reception.receptionBooked">
							<option value="Yes">Yes, it's booked</option>
							<option value="No">No, not yet</option>
						</select>
					</div>

					<?php $listingVenueTypes = get_terms(  array( 'taxonomy' => 'listing-venue-type'   , 'hide_empty' => false));?>

					<div class="input-wrap">
						<p  ng-hide="reception.receptionBooked == 'No'">We've booked a... </p>
						<p  ng-hide="reception.receptionBooked == 'Yes'">We're looking for a... </p>

						<select ng-model="reception.receptionType" ng-init="reception.receptionType='<?php echo $listingVenueTypes[0]->name;?>'">
							<?php foreach($listingVenueTypes as $listingVenueType){ ?>
								<option value="<?php echo $listingVenueType->name; ?>" ><?php echo $listingVenueType->name; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="input-wrap" ng-show="reception.receptionBooked == 'Yes'">
						<p>Our reception is being held at</p>
						<input type="text" name="receptionVenue" ng-model="reception.receptionVenue" placeholder="e.g. The Black Lion, Cardiff"  ng-value="reception.receptionVenue"/>
					</div>

					<div class="input-wrap" ng-show="reception.receptionBooked == 'No'">
						<?php $listingCounties = get_terms( array( 'taxonomy' => 'listing-location', 'hide_empty' => false));?>
						<p>Where in Wales would you like your wedding reception to take place?</p>
						<select ng-model="reception.receptionLocation" ng-init="reception.receptionLocation='<?php echo $listingCounties[0]->name;?>'">
							<?php foreach($listingCounties as $listingCountie){ ?>
								<option value="<?php echo $listingCountie->name; ?>" ><?php echo $listingCountie->name; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="input-wrap">
						<button ng-click="goToSlide('slide8')" ng-disabled="reception.receptionBooked == 'Yes' && reception.receptionVenue == ''">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card " id="slide8">
					<h3>What factors are important to you when selecting your venue?</h3>
					<p style="font-weight: normal;"><small>Select as many as are relevant</small></p>

					<p>Sleeping Arrangements</p>
					<?php $listingSleepings = get_terms( array( 'taxonomy' => 'listing-accommodation', 'hide_empty' => false));?>
					<div class="box-select-wrap">
						<?php foreach($listingSleepings as $listingSleeping){ ?>
							<div class="box-select text-box-select" ng-click="selectSleeping('<?php echo $listingSleeping->name;?>'); addActive('<?php echo $listingSleeping->slug;?>')" id='<?php echo $listingSleeping->slug;?>'>
								<p><strong><?php echo $listingSleeping->name;?></strong></p>
							</div>
						<?php } ?>
					</div>

					<p>Food and Drink</p>
					<?php $listingFoods = get_terms( array( 'taxonomy' => 'listing-fooddrink'     , 'hide_empty' => false));?>
					<div class="box-select-wrap">
						<?php foreach($listingFoods as $listingFood){ ?>
							<div class="box-select text-box-select" ng-click="selectFoodDrink('<?php echo $listingFood->name;?>'); addActive('<?php echo $listingFood->slug;?>')" id='<?php echo $listingFood->slug;?>'>
								<p><strong><?php echo $listingFood->name;?></strong></p>
							</div>
						<?php } ?>
					</div>

					<p>Venue Features</p>
					<?php $listingVenueFeatures = get_terms( array( 'taxonomy' => 'listing-features'     , 'hide_empty' => false));?>
					<div class="box-select-wrap">
						<?php foreach($listingVenueFeatures as $listingVenueFeature){ ?>
							<div class="box-select text-box-select" ng-click="selectVenueFeature('<?php echo $listingVenueFeature->name;?>'); addActive('<?php echo $listingVenueFeature->slug;?>')" id='<?php echo $listingVenueFeature->slug;?>'>
								<p><strong><?php echo $listingVenueFeature->name;?></strong></p>
							</div>
						<?php } ?>
					</div>
				
					<div class="input-wrap">
						<button ng-click="goToSlide('slide9')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide9">
					<h3>Wedding Reception Size</h3>

					<div class="input-wrap">
						<select ng-model="reception.receptionNumberGuests">
							<option value="0">Not sure yet</option>

							<?php $listingReceptionguests = get_terms(     array( 'taxonomy' => 'listing-reception-capacity'     , 'hide_empty' => false, 'orderby' => 'id', 'order'=>'ASC'));?>

							<?php foreach($listingReceptionguests as $listingReceptionguest){ ?>
								<option value="<?php echo $listingReceptionguest->name;?>"><?php echo $listingReceptionguest->name;?> Guests</option>
							<?php } ?>

						</select>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide10')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide10">
					<h3>My Wedding Style</h3>

					<div class="box-select-wrap">

						<?php $listingStyles = get_terms( array( 'taxonomy' => 'listing-style' , 'hide_empty' => false, 'orderby' => 'id', 'order'=>'ASC'));?>

						<?php foreach($listingStyles as $listingStyle){ ?>
							<div class="box-select" ng-click="selectStyle('<?php echo $listingStyle->name;?>');" ng-class="{active : wedding.weddingStyle == '<?php echo $listingStyle->name;?>'}">
								<p><strong><?php echo $listingStyle->name;?></strong></p>
							</div>
						<?php } ?>

					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide11')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card" id="slide11">
					<h3>What are you looking for?</h3>
					<p style="font-weight: normal;"><small>Select as many as are relevant</small></p>

					<?php $listingCategorys = get_terms( array( 'taxonomy' => 'listing-category', 'hide_empty' => false));?>
					<div class="box-select-wrap">
						<?php foreach($listingCategorys as $listingCategory){ ?>
							<div class="box-select" ng-click="selectCategory('<?php echo $listingCategory->name;?>'); addActive('<?php echo $listingCategory->slug;?>')" id='<?php echo $listingCategory->slug;?>'>
								<p><strong><?php echo $listingCategory->name;?></strong></p>
							</div>
						<?php } ?>
					</div>

					<div class="input-wrap">
						<button ng-click="goToSlide('slide12')">Next &raquo</button>
					</div>

				</div>

				<div class="slide-card " id="slide12">
					<h3>Create your free account</h3>
					<p class="register-message" style="display:none"></p>
				    <form action="#" method="POST" name="register-form" class="register-form">

				          <input type="text"  name="new_user_name" placeholder="Username" id="new-username" required>
				          <input type="email"  name="new_user_email" placeholder="Email address" id="new-useremail" required>
				          <input type="password"  name="new_user_password" placeholder="Password" id="new-userpassword" required>
				          <input type="password"  name="re-pwd" placeholder="Re-enter Password" id="re-pwd" required>
				          <input type="hidden"  name="userType" value="couple">
				          <input type="submit"  class="button has-pink-background-color" id="register-button" value="Register"  >
				    </form> 
				</div>

				<script type="text/javascript">
			      jQuery('.register-form').on('submit',function(e){
			        e.preventDefault();

			        jQuery('.register-message').text('').hide();

			        var newUserName = jQuery('#new-username').val();
			        var newUserEmail = jQuery('#new-useremail').val();
			        var newUserPassword = jQuery('#new-userpassword').val();
					var userType = 'couple';

					var scope = angular.element('[ng-controller=coupleController]').scope();
					console.log(scope)
					console.log('------------')
					console.log('name1', scope.couple.name1)
					console.log('name2', scope.couple.name2)

					console.log('name1status', scope.couple.name1status)
					console.log('name2status', scope.couple.name2status)

					console.log('userdescription', scope.userdescription)
					console.log('------------')
					console.log('selectedDeliveryDate', scope.selectedDeliveryDate)
					console.log('------------')
					// conosle.log('ceremony', scope.ceremony)
					console.log('Listing License Type')
					console.log('ceremonyceremonyVenueType', scope.ceremony.ceremonyVenueType)

					console.log('------------')

					console.log('Ceremony Guests')
					console.log('ceremonyceremonyNumberGuests', scope.ceremony.ceremonyNumberGuests)

					console.log('------------')

					console.log('Listing Venue Type')
					console.log('receptionType', scope.reception.receptionType)

					console.log('Location')
					console.log('either receptionVenue or receptionLocation')

					console.log('receptionPlace', scope.reception.receptionVenue)
					console.log('receptionPlace', scope.reception.receptionLocation)
					
					console.log('------------')

					console.log('Listing Accommodation')
					console.log('receptionSleepingArrangements', scope.reception.receptionSleepingArrangements)

					console.log('Listing Food and Drink')
					console.log('receptionFoodDrink', scope.reception.receptionFoodDrink)

					console.log('Listing Feature')
					console.log('receptionFeatures', scope.reception.receptionFeatures)

					console.log('Reception Guests')
					console.log('receptionNumberGuests', scope.reception.receptionNumberGuests)

					console.log('------------')
					
					console.log('Listing Style')
					console.log('weddingStyle', scope.wedding.weddingStyle)
					
					console.log('------------')

					console.log('Category')
					console.log('weddingSuppliers', scope.wedding.weddingSuppliers)

					console.log('end')
					


			        if(!jQuery('#new-userpassword').val() =="" && jQuery('#new-userpassword').val() == jQuery('#re-pwd').val()) {
						var theLocation = '';
						if(scope.reception.receptionVenue === ""){
							theLocation = scope.reception.receptionLocation
						}else{
							theLocation = scope.reception.receptionVenue
						}
				        jQuery.ajax({
				          type:"POST",
				          url:"<?php echo admin_url('admin-ajax.php'); ?>",
				          data: {
				            action: "register_user_front_end",
				            new_user_name : newUserName,
				            new_user_email : newUserEmail,
				            new_user_password : newUserPassword,
							userType: userType,

							name1: scope.couple.name1,
							name1status: scope.couple.name1status,
							name2: scope.couple.name2,
							name2status: scope.couple.name2status,

							userdescription: scope.userdescription,

							weddingDate: scope.selectedDeliveryDate,

							listingLicenseType: scope.ceremony.ceremonyVenueType,

							ceremonyGuests: scope.ceremony.ceremonyNumberGuests,

							listingVenueType: scope.reception.receptionType,

							location: theLocation,

							listingAccommodation: scope.reception.receptionSleepingArrangements,

							listingFoodDrink: scope.reception.receptionFoodDrink,

							listingFeature: scope.reception.receptionFeatures,

							receptionGuests: scope.reception.receptionNumberGuests,

							listingStyle: scope.wedding.weddingStyle,

							category: scope.wedding.weddingSuppliers
							
				          },
				          success: function(results){
				            if(results == 'success') {
				            	window.location.href = '<?php echo get_the_permalink(get_field('login_page','option'));?>';
				            } else {
				            	jQuery('.register-message').text(results).show();
				            }
				          },
				          error: function(results) {

				          }
				        });
				    } else {
				    	jQuery('.register-message').text('The passwords must match').show();
				    }
			      });

				//   jQuery(document).ready(function($){
				// 	// var coupleController = angular.element(document.getElementById('wedmatch')).scope()
				// 	// console.log()
				// 	// console.log(coupleController)
				// 	var scope = angular.element('[ng-controller=coupleController]').scope();
				// 	// console.log(angular.element(document.getElementById('wedmatch')).scope())
				// 	// scope.testFunc()
				// 		$('#webbtn').on('click', function(){
				// 			console.log($('#coupledata'))
				// 		})
				//   })
			    </script>


			</div>
		</div>
	</div>



<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>