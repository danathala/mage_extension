<?php
/* File contain the functions which run & execute the auto install */

set_time_limit(0);
global  $wpdb,$pagenow;

/* Show notifications As per plug-ins activation */
if((!is_plugin_active('Tevolution/templatic.php') || !is_plugin_active('Tevolution-Classifieds/classifieds.php')) && is_admin() && 'themes.php' == $pagenow ){
	add_action("admin_notices", "tmpl_classifieds_activate_eco_plugin"); // action show notification when tevolution not activated.
}else{
	
	// Action to admin_notices for auto install
	if(false==get_option( 'hide_ajax_notification' ) && strstr($_SERVER['REQUEST_URI'],'themes.php') && (!isset($_REQUEST['page']))) {
		add_action("admin_notices", "tmpl_classifieds_autoinstall");  // action show notification when custom field module not available.
		
	}
}

/*
Name: activate_eco_plugin
Desc: Return notifications to admin - to activate tevolution and related plug-in 
*/
function tmpl_classifieds_activate_eco_plugin(){
	global $pagenow;
	$url = home_url().'/wp-admin/plugins.php';
	tmpl_classifieds_add_css_to_admin();
	$current_system = '';
	if(!is_plugin_active('Tevolution/templatic.php') && is_admin() ){
		$current_system = "<a id='templatic_plugin' href=".$url." style='color:#21759B'>".__('Tevolution','templatic')."</a>";
	}	
	if(!is_plugin_active('Tevolution-Classifieds/classifieds.php') && is_admin() ){
		if($current_system != '')
			$current_system .= __(' and ', 'templatic');
		$current_system .= '<a id="booking_plugin" href="'.$url.'" style="color:#21759B">'.__('Tevolution - Classifieds','templatic').'</a>';
	}
	if(!is_plugin_active('Tevolution-Classifieds/classifieds.php') || !is_plugin_active('Tevolution/templatic.php')):
?>
<div class="error" style="padding:10px 0 10px 10px;font-weight:bold;"> <span>
  <?php echo sprintf(__('Thanks for choosing templatic themes, the base system of templatic is not installed at your side, Please download and activate %s addons to get started with %s website.','templatic'),$current_system,'<span style="color:#000">'. @wp_get_theme().'</span>');?>
  </span> </div>
<?php 	
	endif;
}

