function showErrorMessage(msg, type) {
	var message = "";

	$('#messageBox').removeClass('alert-danger');
	$('#messageBox').removeClass('alert-success');
	if (type == "error") {
		$('#messageBox').addClass('alert-danger');
		message = "<strong>Oops!</strong> ";
	} else {
		$('#messageBox').addClass('alert-success');
		message = "<strong>Yeah!</strong> ";
	}
	$('#messageBox').removeClass('hide');
	$('#messageBox').html(message + msg);
}

$(function () {
	$('#confirmForm').submit(function(e) {
		e.preventDefault();
		$('#messageBox').addClass('hide');
		$.ajax({
			contentType: 'application/json',
			data: JSON.stringify($('#confirmForm').serializeObject()),
			dataType: 'json',
			success: function(response){
				if (response.status == 0) {
					showErrorMessage(response.message, "error");
				} else {
					showErrorMessage("Reservation enregistré !", "success");
				}
			},
			error: function() {
				showErrorMessage("Une erreur s'est produite...", "error");
			},
			processData: false,
			type: 'POST',
			url: '/reservation/' + $('#reservationId').val() + '/confirm'
		});
	});
});

