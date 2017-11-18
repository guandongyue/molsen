@extends('layouts.blog')

@section('content')

        @foreach ($articles as $article)
          <div class="blog-post"> 
            <h2 class="blog-post-title"><a href="/article/{{ $article->id }}">{{ $article->title }}</a></h2>
            <p class="blog-post-meta">{{ $article->intime }} by <a href="#">Mark</a></p>

            {{--  <p>{{ $article->description }}</p>  --}}
            <hr>
            <p>{{ $article->description }}</p>
          </div><!-- /.blog-post -->
        @endforeach

@endsection
