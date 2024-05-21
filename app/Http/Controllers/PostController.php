<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewPostEmail;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function search($term){
        // return Post::where('title', 'like', '%'.$term.'%')->get();
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
    public function showCreateForm(){
        // if(!auth()->check()) {
        //     return redirect('/');
        // }
        return view('create-post');
    }

    public function createPost(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

       $newPost = Post::create($incomingFields);

        dispatch(new SendNewPostEmail([
            'sendTo' => auth()->user()->email,
            'name' => auth()->user()->username,
            'title' => $newPost->title,
        ]));

      
        return redirect("/post/{$newPost->id}")->with('success', 'New post created');
    }

    public function createPostApi(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

       $newPost = Post::create($incomingFields);

        dispatch(new SendNewPostEmail([
            'sendTo' => auth()->user()->email,
            'name' => auth()->user()->username,
            'title' => $newPost->title,
        ]));

      
        return $newPost->id;
    }

    public function viewSinglePost(Post $post){     
        $post['body'] = strip_tags(Str::markdown($post->body), '<p><ul><li><strong><em><h3><br>');
        return view('single-post', ['post'=>$post]);
    }

    public function delete(Post $post){
    //    if( auth()->user()->cannot('delete', $post)){
    //         return 'You cannot do that';
    //    }
       $post->delete();
       return redirect('/profile/' . auth()->user()->username)->with('success', 'Post deleted!');
    }

    public function deletePostApi(Post $post){
        //    if( auth()->user()->cannot('delete', $post)){
        //         return 'You cannot do that';
        //    }
           $post->delete();
           return 'true';
        }

  public function showEditForm(Post $post){
    return view('edit-post', ['post' => $post]);
    }

    public function update(Post $post, Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required'
        ]);
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return back()->with('success', 'Post succesfully updated');
    }

}
