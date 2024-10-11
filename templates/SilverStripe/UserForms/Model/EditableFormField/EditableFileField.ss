<% require javascript('silverstripe/userforms:client/dist/js/jquery-validation/additional-methods.min.js') %>
<input type="hidden" name="MAX_FILE_SIZE" value="$MaxFileSize" />
<input $AttributesHTML<% if $RightTitle %> aria-describedby="{$Name}_right_title"<% end_if %>/>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#{$ID}').rules('add', {maxsize: $MaxFileSize});
	});
</script>
