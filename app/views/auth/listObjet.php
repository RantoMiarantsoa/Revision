<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>List des objets de l'utilisateur connecter</h1>

    <?php foreach ($objets as $objet) : ?>
        <div>
            <h2><?= $objet['nom'] ?></h2>
            <p><?= $objet['description'] ?></p>
            <p>Prix : <?= $objet['prix'] ?> €</p>
            <p>Catégorie : <?= $objet['categorie'] ?></p>
            <div>
                <?php if (!empty($objet['images'])) : ?>
                    <?php foreach ($objet['images'] as $image) : ?>
                        <img src="<?= $image['url'] ?>" alt="Photo de l'objet" style="max-width: 200px;">
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucune photo disponible</p>
                <?php endif; ?>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>
</body>
</html>