<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;

class ForumController extends Controller
{
    public function getIndex() {
        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('forum.index')->withPosts($posts);
    }

    public function getSingle() {
        //$post = Post::where('category_id', '=', $category_id)->first();

        return view('posts.show')->withPost($post);
}
}
