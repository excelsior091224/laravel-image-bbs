@extends('layouts.base')
@section('title', 'トップページ')
@section('main')
<div class="container">
    @if(session('error1'))
    <p>{{session('error1')}}</p>
    @endif
    @if(session('error2'))
    <p>{{session('error2')}}</p>
    @endif
    @if(session('error3'))
    <p>{{session('error3')}}</p>
    @endif
    <form class="col-sm" action="/index/confirm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group col-sm">
            <label for="threadname">スレッド名：</label>
            <input type="text" name="threadname" class="form-control" id="threadname" value="{{old('threadname', '')}}"/>
        </div>
        <div class="form-group col-sm">
            <label for="name">名前：</label>
            <input type="text" name="name" class="form-control" id="name" value="{{old('name', '')}}">
        </div>
        <div class="form-group col-sm">
            <label for="text">本文：</label>
            <textarea name="text" id="text" class="form-control" maxlength="200">{{old('text', '')}}</textarea>
        </div>
        <div class="form-group col-sm">
            <label for="imageFile">画像（JPEGかPNGのみ）：</label>
            <input type="file" name="imageFile" id="imageFile" class="form-control" value=""/>
        </div>
        <input class="btn btn-primary" type="submit" name="submit" value="送信"/>
    </form>
</div>
<div>
    @foreach($threads as $thread)
    <p><a href="/thread/{{$thread->threadId}}">{{$thread->threadName}}</a> : {{$thread->last_posted}}</p>
    @endforeach
</div>
@endsection