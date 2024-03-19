<?php

namespace App\Controllers; // Définit l'espace de noms (namespace) pour la classe BlogController

use App\Models\Post;


class BlogController extends Controller // Définit la classe BlogController en tant que sous-classe de Controller
{
    public function welcome() // Définit une méthode publique appelée index
    {
        return $this->view('blog.welcome'); // Appelle la méthode view de la classe parente pour afficher la vue 'blog.index'
    }

    public function index() // Définit une méthode publique appelée index
    {
        $post = new Post($this->getDB());
        $posts = $post->all();
        

        return $this->view('blog.index', compact('posts')); // Appelle la méthode view de la classe parente pour afficher la vue 'blog.index'
    }

    public function show(int $id) // Définit une méthode publique appelée show, prenant un paramètre $id
    {
        $posts = new Post($this->getDB());
        $post = $posts->findById($id);

        return $this->view('blog.show', compact('post')); // Appelle la méthode view de la classe parente pour afficher la vue 'blog.show' en passant l'id comme paramètre
    }  
}
