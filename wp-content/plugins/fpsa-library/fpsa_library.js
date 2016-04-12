function fpsaLibrary() {
	
	var $this = this;

	/**
	 * Functions to create the modal panel loading status
	 **/
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

		var loadingPanel = $this.createPanelLoading(newReference);

		loadingPanel.show();

	};

	this.hideLoadStatus = function() {
		var element = jQuery('#fpsa_spinner');
		element.parent().removeClass('fpsa_prelative');
		element.hide();
	};





	/**
	 *
	 * This functions are creating events to buttons and other elements to save, update and 
	 * delete the books and authors to database through ajax
	 ***/

	this.attachEventActions = function(config, newItem) {
		var deleteItem = function(e) {
			e.preventDefault();

			//Start process loading
			$this.showLoadStatus(config.idDivBox);
			
			jQuery.ajax({
				url: ajaxurl,
				method: 'post',
				data: {
					action: config.actionRemoveItem,
					objID: config.objID,
					itemID: e.data.itemObj.id
				},
				dataType: 'json'
			}).done(function(response){
				if(response.statusText == 'OK') {
					$this.loadItems(config);
					$this.loadTableValues(config);
				}
			});
		};

		jQuery(config.idDivBox).find('#'+config.idNoItems).hide();

		var trObj = jQuery('<tr>');

		var tdLabelObj = jQuery('<td>').html(newItem.name);

		var htmlDelete = jQuery('<a>').
							attr('href', '#').
							html('<label title="'+config.lang.txtRemove+'" class="dashicons dashicons-no"></label>').
							on('click', { itemObj: newItem }, deleteItem);

		var link = config.linkViewItem.replace('{itemId}', newItem.id);
		var htmlView = jQuery('<a>').
							attr('href', link).
							attr('target', '_blank').
							html('<label title="'+config.lang.txtView+'" class="dashicons dashicons-visibility"></label>');

		var htmlActions = jQuery('<td>')
							.append(htmlDelete)
							.append(htmlView);

		trObj.append(tdLabelObj)
				.append(htmlActions);

		config.container.append(trObj);
	};


	this.triggerClick = function(e) {
		e.preventDefault();
		var objSelect = jQuery(e.data.select);
		var nValues = {
			id: objSelect.val(), 
			name: objSelect.find(":selected").text()
		};

		if(!nValues.id) {
			alert(e.data.lang.txtNoSeletedValue);
			return;
		}

		//Start process loading
		$this.showLoadStatus(e.data.idDivBox);
		
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: e.data.actionAddItem,
				objID: e.data.objID,
				values: nValues
			},
			dataType: 'json'
		}).done(function(response){
			if(response.statusText == 'OK') {
				$this.loadItems(e.data);
				$this.attachEventActions(e.data, nValues);
			}
		});
	};

	this.loadItems = function(config) {
			
		var htmlSelect = jQuery(config.select);
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: config.actionLoadItems,
				objID: config.objID
			},
			dataType: 'json'
		}).done(function(response){
			if(response.statusText == 'OK') {

				htmlSelect.html('<option value="">'+config.lang.txtSelectItem+'</option>');
				var option = null;
				for (var i in response.data) {
					option = response.data[i].data ? response.data[i].data : response.data[i];

					htmlSelect.append('<option value="'+option.ID+'">'+option[config.attrName]+'</option>');
				}
				//End process loading
				$this.hideLoadStatus();
			
			}
		});
	};

	this.loadTableValues = function(config) {
			
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: config.actionLoad,
				objID: config.objID
			},
			dataType: 'json'
		}).done(function(response){
			if(response.statusText == 'OK') {

				if(response.data && jQuery.makeArray(response.data).length > 0) {
					config.container.html('');
					for (var i in response.data) {
						$this.attachEventActions(config, response.data[i]);
					}
				} else {
					config.container.html('<tr id="'+config.idNoItems+'"><td colspan="2">'+config.lang.txtNoItemAdded+'</td></tr>');
				}
			}
		});
		return config.container;
	};

} 
