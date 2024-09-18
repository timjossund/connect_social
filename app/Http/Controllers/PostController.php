<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function createPost() {
        return view('create-post');
    }

    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post created!');
    }

    public function showPost(POST $post) {
        $post['body'] = Str::markdown($post->body);
        return view('single-post', ['post' => $post]);
    }

    public function delete(POST $post) {
        // if (auth()->user()->cannot('delete', $post)) {
        //     return redirect('profile/' . auth()->user()->username)->with('error', 'You do not have permission to delete this');
        // }
        $post->delete();

        return redirect('profile/' . auth()->user()->username)->with('success', 'Post successfully deleted');
    }

    public function updatePost(Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully updated');
    }

    public function showEditForm(Post $post) {
        return view('edit-post', ['post' => $post]);
    }
}
