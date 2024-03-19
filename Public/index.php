<?php

use Routes\Router; // Importe la classe Router du namespace Routes

require '../vendor/autoload.php'; // Inclut le fichier autoload.php pour charger automatiquement les classes

// Définit une constante CHEMIN_VIEWS contenant le chemin absolu vers le répertoire des vues
define('CHEMIN_VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR);

// Définit une constante CHEMIN_SCRIPT contenant le chemin absolu vers le script en cours d'exécution
define('CHEMIN_SCRIPT', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
define('DB_NAME', 'prof_jatsu_youtube_site');
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

// Instancie un nouvel objet Router en passant l'URL demandée ($_GET['url'])
$router = new Router($_GET['url']);

// Définit les différentes routes de l'application avec le routeur
$router->get('/', 'App\Controllers\BlogController@welcome'); // Route pour afficher la page d'accueil
$router->get('/posts/', 'App\Controllers\BlogController@index'); // Route pour afficher la page d'accueil
$router->get('/posts/:id', 'App\Controllers\BlogController@show'); // Route pour afficher un article de blog spécifique

// Exécute le routeur pour traiter la demande HTTP actuelle
$router->run();
