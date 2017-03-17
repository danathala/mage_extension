<?php 

/* get the color settings from customizer and write in theme_options.css file located in functions */
function directory_hex2rgb($hex='') {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}



/*
    File contain the code for color options in customizer 
*/

ob_start();
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	//require($file . "/wp-load.php");
	global $wpdb;
	if(function_exists('supreme_get_setting')){
		$color1 = supreme_get_setting( 'color_picker_color1' );
		$color2 = supreme_get_setting( 'color_picker_color2' );
		$color3 = supreme_get_setting( 'color_picker_color3' );
		$color4 = supreme_get_setting( 'color_picker_color4' );
		$color4 = supreme_get_setting( 'color_picker_color4' );
		$color6 = supreme_get_setting( 'color_picker_color6' );
	}else{
		$supreme_theme_settings = get_option(supreme_prefix().'_theme_settings');
		if(isset($supreme_theme_settings[ 'color_picker_color1' ]) && $supreme_theme_settings[ 'color_picker_color1' ] !=''):
			$color1 = $supreme_theme_settings[ 'color_picker_color1' ];
		else:
			$color1 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color2' ]) && $supreme_theme_settings[ 'color_picker_color2' ] !=''):
			$color2 = $supreme_theme_settings[ 'color_picker_color2' ];
		else:
			$color2 = '';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color3' ]) && $supreme_theme_settings[ 'color_picker_color3' ] !=''):
			$color3 = $supreme_theme_settings[ 'color_picker_color3' ];
		else:
			$color3 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color4' ]) && $supreme_theme_settings[ 'color_picker_color4' ] !=''):
			$color4 = $supreme_theme_settings[ 'color_picker_color4' ];
		else:
			$color4 = '';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color4' ]) && $supreme_theme_settings[ 'color_picker_color4' ] !=''):
			$color4 = $supreme_theme_settings[ 'color_picker_color4' ];
		else:
			$color4 ='';
		endif;
		
		if(isset($supreme_theme_settings[ 'color_picker_color6' ]) && $supreme_theme_settings[ 'color_picker_color6' ] !=''):
			$color6 = $supreme_theme_settings[ 'color_picker_color6' ];
		else:
			$color6 ='';
		endif;
	}

