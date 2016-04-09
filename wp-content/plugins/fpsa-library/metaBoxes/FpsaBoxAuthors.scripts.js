jQuery(document).on('ready', function(){


	var selecteds = [];
	var containerAuthors = jQuery('#fpsa_authors_book');

	for (var iu in selecteds) {
		attachEventAuthor(containerAuthors, selecteds[iu]);
	}
	jQuery('#btnFpsaAddAuthor').on('click', function(e) {
		e.preventDefault();
		var newUser = { 
				id: jQuery('#available_authors_book').val(), 
				name: 'Etn'
			};
		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: 'adduser',
				postID: FpsaBoxAuthors.postID,
				user: newUser
			},
			dataType: 'json'
		}).done(function(response){
			if(response.resultText == 'OK') {
				loadAvailableUsers();
				attachEventAuthor(containerAuthors, newUser);
			}
		});
	});

});

function loadAvailablelUsers() {
	var htmlSelect = jQuery('#available_authors_book');
	jQuery.ajax({
		url: ajaxurl,
		method: 'post',
		data: {
			action: 'availableusers',
			postID: FpsaBoxAuthors.postID
		},
		dataType: 'json'
	}).done(function(response){
		if(response.resultText == 'OK') {
			console.log(response.data);
			htmlSelect.html('');
			for (var i in response.data) {
				htmlSelect.append('<option value="'+response.data[i].ID+'">'+response.data[i].ID+'</option>');
			}
		}
	});
}

function attachEventAuthor(containerAuthors, user) {


	var deleteAuthor = function(e) {
		e.preventDefault();
		/**
		 * ajax request to delete author attach to book
		 **/

		jQuery.ajax({
			url: ajaxurl,
			method: 'post',
			data: {
				action: '',
				userID: e.data.userObj.id
			}
		}).done(function(response){

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