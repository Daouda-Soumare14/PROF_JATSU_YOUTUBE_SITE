<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    public function index()
    {
        $posts = (new Post($this->getDB()))->all();

        return $this->view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = (new Tag($this->getDB()))->all();

        $this->view('admin.posts.form', compact('tags'));
    }

    public function createPost()
    {
        $post = new Post($this->getDB());

        $tags = array_pop($_POST);

        $result = $post->create($_POST, $tags);

        if ($result) {
            return header("Location: /Prof_Jatsu_Youtube_Site/public/admin/posts");
            exit;
        }
    }

    public function edit(int $id)
    {
        $post = (new Post($this->getDB()))->findById($id);
        $tags = (new Tag($this->getDB()))->all();

        return $this->view('admin.posts.form', compact('post', 'tags'));
    }

    public function update(int $id)
    {
        $post = new Post($this->getDB());

        $tags = array_pop($_POST);

        $result = $post->update($id, $_POST, $tags);

        if ($result) {
            return header("Location: /Prof_Jatsu_Youtube_Site/public/admin/posts");
            exit;
        }
    }

    public function destroy(int $id)
    {
        $post = (new Post($this->getDB()))->destroy($id);

        header("Location:" . $_SERVER['HTTP_REFERER']);
    }
}
