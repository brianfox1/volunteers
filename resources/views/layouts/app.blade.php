<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Uber Sub') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'UberSub') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                       @if (!Auth::guest())
                        <li><a href="{{ url('/') }}"><i class="fa fa-btn fa-home"></i>Home</a></li>

                        <!-- administrative options -->

                        @if (Auth::user()->isAdmin())

                        <li><a href="{{ url('/users') }}"><i class="fa fa-btn fa-user"></i>Users</a></li>
                        <li><a href="{{ url('/projects') }}"><i class="fa fa-btn fa-product-hunt"></i>Projects</a></li>
                        <li><a href="{{ url('/teams') }}"><i class="fa fa-btn fa-users"></i>Teams</a></li>

                        @endif
                       @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->first_name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                
                                <?php
if ($admin_id = session('back_to_admin_id')) {
    ?>
                                        <li><a href="{{ url('/user_login_by_id/' . $admin_id) }}"><i class="fa fa-btn fa-sign-share"></i>Return to admin</a></li>
                                <?php
}
?>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-btn fa-sign-out"></i>Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

    <?php if (isset($enable_summernote_text_editor)) {?>
        <!-- include summernote css/js -->
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
    <?php }?>

    <script src="{{ asset('js/global.js') }}"></script>

    <!-- https: //igorescobar.github.io/jQuery-Mask-Plugin/docs.html-->
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {

    });

    </script>
    @yield('pagescript')

</body>
</html>
