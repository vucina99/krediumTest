<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank</title>
    <link rel="shortcut icon" href="">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aa6076f641.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset("css/style.css")}}">
    <link rel="stylesheet" href="{{asset("css/responsive.css")}}">

</head>
<body>
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="navbar-logo">BANK</a>
        <ul class="navbar-links">
            @auth
                <li class="logout"><a href="/logout">Logout </a></li>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var logoutLink = document.querySelector('.logout');
                        logoutLink.addEventListener('click', function(event) {
                            event.preventDefault();
                            document.querySelector('#logout-form').submit();
                        });
                    });
                </script>
            @endauth
            @guest
                <li><a href="/login">Login <i class="fa-solid fa-right-to-bracket"></i></a></li>
            @endguest
        </ul>
    </div>
</nav>
<form method="POST" id="logout-form"  action="/advisor/logout">
    @csrf
    <button type="submit">Logout</button>
</form>
<header></header>
<main>
    @yield('content')

</main>
<footer>
    <div class="container">
        <div><p class="text-light">BANK </p></div>
        <div><p class="text-light">© 2023
                COPYRIGHT : VUK ZDRAVKOVIĆ</p></div>
    </div>
</footer>


<script src="{{asset("js/main.js")}}"></script>



</body>
</html>
