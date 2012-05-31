<?php

if(!class_exists('FlexsliderManager'))
{

	class FlexsliderManager extends SpaceManager
	{
		
		private $max_width = false;
		
		public function __construct()
		{
			
			add_action('wp_enqueue_scripts', array($this,'addStylesheet'));

			parent::__construct();
			
		}
		
		public function ns()
		{
			return 'flexslider_manager';
		}
		
		public function spacesKey()
		{
			return 'slides';
		}
		
		public function strings()
		{
			
			return array(
				self::STR_SPACES_ZONE_DELETED => __('The flexslider this slide belongs to has been deleted.',$this->ns()),
				self::STR_SPACE_ZONE_NAME_EMPTY => __('The flexslider name must not be empty.',$this->ns()),
				self::STR_SPACE_ZONE_MISSING => __('The flexslider is missing or has been deleted.',$this->ns()),
				self::STR_INVALID_POST => __('There was a problem with the form submission, please try again.',$this->ns()),
				self::STR_SPACE_NAME_EMPTY => __('The name of the slide cannot be empty.',$this->ns()),
				self::STR_SPACE_MISSING => __('This slide is missing or has been deleted.',$this->ns()),
				self::STR_OPTION_UPDATE_FAILED => __('An error occurred while trying to save, please try again.',$this->ns()),
				self::STR_SPACE_ZONE_ADDED => __('The flexslider has been created.', $this->ns()),
				self::STR_SPACE_ZONE_DELETED => __('The flexslider has been deleted.',$this->ns()),
				self::STR_SPACE_ADDED => __('The slide has been created.',$this->ns()),
				self::STR_SPACE_UPDATED => __('The slide has been updated.',$this->ns()),
				self::STR_EDIT_ZONES => __('Edit Flexsliders', $this->ns()),
				self::STR_EXPLAIN_ZONES => __('Flexsliders are groups of slides. Once you have created a flexslider you can choose to display all the slides inside that flexslider or a random number of slides in that flexslider. To show a flexslider on your website simply %sadd a widget%s to your sidebar.', $this->ns()),
				self::STR_ZONE_NAME => __('Flexslider Name', $this->ns()),
				self::STR_NUM_SPACES => __('Number of Ads', $this->ns()),
				self::STR_NEW_SPACE => __('New Ad', $this->ns()),
				self::STR_EDIT_SPACES => __('Edit Ads', $this->ns()),
				self::STR_DELETE_ZONE => __('Delete Flexslider', $this->ns()),
				self::STR_NEW_ZONE => __('Add a New Flexslider', $this->ns()),
				self::STR_SAVE => __('Save', $this->ns()),
				self::STR_EDITING_SPACES_IN => __('Editing Ads in %s', $this->ns()),
				self::STR_RETURN_TO_ZONES => __('Return to galleries', $this->ns()),
				self::STR_SPACE_NAME => __('Ad Name', $this->ns()),
				self::STR_EDIT_SPACE => __('Edit Ad', $this->ns()),
				self::STR_DELETE_SPACE => __('Delete Ad', $this->ns()),
				self::STR_ZONE_EMPTY => __('This flexslider currently has no slides. Click "New Ad" below to create one.', $this->ns()),
				self::STR_RETURN_TO_ADS_IN_ZONE => __('Return to slides in flexslider: %s', $this->ns()),
				self::STR_ADD_TITLE_AND_CONTENT => __('Add the title and content for the slide.', $this->ns()),
				self::STR_TITLE => __('Title', $this->ns()),
				self::STR_MENU_NAME => __('Flexslider Manager', $this->ns()),
				self::STR_PAGE_NAME => __('Flexslider Manager', $this->ns()),
			);
		
		}
		
		public function beforeZone()
		{
		
			$style = '';
			
			if(false != $this->getMaxWidth())
			{
				$style = ' style="max-width:'.$this->getMaxWidth().'px" ';
			}
			
			return '<div class="flexslider"'.$style.'><ul class="slides">';
			
		}
		
		public function afterZone()
		{
			return '</ul></div>';
		}
		
		public function beforeSpace()
		{
			return '<li>';
		}
		
		public function afterSpace()
		{
			return '</li>';
		}
		
		public function getSpaceContentHtml($space)
		{
			
			$output = '';
			
			$output = stripslashes($space[$this->contentKey()]);
				
			// Remove the title caption
			$output = preg_replace('/title=\"(.*?)\"/','',$output);		
			
			// Remove the width
			$output = preg_replace('/width=\"(.*?)\"/','',$output);	
			
			// Remove the height
			$output = preg_replace('/height=\"(.*?)\"/','',$output);
			
			$output = strip_tags($output, '<img>');
			
			return apply_filters($this->prefix().'space_content', $output, $space);
			
		}
		
		public function widgetClass()
		{
			return 'FlexsliderWidget';
		}
		
		public function getZoneHTML($zone_id = 0, $random = true, $num = -1, $space_name = false)
		{
		
			wp_register_script('flexslider', plugins_url('js/jquery.flexslider-min.js', __FILE__), array('jquery'), 1.8, true);
			
			wp_enqueue_script('flexslider-init', plugins_url('js/flexslider-init.js', __FILE__), array('jquery', 'flexslider'), 1, true);
			
			echo '
			<script type="text/javascript">
				var flexslider_options = '.self::getFlexSliderOptions().';
			</script>
			';
			
			return parent::getZoneHTML($zone_id, $random, $num, $space_name);
			
		}
		
		public function addStylesheet()
		{
			wp_enqueue_style('flexslider', plugins_url('css/flexslider.css', __FILE__));
		}
		
		public function setMaxWidth($max_width)
		{
			$this->max_width = $max_width;
		}
		
		public function getMaxWidth()
		{
			return $this->max_width;
		}
		
		public function getFlexSliderOptions()
		{
			return apply_filters(
				$this->prefix().'flexslider_options', '{}');
		}	
	}

}
?>