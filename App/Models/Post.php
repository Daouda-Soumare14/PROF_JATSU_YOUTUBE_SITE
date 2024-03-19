<?php

namespace App\Models;

use DateTime;

class Post extends Model
{
    // Déclaration des propriétés
    protected $table = 'posts'; // Table associée au modèle
    public $id; // Identifiant du post
    public $title; // Titre du post
    public $content; // Contenu du post
    public $created_at; // Date de création du post
    public $name; // Nom associé au post

    // Méthode pour formater la date de création
    public function getCreatedAt() : string
    {
        return (new DateTime($this->created_at))->format('d/m/Y à H:m');
    }

    // Méthode pour obtenir un extrait du contenu
    public function getExcerpt() : string
    {
        return substr($this->content, 0, 400) . '...';
    }

    // Méthode pour obtenir un bouton de lien vers le post
    public function getButton() : string
    {
        return <<<HTML
            <a href="/Prof_Jatsu_Youtube_Site/public/posts/$this->id" class="btn btn-primary">Lire l'article</a>
HTML;
    }

    // Méthode pour obtenir les tags associés au post
    public function getTags()
    {
        return $this->query("
                SELECT t.* FROM tags t
                INNER JOIN post_tag pt ON pt.tag_id = t.id
                INNER JOIN posts p ON pt.post_id = p.id
                WHERE p.id = ?
                ", $this->id);
    }
}
