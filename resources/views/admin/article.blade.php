@extends('layouts.admin')

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endpush

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        文章
        <small>列表</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
        <li><a href="#">内容管理</a></li>
        <li class="active">文章列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    {{ csrf_field() }}
      <div class="row">
        <div id="main-div" class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">列表</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                  <input type="search" id="table_search" class="form-control pull-right" placeholder="搜索">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                  <a href="/admin/article/edit" class="btn btn-primary form-control pull-right">创建</a>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover" data-page-length='15'>
                <thead>
                <tr>
                  <th>ID</th>
                  <th>标题</th>
                  <th>状态</th>
                  <th>更新时间</th>
                  <th>入库时间</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($datas as $data)
                <tr>
                  <td>{{ $data->id }}</td>
                  <td><a href="/article/{{ $data->id }}" target="_blank">{{ $data->title }}</a> <span class="pull-right">@foreach ($data->tags as $k => $tag)<a href="#" class="label tags-bg-{{ $tag }}" style="margin-left:3px;">{{ $tag }}</a>@endforeach</span></td>
                  <td>@if ($data->status==1) <span class="label label-success">已发布</span> @else <span class="label label-default">草稿</span> @endif</td>
                  <td>{{ $data->uptime }}</td>
                  <td>{{ $data->intime }}</td>
                  <td class="col-sm-1">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                      <div class="btn-group" role="group">
                        <a href="/admin/article/edit/{{ $data->id }}" class="btn btn-default btn-xs">编辑</a>
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
                  <th>标题</th>
                  <th>状态</th>
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
<script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
$(function () {
  var table = $('#example2').DataTable({
    order         : [[ 0, "desc" ]],
    paging        : true,
    lengthChange  : false,
    ordering      : true,
    info          : true,
    pagingType    : "full_numbers",
    autoWidth     : false,
    dom           : "lrtip",
    fnInfoCallback: function( oSettings, iStart, iEnd, iMax, iTotal, sPre ) {
      return iStart +" ~ "+ iEnd+" 共 "+iTotal+" 条记录";
    },
    language      : {
        emptyTable: "<li class='text-danger' align='center'>没有数据</li>",
        paginate:
        {
            previous: "<",
            next: ">",
            first: "|<",
            last: ">|"
        }
    }
  });

  $('#table_search').on( 'keyup', function () {
    console.log(this.value);
    table.search( this.value ).draw();
  });
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
            url: "/admin/article/delete",
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
</script>
@endpush