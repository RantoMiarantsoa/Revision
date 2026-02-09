<?php

namespace app\model;

class Categorie {
    private $id_cat;
    private $description;

    public function __construct($id_cat, $description) {
        $this->id_cat = $id_cat;
        $this->description = $description;
    }
}