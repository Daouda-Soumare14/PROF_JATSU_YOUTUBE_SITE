<?php

namespace App\Models;

use DateTime;

class Post extends Model
{
    // Déclaration des propriétés
    protected $table = 'posts'; // Table associée au modèle

    // Méthode pour formater la date de création
    public function getCreatedAt() : string
    {
        return (new DateTime($this->created_at))->format('d/m/Y à H:i');
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
        return $this->query(
                "SELECT t.* FROM tags t
                INNER JOIN post_tag pt ON pt.tag_id = t.id
                WHERE pt.post_id = ?", [$this->id]);
    }

    public function create(array $data, ?array $relations = null)
    {
        parent::create($data);

        $id = $this->db->getPdo()->lastInsertId();
         foreach($relations as $tagId)
         {
             // Prépare une requête SQL pour insérer une nouvelle relation post_tag.
             $stmt = $this->db->getPdo()->prepare("INSERT post_tag(post_id, tag_id) VALUES(?,?)");
             // Exécute l'opération d'insertion avec l'identifiant de post et l'identifiant de tag donnés.
             $stmt->execute([$id, $tagId]);
         }

         return true;
    }

    public function update(int $id, array $data, ?array $relations=null)
    {
        // Appelle la méthode update de la classe parente avec les données fournies.
        parent::update($id, $data);
    
        // Prépare une requête SQL pour supprimer les relations post_tag existantes pour ce post.
        $stmt = $this->db->getPdo()->prepare("DELETE FROM post_tag WHERE post_id = ?");
        // Exécute l'opération de suppression avec l'identifiant de post donné.
        $result = $stmt->execute([$id]);
    
        // Itère à travers chaque identifiant de tag fourni dans le tableau des relations.
        foreach($relations as $tagId)
        {
            // Prépare une requête SQL pour insérer une nouvelle relation post_tag.
            $stmt = $this->db->getPdo()->prepare("INSERT post_tag(post_id, tag_id) VALUES(?,?)");
            // Exécute l'opération d'insertion avec l'identifiant de post et l'identifiant de tag donnés.
            $stmt->execute([$id, $tagId]);
        }
    
        // Vérifie si l'opération de suppression a réussi.
        if ($result) 
        {
            // Si réussi, retourne true.
            return true;
        }
        // Si l'opération a échoué, aucune valeur de retour explicite n'est spécifiée.
    }    
}
