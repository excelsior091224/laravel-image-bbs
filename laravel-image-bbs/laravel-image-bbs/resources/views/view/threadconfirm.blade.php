@extends('layouts.base')
@section('title', 'スレッド作成確認')
@section('main')
<div>
    <form class="form-group" action="/index/success" method="post">
        @csrf
        <label>スレッド名：</label><br>
        {{$threadname}}<br>
        <label>名前：</label><br>
        {{$name}}<br>
        <label>本文：</label><br>
        {!!nl2br(e($text))!!}<br>
        @isset($filename)
        <img src="{{asset('storage/tmp/'.$filename)}}"></img><br>
        @endisset
        <input class="btn btn-primary" type="submit" name="submit" value="スレッド作成"/>
    </form>
    <a href="/index">戻る</a>
</div>
@endsection