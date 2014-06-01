<?php
if(!class_exists('acoc_field_taxonomy_select')):
class acoc_field_taxonomy_select{
		
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
			'taxonomy' => 'category'
		), $atts );
		
		if($value == ""){ $value = $option['std']; }
		
		$terms = get_terms($option['taxonomy']);
		
		echo '<div class="acoc-form-field field-type-taxonomy_select">';
			echo '<label for="'.$option['id'].'">'.$option['label'].'</label><br>';
			echo '<select id="'.$option['id'].'" name="'.$option['id'].'">';
			
				if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					foreach($terms as $term ){
						echo '<option value="'.$term->term_id.'" '.selected( $value, $term->term_id, false ).'>'.$term->name.'</option>';
					}
				}
				
			echo '</select>';
			echo '<br><span>'.$option['des'].'</span>';
		echo '</div>';
	}
	
	
	function save($field_id){
		$new =  $_POST[$field_id];
		return $new;
	}
}
endif;