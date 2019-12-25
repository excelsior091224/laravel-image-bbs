@extends('layouts.base')
@section('title', '投稿完了')
@section('main')
<div>
    @isset($result)
    <p>投稿が完了しました。</p>
    <a href="/thread/{{$threadId}}">{{$threadName}}</a><br>
    <a href="/index">トップへ</a>
    @else
    <p>スレッドの作成に失敗しました。</p>
    <a href="/index">トップへ</a>
    @endisset
</div>
@endsection