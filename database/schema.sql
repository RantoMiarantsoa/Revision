-- Création de la base (à exécuter séparément si besoin)
-- CREATE DATABASE takalo;
-- \c takalo

CREATE TABLE IF NOT EXISTS admin (
    id SERIAL PRIMARY KEY,
    mdp VARCHAR(50) NOT NULL
);

CREATE TABLE Categorie(
  id_cat SERIAL PRIMARY KEY,
  description VARCHAR(50)
);
