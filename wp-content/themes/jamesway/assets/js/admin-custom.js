var _functions = {};
jQuery(function($) {
    "use strict";

    // Import file
    $(document).on('click', '.map-settings', function(e) {
        e.preventDefault();
      
        $('.load').addClass('loader');

     
        $.ajax({

            type: "POST",

            url: ajaxurl,

            data: {

                action : 'ajax_safe_map',                

            },

            success: function(response) {                
                alert('Done');
            },

            error: function(response) {
               alert('Fail');
            }

        });
        
    }); 
     


});