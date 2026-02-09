<?php
class ImageRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create($url, $id_obj) {
        $stmt = $this->pdo->prepare("INSERT INTO image (url, id_obj) VALUES (?, ?)");
        return $stmt->execute([$url, $id_obj]);
    }

    public function getByObjet($id_obj) {
        $stmt = $this->pdo->prepare("SELECT * FROM image WHERE id_obj = ?");
        $stmt->execute([$id_obj]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function delete($id_img) {
        $stmt = $this->pdo->prepare("DELETE FROM image WHERE id_img = ?");
        return $stmt->execute([$id_img]);
    }
}
