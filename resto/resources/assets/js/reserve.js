function showErrorMessage(msg) {
	$('#messageBox').removeClass('hide');
	$('#messageBox').html("<strong>Oops!</strong> " + msg);
}

function disableBtn()
{
	$('#reserveBtn').attr('disabled', 'disabled');
	$('#reserveBtn').text('Patientez...');
}

function enableBtn()
{
	$('#reserveBtn').removeAttr('disabled');
	$('#reserveBtn').text('Réserver');
}


$(function () {
	$('#reserveForm').submit(function(e) {
		disableBtn();
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
					window.location = '/reservation/' + response.data.id + '/confirmation';
				}
				enableBtn();
			},
			error: function() {
				showErrorMessage("Une erreur s'est produite...");
				enableBtn();
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

