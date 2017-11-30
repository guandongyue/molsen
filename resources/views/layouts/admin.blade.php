<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }} | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
  
  @stack('css')
  
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/adminlte/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="/css/jquery-confirm.min.css">
  <!-- Molsen's CSS -->
  <link rel="stylesheet" href="/css/admin.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  @include('admin.header')

  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Molsen</b> 1.0
    </div>
    <strong>Copyright &copy; 2014-2017 <a href="https://guandongyue.com">Molsen</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  @include('admin.control-sidebar')
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/adminlte/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
{{--  <script src="/adminlte/bower_components/fastclick/lib/fastclick.js"></script>  --}}
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--  <script src="/adminlte/dist/js/pages/dashboard.js"></script>  --}}
<!-- AdminLTE for demo purposes -->
{{--  <script src="/adminlte/dist/js/demo.js"></script>  --}}

<script src="/js/jquery-confirm.min.js"></script>
<script src="/js/admin.js"></script>

@stack('scripts')

</body>
</html>