/* css to hide notification */
add_action('admin_notices','tmpl_classifieds_add_css_to_admin');
function tmpl_classifieds_add_css_to_admin(){
	echo '<style type="text/css">
		#message1{
			display:none;
		}
		
		body .button.delete-data-button { background: #d54e21; border-color: #d54e21; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset }

	body .button.delete-data-button:hover { background: #e65423; border-color: #d54e21; box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset }

	.welcome-panel-content .form-table {width: auto; margin: 0 -20px!important; display: flex; display: -webkit-flex; justify-content: space-between; -webkit-justify-content: space-between; margin-top: 20px; }

	.form-table, .form-table td, .form-table td p, .form-table th, .form-wrap label { font-size: 16px; }

	.licence-key input[type="password"] { background-color: #fff; border: 1px solid #ddd; box-shadow: none; clear: both; color: #333; display: inline-block; font-size: 16px; margin: 0; outline: 0 none; padding: 12px; transition: border-color 0.05s ease-in-out 0s; width: 100%; border-radius: 4px; position: relative;}

	.licence-key h1 span, .sample-data h1 span{padding-right:10px;}
	.form-table h1 { 
		border-bottom: 1px solid #dedede;
	    clear: both;
	    color: #666;
	    font-size: 24px;
	    font-weight: 400;
	    margin: 30px 0;
	    padding: 0 0 7px;
    }

	.licence-key { border-radius: 4px; margin-bottom: 80px; position: relative;}

	
	.form-table > div{

		margin: 0 20px;

		max-width: 50%;

		width: 100%;

	}

	.video iframe{border-radius:0 0 4px 4px; margin-bottom: 40px;}

	

	.window {

		background: none repeat scroll 0 0 #fff;

		border-radius: 4px;

		padding: 20px;

		position: absolute;

		z-index: 2;

	}

	#mask{

		background: none repeat scroll 0 0 black;

		height: 100%;

		left: 0 !important;

		opacity: 0.5;

		position: absolute;

		top: 0 !important;

		width: 100%;

		z-index: 1;

	}

	.dashicons, .dashicons-before::before{

		text-decoration: none!important;

	}

	.tmpl-welcome-panel{border-width: 1px!important;}

	.form-table a { color: #0074a2; }

	

	.licence-key-wrap:before{content: "\f00c"; font-family: FontAwesome; position: absolute; color: #62b748; bottom: inherit;}
	.licence-key-wrap p{padding-left: 25px; font-size: 18px;}

	.form-table .sample-data{margin-top: 55px;}

	.welcome-panel .twp-act-msg { font-size: 24px !important; color: #333 !important; }

	.licensekey_boxes h2 { color: #333; font-size: 22px; font-weight: bold; margin: 0 0 5px; }

	#adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top > a:focus { color: #0074a2 !important; }

	.theme-browser .theme .theme-actions { padding: 4px 10px !important; }

	.tmpl-welcome-panel{

		margin: 50px auto!important;

	}

	.welcome-panel{

		padding: 20px;
		border: none;

	}

	.welcome-panel h4{

		margin: 1em 0;

	}
	.before-autoinstall{position: relative;}
	.before-autoinstall.licence-key-wrap:before{bottom: 0;}
	
	</style>';
}
	
/* Activate add on when run the auto install */
function tmpl_classifieds_autoinstall()
{	
	global $wpdb;
	$wp_user_roles_arr = get_option($wpdb->prefix.'user_roles');
	global $wpdb;
	
		$post_counts = $wpdb->get_var("select count(p.ID) from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')");
		/* help links */
		$menu_msg1 = "<ul>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/post-new.php?post_type=classified")."'>".__('Add a classified','templatic-admin')."</a></li>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/user-new.php")."'>".__('Add classified Seller','templatic-admin')."</a></li>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/widgets.php")."'>Manage Widgets </a>,  <a href='".site_url("/wp-admin/customize.php")."'>".__('Add your logo','templatic-admin')." </a></li>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/nav-menus.php?action=edit")."'>".__('Manage navigation menu','templatic-admin')."</a></li>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/customize.php")."'>".__('Change site colors','templatic-admin')." </a></li>";
		$menu_msg1 .= "<li><a href='".site_url("/wp-admin/themes.php?page=theme-settings-page")."'>".__('Manage theme settings','templatic-admin')." </a></li></ul>";
		
		$menu_msg2 = "<ul><li><a href='".site_url("/wp-admin/admin.php?page=monetization&action=add_package&tab=packages")."'>".__("Set pricing options",'templatic-admin')."</a></li>";
		$menu_msg2 .= "<li><a href='".site_url("/wp-admin/admin.php?page=monetization&tab=payment_options")."'>".__('Setup payment types','templatic-admin')."</a></li>";
		$menu_msg2 .= "<li><a href='".site_url("/wp-admin/admin.php?page=templatic_settings#listing_page_settings")."'>".__('Setup category page','templatic-admin')."</a> and <a href='".site_url("/wp-admin/admin.php?page=templatic_settings#detail_page_settings")."'>".__('detail page','templatic-admin')."</a></li>";
		$menu_msg2 .= "<li><a href='".site_url("/wp-admin/admin.php?page=templatic_settings#registration_page_setup")."'>".__('Setup registration','templatic-admin')."</a> and <a href='".site_url("/wp-admin/admin.php?page=templatic_settings#submit_page_settings")."'>".__('submission page','templatic-admin')."</a></li>";
		$menu_msg2 .= "<li><a href='".site_url("/wp-admin/admin.php?page=location_settings&location_tabs=location_manage_locations&locations_subtabs=city_manage_locations")."'>".__("Manage cities and locations",'templatic-admin')."</a></li>";
		$menu_msg2 .= "<li><a href='".site_url("/wp-admin/admin.php?page=templatic_settings&tab=email")."'>".__('Manage and customize emails','templatic-admin')."</a></li></ul>";
		//$menu_msg3 .= "<li><a href='".site_url("/wp-admin/widgets.php")."'>".__('Manage sidebar widgets ','templatic-admin')." </a></li></ul>";
		
		$my_theme = wp_get_theme();
		$theme_name = $my_theme->get( 'Name' );
		$version = $my_theme->get( 'Version' );
		$dummydata_title .= '<h3 class="twp-act-msg">'.sprintf (__('Thank you. %s (<small>%s</small>) theme is now activated.','templatic-admin'),@wp_get_theme(),strtolower($version)).' <a href="'.site_url().'">Visit Your Site</a></h3>';
		
		/* system info goes in this filter */	
		$dummydata_title .= apply_filters('tmpl_after_install_delete_button',$dummydata_title);
		
		/* theme message */	
		$dummy_theme_message ='<div class="tmpl-wp-desc">This theme allows you to &quot;Create a Classified portal and connect advertisement owners or real estate agents with people searching for their new home&quot;. Make sure to refer <a href="http://templatic.com/docs/classifieds-child-theme/">Installation Guide</a> of this theme to understand how to manually setup the theme and how different settings of this theme works. To get started, we&acute;ve outlined a few suggested steps to help you with this site. If you would like some help, get in touch with us at our <a href="http://templatic.com/forums/viewforum.php?f=141">community forum</a> or write to us at <a href="http://templatic.com/docs/submit-a-ticket/">helpdesk</a>.</div>';
		
		/* guilde and support link */
		
		$dummy_data_msg .= apply_filters('tmpl_after_install_delete_button',$dummy_data_msg);	
		
		$dummy_nstallation_link  = '<div class="tmpl-ai-btm-links clearfix"><ul><li>Need Help?</li><li><a href="http://templatic.com/docs/classifieds-child-theme/">Theme & Installation Guide</a></li><li><a href="http://templatic.com/forums/viewforum.php?f=141">Support Forum</a></li><li><a href="http://templatic.com/docs/submit-a-ticket/">HelpDesk</a></li></ul><p><a href="http://templatic.com">Team Templatic</a> at your service</p></div>';
		
		if($post_counts>0 ){

				$theme_name = get_option('stylesheet');

				

				$dummy_data_msg='';

				$dummy_data_msg = $dummydata_title;

				

			

				$dummy_data_text_msg = '
				
				<h4><span id="success_msg_install" style="color:green;">'.__("All done. Your site is ready with sample data now.", 'templatic').' <a href="'. site_url().'">'.__("Visit your site", 'templatic').'</a>.</span>
				<p>'.__("To make further adjustments to your site simply visit the", 'templatic').' <a href="'.site_url().'">'.__("homepage", 'templatic').'</a></p></h4>
	<hr>
				<div id="install-notification" ><h4 id="install_message">'.__("Wish to delete sample data?", 'templatic').' </h4><p>'.__("Please note that deleting sample data will also remove any content you may have added or edited on any sample content. Deleting the sample data will also remove all sample widgets which were inserted.", 'templatic').'</p><span><h4>'.__("I understand.", 'templatic').' <a class="button button-primary delete-data-button" href="'.home_url().'/wp-admin/themes.php?dummy=del">'.__('Delete sample data','templatic').'</a></h4></span>';

				$dummy_data_text_msg .='<span id="install-notification-nonce" class="hidden">' . wp_create_nonce( 'install-notification-nonce' ) . '</span></div>';

			

				$dummy_data_msg .= $dummy_theme_message;


			}else{
			

				$theme_name = get_option('stylesheet');

				$dummy_data_msg='';

				$dummy_data_msg = $dummydata_title;



				$dummy_data_text_msg = '<div id="install-notification" class="tmpl-auto-install-yb"><h4>'.__("Your site not looking like our online demo?",'templatic').' </h4> <span><a class="button button-primary" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1">'.__('Install sample data','templatic').'</a></span> <p>'.__('So that you don&prime;t start on a blank site, the sample data will help you get started with the theme. The content includes some default settings, widgets in their locations, pages, posts and a few dummy listings.', 'templatic').'</p>';

				$dummy_data_text_msg .='<span id="install-notification-nonce" class="hidden">' . wp_create_nonce( 'install-notification-nonce' ) .'</span></div>';

				$dummy_data_msg .= $dummy_theme_message;

				

			}

		
		/* if($post_counts>0) 	{*/
		
	
			$theme_name = get_option('stylesheet');
			
			$dummy_data_msg='';
			$dummy_data_msg = $dummydata_title;
			
			$t_theme_licence_key_=get_option('templatic_licence_key');

		

			/* Licence key verification form */

			if($t_theme_licence_key_ ==''){

				$licencekey_frm = '	<tr>

						<td colspan="2"><h1><span>'.__('1', 'templatic').'</span>'.__('Licence Key Verification.', 'templatic').'</h1></td>

					</tr>

					<div class="licence-key-wrap before-autoinstall">

						<th scope="row"><label for="templatic_licence_key">'.__('License key', 'templatic').'</label></th>

						<td>

						<p>'.__('Enter the license key in order to unlock the plugin and enable automatic updates.', 'templatic').'</p>

						<p><input type="password" name="licencekey" id="templatic_licence_key" value='.get_option('templatic_licence_key_').' size="30" max-length="36" PLACEHOLDER="templatic.com purchase code"/></p>

						

						</p>'.__('The key can be obtained from Templatic', 'templatic').' <a href="http://templatic.com/members/member">'.__('member area', 'templatic').'</a></p>

						<p><input type="submit" accesskey="p" value='.__('Verify','templatic').' class="bk-button button-primary button-large" id="Verify" name="Verify"></p></td>

					</div>';
					
					$licencekey_frm .= '<h1><span>'.__('2', 'templatic').'</span>' .__('Sample data', 'templatic').'</h1>

					

						<div class="sample-data-wrap">

						'.$dummy_data_text_msg .do_action('tmpl_error_message').'</div>

				';

			}else{
			
				//$dummy_data_text_msg = '';
			
				$licencekey_frm = '

					<h1><span>'.__('1', 'templatic').'</span>'.__('Licence Key Verification.', 'templatic').'</h1>

					<div class="licence-key-wrap"><p style="color:#62b748;"> '.__('Licence key is verified.', 'templatic').'</p></div>';
					
					$licencekey_frm .= '<h1><span>'.__('2', 'templatic').'</span>' .__('Sample data', 'templatic').'</h1>

						<div class="sample-data-wrap">

						'.$dummy_data_text_msg .do_action('tmpl_error_message').'</div>';

			}
			
			

			$dummy_data_msg .='

			<form action="#" name="" method="post">

			<div class="form-table">

				<div class="theme-step">

					<div class="licence-key">

						'.$licencekey_frm.'

						</div>	';	

				$dummy_data_msg .='</div>';
				
				
			$dummy_data_msg_l ='<div class="wrapper_templatic_auto_install_col3"><div class="templatic_auto_install_col3"><h4>'.__('Get Started','templatic-admin').'</h4>'.$menu_msg1.'</div>';
			$dummy_data_msg_l .='<div class="templatic_auto_install_col3"><h4>'.__('Advance Directory Options','templatic-admin').'</h4>'.$menu_msg2.'</div></div>';
			//$dummy_data_msg_l .='<div class="templatic_auto_install_col3"><h4>'.__('Customize Your Website','templatic-admin').'</h4>'.$menu_msg3.'</div></div>';
			$dummy_data_msg .= "<div class='sample-data'>".$dummy_theme_message.$dummy_data_msg_l.'</div></div>';

			$dummy_data_msg .='</form>';
			
			$dummy_data_msg .='<div class="ref-tev-msg">'.__('Please refer to &quot;Tevolution&quot; and other sections on the left side menu for more of the advanced options.','templatic-admin').'</div>';
			$dummy_data_msg .= $dummy_nstallation_link;	
		
			if(isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert']){
				$theme_name = str_replace(' ','',strtolower(wp_get_theme()));
				require_once (get_stylesheet_directory().'/functions/auto_install/auto_install_data.php');
				
				$args = array(
							'post_type' => 'page',
							'meta_key' => '_wp_page_template',
							'meta_value' => 'page-templates/front-page.php'
							);
				$page_query = new WP_Query($args);
				$front_page_id = $page_query->post->ID;
				update_option('page_on_front',$front_page_id);
				
				$args = array('post_type' => 'page',
							'meta_key' => 'page_for_posts',
							'meta_value' => '1'
							);
				$page_query = new WP_Query($args);
				
				$blog_page_id = $page_query->post->ID;
				update_option('page_for_posts',$blog_page_id);
				
				/*BEING Cretae primary menu */
				$nav_menus=wp_get_nav_menus( array('orderby' => 'name') );
				$navmenu=array();
					foreach($nav_menus as $menus){
						$navmenu[]=$menus->slug;	
					}
					/*Primary menu */
					if(!in_array('primary',$navmenu)){
						$primary_post_info[] = array('post_title'=>'Home','post_id'   =>$front_page_id,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Get submit listing page id */
						$submit_listing_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'submit-classified' and $wpdb->posts.post_type = 'page'");
						$primary_post_info[] = array('post_title'=>'Post an ad','post_id'   =>$submit_listing_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Insert primary menu */	
						wp_insert_classified_name_menu_auto_install($primary_post_info,'primary');					
						
					}// end primary nav menu if condition
					/*Primary menu */
					if(!in_array('footer',$navmenu)){
						$footer_post_info[] = array('post_title'=>'Home','post_id'   =>$front_page_id,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Get submit listing page id */
						$submit_listing_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'submit-classified' and $wpdb->posts.post_type = 'page'");
						$footer_post_info[] = array('post_title'=>'Post an ad','post_id'   =>$submit_listing_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Insert primary menu */	
						wp_insert_classified_name_menu_auto_install($footer_post_info,'footer');					
						
					}// end primary nav menu if condition
					/*Secondary menu */
					if(!in_array('secondary',$navmenu)){
						/*Home Page */
						$secondary_post_info[] = array('post_title'=>'Home','post_id'   =>$front_page_id,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						
						/*Get the  listing category list */
						$args = array( 'taxonomy' =>'classifiedscategory','orderby'=> 'id','order' => 'ASC', );
						$terms = get_terms('classifiedscategory', $args);
						if($terms){
							$i=0;
							$secondary_post_info[] = array('post_title'=>'Classifieds','post_content'=>$term->description,'post_id' =>$term->term_id,'_menu_item_type'=>'custom','_menu_item_object'=>'custom','menu_item_parent'=>0,'_menu_item_url'=>site_url().'/classified');
							foreach($terms as $term){
								if($i == 10)
									break;
								$menu_item_parent=1;
								$secondary_post_info[] = array('post_title'=>'','post_content'=>$term->description,'post_id' =>$term->term_id,'_menu_item_type'=>'taxonomy','_menu_item_object'=>'classifiedscategory','menu_item_parent'=>$menu_item_parent);
								$i++;
							}
						}
						/*finish listingcategory menu */
									
						
						/*Blog menu */
						$args = array( 'taxonomy' =>'category','orderby'=> 'id','order' => 'ASC','exclude'=>array('1'));
						$terms = get_terms('category', $args);
						$secondary_post_info[] = array('post_title'=>'Blog','post_id' =>$blog_page_id,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						
						if($terms){
							$i=0;
							foreach($terms as $term){
								$menu_item_parent=1;
								$secondary_post_info[] = array('post_title'=>'','post_content'=>$term->description,'post_id' =>$term->term_id,'_menu_item_type'=>'taxonomy','_menu_item_object'=>'category','menu_item_parent'=>$menu_item_parent);
								$i++;
							}
						}
						/*finish blog menu */
						
						/*Get contact us page id */
						$contact_us_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'contact-us' and $wpdb->posts.post_type = 'page'");
						$secondary_post_info[] = array('post_title'=>'','post_id'   =>$contact_us_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Get How to setup your site page id */
						$howtosetup_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'how-to-setup-your-site' and $wpdb->posts.post_type = 'page'");
						$secondary_post_info[] = array('post_title'=>'','post_id'   =>$howtosetup_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						/*Get extend_id page id */
						$extend_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'extend' and $wpdb->posts.post_type = 'page'");
						$secondary_post_info[] = array('post_title'=>'','post_id'   =>$extend_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>0);
						
						$secondary_post_info[] = array('post_title'=>'More','post_content'=>'more','post_id' =>'','_menu_item_type'=>'custom','_menu_item_object'=>'custom','menu_item_parent'=>0,'_menu_item_url'=>'');
						/*Get people page id */
						$people_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'people' and $wpdb->posts.post_type = 'page'");
						$secondary_post_info[] = array('post_title'=>'','post_id'   =>$people_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>1);
						/*Get all in one map page id */
						$all_in_one_map_id = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE $wpdb->posts.post_name = 'all-in-one-map' and $wpdb->posts.post_type = 'page'");
						$secondary_post_info[] = array('post_title'=>'','post_id'   =>$all_in_one_map_id->ID,'_menu_item_type'=>'post_type','_menu_item_object'=>'page','menu_item_parent'=>1);		
						/*Insert secondary menu */	
						wp_insert_classified_name_menu_auto_install($secondary_post_info,'secondary');
					}// end secondary nav menu if condition

				/*END primary menu */
				
				wp_redirect(admin_url().'themes.php?x=y');
			}
			if(isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='del'){
				tmpl_classifieds_delete_dummy_data();
				wp_redirect(admin_url().'themes.php');
			}
		
			define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="welcome-panel tmpl-welcome-panel"><div class="welcome-panel-content">'.$dummy_data_msg.'<span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span><a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right">Dismiss</a></div></div>');
			echo THEME_ACTIVE_MESSAGE;
}

/*
 To delete dummy data
*/
function tmpl_classifieds_delete_dummy_data()
{
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj)
	{
		wp_delete_post($pids_info_obj->ID,true);
	}
	$widget_array = array(
		'widget_tmplclassifiedsearch',
		'widget_tmplclassifiedpopularlist',
		'widget_directory_featured_category_list',
		'widget_supreme_advertisements',
		'widget_meta',
		'widget_social_media',
		'widget_templatic_aboust_us',
		'widget_widget_login',
		'widget_tevolution_author_listing',
		'widget_tmplclassifiedfilters_widget',
		'widget_templatic_browse_by_categories',
		'widget_templatic_aboust_us',
		'widget_supreme_facebook',
		'widget_tmplclassifiedrelatedlist_key',
		'widget_directory_neighborhood',
		'widget_templatic_popular_post_technews',
		'widget_templatic_twiter',
		'widget_text',
		'widget_templatic_google_map',
		'widget_supreme_facebook',
	);
	foreach($widget_array as $widget_array){
		delete_option($widget_array); //delete widgets
	}
}
/* Setting For dismiss auto install notification message from themes.php START */
wp_register_theme_activation_hook( wp_get_theme(), 'activate'  );
wp_register_theme_deactivation_hook( wp_get_theme(), 'deactivate'  );
function wp_register_theme_activation_hook($code, $function) {
	add_option( 'hide_ajax_notification', false );
}
function wp_register_theme_deactivation_hook($code, $function) {
	/* store function in code specific global */
	$GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
 
    /* create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function */
	$fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option( "hide_ajax_notification" );');
 
	/* Your theme can perceive this hook as a deactivation hook.*/
	add_action("switch_theme", $fn);
}
add_action( 'admin_footer', 'register_classifieds_admin_scripts'  );
add_action( 'wp_ajax_hide_classified_admin_notification', 'hide_classifieds_admin_notification' );
function activate() {
	add_option( 'hide_ajax_notification', false );
}
function deactivate() {
	delete_option( 'hide_ajax_notification' );
}
function register_classifieds_admin_scripts() {
	wp_register_script( 'ajax-notification-admin', get_template_directory_uri().'/js/_admin-install.js'  );
	wp_enqueue_script( 'ajax-notification-admin' );
}
function hide_classifieds_admin_notification() {
	if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax-notification-nonce' ) ) {
		if( update_option( 'hide_ajax_notification', true ) ) {
			die( '1' );
		} else {
			die( '0' );
		}
	}
}
/* Setting For dismiss auto install notification message from themes.php END */
/*

*/

if(!function_exists('set_page_info_autorun')){
function set_page_info_autorun($pages_array,$page_info_arr)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($page_info_arr);$i++)
	{ 
		$post_title = $page_info_arr[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $page_info_arr[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'page';
			if(isset($post_info_arr['post_author']) && $post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
	
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = (isset($post_info_arr['post_image']))?$post_info_arr['post_image']:'';
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
}
/* This function call for create nav menu on auto install*/
function wp_insert_classified_name_menu_auto_install($post_info,$menu_type){	

	$i=0;
	foreach($post_info as $post){
		$args=array('post_type'=>'nav_menu_item','post_title'=>$post['post_title'],'post_status'=>'publish','menu_order'=>$i);
		/*insert post */
		$post_id=wp_insert_post($args);
		$args=array('ID'=>$post_id,'post_type'=>'nav_menu_item','post_title'=>$post['post_title'],'post_status'=>'publish','post_name'=>$post_id,'menu_order'=>$i);
		/*update inserted post update */
		wp_update_post($args);		
		$i++;
		
		if($post['menu_item_parent']==1){
			$menu_item_parent=$last_post_id;
		}else{
			$menu_item_parent=0;
			$last_post_id=$post_id;
		}
		
		/*update nav menu post meta option */
		update_post_meta($post_id,'_menu_item_type',$post['_menu_item_type']);
		update_post_meta($post_id,'_menu_item_menu_item_parent',$menu_item_parent);
		update_post_meta($post_id,'_menu_item_object_id',$post['post_id']);
		update_post_meta($post_id,'_menu_item_object',$post['_menu_item_object']);
		update_post_meta($post_id,'_menu_item_target','');
		update_post_meta($post_id,'_menu_item_classes',array());
		update_post_meta($post_id,'_menu_item_xfn','');
		update_post_meta($post_id,'_menu_item_url',@$post['_menu_item_url']);
		
		/* Get the nav menu*/
		wp_set_post_terms($post_id,$menu_type,'nav_menu',true);
	}
	
	/*get the nav menu list */
	$nav_menus=wp_get_nav_menus( array('orderby' => 'name') );
	foreach($nav_menus as $menus){
		if($menus->slug==$menu_type){
			$term_id=$menus->term_id;
			break;
		}
	}
	/*Set the nav menu location option as per menu type */
	$themename=get_option('stylesheet');
	$nav_menu_locations = get_option('theme_mods_'.$themename);
	$nav_menu_locations['nav_menu_locations'][$menu_type]=$term_id;		
	update_option('theme_mods_'.$themename,$nav_menu_locations);
}
?>