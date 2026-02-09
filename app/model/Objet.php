<?php

namespace app\model;

class Objet {
    private $id_obj;
    private $nom;
    private $description;
    private $prix;
    private $id_cat;
    private $id_user;

    public function __construct($id_obj, $nom, $description, $prix, $id_cat, $id_user) {
        $this->id_obj = $id_obj;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->id_cat = $id_cat;
        $this->id_user = $id_user;
    }

    public function getObjetByUserConnected($id_user) {
        $Objet = new ObjetRepository(Flight::get('pdo'));
        $liste = $Objet->getByUser($id_user);

        return $liste;
    }
}