//Primary Color
if($color1 != "#" || $color1 != ""){?>

	body .header_container .header-wrap .header-widget-wrap #sidebar-header .widget .post-free-classifieds-btn:hover,
	.comment-content p a,
	.list .entry .classified-tax-detail > p a:hover,
	.widget h4 a:hover,
	.popular_post ul li .post_data h3 a:hover,
	.recent_comments li a.title:hover,
	.author_info .title a:hover,
	.templatic_twitter_widget .twit_time,
	.slider_carousel .slides li > h3 a:hover,
	.tmpl-seller-detail-rt .title a:hover,
	#tev_sub_categories ul li a:hover, #sub_event_categories ul li a:hover, #sub_listing_categories ul li a:hover,
	.classified-short span a:hover,
	h2.entry-title a:hover,
	.list .entry .classified-tax-detail > p a:hover,
	.singular-property .supreme_wrapper .property .entry-header-right .property-price,
	.comment-header .comment-author .comment-author a:hover,
	#post-listing .complete .step-heading,
	.entry-meta .category a:hover, .entry-meta .post_tag a:hover,
	#content ul.products li.product:hover h3,#content ul.products li.product .price,body.woocommerce #content div.product p.price, body.woocommerce #content div.product span.price, body.woocommerce div.product p.price, body.woocommerce div.product span.price, body.woocommerce-page #content div.product p.price, body.woocommerce-page #content div.product span.price, body.woocommerce-page div.product p.price, body.woocommerce-page div.product span.price,
	a, ol li a, ul li a,body .mega-menu ul.mega li a:hover, body .mega-menu ul.mega li.current-menu-item a, body .mega-menu ul.mega li.current-page-item a, body .mega-menu ul.mega li:hover > a, body .nav_bg .widget-nav-menu li a:hover, body div#menu-secondary .menu li a:hover, body div#menu-secondary1 .menu li a:hover, body div#menu-subsidiary .menu li a:hover,.mega-menu ul.mega li .sub li.mega-hdr a.mega-hdr-a:hover,body .mega-menu ul.mega li ul.sub-menu ul li a:hover,body .header_container .header-wrap .header-widget-wrap #sidebar-header form .search-icon:hover i,
	a:hover, ol li a:hover, ul li a:hover, body .mega-menu ul.mega li .sub-container.non-mega .sub a:hover, body .mega-menu ul.mega li .sub-container.non-mega li a:hover, body .mega-menu ul.mega li .sub-container.non-mega li.current-menu-item a, #recentcomments a:hover, #breadcrumb a:hover, .breadcrumb a:hover, .error_404 h4, .arclist h2, .arclist ul li a:hover, .arclist ul li .arclist_date a:hover, .byline a:hover, .entry-meta a:hover, .post_info_meta a:hover, #content ui-datepicker-div.people_info h3 a,.supreme_wrapper .fav a.addtofav:hover, .supreme_wrapper .fav a.removefromfav:hover,.user_dsb_cf span a:hover, #respond #cancel-comment-reply-link,
	body #menu-secondary .menu li[class*="current-menu"] > a, body #menu_secondary_mega_menu .mega li[class*="current-menu"] > a, body .menu li[class*="current-menu"] > a,
	.slider_carousel .flex-direction-nav li a:hover,
	.all_category_list_widget .category_list h3 i,
	#footer .footer_bottom a:hover,
	.sidebar .widget_recent_comments ul li a:hover,
	.sidebar .widget.pages ul li a:hover,
	.sidebar .widget-nav-menu ul li a:hover,
	.sidebar .widget_meta ul li a:hover,
	.sidebar .widget.categories ul li a:hover,
	.sidebar .widget.archives ul li a:hover,
	.sidebar .xoxo.authors li a:hover,
	.sidebar .widget.login_widget ul li a:hover,
	div.event_manager_tab ul.view_mode li a:hover:before, div.directory_manager_tab ul.view_mode li a:hover:before,
	div.event_manager_tab ul.view_mode li a.active:before, div.directory_manager_tab ul.view_mode li a.active:before,
	.classified-short span a.active,
	.wordpress .tabs dd.active a, .wordpress .tabs .tab-title.active a,
	.popular_posts.widget ul li .post_data h3 a:hover,
	.wordpress .tabs dd > a:hover, .wordpress .tabs .tab-title > a:hover,
	.widget #wp-calendar .calendar_tooltip .event_title,
	.header_container .primary_menu_wrapper div#menu-primary .sub-menu li a:hover,
	body div#menu-primary .menu li:hover a, body div#menu-primary .menu li[class*="current-menu"] a,
	.listing_post .hentry h2 a,
	.comment_excerpt:hover,
	.tevolution-directory .post-meta a:hover,
	.templatic-editor button.fr-trigger.active:not(.fr-color-bttn), .templatic-editor button.fr-bttn.active:not(.fr-color-bttn),
	.pub-link:hover,
	.attending_event span.fav span.span_msg a:hover,
	.moretag:hover,
	body .rev_pin ul li a:hover,
	.list .entry .bottom_line a:hover,
	.social_media ul li a:hover,
	#content .peoplelisting li h3 span.total_homes a:hover,
	.peoplelink a:hover,
	p.links a:hover,
	.views a:hover,
	.all_category_list_widget .category_list ul li a:hover, .all_category_list_widget .category_list h3 a:hover,
	.nav-menu li a:hover,
	.bottom_line a:hover,
	.singular-classified .classified-price span,
	#footer .footer_bottom .copyright a:hover, #footer .footer_bottom .credit a:hover,
	.widget .nav-menu li a i,
	.widget .nav-menu li a:hover,
	.agent-social-networks a:hover
	{ color:<?php echo $color1;?>; }

	body #content .people_info h3 a:hover,
	body .comment-reply-link:hover, body .comment-reply-login:hover{
		color:<?php echo $color1;?>!important;
	}

	.tab-bar,
	.sidebar .classified_search .button,
	#classified-price-range .ui-widget-header,
	.post .entry .property-title .property-price .prop-price, .post .entry .entry-title-wrapper .property-price .prop-price,
	body.woocommerce-page nav.woocommerce-pagination ul li span.current,
	#silde_gallery .flex-direction-nav li a,
	.frontend_editor .directory_google_map #panel input[type="button"]:hover, .frontend_editor #panel input[type="button"]:hover,
	body .main_btn,
	#searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button,
	.left-off-canvas-menu,.header_container,
	.cancel-btn:hover, a.cancel-btn:hover, input.cancel-btn:hover, .secondray-button:hover, .uploadfilebutton.secondray-button:hover, a.button.secondray-button:hover, button.secondray-button:hover, input.secondray-button[type="button"]:hover, input.secondray-button[type="reset"]:hover, input.secondray-button[type="submit"]:hover,
	.classified-short span a.active:before,
	a.current.page-numbers, span.current.page-numbers strong, .page-numbers:hover strong,
	body .secondary_btn:hover, .comment-pagination .page-numbers:hover strong, strong.prev:hover, strong.next:hover, .loop-nav span.next:hover, .loop-nav span.previous:hover, .pagination .page-numbers:hover strong, body .pos_navigation .post_left a:hover, body .pos_navigation .post_right a:hover, a.current.page-numbers, a.page-numbers[title~="Last"]:hover, a.page-numbers[title~="First"]:hover,
	#content .claim-post-wraper > ul > li > a:hover,#content .claim-post-wraper ul li a.calendar_show:hover,
	.sort_order_alphabetical ul li a:hover, .sort_order_alphabetical ul li.active a, .sort_order_alphabetical ul li.nav-author-post-tab-active a,
	#content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover,body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, body.woocommerce-page a.button.alt:hover, body.woocommerce-page a.button:hover, body.woocommerce-page button.button.alt:hover, body.woocommerce-page button.button:hover, body.woocommerce-page input.button.alt:hover, body.woocommerce-page input.button:hover, div.woocommerce form.track_order input.button:hover,.sidebar #searchform input[type="submit"],
	.social_media ul li a:hover i,
	.sticky_main #branding1,
	.postpagination a.active, .postpagination a:hover,
	#content .claim-post-wraper > ul > li > a.removefromfav,
	.list .post .entry .date, .list [class*="post"] .entry .date,
	body .browse_by_tag a:hover,body .tagcloud a:hover,body .tags a:hover,
	.singular-property .supreme_wrapper .entry-header-custom-wrap ul li i,
	.reverse,.button, .uploadfilebutton, a.button, input[type="button"], input[type="reset"], input[type="submit"],
	#searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce a.button, body.woocommerce a.button.alt, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button,
    .filter-options .flit-opt-cols1 a:hover,
    .recurrence_text:hover,
    .singular-classified #contact_seller_id
	{ background:<?php echo $color1;?>; }

	body .social_media ul li a:hover i,.author-page .social_media ul li a:hover i, .user .social_media ul li a:hover i,
	table.calendar_widget td.date_n div span.calendar_tooltip,
	{
		border-color: <?php echo $color2;?>;
	}
	body .social_media ul li a:hover i, .author-page .social_media ul li a:hover i, .user .social_media ul li a:hover i, table.calendar_widget td.date_n div span.calendar_tooltip{
		border-color: <?php echo $color1;?>;
	}

<?php }


