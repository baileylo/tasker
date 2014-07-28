<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <title>@yield('title', 'Task')</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="/css/bootstrap.theme.min.css">
</head>
<body>

    <input type="hidden" id="js-included-modules" value="@yield('js')" />

    <div class="container-fluid">
        @yield('content')
    </div>


    <!-- Latest compiled and minified JavaScript -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="https://login.persona.org/include.js"></script>
    <script src="/js/master.js"></script>
</body>
</html>
