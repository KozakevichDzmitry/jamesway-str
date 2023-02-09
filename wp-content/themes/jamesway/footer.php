  	</div>
  	<footer>
  	    <div class="footer-top">
  	        <div class="container-fluid">
  	            <div class="row">
  	                <?php $mailchimp = get_field('maichimp_form', 'option');
                        if ($mailchimp['title'] && $mailchimp['number']) : ?>
  	                    <div class="col-xs-12">
  	                        <div class="footer-subscribe">
  	                            
                                    <div class="wrapper-footer">
                                    <?php if ($mailchimp['title']) : ?>
  	                                <!-- uncomment this code for work mailchimp -->
  	                                <!-- <div class="footer-title size-xl">
                                        <?php echo $mailchimp['title']; ?>
                                    </div> -->
  	                            <?php endif;
                                    $sendy_text = get_field('sendy_text', 'option');
                                    if ($sendy_text) : ?>
  	                                <div class="footer-title size-xl"><?php echo esc_html($sendy_text); ?></div>
  	                            <?php endif;
                                    // echo do_shortcode('[embed_sendy]');?>
                                    <?php //echo do_shortcode('[yikes-mailchimp form="'.$mailchimp['number'].'"]'); ?>
                                    <form id="icontactform" class="esd-form" method="post">
                                        
                                        <div class="esd-form__row esd-form__fields">
                                            
                                            <input type="email" name="email" placeholder="Your Email" value="" required="">
                                       

                                            <input class="loading-button" id="submiticontact" type="submit" value="Subscribe">
                                            
                                        </div>

                                        <div class="icontact-text">Text</div>
                                    </form> 
                                </div>
                                <?php
                                $logo_footer = get_field('logo_footer', 'option');

                                if($logo_footer) { ?>

                                    <a href="<?php echo home_url( '/' ); ?>" id="logo1">

                                        <img src="<?php echo $logo_footer[url] ?>" alt="logo">

                                    </a>

                                <?php }
                                endIf;
                                ?>

                                
  	                        </div>
  	                    </div>
  	                <div class="col-md-4 col-sm-4 col-xs-12">
  	                    <?php
                            $col_one = get_field('footer_col_one', 'option');
                            if ($col_one['title']) : ?>
  	                        <div class="footer-title size-xl">
  	                            <?php echo $col_one['title']; ?>
  	                        </div>
                            
                            <div class="main-links">
                                <?php endif; echo $col_one['pages'] ? jmw_footer_list($col_one['pages']) : ''; ?>
                            </div>               
  	                </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <?php
                        $col_two = get_field('footer_col_two', 'option');
                        if ($col_two['title']) : ?>
                            <div class="footer-title size-xl">
                                <?php echo $col_two['title']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($col_two['products'])) { ?>
                            <ul class="products-links">
                                <?php foreach ($col_two['products'] as $page_id) {?>
                                    <li><a href="<?php echo get_the_permalink($page_id); ?>"><?php echo get_the_title($page_id); ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <?php
                        $col_third = get_field('footer_col_third', 'option');
                        if ($col_third['title']) : ?>
                            <div class="footer-title size-xl">
                                <?php echo $col_third['title']; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($col_third['products'])) { ?>
                            <ul class="products-links">
                                <?php foreach ($col_third['products'] as $page_id) {?>
                                    <li><a href="<?php echo get_the_permalink($page_id); ?>"><?php echo get_the_title($page_id); ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
  	                <div class="col-md-4 col-sm-4 col-xs-12">
                        <?php
                        $last_column_links = get_field('last_column_links', 'option');
                        foreach ($last_column_links as $item) {
                            foreach ($item as $link) { ?>
                                <a class="link__right-column-footer" href="<?php echo $link[url] ?>"><?php echo $link[title] ?></a>
                            <?php }

                            ?>
                        <?php } ?>
                        <div class="social-wrapper">
                            <?php
                                $social_title = get_field('footer_social_title', 'option');
                                if ($social_title) : ?>
                                <div class="footer-title size-xl">
                                    <?php echo $social_title; ?>
                                </div>
                            <?php endif;
                                jmw_footer_social(); ?>
                        </div>  	                    
  	                </div>
  	            </div>
  	        </div>
  	    </div>
  	    <div class="footer-bottom">
  	        <div class="container-fluid">
  	            <div class="row">
  	                <div class="col-md-9 col-sm-9 col-xs-12">
  	                    <?php
                            $privacy       = get_field('footer_bottom_page', 'option');
                            $accessibility = get_field('footer_bottom_page_two', 'option'); ?>
  	                    <div class="copy">
  	                        <p><?php esc_html_e('Copyright', 'jamesway'); ?> © <?php echo date('Y'); ?> <?php echo bloginfo(); ?></p>
  	                        <?php if ($privacy) : ?>
  	                            <a href="<?php echo get_the_permalink($privacy); ?>"><?php echo get_the_title($privacy); ?></a>
  	                        <?php endif;
                                if ($accessibility) : ?>
  	                            <a href="<?php echo get_the_permalink($accessibility); ?>"><?php echo get_the_title($accessibility); ?></a>
  	                        <?php endif; ?>
  	                    </div>
  	                </div>
  	                <div class="col-md-3 col-sm-3 col-xs-12">
  	                    <div class="dev">
  	                        <a href="https://www.itwconsulting.com/" target="_blank"><?php esc_html_e('Website by', 'jamesway'); ?><img src="<?php echo THEME_URI; ?>/assets/img/itw-logo.svg" alt="" /></a>
  	                    </div>
  	                </div>
  	            </div>
  	        </div>
  	    </div>
  	</footer>
  	<?php get_template_part('templates/popups');
        wp_footer(); ?>
  	</body>

  	</html>