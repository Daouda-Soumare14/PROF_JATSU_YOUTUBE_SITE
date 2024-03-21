<?php

namespace App\Models;


class Tag extends Model
{
    protected $table = 'tags';
    public $id; 
    public $name; 
    public $created_at; 
    public $title; 
    public $content; 

    public function getPosts()
    {
         return $this->query("
                SELECT p.* FROM posts p
                INNER JOIN post_tag pt ON pt.post_id = p.id
                WHERE pt.post_id = ?
                ", $this->id);
    }
}