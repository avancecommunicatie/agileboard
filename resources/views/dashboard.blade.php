@extends('master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-offset-1 col-lg-3">
            <h2>Agile board: Naam van project</h2>
        </div>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-offset-1 col-lg-2">
            <a href="{{ route('issuetracker.index') }}"><h2>Issuetracker</h2></a>
        </div>
    </div>
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>To-do</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken die nog opgepakt moeten worden</p>

                        <div class="input-group">
                            <input type="text" placeholder="Add new task. " class="input input-sm form-control">
                            <span class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-plus"></i> Add task</button>
                            </span>
                        </div>

                        <ul class="sortable-list connectList agile-list" id="todo">
                            @foreach ($tickets as $ticket)
                                <li class=" {{ ($ticket->priority < 20 ? 'success' : '') }} {{ ($ticket->priority > 19 && $ticket->priority < 40 ? 'warning-element' : '') }} {{ ($ticket->priority > 40 ? 'danger-element' : '') }}" id="{{ $ticket->id }}">
                                    {{ $ticket->summary }}
                                    <div class="agile-detail">

                                        <span class="pull-right btn btn-xs btn-white">{{ $ticket->user == null ? 'ToDo' : $ticket->user->username}}</span>
                                        <i class="fa fa-clock-o"></i> {{ date('d-m-Y', $ticket->date_submitted) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>









            



            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>In Progress</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken die op dit moment worden uitgevoerd</p>
                        <ul class="sortable-list connectList agile-list" id="inprogress">
                            <li class="success-element" id="task9">
                                Quisque venenatis ante in porta suscipit.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 12.10.2015
                                </div>
                            </li>
                            <li class="success-element" id="task10">
                                Phasellus sit amet tortor sed enim mollis accumsan in consequat orci.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task11">
                                Nunc sed arcu at ligula faucibus tempus ac id felis. Vestibulum et nulla quis turpis sagittis fringilla.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 16.11.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task12">
                                Ut porttitor augue non sapien mollis accumsan.
                                Nulla non elit eget lacus elementum viverra.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 09.12.2015
                                </div>
                            </li>
                            <li class="info-element" id="task13">
                                Packages and web page editors now use Lorem Ipsum as
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                                    <i class="fa fa-clock-o"></i> 08.04.2015
                                </div>
                            </li>
                            <li class="success-element" id="task14">
                                Quisque lacinia tellus et odio ornare maximus.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                            <li class="danger-element" id="task15">
                                Enim mollis accumsan in consequat orci.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 11.04.2015
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Feedback</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Taken waar feedback op moet worden gegeven</p>
                        <ul class="sortable-list connectList agile-list" id="feedback">
                            <li class="success-element" id="task9">
                                Quisque venenatis ante in porta suscipit.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 12.10.2015
                                </div>
                            </li>
                            <li class="success-element" id="task10">
                                Phasellus sit amet tortor sed enim mollis accumsan in consequat orci.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task11">
                                Nunc sed arcu at ligula faucibus tempus ac id felis. Vestibulum et nulla quis turpis sagittis fringilla.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 16.11.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task12">
                                Ut porttitor augue non sapien mollis accumsan.
                                Nulla non elit eget lacus elementum viverra.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 09.12.2015
                                </div>
                            </li>
                            <li class="info-element" id="task13">
                                Packages and web page editors now use Lorem Ipsum as
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                                    <i class="fa fa-clock-o"></i> 08.04.2015
                                </div>
                            </li>
                            <li class="success-element" id="task14">
                                Quisque lacinia tellus et odio ornare maximus.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                            <li class="danger-element" id="task15">
                                Enim mollis accumsan in consequat orci.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 11.04.2015
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Completed</h3>
                        <p class="small"><i class="fa fa-hand-o-up"></i> Voltooide taken</p>
                        <ul class="sortable-list connectList agile-list" id="completed">
                            <li class="info-element" id="task16">
                                Sometimes by accident, sometimes on purpose (injected humour and the like).
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 16.11.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task17">
                                Ut porttitor augue non sapien mollis accumsan.
                                Nulla non elit eget lacus elementum viverra.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 09.12.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task18">
                                Which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 09.12.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task19">
                                Packages and web page editors now use Lorem Ipsum as
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-primary">Done</a>
                                    <i class="fa fa-clock-o"></i> 08.04.2015
                                </div>
                            </li>
                            <li class="success-element" id="task20">
                                Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                            <li class="info-element" id="task21">
                                Sometimes by accident, sometimes on purpose (injected humour and the like).
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 16.11.2015
                                </div>
                            </li>
                            <li class="warning-element" id="task22">
                                Simply dummy text of the printing and typesetting industry.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Tag</a>
                                    <i class="fa fa-clock-o"></i> 12.10.2015
                                </div>
                            </li>
                            <li class="success-element" id="task23">
                                Many desktop publishing packages and web page editors now use Lorem Ipsum as their default.
                                <div class="agile-detail">
                                    <a href="#" class="pull-right btn btn-xs btn-white">Mark</a>
                                    <i class="fa fa-clock-o"></i> 05.04.2015
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection