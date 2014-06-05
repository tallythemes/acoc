<?php
if(!class_exists('acoc_field_select')):
class acoc_field_select{
		
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
			'options' => array()
		), $atts );
		
		if($value == ""){ $value = $option['std']; }
		
		echo '<div class="acoc-form-field field-type-select">';
			echo '<label for="'.$option['id'].'">'.$option['label'].'</label><br>';
			echo '<select id="'.$option['id'].'" name="'.$option['id'].'">';
				if(is_array($option['options']) && !empty($option['options'])){
					foreach($option['options'] as $items ){
						echo '<option value="'.$items['value'].'" '.selected( $value, $items['value'], false ).'>'.$items['label'].'</option>';
					}
				}
			echo '</select>';
			echo '<br><span class="description">'.$option['des'].'</span>';
		echo '</div>';
	}
	
	
	function save($field_id){
		$new =  $_POST[$field_id];
		return $new;
	}
}
endif;