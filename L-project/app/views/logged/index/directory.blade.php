@extends('layouts.logged')
@include('logged.index.child.nav')
@include('logged.index.child.footer')

@section('body')
<style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
      .directory-rows:hover{
		  background: #CAE1FF;
	  }
</style>
    
<div class='col-md-12' id='search' style='background-color:white;border-radius:25px;' ng-controller='DirectoryCtrl'>
	<div style='background-color:white;margin-top:5px;' class='col-md-12'>
		<div class='col-md-12' id='search-form'>
			<div class='row'>
				<div class='col-lg-2'>
					<form class='form-inline' role='form'>
						<div class='form-group'>
							<div style='width:800px;' class='input-group'>
								<div style='display: inline-block;'>
									<span class='input-group-btn'>
										<button ng-click='searchDirectory();' class='btn btn-default' type='button'>Go!</button>
									</span>
								</div>
								<div style='display: inline-block;'>
									<input id='search-input' type='text' class='form-control' placeholder='User Name'>
								</div>
								<div style='display: inline-block;margin-left:50px;'>
									<select id='filter-specialty' class="btn btn-default">
										@foreach ($professions as $prof)
											<option value='{{$prof}}'>{{$prof}}</option>
										@endforeach
									</select>
								</div>
								<div style='display: inline-block;margin-left:50px;'>
									<select id='filter-sub-specialty' class="btn btn-default">
										@foreach ($sub_professions as $prof)
											<option value='{{$prof}}'>{{$prof}}</option>
										@endforeach
									</select>
								</div>
								<div style='display: inline-block;margin-left:50px;'>
									<select id='filter-phone-type' class="btn btn-default">
										<option value='Any'>Any</option>
										<option value='Cell Phone'>Cell Phone</option>
										<option value='Landline'>Landline</option>
									</select>
								</div>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</form>
				</div>
				<div style='float:right;' class='pagination'>
					<i ng-click='pageChange("up");' id='page-up' style='float:right;' class='fa fa-chevron-right'></i>
					<span style='float:right;'></span>
					<i ng-click='pageChange("down");' id='page-down' style='float:right;' class='fa fa-chevron-left'></i>
				</div>
			</div>
		</div>
	</div>
	<div id='search-results' style='' ng-init="searchDirectory();">
		<table class='table table-bordered' ng-controller='MapsCtrl'>
			<tr>
				<th>Name</th><th>Phone</th><th>Address</th><th>Specialty</th><th>Specialty{Sub}</th><th>State</th>
			</tr>
			<tr ng-click='openMap(doctor.address, doctor.id);' ng-repeat="doctor in doctorData[0]" class='directory-rows'>
				<td ng-bind="doctor.name"></td>
				<td ng-bind="doctor.phone"></td>
				<td ng-bind="doctor.address"></td>
				<td ng-bind="doctor.specialty"></td>
				<td ng-bind="doctor.sub_specialty"></td>
				<td ng-bind="doctor.state"></td>
			</tr>
		</table>
	</div>
</div>
<div ng-controller='MapsCtrl' style='display:none;height:1px;' id="map-canvas"></div>

@stop

@section('hidden_variables')
<input type="hidden" id="page-counter" value="1" />

@stop

@section('js_packages')
@stop


