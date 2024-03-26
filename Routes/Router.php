<?php

namespace Routes; // Définit l'espace de noms (namespace) pour la classe Router

use App\Exceptions\RouteNotFoundException;

class Router // Définit la classe Router
{
    public $url; // Déclare une propriété publique pour stocker l'URL demandée
    public $routes = []; // Déclare une propriété publique pour stocker les routes

    public function __construct($url) // Définit le constructeur de la classe Router
    {
        $this->url = trim($url, '/'); // Initialise la propriété $url en supprimant les barres obliques des extrémités
    }

    public function get(string $path, string $action) // Définit une méthode pour définir une nouvelle route GET
    {
        $this->routes['GET'][] = new Route($path, $action); // Ajoute une nouvelle route GET à la liste des routes
    }

    public function post(string $path, string $action) // Définit une méthode pour définir une nouvelle route GET
    {
        $this->routes['POST'][] = new Route($path, $action); // Ajoute une nouvelle route GET à la liste des routes
    }

    public function run() // Définit une méthode pour exécuter le routage
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) // Parcourt les routes correspondant à la méthode de la requête
        {
            if ($route->matches($this->url)) // Si l'URL demandée correspond à une route
            {
                return $route->execute(); // Exécute l'action associée à la route
            }
        }
        throw new RouteNotFoundException("La page demandé est introuvable");
    }
} 
