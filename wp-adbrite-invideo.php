<?php
/*
Plugin Name: WP Invideo
Plugin URI: http://imvain.com/programming/wordpress-plugin-wpinvideo/
Description: WP Adbrite Invideo makes implementing adbrite invideo's easy and hassle free
Author: Ryan Zimmerman
Version: 0.5
Author URI: http://imvain.com
*/

function wpinvideo($content){
	$wpinvideooutput = $content;
	$pattern = "/\[wpinvideo (.+?)\]/ise";
	preg_match_all($pattern, $wpinvideooutput,$matches);
	$invideocntr=0;
	$wpinvideostr="";
	foreach($matches as $invideovar){
		$invideostr = str_replace("[wpinvideo ","",$invideovar[$invideocntr]);
		$invideostr = str_replace("]","",$invideostr);
		$invideotemparry = explode(",",$invideostr);
		if(sizeof($invideotemparry)==3){
			$adbrite_video_id = $invideotemparry[0];
			$adbrite_video_width = $invideotemparry[1];
			$adbrite_video_height = $invideotemparry[2];
			$wpinvideostr .= "<span style=\"display:block;float:center;\">";
			$wpinvideostr .= "<!-- Begin AdBrite Video Code -->";
			$wpinvideostr .= "<script src=\"http://files.adbrite.com/player/js/abplayerlib.js\" language=\"javascript\"></script>";
			$wpinvideostr .= "<script language=\"javascript\">";
			$wpinvideostr .= "abWritePlayer($adbrite_video_id, $adbrite_video_width, $adbrite_video_height, \"http://vid.adbrite.com/video/abplayer?\");";
			$wpinvideostr .= "</script>";
			$wpinvideostr .= "<noscript>";
			$wpinvideostr .= "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"$adbrite_video_width\" height=\"$adbrite_video_height\" id=\"abPlayerObj\" align=\"middle\"><param name=\"movie\" value=\"http://vid.adbrite.com/video/abplayer.swf?&vid=$adbrite_video_id&og=1\" /><param name=\"quality\" value=\"best\" /><embed src=\"http://vid.adbrite.com/video/abplayer.swf?&vid=$adbrite_video_id&og=1\" quality=\"best\" width=\"$adbrite_video_width\" height=\"$adbrite_video_height\" name=\"abPlayerObj\" align=\"middle\" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed></object>";
			$wpinvideostr .= "</noscript>";
			$wpinvideostr .= "<!-- End AdBrite Video Code -->";
			$wpinvideostr .= "</span>";
		}
		$invideocntr+=1;
	}
	$wpinvideooutput = preg_replace($pattern, "", $wpinvideooutput);
	return $wpinvideostr . $wpinvideooutput;
}

add_filter('the_content','wpinvideo');
?>