jQuery(function($)  {
    var allStatus = '';
    if( mapJSON ){
        allStatus = mapJSON;
    }
    var markers = [], map, myLatlng, marker, image, locations, allStatus, statusInfoWindow, 
        SnazzyWindow,
        /*infowindow = [],*/
        mapMarkerImg = $('#map').attr('data-chickens'),
        mapMarkerImg2 = $('#map').attr('data-ducks'),
        mapMarkerImg3 = $('#map').attr('data-pharmaceutical'),
        mapMarkerImg4 = $('#map').attr('data-other');

    // Create markers
    function addMarker(location, description, status){

        marker = new google.maps.Marker({
            position: location,
            icon: status === 'Chickens' ? mapMarkerImg : status === 'Ducks' ? mapMarkerImg2 : status === 'Pharmaceutical' ? mapMarkerImg3 : mapMarkerImg4
        });

        markers.push(marker);
        marker.setMap(map);
        map.panTo(location);

        google.maps.event.addListener(marker, 'click', function(){ // click on marker and create infowindow
            if (SnazzyWindow) {
                SnazzyWindow.destroy();
            }
            SnazzyWindow = new SnazzyInfoWindow({
                marker: marker,
                position: location,
                content: description,
                closeWhenOthersOpen: true,
                placement: 'top',
                shadow: false,

                'max-width': '310px',
                offset: {
                    top: '-40px',
                    left: '40px'
                },
                
            });
            
            SnazzyWindow.open();
        });
    }


    // initialize map
    function initialize() {
        var lat = $('#map').attr("data-lat");
        var lng = $('#map').attr("data-lng");

        myLatlng = new google.maps.LatLng(lat,lng);

        var setZoom = parseInt($('#map').attr("data-zoom"));

        var styles  = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"lightness":20},{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#d6cece"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#d4ecf3"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"water","elementType":"labels.text","stylers":[{"color":"#e4e4e4"}]}];

        var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});

        var mapOptions = {
            zoom: setZoom,
            zoomControl: true,
            center: myLatlng,
            mapTypeControlOptions: {
              mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
            }
        };

        //Create map
        map = new google.maps.Map(document.getElementById("map"), mapOptions); 
        map.mapTypes.set('map_style', styledMap); 
        map.setMapTypeId('map_style');

        for ( var i = 0; i < allStatus.length; i++ ) {
            myLatlng = new google.maps.LatLng(allStatus[i].location.lat, allStatus[i].location.lng);
            addMarker(myLatlng, allStatus[i].info,  allStatus[i].status);
        }

    }

    function resetMap() {
        if ( markers.length ) {
            for( var i=0; i < markers.length; i++ ){
                markers[i].setMap(null);
            }
            map.panTo(myLatlng);
        }
    }

    // Select filter
    $('.mapFilter').on('click', function() {
        $('.mapFilter').removeClass('filtered');
        $(this).addClass('filtered');

        var dataFilter = $(this).attr('data-filter');

        showActiveStatus(dataFilter);        
    });

    // Load map
    $(window).load(function(){
        setTimeout(function(){if ( $('#map').length ) initialize();}, 500);
    });

});
