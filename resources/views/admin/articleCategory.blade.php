@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        分类列表
        <small>文章类型</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="#">内容管理</a></li>
        <li class="active">文章分类</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">树形菜单</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
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
