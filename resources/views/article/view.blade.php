@extends('layouts.blog')

@section('content')

        <div class="blog-post"> 
          <h2 class="blog-post-title">{{ $article->title }}</h2>
          
          <div class="row">
            <div class="col-sm-8">
              <p class="blog-post-meta">{{ $article->intime }} by <a href="#">Mark</a></p>
            </div>
            <div class="col-sm-4 text-right">
            @auth
              <a class="btn btn-default" href="/article/edit/{{ $article->id }}" role="button">编辑</a>
            @endauth
            </div>
          </div>

          <p>{{ $article->description }}</p>
          <hr>
          <div id="doc-content" class="none-padding">
            <textarea style="display:none;">{{ $article->note }}</textarea>
          </div>
        </div><!-- /.blog-post -->

@endsection
