<html>
    <head>
        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: rgba(72, 68, 68, 0.4);
                display: table;
                /*font-size: 100;*/
                font-family: "Source Sans Pro","Helvetica Neue",Helvetica,Arial,sans-serif;
            }
            a {
                font-size: 150;
                color: rgba(11, 0, 255, 0.41);
            }
            #body{
                font-size:22;
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"><a>500</a>{!! Lang::get('lang.internal_server_error') !!}. {!! Lang::get('lang.be_right_back') !!}.</div>
                <div class="error-content" id="body">
                    <h3><i class="fa fa-warning text-yellow"></i> {!! Lang::get('lang.sorry') !!}!</h3>
                    <p>
                        {!! Lang::get('lang.we_are_working_on_it') !!}.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>