$(function () {
	$('#reserveBtn').click(function(e) {
		e.preventDefault();
		$.ajax({
			contentType: 'application/json',
			data: JSON.stringify($('#reserveForm').serializeObject()),
			dataType: 'json',
			success: function(data){
				//console.log(data);
				//console.log("device control succeeded");
				window.location = '/reservation/' + data.id;
			},
			error: function(){
				//console.log("Device control failed");
			},
			processData: false,
			type: 'POST',
			url: '/reserve'
		});
	});
});

