<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Comment;
use Session;
use App\User;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_id)
    {
        $this->validate($request, array(
            'comment' => 'required|min:5|max:2000'
        ));

        $post = Post::find($post_id);

        $id = Auth::id();
        $query = User::where('id', '=', $id)->first();
        $total_logins = $query->total_logins;

        if ($total_logins >= 2) {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->approved = true;
            $comment->post()->associate($post);
            $request->user()->comments()->save($comment);

            Session::flash('success', 'Comment was added.');

            return redirect()->route('forum.show', [$post->id]);
        } else {
            return view('errors/logins');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.edit')->withComment($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

//        if (Auth::user() != $comment->user) {
//            return redirect()->back();
//        }

        $this->validate($request, array('comment' => 'required'));

        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success', 'Comment updated.');

        return redirect()->route('posts.show', $comment->post->id);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        return view('comments.delete')->withComment($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_id = $comment->post->id;
        $post = Post::find($id);

//        if (Auth::user() != $comment->user) {
//            return redirect()->back();
//        }

        $comment->delete();

        Session::flash('success', 'Deleted comment.');

        return redirect()->route('posts.show', $post_id);
    }
}
