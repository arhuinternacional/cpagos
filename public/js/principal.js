    

	$('#btnSearch').on('click', function(btn) {
        btn.preventDefault();  
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
	            url: '/admin/proveedorget',
	            data: function (d) {
	            	d.principal = true;
	                d.name = $('input[name=search]').val();
	                d.property = $('select[name=property]').val();
	            }
	        },
	        columns: [
	        	{ data: 'id', name: 'id', visible:false},
	        	{ data: 'company_id', name: 'company_id'},
	        	{ data: 'company_name', name: 'company_name'},
	        	{ data: 'company_email', name: 'company_email'},
	        	{ data: 'company_phone', name: 'company_phone'},
	            { data: 'tax_code', name: 'tax_code'},
	            { data: 'more', name: 'more', orderable: false, searchable: false}
	        ]
		});    

	    $("#searchCard").style.display = 'block';
    });