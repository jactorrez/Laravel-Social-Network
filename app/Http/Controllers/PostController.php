<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Auth;
use App\Http\Requests;

class PostController extends Controller
{

   public function getDashboard()
   {
   		$posts = Post::orderBy('created_at','desc')->get();

		return view('dashboard', compact('posts'));
   }

    public function storePost(Request $request)
    {

    	$this->validate($request, [
    		'body' => 'required|max:1000',
    	]);

    	$post = new Post();
    	$post->body = $request->body;
    	$message = "Something went wrong, try again";
    	if($request->user()->posts()->save($post)){
    		$message = "Your post has been created!";
    	}

    	return redirect('dashboard')->withMessage($message);
    }

    public function deletePost($id)
    {
    	$post = Post::findOrFail($id);

    	if($post->user != Auth::user())
    	{
    		return back()->withMessage("Sorry, you're not authorized to do that"); 
    	}
    	else{

    	}

    	$post->delete();
    	return redirect('dashboard')->withMessage("Your post has been deleted!");
    }


    public function editPost(Request $request)
    {

    	$this->validate($request, [
    		'body' => 'required',
    		'postId' => 'required'
    	]);

    	$post = Post::findOrFail($request->postId);

    	$post->body = $request->body;
    	$post->save();

    	return response()->json(['newPost' => $request->body], 200);
    }

    public function likePost(Request $request)
    {
    	$post_id = $request->post_id;
    	$is_like = $request->is_like == 'true';
    	$update = false;
    	$post = Post::find($post_id);

	    if(!$post)
	    {
	    	return null;
	    } 

	    $user = Auth::user(); 
	    $userLike = $user->likes()->where('post_id',$post_id)->first();

	    if($userLike)
	    {	
	    	$currentLike = $userLike->like_type; 
	    	$update = true; 

	    	if($currentLike == $is_like)
	    	{
	    		$userLike->delete();
	    		return null;
	    	}

	    }else{
	    	$userLike = new Like(); 
	    }

    	$userLike->user_id = $user->id;
    	$userLike->post_id = $post_id; 
    	$userLike->like_type = $is_like; 
    	$userLike->save();

    	return response()->json(['like_type' => $is_like], 200);
    }
}
