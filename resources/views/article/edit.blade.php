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
          <div class="panel-body">
          </div>
        </div>
      </div>
      <!-- 右侧内容详情 -->
      <div class="col-md-9 col-lg-9 none-padding">
        <div class="panel panel-default">
            <div class="panel-heading">文章编辑</div>

            <div class="panel-body">
              <div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="blog-post"> 
                  <form>
                    <h2 class="blog-post-title"><input type="email" class="form-control" id="inputTitle" placeholder="请输入标题" value="{{ $article->title }}"></h2>
                    
                      <div class="row">
                        <div class="col-sm-8">
                          <p class="blog-post-meta">{{ $article->intime }} by <a href="#">{{ $article->category }}Mark</a></p>
                        </div>
                        <div class="col-sm-4 text-right">
                        @auth
                          <button type="submit" class="btn btn-default">
                              保存
                          </button>
                        @endauth
                        </div>
                      </div>

                    <p>{{ $article->description }}</p>
                    <hr>
                    <p>{{ $article->note }}</p>
                  </form>
                </div><!-- /.blog-post -->
              </div>
            </div>
        </div>
      </div>
    </div>
</div>
@endsection