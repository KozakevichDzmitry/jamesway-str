<!DOCTYPE html>
<html <?php language_attributes(); ?> >
  <head>
    <?php /* ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109280459-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-109280459-1');
    </script>
    */ ?>
    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MKJBCHH');</script>
	<!-- End Google Tag Manager -->
    <meta charset="<?php bloginfo('charset'); ?>" >
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" >
    <meta name="format-detection" content="telephone=no" />
    <?php wp_head(); 
     	$favicon = get_field( 'header_favicon' , 'option' );
		if( $favicon ):
			echo '<link rel="shortcut icon" href="' . $favicon['url'] . '">';
		endif;
    ?>
    <script>
        document.addEventListener( 'wpcf7mailsent', function( event ) {
            if ( '1007' == event.detail.contactFormId ) {
                ga( 'send', 'event', 'Product page form', 'submit' );
            }
            else if ( '349' == event.detail.contactFormId ) {
                ga( 'send', 'event', 'Accessories page form', 'submit' );
            }
            else if ( '487' == event.detail.contactFormId ) {
                ga( 'send', 'event', 'Contact page form', 'submit' );
            }
            else if( '604' == event.detail.contactFormId ){
                ga( 'send', 'event', 'Whitepaper form', 'submit' );    
            }
        }, false );
    </script>
  </head>
<body <?php body_class(); ?> >
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKJBCHH"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div id="loader-wrapper"></div>
    <header <?php echo esc_attr( !is_front_page() ? 'class=type2' : '' ); ?>>
        <?php $logo = get_field( 'header_logo', 'option' ); ?>
        <a href="<?php echo home_url( '/' ); ?>" id="logo">
           <?php if( $logo ): ?>
                    <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="logo">
            <?php else:
                echo bloginfo(); 
            endif; ?>
        </a>
        <div class="right-menu">
            <div class="top-nav">
                 <?php 
                    jmw_languages();
                    if( has_nav_menu( 'top-menu' ) ):
                        wp_nav_menu( array(
                            'container'      => 'ul',
                            'menu_class'     => '', 
                            'theme_location' => 'top-menu',
                            'walker'         => new Jmw_Walker_Nav_Menu()
                        ) );
                    endif; 
                    $search = get_field( 'header_search', 'option' );
                    if( $search != false ): ?>
                        <div class="search-wrapper">
                            <img src="<?php echo THEME_URI; ?>/assets/img/search.svg" alt="" />
                        </div>
                        <div class="search-input">
                            <?php jmw_search_form(); ?>
                            <div class="close-search">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                <?php endif; ?>
            </div>
            <nav>
                <?php 
					if( has_nav_menu( 'primary-menu' ) ):
						wp_nav_menu( array(
							'container'      => 'ul',
							'menu_class' 	 => '', 
							'theme_location' => 'primary-menu'
						) );
					endif; 
				?>
            </nav>
        </div>
        <div class="mobile-button">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <?php $logo_mob = get_field( 'header_logo_mobile', 'option' ); ?>
        <a href="<?php echo home_url( '/' ); ?>" id="mobile-logo">
            <?php if( $logo_mob ): ?>
                    <img src="<?php echo esc_url( $logo_mob['url'] ); ?>" alt="logo">
            <?php else:
                echo bloginfo();
            endif; ?>
        </a>
        <?php if( $search != false ): ?>
            <div class="header-search">
                <div class="search-wrapper">
                    <img src="<?php echo THEME_URI; ?>/assets/img/search2.svg" alt="">
                </div>
                <div class="search-input">
                    <?php jmw_search_form( true ); ?>
                    <div class="close-search">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </header>
    <div class="main-content">