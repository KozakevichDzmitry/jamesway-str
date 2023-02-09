<?php
/**
 * Admin functions
 * ext Domain: jcmi
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




function label_to_worls($city=''){
    $values = array(
        'Canada' => 'ca',
        'United States' => 'us',
        'South Africa' => 'za',
        'China' => 'cn',    
        'Poland' => 'pl',       
        'CIS + Russia' => 'cis',
        'Europe (1)' => 'eu-1',
        'Australia' => 'au',
        'Europe (2)' => 'eu-2',
        'Latin America (1)' => 'latin-1',
        'Latin America (2)' => 'latin-2',
        'Latin America (3)' => 'latin-3',
        'Middle East and Africa' => 'mea',
        'Japan' => 'jp',
        'Taiwan' => 'tw',
        'South Korea' => 'kr',
        'South APAC (1)' => 'apac-2',
        'South APAC (2)' => 'apac-3',
        'South APAC (3)' => 'apac-4',
        'Papua New Guinea' => 'pg',
        'New Zealand' => 'nz',
        'Afghanistan' => 'af',
        'Iran' => 'ir',
        'Cyprus' => 'cypr',       
    );
    if($values[$city]){
        return $values[$city];
    } else {
            return $city;
    }
}
function label_to_cuty($city=''){

    $values = array(
        'ca' => 'California',      
        'wa' => 'Washington',
        'tx' => 'Texas',
        'al' => 'Alabama',
        'ak' => 'Alaska', 
        'az' => 'Arizona',        
        'ar' => 'Arkansas', 
        'co' => 'Colorado', 
        'ct' => 'Connecticut', 
        'de' => 'Delaware', 
        'fl' => 'Florida', 
        'ga' => 'Georgia', 
        'hi' => 'Hawaii', 
        'id' => 'Idaho', 
        'il' => 'Illinois', 
        'in' => 'Indiana', 
        'ia' => 'Iowa', 
        'ks' => 'Kansas', 
        'la' => 'Louisiana', 
        'me' => 'Maine', 
        'md' => 'Maryland', 
        'mi' => 'Michigan', 
        'mn' => 'Minnesota', 
        'ms' => 'Mississippi', 
        'mo' => 'Missouri',
        'ma' => 'Massachusetts',
        'mt' => 'Montana', 
        'ne' => 'Nebraska', 
        'nv' => 'Nevada', 
        'nh' => 'New Hampshire', 
        'nj' => 'New Jersey', 
        'nm' => 'New Mexico', 
        'ny' => 'New York', 
        'nc' => 'North Carolina',
        'oh' => 'Ohio', 
        'ok' => 'Oklahoma',  
        'or' => 'Oregon', 
        'ri' => 'Rhode Island', 
        'cs' => 'South Carolina', 
        'sd' => 'South Dakota', 
        'tn' => 'Tennessee', 
        'ut' => 'Utah', 
        'vt' => 'Vermont', 
        'wa' => 'Washington', 
        'wv' => 'West Virginia',
        'wi' => 'Wisconsin',
        'wy' => 'Wyoming',
        'nd' => 'North Dakota',
        'pa' => 'Pennsylvania',
        'va' => 'Virginia',
        'sc' => 'South Carolina',
        'ky' => 'Kentucky',


    ); 

    if($values[$city]){
    return $values[$city];
    } else {
        return $city;
    }
    
}


add_action('wp_ajax_ajax_safe_map', 'jcmi_ajax_safe_map');
add_action('wp_ajax_nopriv_ajax_safe_map', 'jcmi_ajax_safe_map');
function jcmi_ajax_safe_map()
{
    $pega_id = get_the_ID();
    $map_information = get_field('bio' , 42);
    $json = '';
    $test_array = array();
    $test_array_usa = array();
    $locations['mapwidth']      = '2500';
    $locations['mapheight']     = '760';
    $locations['categories']    = array(); 

    $locations_usa['mapwidth']      = '960';
    $locations_usa['mapheight']     = '600';     


    foreach($map_information as $info){
        $json_tab_services = $json_tab_sales = $json_content = '';
        // file_put_contents(__DIR__ . '/../ee.txt', print_r($info['region'][0]['label'], true));
        // file_put_contents(__DIR__ . '/../ee1.txt', print_r($info['region'], true));
        // file_put_contents(__DIR__ . '/../ee2.txt', print_r(array_search('Unites States', array_column($info['region'], 'label')), true));        
     
        // $tt = array_search('Unites States', array_column($info['region'], 'label'));
        // file_put_contents(__DIR__ . '/../tt.txt', print_r($tt, true));
        // $cordinates_region = explode(',',$info['region']['value']); 

       

        foreach($info['member'] as $member){         
            
            if($member['tab'] == 'Sales'){
                $json_tab_services .= '<div class="item">
                <div class="left_side">
                    <img src="'. esc_url($member['photo']['url']) .'"
                        alt="">
                </div>
                <div class="right_side">
                    <div class="title h6">'. esc_html($member['first_name_last_name']) .'</div>
                    <div class="desc">
                    '. esc_html($member['position']) .'
                    </div>
                    <ul class="links_wr">
                        <li>
                            <a href="tel:'. esc_html($member['phone_numer']) .'">
                                <span class="icon">
                                    <img src="/wp-content/themes/jamesway/assets/img/phone-icon.svg"
                                        alt="">
                                </span>
                                '. esc_html($member['phone_numer']) .'
                            </a>
                        </li>
                        <li>
                            <a href="mailto:'. esc_html($member['email_address']) .'">
                                <span class="icon">
                                    <img src="/wp-content/themes/jamesway/assets/img/email-icon.svg"
                                        alt="">
                                </span>
                                '. esc_html($member['email_address']) .'
                            </a>
                        </li>
                    </ul>
                </div>
            </div>';
            } else {
                $json_tab_sales .= '<div class="item">
                <div class="left_side">
                    <img src="'. esc_url($member['photo']['url']) .'"
                        alt="">
                </div>
                <div class="right_side">
                    <div class="title h6">'. esc_html($member['first_name_last_name']) .'</div>
                    <div class="desc">
                    '. esc_html($member['position']) .'
                    </div>
                    <ul class="links_wr">
                        <li>
                            <a href="tel:'. esc_html($member['phone_numer']) .'">
                                <span class="icon">
                                    <img src="/wp-content/themes/jamesway/assets/img/phone-icon.svg"
                                        alt="">
                                </span>
                                '. esc_html($member['phone_numer']) .'
                            </a>
                        </li>
                        <li>
                            <a href="mailto:'. esc_html($member['email_address']) .'">
                                <span class="icon">
                                    <img src="/wp-content/themes/jamesway/assets/img/email-icon.svg"
                                        alt="">
                                </span>
                                '. esc_html($member['email_address']) .'
                            </a>
                        </li>
                    </ul>
                </div>
            </div>';
            }
        } 
        
        // if(!$member['global_us_member'] && $info['region'][0]['label'] == 'United States'){
            if($info['region'][0]['label'] == 'United States' && !empty($info['state'])){
                    

            foreach($info['state'] as $usa_state){              

                $cordinates = explode(',',$usa_state['value']); 
                $test_array_usa[] = array(
                    
                'id' 	=> $usa_state['label'],

                'title' => label_to_cuty($usa_state['label']), 
                               
                'description' 	=> '
                <div class="top_side"><div class="popup_logo"><img src="/wp-content/themes/jamesway/assets/img/logo_popup.svg" alt=""></div></div>
                    <div class="tabs sales_tabs">
                        <div class="tab-nav">
                            <div class="tab-toggle">
                                <div class="active"><span class="tab-caption">Sales</span></div>
                                <div class=""><span class="tab-caption">Service</span></div>
                            </div>
                        </div>
                    <div class="tab active" style="display: block;">
                    <div class="sales_side">
                        '.$json_tab_services.'         
                    </div>
                </div>
                <div class="tab" style="display: none;">
                    <div class="sales_side">
                    '.$json_tab_sales.' 
                    </div>
                </div>',
        
                'pin' => 'hiden',
        
                "x" =>  $cordinates[0],
        
                "y" => $cordinates[1],                             
    
            );  
            }

            // $cordinates = explode(',',$member['state']['value']); 
            // $test_array_usa[] = array(
                    
            //     'id' 	=> $member['state']['label'],

            //     'title' => label_to_cuty($member['state']['label']), 
                               
            //     'description' 	=> '
            //     <div class="top_side"><div class="popup_logo"><img src="/wp-content/themes/jamesway/assets/img/logo_popup.svg" alt=""></div></div>
            //         <div class="tabs sales_tabs">
            //             <div class="tab-nav">
            //                 <div class="tab-toggle">
            //                     <div class="active"><span class="tab-caption">Sales</span></div>
            //                     <div class=""><span class="tab-caption">Service</span></div>
            //                 </div>
            //             </div>
            //         <div class="tab active" style="display: block;">
            //         <div class="sales_side">
            //             '.$json_tab_services.'         
            //         </div>
            //     </div>
            //     <div class="tab" style="display: none;">
            //         <div class="sales_side">
            //         '.$json_tab_sales.' 
            //         </div>
            //     </div>',
        
            //     'pin' => 'hiden',
        
            //     "x" =>  $cordinates[0],
        
            //     "y" => $cordinates[1],                             
    
    // );  
        }  else {              
        

            foreach($info['region'] as $world_marker){

                $cordinates_region = explode(',',$world_marker['value']); 

                $label = $world_marker['label'];

                $description = '';

                if($label == 'United States'){
                    $label = 'Click for our US Sales Reps by region';
                }
                if($label == 'Click for our US Sales Reps by region'){
                    $description = '';
                } else {
                    $description = '<div class="top_side"> <div class="popup_logo"><img src="/wp-content/themes/jamesway/assets/img/logo_popup.svg" alt=""> </div> </div>
                    <div class="tabs sales_tabs">
                        <div class="tab-nav">
                            <div class="tab-toggle">
                                <div class="active"><span class="tab-caption">Sales</span></div>
                                <div class=""><span class="tab-caption">Service</span></div>
                            </div>
                        </div>
                    <div class="tab active" style="display: block;">
                    <div class="sales_side">
                        '.$json_tab_services.'         
                    </div>
                </div>
                <div class="tab" style="display: none;">
                    <div class="sales_side">
                    '.$json_tab_sales.' 
                    </div>
                </div>';
                }

                $test_array[] = array(
                                    
                                    'id' 	=> label_to_worls($world_marker['label']),

                                    'title' => $label, 
                                                
                                    'description' 	=> $description,
                            
                                    'pin' => 'hiden',
                            
                                    "x" => $cordinates_region[0],
                            
                                    "y" => $cordinates_region[1],
                                                    
                        );     

            }

        // $test_array[] = array(
                    
        //             'id' 	=> $info['region']['label'],

        //             'title' => label_to_worls($info['region']['label']), 
                                   
        //             'description' 	=> '
        //             <div class="top_side"> <div class="popup_logo"><img src="/wp-content/themes/jamesway/assets/img/logo_popup.svg" alt=""> </div> </div>
        //                 <div class="tabs sales_tabs">
        //                     <div class="tab-nav">
        //                         <div class="tab-toggle">
        //                             <div class="active"><span class="tab-caption">Sales</span></div>
        //                             <div class=""><span class="tab-caption">Service</span></div>
        //                         </div>
        //                     </div>
        //                 <div class="tab active" style="display: block;">
        //                 <div class="sales_side">
        //                     '.$json_tab_services.'         
        //                 </div>
        //             </div>
        //             <div class="tab" style="display: none;">
        //                 <div class="sales_side">
        //                 '.$json_tab_sales.' 
        //                 </div>
        //             </div>',
            
        //             'pin' => 'hiden',
            
        //             "x" => $cordinates_region[0],
            
        //             "y" => $cordinates_region[1],
                    	           	
        // );     
        
    }
}
    $locations_usa['levels'][] = array(
        'id' => 'usamap',
        'title' => 'USAMAP',
        'map' => '/wp-content/themes/jamesway/assets/img/usa-map.svg',
        'locations' => $test_array_usa,  
    );
    $locations['levels'][] = array(
        'id' => 'world',
        'title' => '600',
        'map' => '/wp-content/themes/jamesway/assets/img/world.svg',
        'locations' => $test_array,  
    );
  
    file_put_contents(__DIR__ . '/../locations-world.json', print_r(json_encode($locations), true));

    file_put_contents(__DIR__ . '/../locations-usa.json', print_r(json_encode($locations_usa), true));

    echo json_encode(array('success' => true));  
    die();
}

?>