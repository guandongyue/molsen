<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap core CSS --> 
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog.css" rel="stylesheet">

    <link href="/plugin/editor.md/css/editormd.css" rel="stylesheet" />
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            {{--  <li><a href="{{ route('register') }}">Register</a></li>  --}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.js"></script>
    <script src="/plugin/editor.md/editormd.min.js"></script>
    <script type="text/javascript">
        var testEditor;

        $(function() {
            testEditor = editormd("test-editormd", {
                width   : "100%",
                height  : 640,
                syncScrolling : "single",
                path    : "/plugin/editor.md/lib/",
                imageUpload:true,
                imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL : "/upload?_token={{ csrf_token() }}"
            });
            
            /*
            // or
            testEditor = editormd({
                id      : "test-editormd",
                width   : "90%",
                height  : 640,
                path    : "../lib/"
            });
            */
        });
    </script>


<script>
$("#div-category").click(function(){
    if ( $("#div-button").is(':hidden') ) {
        $("#div-button").show();
    } else {
        $("#div-button").hide();
    }
    if ( $("#inputCategory").is(':hidden') ) {
        $("#inputCategory").show();
    } else {
        $("#inputCategory").hide();
    }
});

$("#button-category-cancel").click(function(){
    $("#div-button").hide();
    $("#inputCategory").hide();
});

$("#button-category-save").click(function(){
    var categoryName = $("#inputCategory").val();
    $.ajax({
        method: "POST",
        url: "/category/add",
        data: { name: categoryName, _token: '{{ csrf_token() }}' }
    }).done(function( msg ) {
        if (msg.status==1) {
            $("#category-list a").each(function(){
                $(this).prop('class', 'list-group-item');
            });
            $("#category-list").append('<a href="#" class="list-group-item active" style="margin:-1px;">'+categoryName+'</a>');
        } else {
            console.log(msg.msg);
        }
    });
    $("#div-button").hide();
    $("#inputCategory").hide();
});

$("#button-article-save").click(function(){
    $.ajax({
        method: "POST",
        url: "/article/save",
        data: { title: $("#articleFormTitle").val(), note: $("#articleFormNote").val(), _token: '{{ csrf_token() }}', status:1, dosubmit:1 }
    }).done(function( msg ) {
        if (msg.status==1) {
            $("#article-post-header").animate({ backgroundColor:'#dff0d8'},1000);
            $("#article-post-header").delay(1000).animate({ backgroundColor:'#fff'},1000);
            // .prop('style', 'background-color:#dff0d8;');
        }
    });
});

$("#button-article-publish").click(function(){
    $.ajax({
        method: "POST",
        url: "/article/save",
        data: { title: $("#articleFormTitle").val(), note: $("#articleFormNote").val(), _token: '{{ csrf_token() }}', status:1, dosubmit:1 }
    }).done(function( msg ) {
        if (msg.status==1) {
            location.href = "/article/"+msg.param.id;
        }
    });
});
</script>
</body>
</html>
