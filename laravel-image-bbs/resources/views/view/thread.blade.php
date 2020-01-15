@extends('layouts.base')
@section('title', $thread->threadName)
@section('main')
<div class="container">
    <div id="thread">
        <h2>{{$thread->threadName}}</h2>
        @foreach($thread->posts as $post)
        <div id="post">
            <p>{{$post->noInThread}} : {{$post->name}} : {{$post->created_at}}</p>
            <p>{!!nl2br(e($post->text))!!}</p>
            @if($post->imageName !== NULL)
            <a href="{{asset('storage/img/'.$post->imageName)}}"><img src="{{asset('storage/img/'.$post->imageName)}}"></a>
            @endif
        </div>
        @endforeach
    </div>
    <div id="form">
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
        <form class="form-group" action="/thread/{{$thread->threadId}}/confirm" method="post" enctype="multipart/form-data">
            @csrf
            <label>名前：</label><br>
            <input type="text" name="name" value="{{old('name', '')}}"><br>
            <label>本文：</label><br>
            <textarea name="text" maxlength="200">{{old('text', '')}}</textarea><br>
            <label>画像（JPEGかPNGのみ）：</label><br>
            <input type="file" name="imageFile" value=""/><br>
            <input class="btn btn-primary" type="submit" name="submit" value="送信"/>
        </form>
    </div>
    <a href="/index">トップページへ</a>
</div>
@endsection