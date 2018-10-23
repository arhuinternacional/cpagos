$(document).ready(function (){

	var oTable = $("#tablaDrivers").dataTable({
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
            url: '/admin/proveedor/tablas',
            data: function (d) {
                d.driver = true;
                d.compID = $("#compaID").val();
            }
        },
        columns: [
        	{ data: '_id', name: '_id', visible:false},
        	{ data: 'driver', name: 'driver'}
        ]
		
	});

	var cTable = $("#tablaCostos").dataTable({
        
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
            url: '/admin/proveedor/tablas',
            data: function (d) {
                d.costo = true;
                d.compID = $("#compaID").val();
                d.property = $('select[name=c_property]').val();
                d.name = $('input[name=c_search]').val();
                d.type = $('select[name=c_status]').val();
            }
        },
        columns: [
        	{ data: '_id', name: '_id', visible:false},
        	{ data: 'week', name: 'week'},
        	{ data: 'year', name: 'year'},
        	{ data: 'fecha_upload', name: 'fecha_upload'},
        	{ data: 'drivers.driver', name: 'drivers.driver'},
        	{ data: 'costo', name: 'costo'},
        	{ data: 'bonus_cat', name: 'bonus_cat'},
        	{ data: 'bonus_mount', name: 'bonus_mount'},
        	{ data: 'penalty_cat', name: 'penalty_cat'},
        	{ data: 'penalty_mount', name: 'penalty_mount'},
        	{ data: 'payout_cat', name: 'payout_cat'},
        	{ data: 'payout_mount', name: 'payout_mount'},
        	{ data: 'total_factura', name: 'total_factura'},
        	{ data: 'total_pay', name: 'total_pay'},
        	{ data: 'status', name: 'status'},
        	{ data: 'nro_fact', name: 'nro_fact'}
        	
        ],
        order: [[15, 'desc']],
        rowGroup: {
            dataSrc: 'nro_fact'
        },

		
	});

	var fTable = $("#tablaFacturas").dataTable({
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
            url: '/admin/proveedor/tablas',
            data: function (d) {
                d.factura = true;
                d.compID = $("#compaID").val();
                d.property = $('select[name=f_property]').val();
                d.name = $('input[name=f_search]').val();
                d.type = $('select[name=f_status]').val();
            }
        },
        columns: [
        	{ data: '_id', name: '_id', visible:false},
        	{ data: 'fact_day', name: 'fact_day'},
        	{ data: 'week', name: 'week'},
        	{ data: 'year', name: 'year'},
        	{ data: 'total_fact', name: 'total_fact'},
        	{ data: 'total_pay', name: 'total_pay'},
        	{ data: 'fact_type', name: 'fact_type'},
        	{ data: 'status', name: 'status'},
        ]
		
	});

	var pTable = $("#tablaPagos").dataTable({
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
            url: '/admin/proveedor/tablas',
            data: function (d) {
                d.pagos = true;
                d.compID = $("#compaID").val();
                d.property = $('select[name=f_property]').val();
                d.name = $('input[name=f_search]').val();
                d.type = $('select[name=f_status]').val();
            }
        },
        columns: [
        	{ data: '_id', name: '_id', visible:false},
        	{ data: 'transaction_emit', name: 'transaction_emit'},
        	{ data: 'd_operation', name: 'd_operation'},
        	{ data: 'group', name: 'group'},
        	{ data: 'n_cuenta', name: 'n_cuenta'},
        	{ data: 'importe', name: 'importe'},
        	{ data: 'transaction_payed', name: 'transaction_payed'},
        	{ data: 'transaction_n', name: 'transaction_n'},
        	{ data: 'status', name: 'status'},
        	{ data: 'observacion', name: 'observacion'},
        ]
		
	});

	$('#licostos').on('click', function(e) {
        cTable.fnDraw();
    });

    $('#f_submit').on('click', function(e) {
    	e.preventDefault();
        fTable.fnDraw();
    });

    $('#c_submit').on('click', function(e) {
    	e.preventDefault();
        cTable.fnDraw();
    });

});