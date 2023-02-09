<?php
/**
 * Template name: Login page
 *
 * @package jamesway
 * @since 1.0.0
 *
 */

if( !defined('ABSPATH') ) exit; get_header(); ?>
		<div class="section banner">
            <div class="clip-wrapper">
                <div class="bg-image" style="background-image: url(<?php echo THEME_URI; ?>/assets/img/Rectangle.png);">
                </div>
            </div>
            <div class="svg-element counter-wrapper full-height countEnd">
                <svg version="1.1" width="100%" height="120px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon fill="#ffffff" points="0,100 -10,20  50,0 110,20 100,100"></polygon>
                </svg>
            </div>
            <div class="container-fluid padding">
                <div class="row padding">
                    <div class="col-lg-12 padding">
                        <div class="banner-content type4">
                            <div class="banner-content-cell">
                                <div class="big-title"><?php the_title(); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-md"></div>
        <?php 
        $log_title 	  = get_field( 'login_title' );
        $log_subtitle = get_field( 'login_subtitle' );?>
        <div class="section margin login">
            <div class="container-fluid">
                <div class="row">
                	<?php if( $log_title || $log_subtitle ): ?>
	                    <div class="col-md-6 col-sm-12">
	                        <div class="simple-article type6">
	                        	<?php if( $log_title ): ?>
		                            <h1 class="h2"><?php echo wp_kses_post( $log_title ); ?></h1>
		                        <?php endif;
		                        if( $log_subtitle ): ?>
		                            <div class="empty-lg-20 empty-sm-15"></div>
		                            <p><?php echo wp_kses_post( $log_subtitle ); ?></p>
		                        <?php endif; ?>
	                        </div>                  
	                    </div>
	                <?php endif; ?>
                    <div class="<?php echo esc_attr( !$log_title && !$log_subtitle ? 'col-md-offset-3' : '' ); ?> col-md-6 col-sm-12">
                        <div class="login-form-bg <?php echo esc_attr( is_user_logged_in() ? 'logout-form' : '' ); ?>">
                            <?php if( !is_user_logged_in() ): ?>
                                <form name="loginform" id="login" action="" method="post">
                                    <div class="input-container">
                                        <div class="input">
                                            <input id="user_login" type="text" size="20" value="" name="username" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="input-container">
                                        <div class="input">
                                            <input id="user_pass" type="password" size="20" value="" name="password" placeholder="Password">
                                        </div>
    		                            <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
                                    </div>
                                    <div class="button">
                                        <?php esc_html_e( 'Login', 'jamesway' ); ?>
                                        <input type="submit" name="submit" value="Submit">
                                    </div>
                                </form>
                                <form name="recoveryform" id="recovery" action="<?php echo home_url(); ?>" method="post">
                                    <div class="input-container">
                                        <div class="input">
                                            <input id="user_mail" type="text" size="20" value="" name="usermail" placeholder="Email">
                                        </div>
                                        <div class="button">
                                            <?php esc_html_e( 'Submit', 'jamesway' ); ?>
                                            <input type="submit" name="submit" value="Submit">
                                        </div>
                                    </div>
                                </form>
                                <div class="login-info">
                                    <p><?php esc_html_e( 'Forgot password?', 'jamesway' ); ?> <br><?php esc_html_e( 'To recover your password,', 'jamesway' ); ?> </p>
                                    <a href="#" class="recovery-button"><?php esc_html_e( 'Click Here', 'jamesway' ); ?> </a>
                                </div>
                            <?php else: ?>
                                <div class="button log">
                                    <a href="<?php echo wp_logout_url( home_url() ); ?>" class="logout" ><?php esc_html_e( 'Logout', 'jamesway' ); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>             
                    </div>
                </div>
            </div>
            <div class="space-lg"></div>
        </div>
	<?php
get_footer();