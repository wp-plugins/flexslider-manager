<?php
/*
Plugin Name: Flexslider Manager
Plugin URI: http://bloggingsquared.com
Description: Add a hero slideshow to any sidebar and display it with Tyler Smith's responsive <a href="http://flex.madebymufffin.com/" title="Learn more about Flexslider">Flexslider</a>. To use this plugin you must first download and activate the <a href="http://wordpress.org/extend/plugins/space-manager/" title="Download Space Manager">Space Manager</a> plugin.
Version: 1.0
Author: dan.imbrogno
Author URI: http://bloggingsquared.com
Tags: Responsive, Slider, Widget

Copyright 2008  DAN_IMBROGNO  (email : dan.imbrogno@brolly.ca)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__, 'flexslider_manager_check_deps');

function flexslider_manager_check_deps($wp_die = false)
{
	
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
 
	if (!is_plugin_active('space-manager/index.php') )
	{
	
		deactivate_plugins(__FILE__);
		
		if(false == $wp_die)
		{
	    	exit('To use this plugin you must first download and activate the <a href="http://wordpress.org/extend/plugins/space-manager/" title=""Download Space Manager">Space Manager</a> plugin.');
		}
		else
		{
			
			wp_die('Flexslider Manager was deactivated because the Space Manager plugin is missing or deactivated. <a href="'.admin_url('plugins.php').'">Go Back.</a>');
			
		}
		
	}
	  
}

add_action('init', 'flexslider_init', 1);

function flexslider_init()
{
	global $myFlexsliderManager;
	
	flexslider_manager_check_deps(true);
	  
	require_once('flexslider-manager.php');
	
	require_once('flexslider-manager-widget.php');
	
	$myFlexsliderManager = new FlexsliderManager();
	
}

?>