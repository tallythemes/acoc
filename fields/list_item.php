<?php
if(!class_exists('acoc_field_list_item')):
class acoc_field_list_item{
	public $options;
	public $uid;
	
	function __construct(){
		$this->uid = $this->options['id'].'_acoc_list_item_'.rand();
		
		/* AJAX call to create a new list item */
		add_action( 'wp_ajax_add_acoc_field_list_item', array( 'acoc_field_list_item', 'add_acoc_field_list_item' ) );
		//add_action( 'wp_ajax_nopriv_add_acoc_field_list_item', array( $this, 'add_acoc_field_list_item' ) );
	}
	
	
	
	/**
	 * Set the default setttings of all fields
	 */
	function field_default_options($atts){
		$options = array_merge( array(
			'id' => '',
			'class' => '',
			'label' => '',
			'type' => '',
			'std' => '',
			'des' => '',
			'filter' => '', //sanitize_text_field, esc_attr
			'rows' => '4',
		), $atts );
		
		return $options;
	}
	
	
	function html($atts, $value){
		global $post;
		$option = $this->field_default_options($atts);
		$this->options = $option;
		$list_item_items = $value;
		$uid = $option['id'].'_acoc_list_item_'.rand();
		
		print_r($value);
		
		echo '<div class="acoc-form-field field-type-list_item">';
		echo '<label for="'.$option['id'].'"><strong>'.$option['label'].'</strong></label><br><br>';
		echo '<span>'.$option['des'].'</span>';
		
		echo '<ul class="acoc-list_item-items-'.$uid.'" id="'.$option['id'].'">';
			if(is_array($list_item_items) && !empty($list_item_items)){
				foreach( $list_item_items as $list_item_item ){
					
					$slider_title = $list_item_item['title'];
					if($slider_title == ''){ $slider_title = 'Item #'; }
					
					echo '<li>';
						echo '<input type="hidden" value="1" name="'.$option['id'].'-hiden[]" id=""/>';
						
						echo '<div class="row-header-'.$uid.'">';
							echo '<a href="#" class="title-row-'.$uid.' edit-row-'.$uid.' row-title"><strong>Item #</strong></a>';
							echo '<a href="#" class="edit-row-'.$uid.' row-edit" ><div class="dashicons dashicons-edit"></div></a>';
							echo '<a href="#" class="remove-row-'.$uid.' row-delete"><div class="dashicons dashicons-no"></div></a>';
						echo '</div>';
				
						echo '<div class="row-content-'.$uid.'">';
							if(is_array($option['fields']) && !empty($option['fields'])){
								foreach($option['fields'] as $field){
									$field_data_name = $field['id'];
									$field['id'] = $option['id'].'-'.$field['id'].'[]';
									echo '<div class="acoc-setting-item">';
										if($value == ""){ $value = $option['std']; }
										include(ACOC_DRI.'fields/'.$field['type'].'.php');
										$class_name = 'acoc_field_'.$field['type'];
										$field_class = new $class_name;
										$field_class->html($field, $value[$field_data_name ]);
										//$field_class->html($field, '');
									echo '</div>';
								}
							}else{
								echo 'Please add some fields';	
							}
						echo '</div>';
									
					echo '</li>';
				}
			}else{
				echo '<li></li>';
			}
		echo '</ul>';
		echo '<div class="sss"></div>';
		echo '<a href="#" class="add-row-'.$uid.' button button-primary button-large row-addnew">Add New</a>';
		
		
		
		
		
		/*~~~ Javascript ~~~*/
		echo '<script type="text/javascript">';
			echo 'jQuery(document).ready(function( $ ){';
			
				/*~~~ Javascript for the Accordin ~~~*/
				echo "(function($) {
					  var allPanels = $('.row-content-".$uid."').hide();
					  $('.edit-row-".$uid."').click(function() {
						  allPanels.slideUp();
						  if($(this).parent().next().is(':visible')){
							  $(this).parent().next().slideUp();
						  }
						  if(!$(this).parent().next().is(':visible')){
							  $(this).parent().next().slideDown();
						  }
						
						return false;
					  });
					})(jQuery);";
					

				
				/*~~~ Shortable ~~~*/
				echo '$( ".acoc-list_item-items-'.$uid.'" ).sortable({
						  placeholder: "ui-state-highlight"
					  });
					  $( ".acoc-list_item-items-'.$uid.'" ).disableSelection();';
					  
					
			echo '});';
		echo '</script>';
		
		
		echo '</div>';
	}
	
	
	function save($field_id){
		$new = array();
	
		$list_item_hiden =  $_POST[$field_id.'-hiden'];
		$count = count( $list_item_hiden );
							
		for ( $i = 0; $i < $count; $i++ ) {
			$new[$i] =  $this->save_helper($field_id, $i);
		}
		
		return $new;
	}
}
endif;


add_action( 'wp_ajax_add_acoc_field_list_item', 'add_acoc_field_list_item' );
function add_acoc_field_list_item(){
	$uid = $this->uid;
	$option = $this->options;
	//$_REQUEST[];
	echo '<div class="row-header-'.$uid.'">';
		echo '<a href="#" class="title-row-'.$uid.' edit-row-'.$uid.' row-title"><strong>Item #</strong></a>';
		echo '<a href="#" class="edit-row-'.$uid.' row-edit" ><div class="dashicons dashicons-edit"></div></a>';
		echo '<a href="#" class="remove-row-'.$uid.' row-delete"><div class="dashicons dashicons-no"></div></a>';
	echo '</div>';

	echo '<div class="row-content-'.$uid.'">';
		if(is_array($option['fields']) && !empty($option['fields'])){
			foreach($option['fields'] as $field){
				$field['id'] = $option['id'].'-'.$field['id'].'[]';
				echo '<div class="acoc-setting-item">';
					if($value == ""){ $value = $option['std']; }
					$class_name = 'acoc_field_'.$field['type'];
					$field_class = new $class_name;
					//$field_class->html($field, $value[$field['id']]);
					$field_class->html($field, '');
				echo '</div>';
			}
		}else{
			echo 'Please add some fields';	
		}
	echo '</div>';	
	
	die(); // this is required to return a proper result
}