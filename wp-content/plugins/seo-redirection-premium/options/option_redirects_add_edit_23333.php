<?php

global $wpdb;

$request = SRP_PLUGIN::get_request();
$security = SRP_PLUGIN::get_security();

$table_name = SR_database::WP_SEO_Redirection();
$SR_jforms = new jforms();
$redirect_manager_tab = $request->get('redirect_manager_tab');


/* Default Values ----------------------------- */

$enabled=1;
$grpID=0;
if($request->get('grpID')!='')
{
    $grpID=intval($request->get('grpID'));
}

$redirect_from_type='Page';
$general_group='0';
$redirect_to_type='Page';
$redirect_from_folder_settings = '1';
$redirect_from_subfolders='0';
$redirect_to_folder_settings='1';
$redirect_type='301';
$redirect_from='/';
$redirect_to='/';
$search_for='';
$replace_with='';


if($request->get('add')!='')
{
     echo '<h4>'.__("Add New Redirect",'wsr').'</h4><hr/>';
    
}
else if(intval($request->get('edit'))>0)
{

    echo '<h4>'.__("Update Existing Redirect",'wsr').'</h4><hr/>';
    
    $ID=$request->get("edit","int");

    $redirect = $wpdb->get_row($wpdb->prepare(" select * from $table_name where blog='%d' and ID=%d ",get_current_blog_id(),$ID));
    $enabled = $redirect->enabled;
    $grpID = $redirect->grpID;
    $redirect_from_type = $redirect->redirect_from_type;
    $redirect_from_folder_settings = $redirect->redirect_from_folder_settings;
    $redirect_from_subfolders = $redirect->redirect_from_subfolders;
    $redirect_to_folder_settings = $redirect->redirect_to_folder_settings;
    $redirect_type = $redirect->redirect_type;
    $redirect_from = $redirect->redirect_from ;
    $redirect_to = $redirect->redirect_to;
    $redirect_to_type=$redirect->redirect_to_type;
    
	if(strpos($redirect_from,'|'))
	{
		$redirect_from_ = explode('|',$redirect_from);
	}
	
    $search_for=$redirect_from_[0]; 
    $replace_with=$redirect_from_[1];

}

?>

