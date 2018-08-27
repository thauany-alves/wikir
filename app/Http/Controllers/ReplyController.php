<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\User;
use App\Models\Post;

class ReplyController extends Controller{
    
    public function __construct(){
        
        $this->middleware('auth');
   	}

   	public function store(ReplyRequest $request,$post_id){
   		$user_id = auth()->user()->id;
   		$post = Post::find($request->post_id);
   		$reply = Reply::create([
   			'reply'		=> $request->reply,
   			'post_id' 	=> $post_id,
   			'user_id'	=> $user_id,
   		]);
   		if ($reply) {
   			$post->status = 'Respondido';
   			$post->save();
   		}
   		return redirect()->route('posts');
   	}

   	public function formEdit($id){
   		$reply = Reply::find($id);
   		$post = $reply->post;
   		return view('admin.edit_reply',compact('reply','post'));
   	}

   	public function update(ReplyRequest $request, $id){
   		$reply = Reply::find($id);
   		$reply->reply = $request->reply;
   		$reply->save();
   		return redirect()->route('posts');
   	}

   	public function delete($id){
   		$reply = Reply::find($id);
   		$post_id = $reply->post_id;
   		$del= $reply->delete();
   		if ($del) {
   			$post = Post::find($post_id);
   			$post->status = 'Aguardando resposta';
   			$post->save();
   		}
   		return redirect()->back();
   	}
}


