@extends('master')

@section('content')
<div id="taskboard-header" class="row wrapper border-bottom white-bg">
    <nav class="navbar border-bottom">
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <h2>{{ $projectgroup->name }}: Storyboard</h2>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{route('taskboard.index', ['projectgroup_id' => $projectgroup->id, 'sprint_id' => $sprintId])}}" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><i class="fa fa-tasks fa-2x"></i></a>
            <a href="{{route('home')}}" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
            <a href="http://in2008.nl/mantis/my_view_page.php" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><span style="font-size: 1.4em;">Mantis</span> <i class="fa fa-angle-double-right fa-customsize"></i>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row" id="select-sprint-section">
            <div class="col-lg-3">
                {!! Form::open(['id' => 'change-project', 'url' => route('storyboard.change-project'), 'method' => 'POST']) !!}
                <div class="form-group">
                    {!! Form::hidden('sprint_id', $sprintId) !!}
                    {!! Form::label('projectgroup_id', 'Agile project', ['style' => 'white-space: nowrap;']) !!}
                    @if ($projectgroups)
                        {!! Form::select('projectgroup_id', $projectgroups, $projectgroup->id, ['id' => 'select-project']) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-lg-9">
                {!! Form::open(['id' => 'change-sprint', 'url' => route('storyboard.change-sprint'), 'method' => 'POST']) !!}
                <div class="form-group input-sprint">
                    {!! Form::hidden('projectgroup_id', $projectgroup->id) !!}
                    {!! Form::label('sprint_id', 'Sprint #', ['style' => 'white-space: nowrap;']) !!}
                    @if ($sprints)
                        {!! Form::select('sprint_id', $sprints, $sprintId, ['id' => 'select-sprint']) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h2>Akkoord</h2>
                  </div>
                  <div class="ibox-content p-md">
                      @if ($tickets && $tickets->count() > 0)
                      <ul class="sortable-list connectList agile-list">
                          @foreach ($tickets as $ticket)
                              @include('partials.task_item')
                          @endforeach
                      </ul>
                      @else
                          <p>Geen tickets om weer te geven</p>
                      @endif
                  </div>
              </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox collapsed collapsed-new-story">
                <a href="#" class="new-story">
                    <div class="ibox-title">
                        <h5 class="pull-left"><i class="fa fa-envelope-o"></i> Nieuw bericht</h5>
                        <div class="ibox-tools">
                            <i class="fa fa-chevron-up collapse-icon" style="color: #c4c4c4;"></i>
                        </div>
                    </div>
                </a>
                <div class="ibox-content">
                    {!! Form::open(['url' => route('storyboard.store'), 'method' => 'POST']) !!}
                    {!! Form::hidden('projectgroup_id', $projectgroup->id) !!}
                    <div class="form-group">
                        {!! Form::bsText('subject', false, ['class' => 'form-control', 'placeholder' => 'Onderwerp (verplicht)']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::bsTextarea('content', false, ['class' => 'form-control', 'placeholder' => 'Plaats een nieuw bericht op het storyboard']) !!}
                    </div>
                    {!! Form::submit('Plaats bericht', ['class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
           @if ($stories && $stories->count() > 0)
               @foreach ($stories as $story)
                <div class="ibox">
                    <div class="ibox-title">
                        {!! Form::open(['route' => ['storyboard.destroy', $story->id], 'method' => 'delete']) !!}
                        <div class="ibox-tools pull-right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li class="delete-story" style="cursor: pointer;"><a href="#">Bericht verwijderen</a></li>
                            </ul>
                            <a href="#" class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        {!! Form::close() !!}
                        <i class="fa fa-comment-o fa-3x pull-left"></i>
                        <h3 style="display: inline-block">{{ $story->subject }}</h3>
                        <small class="text-muted" style="display: block"><i class="fa fa-clock-o"></i>  {{ date('d-m-Y H:s:i', strtotime($story->created_at)) }}</small>
                    </div>
                    <div class="ibox-content">
                        <p>{!! nl2br($story->content) !!}</p>
                    </div>
                </div>
               @endforeach
           @endif
        </div>
   </div>
</div>
@endsection

@section('bottom-script')
    @parent
    @include('partials.navigation_script')
    @include('storyboard.scripts.index_script')
@endsection
