<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;

class ForumController extends Controller
{
    public function getIndex() {
        $posts = Post::paginate(10);

        return view('forum.index')->withPosts($posts);
    }

    public function getSingle() {
        return view('forum.single')->withPost($post);
}
}
