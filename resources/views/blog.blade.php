@extends('layouts.blog')

{{--  需要有 @parent 标签，才会继承父页面的内容，否则直接覆盖  --}}
@section('breadcrumb')
@stop

@section('content')

        @foreach ($articles as $article)
          <div class="blog-post"> 
            <h2 class="blog-post-title"><a href="/article/{{ $article->id }}">{{ $article->title }}</a></h2>
            <p class="blog-post-meta">{{ $article->intime }} | @foreach ($article->tags as $k => $tag)<a href="#" class="label tags-bg-{{ $tag }}" style="margin-left:3px;">{{ $tag }}</a>@endforeach</p>

            {{--  <p>{{ $article->description }}</p>  --}}
            <hr>
            <p>{{ $article->description }}</p>
          </div><!-- /.blog-post -->
        @endforeach

          {{ $articles->links() }}

@endsection
