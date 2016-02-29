@extends('master')

@section('content')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <img src="" class="img-circle circle-border img-responsive" style="background-color: #fff;">
        </div>

        <form class="m-t" role="form" method="POST" action="{{ route('backend.login') }}">
            {!! csrf_field() !!}

            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="Gebruikersnaam" value="{{ old('user_name') }}" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord" required="">
            </div>

            <div class="form-group" style="float: left; padding-left: 10px;">
                {!! Form::icheck('remember', false) !!}
                {!! Form::label('remember', 'Gegevens onthouden') !!}
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Inloggen</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {

        {{--$('[data-toggle="tooltip"]').tooltip({ html: true, container: 'body', delay: {show: 800, hide: 100}, placement: 'right' });--}}

        {{--@if(session()->has('error') || session()->has('warning') || session()->has('success') || session()->has('info') || $errors->any())--}}

            {{--@foreach(['error', 'warning', 'success', 'info'] as $flash_value)--}}
                {{--@if(session()->has($flash_value))--}}
                    {{--@if(is_array(session()->get($flash_value)))--}}
                        {{--@foreach(session()->get($flash_value) as $fv)--}}
{{--                            toastr.{{$flash_value}}('{{ $fv }}');--}}
        {{--@endforeach--}}
    {{--@else--}}
{{--        toastr.{{$flash_value}}('{{ session()->get($flash_value) }}');--}}
        {{--@endif--}}
    {{--@endif--}}
{{--@endforeach--}}

{{--@if (count($errors) > 0)--}}
    {{--@foreach ($errors->all() as $error)--}}
        {{--toastr.error('{{ $error }}');--}}
        {{--@endforeach--}}
        {{--@endif--}}

        {{--@endif--}}

    });
</script>
@endsection