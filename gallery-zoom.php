<?php
/**
 * FooGallery ZOOM gallery template
 * This is the template that is run when a FooGallery shortcode is rendered to the frontend
 */
//the current FooGallery that is currently being rendered to the frontend
global $current_foogallery;
//the current shortcode args
global $current_foogallery_arguments;
//get our thumbnail sizing args
$args = foogallery_gallery_template_setting( 'thumbnail_size', 'thumbnail' );
//add the link setting to the args

$args['link'] = 'none';

$args['image_attributes'] = array(
	'class'  => 'zoom',
	'height' => $args['height'],
	'width' => $args['width'],
);
$spacing = foogallery_gallery_template_setting( 'spacing', '' );
$viswidth = foogallery_gallery_template_setting( 'viswidth', '200' );
$lenssize = foogallery_gallery_template_setting( 'lenssize', '200' );
$bordersize = foogallery_gallery_template_setting( 'bordersize', '5' );
$bordercolor = foogallery_gallery_template_setting( 'bordercolor', '#333333' );
?>
<style>
img.zoom {max-width: <?php echo $viswidth; ?>px;}
</style>

<div class="foogallery-container foogallery-zoom<?php echo foogallery_build_class_attribute( $current_foogallery, $spacing, $border_style, $alignment); ?>">
	<?php foreach ( $current_foogallery->attachments() as $attachment ) {
		echo '<div class="zoombox">' . $attachment->html( $args ) . '</div>';
	} ?>
</div>

<script type="text/javascript" language="javascript">
		jQuery(document).ready(function ($) {
			$('.zoom').imageLens({
			'lensSize': <?php echo $lenssize?>,
			'borderSize': <?php echo $bordersize?>,
			'borderColor': '<?php echo $bordercolor?>'
			});
		});
</script>