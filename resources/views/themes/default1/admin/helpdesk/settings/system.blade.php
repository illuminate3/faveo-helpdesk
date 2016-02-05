@extends('themes.default1.admin.layout.admin')

@section('Settings')
class="active"
@stop

@section('settings-bar')
active
@stop

@section('system')
class="active"
@stop


@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')

@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">

</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')

<!-- open a form -->

	{!! Form::model($systems,['url' => 'postsystem/'.$systems->id, 'method' => 'PATCH' , 'id'=>'formID']) !!}

    <div class="box box-primary">
    <div class="box-header">

   			<h3 class="box-title">{{Lang::get('lang.system')}}</h3> {!! Form::submit('Save',['onclick'=>'sendForm()','class'=>'btn btn-primary pull-right'])!!}
        <!-- <input type="submit" value="sumit" onclick="sendForm();"> -->
    </div>

    <!-- check whether success or not -->

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('success')}}
    </div>
    @endif
    <!-- failure message -->
    @if(Session::has('fails'))
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{Session::get('fails')}}
    </div>
    @endif


	<!-- Helpdesk Status:	radio  Online    Offline    -->
	
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
			  		<div class="form-group">
						{!! Form::label('status',Lang::get('lang.status')) !!}
						<div class="row">
							<div class="col-xs-3">
								{!! Form::radio('status','1',true) !!}{{Lang::get('lang.online')}}
							</div>
							<div class="col-xs-3">
								{!! Form::radio('status','0') !!}{{Lang::get('lang.offline')}}
							</div>
						</div>
					</div>
				</div>


 		<!-- Helpdesk Name/Title: text Required   -->

		       <div class="col-md-6">
		            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
						{!! Form::label('name',Lang::get('lang.name/title')) !!}
						{!! $errors->first('name', '<spam class="help-block">:message</spam>') !!}
						{!! Form::text('name',$systems->name,['class' => 'form-control']) !!}
					</div>
			    </div>


		<!-- Helpdesk URL: 	 text   Required -->
      		<div class="col-md-6">
      		<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
				{!! Form::label('url',Lang::get('lang.url')) !!}
				{!! $errors->first('url', '<spam class="help-block">:message</spam>') !!}
				{!! Form::text('url',$systems->url,['class' => 'form-control']) !!}
			</div>
     		</div>

      	<!-- Default Department:	Dropdown From  Department table: required  -->
            <div class="col-md-6">
            <div class="form-group {{ $errors->has('department') ? 'has-error' : '' }}">

			    {!! Form::label('department',Lang::get('lang.default_department')) !!}
			    {!! $errors->first('department', '<spam class="help-block">:message</spam>') !!}
			    {!!Form::select('department', [''=>'Select a Department','Department'=>$departments->lists('name','id')],null,['class'=>'form-control']) !!}

			</div>
		    </div>

		<!-- Default Time Zone:	Drop down: timezones table : Required -->
            <div class="col-md-6">
		    <div class="form-group {{ $errors->has('time_zone') ? 'has-error' : '' }}">
		        {!! Form::label('time_zone',Lang::get('lang.timezone')) !!}
			    {!! $errors->first('time_zone', '<spam class="help-block">:message</spam>') !!}
			    {!!Form::select('time_zone',[''=>'Select a Time Zone','Time Zones'=>$timezones->lists('name','id')],null,['class'=>'form-control']) !!}
			</div>
		    </div>

       
		<!-- Date and Time Format: text: required: eg - 03/25/2015 7:14 am -->

            <div class="col-md-6">
		    <div class="form-group {{ $errors->has('date_time_format') ? 'has-error' : '' }}">

			    {!! Form::label('date_time_format',Lang::get('lang.date_time')) !!}
			    {!! $errors->first('date_time_format', '<spam class="help-block">:message</spam>') !!}
	           	{!! Form::select('date_time_format',[''=>'Select a date Time Format','Date Time Formats'=>$date_time->lists('format','id')],null,['class' => 'form-control']) !!}

		    </div>

		    </div>

		 </div>

		<!-- Guest user page Content -->
			<div class="row">
			</div>

            

            <script language="JavaScript" type="text/javascript">
				CKEDITOR.replace( 'content',
				{
				filebrowserUploadUrl : '/uploader/upload.php'
				});

				CKEDITOR.replace( 'content', { toolbar : 'MyToolbar' } );
			</script>
</div>


@stop
