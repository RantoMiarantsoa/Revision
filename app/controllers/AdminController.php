<?php
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
    $pdo = Flight::db();
    $repo = new UserRepository($pdo);
    $req = Flight::request();
    $nom = trim((string)$req->data->nom);
  

    // Successful login
    $_SESSION['user_id'] = (int)$user['id'];
    Flight::json([
      'success' => true,
      'redirect' => '/home'
    ]);
  }

  public static function showHome() {
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
      Flight::redirect('/');
      return;
    }
    $pdo = Flight::db();
    $repo = new UserRepository($pdo);
    $user = $repo->findById($userId);
    Flight::render('home', ['user'=>$user]);
  }

  public static function logout() {
    unset($_SESSION['user_id']);
    Flight::redirect('/');
  }

 
 
}
