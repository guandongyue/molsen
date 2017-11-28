@extends('layouts.admin')

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endpush

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        系统设置
        <small>Master配置</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="#">系统设置</a></li>
        <li class="active">Master配置</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    {{ csrf_field() }}
      <div class="row">
        <div class="col-xs-2">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">树形菜单</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <div id="treeview" class=""></div>
                  <a href="/admin/master/edit" class="btn btn-block btn-default">
                    <i class="fa fa-plus"></i> <span>创建</span>
                  </a>
                </div>
            </div>
        </div>
        <div id="main-div" class="col-xs-10">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">详细列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>PID</th>
                  <th>名称</th>
                  <th>KEY</th>
                  <th>VALUE</th>
                  <th>更新时间</th>
                  <th>入库时间</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($datas as $data)
                <tr>
                  <td>{{ $data->id }}</td>
                  <td>{{ $data->pid }}</td>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->key }}</td>
                  <td>{{ $data->value }}</td>
                  <td>{{ $data->uptime }}</td>
                  <td>{{ $data->intime }}</td>
                  <td class="col-sm-1">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <a href="/admin/master/edit/{{ $data->id }}" class="btn btn-default btn-xs">编辑</a>
                      </div>
                      <div class="btn-group" role="group">
                      {{--   data-toggle="modal" data-target="#modal-danger"   --}}
                        <a href="#" data-id="{{ $data->id }}" data-title="{{ $data->name }}" class="deleteMaster btn btn-danger btn-xs">删除</a>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>PID</th>
                  <th>名称</th>
                  <th>KEY</th>
                  <th>VALUE</th>
                  <th>更新时间</th>
                  <th>入库时间</th>
                  <th>操作</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<!-- DataTables -->
<script src="/js/bootstrap-treeview.js"></script>
<script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
  $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
  })
});

$(".deleteMaster").click(function(){
  var delID = $(this).attr('data-id');
  $.confirm({
    title: '注意！',
    content: '确认要删除【'+$(this).attr('data-title')+'】吗？',
    buttons: {
      confirm: {
        text: '确认',
        btnClass: 'btn-danger',
        keys: ['enter'],
        action: function(){
          $.ajax({
            method: "POST",
            url: "/admin/master/delete",
            data: { 
              id: delID,
              _token: $("input[name='_token']").val() 
            }
          }).done(function( msg ) {
            if (msg.status==1) {
              molsen.alert("#main-div", 'success', msg.msg, function(){
                window.location.reload();
              });
            } else {
              molsen.alert("#main-div", 'danger', msg.msg);
            }
          });
        }
      },
      cancel: {
        text: '取消',
        keys: ['esc'],
        action: function(){
        }
      }
    }
  });
});

$('#treeview').treeview({
  levels: 1,
  showTags: true,
  enableLinks: true,
  data: '@json($tree)'
});
</script>
@endpush