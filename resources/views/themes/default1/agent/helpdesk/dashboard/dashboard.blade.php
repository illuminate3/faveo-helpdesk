@extends('themes.default1.agent.layout.agent')

@section('Dashboard')
class="active"
@stop

@section('dashboard-bar')
active
@stop

@section('dashboard')
class="active"
@stop

@section('content')

<link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
{{-- <script src="{{asset("lb-faveo/dist/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script> --}}

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">{!! Lang::get('lang.line_chart') !!}</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    @if(Session::has('content'))
                    <div class="chart">
                        <div id="legendDiv1"></div>
                        <canvas class="chart-data" id="tickets-graph1" width="1000" height="400"></canvas>   
                    </div>
                    @else
                    <div class="chart">
                        <div id="legendDiv"></div>
                        <canvas class="chart-data" id="tickets-graph" width="1000" height="400"></canvas>   
                    </div>
                    @endif
                </div><!-- /.box-body -->
            </div><!-- /.box -->
            <hr/>
            <div class="box">
                <div class="box-header">
                             <h1>{!! Lang::get('lang.statistics') !!}</h1>
            
                </div>
                <div class="box-body">
              <table class="table table-hover" style="overflow:hidden;">
             
                <tr>
                <th>{!! Lang::get('lang.department') !!}</th>
                <th>{!! Lang::get('lang.opened') !!}</th>
                <th>{!! Lang::get('lang.resolved') !!}</th>
                <th>{!! Lang::get('lang.closed') !!}</th>
                <th>{!! Lang::get('lang.deleted') !!}</th>
                </tr>

<?php $departments = App\Model\helpdesk\Agent\Department::all(); ?>
@foreach($departments as $department)
<?php
$open = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$department->id)->where('status','=',1)->count(); 
$resolve = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$department->id)->where('status','=',2)->count(); 
$close = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$department->id)->where('status','=',3)->count(); 
$delete = App\Model\helpdesk\Ticket\Tickets::where('dept_id','=',$department->id)->where('status','=',5)->count(); 
?>

                <tr>
                   
                    <td>{!! $department->name !!}</td>
                    <td>{!! $open !!}</td>
                    <td>{!! $resolve !!}</td>
                    <td>{!! $close !!}</td>
                    <td>{!! $delete !!}</td>
                   
                </tr>
                @endforeach 
                </table>
            </div>
                </div>
                <div id="refresh"> 
                  <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
                </div>
   
<script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
    <script type="text/javascript">
    $(function(){
    $.getJSON("agen", function (result) {

    var labels=[], open=[], closed=[], reopened=[];
    //,data2=[],data3=[],data4=[];
    for (var i = 0; i < result.length; i++) {


        // $var12 = result[i].day;

        // labels.push($var12);
        labels.push(result[i].date);
        open.push(result[i].open);
        closed.push(result[i].closed);
        reopened.push(result[i].reopened);
      // data4.push(result[i].open);
    }

    var buyerData = {
      labels : labels,
      datasets : [
        {
          label : "Total Tickets" , 
          fillColor : "rgba(240, 127, 110, 0.3)",
          strokeColor : "#f56954",
          pointColor : "#A62121",
          pointStrokeColor : "#E60073",
          pointHighlightFill : "#FF4DC3",
          pointHighlightStroke : "rgba(151,187,205,1)",
          data : open      
        }
        ,{
          label : "Open Tickets" , 
          fillColor : "rgba(255, 102, 204, 0.4)",
          strokeColor : "#f56954",
          pointColor : "#FF66CC",
          pointStrokeColor : "#fff",
          pointHighlightFill : "#FF4DC3",
          pointHighlightStroke : "rgba(151,187,205,1)",
          data : closed
          
        }
        ,{
          label : "Closed Tickets",
          fillColor : "rgba(151,187,205,0.2)",
          strokeColor : "rgba(151,187,205,1)",
          pointColor : "rgba(151,187,205,1)",
          pointStrokeColor : "#0000CC",
          pointHighlightFill : "#0000E6",
          pointHighlightStroke : "rgba(151,187,205,1)",
          data : reopened
        }
        // ,{
        //       label : "Reopened Tickets",
        //         fillColor : "rgba(102,255,51,0.2)",
        //       strokeColor : "rgba(151,187,205,1)",
        //        pointColor : "rgba(46,184,0,1)",
        //         pointStrokeColor : "#fff",
        //         pointHighlightFill : "#fff",
        //         pointHighlightStroke : "rgba(151,187,205,1)",
        //        data : data3
        //     }
      ]
    };

     var myLineChart = new Chart(document.getElementById("tickets-graph").getContext("2d")).Line(buyerData, {
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: false,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: false,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: true,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 1,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: true,
          //String - A legend template
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          
          legendTemplate : '<ul style="list-style-type: square;">'
                      +'<% for (var i=0; i<datasets.length; i++) { %>'
                        +'<li style="color: <%=datasets[i].pointColor%>;">'
                        +'<span style=\"background-color:<%=datasets[i].pointColor%>\"></span>'
                        +'<% if (datasets[i].label) { %><%= datasets[i].label %><% } %>'
                      +'</li>'
                    +'<% } %>'
                  +'</ul>'
        });
    document.getElementById("legendDiv").innerHTML = myLineChart.generateLegend();
  });
});




</script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        // Close a ticket
        $('#close').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "agen",
                beforeSend: function() {
                    
                },
                success: function(response) {
                    
                }
            })
            return false;
        });
    });
</script>

<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
{{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script> --}}
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
@stop