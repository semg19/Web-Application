<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Session;

class PostController extends Controller
{

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('posts.create');
    }

    /**
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required|max:225',
            'body' => 'required'
        ));

    $post = new Post;

    $post->title = $request-> title;
    $post->body = $request-> body;

    $post->save();

    Session::flash('success', 'The forum post is succesfully placed!');

    return redirect()->route('posts.show', $post->id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view ('posts.show')->withPost($post);
    }
}