//Change color of Title Color
if($color2 != "#" || $color2 != ""){?>

	h1, h2, h3, h4, h5, h6
	.widget.tmpl-classified-related h3, .widget h3.widget-title, .widget-search h3.widget-title, h3.widget-title, .slider_carousel h3.widget-title,
	.all_category_list_widget .category_list h3 a,
	body #content .people_info h3 a, h2.entry-title a,
	.classified-short span a,
	.sidebar .tmpl_search_classified.widget #tmpl_find_classified h4,
	.list [class*="classified"] .entry [class*="-title"] .classified-price .cls-price-wrapper,
	.slider_carousel .slides li > h3 a,
	.tmpl-seller-detail-rt .title a,
	.singular-classified .classified_info-right .classified-info p label, .user_dsb_cf > div label, .user_dsb_cf > p label,
	.wordpress .tabs dd > a, .wordpress .tabs .tab-title > a,
	.widget h3.widget-title, .widget-search h3.widget-title, h3.widget-title,.slider_carousel h3.widget-title,
	.widget.tmpl-classified-related h3, .widget h3.widget-title, .widget-search h3.widget-title, h3.widget-title, .slider_carousel h3.widget-title,
	.author_info .title a,
	.widget h4 a,
	#widget_loop_classified h3,
	.recent_comments li a.title,
	.author_info .title a,
	.popular_posts.widget ul li .post_data h3 a,
	.widget h4 a,
	h2.entry-title a,
    .filter-options .flit-opt-cols span.value a:hover,
    .browse_by_categories ul li a:hover,
    .owner_name a:hover,
    a.more:hover,
    .textwidget a:hover,
    .nav-menu li a,
    .entry-content a:hover,
    .posted_successful a:hover,
    .submit_info_section a:hover,
    .submited_info a:hover,
    .singular-classified .spt-left > ul li .listing_rating a:hover,
    .website a.frontend_web_site:hover,
    .d_location_type_navigation .d_location_navigation_left .horizontal_location_nav li.cities_names a:hover,
    .widget .nav-menu li a
	{ color:<?php echo $color2;?>; }

	.sidebar .classified_search .button:hover,
	.list .entry .classified-tax-detail > p.i_category:after, .list .entry .classified-tax-detail > p.address:after,
	.frontend_editor .directory_google_map #panel input[type="button"], .frontend_editor #panel input[type="button"],
	.cancel-btn, a.cancel-btn, input.cancel-btn, .secondray-button, .uploadfilebutton.secondray-button, a.button.secondray-button, button.secondray-button, input.secondray-button[type="button"], input.secondray-button[type="reset"], input.secondray-button[type="submit"],.btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled],
	#content input.button:hover, #searchform input[type="submit"]:hover, .upload:hover, body.woocommerce #content input.button.alt:hover, body.woocommerce #content input.button:hover, body.woocommerce #respond input#submit.alt:hover, body.woocommerce #respond input#submit:hover, body.woocommerce .widget_layered_nav_filters ul li a:hover, body.woocommerce button.button.alt:hover, body.woocommerce button.button:hover, body.woocommerce input.button.alt:hover, body.woocommerce input.button:hover, body.woocommerce-page #content input.button.alt:hover, body.woocommerce-page #content input.button:hover, body.woocommerce-page #respond input#submit.alt:hover, body.woocommerce-page #respond input#submit:hover, body.woocommerce-page .widget_layered_nav_filters ul li a:hover, div.woocommerce form.track_order input.button:hover, .button:hover, .uploadfilebutton:hover, a.button:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover,.submitbutton, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit.alt, body.woocommerce input.button.alt, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page a.button.alt, body.woocommerce-page button.button.alt, body.woocommerce-page input.button.alt,body.woocommerce #content .quantity .minus:hover, body.woocommerce #content .quantity .plus:hover, body.woocommerce .quantity .minus:hover, body.woocommerce .quantity .plus:hover, body.woocommerce-page #content .quantity .minus:hover, body.woocommerce-page #content .quantity .plus:hover, body.woocommerce-page .quantity .minus:hover, body.woocommerce-page .quantity .plus:hover,.property_search #searchproperty .form_row .b_search_event:hover,body .ui-datepicker-trigger:hover,.widget #wp-calendar caption,
	#content .claim-post-wraper > ul > li > a,#content .claim-post-wraper ul li a.calendar_show,
	#searchform input[type="submit"], .upload, body.woocommerce #content input.button, body.woocommerce #content input.button.alt, body.woocommerce #respond input#submit, body.woocommerce #respond input#submit.alt, body.woocommerce .widget_layered_nav_filters ul li a, body.woocommerce button.button, body.woocommerce button.button.alt, body.woocommerce input.button, body.woocommerce input.button.alt, body.woocommerce-page #content input.button, body.woocommerce-page #content input.button.alt, body.woocommerce-page #respond input#submit, body.woocommerce-page #respond input#submit.alt, body.woocommerce-page .widget_layered_nav_filters ul li a, body.woocommerce-page a.button, body.woocommerce-page a.button.alt, body.woocommerce-page button.button, body.woocommerce-page button.button.alt, body.woocommerce-page input.button, body.woocommerce-page input.button.alt, div.woocommerce form.track_order input.button,.sidebar #searchform input[type="submit"]:hover,
	#footer .footer_bottom,
	.singular-classified #contact_seller_id:hover
	{ background:<?php echo $color2;?>; }

<?php }

//Change Body font color
if($color3 != "#" || $color3 != ""){?>

	body,
	body #loop_listing_archive .post .entry p, body #loop_listing_taxonomy .post .entry p, body #tmpl-search-results.list .hentry p, .entry-details p,
	div.event_manager_tab ul.view_mode li a:before, div.directory_manager_tab ul.view_mode li a:before,
	a:hover, ol li a:hover, ul li a:hover,
	.sidebar .widget_recent_comments ul li a,
	.sidebar .widget.pages ul li a,
	.sidebar .widget-nav-menu ul li a,
	.sidebar .widget_meta ul li a,
	.sidebar .widget.categories ul li a,
	.sidebar .widget.archives ul li a,
	.sidebar .xoxo.authors li a,
	.sidebar .widget.login_widget ul li a,
	.contact_widget textarea.error,
	.supreme_wrapper .fav a.addtofav:hover,
	.widget #wp-calendar .calendar_tooltip .event_title:hover,
	.widget table.calendar_widget td.date_n div span.calendar_tooltip small .wid_event_list b.label,
	.listing_post .hentry h2 a:hover,
	.supreme_wrapper .classified_manager_tab ul.view_mode li a:hover:after,
	.tevolution-directory .post-meta a,
	.pub-link,
	.attending_event span.fav span.span_msg a,
	.moretag,
	body .rev_pin ul li a,
	label,.form_row label,.form_row label:hover,
	.social_media ul li a,
	#content .peoplelisting li h3 span.total_homes a,
	.peoplelink a,
	p.links a,
	.views a,.date,
	.header_container .primary_menu_wrapper div#menu-primary .sub-menu li a,
	.nav_bg .widget-nav-menu li a, div#menu-secondary .menu li a, div#menu-secondary1 .menu li a, div#menu-subsidiary .menu li a,body .mega-menu ul.mega li a,body .mega-menu ul.mega li .sub li.mega-hdr a.mega-hdr-a,body .mega-menu ul.mega li .sub a,
	body .mega-menu ul.mega li ul.sub-menu ul li a,
	.tab-bar .menu-icon,
	body .header_container .header-wrap .header-widget-wrap #sidebar-header .widget .post-free-classifieds-btn,
	body #show_togglebox-button #show_togglebox_wrap,
	.comment-content p a:hover,
	.all_category_list_widget .category_list ul li a,
	.slider_carousel .slides li span.classified-price,
	.post-right span.rel-price,
	#tev_sub_categories ul li a, #sub_event_categories ul li a, #sub_listing_categories ul li a,
	.list .post .entry p, .grid .post .entry p, .list .hentry p, .entry-details p,
	.list .entry .classified-tax-detail > p, .list .entry .classified-tax-detail > p label, .list .entry .classified-tax-detail > p a,
	.grid .entry .classified-price,
	.comment_excerpt,
	.comment-pagination .page-numbers strong, .pagination .page-numbers strong, strong.prev, strong.next, .expand.page-numbers, a.page-numbers[title~="Last"], a.page-numbers[title~="First"], span.page-numbers.dots, .loop-nav span.next, .loop-nav span.previous, body .pos_navigation .post_left a, body .pos_navigation .post_right a,
	.comment-header .comment-author .comment-author a,
	.ui-widget-content a,
	body .toggle_handler #directorytab.directorytab_open,
	.user_dsb_cf span,
	.user_dsb_cf span a,
	.entry p strong, .entry p strong,
	body .ui-widget-content.ui-autocomplete.ui-front li.instant_search span.type, 
	.header-widget-wrap #sidebar-header form .ui-widget-content.ui-autocomplete.ui-front li.instant_search span.type,
	div#menu-primary .menu li a,
	input.input-text,
	input[type="date"],
	input[type="datetime-local"],
	input[type="datetime"],
	input[type="email"],
	input[type="month"],
	input[type="number"],
	input[type="password"],
	input[type="search"],
	input[type="tel"],
	input[type="text"],
	input[type="time"],
	input[type="url"],
	input[type="week"],
	select,
	textarea,
	input.input-text:focus,
	input[type="date"]:focus,
	input[type="datetime-local"]:focus,
	input[type="datetime"]:focus,
	input[type="email"]:focus,
	input[type="month"]:focus,
	input[type="number"]:focus,
	input[type="password"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="text"]:focus,
	input[type="time"]:focus,
	input[type="url"]:focus,
	input[type="week"]:focus,
	select:focus,
	textarea:focus,
	#footer .copyright, #footer .credit,
	#footer .footer_bottom .copyright a, 
	#footer .footer_bottom .credit a,
	#footer .footer_bottom a, #footer .footer_bottom .social_media ul li a i,
	.slider_carousel .slides li > h3 a,
	.widget .nav-menu li a,
	.slider_carousel .flex-direction-nav li a,
	.widget.tmpl-classified-related h3, 
	.widget h3.widget-title, 
	.widget-search h3.widget-title, 
	h3.widget-title, 
	.slider_carousel h3.widget-title,
	.grid [class*="post"] p.event_date::before, 
	.post .favourite::before, .attended_persons::before,
	.list [class*="post"] p.owner_name::before,
	.grid [class*="post"] p.owner_name::before,
	.list [class*="post"] p.phone::before,
	.grid [class*="post"] p.phone::before,
	.list [class*="post"] p.address::before,
	.grid [class*="post"] p.address::before,
	.list [class*="post"] p.time::before,
	.grid [class*="post"] p.time::before,
	.list [class*="post"] p.event_date::before,
	.grid [class*="post"] p.event_date::before,
	.list [class*="post"] p.address::before,
	.grid [class*="post"] p.address::before,
	.list [class*="post"] p.time::before,
	.grid [class*="post"] p.time::before,
	.peoplelink .website::before,
	.peoplelink .facebook::before,
	.peoplelink .twitter::before,
	.peoplelink .linkedin::before,
	.links .email::before,
	.links .phone::before,
	.post .rev_pin ul li.pinpoint::before,
	.post .rev_pin ul li.review::before,
	.classified-short span a,
	body #content .people_info h3 a, h2.entry-title a,
	.classified-price .cls-price-wrapper,
	.sidebar .tmpl_search_classified.widget #tmpl_find_classified h4,
	h1, h2, h3, h4, h5, h6,
	#breadcrumb a, .breadcrumb a,
	#breadcrumb > div, .breadcrumb > div,
	#breadcrumb .trail-end, .breadcrumb .trail-end,
	.singular-classified .classified-price + span.price-type,
	.singular-classified .contact-no,
	.singular-classified .classified_info-right .classified-info p label, 
	.user_dsb_cf > div label, 
	.user_dsb_cf > p label,
	.wordpress .tabs dd > a, 
	.wordpress .tabs .tab-title > a,
	.directory-single-page .hentry .entry-header-title .entry-header-custom-wrap p label, 
	p.custom_header_field label, 
	.listing_custom_field p label,
	.bottom_line a, .byline, 
    .detail-meta li p, .post_info_meta, body .bottom_line, 
    .list .post .entry p.bottom_line, .grid .post .entry p.bottom_line, 
    .list .hentry p.bottom_line, .entry-details p.bottom_line, 
    body #loop_listing_archive .post .entry p.bottom_line, 
    body #loop_listing_taxonomy .post .entry p.bottom_line, 
    body #tmpl-search-results.list .hentry p.bottom_line, .entry-details p.bottom_line,
    .singular-classified .spt-left > ul li,
    .tmpl_classified_seller .tmpl-seller-details p.phone,
    .tmpl_classified_seller .seller-top_wrapper .tmpl-seller-detail-rt p,
    .agent-social-networks a,
    .comment-author cite,
    .comment-meta .published,
    .comment-meta span.comment-reply::after,
    section[id*="classified"].list .entry .classified-price .cls-price-wrapper,
    .widget h3, .widget-search .widget-title, .widget-title, .widget.title,
    .social_media ul li a i
	{ color:<?php echo $color3;?>; }

	body .comment-reply-link, body .comment-reply-login,
	.list .entry .classified-tax-detail > p a:before
	{ color:<?php echo $color3;?> !important; }


	.social_media ul li a i{
		border-color:<?php echo $color3;?>;
	}



<?php }


//Change Background color
if($color4 != "#" || $color4 != ""){?>

	body,
	#main > .wrap.row
	{ background:<?php echo $color4;?>; }

<?php }


$color_data = ob_get_contents();
ob_clean();
if(isset($color_data) && $color_data !=''){
    file_put_contents(trailingslashit(get_template_directory())."css/admin_style.css" , $color_data); 
}
?>
