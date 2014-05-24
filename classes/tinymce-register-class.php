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
		echo '<div id="'.$this->uid.'" style="display:none;">';
			echo '<div class="wrap">';
				?>
                <h3><?php echo $this->title; ?></h3>
                <?php
			echo '</div>';
		echo '</div>';
	}
	
}