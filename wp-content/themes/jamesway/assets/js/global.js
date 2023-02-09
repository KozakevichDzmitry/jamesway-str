/*-------------------------------------------------------------------------------------------------------------------------------*/

/*This is main JS file that contains custom style rules used in this template*/

/*-------------------------------------------------------------------------------------------------------------------------------*/

/* Template Name: "Title"*/

/* Version: 1.0 Initial Release*/

/* Build Date: 06-02-2016*/

/* Author: Title*/

/* Copyright: (C) 2016 */

/*-------------------------------------------------------------------------------------------------------------------------------*/



/*--------------------------------------------------------*/

/* TABLE OF CONTENTS: */

/*--------------------------------------------------------*/

/* 01 - VARIABLES */

/* 02 - page calculations */

/* 03 - function on document ready */

/* 04 - function on page load */

/* 05 - function on page resize */

/* 06 - function on page scroll */

/* 07 - swiper sliders */

/* 08 - buttons, clicks, hovers */



var _functions = {};





jQuery(function( $ ) {

  "use strict";



    /*================*/

    /* 01 - VARIABLES */

    /*================*/

    var swipers = [], winW, winH, headerH, winScr, footerTop, navHeight, _isresponsive, contentOverflow, _ismobile = navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);



    /*========================*/

    /* 02 - page calculations */

    /*========================*/

    _functions.pageCalculations = function(){

        winW = $(window).width();

        winH = $(window).height();

        if($('body').hasClass('home')){

	        var bgH = $('.section.banner').height() - $('.section.banner .banner-content-cell > div').height() - $('.egg-wrap').offset().top - 100;

	        var bgW = bgH*0.8;

	        $('.egg-wrap').css({'height':bgH, 'width':bgW});

    	}

    };



    /*=================================*/

    /* 03 - function on document ready */

    /*=================================*/



    // Check if mobile mobile device

    if(_ismobile) $('body').addClass('mobile');

    if (navigator.userAgent.indexOf('Edge') >= 0) {

        $('body').addClass('edge');

    }

    if (navigator.userAgent.indexOf("Trident") >= 0) {

        $('body').addClass('ie');

    }

    if (navigator.userAgent.indexOf('Safari') >= 0 && navigator.userAgent.indexOf('Chrome') < 0) {

        $('body').addClass('safari');

    }

    if (navigator.userAgent.indexOf('Chrome') >= 0 && navigator.userAgent.indexOf('Edge') < 0) {

        $('body').addClass('chrome');

    }



    _functions.pageCalculations();



    setTimeout( function() {

        $("#loader-wrapper").fadeOut(300);

        _functions.initSwiper();

        _functions.initSelectBox();



        if( $('.more-info-article').length ) {

            contentOverflow = document.querySelector('.more-info-article').style.height;

        }



        if ( $('.page-navigation-FixWrapper').length ) {

            $('.page-navigation-FixWrapper').css({

                height: $('.page-navigation-title').outerHeight()

            });

        }



        if ( $('.page-navigation-wrapper').length ) {

             navHeight = $('.page-navigation-wrapper').offset().top;

        }



        if ($('.side-block-wrapper').length) {

            var sideBlockWrapperHeight = $('.side-block-wrapper').outerHeight();



             if ($('.news-content').length) {

                    var newsContentHeight = $('.news-content').outerHeight();

                }



             if(!_ismobile && sideBlockWrapperHeight < newsContentHeight * $('.news-content').length) {

                if ($('.side-block-wrapper').length) {

                    if ($(window).scrollTop() < $(".news-items").offset().top ) {

                        $('.side-block-wrapper').css('position','relative');

                        $('.side-block-wrapper').css('top', '0');

                        $('.side-block-wrapper').css('bottom', 'auto');

                        $('.side-block-wrapper').removeClass('overSroll');

                    } 

                     else {

                        $('.side-block-wrapper').css('position','fixed');

                        $('.side-block-wrapper').css('top', '0');

                        $('.side-block-wrapper').css('bottom', 'auto');

                        $('.side-block-wrapper').addClass('overSroll');

                    }

                    if ( $(window).scrollTop() + $(window).height() >  $('footer').offset().top - 90  ) {

                        console.log($('.news-items').outerHeight(), $('.side-block-wrapper').outerHeight());

                        $('.side-block-wrapper').css('position','absolute');

                        $('.side-block-wrapper').css('top', $('.news-items').outerHeight() - $('.side-block-wrapper').outerHeight() - 90 );

                        console.log($('.news-items').outerHeight() - $('.side-block-wrapper').outerHeight() - 90 );

                    }

                }

            }

        }



    }, 800);



    $('.menu-item-has-children').append('<span></span>');





    setTimeout( function(){



        if ($('.news-content').length) {

            var newsContentHeight = $('.news-content').outerHeight();

        }

    

        if(!_ismobile && $('body').hasClass('ie') ) {

            $('.content-hide').each(function(){

                var contentHeight = $(this).innerHeight(),

                    titleHeight = $(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 50,

                    vvv = $(this).parent().innerHeight(),

                    fff = vvv - titleHeight - 60;

                $(this).css({

                    transform: 'translateY('+ value +'px)'

                });

            });

        }else if(!_ismobile){

            $('.content-hide').each(function(){

                var contentHeight =$(this).innerHeight(),

                    titleHeight =$(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                $(this).css({

                    transform: 'translateY('+ value +'px)'

                });

            });

        } else {

            $('.content-hide').each(function(){

                $(this).css({

                    transform: 'translateY(0)'

                });

            });

        }

    },300);

    setTimeout( function(){
   

        if(!_ismobile && $('body').hasClass('ie') ) {

            $('.content-hide.type-2').each(function(){

                var contentHeight = $(this).innerHeight(),

                    titleHeight = $(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                    // vvv = $(this).parent().innerHeight(),

                    // fff = vvv - titleHeight - 60;

                $(this).css({

                    transform: 'translateY('+ value +'px)'

                });

            });

        }
        else if(!_ismobile){

            $('.content-hide.type-2').each(function(){

                var contentHeight =$(this).innerHeight(),

                    titleHeight =$(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10;                    

                $(this).css({

                    transform: 'translateY('+ value +'px)'

                });

            });

        }
         else {

            $('.content-hide.type-2').each(function(){

                $(this).css({

                    transform: 'translateY(0)'

                });

            });

        }

    },300);



    // init sumo select

    _functions.initSelectBox = function(){



        if(!$('.SelectBox').length) return false;

        $('.SelectBox').not('.initialized').each(function(){

            $(this).addClass('initialized').SumoSelect({search: true, searchText: 'Enter here.'});  

        });

        $('.SelectClass').on('change',function(){

            var opt_val = $(this).val();

            $(this).closest('.contact-drop-down').find('.detail-info').slideUp(400);

            $(this).closest('.contact-drop-down').find('.detail-info[data-type="'+opt_val+'"]').slideToggle(400);

        });



        $('.SumoUnder').on('sumo:closed', function(sumo) {

            var opt_val = $('.SumoUnder').val();

            $(this).closest('.contact-drop-down').find('.detail-info').slideUp(400);

            $(this).closest('.contact-drop-down').find('.detail-info[data-type="'+opt_val+'"]').slideToggle(400);

        });

    };





    /*============================*/

    /* 04 - function on page load */

    /*============================*/

    $(window).load(function(){

      // _functions.initSwiper();

     

         

    });



    $('.more-button').on('click', function() {

        $(this).toggleClass('hide-more-info');

        if ( $(this).hasClass('hide-more-info') ) { // show 

            $(this).closest('.more-info-content').find('.more-info-article').animate({

                'height': $(this).closest('.more-info-content').find('.more-info-article .article').outerHeight()

            }, 600);

            $(this).find('i').html($(this).attr('data-text-hide'));

        } else { // hide

             $('html, body').animate({

                scrollTop: $('.more-info-article').offset().top

            }, 400);

            $(this).closest('.more-info-content').find('.more-info-article').animate({

                'height': contentOverflow

            }, 600);

            $(this).find('i').html($(this).attr('data-text-show'));

        }  

    });





    if( !_ismobile ){

        $('.big-img').on('mouseenter',  function(event) {

            if($('body').hasClass('ie') ) {

                var contentHeight = $(this).find('.content-hide').innerHeight(),

                    titleHeight = $(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                $(this).find('.content-hide').css({

                    transform: 'translateY(0)'

                });

            }else{

                var contentHeight =$(this).find('.content-hide').innerHeight(),

                    titleHeight =$(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                $(this).find('.content-hide').css({

                    transform: 'translateY(0)'

                });

            }

        });





        $('.big-img').on('mouseleave',  function(event) {

    	    if($('body').hasClass('ie') ) {

                var contentHeight = $(this).find('.content-hide').innerHeight(),

                    titleHeight = $(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 10,

                    vvv = $(this).innerHeight(),

                    fff = vvv - titleHeight - 60;

                $(this).find('.content-hide').css({

                    transform: 'translateY('+ value +'px)'

                });

    	    }else{

    	        var contentHeight = $(this).find('.content-hide').innerHeight(),

                    titleHeight = $(this).find('h4').innerHeight(),

                    value = contentHeight - titleHeight + 10;



                $(this).find('.content-hide').css({

                    transform: 'translateY('+ value +'px)'

                });

    	    }

        });

    }




    if( !_ismobile ){

        $('.big-img').on('mouseenter',  function(event) {

            if($('body').hasClass('ie') ) {

                var contentHeight = $(this).find('.content-hide.type-2').innerHeight(),

                    titleHeight = $(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                $(this).find('.content-hide.type-2').css({

                    transform: 'translateY(0)'

                });

            }else{

                var contentHeight =$(this).find('.content-hide.type-2').innerHeight(),

                    titleHeight =$(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10;

                $(this).find('.content-hide.type-2').css({

                    transform: 'translateY(0)'

                });

            }

        });





        $('.big-img').on('mouseleave',  function(event) {

    	    if($('body').hasClass('ie') ) {

                var contentHeight = $(this).find('.content-hide.type-2').innerHeight(),

                    titleHeight = $(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10,

                    vvv = $(this).innerHeight(),

                    fff = vvv - titleHeight - 60;

                $(this).find('.content-hide.type-2').css({

                    transform: 'translateY('+ value +'px)'

                });

    	    }else{

    	        var contentHeight = $(this).find('.content-hide.type-2').innerHeight(),

                    titleHeight = $(this).find('.title-wrapper').innerHeight(),

                    value = contentHeight - titleHeight + 10;



                $(this).find('.content-hide.type-2').css({

                    transform: 'translateY('+ value +'px)'

                });

    	    }

        });

    }

    /*==============================*/

    /* 05 - function on page resize */

    /*==============================*/

    _functions.resizeCall = function(){

        setTimeout(function() {

            _functions.pageCalculations();



            _functions.initSwiper();

            for (var x in swipers) {

                if ($('.' + x).siblings('.swiper-navigation').find('.swiper-button-next').hasClass('swiper-button-disabled')) {

                    $('.' + x).closest('.swiper-main-wrapper').addClass('noSwiperPagination');

                } else {

                    $('.' + x).closest('.swiper-main-wrapper').removeClass('noSwiperPagination');

                }

            }

        }, 100);

    };

    

    if(!_ismobile){

        $(window).resize(function(){

            _functions.resizeCall();

        });

    } else{

        window.addEventListener("orientationchange", function() {

            _functions.resizeCall();

        }, false);

    }



    /*==============================*/

    /* 06 - function on page scroll */

    /*==============================*/

    $(window).on("scroll", function() {



        anchorSection();



        winScr = $(window).scrollTop();

        if ($('.page-navigation-wrapper').length) {

            var bannerBottom = $('.banner').offset().top,

                bannerHeight = $('.banner').innerHeight();

            if (winScr >= navHeight ) {

                $('.page-navigation-wrapper').addClass('fixed');

            } else {

                $('.page-navigation-wrapper').removeClass('fixed');

            }            

        }



        if ($('footer').length) {

            var footerTop = $("footer").offset().top;

            var footerHeight = $("footer").outerHeight();

        }



        if ($('.news-items').length) {

            var newsItemsTop = $(".news-items").offset().top;

            var newsItemsHeight = $(".news-items").outerHeight();

        }



        var newsHeight = newsItemsHeight - newsItemsTop;



        if ($('.side-block-wrapper').length) {

            var sideBlockWrapperHeight = $('.side-block-wrapper').outerHeight();

        }



        if ($('.news-content').length) {

            var newsContentHeight = $('.news-content').outerHeight();

        }

        if(!_ismobile && sideBlockWrapperHeight < newsContentHeight * $('.news-content').length) {

            if ($('.side-block-wrapper').length) {

                if (winScr < newsItemsTop ) {

                    $('.side-block-wrapper').css('position','relative');

                    $('.side-block-wrapper').css('top', '0');

                    $('.side-block-wrapper').css('bottom', 'auto');

                    $('.side-block-wrapper').removeClass('overSroll');

                } 

                 else {

                    $('.side-block-wrapper').css('position','fixed');

                    $('.side-block-wrapper').css('top', '0');

                    $('.side-block-wrapper').css('bottom', 'auto');

                    $('.side-block-wrapper').addClass('overSroll');

                }

                if ( winScr + $(window).height() >  $('footer').offset().top - 90  ) {

                    $('.side-block-wrapper').css('position','absolute');

                    $('.side-block-wrapper').css('top', $('.news-items').outerHeight() -  $('.side-block-wrapper').outerHeight() -90  );

                

                }

            }

        }



    });





    // $('a[href*="#"]').not('[href="#"]').on('click', function(event) {

    //     if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 

    //         && 

    //         location.hostname == this.hostname ) {

    //         // Figure out element to scroll to

    //         var target = $(this.hash);

    //         target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

    //         // Does a scroll target exist?

    //         if (target.length) {

    //             // Only prevent default if animation is actually gonna happen

    //             event.preventDefault();

    //             $('html, body').animate({

    //                 scrollTop: target.offset().top 

    //             }, 1000, function() {

    //                 // Callback after animation

    //                 // Must change focus!

    //                 var $target = $(target);

    //                 $target.focus();

    //                 if ($target.is(":focus")) { // Checking if the target was focused

    //                     return false;

    //                 } else {

    //                     $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable

    //                     $target.focus(); // Set focus again

    //                 };

    //             });

    //         }

    //     }

    // });







    /*=====================*/

    /* 07 - swiper sliders */

    /*=====================*/

    var i = 0;

    var initIterator = 0;

    _functions.initSwiper = function(){

        $('.swiper-container').not('.initialized').each(function(){                 

            var $t = $(this);                 

            var index = 'swiper-unique-id-' + initIterator;

            var mas = [];

            var masLenght;









            $t.addClass('swiper-'+index+' initialized').attr('id', index);

            $t.parent().find('>.swiper-navigation .swiper-pagination').addClass('swiper-pagination-'+index);

            $t.parent().find('>.swiper-navigation .swiper-button-prev').addClass('swiper-button-prev-'+index);

            $t.parent().find('>.swiper-navigation .swiper-button-next').addClass('swiper-button-next-'+index);



            var slidesPerViewVar = ($t.data('slides-per-view'))?$t.data('slides-per-view'):1;

            if(slidesPerViewVar!='auto') slidesPerViewVar = parseInt(slidesPerViewVar, 10);

            var a;

            swipers['swiper-'+index] = new Swiper('.swiper-'+index,{

                pagination: '.swiper-pagination-'+index,

                paginationClickable: true,

                nextButton: '.swiper-button-next-'+index,

                prevButton: '.swiper-button-prev-'+index,

                slidesPerView: slidesPerViewVar,

                autoHeight:($t.is('[data-auto-height]'))?parseInt($t.data('auto-height'), 10):0,

                loop: ($t.is('[data-loop]'))?parseInt($t.data('loop'), 10):0,

                autoplay: ($t.is('[data-autoplay]'))?parseInt($t.data('autoplay'), 10):0,

                paginationType: ($t.is('[data-pagination-type]')) ? $t.data('pagination-type') : 'fraction',

                breakpoints: ($t.is('[data-breakpoints]'))? { 

                    767: { 

                        paginationType: 'fraction',

                        slidesPerView: parseInt($t.attr('data-xs-slides'), 10)

                    }, 

                    991: { 

                        paginationType: 'fraction',

                        slidesPerView: parseInt($t.attr('data-sm-slides'), 10) 

                    }, 

                    1199: { 

                        paginationType: ($t.is('[data-pagination-type]')) ? $t.data('pagination-type') : 'fraction',

                        slidesPerView: parseInt($t.attr('data-md-slides'), 10) 

                    }, 

                    1500: { 

                        paginationType: ($t.is('[data-pagination-type]')) ? $t.data('pagination-type') : 'fraction',

                        slidesPerView: parseInt($t.attr('data-lg-slides'), 10) 

                    } 

                } : {},

                initialSlide: ($t.is('[data-ini]'))?parseInt($t.data('ini'), 10):0,

                speed: ($t.is('[data-speed]'))?parseInt($t.data('speed'), 10):500,

                mousewheelControl: ($t.is('[data-mousewheel]'))?parseInt($t.data('mousewheel'), 10):0,

                mousewheelReleaseOnEdges: true,

                direction: ($t.is('[data-direction]'))?$t.data('direction'):'horizontal',

                parallax: (_ismobile) ? 0 : ($t.is('[data-parallax]'))?parseInt($t.data('parallax'), 10):0,

                spaceBetween: ($t.is('[data-space]'))?parseInt($t.data('space'), 10):0,

                centeredSlides:($t.is('[data-centered]'))?parseInt($t.data('centered'),10):0,

                roundLengths:($t.is('[data-round]'))?$t.data('round'):false,

                slideToClickedSlide:($t.is('[data-slide-clickable]'))?parseInt($t.data('slide-clickable'), 10):0,

                effect: $t.is("[data-effect]") ? $t.data("effect") : 0,



                paginationFractionRender: function (swiper, currentClassName, totalClassName) {

                    return '<span class="' + currentClassName + '"></span>' +

                    ' ' +

                    '<span class="' + totalClassName + '"></span>';

                },

                onInit: function(swiper) {



                    if ($t.siblings('.swiper-navigation').find('.swiper-button-next').hasClass('swiper-button-disabled')) {

                        $t.parent().addClass('noSwiperPagination');

                    }



                    $t.closest('.year-slider').find('.bg').eq($t.closest('.year-slider').find('.swiper-slide').index()).addClass('active');



                },

                onTransitionEnd: function(swiper) {

                    $t.closest('.year-slider').find('.bg').removeClass('active');

                    $t.closest('.year-slider').find('.bg').eq(swiper.activeIndex).addClass('active');

                    // console.log(swiper.activeIndex);

                }

            });

            swipers['swiper-'+index].update();

            initIterator++;

        });

        $('.swiper-container.swiper-control-top').each(function(){

            swipers['swiper-'+$(this).attr('id')].params.control = swipers['swiper-'+$(this).closest('.swiper-main-wrapper').find('.swiper-control-bottom').attr('id')];

        });

        $('.swiper-container.swiper-control-bottom').each(function(){

            swipers['swiper-'+$(this).attr('id')].params.control = swipers['swiper-'+$(this).closest('.swiper-main-wrapper').find('.swiper-control-top').attr('id')];

        });

    };



    /*==============================*/

    /* 08 - buttons, clicks, hovers */

    /*==============================*/

    

    // open menu

    $('.mobile-button').on('click', function(event) {

        $('header').toggleClass('active');

        $('html').toggleClass('overflow-hidden');

    });



    // open video

    $('.video-button:not(.open-video)').on('click', function(event) {

        $(this).closest('.banner').find('.banner-content').addClass('hide-banner-content');

        $(this).closest('.banner').find('.video-position').addClass('show-video');

        $(this).closest('.banner').find('.close-video').removeClass('hide');

    });

    $('.video-button.open-video').on('click', function(event) {
        $('.video-position video').trigger('pause');
    });

    $('.home #video-popup .button-close').on('click', function(event) {
        $('.video-position video').trigger('play');
    });

    // $(window).load(function() {

    // 	if($('body').hasClass('home')) {

    //         // console.log(1);

    //         var video = document.querySelector(".video-position video");

    //         var checkVideoLoaded = setInterval(function() {

    //             if ( video.readyState === 4 ) {

    //                 // console.log(video);

    //                 $('.video-button').closest('.banner').find('.video-position').addClass('show-video');

    //                 clearInterval(checkVideoLoaded);

    //             }

    //         },500);

    // 	}

    // });



    // close video

    $('.close-video').on('click', function(event) {

        $(this).closest('.banner').find('.banner-content').removeClass('hide-banner-content');

        if($('body').hasClass('home')){

            $(this).addClass('hide');

        } else {

            $(this).closest('.banner').find('.video-position').removeClass('show-video');

        }

    });



    // open search

    $('.search-wrapper').on('click', function(event) {

        $(this).closest('.top-nav').find('.search-input').addClass('search-open');

    });



    $('.search-wrapper').on('click', function(event) {

        $(this).closest('.header-search').addClass('search-open');

    });



    // close search

    $('.close-search').on('click', function(event) {

        $(this).closest('.top-nav').find('.search-input').removeClass('search-open');

    });



    $('.close-search').on('click', function(event) {

        $(this).closest('.header-search').removeClass('search-open');

    });



    // open accordion

    $('.accordion-title').on('click', function(event) {

        var this_acc = $(this);

        setTimeout( function() {

            $('html, body').animate({

                scrollTop: $(this_acc).offset().top

            }, 400);

        }, 400);

        $(this).closest('.accordion-element').siblings('.active').removeClass('active').find('.accordion-content').slideToggle(400);

        $(this).closest('.accordion-element').toggleClass('active').find('.accordion-content').slideToggle(400);





    });
    // open accordion tips

    $('.accordion__tips-title').on('click', function(event) {
        var this_acc = $(this).closest('.accordion__tips-element');
        setTimeout( function() {
            $('html, body').animate({
                scrollTop: $(this_acc).offset().top
            }, 400);
        }, 400);

        $(this).closest('.accordion__tips-element').siblings('.active').removeClass('active').find('.accordion__tips-content').slideToggle(400);
        $(this).closest('.accordion__tips-element').toggleClass('active').find('.accordion__tips-content').slideToggle(400);
    });

    //open filters

    $('.side-block-button').on('click', function(event) {

        $(this).closest('.side-block-wrapper').toggleClass('open');

    });



    //open and close popup

  _functions.openPopup = function(foo){

    $('html').removeClass('overflow-hidden');

    $('.popup-content').removeClass('active');

    $('.popup-wrapper').addClass('active');

    foo.addClass('active');

    $('html').addClass('overflow-hidden');



    if ($('.popup-content.active[data-rel="2"]').is(":visible")) {

      $('.popup-content[data-w="w"]').find('.button-close').addClass('open-popup-duplicate');

    }

  };



  _functions.closePopup = function(){

    $('.popup-wrapper').removeClass('active');

    $('.popup-content').removeClass('active');

    $('html').removeClass('overflow-hidden');

    $('#video-popup iframe').remove();

    if( $('.present-wrapp').length ) $('.present-wrapp').removeClass('show-block'); 

  };



  _functions.videoPopup = function(src){

    $('#video-popup .embed-responsive').html('<iframe src="'+src+'"></iframe>');

    _functions.openPopup($('#video-popup'));

  };



  $(document).on('click', '.open-popup', function(e){

    e.preventDefault();

    _functions.openPopup($('.popup-content[data-rel="'+$(this).data('rel')+'"]'));

  });



  $(document).on('click', '.popup-wrapper .button-close', function(e){

    e.preventDefault(); 

    if ($(this).hasClass('open-popup-duplicate')) {

      _functions.openPopup($('.popup-content[data-rel="'+$(this).data('rel')+'"]'));

    } else {

      _functions.closePopup();

    }

  });



  $(document).on('click', '.open-video', function(e){

    e.preventDefault();

    _functions.videoPopup($(this).data('src'));

  });

  //open and close popup





    function anchorSection() {

        var section_scroll = $(".section-scroll"),

        sections = {},

        i = 0,

        scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

        Array.prototype.forEach.call(section_scroll, function(e) {

            sections[e.id] = e.offsetTop - 80;

        });

        for (i in sections) {

            if (sections[i] <= scrollPosition) {

                $('.page-navigation-wrapper li').attr('class', ' ');

                $('.page-navigation-wrapper li a[href*=' + i + ']').closest('li').attr('class', 'active');

                

            } else if(($(window).scrollTop() == 0) || ($(window).scrollTop() < $('.main-banner').outerHeight() - 80)){

                $('.page-navigation-wrapper li a').closest('li').removeClass('active');

            }

        }



        if ( $('.page-navigation-wrapper li').hasClass('active') ) {

            $('.page-navigation-title').html($('.page-navigation-wrapper li.active').find('span').html());

        } else {

             $('.page-navigation-title').html($('.page-navigation-title').data('placeholder'));

        }



        if ( !$('.page-navigation-wrapper').hasClass('fixed') && _ismobile ) {

             $('.page-navigation-title').html($('.page-navigation-title').data('placeholder'));

        }

        

    };





    $('.page-navigation-title').on('click',function(event) {

        $(this).closest('.page-navigation-wrapper').toggleClass('active');

    });



    $('.page-navigation-wrapper ul li a').on('click',function(event) {

        $(this).closest('.page-navigation-wrapper').removeClass('active');



        var aValue = $(this).text();

        $(this).closest('.page-navigation-wrapper').find('.page-navigation-title').text(aValue);

    });

    if( !_ismobile ){

        $('.big-img').on('click', function(event) {

            $(this).closest('.img-item').find('.big-img').toggleClass('active');

        });

    }

    /* upload file */

    $('body').on('change', '.up-file', function() {

        var format = $(this).val();

        var fileName = format.substring(format.lastIndexOf("\\") + 1);

        if (format == '') {

            $('.file-name').text('Upload Resume');

        } else {

            $('.file-name').text(fileName);

        }

    });





    // Open language

    $('.select-language').on('click', function(event) {

        $(this).closest('.language').find('ul').slideToggle(400);

    });





    // Open submenu

    $('.menu-item-has-children span').on('click', function(event) {
        
        $(this).closest('.menu-item-has-children').find('.sub-menu').slideToggle(400);

    });



    /*==============================*/

    /* 10 - smooth scroll*/

    /*==============================*/

    $(function() {

      $('a[href*="#"]:not([href="#"])').click(function() {

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

          var target = $(this.hash);

          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

          if (target.length) {

            $('html, body').animate({

              scrollTop: target.offset().top

            }, 1000);

            $('.mobile-button').removeClass('active');

            $('.toggle-block').removeClass('open-menu');

            $('html').removeClass('overflow-menu');

            return false;

          }

        }

      });

    });



    //contact form select placeholder

    $('.dataplaceholder').each(function(index, el) {

        var placeholder = $(this).attr('data-placeholder');

        $(this).find('select option').eq(0).text(placeholder).prop('disabled', true);

    });


    //informer hiden

    $('.informer-top .close').on('click',  function(){
        $(this).parents('.informer-top').slideUp(250);
        Cookies.set('top_informer', true, {
            expires: 1
        });
    });

    //categories

    // $("nav ul li.menu-item-has-children").hover(function () {
    //     if ($(window).width() > 1199) {
    //       $('.overlay').addClass('active');
    //     }
    // });

    // $('.sub-menu.categories').mouseleave(function () {
    //     if ($(window).width() > 1199) {
    //         $(this).parent().removeClass('active');
    //     }
    // })

    $( document ).ready(function() {
        // var coocie = Cookies.get('qtcunstomlanguage');
           
        var current_lang = document.getElementsByTagName('html')[0].getAttribute('lang');
       //  alert(current_lang);
        switch(current_lang){
           case 'en': $('#menu-item-5149 a:first').text('English'); break;
           case 'es': $('#menu-item-5149 a:first').text('Spanish'); break;
           case 'ar': $('#menu-item-5149 a:first').text('Arabic'); break;
           case 'zh-CN': $('#menu-item-5149 a:first').text('Chinese'); break;
           case 'fr': $('#menu-item-5149 a:first').text('French'); break;
           case 'pt': $('#menu-item-5149 a:first').text('Portuguese'); break;
           case 'ru': $('#menu-item-5149 a:first').text('Russian'); break;
           default: $('#menu-item-5149 a:first').text('English'); break;
        }
        // $('#menu-item-4819 a:first').text(coocie);   
       
        // alert ("The language is: " + current_lang);
       });

    $("nav ul li.js_popup_menu_category").on('click', function () {
        $(this).toggleClass('active');
        if ($(window).width() < 1199) {
          $('.categories').toggleClass('active');
        }
    });

    $('.dropdown').on('click', function(){
        if ($(window).width() < 1200) {
            $(this).toggleClass('active');
        }
    });

    // tabs
    $(document).on('click', '.tab-toggle div', function() {
        var tab = $(this).closest('.tabs').find('.tab').filter((index, tab)=>this.closest(".tabs")===tab.closest(".tabs"));
        var i = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        tab.eq(i).siblings('.tab:visible').fadeOut(function() {
            tab.eq(i).fadeIn();
        });
        $(this).closest('.tab-nav').removeClass('active');
    });

    // usa open map
    $(document).on('click', '#us', function (e) {
        e.preventDefault();
        $(this).removeClass('.mapplic-active');
        $(document).find('.mapplic-tooltip').css('display', 'none');
        $('.map_tabs .tab-toggle div').removeClass('active');
        $('.map_tabs .tab-toggle .usa_tab-nav').addClass('active');
        $('.map_tabs .tab').fadeOut();
        $('.map_tabs .usa-tab').fadeIn();
    })
    // end usa open map

});