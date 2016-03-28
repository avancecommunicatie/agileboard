@extends('master')

@section('content')
    <div id="taskboard-header" class="row wrapper border-bottom white-bg">
        <nav class="navbar border-bottom">
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <h2>Projecten</h2>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{route('taskboard.index')}}" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><i class="fa fa-tasks fa-2x"></i></a>
                <a href="{{route('home')}}" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                <a href="http://in2008.nl/mantis/my_view_page.php" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><span style="font-size: 1.4em; margin-right: 10%;">Mantis</span> <i class="fa fa-angle-double-right fa-customsize" style="padding-top: 5%;"></i>
                </a>
            </div>
        </nav>
    </div>


    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h4>Agile Project wijzigen</h4>
                </div>
                {!! Form::open(['url' => route('projectgroup.update', $projectgroup->id), 'method' => 'PUT', 'class'=>'form-horizontal']) !!}
                @include('projectgroup.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('bottom-script')
    @parent
    @include('projectgroup.scripts.form_script')
@endsection