<?php
if(!class_exists('acoc_field_image_upload')):
class acoc_field_image_upload{
	
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
		), $atts );
		
		if($value == ""){ $value = $option['std']; }
		$image_url = ( $value == "" ) ? 'http://placehold.it/350x150' : $value;
		
		echo '<div class="acoc-form-field field-type-text">';
			echo '<label for="'.$option['id'].'">'.$option['label'].'</label><br>';
			echo '<input type="text" id="'.$option['id'].'_field" name="'.$option['id'].'" value="'.$value.'" />';
			echo '<a href="#" id="'.$option['id'].'_button" class="button button-primary">Upload Image</a><br>';
			echo '<img src="'.$image_url.'" id="'.$option['id'].'_image" style="max-width:50%;  margin-bottom:1px; clear:both; flot:left;"><br>';
			echo '<span class="description">'.$option['des'].'</span>';
		echo '</div>';		
		?>
        <script type="text/javascript">
			// Uploading files
			var file_frame_<?php echo $option['id'] ?>;
			jQuery('#<?php echo $option['id'] ?>_button').live('click', function( event ){
				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_frame_<?php echo $option['id'] ?> ) { file_frame_<?php echo $option['id'] ?>.open(); return; }

				// Create the media frame.
				file_frame_<?php echo $option['id'] ?> = wp.media.frames.file_frame_<?php echo $option['id'] ?> = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false  // Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame_<?php echo $option['id'] ?>.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame_<?php echo $option['id'] ?>.state().get('selection').first().toJSON();
		
					// Do something with attachment.id and/or attachment.url here
					jQuery('img#<?php echo $option['id'] ?>_image').attr('src', attachment.url);
					jQuery('input#<?php echo $option['id'] ?>_field').val(attachment.url);
				});

				// Finally, open the modal
				file_frame_<?php echo $option['id'] ?>.open();
			});
		</script>
        <?php
	}
	
	
	function save($field_id){
		$new =  $_POST[$field_id];
		return $new;
	}
	
	function admin_enqueue_scripts(){
		 if(function_exists( 'wp_enqueue_media' )){
			wp_enqueue_media();
		}else{
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
		}
	}
}
endif;