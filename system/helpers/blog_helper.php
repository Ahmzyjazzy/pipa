<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function catch_that_image($str){
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',$str, $matches);
	
	@$first_img = $matches[1][0];
	
	if(empty($first_img)){
		
		//try again
		$output = preg_match_all('/<input.+src=[\'"]([^\'"]+)[\'"].*>/i',$str, $matches);
	
		@$first_img = $matches[1][0];
		
		if(empty($first_img)){
			
			return $first_img = base_url()."uploads/images/no_picture.png";
		
		}else{
		
			return $first_img;
			
		}
		
	}else{
		
		return $first_img;
	}
}

		
function replace_that_image($str){
	
	$first_img 		= 	'';
	
	ob_start();
	ob_end_clean();
	
	// remove all the images in the article
	$output 		= 	preg_replace('/<img[^>]+\>/i', '', $str);
	$output 		= 	preg_replace('/<input[^>]+\>/i', '', $str);
	//return $output;
	
	// remove all the h1 to h6 with their values
	$html 			= 	preg_replace('/<h[1-6](.*?)<\/h[1-6]>/si', '', $output);
	
	return $html;
}
