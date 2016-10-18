<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Session;
use App\Category;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\Response
     */
public function index()
{
    $search = \Request::get('search');

    $posts = Post::where('title','like','%'.$search.'%')
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('posts.index',compact('posts'));
}


    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view ('posts.create')->withCategories($categories)->withTags($tags);
    }

    /**
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required|max:225',
            'category_id' => 'required|integer',
            'body' => 'required'
        ));

    $post = new Post;

    $post->title = $request->title;
    $post->category_id = $request->category_id;
    $post->body = $request->body;

    $request->user()->posts()->save($post);

    $post->tags()->sync($request->tags, false);

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

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();
        $cats = [];
        foreach ($categories as $category) {
            $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }

        return view('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'title' => 'required|max:225',
            'category_id' => 'required|integer',
            'body' => 'required'
        ));

        $post = Post::find($id);

        if (Auth::user() != $post->user) {
            return redirect()->back();
        }

        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->body = $request->input('body');

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync(array());
        }

        Session::flash('success', 'This post was successfully saved.');

        return redirect()->route('posts.show', $post->id);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();

        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();

        Session::flash('success', 'This post was succesfully deleted.');
        return redirect()->route('posts.index');
    }
}

