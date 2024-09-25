 <% require javascript(logicbrush/silverstripe-userforms-utils:client/thirdparty/jsignature/jSignature.min.js) %>

<div id="{$getAttribute('id')}__signature" class="signatureBox"></div>
<p class="right-title"><em>Please sign above using your finger or mouse.</em> <button onclick="jQuery('#{$getAttribute('id')}__signature').jSignature('reset');jQuery('#{$getAttribute('id')}').val('');return false">Clear Signature</button></p>
<input $AttributesHTML style="position:absolute; visibility: hidden; z-index: -1" />

<script type="text/javascript">

jQuery(document).ready(function() {

	var x = jQuery('#{$getAttribute('id')}__signature');
	x.jSignature({
		height: '100px',
	  	width: '500px'
	});
    x.find("canvas").css({
        "border": "2px solid #ddd",
        "background-color": "white"
    });

	x.bind('change', function(e) {
		jQuery('#{$getAttribute('id')}').val(x.jSignature('getData', 'image').join(','));
	});

});

</script>
