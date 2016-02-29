@extends('master')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2>Projecten</h2>
                        </div>
                        <div class="ibox-content">
                            {!! Form::open(['url' => route('taskboard.index'), 'method' => 'GET']) !!}
                            <div class="row">
                                <div class="col-sm-8">
                                    {!! Form::select2('project_id', $selectValues) !!}
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-sm btn-primary">Ga</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <div class="hr-line-dashed"></div>
                            <ul>
                                @foreach ($projects as $project)
                                    <li>
                                        <a href="{{ route('taskboard.index', 'project_id='.$project->id) }}">{{ $project->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                   </div>
                </div>
                <div class="col-sm-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Recent toegevoegde tickets</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Stock Man</a> Check this stock chart. This price is crazy! </p>
                                    <div class="text-center m">
                                        <span id="sparkline8"></span>
                                    </div>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                                <li class="list-group-item ">
                                    <p><a class="text-info" href="#">@Jonathan Febrick</a> The standard chunk of Lorem Ipsum</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Meest recente reacties</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content no-padding">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Stock Man</a> Check this stock chart. This price is crazy! </p>
                                    <div class="text-center m">
                                        <span id="sparkline8"></span>
                                    </div>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 hours ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                                <li class="list-group-item ">
                                    <p><a class="text-info" href="#">@Jonathan Febrick</a> The standard chunk of Lorem Ipsum</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 hour ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Alan Marry</a> I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 1 minuts ago</small>
                                </li>
                                <li class="list-group-item">
                                    <p><a class="text-info" href="#">@Kevin Smith</a> Lorem ipsum unknown printer took a galley </p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> 2 minuts ago</small>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">





                    </div>
            </div>
        </div>
    </div>
@endsection