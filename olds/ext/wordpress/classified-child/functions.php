<?php 
ob_start();
if (defined('WP_DEBUG') and WP_DEBUG == true){
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}

/* set current theme as child and add Directory theme as parent - it will run only first time when the theme will activated */
if (get_option('is_first_time_install_classified') != 1) {
        
		$filename = get_template_directory() . '/style.css';
		$arr = file($filename);
		if ($arr === false) {
		  die('Failed to read ' . $filename);
		}
		array_pop($arr); // remove last line of */ string

		/* add template name into the file */
		$add_string[] = "* Template: Directory";
		$add_string[] =  "\n*/";
		$arr = array_merge($arr,$add_string);

		// write the new data to the file
		$fp = fopen($filename, 'w+');
		fwrite($fp, implode('', $arr));
		fclose($fp); 

		/* Add templatic directory theme to theme folder */
		$tev_directory = get_stylesheet_directory(). "/Directory.zip";
		$directory_theme = get_theme_root() . '/Directory';
		if (!is_dir($directory_theme) && file_exists($tev_directory)) {
				  
			  $zip = new ZipArchive();
			  $x = $zip->open($tev_directory);

			  if ($x === true && file_exists($tev_directory)) {
						$zip->extractTo( get_theme_root()); // change this to the correct site path
						$zip->close();
			  }
		}
		update_option('is_first_time_install_classified', 1);		
}
if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
	update_option('template','Directory');		
}

remove_action('admin_init','directory_theme_localization_slugs');
if(file_exists(trailingslashit ( get_template_directory() ) . 'library/supreme.php'))
	require_once( trailingslashit ( get_template_directory() ) . 'library/supreme.php' ); // contain all classes and core function pf the framework
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
define('TEMPLATE_URI',trailingslashit(get_template_directory_uri()));
define('TEMPLATE_DIR',trailingslashit(get_template_directory()));

global $pagenow,$page;
if(is_admin() && ($pagenow =='themes.php' || $pagenow =='update-core.php' || $pagenow =='post.php' || $pagenow =='edit.php' || trim($page) == trim('tmpl_theme_update'))){
	require_once('wp-updates-theme.php');	
	new WPUpdatesCuisineUpdater( 'http://templatic.com/updates/api/', basename(get_stylesheet_directory()) );
}

/* ok after theme set up */

add_action('after_setup_theme','tmpl_classifeids_setup',12);

function tmpl_classifeids_setup(){
	/*to hide classified auto install link in plugin area*/
	update_option( 'hide_classified_ajax_notification', true );
	/*remove action for regenerate thumbnail*/
	remove_action( 'init', 'directory_register_image_sizes' );
	remove_action('init','popular_post_widget',10);
	add_theme_support( 'supreme-core-sidebars', array( // Add sidebars or widget areas.
				'header',
				'mega_menu',
				'secondary_navigation_right',
				'below-secodary-navigation',
				'home-page-banner',
				'home-page-above-content',
				'home-page-content',
				'home-page-below-content',
				'before-content',
				'entry',
				'after-content',
				'front-page-sidebar',
				'author-page-sidebar',
				'post-listing-sidebar',
				'post-detail-sidebar',
				'primary-sidebar',
				'after-singular',
				'subsidiary',
				'subsidiary-2c',
				'subsidiary-3c',
				'advance_search_sidebar',
				'contact_page_widget',
				'contact_page_sidebar',
				'supreme_woocommerce',
				'home-page-above-footer',
				'footer',
				) );
	add_action( 'customize_register',  'templatic_classified_customizer_settings',100);
	
	/* get mo file for translation. If file is not found in this theme then apply directory theme's mo file */
	$locale = get_locale();
	
	if(is_admin()){
		
		if(file_exists(get_stylesheet_directory().'/languages/admin-'.$locale.'.mo'))
		{ 
			load_textdomain( 'templatic', get_stylesheet_directory().'/languages/admin-'.$locale.'.mo');
		}else{
			load_textdomain( 'templatic', get_template_directory().'/languages/admin-'.$locale.'.mo');
		}
	}else{	
		if(file_exists(get_stylesheet_directory().'/languages/'.$locale.'.mo'))
		{
			load_textdomain('templatic', get_stylesheet_directory().'/languages/'.$locale.'.mo');
		}else{
			load_textdomain('templatic', get_template_directory().'/languages/'.$locale.'.mo');
		}
	}
}
/* to add carousel slider option in home page slider widget */
add_theme_support('show_carousel_slider');

