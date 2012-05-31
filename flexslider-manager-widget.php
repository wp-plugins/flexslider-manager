<?php

if(!class_exists('FlexsliderWidget'))
{
	
	class FlexsliderWidget extends SpaceManagerWidget {
		
		const STR_MAX_WIDTH = 'max_width';
		
		public function __construct() {

			global $myFlexsliderManager;
			parent::__construct($myFlexsliderManager);
			
		}
		
		public function ns(){
			
			return 'flexslider_widget';
			
		}
		
		public function strings()
		{
			return array(
				self::STR_DESCRIPTION => __('Displays the flexsliders setup using the slide manager.', $this->ns()),
				self::STR_NAME => __('Flexslider Widget', $this->ns()),
				self::STR_DEFAULT_TITLE => '',
				self::STR_NO_SPACE_ZONES => __('No flexsliders have been set up. %sGo to the slide manager configuration page%s and create a zone.',$this->ns()),
				self::STR_SETUP_SPACES => __('Setup slides using the %sflexslider manager%s configuration page.',$this->ns()),
				self::STR_TITLE => __('Title',$this->ns()),
				self::STR_ZONE => __('Zone',$this->ns()),
				self::STR_NUM_TO_SHOW => __('Number of slides to show (-1 for unlimited):', $this->ns()),
				self::STR_SHOW_RANDOM => __('Select slides at random', $this->ns()),
				self::STR_SHOW_SPACE_NAME => __('Show slide name', $this->ns()),
				self::STR_MAX_WIDTH => __('Max Width', $this->ns())
			);
		}
		
		public function update($new_instance, $old_instance) {
			
			$max_width = intval($new_instance['max_width']);
			
			if(0 == $max_width) $max_width = $old_instance['max_width'];
			
			$instance = parent::update($new_instance, $old_instance);
			
			$instance['max_width'] = $max_width;
			
			return $instance;
			
		}


		public function form($instance) {
			
			parent::form($instance);
			
			$instance = wp_parse_args( 
				(array)$instance, 
				array(
					'max_width'=>$this->defaultMaxWidth()
				)
			);
			
			$max_width = esc_attr($instance['max_width']);
			
			require('html/widget_form.php');
			
		}
		
		public function widget( $args=false, $instance=false ) {
		
			$this->manager->setMaxWidth($instance['max_width']);
			
			parent::widget($args, $instance);
			
		}
		
		public function defaultMaxWidth()
		{
			return apply_filters($this->prefix().'default_max_width', 900);
		}
		
	}

}

?>