@extends('layouts.base')
@section('title', 'トップページ')
@section('main')
<div>
    <p><a href="index/listofposts">投稿一覧</a></p>
    <hr>
    <div id="form">
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
</div>
<div>
    @foreach($threads as $thread)
    <div id="thread">
        <h5>
            <a href="/thread/{{$thread->threadId}}">{{$thread->threadName}}</a> : {{$thread->last_posted}}
        </h5>
        @if (count($thread->posts) > 6)
        <div id="post">
            <p>{{$thread->posts[0]->noInThread}} : {{$thread->posts[0]->name}} : {{$thread->posts[0]->created_at}}</p>
            <p>{!!nl2br(e($thread->posts[0]->text))!!}</p>
            @if($thread->posts[0]->imageName !== NULL)
            <a href="{{asset('storage/img/'.$thread->posts[0]->imageName)}}"><img src="{{asset('storage/img/'.$thread->posts[0]->imageName)}}"></a>
            @endif
        </div>
        @for ($i = 5; $i > 0; $i--)
        <div id="post">
            <p>{{$thread->posts[count($thread->posts) - $i]->noInThread}} : {{$thread->posts[count($thread->posts) - $i]->name}} : {{$thread->posts[count($thread->posts) - $i]->created_at}}</p>
            <p>{!!nl2br(e($thread->posts[count($thread->posts) - $i]->text))!!}</p>
            @if($thread->posts[count($thread->posts) - $i]->imageName !== NULL)
            <a href="{{asset('storage/img/'.$thread->posts[count($thread->posts) - $i]->imageName)}}"><img src="{{asset('storage/img/'.$thread->posts[count($thread->posts) - $i]->imageName)}}"></a>
            @endif
        </div>
        @endfor
        @else
        @foreach($thread->posts as $post)
        <div id="post">
            <p>{{$post->noInThread}} : {{$post->name}} : {{$post->created_at}}</p>
            <p>{!!nl2br(e($post->text))!!}</p>
            @if($post->imageName !== NULL)
            <a href="{{asset('storage/img/'.$post->imageName)}}"><img src="{{asset('storage/img/'.$post->imageName)}}"></a>
            @endif
        </div>
        @endforeach
        @endif
    </div>
    @endforeach
</div>
@endsection