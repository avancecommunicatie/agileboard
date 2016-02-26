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
                            <a href="{{ route('dashboard.index') }}">Naar project</a>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection