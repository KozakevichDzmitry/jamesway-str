<?php m3c_admin_enqueues(); ?>

<link rel='stylesheet' id='imgareaselect-css'  href='<?php echo RS_DIR; ?>assets/css/plugin_page.css' type='text/css' media='all' />
<script type='text/javascript' src="<?php echo RS_DIR; ?>assets/js/plugin_page.js"></script>

<div class="content">
	<form method="post" action="options.php" id="myOptionsForm">
	
	<fieldset>
		<legend class="act">Hide & Sort admin menu </legend>
		<div class="form-group" id="gil_list">
			<?php 
			
			settings_fields( 'm3c_plugin_settings' );
			$option = get_option( 'm3c_option' ); 
			$pages_old = $GLOBALS[ 'admin_page_hooks' ];
			$pages_new = get_option('m3c_menu_positions', true);
			$pages = explode(',', $pages_new);
			if($pages[0]=='dashboard' || $pages_new=='1'){
				$pages = array_keys($pages_old);
			}
			//$count = -1;
			//$pages_uri = array_keys($pages11);

			foreach ($pages as $page) {  ?>
				<label class="m3c_<?php echo strtolower($page); ?>"><input id="m3c_option[<?php echo $page; ?>]" data-href="<?php echo $page; ?>" name="m3c_option[<?php echo $page; ?>]" type="checkbox" value="1" <?php checked( '1', isset($option[$page] )); ?> /> 
					<a href="<?php if(substr($page,0,3)!='edi' && substr($page,-3)!='php') { echo 'admin.php?page='.$page; } else { echo $page; } ?>"><?php echo ucfirst(urldecode($pages_old[$page])); ?> </a></label>
			<?php }?>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Add custom view</legend>
		<div class="form-group">
			<label><input id="m3c_option[css]" name="m3c_option[css]" type="checkbox" value="1" <?php checked( '1', isset($option['css'] )); ?> /> <?php echo 'Add custom CSS' ?> </label>
			<label><input id="m3c_option[js]" name="m3c_option[js]" type="checkbox" value="1" <?php checked( '1', isset($option['js'] )); ?> /> <?php echo 'Add custom JS' ?> </label>
			<label><input id="m3c_option[logo_url]" name="m3c_option[logo_url]" type="checkbox" value="1" <?php checked( '1', isset($option['logo_url'] )); ?> /> <?php echo 'Change login logo url to site homepage' ?> </label>
			<label class="check_open"><input id="m3c_option[gil]" name="m3c_option[gil]" type="checkbox" value="1" <?php checked( '1', isset($option['gil'] )); ?> /> <?php echo 'Add ITW view' ?> </label>
			<div class="input_open">
				<label><input id="m3c_option[color]"  name="m3c_option[color]" type="text" value='<?php echo $option['color']; ?>' placeholder="Change main color"/></label>
				<label><input type="text" id="m3c_option[logo]" name="m3c_option[logo]" value="<?php echo  $option['logo']; ?>" data-id="upload_image" placeholder="Change logo"/>
	        	<input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'rs_panel' ); ?>" /></label>
	        	<label>Custom CSS<textarea id="m3c_option[admin_css]"  name="m3c_option[admin_css]" type="text" value='<?php echo $option['admin_css']; ?>' placeholder="Main color" data-id="admin-css"/><?php echo $option['admin_css']; ?></textarea></label>
		        <div id="admin_css"></div>
	    	</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Other</legend>
		<div class="form-group">
			<label><input id="m3c_option[admin_bar]" name="m3c_option[admin_bar]" type="checkbox" value="1" <?php checked( '1', isset($option['admin_bar'] )); ?> /> <?php echo 'Remove admin bar' ?> </label>
			<label><input id="m3c_option[sortable]" name="m3c_option[sortable]" type="checkbox" value="1" <?php checked( '1', isset($option['sortable'] )); ?> /> <?php echo 'Remove sortable' ?> </label>
			<label><input id="m3c_option[hide_acf]" name="m3c_option[hide_acf]" type="checkbox" value="1" <?php checked( '1', isset($option['hide_acf'] )); ?> /> <?php echo 'Hide ACF settings' ?> </label>
		</div>
	</fieldset>
	<p><input name="submit" id="submit" value="Save" type="submit"></p>
	</form>
	<div id="saveResult"></div>
</div>

<script>
		var editor = ace.edit("admin_css");
		editor.setTheme("ace/theme/monokai");
		editor.getSession().setMode("ace/mode/css");
		var textarea = jQuery('textarea[data-id="admin-css"]');
		editor.getSession().setValue(textarea.val());
		editor.getSession().on('change', function(){
		  textarea.val(editor.getSession().getValue());
		});
	</script>


<!-- Add ajax save btn -->
<!--  <script type="text/javascript">
jQuery(document).ready(function($) {
	 $('#myOptionsForm').submit(function() { 

      $(this).ajaxSubmit({
         success: function(){
            $('#saveResult').html("<div id='saveMessage' class='successModal'></div>");
            $('#saveMessage').append("<p><?php echo htmlentities(__('Settings Saved Successfully','wp'),ENT_QUOTES); ?></p>").show();
         }, 
         timeout: 5000
      }); 
      setTimeout("$('#saveMessage').hide('slow');", 5000);
      return false; 
   });
});
</script> -->
