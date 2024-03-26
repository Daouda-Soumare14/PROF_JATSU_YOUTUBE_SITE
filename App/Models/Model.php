<?php

namespace App\Models;

use PDO;
use Database\DBConnection;

abstract class Model
{
    public $db; // Propriété publique pour la connexion à la base de données.
    protected $table; // Propriété protégée pour le nom de la table.
    public $id;
    public $title;
    public $content;
    public $created_at;
    public $name;

    public function __construct(DBConnection $db)
    {
        $this->db = $db; // Initialisation de la connexion à la base de données dans le constructeur.
    }


    public function all(): array
    {
        // Méthode pour récupérer tous les enregistrements de la table.
        return $this->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function findById(int $id): Model
    {
        // Méthode pour rechercher un enregistrement par son identifiant.
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }


    // Méthode pour mettre à jour un enregistrement dans la table.
    public function update(int $id, array $data, ?array $relations=null)
    {
        $sqlRequestPart = ""; // Variable pour stocker les parties de la requête SQL pour la mise à jour
        $i = 1; // Variable de comptage pour déterminer la dernière colonne mise à jour

        // Parcours des données à mettre à jour
        foreach ($data as $key => $value) {
            $comma = $i === count($data) ? " " : ", "; // Séparateur pour les parties de la requête SQL
            $sqlRequestPart .= "{$key} = :{$key}{$comma}"; // Construction de la partie de la requête SQL
            $i++; // Incrémentation du compteur
        }

        $data['id'] = $id; // Ajout de l'identifiant de l'enregistrement à mettre à jour dans les données

        // Exécution de la requête SQL pour mettre à jour l'enregistrement
        return $this->query("UPDATE {$this->table} SET {$sqlRequestPart} WHERE id = :id", $data);
    }


    public function destroy(int $id): bool
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }



    public function query(string $sql, array $param = null, bool $single = null)
    {
        // Méthode pour exécuter une requête SQL.
        $method   = is_null($param)  ? 'query' : 'prepare'; // Choix de la méthode PDO en fonction des paramètres.

        if (strpos($sql, 'DELETE') === 0 
            || strpos($sql, 'UPDATE') === 0 
            || strpos($sql, 'INSERT') === 0) 
        {
            $stmt = $this->db->getPdo()->$method($sql); // Préparation de la requête.
            $stmt->setFetchMode(PDO::FETCH_CLASS, static::class, [$this->db]); // Configuration du mode de récupération des données. 
            return $stmt->execute($param);
        }

        $fetch = is_null($single) ? 'fetchAll' : 'fetch'; // Choix de la méthode de récupération des résultats.

        $stmt = $this->db->getPdo()->$method($sql); // Préparation de la requête.
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class, [$this->db]); // Configuration du mode de récupération des données.

        if ($method === 'query') // Si la méthode est query, exécute la requête directement.
        {
            return $stmt->$fetch(); // Récupère tous les résultats.
        } else // Sinon, exécute la requête préparée avec le paramètre.
        {
            $stmt->execute($param);
            return $stmt->$fetch(); // Récupère un seul résultat.
        }
    }
}
