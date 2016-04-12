<div class="box-authors">
	<div class="form">
		<select id="available_authors">
			<option value=""><?php _e('--- Select a User ---', 'fpsa_lang'); ?></option>
		</select>
		<a id="btnFpsaAddAuthor" href="#" class="button button-primary button-large"><?php _e('Add', 'fpsa_lang'); ?></a>
	</div>
	<hr />
	<div class="selecteds">
		<table class="widefat">
			<thead>
				<tr>
					<th><?php _e('Name', 'fpsa_lang'); ?></th>
					<th><?php _e('Actions', 'fpsa_lang'); ?></th>
				</tr>
			</thead>
			<tbody id="fpsa_authors">
			</tbody>
			<tfoot>
				<tr>
					<th><?php _e('Name', 'fpsa_lang'); ?></th>
					<th><?php _e('Actions', 'fpsa_lang'); ?></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>