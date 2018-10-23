$(document).ready(function (){

	var oTable = $("#tablaDatos").DataTable({
		dom: 'Bfrtip',
        order: [ 0, 'desc' ],
        select: {
        	style: 'multi',
        	selector: 'td:last-child'
        },
        buttons: [
            {
                text: 'Get selected data',
                action: function () {
                    var count = oTable.rows( { selected: true } ).count();
 					alert(count);
                    //events.prepend( '<div>'+count+' row(s) selected</div>' );
                }
            },
        ],
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
            url: '/admin/proveedor/proveedorget',
            data: function (d) {
                d.name = $('input[name=search]').val();
                d.property = $('select[name=property]').val();
            }
        },
        columns: [
        	{ data: 'id', name: 'id', visible: false},
        	{ data: 'company_id', name: 'company_id',responsivePriority: 1},
        	{ data: 'company_name', name: 'company_name', responsivePriority: 1},
            { data: 'company_email', name: 'company_email', responsivePriority: 1},
            { data: 'company_phone', name: 'company_phone', responsivePriority: 1},
            { data: 'more', name: 'more', orderable: false, searchable: false, responsivePriority: 1},
            { data: 'tax_code', name: 'tax_code', responsivePriority: 1},
            { data: 'bank_account_holder_name', name: 'bank_account_holder_name', responsivePriority: 2},
            { data: 'bank_tax_code_name', name: 'bank_tax_code_name', responsivePriority: 2},
            { data: 'bank_tax_code', name: 'bank_tax_code', responsivePriority: 2},
            { data: 'bank_account_number', name: 'bank_account_number', responsivePriority: 2},
            { data: 'company_notes', name: 'company_notes', responsivePriority: 1},
            { data: 'p_status', name: 'p_status', orderable: false, searchable: false, responsivePriority: 2},
            { data: 'action', name: 'action', orderable: false, searchable: false, responsivePriority: 1}
        ],
        columnDefs: [ {
            orderable: false,
            className: 'select-checkbox',
            targets:   -1
        } ],
	});

	$('#submit').on('click', function(e) {
        oTable.fnDraw();
        e.preventDefault();
    });


	$('.salir').on('click', function(e) {
        oTable.fnDraw();
    });

	$(document).on('click', '.verify', function (btn) {
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
	});

});