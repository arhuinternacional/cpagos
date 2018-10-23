$(document).ready(function (){
	
	var oTable = $("#tablaDatos").dataTable({
        order: [ 0, 'desc' ],
		language: {
		    "sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ registros",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
		    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		    "sInfoPostFix":    "",
		    "sSearch":         "Buscar:",
		    "sUrl":            "",
		    "sInfoThousands":  ",",
		    "sLoadingRecords": "Cargando...",
		    "oPaginate": {
		        "sFirst":    "Primero",
		        "sLast":     "Último",
		        "sNext":     "Siguiente",
		        "sPrevious": "Anterior"
		    },
		    "oAria": {
		        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
		    }
		},
		processing: true,
        serverSide: true,
        ajax: '/admin/getcostosincidents',
        columns: [
        	{ data: 'id', name: 'id', visible:false},
        	{ data: 'proveedors_id', name: 'proveedors_id', responsivePriority: 1},
        	{ data: 'drivers_id', name: 'drivers_id', responsivePriority: 1},
            { data: 'costo', name: 'costo', responsivePriority: 1},
            { data: 'bonus_cat', name: 'bonus_cat', responsivePriority: 2},
            { data: 'bonus_mount', name: 'bonus_mount', responsivePriority: 2},
            { data: 'penalty_cat', name: 'penalty_cat', responsivePriority: 2},
            { data: 'penalty_mount', name: 'penalty_mount', responsivePriority: 2},
            { data: 'payout_cat', name: 'payout_cat', responsivePriority: 2},
            { data: 'payout_mount', name: 'payout_mount', responsivePriority: 2},
            { data: 'total_factura', name: 'total_factura', orderable: false, searchable: false, responsivePriority: 1},
            { data: 'total_pay', name: 'total_pay', orderable: false, searchable: false, responsivePriority: 1},
            { data: 'fecha_upload', name: 'fecha_upload', responsivePriority: 1},
            { data: 'week', name: 'week', responsivePriority: 2},
            { data: 'year', name: 'year', responsivePriority: 2},
            { data: 'observaciones', name: 'observaciones', orderable: false, searchable: false, responsivePriority: 1},
            { data: 'ci_status', name: 'ci_status', orderable: false, searchable: false, responsivePriority: 1}
        ]
	});

	/*$(document).on('click', '.verify', function (btn) {
		var token = $('#token').attr('content');
	    id = $(this).val();
	    $.ajax({
	        type: 'GET',
	        headers: {'X-CSRF-TOKEN': token},
	        url: "/admin/verifprov/"+id,
	        dataType: 'json',        
	        success: function(data) {
	                toastr.success('Conductor Verificado!', 'Success Alert', {timeOut: 5000});
	                oTable.fnDraw();

	        }
	    });
	});*/

});