@extends('layouts.admin')

@push('css')
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
        <!-- left column -->
        <div id="main-div" class="col-md-12">
          
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">创建</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form id="myForm" class="form-horizontal" method="POST" action="/admin/master/save">
            <input type="hidden" name="editId" value="@isset($records){{ $data->id }}@endisset">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">所属上级</label>
                  <div class="col-sm-10">
                    <select name="pid" class="form-control">
                    @foreach ($datas as $master)
                        <option value="{{ $master->id }}">{{ $master->name }}</option>
                    @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">名称</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="请输入一个配置名称...">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">KEY</label>
                  <div class="col-sm-10">
                    <input type="text" name="key" class="form-control" placeholder="请输入一个key...">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">VALUE</label>
                  <div class="col-sm-10">
                    <input type="text" name="value" class="form-control" placeholder="请输入一个value...">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="hidden"></button>
                <a class="btn btn-default" href="/admin/master/list">取消</a>
                <button type="button" id="button-save" data-toggle="modal" data-target="#modal-default" class="btn btn-primary">保存</button>
                <button type="button" id="button-save-continue" class="btn btn-info">保存并继续</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>

        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
<script>
$("button[type='reset']").trigger("click");

$("#button-save").click(function(){
  $("#button-save").addClass('disabled');
  $("#button-save-continue").addClass('disabled');
  $.ajax({
    method: "POST",
    url: "/admin/master/save",
    data: { 
      pid: $("select[name='pid'] option:selected").val(),
      name: $("input[name='name']").val(), 
      key: $("input[name='key']").val(), 
      value: $("input[name='value']").val(), 
      _token: $("input[name='_token']").val() 
    }
  }).done(function( msg ) {
    if (msg.status==1) {
      molsen.alert("#main-div", 'success', msg.msg);
      window.location.href = "/admin/master/list";
    } else {
      molsen.alert("#main-div", 'danger', msg.msg);
      $("#button-save").removeClass('disabled');
      $("#button-save-continue").removeClass('disabled');
    }
  });
});

$("#button-save-continue").click(function(){
  $("#button-save").addClass('disabled');
  $("#button-save-continue").addClass('disabled');
  $.ajax({
    method: "POST",
    url: "/admin/master/save",
    data: { 
      pid: $("select[name='pid'] option:selected").val(),
      name: $("input[name='name']").val(), 
      key: $("input[name='key']").val(), 
      value: $("input[name='value']").val(), 
      _token: $("input[name='_token']").val() 
    }
  }).done(function( msg ) {
    $("#button-save").removeClass('disabled');
    $("#button-save-continue").removeClass('disabled');
    if (msg.status==1) {
      molsen.alert("#main-div", 'success', msg.msg);
      $("#myForm")[0].reset();
    } else {
      molsen.alert("#main-div", 'danger', msg.msg);
    }
  });
});
</script>
@endpush