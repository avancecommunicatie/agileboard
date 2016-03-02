<!DOCTYPE html>
<html>
    @include('partials.head')

    <body>
        <div class="container-fluid gray-bg">
            <div id="wrapper">
                <div class="gray-bg">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('partials.bottom_includes')
    </body>
</html>