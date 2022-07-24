<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>ContactOut</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="h-100 d-flex flex-column justify-content-center align-items-center pb-5">
            <h1 class="display-1">ContactOut</h1>
            <h2 class="mb-5">Contact instantly via personal emails & mobile phones</h2>
            <div>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Sign up for free</a>
            </div>
        </div>
    </body>
</html>
