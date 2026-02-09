<?php
class UserService {
  private $repo;
  public function __construct(UserRepository $repo) { $this->repo = $repo; }

  public function register(array $values) {
    return $this->repo->create($values);
  }
}