/* register new widget area */
global $theme_sidebars;
add_action('tmpl_cls_open_main','classified_open_main_area_widget');
$theme_sidebars = array(
	'home-page-above-content-all-pages' => array(
		'name' =>	__( 'Above Main Content - All Pages', 'templatic' ),
		'description' =>	__( 'Widgets in this area will display on all pages below menu/map and above content in full width.','templatic' ),
		'before_widget' =>	'',
		'after_widget' =>	'',
	),
	'below-secodary-navigation' => array(
		'name' =>	__( 'Below Secondary Navigation', 'templatic' ),
		'description' =>	__( 'Widgets in this area will be shown below secondary navigation.','templatic' ),
		'before_widget' =>	'',
		'after_widget' =>	'',
	),
	'home-page-above-content' => array(
		'name' =>	__( 'Above Home page content', 'templatic' ),
		'description' =>	__( 'Widgets in this area will be shown above home page content.','templatic' ),
		'before_widget' =>	'',
		'after_widget' =>	'',
	),
	'home-page-below-content' => array(
		'name' =>	__( 'Below Home page content', 'templatic' ),
		'description' =>	__( 'Widgets in this area will be shown in full width below home page content.','templatic' ),
		'before_widget' =>	'',
		'after_widget' =>	'',
	),
	'home-page-above-footer' => array(
		'name' =>	__( 'Inside Home page Footer', 'templatic' ),
		'description' =>	__( 'Widgets in this area will be shown in full width inside the home page footer.','templatic' ),
		'before_widget' =>	'',
		'after_widget' =>	'',
	)
	
	);
/* to show the widget area on front page only */
function classified_open_main_area_widget(){ 
	if(is_active_sidebar('home-page-above-content-all-pages')){ ?>
		 <div class="home_page_full_content row">
		 	<div class="columns">
	          	<?php dynamic_sidebar('home-page-above-content-all-pages'); ?>
	        </div>
         </div>
	<?php }
	
		if((is_front_page() || is_tax() || (is_archive() && !is_author()) || is_search() || is_single() ) && is_active_sidebar('below-secodary-navigation')){
		?>
		 <div class="home_page_full_content row">
		 	<div class="columns classified_search">
	          	<?php dynamic_sidebar('below-secodary-navigation'); ?>
	        </div>
         </div>
		 <?php }
		if(is_front_page() && is_active_sidebar('home-page-above-content')){
		?>
		 <div class="home_page_full_content row">
		 	<div class="columns ">
	          	<?php dynamic_sidebar('home-page-above-content'); ?>
	        </div>
         </div>
	<?php }
}
/* to show the widget area  */

add_action('listng_post_after_content','tmpl_listng_post_after_content');

function tmpl_listng_post_after_content(){
	global $post; ?>
	<div class="post-meta" >                              
		<?php 
		echo tmpl_get_the_posttype_taxonomies('Category','category');
	
		echo tmpl_get_the_posttype_tags('Post tags','post_tags'); ?>
	</div><?php
}


/* add widget inside footer - full width */
add_action('open_footer_widget','tmpl_home_page_above_footer');

