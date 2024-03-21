<?php

namespace App\Models;

use PDO;
use Database\DBConnection;

abstract class Model
{
    public $db; // Propriété publique pour la connexion à la base de données.
    protected $table; // Propriété protégée pour le nom de la table.

    public function __construct(DBConnection $db)
    {
        $this->db = $db; // Initialisation de la connexion à la base de données dans le constructeur.
    }

    public function all() : array
    {
        // Méthode pour récupérer tous les enregistrements de la table.
        return $this->query("SELECT * FROM {$this->table} ORDER BY created_at DESC");
    }

    public function findById(int $id) : Model
    {
        // Méthode pour rechercher un enregistrement par son identifiant.
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", $id, true);
    }

    public function query(string $sql, int $param = null, bool $single = null)
    {
        // Méthode pour exécuter une requête SQL.
        $method   = is_null($param)  ? 'query'    : 'prepare'; // Choix de la méthode PDO en fonction des paramètres.
        $recovery = is_null($single) ? 'fetchAll' : 'fetch'; // Choix de la méthode de récupération des résultats.

        $stmt = $this->db->getPdo()->$method($sql); // Préparation de la requête.
        $stmt->setFetchMode(PDO::FETCH_CLASS, static::class, [$this->db]); // Configuration du mode de récupération des données.

        if($method === 'query') // Si la méthode est query, exécute la requête directement.
        {
            return $stmt->$recovery(); // Récupère tous les résultats.
        }
        else // Sinon, exécute la requête préparée avec le paramètre.
        {
            $stmt->execute([$param]);
            return $stmt->$recovery(); // Récupère un seul résultat.
        }
    }   
}
