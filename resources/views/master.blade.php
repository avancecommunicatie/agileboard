<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Avancé Communicatie | Agile board</title>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/font-awesome.min.css" rel="stylesheet">
        <link href="/css/select2.min.css" rel="stylesheet">

        <!-- Toastr style -->
        <link href="/css/toastr.min.css" rel="stylesheet">

        <link href="/css/animate.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/custom.css" rel="stylesheet">
    </head>

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