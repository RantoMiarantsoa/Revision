<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

// Authentication / home
Flight::route('GET /', ['AuthController', 'showLogin']);
Flight::route('POST /login', ['AuthController', 'postLogin']);
Flight::route('GET /home', ['AuthController', 'showHome']);
Flight::route('GET /logout', ['AuthController', 'logout']);
Flight::route('GET /', function() {
    echo "Bienvenue sur mon application Flight MVC !";
});
