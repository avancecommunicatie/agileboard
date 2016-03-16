@extends('master')

@section('content')

<div id="taskboard-header" class="row wrapper border-bottom white-bg">
    <nav class="navbar border-bottom">
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <h2>{{ 'Project' }}: Storyboard</h2>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-right">
            <a href="{{route('taskboard.index')}}" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><i class="fa fa-tasks fa-2x"></i></a>
            <a href="{{route('home')}}" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
            <a href="http://in2008.nl/mantis/my_view_page.php" class="btn btn-sm btn-primary nav-btn" style="border-radius: 15px;"><span style="font-size: 1.4em; margin-right: 10%;">Mantis</span> <i class="fa fa-angle-double-right fa-customsize" style="padding-top: 5%;"></i>
            </a>
        </div>
    </nav>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                      <h2>Akkoord</h2>
                  </div>
                  <div class="ibox-content p-md">
                      <ul class="sortable-list connectList agile-list">
                          @foreach ($tickets as $ticket)
                              @include('partials.task_item')
                          @endforeach
                      </ul>
                  </div>
              </div>
        </div>
        <div class="col-lg-9">
            <div class="ibox collapsed">
                <div class="ibox-title">
                    <h5 class="pull-left">Nieuw bericht</h5>
                    <div class="ibox-tools">
                        <a href="#" class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['url' => route('storyboard.store'), 'method' => 'POST']) !!}
                    <div class="form-group">
                        {{--{!! Form::label('subject', 'Onderwerp', ['class'=>'control-label']) !!}--}}
                        {!! Form::bsText('subject', false, ['class' => 'form-control', 'placeholder' => 'Onderwerp']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::bsTextarea('content', false, ['class' => 'form-control', 'placeholder' => 'Plaats een nieuw bericht op het storyboard']) !!}
                    </div>
                    {!! Form::submit('Plaats bericht', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
           @if ($stories && $stories->count() > 0)
               @foreach ($stories as $story)
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="ibox-tools pull-right">
                            <a href="#" class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                        <i class="fa fa-comment-o fa-3x pull-left"></i>
                        <h3 style="display: inline-block">{{ $story->subject }}</h3>
                        <small class="text-muted" style="display: block"><i class="fa fa-clock-o"></i>  {{ $story->created_at }}</small>
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
    <script>
        $(function() {
            $('.handle').css('cursor', 'default');

            $('.description-btn').on('click', function() {
                $(this).toggleClass('fa-angle-double-down fa-angle-double-up');
                $(this).siblings('.handle').children('.ticket-description').toggle('slide', { direction: "left"}, 500);
            });
        });
    </script>
@endsection
