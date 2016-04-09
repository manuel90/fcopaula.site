function fpsaLibrary() {

	this.createPanelLoading = function(reference) {


		var createModal = function() {
			var divfpsa_spinner = jQuery('<div>').attr('id', 'fpsa_spinner').append('<div class="fpsa_bg"></div>');

			var divspinner = jQuery('<div>').addClass('spinner_content').append('<div class="fpsa_rect1"></div>').append('<div class="fpsa_rect2"></div>').append('<div class="fpsa_rect3"></div>').append('<div class="fpsa_rect4"></div>').append('<div class="fpsa_rect5"></div>');

			divfpsa_spinner.append(divspinner);
			jQuery(reference).append(divfpsa_spinner);

			return divfpsa_spinner;
		};

		var element = document.getElementById('fpsa_spinner');

		var panel = null;

		if(!element) {
			panel = createModal();
		} else {
			panel = jQuery(element).appendTo(reference);
		}
		jQuery(reference).addClass('fpsa_prelative');

		return panel;
	};

	this.showLoadStatus = function(reference) {
		
		var hasAddToBody = ( typeof(reference) === 'undefined' || !reference );

		var newReference = hasAddToBody ? document.body : reference;

		var loadingPanel = this.createPanelLoading(newReference);

		loadingPanel.show();

	};

	this.hideLoadStatus = function() {
		var element = jQuery('#fpsa_spinner');
		element.parent().removeClass('fpsa_prelative');
		element.hide();
	};
} 

var FpsaLibrary = new fpsaLibrary();