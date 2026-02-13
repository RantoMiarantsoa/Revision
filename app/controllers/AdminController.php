<?php
require_once __DIR__ . '/../repositories/AdminRepository.php';

class AdminController {

  public static function showRegister() {
    Flight::render('admin/login', [
      'values' => ['nom'=>'','prenom'=>'','email'=>'','telephone'=>''],
      'errors' => ['nom'=>'','prenom'=>'','email'=>'','telephone'=>''],
      'success' => false
    ]);
  }

  // Show login form
  public static function showLogin($errors = []) {
    Flight::render('admin/login', [
      'errors' => $errors,
      'values' => ['nom'=>'', 'email'=>'']
    ]);
  }

  // Process login
  public static function postLogin() {
    $request = Flight::request();
    $nom = trim((string)$request->data->nom);
    $password = trim((string)$request->data->password);

    // Get PDO connection
    $pdo = Flight::db();
    
    // Look up admin by nom using AdminRepository
    $repo = new AdminRepository($pdo);
    $user = $repo->getAdmin($nom);

    // Verify password
    if ($user && $user['mdp'] === $password) {
      $_SESSION['user_id'] = (int)$user['id'];
      Flight::redirect('/home');
    } else {
      // Login failed - show error
      self::showLogin(['nom' => 'Nom ou mot de passe incorrect']);
    }
  }
  
  public static function showHome() {
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
      Flight::redirect('/');
      return;
    }
    $pdo = Flight::db();
    $repo = new AdminRepository($pdo);
    $user = $repo->getAdminById($userId);
    Flight::render('home', ['user'=>$user]);
  }

  public static function logout() {
    unset($_SESSION['user_id']);
    Flight::redirect('/');
  }

 
 
}
