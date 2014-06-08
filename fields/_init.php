<?php
function acoc_fields_list_view($name, $key = 0, $uid, $fields, $value = NULL , $class = NULL){
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
function acoc_fields_list_view_javascript($uid, $option_id){
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
				row.insertAfter( '.acoc-slideshow2-items-<?php echo $uid; ?> li:last' );
				return false;
			});
			
			$( ".acoc-slideshow2-items-<?php echo $uid; ?>" ).sortable({
				placeholder: "ui-state-highlight"
			});
			$( ".acoc-slideshow2-items-<?php echo $uid; ?>" ).disableSelection();
		});
	</script>
    <?php
}

include(ACOC_DRI.'fields/checkbox.php');
include(ACOC_DRI.'fields/heading.php');
include(ACOC_DRI.'fields/image_upload.php');
//include(ACOC_DRI.'fields/list_item.php');
include(ACOC_DRI.'fields/parallax.php');
include(ACOC_DRI.'fields/post_multi_select.php');
include(ACOC_DRI.'fields/post_select.php');
include(ACOC_DRI.'fields/select.php');
include(ACOC_DRI.'fields/slideshow.php');
include(ACOC_DRI.'fields/slideshow2.php');
include(ACOC_DRI.'fields/taxonomy_multi_select.php');
include(ACOC_DRI.'fields/taxonomy_select.php');
include(ACOC_DRI.'fields/text.php');
include(ACOC_DRI.'fields/textarea.php');