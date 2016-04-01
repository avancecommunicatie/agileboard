@extends('master')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-lg-offset-1 col-lg-1">
                                    <i class="fa fa-tag fa-3x"></i>
                                </div>
                                <div class="col-lg-9">
                                    <h2 class="text-center">Agile Projecten</h2>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            @if ($projectgroups->count() > 0)
                                <p class="small text-center"><i class="fa fa-info-circle"></i> Agile Projecten zijn een verzameling van mantis projecten</p>
                                <div class="hr-line-dashed"></div>
                            @endif
                                <a href="{{route('projectgroup.create')}}" class="btn btn-xs btn-success project-btn"><i class="fa fa-plus"></i> Nieuw</a>
                                <a href="{{route('projectgroup.index')}}" class="btn btn-xs btn-default project-btn">Overzicht</a>
                            <div style="margin-top: 10px;">
                                @if ($projectgroups->count() > 0)
                                    @foreach ($projectgroups as $projectgroup)
                                        <div class="searchable" data-name="{{ $projectgroup->name }}">
                                            <a href="{{ route('taskboard.index', $projectgroup->id) }}" class="list-group-item">{{ $projectgroup->name }} <span class="label label-default pull-right" title="Aantal projecten">{{ ($projectgroup->projects ? $projectgroup->projects->count() : 0) }}</span></a>
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

@section('bottom-script')
    @parent
<script>
    $(function() {
        @if(session()->has('error') || session()->has('warning') || session()->has('success') || session()->has('info') || $errors->any())

            @foreach(['error', 'warning', 'success', 'info'] as $flash_value)
                @if(session()->has($flash_value))
                    @if(is_array(session()->get($flash_value)))
                        @foreach(session()->get($flash_value) as $fv)
                            toastr.{{$flash_value}}('{{ $fv }}');
                        @endforeach
                    @else
                        toastr.{{$flash_value}}('{{ session()->get($flash_value) }}');
                    @endif
                @endif
            @endforeach

            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            @endif

        @endif
    });
</script>
@endsection