@extends('master')

@section('content')
    <div class="row wrapper nav-wrapper border-bottom white-bg page-heading no-padding">
        <nav class="navbar navbar-default border-bottom">
            <div class="col-lg-offset-1 col-md-offset-1 col-xs-offset-1 col-lg-6 col-md-4 col-sm-5 col-xs-10 no-padding">
                <h2>Projectnaam: Taskboard</h2>
            </div>
            <div class="col-sm-offset-1 col-xs-offset-1 col-lg-2 col-md-4 col-sm-5 col-xs-10 pull-right">
                <a href="{{ route('issuetracker.index') }}"><h2>Issuetracker</h2></a>
            </div>
        </nav>
    </div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2>Ticketnaam</h2>
                </div>
                <div class="ibox-content p-md">
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">Toegewezen door</label>
                        </div>
                        <div class="col-sm-9">
                            <p>John Doe</p>
                        </div>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">

                        <div class="col-sm-3">
                            <label class="control-label">Toegewezen aan</label>
                        </div>
                        <div class="col-sm-9">
                            <p>Rob Meijerink</p>
                        </div>


                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label">Omschrijving</label>
                        </div>
                        <div class="col-sm-9">
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam nesciunt praesentium quae quisquam recusandae rem rerum velit. Aspernatur cum facilis placeat sed sit voluptate voluptatibus. Explicabo provident quisquam reprehenderit? Perferendis.</p>
                        </div>
                         </div>
                     </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="ibox">
                <div class="social-feed-box">
                    <div class="social-avatar">
                        <div class="media-body">
                            <div class="col-lg-1">
                                <div class="">
                                    <i class="fa fa-comment-o fa-5x"></i>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <h2>{{ 'Rob Meijerink' }}</h2>
                                <small class="text-muted"><i class="fa fa-clock-o"></i>  {{ '21-02-2016' }}</small>
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



</div>



@endsection