<form method="post" onsubmit="return check_redirect_to()" action="<?php echo $request->get_current_parameters(array("add","edit",'link','post_operation','post_operation_id'));?>" class="form-horizontal" role="form" data-toggle="validator">

    <div class="form-group">
        <label class="control-label col-sm-2" for="enabled"><?php _e('Redirect Status:','wsr'); ?></label>
        <div class="col-sm-10">
            <?php
            $drop = new dropdown_list('enabled');
           $drop->add(__('Enabled','wsr'),'1');
            $drop->add(__('Disabled','wsr'),'0');
            $drop->run($SR_jforms);
            $drop->select($enabled);
            ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="grpID"><?php _e('Group:','wsr'); ?></label>
        <div class="col-sm-10">
            <?php
            $drop = new dropdown_list('grpID');
            $groups = $wpdb->get_results("select * from `" . SR_database::WP_SEO_Groups() . "` where blog='" . get_current_blog_id() . "'  order by group_type asc;");
            foreach ( $groups as $group ) {
                $drop->add($group->group_title,$group->ID);
            }
			
            $drop->run($SR_jforms);
            
            $drop->select($grpID);
            ?>

        </div>
    </div>
	
	
	



    <div class="form-group" id="redirect_from_panel">
      <label class="control-label col-sm-2" for="redirect_from"><?php if($redirect_manager_tab == 'redirects_rules'){echo __('Select Rule','wsr');}else{echo __('Redirect From','wsr');}?>:</label>
        <div class="col-sm-10">
            <?php
            if($redirect_manager_tab == 'redirects_rules')
            {

            $drop = new dropdown_list('redirect_from_type');
                
              $drop->add(__('Replace','wsr'), 'Replace', 'Replace');
                $drop->run($SR_jforms);
                $drop->select($redirect_from_type);
				}else{
                $drop = new dropdown_list('redirect_from_type');
                    $drop->add(__('Page','wsr'), 'Page', 'Page_1');
                $drop->add(__('Folder','wsr'), 'Folder', 'Folder_1');
                $drop->add(__('Regex','wsr'), 'Regex', 'Regex_1');
                $drop->add(__('Start With','wsr'), 'StartWith', 'StartWith_1');
                $drop->add(__('End With','wsr'), 'EndWith', 'EndWith_1');
                $drop->add(__('Contain','wsr'), 'Contain', 'Contain_1');
                $drop->add(__('File Type','wsr'), 'Filetype', 'Filetype_1');
                
                $drop->add(__('Replace','wsr'), 'Replace', 'Replace');
                $drop->run($SR_jforms);
                $drop->select($redirect_from_type);
				}
				
					if($request->get('link')=='') {
					?>
						<input type="text" style="width: 350px" class="small_text_box" value="<?php echo $redirect_from ?>"
							   id="redirect_from" name="redirect_from" placeholder="<?php _e('Redirect From','wsr'); ?>"
							   data-error="<?php _e('This Field can not be empty','wsr'); ?>" >
						<a id="invalid_redirect_from" style="display: none;" class="btn btn-danger btn-xs" href="http://www.clogica.com/kb/why-having-the-red-message-seems-to-be-invalid-click-here.htm" target="_blank"><span class="glyphicon glyphicon-alert" aria-hidden="true"></span> <?php _e('Seems to be invalid, Click here','wsr'); ?></a>

					<?php
					}else {
						
						$link=rawurldecode($request->get('link')); 
						$SR_jforms->add_script('$("[data-id=\'redirect_from_type\']").addClass("disabled");');
						?>
						<input name="redirect_from" type="hidden" value="<?php echo $link; ?>"/>
						<a target="_blank" href="<?php echo $request->make_absolute_url($link); ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-link"></span> <?php echo $link; ?></a>
					<?php
					}
					?>
                <div class="divcontainer" id="dv_from_folder_settings">
                    <?php
                    $drop = new dropdown_list('redirect_from_folder_settings');
                    $drop->add(__('Only the folder','wsr'), '1');
                    $drop->add(__('The folder and it\'s content','wsr'), '2');
                    $drop->add(__('Only the folder\'s content','wsr'), '3');
                    $drop->run($SR_jforms);
                    $drop->select($redirect_from_folder_settings);
                    ?></div>

                <div class="divcontainer" id="dv_from_subfolders">
                    <?php
                    $drop = new dropdown_list('redirect_from_subfolders');
                     $drop->add(__('Include sub-folders','wsr'), '0');
                    $drop->add(__('Do not include sub-folders','wsr'), '1');
                    $drop->run($SR_jforms);
                    $drop->select($redirect_from_subfolders);
                    ?></div>
				
				<div id="dv_rule_replace" <?php if($redirect_manager_tab != 'redirects_rules'){echo 'style="display:none"';}?>>
				<input type="text" style="width: 175px" class="small_text_box" value="<?php echo $search_for ?>"
                       id="search_for" name="search_for" placeholder="<?php _e('Search For','wsr'); ?>">
				<input type="text" style="width: 175px" class="small_text_box" value="<?php echo $replace_with ?>"
                       id="replace_with" name="replace_with" placeholder="Replace with">
			</div>
				

        </div>
    </div>

    <div class="form-group" id="dv_redirect_to">
        <label class="control-label col-sm-2" for="redirect_to"><?php _e('Redirect To:','wsr'); ?></label>
        <div class="col-sm-10">
            <?php
            $drop = new dropdown_list('redirect_to_type');
             $drop->add(__('Page','wsr'),'Page','Page_1');
            $drop->add(__('Folder','wsr'),'Folder','Folder_1');
            $drop->run($SR_jforms);
            $drop->select($redirect_to_type);
            ?>
                <input type="text" style="width: 350px" class="small_text_box" value="<?php echo $redirect_to ?>" id="redirect_to" name="redirect_to" placeholder="<?php _e('Redirect To','wsr'); ?>" data-error="<?php _e('This Field can not be empt','wsr'); ?>" >
            <div class="divcontainer" id="dv_to_folder_settings">
                <?php
            $drop = new dropdown_list('redirect_to_folder_settings');

             $drop->add(__('Normal','wsr'),'1');
            $drop->add(__('Wildcard Redirect','wsr'),'2');

            $drop->run($SR_jforms);
            $drop->select($redirect_to_folder_settings);
            ?></div>

        </div>
    </div>


    <div class="form-group">
        <label class="control-label col-sm-2" for="email"><?php _e('Redirect Type:','wsr'); ?></label>
        <div class="col-sm-10">
            <?php
            $drop = new dropdown_list('redirect_type');

           $drop->add(__('301 (SEO)','wsr'),'301');
            $drop->add(__('302','wsr'),'302');
            $drop->add(__('307','wsr'),'307');
            
            $drop->run($SR_jforms);
            $drop->select($redirect_type);
            ?>
        </div>
    </div>

    <div class="form-group">
        <br/>
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" name="save" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> <?php _e('Save','wsr'); ?></button>  <a href="<?php echo $request->get_current_parameters(array("add","edit",'link','post_operation','post_operation_id'));?>" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> <?php _e('Cancel','wsr'); ?></a>
        </div>
        <br/><br/>
    </div>

<script language="JavaScript">

