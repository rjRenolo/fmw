var app = angular.module("wedmatch", []).run(function ($rootScope, $location, $http) {})


app.filter('unsafe', function ($sce) {
    return function (val) {
        return $sce.trustAsHtml(val);
    };
});

app.controller("coupleController", function ($scope, $http, $location, $rootScope, $timeout) {

    $scope.couple = {
        name1 : "",
        name2 : "",
        name1status : 'Bride',
        name2status : 'Bride',
        weddingDate : '',
        weddingBooked : false
    }

    $scope.userdescription = '';

    $scope.ceremony = {
        ceremonyBooked : 'No',
        ceremonyVenueType : '',
        ceremonyBookedVenue : '',
        ceremonyNumberGuests : '0'
    }

    $scope.reception = {
        receptionBooked : 'No',
        receptionVenue : '',
        receptionType : '',
        receptionLocation : '',
        receptionNumberGuests : '0',
        receptionSleepingArrangements : [],
        receptionFoodDrink : [],
        receptionFeatures : [],
    }

    $scope.wedding = {
        weddingStyle : '',
        weddingSuppliers : []
    }


    $scope.selectUserDescription = function (desc) { 
        $scope.userdescription = desc;
    }

    $scope.selectVenueFeature = function (feature) { 
        
        if(Object.values($scope.reception.receptionFeatures).includes(feature)) {
            var index =$scope.reception.receptionFeatures.indexOf(feature);
            if (index !== -1) {
              $scope.reception.receptionFeatures.splice(index, 1);
            }
        } else {
            $scope.reception.receptionFeatures.push(feature);
        }
    }

    $scope.selectSleeping = function (feature) { 
        
        if(Object.values($scope.reception.receptionSleepingArrangements).includes(feature)) {
            var index =$scope.reception.receptionSleepingArrangements.indexOf(feature);
            if (index !== -1) {
              $scope.reception.receptionSleepingArrangements.splice(index, 1);
            }
        } else {
            $scope.reception.receptionSleepingArrangements.push(feature);
        }
    }

    $scope.selectFoodDrink = function (feature) { 
        
        if(Object.values($scope.reception.receptionFoodDrink).includes(feature)) {
            var index =$scope.reception.receptionFoodDrink.indexOf(feature);
            if (index !== -1) {
              $scope.reception.receptionFoodDrink.splice(index, 1);
            }
        } else {
            $scope.reception.receptionFoodDrink.push(feature);
        }
    }

    $scope.selectStyle = function (style) { 
        
        $scope.wedding.weddingStyle = style;
    }

    $scope.selectCategory = function (feature) { 
        
        if(Object.values($scope.wedding.weddingSuppliers).includes(feature)) {
            var index =$scope.wedding.weddingSuppliers.indexOf(feature);
            if (index !== -1) {
              $scope.wedding.weddingSuppliers.splice(index, 1);
            }
        } else {
            $scope.wedding.weddingSuppliers.push(feature);
        }
    }

    $scope.addActive = function (element) { 
        jQuery('#' + element).toggleClass('active');
    }

    $scope.goToSlide =  function(slide) {
        jQuery('.slide-card').removeClass('active');
        jQuery('#'+slide).addClass('active');
    }

    /* intialize date fields with datepicker */
    $scope.setDates = function () {
        var today = new Date();
        today.setDate(today.getDate() + 2);
        //date = date.setDate(date.getDate()-1);

        jQuery(".deliverydate").datepicker({
            format: 'dd/mm/yyyy',
            weekStart: 1,
            daysOfWeekDisabled: "0,6",
            startDate : today
        }).on('changeDate', function(e) {
            $scope.selectedDeliveryDate = jQuery(".deliverydate").val();
         });

    }
    $scope.setDates();




    $scope.saveUserData = function(user) {
        $http({
            method : "GET",
            url : '',
            params : {
                function : 'saveUserData',
                userdata : user
            }
        }).then(function success(response) {
            
        });
    }




});
