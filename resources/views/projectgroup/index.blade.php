@extends('master')

@section('content')
    <div id="taskboard-header" class="row wrapper border-bottom white-bg">
        <nav class="navbar border-bottom">
            <div class="col-lg-9 col-md-6 col-sm-6 col-xs-12">
                <h2>Agile Projecten: Overzicht</h2>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{route('home')}}" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><i class="fa fa-home fa-2x"></i></a>
                <a href="http://in2008.nl/mantis/my_view_page.php" class="btn btn-sm btn-success nav-btn" style="border-radius: 15px;"><span style="font-size: 1.4em; margin-right: 10%;">Mantis</span> <i class="fa fa-angle-double-right fa-customsize" style="padding-top: 5%;"></i>
                </a>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-lg-offset-1 col-lg-1">
                                    <i class="fa fa-pencil-square-o fa-3x"></i>
                                </div>
                                <div class="col-lg-9">
                                    <h2 class="text-center">Agile Projecten</h2>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            @if ($projectgroups->count() > 0)
                                <p class="small text-center"><i class="fa fa-info-circle"></i> Klik op een Agile Project om hem te wijzigen</p>
                                <div class="hr-line-dashed"></div>
                            @endif
                                <a href="{{route('projectgroup.create')}}" class="btn btn-xs btn-success project-btn"><i class="fa fa-plus"></i> Nieuw</a>
                            <div style="margin-top: 10px;">
                                @if ($projects->count() > 0)
                                    @foreach ($projectgroups as $projectgroup)
                                        <div class="searchable" data-name="{{ $projectgroup->name }}">
                                            <a href="{{ route('projectgroup.edit', $projectgroup->id) }}" class="list-group-item">{{ $projectgroup->name }} <span class="label label-default pull-right" title="Aantal projecten">{{ $projectgroup->projects->count() }}</span></a>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center">Geen agileprojecten om weer te geven</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection