@extends('layouts.admin')

@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="/adminlte/bower_components/select2/dist/css/select2.min.css">
<link href="/plugin/editor.md/css/editormd.css" rel="stylesheet" />
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
      <div class="row">
        <!-- left column -->
        <div id="main-div" class="col-md-12">
          
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">创建</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <input type="hidden" name="editId" value="@isset($data){{ $data->id }}@endisset">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  {{--  <label class="col-sm-2 control-label">标签</label>  --}}
                  <div class="col-sm-12">
                    <select name="tags" id="form-tags" class="form-control select2" multiple="multiple" data-placeholder="选择一个标签" style="width: 100%;">
                      @foreach ($tags as $child)
                      <option value="{{ $child->id }}" @if (in_array($child->id, $data->tags)) selected="selected" @endif>{{ $child->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  {{--  <label class="col-sm-2 control-label">标题</label>  --}}
                  <div class="col-sm-12">
                    <input type="text" name="title" value="{{ $data->title }}" class="form-control" placeholder="请输入标题...">
                  </div>
                </div>

                <div class="form-group">
                  {{--  <label class="col-sm-2 control-label">内容</label>  --}}
                  <div class="col-sm-12">
                    <div id="test-editormd">
                      <textarea id="articleFormNote" style="display:none;">{{ $data->note }}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a class="btn btn-default" href="/admin/article/list">取消</a>
                <button type="button" id="button-save" data-toggle="modal" data-target="#modal-default" class="btn btn-primary">保存</button>
                <button type="button" id="button-save-continue" class="btn btn-info">保存并继续</button>
              </div>
              <!-- /.box-footer -->
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
    });
</script>

<script>
var results = [];

$("#button-save").click(function(){
  $("#button-save").addClass('disabled');
  $("#button-save-continue").addClass('disabled');
  $.ajax({
    method: "POST",
    url: "/admin/article/save",
    data: { 
      editId: $("input[name='editId']").val(), 
      title: $("input[name='title']").val(), 
      note: $("#articleFormNote").val(), 
      tags: $('#form-tags').val().toString(), 
      _token: $("input[name='_token']").val(), 
      status:1
    }
  }).done(function( msg ) {
    if (msg.status==1) {
      molsen.alert("#main-div", 'success', msg.msg, function(){
        window.location.href = "/admin/article/list";
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
    url: "/admin/article/save",
    data: { 
      editId: $("input[name='editId']").val(), 
      title: $("input[name='title']").val(), 
      note: $("#articleFormNote").val(), 
      tags: $('#form-tags').val().toString(), 
      _token: $("input[name='_token']").val(), 
      status:1
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

$(function () {
  //Initialize Select2 Elements
  $('.select2').select2();
})
</script>
@endpush