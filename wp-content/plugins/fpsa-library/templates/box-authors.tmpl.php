<div class="box-authors">
	<div class="">
		<select id="available_authors_book">
			<option value=""><?php _e('--- Select a User ---', 'fpsa_lang'); ?></option>
			<?php foreach($usersOption as $user) { ?>
				<option value="<?php echo $user->ID; ?>"><?php echo $user->data->display_name; ?></option>
			<?php } ?>
		</select>
		<a id="btnFpsaAddAuthor" href="#" class="button button-primary button-large"><?php _e('Add', 'fpsa_lang'); ?></a>
	</div>
	<div class="selecteds">
		<ul id="fpsa_authors_book">
		</ul>
	</div>
</div>