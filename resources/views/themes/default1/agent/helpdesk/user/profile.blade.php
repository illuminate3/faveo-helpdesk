@extends('themes.default1.agent.layout.agent')


@section('content')

@section('Dashboard')
class="active"
@stop

@section('dashboard-bar')
active
@stop

@section('profile')
class="active"
@stop


            @section('profileimg')
	        	@if(Auth::user() && Auth::user()->profile_pic)
                    <img src="{{asset('lb-faveo/media/profilepic')}}{{'/'}}{{Auth::user()->profile_pic}}" class="img-circle" alt="User Image" />
                @else
                    @if(Auth::user())
                         <img src="{{ Gravatar::src(Auth::user()->email,200) }}" class="img-circle" alt="User Image">
                    @endif
                @endif
	        @stop



<section class="content">
<div class="row">
{{-- style="background-image:url({{ URL::asset('/dist/img/boxed-bg.jpg')}}); color:#DBDBDB;" --}}
	<div class="col-md-12 box box-primary">
	    <div class="col-md-6">
	       	{{-- <div class="box box-success"> --}}
			{{-- <section class="content"> --}}
	       		{{-- <div class=" box-header"> --}}
			        	<h3><b>{!! Lang::get('lang.user_information') !!}</b>&nbsp;&nbsp;<a href="{{URL::route('agent-profile-edit')}}"><i class="fa fa-fw fa-edit"> </i></a></h3>
			        	{{-- </div> --}}
			        <div class="box-body">
			        	<table class="row">
				        	@if($user->gender == 1)
				        		<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.gender') !!}:<b></h4></th><td class="col-md-6"><h4>{{ 'Male' }}</h4></td></tr>
				        	@else
				        		<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.gender') !!}:</b></h4></th><td class="col-md-6"><h4>{{ 'Female' }}</h4></td></tr>
				        	@endif
				        	<?php
				        	if($user->primary_dpt){
				        		$dept = App\Model\helpdesk\Agent\Department::where('id','=', $user->primary_dpt)->first();
				        		$dept = $dept->name;
				        	} else {
				        		$dept = "";
				        	}
				        	if($user->assign_group){
				        		$grp = App\Model\helpdesk\Agent\Groups::where('id','=', $user->assign_group)->first();
				        		$grp = $grp->name;
				        	} else {
								$grp = "";
				        	}
				        	if($user->agent_tzone){
				        		$timezone = App\Model\helpdesk\Utility\Timezones::where('id','=', $user->agent_tzone)->first();
				        		$timezone = $timezone->name;
				        	} else {
				        		$timezone = "";
				        	}
				        	?>
				        	<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.department') !!}:</b></h4></th><td class="col-md-6"><h4>{{ $dept }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.group') !!}:</b></h4></th><td  class="col-md-6"><h4>{{ $grp }}</h4></td></tr>
				        	<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.company') !!}:</b></h4></th><td  class="col-md-6"> <h4>{{ $user->company }}</h4></td></tr>
				        	{{-- <tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.time_zone') !!}:</b></h4></th><td  class="col-md-6"><h4> {{ $timezone }}</h4></td></tr> --}}
				        	<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.role') !!}:</b></h4></th><td  class="col-md-6"> <h4>{{ $user->role }}</h4></td></tr>
			        	</table>
			    	</div>
			    {{-- </section> --}}
		    {{-- </div> --}}
	    </div>
	    <div class="col-md-6">
	      	{{-- <div class="box box-primary"> --}}
	      		{{-- <section class="content"> --}}
	      		<h3><b>{!! Lang::get('lang.contact_information') !!}</b></h3>
		       		<div class="box-body">
			        	<table>
							<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.email') !!}:</b></h4> </th> <td class="col-md-6"><h4> {{ $user->email }}</h4> </td></tr>
							<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.phone_number') !!}:</b></h4> </th> <td class="col-md-6"><h4> {{ $user->ext }}{{ $user->phone_number }}</h4> </td></tr>
				        	<tr><th class="col-md-8"><h4><b>{!! Lang::get('lang.mobile') !!}:</b></h4></th><td class="col-md-6"><h4> {{ $user->mobile }}</h4></td></tr>
			        	</table>
		        	</div>
		        {{-- </section> --}}
	        </div>
	    {{-- </div> --}}
    </div>
</div>
</section>
@stop
