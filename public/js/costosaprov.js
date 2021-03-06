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
            url: '/admin/costos/getcostos',
            data: function (d) {
            	d.type = true;
                d.names = $('#searchs').val();
                d.property = $('#property').val();
                d.status = $('#status').val();
            }
        },
        columns: [
        	{ data: '_id', name: '_id', visible:false},
        	{ data: 'proveedores.company_id', name: 'proveedores.company_id'},
        	{ data: 'drivers.driver', name: 'drivers.driver'},
            { data: 'costo', name: 'costo'},
            { data: 'total_factura', name: 'total_factura', orderable: false, searchable: false},
            { data: 'total_pay', name: 'total_pay', orderable: false, searchable: false},
            { data: 'week', name: 'week'},
            { data: 'year', name: 'year'},
            { data: 'status', name: 'status', orderable: false, searchable: false},
            { data: 'fecha_upload', name: 'fecha_upload'}
        ]
	});

	$('#submit').on('click', function(e) {
        oTable.fnDraw();
        e.preventDefault();
    });

    $('#salir').on('click', function(e) {
        oTable.fnDraw();
    });

    oTable.on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
 
    $('#mostrar').click( function () {
        alert( oTable.rows('.selected').data().length +' row(s) selected' );
    } );

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

