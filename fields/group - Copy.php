<?php
if(!class_exists('acoc_field_group')):
class acoc_field_group{
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
			$('.acoc-group-color-field').wpColorPicker();
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
		$group_items = $value;
		$uid = $option['id'].'_acoc_group_'.rand();
		
		echo '<div class="acoc-form-field field-type-group">';
		echo '<label for="'.$option['id'].'"><strong>'.$option['label'].'</strong></label><br>';
		echo '<span>'.$option['des'].'</span>';
		
		echo '<ul class="acoc-group-items-'.$uid.'" id="'.$option['id'].'">';
			if(is_array($group_items) && !empty($group_items)){ $i=0;
				foreach( $group_items as $group_item ){ 
					echo '<li>';
						echo '<input type="hidden" value="1" name="'.$option['id'].'-hiden[]" id=""/>';		
						$this->list_view($option['id'], $i, $uid, $option['fields'], $group_item);			
					echo '</li>'; $i++;
				}
			}else{
				echo '<li></li>';
			}
		echo '</ul>';
		echo '<a href="#" class="add-row-'.$uid.' button button-primary button-large row-addnew">Add New</a>';
		
		/*~~~ empty row for being clone ~~~*/
		echo '<li class="empty-row-'.$uid.'" style="display:none" >';
			echo '<input type="hidden" value="1" name="" id=""/>';
			$this->list_view($option['id'], 0, $uid, $option['fields'], NULL );				
		echo '</li>';
		
		$this->list_view_javascript($uid, $option['id']);		
		echo '</div>';
	}
	
	
	function save($field_id){
		$new = array();
	
		$group_hiden =  $_POST[$field_id.'-hiden'];
		$group_title =  $_POST[$field_id.'-title'];
		$group_subtitle =  $_POST[$field_id.'-titles'];
							
		$count = count( $group_hiden );
							
		for ( $i = 0; $i < $count; $i++ ) {
			$new[$i]['title'] = $group_title[$i];
			$new[$i]['titles'] = $group_subtitle[$i];
		}
		
		return $new;
	}
	
	function list_view($name, $key = 0, $uid, $fields, $value = NULL , $class = NULL){
		?>
		<div class="acoc-list-item acoc-list-item-<?php echo $uid; ?>">
			<div class="acoc-list-item-header">
				<a href="" class="acoc-row-title acoc-edit-row-<?php echo $uid; ?>" id="acoc-row-title-<?php echo $uid; ?>">Item #1</a>
				<a href="" class="acoc-delete-row-<?php echo $uid; ?>" id="acoc-delete-row-<?php echo $uid; ?>"><div class="dashicons dashicons-no"></div></a>
				<a href="" class="acoc-edit-row-<?php echo $uid; ?>" id="acoc-edit-row-<?php echo $uid; ?>"><div class="dashicons dashicons-edit"></div></a>
			</div>
			
			<div class="acoc-list-item-content">
				<?php if(is_array($fields) && !empty($fields)): ?>
					<?php foreach($fields as $field): ?>
						<?php
						$field_id = $field['id'];
						$field['id'] = $name.'-'.$field['id'].'[]';
						$class_name = 'acoc_field_'.$field['type'];
						$field_class = new $class_name;
						$field_class->html($field, $value[$field_id ]);
						?>
					<?php endforeach; ?>
				<?php else: ?>
					Please ADD some fileds
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
	function list_view_javascript($uid, $option_id){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function( $ ){
				(function($) {
					var allPanels = $('.acoc-list-item-<?php echo $uid; ?> .acoc-list-item-content').hide();
						$('.acoc-edit-row-<?php echo $uid; ?>').click(function() {
							allPanels.slideUp();
							if($(this).parent().next().is(':visible')){
								$(this).parent().next().slideUp();
							}
							if(!$(this).parent().next().is(':visible')){
								$(this).parent().next().slideDown();
							}
						return false;
					});
				})(jQuery);
				
				$('.acoc-delete-row-<?php echo $uid; ?>').on('click', function() {
					var isGood=confirm('Are you sure, you want to remove this?');
					if (isGood) {
						$(this).parents('li').remove();
					}
					return false;
				})
				
				$( '.add-row-<?php echo $uid; ?>' ).on('click', function() {
					var row = $( '.empty-row-<?php echo $uid; ?>' ).clone(true);
					row.css( 'display', 'block' );
					row.removeClass( 'empty-row-<?php echo $uid; ?>' );
					row.find( 'input[type=\"hidden\"]' ).attr('name', '<?php echo $option_id; ?>-hiden[]');
					row.insertAfter( '.acoc-group-items-<?php echo $uid; ?> li:last' );
					return false;
				});
				
				$( ".acoc-group-items-<?php echo $uid; ?>" ).sortable({
					placeholder: "ui-state-highlight"
				});
				$( ".acoc-group-items-<?php echo $uid; ?>" ).disableSelection();
			});
		</script>
		<?php
	}
}
endif;