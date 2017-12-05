@extends('layouts.blog')

@section('content')

<div class="blog-post"> 
  <h2 class="blog-post-title">{{ $article->title }}</h2>
  
  <div class="row">
    <div class="col-sm-8">
      <p class="blog-post-meta">{{ $article->intime }} | @foreach ($tags as $k => $tag)<a href="#" class="label tags-bg-{{ $tag }}" style="margin-left:3px;">{{ $tag }}</a>@endforeach</p>
    </div>
    <div class="col-sm-4 text-right">
    @auth
      <a class="btn btn-default" href="/admin/article/edit/{{ $article->id }}" role="button">编辑</a>
    @endauth
    @guest
      <p class="blog-post-meta">Visit：{{ $article->getVisitor() }}</p>
    @endguest
    </div>
  </div>

  <p>{{ $article->description }}</p>
  <hr>
  <div id="doc-content" class="none-padding">
    <textarea style="display:none;">{{ $article->note }}</textarea>
  </div>
</div><!-- /.blog-post -->

@endsection
