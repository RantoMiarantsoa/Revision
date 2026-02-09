<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Accueil</title>
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/site.css">
</head>
<body class="p-4">
  <div class="container" style="max-width:720px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <?php
        $prenom = isset($user['prenom']) ? trim((string)$user['prenom']) : '';
        $nom = isset($user['nom']) ? trim((string)$user['nom']) : '';
        $displayName = trim($prenom . ' ' . $nom);
        if ($displayName === '') {
          $displayName = $user['email'] ?? 'Utilisateur';
        }
      ?>
      <h3>Bonjour <?=htmlspecialchars($displayName)?></h3>
      <a class="btn btn-outline-secondary" href="/logout">Déconnexion</a>
    </div>

    <div class="card p-3">
      <h5>Tableau de bord</h5>
      <p>Accès rapide :</p>
      <ul>
        <li><a href="/messages">Messages</a></li>
      </ul>
    </div>
  </div>
</body>
</html>
