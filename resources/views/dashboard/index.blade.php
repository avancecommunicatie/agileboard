@extends('master')

@section('content')

<div id="taskboard-header" class="row wrapper border-bottom white-bg">
    <nav class="navbar border-bottom">
        <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
            <h2>Project: Taskboard</h2>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-offset-2 col-lg-1 col-md-3 col-sm-10 col-xs-12">
                    <a href="{{route('home')}}" id="home-btn" class="btn btn-sm btn-primary" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                </div>
                <div class="col-lg-offset-1 col-lg-7 col-md-9 col-sm-2 col-xs-12">
                    <a href="http://in2008.nl/mantis/my_view_page.php"><h2 style="white-space: nowrap">Ga naar Mantis</h2></a>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
              <div class="ibox float-e-margins">
                  <div class="ibox-title">
                          <h2>Ticketnaam</h2>
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
           <div class="ibox">
                <div class="ibox-title">
                    <h2>Stories</h2>
                </div>
                   <div class="social-feed-box">
                       <div class="social-avatar">
                           <div class="media-body">
                               <div class="col-lg-1">
                                   <div class="">
                                       <i class="fa fa-comment-o fa-5x"></i>
                                   </div>
                               </div>
                               <div class="col-lg-4">
                                   <h2>{{ 'Eerste bericht!' }}</h2>
                                   <small class="text-muted"><i class="fa fa-clock-o"></i>  {{ '21-02-2016' }}</small>
                               </div>
                           </div>
                       </div>
                       <div class="social-body">
                           <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, asperiores aspernatur beatae distinctio, dolor esse et ex expedita facere illo, incidunt molestias nam natus provident repellat reprehenderit rerum sapiente ullam?</p>
                       </div>
                   </div>
               </div>
         </div>
   </div>
</div>
@endsection

@section('bottom-script')
    @parent
    <script>
        $(function() {
            $('.handle').css('cursor', 'default');

            $('.description_btn').on('click', function() {
                $(this).toggleClass('fa-angle-double-down fa-angle-double-up');
                $(this).siblings('.handle').children('.ticket-description').toggle('slide', { direction: "left"}, 500);
            });
        });
    </script>
@endsection
