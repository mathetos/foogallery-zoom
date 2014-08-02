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
	'class'  => 'small',
	'height' => $args['height'],
	'width' => $args['width'],
);
$spacing = foogallery_gallery_template_setting( 'spacing', '' );
$viswidth = foogallery_gallery_template_setting( 'viswidth', 200 );
$lenssize = foogallery_gallery_template_setting( 'lenssize', 200 );
$bordersize = foogallery_gallery_template_setting( 'bordersize', 5 );
$bordercolor = foogallery_gallery_template_setting( 'bordercolor', '#333333' );
$border_style = foogallery_gallery_template_setting( 'border-style', 'border-style-square-white' );
// $lightbox = foogallery_gallery_template_setting( 'lightbox', 'none' );
$gray = foogallery_gallery_template_setting( 'grayscale', 'none' );
$blur = foogallery_gallery_template_setting( 'blur', 'none' );
?>
<style>
.foogallery-zoom .small {max-width: <?php echo $viswidth; ?>px;}
.large {
	width: <?php echo $lenssize; ?>px; 
	height: <?php echo $lenssize; ?>px; 
	-webkit-box-shadow: 0 0 0 <?php echo $bordersize; ?>px <?php echo $bordercolor; ?>, 
	0 0 7px 7px rgba(0, 0, 0, 0.35), 
	inset 0 0 40px 0 rgba(0, 0, 0, 0.5);
	
	-moz-box-shadow: 0 0 0 <?php echo $bordersize; ?>px <?php echo $bordercolor; ?>, 
	0 0 7px 7px rgba(0, 0, 0, 0.35), 
	inset 0 0 40px 0 rgba(0, 0, 0, 0.5);
	
	box-shadow: 0 0 0 <?php echo $bordersize; ?>px <?php echo $bordercolor; ?>, 
	0 0 7px 7px rgba(0, 0, 0, 0.35), 
	inset 0 0 40px 0 rgba(0, 0, 0, 0.5);
	}

</style>
<!--
<?php
// if ($lightbox != 'none'){
?>
<script>
jQuery(function($){
$(".large").on('click',function(){
document.location.href = $(this).data("url");});
});
</script>
<?php
// } ?>
-->
<div class="foogallery-container foogallery-zoom<?php echo foogallery_build_class_attribute( $current_foogallery, $spacing, $border_style, $gray, $blur /*$lightbox*/); ?>">
	<?php foreach ( $current_foogallery->attachments() as $attachment ) {
		$attr['src'] = apply_filters( 'foogallery_attachment_resize_thumbnail', $attachment->url, $args, $this );
		echo '<div class="magnify" id="' . $attachment->ID . '"><div class="large"  style="background: url(' . $attr['src'] . ') no-repeat;" data-url="' . $attachment->url . '"></div>' . $attachment->html( $args ) . '</div>';
	} ?>
</div>