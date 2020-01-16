<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ThreadController extends Controller
{
    //
    public function thread($threadId, Request $req)
    {
        if($req->session()->get('filename'))
        {
            Storage::delete('public/tmp/'.$req->session()->get('filename'));
            $req->session()->forget('filename');
        }
        
        $result = Thread::where('threadId',$threadId)->first();
        return view('view.thread',[
            'thread' => $result
            ]);
    }
    
    public function confirm($threadId, Request $req)
    {
        $result = Thread::where('threadId',$threadId)->first();
        $errors = array();
        
        $messages = [
            'name.required' => '名前が入力されていません。',
            'text.required' => '本文が入力されていません。'
            ];
        
        $messages2 = [
            'imageFile.file' => 'アップロードされるのはファイルでなければいけません。',
            'imageFile.image' => 'アップロードするのは画像ファイルでなければいけません。',
            'imageFile.mimes' => '画像の形式はJPEGかPNGでなければいけません。'
            ];
        
        $validator = $req->validate([
            'name' => 'required',
            'text' => 'required',
            'imageFile' => 'nullable|file|image|mimes:jpeg,png'
        ], [
            'name.required' => '名前が入力されていません。',
            'text.required' => '本文が入力されていません。',
            'imageFile.file' => 'アップロードされるのはファイルでなければいけません。',
            'imageFile.image' => 'アップロードするのは画像ファイルでなければいけません。',
            'imageFile.mimes' => '画像の形式はJPEGかPNGでなければいけません。'
            ]);
        
        $name = htmlspecialchars($req->name);
        $text = htmlspecialchars($req->text);
        $req->session()->put('name', $name);
        $req->session()->put('text', $text);
        
        if ($req->hasFile('imageFile')) {
            $path = $req->imageFile->store('public/tmp');
            $filename = basename($path);
            $req->session()->put('filename', $filename);
            return view('view.postconfirm', [
                'thread' => $result,
                'name'=>$name,
                'text'=>$text,
                'filename'=>$filename
                ]);
        } else {
            return view('view.postconfirm', [
                'thread' => $result,
                'name'=>$name,
                'text'=>$text
                ]);
        }
    }
    
    public function success($threadId, Request $req)
    {
        $result = Thread::where('threadId',$threadId)->first();
        $threadname = $result['threadName'];
        $name = $req->session()->pull('name','');
        $text = $req->session()->pull('text','');
        if ($req->session()->get('filename')) {
            $filename = $req->session()->pull('filename','');
        }
        $now = Carbon::now();
        $datetime = $now->format('Y-m-d H:i:s');
        
        $postno = Post::where('threadId',$threadId)->count();
        $no = $postno + 1;
        
        $p = new Post();
        $p->fill(['threadId' => $threadId]);
        $p->fill(['noInThread' => $no]);
        $p->fill(['name' => $name]);
        $p->fill(['text' => $text]);
        if (isset($filename)) {
            $p->fill(['imageName' => $filename]);
        }
        $p->save();
        
        if (isset($filename)) {
            Storage::move('public/tmp/'.$filename, 'public/img/'.$filename);
        }
        
        Thread::where('threadId',$threadId)->update(['last_posted' => $datetime]);
        
        return view('view.postsuccess', [
            'result'=>1,
            'threadId'=>$threadId,
            'threadName'=>$threadname,
            ]);
    }
}
