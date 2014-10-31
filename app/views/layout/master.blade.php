<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="<?= csrf_token() ?>">

    <title>@yield('title', 'Task')</title>


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/bootstrap.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="/css/bootstrap.theme.min.css">

    <link rel="stylesheet" href="/css/main.css">
</head>
<body>

    {{--<input type="hidden" id="js-included-modules" value="authentication @yield('js')" />--}}
    <input type="hidden" id="js-included-modules" value=" @yield('js')" />
    <script type="text/javascript">var currentUser = {{ $currentUser }};</script>

    @include('partials.top-nav')

    <div class="container">
        @yield('content')
    </div>


    <!-- Latest compiled and minified JavaScript -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    {{--<script src="https://login.persona.org/include.js"></script>--}}
    <script src="/js/master.js"></script>
</body>
</html>
