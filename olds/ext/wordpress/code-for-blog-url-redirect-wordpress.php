<?php

$request_uri	=	str_replace('/','',$_SERVER['REQUEST_URI']);
global $wpdb;
// $query	=	"SELECT post_name,post_status FROM gr_posts WHERE post_status = 'publish' AND post_type = 'post' AND post_name = '{$request_uri}'";
$query	=	"SELECT COUNT(*) FROM gr_posts WHERE post_status = 'publish' AND post_type = 'post' AND post_name = '{$request_uri}'";
$results = $wpdb->get_var( $query );

if($results == 1) {
	wp_redirect( 'http://grhardnesstester.com/blog/' . $request_uri, 301 );
	exit;
}
?>