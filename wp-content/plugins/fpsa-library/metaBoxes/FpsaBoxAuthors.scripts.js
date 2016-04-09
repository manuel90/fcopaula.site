jQuery(document).on('ready', function(){

	var containerAuthors = loadAuthors();

	jQuery('#btnFpsaAddAuthor').on('click', function(e) {
		e.preventDefault();

		var objUser = jQuery('#available_authors_book');
		var newUser = { 
				id: objUser.val(), 
				name: objUser.find(":selected").text()
			};

		if(!newUser.id) {
			alert(FpsaBoxAuthors.txtNoSeletedUser);
			return;
		}

		//Start process add author
		FpsaLibrary.showLoadStatus('#box_authors');
		
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: 'fpsa-adduser',
				postID: FpsaBoxAuthors.postID,
				user: newUser
			},
			dataType: 'json'
		}).done(function(response){
			if(response.statusText == 'OK') {
				loadAvailableUsers();
				attachEventAuthor(containerAuthors, newUser);
			}
		});
	});

});

function loadAuthors() {
	var containerAuthors = jQuery('#fpsa_authors_book');
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'fpsa-authors',
			postID: FpsaBoxAuthors.postID
		},
		dataType: 'json'
	}).done(function(response){
		if(response.statusText == 'OK') {
			containerAuthors.html('');
			for (var i in response.data) {
				attachEventAuthor(containerAuthors, response.data[i]);
			}
		}
	});
	return containerAuthors;
}

function loadAvailableUsers() {
	var htmlSelect = jQuery('#available_authors_book');
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'fpsa-availableusers',
			postID: FpsaBoxAuthors.postID
		},
		dataType: 'json'
	}).done(function(response){
		if(response.statusText == 'OK') {

			htmlSelect.html('<option value="">'+FpsaBoxAuthors.txtSelectAuthor+'</option>');
			for (var i in response.data) {
				htmlSelect.append('<option value="'+response.data[i].ID+'">'+response.data[i].data.display_name+'</option>');
			}
			//End process
			FpsaLibrary.hideLoadStatus();
		
		}
	});
}

function attachEventAuthor(containerAuthors, user) {

	var deleteAuthor = function(e) {
		e.preventDefault();

		//Start process remove author
		FpsaLibrary.showLoadStatus('#box_authors');
		
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: 'fpsa-removeuser',
				postID: FpsaBoxAuthors.postID,
				userID: e.data.userObj.id
			},
			dataType: 'json'
		}).done(function(response){
			if(response.statusText == 'OK') {
				loadAvailableUsers();
				loadAuthors();
			}
		});
	};

	var liObj = jQuery('<li>');

	var labelObj = jQuery('<span>').html(user.name);

	var htmlDelete = jQuery('<a>').
						attr('href', '#').
						html(FpsaBoxAuthors.txtRemove).
						on('click', { userObj: user }, deleteAuthor);

	liObj.append(labelObj).append(htmlDelete);

	containerAuthors.append(liObj);
}