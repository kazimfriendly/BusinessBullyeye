<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Business BullsEye</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 50px;
                top: 60px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                /*color: #116bfe;*/
                padding: 10px 10px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                color: #FFF;
                background-color: #3097d1;
                border-radius: 5px;
                margin-right: 13px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .bg_banner{
                background-image: url(images/bg.jpg);
                background-repeat: no-repeat;
                background-size: 100%;
                margin: 0 auto;
                text-align: center;
                max-width: 1150px;
            }
            @media screen and (max-width: 767px) {
                .top-right {
                    right: 6px;
                    top: 25px;
                }
                .links > a{
                    font-size: 10px;
                }
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height bg_banner">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Click here to login</a>
                        <!--<a href="{{ url('/register') }}">Register</a>-->
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <!--<img src="{{ url('/') }}/images/logo.png" />-->
                    <!--<b>Co</b>ach and <b>C</b>lient Panel-->
                </div>

<!--                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>-->
            </div>
        </div>
    </body>
</html>
