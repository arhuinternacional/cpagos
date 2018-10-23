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
        ajax: {
            url: '/admin/costos/gethistoric',
            data: function (d) {
                d.name = $('input[name=search]').val();
                d.property = $('select[name=property]').val();
                d.type = $('select[name=status]').val();
            }
        },
        columns: [
        	{ data: 'id', name: 'id', visible:false},
        	{ data: 'proveedors.company_id', name: 'proveedors.company_id'},
        	{ data: 'drivers.driver_id', name: 'drivers.driver_id'},
            { data: 'costo', name: 'costo'},
            { data: 'bonus_cat', name: 'bonus_cat'},
            { data: 'bonus_mount', name: 'bonus_mount'},
            { data: 'penalty_cat', name: 'penalty_cat'},
            { data: 'penalty_mount', name: 'penalty_mount'},
            { data: 'payout_cat', name: 'payout_cat'},
            { data: 'payout_mount', name: 'payout_mount'},
            { data: 'total_factura', name: 'total_factura', orderable: false, searchable: false},
            { data: 'total_pay', name: 'total_pay', orderable: false, searchable: false},
            { data: 'week', name: 'week'},
            { data: 'year', name: 'year'},
            { data: 'c_status', name: 'c_status', orderable: false, searchable: false},
            { data: 'observaciones', name: 'observaciones', orderable: false, searchable: false},
            { data: 'fecha_upload', name: 'fecha_upload'}
        ]
	});

	$('#submit').on('click', function(e) {
        oTable.fnDraw();
        e.preventDefault();
    });

    /*$('#import').on('click', function(btn) {
        btn.preventDefault();        
    });*/

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