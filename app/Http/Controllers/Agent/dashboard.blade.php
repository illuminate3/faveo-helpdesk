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
  
      <div class="box box-info">
                            
                <?php 
          
          // $tickets = App\Model\Ticket\Tickets::where('created_at','>=',date('Y-m-d'))->get();

          // echo count($tickets);

          ?>
                <div class="box-header with-border">
                    <h3 class="box-title">{!! Lang::get('lang.line_chart') !!}</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart" >
                            <div id="legendDiv"></div>
                            <canvas class="chart-data" id="tickets-graph" width="1000" height="400"></canvas>   
                    </div>
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
   
   <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
         <script type="text/javascript">
    $(function(){
    $.getJSON("agen", function (result) {

    var labels = [],data=[],data2=[],data3=[],data4=[];
    for (var i = 0; i < result.length; i++) {

$var12 = result[i].month;
if($var12 == 1){
   $var13 = "January";
} 
if($var12 == 2){
   $var13 = "Febuary";
} 
if($var12 == 3){
   $var13 = "March";
} 
if($var12 == 4){
   $var13 = "April";
} 
if($var12 == 5){
   $var13 = "May";
} 
if($var12 == 6){
   $var13 = "June";
} 
if($var12 == 7){
   $var13 = "July";
} 
if($var12 == 8){
   $var13 = "August";
} 
if($var12 == 9){
   $var13 = "September";
} 
if($var12 == 10){
   $var13 = "October";
} 
if($var12 == 11){
   $var13 = "November";
} 
if($var12 == 12){
   $var13 = "December";
}
        labels.push($var13);
        data.push(result[i].totaltickets);
        data2.push(result[i].closed);
data3.push(result[i].reopened);
data4.push(result[i].open);
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
          data : data
          
        }
,
{
          label : "Open Tickets" , 
          fillColor : "rgba(255, 102, 204, 0.4)",
          strokeColor : "#f56954",
          pointColor : "#FF66CC",
          pointStrokeColor : "#fff",
pointHighlightFill : "#FF4DC3",
                pointHighlightStroke : "rgba(151,187,205,1)",
          data : data4
          
        }
,
              {
              label : "Closed Tickets",
                fillColor : "rgba(151,187,205,0.2)",
              strokeColor : "rgba(151,187,205,1)",
               pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#0000CC",
                pointHighlightFill : "#0000E6",
                pointHighlightStroke : "rgba(151,187,205,1)",
               data : data2
            }
,
{
              label : "Reopened Tickets",
                fillColor : "rgba(102,255,51,0.2)",
              strokeColor : "rgba(151,187,205,1)",
               pointColor : "rgba(46,184,0,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(151,187,205,1)",
               data : data3
            }
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

@stop
