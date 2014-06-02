<?php
if(!class_exists('acoc_field_heading')):
class acoc_field_heading{
		
	function html($atts, $value){
		global $post;
		$option = array_merge( array(
			'id' => '',
			'class' => '',
			'label' => '',
			'type' => '',
			'std' => '',
			'des' => '',
			'filter' => '', //sanitize_text_field, esc_attr
		), $atts );
		
		if($value == ""){ $value = $option['std']; }
		
		echo '<div class="acoc-form-field field-type-heading">';
			if($option['label'] !== ''){ echo '<p class="field-heading">'.$option['label'].'</p>'; }
			if($option['des'] !== ''){ echo '<p>'.$option['des'].'</p>'; }
			echo '<hr />';
		echo '</div>';
	}
	
	
	function save($field_id){
		
	}
}
endif;