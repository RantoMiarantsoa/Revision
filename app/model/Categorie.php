<?php

namespace app\model;

use Flight;
class Categorie {
    public $id;
    public $nom;

    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }
}