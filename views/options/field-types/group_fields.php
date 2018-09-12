<?php
if ( ! isset($field['group_fields']) || ! is_array($field['group_fields']) || ! count($field['group_fields']) ){
	return;
}
?>
<div class="lms-option-gorup-fields-wrap">
	<?php
	foreach ($field['group_fields'] as $groupFieldKey => $group_field){
		$input_name = "lms_option[{$field['field_key']}][{$groupFieldKey}]";
		$default_value = isset($group_field['default']) ? $group_field['default'] : false;
		$input_value = $this->get($field['field_key'].'.'.$groupFieldKey, $default_value);
		?>
		<div class="lms-option-group-field">
			<?php include lms()->path."views/options/field-types/groups/{$group_field['type']}.php"; ?>
		</div>
		<?php
	}
	?>
</div>
