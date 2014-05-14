<?php
if(!class_exists('acoc_flexslider2_html')):

class acoc_flexslider2_html{
	
	public $uid;
	public $display;
	
	/*-script settings-*/
	public $animation;
	public $direction;
	public $smoothHeight;
	public $slideshow;
	public $animationLoop;
	public $slideshowSpeed;
	public $animationSpeed;
	public $controlNav;
	public $directionNav;
	public $prevText;
	public $nextText;
	public $pausePlay;
	public $pauseText;
	public $playText;
	public $move;
	
	public $itemWidth;
	public $itemMargin;
	public $minItems;
	public $maxItems;
	
	
	/**
	* Get started
	* @since  1.0
	*/
	function __construct($data, $additional_data = NULL){
		$default = array(			
			'display' => true,
			
			'animation' => 'slide',
			'direction' => 'horizontal',
			'smoothHeight' => 'false',
			'slideshow' => 'true',
			'animationLoop' => 'true',
			'slideshowSpeed' => '7000',
			'animationSpeed' => '600',
			'controlNav' => 'true',
			'directionNav' => 'true',
			'prevText' => 'Previous',
			'nextText' => 'Next',
			'pausePlay' => 'false',
			'pauseText' => 'Pause',
			'playText' => 'Play',
			'itemWidth' => '0',
			'itemMargin' => '0',
			'minItems' => '0',
			'maxItems' => '0',
			'move' => '0',
		);
		$data = array_merge($default, $data);
		
		$this->display = $data['display'];
		$this->uid = 'acoc-flexslider2-uid-'.rand();
		
		$this->animation = $data['animation'];
		$this->direction = $data['direction'];
		$this->smoothHeight = $data['smoothHeight'];
		$this->slideshow = $data['slideshow'];
		$this->animationLoop = $data['animationLoop'];
		$this->slideshowSpeed = $data['slideshowSpeed'];
		$this->animationSpeed = $data['animationSpeed'];
		$this->controlNav = $data['controlNav'];
		$this->directionNav = $data['directionNav'];
		$this->prevText = $data['prevText'];
		$this->nextText = $data['nextText'];
		$this->pausePlay = $data['pausePlay'];
		$this->pauseText = $data['pauseText'];
		$this->playText = $data['playText'];
		$this->itemWidth = $data['itemWidth'];
		$this->itemMargin = $data['itemMargin'];
		$this->minItems = $data['minItems'];
		$this->maxItems = $data['maxItems'];
		$this->move = $data['move'];
	}
	
	
	
	function start(){
		$output = '';
		$output .= '<style type="text/css">';
			if(($this->itemWidth != '0') && ($this->itemMargin != '0')) { 
				$output .= '#'.$this->uid.' .wfs-viewport ul.slides{ margin-left: -'.$this->itemMargin.'px;  }'; 
				$output .= '#'.$this->uid.' .wfs-viewport ul.slides li{ margin-left: '.$this->itemMargin.'px; }';
			}
		$output .= '</style>';
		$output .= '<div class="acoc-flexslider-clear"></div>';
		$output .= '<div class="acoc-flexslider2" id="'.$this->uid.'">';
			$output .= '<ul class="slides">';
		
		if($this->display == false){ return $output; }else{  echo $output; }
	}
	
		function in_loop_start(){
			$output = '';
			$output .= '<li>';
			if($this->display == false){ return $output; }else{  echo $output; }
		}
		
		
		function in_loop_end(){
			$output = '';
			$output .= '</li>';
			if($this->display == false){ return $output; }else{  echo $output; }
		}
	
	
	function end(){
		$output = '';
			$output .= '</ul>';
		$output .= '</div>';
		$output .= '<div class="acoc-flexslider-clear"></div>';
		$output .= '<script type="text/javascript">';
			$output .= 'jQuery(document).ready(function($){';
				$output .= "$('#".$this->uid."').flexslider({
						animation: '".$this->animation."',
						namespace: 'wfs-',
						direction: '".$this->direction."',
						smoothHeight: ".$this->smoothHeight.",
						slideshow: ".$this->slideshow.",
						animationLoop: ".$this->animationLoop.",
						slideshowSpeed: ".$this->slideshowSpeed.",
						animationSpeed: ".$this->animationSpeed.",
						controlNav: ".$this->controlNav.",
						
						directionNav: ".$this->directionNav.",
						prevText: '".$this->prevText."',
						nextText: '".$this->nextText."',
						
						pausePlay: ".$this->pausePlay.",
						pauseText: '".$this->pauseText."',
						playText: '".$this->playText."',
						
						itemWidth: ".$this->itemWidth.",
						itemMargin: ".$this->itemMargin.",
						minItems: ".$this->minItems.",
						maxItems: ".$this->maxItems.",
						move: ".$this->move.",
					});";
			$output .= '});';
		$output .= '</script>';
		
		if($this->display == false){ return $output; }else{  echo $output; }
	}

}

endif;