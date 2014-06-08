<?php
if(!class_exists('acoc_field_slideshow2')):
class acoc_field_slideshow2{
	public $option;
	
	function __construct(){
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
		add_action( 'admin_footer', array($this, 'the_javascript') );
	}
	
	/**
	 * All global Javascript
	 */
	function the_javascript(){
		?>
        <script type="text/javascript">
		jQuery(document).ready(function($){
			$('.acoc-slideshow2-color-field').wpColorPicker();
		});
		</script>
        <?php
	}
	
	
	
	function admin_enqueue_scripts(){
		 wp_enqueue_style( 'wp-color-picker' );
		 wp_enqueue_style( 'jquery-ui-core' );
		 wp_enqueue_style( 'jquery-ui-widget' );
		 wp_enqueue_style( 'jquery-ui-mouse' );
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
		$slideshow2_items = $value;
		$uid = $option['id'].'_acoc_slideshow2_'.rand();
		
		echo '<div class="acoc-form-field field-type-slideshow2">';
		echo '<label for="'.$option['id'].'"><strong>'.$option['label'].'</strong></label><br><br>';
		echo '<span>'.$option['des'].'</span>';
		
		echo '<ul class="acoc-slideshow2-items-'.$uid.'" id="'.$option['id'].'">';
			if(is_array($slideshow2_items) && !empty($slideshow2_items)){
				$i = 0;
				
				foreach( $slideshow2_items as $slideshow2_item ){
					$slider_title = $slideshow2_item['title'];
					if($slider_title == ''){ $slider_title = 'Section title'; }
					
					echo '<li>';
						echo '<input type="hidden" value="1" name="'.$option['id'].'-hiden[]" id=""/>';		
						acoc_fields_list_view($option['id'], $i, $uid, $option['fields'], $slideshow2_item);			
					echo '</li>';
					$i++;
				}
			}else{
				echo '<li></li>';
			}
		echo '</ul>';
		echo '<a href="#" class="add-row-'.$uid.' button button-primary button-large row-addnew">Add New</a>';
		
		
		/*~~~ empty row for being clone ~~~*/
		echo '<li class="empty-row-'.$uid.'" style="display:none" >';
			echo '<input type="hidden" value="1" name="" id=""/>';
			acoc_fields_list_view($option['id'], 0, $uid, $option['fields'], NULL );				
		echo '</li>';
		
		acoc_fields_list_view_javascript($uid, $option['id']);		
		echo '</div>';
	}
	
	
	function save($field_id){
		$new = array();
	
		$slideshow2_hiden =  $_POST[$field_id.'-hiden'];
		$slideshow2_title =  $_POST[$field_id.'-title'];
		$slideshow2_subtitle =  $_POST[$field_id.'-titles'];
							
		$count = count( $slideshow2_hiden );
							
		for ( $i = 0; $i < $count; $i++ ) {
			$new[$i]['title'] = $slideshow2_title[$i];
			$new[$i]['titles'] = $slideshow2_subtitle[$i];
		}
		
		return $new;
	}
}
endif;