@extends('layouts.base')
@section('title', '投稿確認')
@section('main')
<div class="container">
    <form action="{{route('postsuccess', ['threadId' => $thread->threadId])}}" method="post" enctype="multipart/form-data">
        @csrf
        <label>名前：</label><br>
        {{$name}}<br>
        <label>本文：</label><br>
        {!!nl2br(e($text))!!}<br>
        @isset($filename)
        <img src="{{asset('storage/tmp/'.$filename)}}"></img><br>
        @endisset
        <input class="btn btn-primary" type="submit" name="action" value="投稿"/>
    </form>
    <a href="{{route('thread', ['threadId' => $thread->threadId])}}">戻る</a><br>
    <a href="{{route('index')}}">トップページへ</a>
</div>
@endsection