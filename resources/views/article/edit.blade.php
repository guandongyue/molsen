@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <!-- 左侧分类列表 -->
      <div class="col-md-1 col-lg-1 none-padding">
        <div class="panel panel-default">
          <div class="panel-heading">
            <a id="div-category" class="btn btn-link btn-xs" style="line-height: 1.4;text-decoration: none;">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 文集
            </a>
          </div>
          <div class="panel-body none-padding">
            <div id="category-list" class="list-group">
              <input id="inputCategory" style="display: none;" type="text" class="list-group-item form-control" placeholder="请输入文集名...">
              <div id="div-button" style="display: none;" class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group">
                  <button id="button-category-save" type="button" class="btn btn-primary">保存</button>
                </div>
                <div class="btn-group">
                  <button id="button-category-cancel" type="button" class="btn btn-default">取消</button>
                </div>
              </div>
            @foreach ($categorys as $k => $category)
              <a href="#" class="list-group-item @if ($k==$article->category) active @endif" style="margin:-1px;">{{ $category }}</a>
            @endforeach
            </div>
          </div>
        </div>
      </div>
      <!-- 中间标题列表 -->
      <div class="col-md-2 col-lg-2 none-padding">
        <div class="panel panel-default">
          <div class="panel-heading">
            <a class="btn btn-link btn-xs" style="line-height: 1.4;text-decoration: none;">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 文章
            </a>
          </div>
          <div class="panel-body none-padding">
            @foreach ($articles as $k => $arti)
              <a href="/article/edit/{{ $arti->id }}" class="list-group-item @if ($arti->id==$article->id) active @endif" style="margin:-1px;">{{ $arti->title }}</a>
            @endforeach
          </div>
        </div>
      </div>
      <!-- 右侧内容详情 -->
      <div class="col-md-9 col-lg-9 none-padding">
        <form method="POST" action="/article/edit">
          {{ csrf_field() }}
          <div class="panel panel-default">
              <div id="article-post-header" class="panel-heading bg-success">
                <div class="row">
                  <div class="col-md-9 col-lg-9">文章编辑</div>
                  <div class="col-md-3 col-lg-3 text-right">
                    <button id="button-article-save" type="button" class="btn btn-default btn-xs" style="line-height: 1.4;">保存</button>
                    <button id="button-article-publish" type="button" class="btn btn-primary btn-xs" style="line-height: 1.4;">发布</button>
                  </div>
                </div>
              </div>
              <div class="panel-body">
                <div>
                  <div class="blog-post"> 
                    <h2 class="blog-post-title">
                      <input type="text" class="form-control" id="articleFormTitle" placeholder="请输入标题" value="{{ $article->title }}">
                    </h2>
                    <p>{{ $article->description }}</p>
                    <p>
                      <div id="test-editormd">
                        <textarea id="articleFormNote" style="display:none;">{{ $article->note }}</textarea>
                      </div>
                    </p>
                  </div><!-- /.blog-post -->
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection