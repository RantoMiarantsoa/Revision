<?php
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

// Authentication / home
Flight::route('GET /', ['AdminController', 'showLogin']);
Flight::route('POST /login', ['AdminController', 'postLogin']);
Flight::route('GET /home', ['AdminController', 'showHome']);
Flight::route('GET /logout', ['AdminController', 'logout']);
Flight::route('GET /', function() {
    echo "Bienvenue sur mon application Flight MVC !";
});
