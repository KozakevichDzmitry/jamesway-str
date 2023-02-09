<?php if(!defined('ABSPATH')) exit; 

    $f_col  = get_sub_field( 'file_column' );

	$f_col2 = get_sub_field( 'file_column2' );



	if( $f_col || $f_col2 ): ?>

	<div class="section margin type2 mrg-top bag-fix">

        <div class="container-fluid">

            <div class="row">

                <?php if( ( $f_col['title'] || $f_col['text'] ) && ( !$f_col2['title'] || !$f_col2['text'] ) ): ?>

                    <div class="col-md-6 col-md-offset-3 padding">

                        <div class="brochure-block left">

                            <div class="simple-article">

                            	<?php if( $f_col['title'] ): ?>

    	                            <div class="title type2 h5"><?php echo $f_col['title']; ?></div>

    	                        <?php endif;

    	                        if( $f_col['text'] ): ?>

    	                            <div class="empty-lg-30 empty-xs-20"></div>

    	                            <p><?php echo wp_kses_post( $f_col['text'] ); ?></p>

    	                            <div class="empty-lg-80 empty-md-50 empty-xs-30"></div>

    	                        <?php endif; 

    	                        

                                //button

                                if(isset($f_col['link_type']) and ($f_col['link_type'] == 'link')){

                                    if( !empty($f_col['link']) && !empty($f_col['file_title']) )

                                        echo '<a href="'.esc_url( $f_col['link'] ).'" class="button type3">'.$f_col['file_title'].'</a>';



                                } else {

                                    if( !empty($f_col['file_url']) && !empty($f_col['file_title']) )

                                        echo '<a href="'.esc_url( $f_col['file_url'] ).'" target="_blank" class="button type3">'.$f_col['file_title'].'</a>';

                                }?>

                            </div>

                        </div>

                    </div>

                <?php elseif( ( $f_col2['title'] || $f_col2['text'] ) && ( !$f_col['title'] || !$f_col['text']) ): ?>

                    <div class="col-md-6 col-md-offset-3 padding">

                        <div class="brochure-block left">

                            <div class="simple-article">

                                <?php if( $f_col2['title'] ): ?>

                                    <div class="title type2 h5"><?php echo $f_col2['title']; ?></div>

                                <?php endif;

                                if( $f_col2['text'] ): ?>

                                    <div class="empty-lg-30 empty-xs-20"></div>

                                    <p><?php echo wp_kses_post( $f_col2['text'] ); ?></p>

                                    <div class="empty-lg-80 empty-md-50 empty-xs-30"></div>

                                <?php endif; 



                                //button

                                if(isset($f_col2['link_type']) and ($f_col2['link_type'] == 'link')){

                                    if( !empty($f_col2['link']) && !empty($f_col2['file_title']) )

                                        echo '<a href="'.esc_url( $f_col2['link'] ).'" class="button type3">'.$f_col2['file_title'].'</a>';



                                } else {

                                    if( !empty($f_col2['file_url']) && !empty($f_col2['file_title']) )

                                        echo '<a href="'.esc_url( $f_col2['file_url'] ).'" target="_blank" class="button type3">'.$f_col2['file_title'].'</a>';

                                }?>

                            </div>

                        </div>

                    </div>

                <?php elseif( ( $f_col['title'] || $f_col['text']) && ( $f_col2['title'] || $f_col2['text'])  ): ?>

                    <div class="col-md-6 brochure-item">

                        <div class="brochure-block left">

                            <div class="simple-article">

                                <?php if( $f_col['title'] ): ?>

                                    <div class="title type2 h5"><?php echo $f_col['title']; ?></div>

                                <?php endif;

                                if( $f_col['text'] ): ?>

                                    <div class="empty-lg-30 empty-xs-20"></div>

                                    <p><?php echo $f_col['text']; ?></p>

                                <?php endif;



                                //button

                                if(isset($f_col['link_type']) and ($f_col['link_type'] == 'link')){

                                    if( !empty($f_col['link']) && !empty($f_col['file_title']) )

                                        echo '<a href="'.esc_url( $f_col['link'] ).'" class="button type3">'.$f_col['file_title'].'</a>';



                                } else {

                                    if( !empty($f_col['file_url']) && !empty($f_col['file_title']) )

                                        echo '<a href="'.esc_url( $f_col['file_url'] ).'" target="_blank" class="button type3">'.$f_col['file_title'].'</a>';

                                }?>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 brochure-item">

                        <div class="brochure-block right">

                            <div class="simple-article">

                                <?php if( $f_col2['title'] ): ?>

                                    <div class="title type2 h5"><?php echo $f_col2['title']; ?></div>

                                <?php endif;

                                if( $f_col2['text'] ): ?>

                                    <div class="empty-lg-30 empty-xs-20"></div>

                                    <p><?php echo $f_col2['text']; ?></p>

                                <?php endif;



                                //button

                                if(isset($f_col2['link_type']) and ($f_col2['link_type'] == 'link')){

                                    if( !empty($f_col2['link']) && !empty($f_col2['file_title']) )

                                        echo '<a href="'.esc_url( $f_col2['link'] ).'" class="button type3">'.$f_col2['file_title'].'</a>';



                                } else {

                                    if( !empty($f_col2['file_url']) && !empty($f_col2['file_title']) )

                                        echo '<a href="'.esc_url( $f_col2['file_url'] ).'" target="_blank" class="button type3">'.$f_col2['file_title'].'</a>';

                                }?>

                            </div>

                        </div>

                    </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="space-lg"></div>

    </div>

<?php endif;