function tmpl_home_page_above_footer(){ 
	if(is_active_sidebar('home-page-above-footer')){
	?>
	<div class="home_page_below_content">
        <?php dynamic_sidebar('home-page-above-footer'); ?>
    </div>
<?php }
}
/*
	Added Logo after theme activation 
*/
function tmpl_classified_theme_activation(){
	global $theme_name;
	$theme_name = wp_get_theme('Directory');
    if($theme_name != 'Directory')
    {
		remove_action('admin_init','theme_activation'); 
		global $pagenow;	
		$theme_name = strtolower(wp_get_theme());
		if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
			$b = array(
					'supreme_logo_url' 					=> get_stylesheet_directory_uri()."/images/".$theme_name."/logo.png",
					'display_header_text'				=> 1,
					'enable_comments_on_post'			=> 1,
					'supreme_display_noimage'			=> 1,
					'enable_comments_on_post'			=> 1
				);
			if(function_exists('supreme_prefix'))
				$supreme_prefix=supreme_prefix();
			else
				$supreme_prefix=sanitize_key( apply_filters( 'hybrid_prefix', get_template() ) );
			
			update_option($supreme_prefix.'_theme_settings',$b);
		}
	}
}
add_action('admin_init','tmpl_classified_theme_activation',9); 


/* Star Rating image */
add_action('init','re_star_rating_image',9);
function re_star_rating_image()
{
	global $theme_name;
	$theme_name = strtolower(wp_get_theme());		
	if(strtolower($theme_name) == strtolower('RealEstate'))
	{
		remove_action('init','tevolution_fetch_rating_image');
		add_action('init','classified_fetch_rating_image');
		function classified_fetch_rating_image()
		{
			global $post,$rating_image_on,$rating_image_off,$rating_table_name;
			$rating_image_on = get_template_directory_uri().'/images/classified/star_rated.png';
			$rating_image_off = get_template_directory_uri().'/images/classified/star_normal.png';
		}
		add_filter('rating_star_rated_half','rating_star_rated_half');
		function rating_star_rated_half()
		{
			return  get_directory_uri().'/images/classified/star_rated_half.png';
		}
		
		add_filter('rating_star_rated','rating_star_rated');
		function rating_star_rated()
		{
			return  get_directory_uri().'/images/classified/star_rated.png';
		}
		
		add_filter('rating_star_normal','rating_star_normal');
		function rating_star_normal()
		{
			return  get_directory_uri().'/images/classified/star_normal.png';
		}
	}
}

