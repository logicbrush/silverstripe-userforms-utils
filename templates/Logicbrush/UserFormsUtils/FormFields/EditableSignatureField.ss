 <% require javascript(logicbrush/silverstripe-userforms-utils:client/thirdparty/jsignature/jSignature.min.js) %>

<span class="right-title"><em>Please sign below using your finger or mouse.</em> <button onclick="jQuery('#{$getAttribute('id')}__signature').jSignature('reset');jQuery('#{$getAttribute('id')}').val('');return false">Reset Signature</button></span>

<div id="{$getAttribute('id')}__signature" class="signatureBox"></div>
<input $AttributesHTML style="position:absolute; visibility: hidden; z-index: -1" />

<script type="text/javascript">

jQuery(document).ready(function() {

	var x = jQuery('#{$getAttribute('id')}__signature');
	x.jSignature({
		height: '100px',
	  	width: '400px'
	});

	x.bind('change', function(e) {
		jQuery('#{$getAttribute('id')}').val(x.jSignature('getData', 'image').join(','));
	});

});

</script>
