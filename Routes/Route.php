<?php

namespace Routes; // Définit l'espace de noms (namespace) pour la classe Route

use Database\DBConnection;

class Route // Définit la classe Route
{
    public $path; // Déclare une propriété publique pour stocker le chemin de la route
    public $action; // Déclare une propriété publique pour stocker l'action associée à la route
    public $matches; // Déclare une propriété publique pour stocker les correspondances des paramètres dans le chemin de la route

    public function __construct($path, $action) // Définit le constructeur de la classe Route
    {
        $this->path = trim($path, '/'); // Initialise la propriété $path en supprimant les barres obliques des extrémités
        $this->action = $action; 
    }

    public function matches(string $url) // Définit une méthode pour vérifier si l'URL correspond au chemin de la route
    {
        // Remplace les paramètres dynamiques du chemin par des motifs de correspondance régulière
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#"; // Crée un motif de correspondance complet

        // Vérifie si l'URL correspond au motif de chemin
        if(preg_match($pathToMatch, $url, $matches)) // Si une correspondance est trouvée
        {
            $this->matches = $matches; // Stocke les correspondances dans $matches
            return true; // Retourne vrai
        }
        else // Si aucune correspondance n'est trouvée
        {
            return false; // Retourne faux
        }
    }

    public function execute() // Définit une méthode pour exécuter l'action associée à la route
    {
        // Divise l'action en nom de contrôleur et nom de méthode
        $params = explode('@', $this->action);
         // Instancie la class BlogController
        $controller = new $params[0](new DBConnection(DB_NAME, DB_HOST, DB_USERNAME, DB_PASSWORD));
        $method = $params[1]; // Stocke le nom de la méthode

        // Vérifie s'il y a des paramètres capturés dans le chemin de la route
        if(isset($this->matches[1])) // Si des paramètres ont été capturés
        {
            return $controller->$method($this->matches[1]); // Appelle la méthode de la class BlogController avec les paramètres capturés
        }
        else // Si aucun paramètre n'a été capturé
        {
            return $controller->$method(); // Appelle la méthode de la class BlogController sans paramètres
        }
    }
}
