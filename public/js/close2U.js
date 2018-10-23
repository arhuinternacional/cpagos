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
            url: '/admin/facturas/getfacts',
            data: function (d) {
                d.name = $('input[name=search]').val();
                d.property = $('select[name=property]').val();
                d.type = $('select[name=type]').val();
            }
        },
        columns: [
        	{ data: 'id', name: 'id', visible:false},
        	{ data: 'year', name: 'year'},
        	{ data: 'week', name: 'week'},
        	{ data: 'fact_day', name: 'fact_day'},
            { data: 'proveedors.company_id', name: 'proveedors.company_id'},
            { data: 'proveedors.company_name', name: 'proveedors.company_id'},
            { data: 'proveedors.tax_code', name: 'proveedors.tax_code'},
            { data: 'proveedors.company_email', name: 'proveedors.company_email'},
            { data: 'total_pay', name: 'total_pay',  orderable: false, searchable: false},
            { data: 'fact_type', name: 'fact_type'},
            { data: 'f_status', name: 'f_status',  orderable: false, searchable: false}
        ]
	});

	$('#submit').on('click', function(e) {
        oTable.fnDraw();
        e.preventDefault();
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