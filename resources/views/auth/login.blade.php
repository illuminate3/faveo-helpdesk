@extends('themes.default1.layouts.login')

@section('body')
<h4 class="login-box-msg">{!! Lang::get('lang.Login_to_start_your_session') !!}</h4>
        @if(Session::has('status'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"> </i> <b> {!! Lang::get('lang.success') !!} </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('status')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('errors'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        </div>
        @endif

        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <li>{!! Session::get('error') !!}</li>
        </div>
        @endif
            <!-- form open -->
            {!!  Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']) !!}
            <!-- Email -->
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                {!! Form::text('email',null,['placeholder'=> Lang::get("lang.email") ,'class' => 'form-control']) !!}
                {!! $errors->first('email', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <!-- Password -->
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                {!! Form::password('password',['placeholder'=>Lang::get("lang.password"),'class' => 'form-control']) !!}
                {!! $errors->first('password', '<spam class="help-block">:message</spam>') !!}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember">{!! Lang::get("lang.remember") !!}
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{!! Lang::get("lang.login") !!}</button>
                </div><!-- /.col -->
            </div>
            </form>

            <a href="{{url('password/email')}}">{!! Lang::get("lang.iforgot") !!}</a><br>
            <a href="{{url('auth/register')}}" class="text-center">{!! Lang::get("lang.reg_new_member") !!}</a>
<!-- /.login-page -->
@stop
