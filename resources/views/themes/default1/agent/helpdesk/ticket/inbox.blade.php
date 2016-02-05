@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('inbox')
class="active"
@stop

@section('content')
<?php 
    if(Auth::user()->role == 'agent') {
        $dept = App\Model\helpdesk\Agent\Department::where('id','=',Auth::user()->primary_dpt)->first();
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->where('dept_id','=',$dept->id)->orderBy('id', 'DESC')->paginate(20);
    } else {
        $tickets = App\Model\helpdesk\Ticket\Tickets::where('status', '=', 1)->orderBy('id', 'DESC')->paginate(20);
    }   
?>
<!-- Main content -->
<div class="box box-primary">
     <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.inbox') !!} </h3> <small id="title_refresh">{!! $tickets->total() !!} {!! Lang::get('lang.tickets') !!}</small>
    </div><!-- /.box-header -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> <b> Success </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> Fail! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
    <div class="box-body ">
    {!! Form::open(['route'=>'select_all','method'=>'post']) !!}
        <div class="mailbox-controls">
            <!-- Check all button -->
            <a class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></a>
            {{-- <a class="btn btn-default btn-sm" id="click"><i class="fa fa-refresh"></i></a> --}}
            <input type="submit" class="btn btn-default text-orange btn-sm" name="submit" value="{!! Lang::get('lang.delete') !!}">
            <input type="submit" class="btn btn-default text-yellow btn-sm" name="submit" value="{!! Lang::get('lang.close') !!}">
           
        </div>
        <div class="mailbox-messages" id="refresh">
            <!--datatable-->
            {!! Datatable::table()
        ->addColumn(
                    "",
                    Lang::get('lang.subject'),
                    Lang::get('lang.ticket_id'),
                    Lang::get('lang.priority'),
                    Lang::get('lang.from'),
                    Lang::get('lang.last_replier'),
                    Lang::get('lang.assigned_to'),
                    Lang::get('lang.last_activity'))
        ->setUrl(route('get.inbox.ticket')) 
        ->setOrder(array(7=>'desc'))  
        ->setClass('table table-hover table-bordered table-striped')       
        ->render();!!}
        <!-- /.datatable -->
        </div><!-- /.mail-box-messages -->
        {!! Form::close() !!}
    </div><!-- /.box-body -->
</div><!-- /. box -->

<script>
      $(function () {
        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }          
          $(this).data("clicks", !clicks);
        });
      });

    $(function() {
        // Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
            } else {
                //Check all checkboxes
                $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
            }
            $(this).data("clicks", !clicks);
        });
    });

    $(document).ready(function() { /// Wait till page is loaded
        $('#click').click(function() {
            $('#refresh').load('inbox #refresh');
            $('#title_refresh').load('inbox #title_refresh');
            $('#count_refresh').load('inbox #count_refresh');
            $("#show").show();
        });
    });

</script>
@stop