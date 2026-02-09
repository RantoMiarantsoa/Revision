<?php
class UserRepository {
  private $pdo;
  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function emailExists($email) {
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE email=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function nameExist($nom){
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE nom=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function findBYName($nom){
        $st = $this->pdo->prepare("SELECT * FROM users WHERE nom = ? LIMIT 1");
    $st->execute([(string)$nom]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }
  public function findByEmail($email) {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $st->execute([(string)$email]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function findById($id) {
    $st = $this->pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $st->execute([(int)$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function findAll() {
    $st = $this->pdo->query("SELECT id, nom, email FROM users ORDER BY id");
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }


}
