@extends('master')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content  animated fadeInRight">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-lg-offset-1 col-lg-1">
                                    <i class="fa fa-calendar fa-3x"></i>
                                </div>
                                <div class="col-lg-9">
                                    <h2 class="text-center">Projectoverzicht</h2>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div style="margin-top: 10px;">
                                @foreach ($projects as $project)
                                    <div class="searchable" data-name="{{ $project->name }}">
                                        <a href="{{ route('taskboard.index', ['project_id' => $project->id]) }}" class="list-group-item">{{ $project->name }} <span class="label label-default pull-right">{{ $project->sprints }}</span></a>
                                    </div>
                                @endforeach
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
    $(document).ready(function() {
        var select = $("select[name='project_id']");

        select.on('change', function() {
            var id = $(this).val();
            window.location.replace("{{ route('taskboard.index') }}/"+id);
        });

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