/* code to auto extract plug ins  START*/	 
function tmpl_cls_zip_copy( $source, $target, $plug_path, $add_msg=0) 
{
		if(!@copy($source,$target))
		{	add_action('admin_notices','dir_one_click_install');
			$errors= error_get_last();
			echo "<span style='color:red;'>COPY ERROR:</span> ".$errors['type'];
			echo "<br />\n".$errors['message'];
		} else {
				$file = explode('.',$target);
		
				if(file_exists($target)){ 
					$message ="<span style='color:green;'>File copied from remote!</span><br/>";
					
					$zip = new ZipArchive();
					$x = $zip->open($target);
					
					if ($x === true && file_exists($target)) { 
						$zip->extractTo( get_tmpl_plugin_directory()); // change this to the correct site path
						$zip->close();
		
						
						unlink($target);
						$message = "Your .zip file was uploaded and unpacked.<br/>";
					}else{
						
					}
				}
			if($add_msg == 1 && strstr($_SERVER['REQUEST_URI'],'themes.php')){ 
				update_option('tev_on_go_re',1);
				
				$plug_path2 = "Tevolution-Classifieds/classifieds.php";  // change this to the correct site path
				$plug_path3 = "Tevolution-LocationManager/location-manager.php";  // change this to the correct site path
				$plug_path1 = "Tevolution/templatic.php";  // change this to the correct site path
				
				activate_plugin($plug_path1);
				activate_plugin($plug_path2);
				activate_plugin($plug_path3);
				
				update_option('cls_easy_install_redirect_activation','Active');
				$location_post_type[]='post,category,post_tag';
				$location_post_type[]='classified,classifiedscategory,classifiedstags';
				$post_types=update_option('location_post_type',$location_post_type);
				
			}
	}
}
/* code for easy install zip */
add_action('admin_init', 'tmpl_cls_easy_install_plugin_redirect_templatic',20);
function tmpl_cls_easy_install_plugin_redirect_templatic()
{
	if (get_option('cls_easy_install_redirect_activation') == 'Active' && is_plugin_active('Tevolution/templatic.php'))
	{
		update_option('cls_easy_install_redirect_activation', 'Deactive');
		wp_redirect(site_url().'/wp-admin/admin.php?page=templatic_system_menu');
		exit;
	}
}
/*
	Return the plug-in directory path
*/
if(!function_exists('get_tmpl_plugin_directory')){
function get_tmpl_plugin_directory() {
	 return WP_CONTENT_DIR."/plugins/";
}
}
/* code for easy install zip */
if(is_admin() && is_writable(WP_CONTENT_DIR."/plugins") && is_readable(get_stylesheet_directory())){
	$tev_zip = get_stylesheet_directory()."/Tevolution.zip";
	$tev_zip_path = get_stylesheet_directory()."/Tevolution.zip";
	$re_zip = get_stylesheet_directory()."/Tevolution-Classifieds.zip";
	$re_zip_path = get_stylesheet_directory()."/Tevolution-Classifieds.zip";
	$loc_zip = get_stylesheet_directory()."/Tevolution-LocationManager.zip";
	$loc_zip_path = get_stylesheet_directory()."/Tevolution-LocationManager.zip";
	
	$target_path1 = get_tmpl_plugin_directory()."Tevolution.zip";  // change this to the correct site path
	$target_path2 = get_tmpl_plugin_directory()."Tevolution-Classifieds.zip";  // change this to the correct site path
	$target_path3 = get_tmpl_plugin_directory()."Tevolution-LocationManager.zip";  // change this to the correct site path
	
	$plug_path1 = "Tevolution/templatic.php";  // change this to the correct site path
	$plug_path2 = "Tevolution-Classifieds/classifieds.php";  // change this to the correct site path
	$plug_path3 = "Tevolution-LocationManager/location-manager.php";  // change this to the correct site path
	global $pagenow;

	if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php') {
            if(file_exists($tev_zip_path))
                    tmpl_cls_zip_copy( $tev_zip, $target_path1, $plug_path1 );
            if(file_exists($re_zip_path))
                    tmpl_cls_zip_copy( $re_zip, $target_path2, $plug_path2 );
            if(file_exists($loc_zip_path))
                    tmpl_cls_zip_copy( $loc_zip, $target_path3, $plug_path3, $add_msg=1 );

	}
}

/* add classifieds thumbnail size */
add_filter('supreme_thumbnail_height','tmpl_classified_tevolution_thumbnail_width');
add_filter('supreme_thumbnail_width','tmpl_classified_tevolution_thumbnail_height');
	
add_filter('tevolution_thumbnail_width','tmpl_classified_tevolution_thumbnail_width');
function tmpl_classified_tevolution_thumbnail_width(){
	return '80';	
}

add_filter('tevolution_thumbnail_height','tmpl_classified_tevolution_thumbnail_height');
function tmpl_classified_tevolution_thumbnail_height(){
	return '70';	
}
/*change the itemwidth of detail page slider.*/
add_filter('tmpl_detail_slider_options','tmpl_classified_detail_slider_options');
function tmpl_classified_detail_slider_options()
{
	return array('animation'=>'slide','slideshow'=>'false','direction'=>'horizontal','slideshowSpeed'=>7000,'animationLoop'=>'true','startAt'=> 0,'smoothHeight'=> 'true','easing'=> "swing",'pauseOnHover'=> 'true','video'=> 'true','controlNav'=> 'false','directionNav'=> 'false','prevText'=> 'next','nextText'=> 'previous','animationLoop'=>'true','itemWidth'=>'90','itemMargin'=>'15');
}
add_action( 'init', 'classified_theme_register_image_sizes' );
function classified_theme_register_image_sizes(){
		/* add_image_size( 'clasified-thumb', 175, 125, true ); */
	add_image_size('adv_detail-main-img',400,290,true);
	/* listing page featured thumbnail */
	add_image_size('adv_listings-thumb',250,165,true);
	add_image_size('tevolution_thumbnail',90,65,true);
	
	add_image_size( 'popular_post-thumbnail',90,65,true);
	add_image_size( 'mobile-thumbnail',90,65,true);
	add_image_size( 'slider-thumbnail',175,125,true);
	/* add_image_size('classified_slider_img_thumb',175,125,true); */
}
/*set wordpress iamge*/
add_action( 'init', 'classified_child_theme_register_image_sizes' );
function classified_child_theme_register_image_sizes(){	
	
	add_image_size( 'thumbnail', 90, 65, true );
	if(get_option('tmpl_added_default_image_sizes') != 1){
		if(get_option('thumbnail_size_w')!=90)
			update_option('thumbnail_size_w',90);
		if(get_option('thumbnail_size_h')!=65)
			update_option('thumbnail_size_h',65);
			
		if(get_option('medium_size_w')!=0)
			update_option('medium_size_w',0);
		if(get_option('medium_size_h')!=0)
			update_option('medium_size_h',0);
			
		if(get_option('large_size_w')!=0)
			update_option('large_size_w',0);
		if(get_option('large_size_h')!=0)
			update_option('large_size_h',0);
			
		update_option('tmpl_added_default_image_sizes',1);	
	}	
	
}
function templatic_classified_customizer_settings($wp_customize)
{
	$wp_customize->get_control('color_picker_color1')->label = __('Primary Color','templatic');
	$wp_customize->get_control('color_picker_color2')->label = __('Secondary Color','templatic');
	$wp_customize->get_control('color_picker_color3')->label = __('Content Color','templatic');
	$wp_customize->get_control('color_picker_color4')->label = __('Body Background Color','templatic');
	$wp_customize->remove_control('color_picker_color5');
	$wp_customize->remove_control('color_picker_color6');
}
/* header hook to set the current city background colour and header image colour/image*/
remove_action('before_desk_menu_primary','tmpl_locations_color_settings',100);
add_action('before_desk_menu_primary','tmpl_classifieds_locations_color_settings',100);
function tmpl_classifieds_locations_color_settings(){
	global $current_cityinfo,$wpdb,$multicity_table;
	/* Set city wise  back ground colour or image */
	if(($current_cityinfo['color'] && $current_cityinfo['color'] !='#') || $current_cityinfo['images'] || ($current_cityinfo['header_color'] && $current_cityinfo['header_color'] !='#') || $current_cityinfo['header_image']):?>
		<style type="text/css">
			html body{
				<?php if($current_cityinfo['color']):?>
					background-color:<?php echo $current_cityinfo['color'];?>!important;
				<?php endif;?>
				<?php if($current_cityinfo['images']):?>
					background-image:url('<?php echo $current_cityinfo['images'];?>')!important;
				<?php endif;?>
			}
			header.header_container,body div.header_container{
				<?php if($current_cityinfo['header_color']):?>
					background-color:<?php echo $current_cityinfo['header_color'];?>!important;
				<?php endif;?>
				<?php if($current_cityinfo['header_image']):?>
					background-image:url('<?php echo $current_cityinfo['header_image'];?>')!important;
				<?php endif;?>
			}
		</style>
	<?php endif;
}
/*
 * Child theme auto update.
 */
add_action('admin_menu','classified_templatic_menu',20);
if(!function_exists('classified_templatic_menu'))
{
	function classified_templatic_menu()
	{
		if(is_plugin_active('Tevolution/templatic.php')){
                    add_submenu_page( 'templatic_system_menu', __('Child Theme Update','templatic'), __('Child Theme Update','templatic'), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update',27 );
		}else{
                    add_submenu_page( 'templatic_menu',  __('Child Theme Update','templatic'), __('Child Theme Update','templatic'), 'administrator', 'child_tmpl_theme_update', 'child_tmpl_theme_update',27 );
		}
	}
}
if(!function_exists('child_tmpl_theme_update'))
{
	function child_tmpl_theme_update()
	{
		require_once(get_stylesheet_directory()."/templatic_login.php");
	}
}
?>