function hide_redirect_from()
{
	document.getElementById('redirect_from_panel').style.display = 'none';
}
    // set the default values ....

    redirect_from_type_change();
    redirect_from_folder_settings_change();
    redirect_to_type_change();

    function check_redirect_to()
    {
        var url=document.getElementById('redirect_to').value;
        if(url.indexOf('://')!=-1 || url.substr(0,1)=='/')
        {
            return true;
        }else
        {
           alert("<?php _e('Invalid redirect target URL!','wsr') ?>");
            document.getElementById('redirect_to').focus();
            return false;
        }
        return false;
    }

    /*------------------------------------------*/
    function redirect_to_type_change()
    {
        if(document.getElementById('redirect_to_type').value == 'Folder')
        {
            document.getElementById('dv_to_folder_settings').style.display='inline';
        }else{
            document.getElementById('dv_to_folder_settings').style.display='none';
        }
    }
    /*------------------------------------------*/
    function redirect_from_folder_settings_change()
    {
        if(document.getElementById('redirect_from_folder_settings').value == '1')
        {
            document.getElementById('dv_from_subfolders').style.display='none';
        }else{
            document.getElementById('dv_from_subfolders').style.display='inline';
        }
    }

    /*------------------------------------------*/
    function redirect_from_type_change()
    {

		if(document.getElementById('redirect_from_type').value == 'Replace')
		{
			
			document.getElementById('dv_rule_replace').style.display='inline';
			document.getElementById('redirect_from').style.display='none';
			document.getElementById('dv_from_folder_settings').style.display='none';
			document.getElementById('dv_redirect_to').style.display='none';
		}else{
			document.getElementById('dv_redirect_to').style.display='block';
			document.getElementById('redirect_from').style.display='inline';
			
			if(document.getElementById('redirect_from_type').value == 'Folder')
			{
				document.getElementById('dv_from_folder_settings').style.display='inline';
			}else{
				document.getElementById('dv_from_folder_settings').style.display='none';
				
			}
		}
    }

    /*------------------------------------------*/
    function check_valid_redirect_from()
    {
        var site = "<?php echo home_url();?>";
        var redirect_from = document.getElementById('redirect_from').value;
        var redirect_from_type = document.getElementById('redirect_from_type').value;

            if((redirect_from_type =='Page' || redirect_from_type == 'Folder') && redirect_from !="")
            {
                if(redirect_from.length >= site.length)
                {
                    if(redirect_from.substr(0,site.length) == site)
                    {
                        return true;
                    }
                }
                if(redirect_from.substr(0,1) == '/')
                {
                    return true;
                }
            }else
            {
                return true;
            }
        return false;
    }


    jQuery(document).ready(function($){
        $( "#redirect_from_type" ).trigger( "change" );
        $( "#redirect_from_folder_settings" ).trigger( "change" );
        $( "#redirect_to_type" ).trigger( "change" );

        $("#redirect_from_type").bind("change", function () {

            if($('#redirect_from_type').val() == 'Folder')
            {
                $('#dv_from_folder_settings').fadeIn();
                $('#redirect_from').animate({width: '250px'});
                $( "#redirect_from_folder_settings" ).trigger( "change" );
                $( "#dv_rule_replace" ).style.display = 'none';
            }else{
				
				if(document.getElementById('redirect_from_type').value == 'Replace')
				{
					document.getElementById('dv_redirect_to').style.display='none';
					document.getElementById('dv_rule_replace').style.display='inline';
					document.getElementById('redirect_from').style.display='none';
					document.getElementById('dv_from_folder_settings').style.display='none';
				}else{
				document.getElementById('dv_redirect_to').style.display='block';
				document.getElementById('dv_rule_replace').style.display='none';
				document.getElementById('redirect_from').style.display='inline';
                $('#dv_from_folder_settings').fadeOut();
                $('#dv_from_subfolders').fadeOut();
                $('#redirect_from').animate({width: '350px'});
				}
				
            }

            $( "#redirect_from" ).trigger( "focusout" );
        })

        $('#redirect_from_folder_settings').bind("change", function () {
            if($('#redirect_from_folder_settings').val() == '1')
            {
                $('#dv_from_subfolders').fadeOut();
            }else{
                $('#dv_from_subfolders').fadeIn();
            }
        })

        $('#redirect_to_type').bind("change", function () {
            if($('#redirect_to_type').val() == 'Folder')
            {
                $('#dv_to_folder_settings').fadeIn();
                $('#redirect_to').animate({width: '250px'});
            }else{
                $('#dv_to_folder_settings').fadeOut();
                $('#redirect_to').animate({width: '350px'});
            }
        })


        $('#redirect_from').focusout(function() {
            if($('#redirect_from').val() != "")
            {
                if(!check_valid_redirect_from())
                {
                    $('#invalid_redirect_from').fadeIn();
                }else
                {
                    $('#invalid_redirect_from').fadeOut();
                }
            }
        })

        $( "#redirect_from" ).trigger( "focusout" );

    });



</script>

    <?php
    $fildname="noaction";
    $fildval="";

    if($request->get("add")!="")
    {
        $fildname="add";
        $fildval="1";
    }elseif($request->get("edit","int")!=0)
    {
        $fildname="edit";
        $fildval=$request->get("edit","int");
    }
    echo "<input type=\"hidden\" name=\"$fildname\" value=\"$fildval\" >";
    ?>
<input type="hidden" name="return" value="<?php echo urldecode($request->get('return')); ?>">
    <input type="hidden" name="post_operation" value="<?php echo $request->get('post_operation'); ?>">
    <input type="hidden" name="post_operation_id" value="<?php echo $request->get('post_operation_id'); ?>">
</form>
<?php
$SR_jforms->set_small_select_pickers();
$SR_jforms->run();