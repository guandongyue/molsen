<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/blog.css" rel="stylesheet">

    <link href="/plugin/editor.md/css/editormd.css" rel="stylesheet" />

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/assets/js/ie-emulation-modes-warning.js"></script>

  </head>

  <body>

    <div class="blog-masthead">
      <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <nav class="blog-nav">
                <a class="blog-nav-item active" href="/">{{ config('app.name', 'Laravel') }}</a>
                @foreach ($categorys as $k => $category)
                <a class="blog-nav-item" href="#">{{ $category->name }}</a>
                @endforeach
                {{--  <a class="blog-nav-item" href="#">关于我</a>  --}}
                </nav>
            </div>
            <div class="col-sm-4">
              <nav class="blog-nav text-right">
              @guest
                <a class="blog-nav-item" href="/login">登录</a>
              @endguest
              @auth
                <a class="blog-nav-item" href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
              @endauth
              </nav>
            </div>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="blog-header">
        {{--  <h1 class="blog-title">The Bootstrap Blog</h1>
        <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>  --}}
        <ol class="breadcrumb">
          <li><a href="/">首页</a></li>
          @section('breadcrumb')
          @show
        </ol>
      </div>
      

      <div class="row">

        <div class="col-sm-9 blog-main">
        <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
          @yield('content')
        </div><!-- /.blog-main -->

        <div class="col-sm-3 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            {{--  <h4>About</h4>  --}}
            <p>做一枚懂产品爱生活的技术</p>
          </div>
          <div class="sidebar-module">
            <h4>标签</h4>
              @foreach ($tags as $key => $scores)
              <span style="margin-bottom:4px;display:inline-block;"><a href="/tag/{{ $master[$key] }}" class="label tags-bg-{{ $master[$key] }}">{{ $master[$key] }} <span class="badge" style="padding:0px 3px;font-weight:100;">{{ $scores }}</span></a></span>
              @endforeach
          </div>
          <div class="sidebar-module">
            <h4>收藏</h4>
            <ol class="list-unstyled">
              <li><a href="https://github.com/" title="公用代码库" target="_blank">GitHub</a></li>
              <li><a href="http://www.bootcdn.cn/" title="公用CDN资源" target="_blank">免费 CDN资源</a></li>
              <li><a href="http://www.iconfont.cn/" title="大量在线图标库" target="_blank">iconFont</a></li>
              <li><a href="http://v3.bootcss.com/css/" title="CSS框架" target="_blank">Bootstrap</a></li>
              <li><a href="https://d.laravel-china.org/docs/5.5" title="全中文手册，翻译的不错" target="_blank">Laravel 中文手册</a></li>
              <li><a href="https://cs.laravel-china.org/" title="一个页面放了所有的Laravel命令，蛮实用，可惜版本不是最新的" target="_blank">Laravel 命令速查</a></li>
              <li><a href="https://github.com/phpredis/phpredis/" title="phpredis 手册" target="_blank">phpredis 文档</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>大神博客</h4>
            <ol class="list-unstyled">
              <li><a href="http://www.ruanyifeng.com/blog/" title="很厉害的一位大神" target="_blank">阮一峰的网络日志</a></li>
              <li><a href="http://rango.swoole.com/" title="Swoole..." target="_blank">韩天峰的博客</a></li>
              <li><a href="http://www.turbolinux.com.cn/turbo/wiki/doku.php" title="Linux 命令讲解" target="_blank">Linux Wiki</a></li>
              <li><a href="http://linuxwiki.github.io/" title="Linux 命令讲解" target="_blank">Linux 网络相关 Wiki</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>这里很骚气</h4>
            <ol class="list-unstyled">
              <li><a href="http://cv.jevon.cn/" title="孙巨文的站点" target="_blank">Jevon's Site</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <footer class="blog-footer">
      <p>技需勤以出神，艺唯思方入化。</p>
      <p>© 暮隼</p>
      <p>
        <a href="#">京ICP备15014247号-4</a>
      </p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/assets/js/ie10-viewport-bug-workaround.js"></script>

    <script src="/plugin/editor.md/lib/marked.min.js"></script>
    <script src="/plugin/editor.md/lib/prettify.min.js"></script>
    <script src="/plugin/editor.md/lib/raphael.min.js"></script>
    <script src="/plugin/editor.md/lib/underscore.min.js"></script>
    <script src="/plugin/editor.md/lib/sequence-diagram.min.js"></script>
    <script src="/plugin/editor.md/lib/flowchart.min.js"></script>
    <script src="/plugin/editor.md/lib/jquery.flowchart.min.js"></script>
    <script src="/plugin/editor.md/editormd.min.js"></script>
    <script type="text/javascript">
        var testEditor;
        $(function () {
            testEditor = editormd.markdownToHTML("doc-content", {//注意：这里是上面DIV的id
                htmlDecode: "style,script,iframe",
                emoji: true,
                taskList: true,
                tex: true, // 默认不解析
                flowChart: true, // 默认不解析
                sequenceDiagram: true, // 默认不解析
                codeFold: true,
        });});
    </script>
  </body>
</html>
