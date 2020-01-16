<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $req)
    {
        if($req->session()->get('filename'))
        {
            Storage::delete('public/tmp/'.$req->session()->get('filename'));
            $req->session()->forget('filename');
        }
        
        $results = Thread::orderBy('last_posted', 'desc')->get();

        return view('view.index',[
            'threads' => $results
            ]);
    }
    
    public function confirm(Request $req)
    {
        $validator = $req->validate([
            'threadname' => 'required',
            'name' => 'required',
            'text' => 'required',
            'imageFile' => 'nullable|file|image|mimes:jpeg,png'
        ], [
            'threadname.required' => 'スレッド名が入力されていません。',
            'name.required' => '名前が入力されていません。',
            'text.required' => '本文が入力されていません。',
            'imageFile.file' => 'アップロードされるのはファイルでなければいけません。',
            'imageFile.image' => 'アップロードするのは画像ファイルでなければいけません。',
            'imageFile.mimes' => '画像の形式はJPEGかPNGでなければいけません。'
            ]);
        
        $threadname = htmlspecialchars($req->threadname);
        $name = htmlspecialchars($req->name);
        $text = htmlspecialchars($req->text);
        
        $req->session()->put('threadname', $threadname);
        $req->session()->put('name', $name);
        $req->session()->put('text', $text);
        
        if ($req->hasFile('imageFile')) {
            if ($req->file('imageFile')->isValid()) {
            $path = $req->imageFile->store('public/tmp');
            $filename = basename($path);
            $req->session()->put('filename', $filename);
            return view('view.threadconfirm', [
                'threadname'=>$threadname,
                'name'=>$name,
                'text'=>$text,
                'filename'=>$filename
                ]);
            }
        } else {
            return view('view.threadconfirm', [
                'threadname'=>$threadname,
                'name'=>$name,
                'text'=>$text
                ]);
        }
    }

    public function success(Request $req)
    {
        $threadname = $req->session()->pull('threadname','');
        $name = $req->session()->pull('name','');
        $text = $req->session()->pull('text','');
        if ($req->session()->get('filename')) {
            $filename = $req->session()->pull('filename','');
        }
        $now = Carbon::now();
        $datetime = $now->format('Y-m-d H:i:s');
        $threadid = $now->format('YmdHis');
        
        $t = new Thread();
        $t->fill(['threadId' => $threadid]);
        $t->fill(['threadName' => $threadname]);
        $t->fill(['last_posted' => $datetime]);
        $t->save();
        
        $p = new Post();
        $p->fill(['threadId' => $threadid]);
        $p->fill(['noInThread' => 1]);
        $p->fill(['name' => $name]);
        $p->fill(['text' => $text]);
        if (isset($filename)) {
            $p->fill(['imageName' => $filename]);
        }
        $p->save();
        
        if (isset($filename)) {
            Storage::move('public/tmp/'.$filename, 'public/img/'.$filename);
        }
        
        return view('view.threadsuccess', [
            'result'=>1,
            'threadId'=>$threadid,
            'threadName'=>$threadname
            ]);
    }
    
    public function listofposts()
    {
        $results = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('view.listofposts', [
            'posts' => $results
            ]);
    }
}
