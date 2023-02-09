jQuery(document).ready(function($){
    

	$('form#login').on('submit', function(e){
        e.preventDefault();
        var _is_error = false,
            loginform = $(this);
        loginform.find('.simple-input').each(function(){
            if( $(this).attr('data-required') && !$(this).val() ){
                $(this).addClass('invalid');
                _is_error = true;
            }else{
                $(this).removeClass('invalid');
            }
        });
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: { 
                'action'   : 'ajaxlogin',
                'username' : loginform.find('input[name="username"]').val(),
                'password' : loginform.find('input[name="password"]').val(),
                'security' : loginform.find('input[name="security"]').val()
            },
            success: function(data){
                if( data.loggedin == true ){
                    window.location.href = data.redirect_url;
                }
                else
            	   $('#login').find('.input').addClass('error');
            }
        });        
    });

    $('body').on('click', '.recovery-button', function(e){
        e.preventDefault();
        $('#login').toggle();
        $('#recovery').toggle();
    });

    $('form#recovery').on('submit', function(e){
        e.preventDefault();
        var loginform = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: { 
                'action'   : 'recovery_password',
                'usermail' : loginform.find('input[name="usermail"]').val()
            },
            success: function(data){
                if( data.user == false ){
                    $('#recovery').find('.input').addClass('error');
                }else{
                    $('#recovery').hide();
                    $('#login').show();
                    $('.popup-wrapper').addClass('active');
                    $('#recovery-popup').addClass('active');
                }
                //console.log(data);
            }
        });        
    });


    $('body').on( 'click', '.open-popup[data-link]', function(){
        if($(this).data('link')){
            $('.wpcf7-form').find('.for-file-id').val($(this).data('link'));
        }else{
            $('.wpcf7-form').find('.for-file-id').val('');
        }
    });

    function downloadURI(uri, name) {
      var link = document.createElement("a");
      // link.download = name;
      link.target = '_blank';
      link.href = uri;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      delete link;
    }

    $(document).on('click', '.downloadres:not(.open-popup)', function(event) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: { 
                'action'  : 'jmw_download_url',
                'file_id' : $(this).attr('data-link')
            },
            success: function(data){
                $('.downloadres').removeClass('open-popup');
                downloadURI(data.url, data.named);  
            }
        }); 
    });
    console.log('123');
    document.addEventListener( 'wpcf7mailsent', function( event ) {
        console.log(event.detail.contactFormId);
        if(event.detail.contactFormId == '604'){
            var inputs = event.detail.inputs;
            for( var i = 0; i < inputs.length; i++ ){
              if ( 'file-id' == inputs[i].name ){
                if( inputs[i].value ){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: ajaxurl,
                        data: { 
                            'action'  : 'jmw_download_url',
                            'file_id' : inputs[i].value
                        },
                        success: function(data){
                            $('.popup-content').removeClass('active');
                            $('.popup-wrapper').removeClass('active');
                            $('html').removeClass('overflow-hidden');
                            // $('#thank-popup').addClass('active');
                            $('.downloadres').removeClass('open-popup');
                            downloadURI(data.url, data.named);  
                        }
                    }); 
                }else{
                    $('.popup-content').removeClass('active');
                    $('.popup-wrapper').addClass('active');
                    $('#thank-popup').addClass('active');
                }
              }
            }
        }else if(event.detail.contactFormId == '422'){
            $('.file-name').text('Upload Resume');
            $('.popup-wrapper').addClass('active');
            $('#thank-popup').addClass('active');
        }else{
            $('.popup-wrapper').addClass('active');
            $('#thank-popup').addClass('active');
        }
      return false;
    }, false );

    //mailchimp
    $(document).ajaxComplete(function( event, xhr, settings ){
        if( jQuery.type( settings.data ) === "string" ){
            if( settings.data.split('&')[0] == 'action=process_form_submission' ){
                if( xhr.responseJSON && xhr.responseJSON.success ){
                    $('input.yikes-easy-mc-email').removeClass('error-field');
                    //console.log('true');
                } else if( xhr.responseJSON ){
                    $('input.yikes-easy-mc-email').addClass('error-field');
                }
            }
        }
    });

    $(document).on('click', '.show-more-button', function(e){
        e.preventDefault();
        $(this).hide();
        $(this).siblings('[data-list-id='+$(this).data('link-id')+']').find('li').removeClass('hidden');
    });
    $(document).on('click', '.webinar-show-more-button', function(e){
        e.preventDefault();
        $(this).hide();
        $(this).siblings('.space-lg').hide();
        $(this).parent().find('.hidden').removeClass('hidden');
    });

    //scroll to contact form
    $('.scrolltocontact').on('click', function(event) {
        if($('.contact-form-shortcode').length){
        $('html, body').animate({
            scrollTop: $('.contact-form-shortcode').offset().top
        }, 1500);
        }
        return false;
    });
    

    $('.icontact-text').hide();

	$('form#icontactform').on('submit', function(e){
        $('.loading-button').addClass('loader');
        e.preventDefault();
        $('.loading-button').prop('disabled', true);
        var subform = $(this);
           

        $.ajax({

            type: 'POST',

            dataType: 'json',

            url: ajaxurl,

            data: { 

                'action'   : 'icontact_sub',

                'email' : subform.find('input[name="email"]').val()
            },

            success: function(data){

                if( data.succsess == true ){
                   
                    setTimeout(function() { 
                    $('.icontact-text').text(data.message);
                    $('.icontact-text').show();              
                   
                    $('.loading-button').prop('disabled', false); 
                    $("#icontactform")[0].reset();                  
                    }, 1000);
                    
                    $('.loading-button').removeClass('loader');
                    
                }

                else{
                    $('.icontact-text').text(data.message);
                    $('.icontact-text').show();
                }

            	   

            }

        });        

    })

});