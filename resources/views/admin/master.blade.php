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
      <div class="row">
        <div class="col-xs-2">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">树形菜单</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <ul class="molsen-tree-menu" data-widget="tree">
                    <li class="treeview">
                      <a href="#">
                        <i class="fa fa-bars"></i> <span>Multilevel</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                        <li class="treeview">
                          <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                          <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li class="treeview">
                              <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                              </ul>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                      </ul>
                    </li>
                    <li>
                      <a href="/admin/master/edit" class="btn btn-block btn-default">
                        <i class="fa fa-plus"></i> <span>创建</span>
                      </a>
                    </li>
                  </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-10">
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
  })
</script>
@endpush