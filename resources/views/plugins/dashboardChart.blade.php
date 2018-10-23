<!DOCTYPE html>
<html>
 <body>
	@if ($chart != null)
	  <div>{!! $chart->container() !!}</div>
	@endif

 	{!!Html::script('plugins/js/Chart.bundle.min.js')!!}
	@if ($chart != null)
		 {!! $chart->script() !!}
	@endif
 </body>
</html>