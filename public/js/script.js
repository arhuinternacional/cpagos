$(document).ready(function() {
		$("#registro").click(function(){
		
		var route = "/usuario";
		var token = $("#token").attr('content');
		//alert(token);
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': token},
			type: 'POST',
			dataType: 'json',
			data:{'dni': $('#dni').val(),
				  'name': $('#name').val(),
		          'email': $('#email').val(),
		          'password': $('#password').val(),
		          'telefono': $('#telefono').val(),
		          'perfil': $('#perfil').val(),
		          'username': $('#username').val(),
		          'rol': $('#rol').val(),
		      },


			success:function(){
				$("#modalAgregarUsuario").modal('hide');
				toastr.success('¡El usuario ha sido guardado correctamente!');
				otable.fnDraw();

			},
			error:function(msj){
				toastr.warning('¡El usuario no puede ir vacío o llevar caracteres especiales!');
				$("#msj").html(msj.responseJSON.dni);
				$("#msj-error").fadeIn();
			}
		});
	});
		var otable = $("#TablaDatos").dataTable({
			"language": {

		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
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
		        ajax: '/admin/getusers',
		        columns: [
		            { data: 'dni', name: 'dni' },
		            { data: 'name', name: 'name' },
		            { data: 'email', name: 'email' },
		            { data: 'username', name: 'username' },
		            { data: 'telefono', name: 'telefono' },
		            { data: 'perfil', name: 'perfil' },
		            { data: 'estado', name: 'estado' },
		            {data: 'action', name: 'action', orderable: false, searchable: false}


		            
        		]
		});


		
});