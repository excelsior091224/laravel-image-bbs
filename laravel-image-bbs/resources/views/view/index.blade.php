@extends('layouts.base')
@section('title', 'トップページ')
@section('main')
<div>
    <p><a href="{{route('listofposts')}}">投稿一覧</a></p>
    <hr>
    <div id="form">
        <h5>スレッド作成</h5>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
        <form class="col-sm" action="{{route('threadconfirm')}}" method="post" enctype="multipart/form-data">
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
            <a href="{{route('thread', ['threadId' => $thread->threadId])}}">{{$thread->threadName}}</a> : {{$thread->last_posted}}
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