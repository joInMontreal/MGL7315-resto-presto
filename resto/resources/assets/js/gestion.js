$( document ).ready(function() {
});

$('#statusFilter').on('change', function(e){
	window.location.href='/gestion/requests?status=' + $(this).val();
});

$('#tbl').on('click', 'th.sortable', function(){
    var th=$(this).index();
	window.location.href='/gestion/requests?status=' + $('#statusFilter').val() + '&sort=' + $(this).text();
});
