<div class="box-authors">
	<div class="">
		<select id="available_authors_book">
			<?php foreach($usersOption as $user) { ?>
				<option value="<?php echo $user->ID; ?>"><?php echo $user->data->display_name; ?></option>
			<?php } ?>
		</select>
		<a id="btnFpsaAddAuthor" href="#" class="button button-primary button-large"><?php _e('Add', 'fpsa_lang'); ?></a>
	</div>
	<div class="selecteds">
		<ul id="fpsa_authors_book">
			<li><span>Author Example</span><div class="actions"><a href="#">View</a><a href="#">X</a></div></li>
		</ul>
	</div>
</div>