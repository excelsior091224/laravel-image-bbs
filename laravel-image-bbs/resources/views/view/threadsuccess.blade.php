@extends('layouts.base')
@section('title', 'スレッド作成完了')
@section('main')
<div>
    @isset($result)
    <p>スレッドを作成しました。</p>
    <a href="/thread/{{$threadId}}">{{$threadName}}</a><br>
    <a href="/index">トップへ</a>
    @else
    <p>スレッドの作成に失敗しました。</p>
    <a href="/index">トップへ</a>
    @endisset
</div>
@endsection