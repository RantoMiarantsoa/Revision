-- Création de la base (à exécuter séparément si besoin)
CREATE DATABASE takalo;
\c takalo

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

CREATE TABLE image(
  id_img SERIAL PRIMARY KEY,
  url VARCHAR(255),
  id_obj INT,
  FOREIGN KEY (id_obj) REFERENCES Objet(id_obj)
);

CREATE TABLE Echange(
  id_ech SERIAL PRIMARY KEY,
  id_obj1 INT,
  id_obj2 INT,
  date_ech DATE,
  FOREIGN KEY (id_obj1) REFERENCES Objet(id_obj),
  FOREIGN KEY (id_obj2) REFERENCES Objet(id_obj)
);

