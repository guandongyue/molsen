@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-1 col-lg-1 none-padding">
        <div class="panel panel-default">
          <div class="panel-heading"><a><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 文集</a></div>
          <div class="panel-body">
          </div>
        </div>
      </div>
      <div class="col-md-2 col-lg-2">
        <div class="panel panel-default">
          <div class="panel-heading"><a><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 文章</a></div>
          <div class="panel-body">
          </div>
        </div>
      </div>
      <div class="col-md-9 col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading">Article Edit</div>

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
                          <p class="blog-post-meta">{{ $article->intime }} by <a href="#">Mark</a></p>
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