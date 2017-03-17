<?php
	//echo 'testing';die();
	//error_reporting(E_ALL);
	//ini_set('error_reporting', E_ALL);
	/* $handle	=	fopen("img_sku/sku.csv"));
	$csv		=	fgetcsv($handle);

	echo '<pre>' . print_r($csv,true) . '</pre>'; */
	$file = fopen('img_sku/sku.csv', 'r');
	$x=0;
	while (($line = fgetcsv($file)) !== FALSE) {
	//$line is an array of the csv elements
		//echo '<pre>' . print_r($line,true) . '</pre>';
			$sku	=	$line[0];
			$files = glob( 'media/import/' . $sku . '*.jpg' );
			
			//$found	=	$files[0];
			
			//rename ( $found, 'media/import/' . $sku . '.jpg' );
			
			print_r($files);
	}
	fclose($file);
	
	
	
	/* $files = scandir('media/import');
	
	echo '<pre>' . print_r($files,true) . '</pre>'; */
	

?>