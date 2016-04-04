$( document ).ready(function() {
	//$("#tbl").tablesorter();
});

$('#statusFilter').on('change', function(e){
	window.location.href='/gestion/requests?status=' + $(this).val();
});

$('#tbl').on('click', 'th.sortable', function(){
    var th=$(this).index();
    //alert('Column number is : ' + th + ' and text is : ' + $(this).text());
	window.location.href='/gestion/requests?status=' + $('#statusFilter').val() + '&sort=' + $(this).text();
});
