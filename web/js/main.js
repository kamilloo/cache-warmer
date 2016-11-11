function associated(checkbox) {

	var $checkbox = $(checkbox),
	url = $checkbox.attr('data-url-associated'),
	varnishId = $checkbox.attr('data-varnish-id'),
	websiteId = $checkbox.val(),
	checked = checkbox.checked ? 1 : 0;
	$('input[type="checkbox"][value="' + websiteId +'"]').not(checkbox).prop('checked', false);
	$.ajax({
		url: 	url,
		type: 'POST',
		data: {
			varnish_id : 	varnishId,
			website_id : 	websiteId,
			checked: 		checked,
		},
		success: 	function(response){
			alert(response)	
		},
	})
}