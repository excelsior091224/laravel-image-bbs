@extends('layouts.base')
@section('title', '投稿完了')
@section('meta')
<meta http-equiv="refresh"content="5; url={{route('thread', ['threadId' => $threadId])}}">
@endsection
@section('main')
<div>
    @isset($result)
    <p>投稿が完了しました。5秒後にスレッドに戻ります。</p>
    @else
    <p>投稿に失敗しました。</p>
    <a href="{{route('index')}}">トップへ</a>
    @endisset
</div>
@endsection