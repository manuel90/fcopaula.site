jQuery(document).on('ready', function(){


	var params = {
		select: '#available_authors',
		lang: {
			txtNoSeletedValue: FpsaBoxAuthors.txtNoSeletedUser,
			txtNoItemAdded: FpsaBoxAuthors.txtNoUsersAdded,
			txtView: FpsaBoxAuthors.txtView,
			txtSelectItem: FpsaBoxAuthors.txtSelectAuthor,
			txtRemove: FpsaBoxAuthors.txtRemove
		},
		linkViewItem: '/wp-admin/user-edit.php?user_id={itemId}',
		idDivBox: '#box_authors',
		idNoItems: 'noauthors',
		container: jQuery('#fpsa_authors'),
		actionLoadItems: 'fpsa-availableusers',
		actionLoad: 'fpsa-authors',
		actionRemoveItem: 'fpsa-removeuser',
		actionAddItem: 'fpsa-adduser',
		attrName: 'display_name',
		objID: FpsaBoxAuthors.postID
	};
	

	var library = new fpsaLibrary();
	library.loadTableValues(params);
	library.loadItems(params);

	jQuery('#btnFpsaAddAuthor').on('click', params,  library.triggerClick);
});