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
        ajax: '/admin/historic',
        columns: [
        	{ data: 'id', name: 'id', visible: false},
        	{ data: 'subject_id', name: 'subject_id'},
            { data: 'attributes[<br> ]', name: 'attributes[<br> ]', orderable: false, searchable: false},
            { data: 'properties[<br> ]', name: 'properties[<br> ]', orderable: false, searchable: false},
            { data: 'changes[<br> ]', name: 'changes[<br> ]', orderable: false, searchable: false},
            { data: 'created_at', name: 'created_at', orderable: false, searchable: false}
        ]
        
	});

	/*$(document).on('click', '#send', function(){
		let x = $("#upload").val();
		let route = '/admin/setproveedores';
		let token = $('#token').attr('content');

		$.ajax({
			type: 'POST',
	        headers: {'X-CSRF-TOKEN': token},
	        data: {'files': x},
	        url: route,
	        success: function(res){
	        	
	        }

		});

	});*/
});