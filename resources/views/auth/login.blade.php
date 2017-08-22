@extends('master')

@section('content')
    <div class="container">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h2 class="text-center">Inloggen</h2>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method="POST" action="/auth/login">
                                {!! csrf_field() !!}

                                <div class="form-group">
                                    <label for="email">E-mailadres</label>
                                    <input placeholder="E-mailadres" class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="password">Wachtwoord</label>
                                    <input placeholder="Wachtwoord" class="form-control" type="password" name="password" id="password">
                                </div>

                                <div class="form-group">
                                    <input type="checkbox" name="remember" id="remember"> <label for="remember">Onthoud mij</label>
                                </div>

                                <div>
                                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection