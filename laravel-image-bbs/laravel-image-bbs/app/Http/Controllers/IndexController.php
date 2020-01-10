<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    //
    public function test()
    {
        return view('view.test', [
            'msg'=>'テスト'
            ]);
    }
    
    public function index(Request $req)
    {
        $results = Thread::orderBy('last_posted', 'desc')->get();

        if ($req->session()->exists('errors')) {
            return view('view.index', [
                'errors'=> $req->session()->get('errors'),
                'threads' => $results
                ]);
        } else {
            return view('view.index',[
                'threads' => $results
                ]);
        }
    }
    
    public function confirm(Request $req)
    {
        $messages = [
            'threadname.required' => 'スレッド名が入力されていません。',
            'name.required' => '名前が入力されていません。',
            'text.required' => '本文が入力されていません。'
            ];
        
        $messages2 = [
            'imageFile.file' => 'アップロードされるのはファイルでなければいけません。',
            'imageFile.image' => 'アップロードするのは画像ファイルでなければいけません。',
            'imageFile.mimes' => '画像の形式はJPEGかPNGでなければいけません。'
            ];
        
        $validator = Validator::make($req->except('imageFile'), [
            'threadname' => 'required',
            'name' => 'required',
            'text' => 'required',
        ], $messages);
        
        if ($validator->fails()) {
            return redirect('/index')
            ->withErrors($validator)
            ->withInput();
        } else {
            $threadname = htmlspecialchars($req->threadname);
            $name = htmlspecialchars($req->name);
            $text = htmlspecialchars($req->text);
            
            $req->session()->put('threadname', $threadname);
            $req->session()->put('name', $name);
            $req->session()->put('text', $text);
            
            if ($req->hasFile('imageFile')) {
                $validator2 = Validator::make($req->only('imageFile'), [
                    'imageFile' => [
                        'file',
                        'image',
                        'mimes:jpeg,png'
                        ]], $messages2);
                
                if ($validator2->fails()) {
                    return redirect('/thread/'.$threadId)
                    ->withErrors($validator2)
                    ->withInput();
                    
                } else {
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
                }
            } else {
                return view('view.threadconfirm', [
                    'threadname'=>$threadname,
                    'name'=>$name,
                    'text'=>$text
                    ]);
            }
        }
        
        // $threadname = htmlspecialchars($req->threadname);
        // $name = htmlspecialchars($req->name);
        // $text = htmlspecialchars($req->text);
        // if ($threadname === '') {
        //     $errors['threadname'] = 'スレッド名が入力されていません。';
        // }
        // if ($name === '') {
        //     $errors['name'] = '名前が入力されていません。';
        // }
        // if ($text === '') {
        //     $errors['text'] = '本文が入力されていません。';
        // }
        // if (count($errors) === 0) {
        //     $req->session()->put('threadname', $threadname);
        //     $req->session()->put('name', $name);
        //     $req->session()->put('text', $text);
        //     return view('view.threadconfirm', [
        //         'threadname'=>$threadname,
        //         'name'=>$name,
        //         'text'=>$text
        //         ]);
        // } else {
        //     return redirect('index')
        //     ->withInput()
        //     ->with([
        //         'error1' => $errors['threadname'],
        //         'error2' => $errors['name'],
        //         'error3' => $errors['text']
        //         ]);
        // }
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
}
