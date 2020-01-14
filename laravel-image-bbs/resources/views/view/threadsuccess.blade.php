@extends('layouts.base')
@section('title', 'スレッド作成完了')
@section('meta')
<meta http-equiv="refresh"content="5; url=/thread/{{$threadId}}">
@endsection
@section('main')
<div>
    @isset($result)
    <p>スレッドを作成しました。5秒後に作成したスレッドを表示します。</p>
    @else
    <p>スレッドの作成に失敗しました。</p>
    <a href="/index">トップへ</a>
    @endisset
</div>
@endsection