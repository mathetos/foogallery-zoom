//Use this file to inject custom javascript behaviour into the foogallery edit page
//For an example usage, check out wp-content/foogallery/extensions/default-templates/js/admin-gallery-default.js

(function (ZOOM_TEMPLATE_FOOGALLERY_EXTENSION, $, undefined) {

	ZOOM_TEMPLATE_FOOGALLERY_EXTENSION.doSomething = function() {
		//do something when the gallery template is changed to zoom
		jQuery('INPUT.minicolors').minicolors({
		position: 'top left',
		theme: 'default'
		});
	};

	ZOOM_TEMPLATE_FOOGALLERY_EXTENSION.adminReady = function () {
		$('body').on('foogallery-gallery-template-changed-zoom', function() {
			ZOOM_TEMPLATE_FOOGALLERY_EXTENSION.doSomething();
			
		});
	};

}(window.ZOOM_TEMPLATE_FOOGALLERY_EXTENSION = window.ZOOM_TEMPLATE_FOOGALLERY_EXTENSION || {}, jQuery));

jQuery(function () {
	ZOOM_TEMPLATE_FOOGALLERY_EXTENSION.adminReady();
});