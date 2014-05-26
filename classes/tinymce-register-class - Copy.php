<?php
//http://jonsaverda.com/2014/03/add-shortcode-add-media-button/
class acoc_tinymce_register {
	
	public $options;
	public $title;
	public $button_url;
	public $button_title;
	public $uid;

	function __construct(){
		$this->uid = 'sample512';
		$this->button_title = '[ ]';
		$this->title = 'Insert Shortcodes';
		
		global $pagenow;
		if ( in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			add_action( 'media_buttons', array( $this, 'media_buttons' ), 20 );
			add_action( 'admin_footer', array( $this, 'popup_html' ) );
		}
	}
	
	
	function media_buttons( $editor_id = 'content' ) {

		$output = '<a href="#TB_inline?width=4000&amp;inlineId='.$this->uid.'" class="thickbox button" title="' . $this->title . '">' . $this->button_title . '</a>';
		
		echo $output;
	}
	
	
	function popup_html(){
		$this->javascript();
		echo '<div id="'.$this->uid.'" style="display:none;">';
			echo '<div class="wrap">';
				//echo '<h3>'.$this->title.'</h3>';
				$this->html();
			echo '</div>';
		echo '</div>';
	}
	
	function javascript(){
		?>
        <script type="text/javascript">
			jQuery(document).ready(function($){
				$("#<?php echo $this->uid; ?> h3.acoc_tinymce_toggle_trigger").click(function(){$(this).toggleClass("active").next().slideToggle("fast");return false;});
				
				<?php if(is_array($this->options)): ?>
					<?php foreach($this->options as $options): ?>
						<?php $uid = $this->uid.'_'.$options['shortcode']; ?>
						function acoc_tinymce_<?php echo $uid; ?>_insert(){
							<?php if(is_array($options['fields'])): ?>
								<?php foreach($options['fields'] as $field): ?>
									var js_link_href = $("#form_href").val();
								<?php endforeach ?>
							<?php endif; ?>
							
							<?php if(): ?>
								
							<?php else: ?>
								window.send_to_editor("[" + form_shortcode + "]");
							<?php endif; ?>
						}
					<?php endforeach ?>
				<?php endif; ?>
			});
		</script>
        <?php
	}
	
	function html(){
		if(is_array($this->options)){
			foreach($this->options as $options){
				
				$uid = $this->uid.'_'.$options['shortcode'];
				 
				echo '<div class="acoc_tinymce_shortcode_holder">';
					echo '<h3 class="acoc_tinymce_toggle_trigger">'. $options['title'] .'</h3>';
					echo '<div class="acoc_tinymce_shortcode_fields">';
						if(is_array($options['fields'])){
							foreach($options['fields'] as $field){
								$value = $field['std'];
								include(ACOC_DRI.'fields/'.$field['type'].'.php');
								$class_name = 'acoc_field_'.$field['type'];
								$field_class = new $class_name;
								$field_class->html($field, $value);
							}
						}
						?>
                        <div >
                            <input type="button" class="button-primary" value="<?php _e('insert', 'acoc_textdomain'); ?>" onclick="acoc_tinymce_<?php echo $uid; ?>_insert();"/>
                            &nbsp;&nbsp;&nbsp;
                            <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "acoc_textdomain"); ?></a>
                        </div>
                        <?php
					echo '</div>';
				echo '</div>';
			}
		}
	}
	
}

$tinymce = new acoc_tinymce_register;
$options = array();
$options[] = array(
	'title' => 'Button',
	'shortcode' => 'button',
	'content' => 'no',//yes, no
	'fields' => array(
		array(
			'id' => 'kala',
			'class' => '',
			'label' => 'Okala',
			'type' => 'text',
			'std' => '512',
			'des' => 'Welcome to Fields for Jewellery',
			'filter' => '', //sanitize_text_field, esc_attr
		),
		array(
			'id' => 'okk',
			'class' => '',
			'label' => 'Okala',
			'type' => 'textarea',
			'std' => '300',
			'des' => 'Welcome to Fields for Jewellery',
			'filter' => '', //sanitize_text_field, esc_attr
		),
	)
);

$tinymce->options = $options;