jQuery(document).on('ready', function(){
	
	var params = {
		select: '#available_books',
		lang: {
			txtNoSeletedValue: FpsaBoxBooks.txtNoSeletedBook,
			txtNoItemAdded: FpsaBoxBooks.txtNoUsersAdded,
			txtView: FpsaBoxBooks.txtView,
			txtSelectItem: FpsaBoxBooks.txtSelectBook,
			txtRemove: FpsaBoxBooks.txtRemove
		},
		linkViewItem: '/wp-admin/post.php?post={itemId}&action=edit',
		idDivBox: '#box_books',
		idNoItems: 'nobooks',
		container: jQuery('#fpsa_books'),
		actionLoadItems: 'fpsa-availablebooks',
		actionLoad: 'fpsa-books',
		actionRemoveItem: 'fpsa-removebook',
		actionAddItem: 'fpsa-addbook',
		attrName: 'post_title',
		objID: FpsaBoxBooks.userID
	};


	var library2 = new fpsaLibrary();
	library2.loadTableValues(params);
	library2.loadItems(params);

	jQuery('#btnFpsaAddBook').on('click', params,  library2.triggerClick);

});