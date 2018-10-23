	var route = '/admin/dashboard';
	var token = $('#token').attr('content');
	var labelsCharts = [];

	$.get(route, function(data){
		console.log(data)
		//alert(data.proveedors);
		$("#drivCount").text(data.drivers);
		$("#provCount").text(data.proveedors);
		$("#costCount").text('S/ '+data.costos);
		//window.labelsCharts.push('1');
		/*alert(labelsCharts);
		labelsCharts.push('suma');*/
	});
