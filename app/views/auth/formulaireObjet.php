<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/objet/ajouter" method="post" enctype="multipart/form-data">
        <label for="nom">Nom de l'objet :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="description">Description de l'objet :</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="prix">Prix de l'objet :</label>
        <input type="number" id="prix" name="prix" step="0.01" required><br><br>

        <label for="categorie">Catégorie de l'objet :</label>
        <select id="categorie" name="categorie" required>
            <?php foreach ($categories as $categorie) : ?>
                <option value="<?= $categorie['id_cat'] ?>"><?= $categorie['description'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="photos">Photos (plusieurs possibles) :</label>
        <input type="file" id="photos" name="photos[]" accept="image/*" multiple required><br><br>

        <input type="hidden" name="id_user" value="1">

        <input type="submit" value="Ajouter l'objet">
    </form>
</body>
</html>