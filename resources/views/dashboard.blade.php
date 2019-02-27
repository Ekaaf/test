@extends('layout.master')

@section('content')

<div class="container">
	<div style="padding-top: 83px;max-width: 400px;width: 100%;margin: 0 auto;">
		<div style="text-align: center;margin-bottom: 4%;">期間を指定してCSVのダウンロードを行います</div>
		<form class="form-inline" method="post" action="{{URL::to('downloadFile')}}">
			@csrf
			<div style="width: 100%;text-align: center;vertical-align: middle;line-height: 33px;">
				<input type="text" class="form-control datepicker" id="startDate" name="startDate" value="{{ old('startDate') }}" style="border: 1px solid black;border-radius: 10px 10px 10px 10px;max-width: 160px;width: 40%;float: left;text-align: center;<?php if(Session::has('error')) echo "border: 1px solid red"; ?>" placeholder="2019/02/14"> ~
				<input type="text" class="form-control" id="endDate" name="endDate" value="{{ old('endDate') }}" style="border: 1px solid black;border-radius: 10px 10px 10px 10px;max-width: 160px;width: 40%;float: right;text-align: center;<?php if(Session::has('error')) echo "border: 1px solid red"; ?>" placeholder="2019/02/14">
			</div>
			@if (Session::has('error'))
			<div style="width: 100%;color: red;margin-top: 1%;">{{Session::get('error')}}</div>
			@endif
			<button type="submit" class="btn btn-primary" style="color: white;background: #005BAB;width: 100%;border-radius: 10px 10px 10px 10px;margin-top: 4%;>">CSVダウンロード</button>
			<!-- <a href="{{URL::to('logout')}}">Logout</a> -->

			@if (Session::has('nofile'))
			<div style="width: 100%;color: green;margin-top: 1%;">{{Session::get('nofile')}}</div>
			@endif
		</form>
	</div>
</div>

<script type="text/javascript">
	// $("#startDate").datepicker({uiLibrary: 'bootstrap4'});
	$(document).ready(function() {
		$('#startDate,#endDate').datepicker({
             'format': 'yyyy/mm/dd'
         }).on('changeDate', function(e){
             $('#startDate,#endDate').datepicker('hide');
         });
	});
</script>
@stop