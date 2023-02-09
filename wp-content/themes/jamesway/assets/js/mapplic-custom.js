jQuery(function($) {
    'use strict';

    // initialization mapplick
    $('#mapplic').mapplic({
        // source: '/wp-content/themes/jamesway/usa.json',
        source: '/core/assets/aec0155b06/locations-usa.json', 
        height: 750,
        landmark: false,
        search: false,
        lightbox: false,
        sidebar: false,
        minimap: false,
        zoombuttons: false,
        fullscreen: false,
        hovertip: true,
        maxscale: 1,
        zoom: false,        
        clearbutton: false
    });

    $('#mapplic-world').mapplic({
        // source: '/wp-content/themes/jamesway/world.json',
        source: '/core/assets/aec0155b06/locations-world.json',
        height: 750,
        landmark: false,
        search: false,
        lightbox: false,
        sidebar: false,
        minimap: false,
        zoombuttons: false,
        fullscreen: false,
        hovertip: true,
        maxscale: 1,
        zoom: false,        
        clearbutton: false
    });

    if ($(window).width() < 992) {
        let locations_block = $(document).find('.mobile_locations');
        let locations_world = $(document).find('.mobile_world');
        $.ajax({
            url: '/core/assets/aec0155b06/locations-usa.json',
            type: 'get',
            dataType: 'json',
            error: function (data) {
                console.log('error');
            },
            success: function (data) {
                let locations = data.levels[0].locations;
                for (let i = 0; i < locations.length; i++) {
                    locations_block.append('<div class="accordion-item"><div class="accordion-title2">'+locations[i].title+'</div><div class="accordion-inner"><div class="mapplic-tooltip-description">'+locations[i].description+'</div></div></div>');
                }
            }
        });
        $.ajax({
            url: '/core/assets/aec0155b06/locations-world.json',
            type: 'get',
            dataType: 'json',
            error: function (data) {
                console.log('error');
            },
            success: function (data) {
                let locations = data.levels[0].locations;
                for (let i = 0; i < locations.length; i++) {
                    locations_world.append('<div class="accordion-item"><div class="accordion-title2">'+locations[i].title+'</div><div class="accordion-inner"><div class="mapplic-tooltip-description">'+locations[i].description+'</div></div></div>');
                }
            }
        });
    }
});
