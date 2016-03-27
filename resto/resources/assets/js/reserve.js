function showErrorMessage(msg) {
	$('#messageBox').removeClass('hide');
	$('#messageBox').html("<strong>Oops!</strong> " + msg);
}

$(function () {
	$('#reserveForm').submit(function(e) {
		e.preventDefault();
		$('#messageBox').addClass('hide');
		$.ajax({
			contentType: 'application/json',
			data: JSON.stringify($('#reserveForm').serializeObject()),
			dataType: 'json',
			success: function(response){
				if (response.status == 0) {
					showErrorMessage(response.message);
				} else {
					window.location = '/reservation/' + response.data.id;
				}
			},
			error: function() {
				showErrorMessage("Une erreur s'est produite...");
			},
			processData: false,
			type: 'POST',
			url: '/reserve'
		});
	});

	$('#resrvedAt').datetimepicker({
		format: 'YYYY-MM-DD HH:mm'
	});
});

