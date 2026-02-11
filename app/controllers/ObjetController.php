<?php
require_once __DIR__ . '/../repositories/ObjetRepository.php';
require_once __DIR__ . '/../repositories/ImageRepository.php';

class ObjetController {
    public static function postAjouter() {
        $pdo = Flight::db();
        $req = Flight::request();

        $nom         = trim($req->data->nom);
        $description = trim($req->data->description);
        $prix        = (float) $req->data->prix;
        $id_cat      = (int) $req->data->categorie;
        $id_user     = (int) $req->data->id_user;

        // 1. Insérer l'objet via le repository
        $objetRepo = new ObjetRepository($pdo);
        $id_obj = $objetRepo->create($nom, $description, $prix, $id_cat, $id_user);

        // 2. Upload des photos
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageRepo = new ImageRepository($pdo);
        $photos = $req->files->photos ?? [];

        // Normaliser la structure $_FILES pour le multi-upload
        if (isset($photos['name']) && is_array($photos['name'])) {
            $count = count($photos['name']);
            for ($i = 0; $i < $count; $i++) {
                if ($photos['error'][$i] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpName  = $photos['tmp_name'][$i];
                $origName = basename($photos['name'][$i]);
                $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

                // Vérifier l'extension
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                if (!in_array($ext, $allowed)) {
                    continue;
                }

                // Nom unique pour éviter les doublons
                $newName = uniqid('img_') . '.' . $ext;
                $dest    = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $dest)) {
                    $imageRepo->create('/uploads/' . $newName, $id_obj);
                }
            }
        }

        Flight::redirect('/objet/form');
    }
}
