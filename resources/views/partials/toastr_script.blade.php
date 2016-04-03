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