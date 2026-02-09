-- Création de la base (à exécuter séparément si besoin)
-- CREATE DATABASE takalo;
-- \c takalo

CREATE TABLE IF NOT EXISTS admin (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    mdp VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS users(
  id_user SERIAL PRIMARY KEY,
  nom VARCHAR(50),
  email VARCHAR(50),
  pwd VARCHAR(20)
);

CREATE TABLE Categorie(
  id_cat SERIAL PRIMARY KEY,
  description VARCHAR(50)
);

CREATE TABLE Objet(
  id_obj SERIAL PRIMARY KEY,
  nom VARCHAR(50),
  description TEXT,
  id_cat INT,
  id_user INT,
  FOREIGN KEY (id_cat) REFERENCES Categorie(id_cat),
  FOREIGN KEY (id_user) REFERENCES users(id_user)
);

