@extends('layouts.admin')

@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="/adminlte/bower_components/select2/dist/css/select2.min.css">
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
            <input type="hidden" name="editId" value="@isset($data){{ $data->id }}@endisset">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Minimal</label>
                  <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;">
                      <option selected="selected"> -- 请选择 -- </option>
                      @foreach ($tree as $child)
                      <option value="{{ $child->id }}">{{ str_repeat('-', $child->level*2) }}{{ $child->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  {{--  <label class="col-sm-2 control-label">所属上级</label>
                  <div class="col-sm-10">
                    <div class="dropdown">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        根分类
                        <span class="caret"></span>
                      </button>
                      <ul id="treeview" class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      </ul>
                    </div>
                  </div>  --}}
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">名称</label>
                  <div class="col-sm-10">
                    <input type="text" name="name" value="{{ $data->name }}" class="form-control" placeholder="请输入一个配置名称...">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">KEY</label>
                  <div class="col-sm-10">
                    <input type="text" name="key" value="{{ $data->key }}" class="form-control" placeholder="请输入一个key...">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">VALUE</label>
                  <div class="col-sm-10">
                    <input type="text" name="value" value="{{ $data->value }}" class="form-control" placeholder="请输入一个value...">
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
<script src="/js/bootstrap-treeview.js"></script>
<!-- Select2 -->
<script src="/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$("button[type='reset']").trigger("click");

$("#button-save").click(function(){
  $("#button-save").addClass('disabled');
  $("#button-save-continue").addClass('disabled');
  $.ajax({
    method: "POST",
    url: "/admin/master/save",
    data: { 
      editId: $("input[name='editId']").val(), 
      pid: $("select[name='pid'] option:selected").val(),
      name: $("input[name='name']").val(), 
      key: $("input[name='key']").val(), 
      value: $("input[name='value']").val(), 
      _token: $("input[name='_token']").val() 
    }
  }).done(function( msg ) {
    if (msg.status==1) {
      molsen.alert("#main-div", 'success', msg.msg, function(){
        window.location.href = "/admin/master/list";
      });
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
      editId: $("input[name='editId']").val(), 
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
      molsen.alert("#main-div", 'success', msg.msg, function(){
        window.location.reload();
      });
    } else {
      molsen.alert("#main-div", 'danger', msg.msg);
    }
  });
});


var initSelectableTree = function() {
  return $('#treeview').treeview({
    levels: 99,
    data: '@json($tree)',
    onNodeSelected: function(event, node) {
      console.log(node.text + ' was selected');
    },
    onNodeUnselected: function (event, node) {
      console.log(node.text + ' was unselected');
    }
  });
};
var $selectableTree = initSelectableTree();



$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()
})
</script>
</script>
@endpush