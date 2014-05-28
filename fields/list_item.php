<?php
if(!class_exists('acoc_field_list_item')):
class acoc_field_list_item{
	
	function __construct(){
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
	}
		
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
			'settings' => array(),
		), $atts );
		
		if($value == ""){ $value = $option['std']; }
		$uid = $option['id'];
		
		echo '<div class="acoc-form-field field-type-list_item">';
			
			if(is_array($option['settings'])):
				
				echo '<label for="'.$option['id'].'">'.$option['label'].'</label><br>';
				echo '<span class="description">'.$option['des'].'</span>';
				
				$i = 0;
				foreach($option['settings'] as $item):
				
					echo '<div class="list-row">';
						echo '<input type="hidden" value="1" name="'.$option['id'].'-hiden[]" id=""/>';
						echo '<div class="list-heading">';
							echo '<a href="#" class="row-list-title title-row-'.$uid.' edit-row-'.$uid.'"><strong>Slider Title</strong></a>';
							echo '<a href="#" class="row-list-edit edit-row-'.$uid.'"><div class="dashicons dashicons-edit"></div></a>';
							echo '<a href="#" class="row-list-remove remove-row-'.$uid.'"><div class="dashicons dashicons-no"></div></a>';
						echo '</div>';
						
						echo '<div class="list-content">';
							echo '<label><strong>Title</strong></label>';
							echo '<input type="text" value="Slider Title" name="'.$option['id'].'-title[]" />';
							
							$all_value = $value;
							$the_value = $all_value[$i][$item['id']];
							include(ACOC_DRI.'fields/'.$item['type'].'.php');
							$class_name = 'acoc_field_'.$item['type'];
							$field_class = new $class_name;
							$field_class->html($item, $the_value);
							
						echo '</div>';
					echo '</div>';
					$i++;
				endforeach;
				
				echo '<a href="#" class="add-row-'.$uid.' button button-primary button-large">Add New</a>';
			endif;
			
		echo '</div>';
	}
	
	
	function save($field_id){
		$new =  $_POST[$field_id];
		return $new;
	}
	
	function admin_enqueue_scripts(){
		 wp_enqueue_style( 'jquery-ui-core' );
		 wp_enqueue_style( 'jquery-ui-widget' );
		 wp_enqueue_style( 'jquery-ui-mouse' );
	}
}
endif;