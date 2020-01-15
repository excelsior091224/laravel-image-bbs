@extends('layouts.base')
@section('title', '投稿一覧')
@section('main')
<div>
    <a href="{{route('index')}}">トップページへ</a>
</div>
<hr>
@foreach($posts as $post)
<div id="thread">
    <p><a href="{{route('thread', ['threadId' => $post->thread->threadId])}}">{{$post->thread->threadName}}</a></p>
    <div id="post">
        <p>{{$post->noInThread}} : {{$post->name}} : {{$post->created_at}}</p>
        <p>{!!nl2br(e($post->text))!!}</p>
        @if($post->imageName !== NULL)
        <a href="{{asset('storage/img/'.$post->imageName)}}"><img src="{{asset('storage/img/'.$post->imageName)}}"></a>
        @endif
    </div>
</div>
<hr>
@endforeach
{{ $posts->links() }}<br>
<a href="{{route('index')}}">トップページへ</a>
@endsection