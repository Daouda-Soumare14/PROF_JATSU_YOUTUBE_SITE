<?php

namespace App\Controllers; // Définit l'espace de noms (namespace) pour la classe Controller

use Database\DBConnection;

abstract class Controller // Définit la classe Controller
{
    protected $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }
    
    protected function view(string $path, array $params = null) // Définit une méthode publique appelée view, prenant un chemin et un tableau de paramètres en option
    {
        ob_start(); // Démarre la temporisation de la sortie

        $path = str_replace('.', DIRECTORY_SEPARATOR, $path); // Remplace les points dans le chemin par le séparateur de répertoire du système d'exploitation en cours

        require CHEMIN_VIEWS . $path . '.php'; // Inclut le fichier de vue correspondant au chemin spécifié

        $content = ob_get_clean(); // Obtient le contenu de la temporisation de la sortie et l'efface de la mémoire tampon

        require CHEMIN_VIEWS . 'layout.php'; // Inclut le fichier de mise en page (layout.php) pour envelopper le contenu de la vue
    }

    protected function getDB()
    {
        return $this->db;
    }
}
